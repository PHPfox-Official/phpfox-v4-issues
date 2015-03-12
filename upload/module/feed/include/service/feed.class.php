<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: feed.class.php 7315 2014-05-09 15:54:10Z Fern $
 */
class Feed_Service_Feed extends Phpfox_Service 
{	
	private $_aViewMoreFeeds = array();
	private $_aCallback = array();
	private $_sLastDayInfo = '';
	private $_aFeedTimeline = array('left' => array(), 'right' => array());	
	
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('feed');

		(($sPlugin = Phpfox_Plugin::get('feed.service_feed___construct')) ? eval($sPlugin) : false);
	}
	
	public function getOldPost($iPageId)
	{
		$aOldFeed = $this->database()->select('*')
			->from(Phpfox::getT('pages_feed'))
			->where('parent_user_id	= ' . (int) $iPageId)
			->order('time_stamp ASC')
			->execute('getSlaveRow');
		
		return (isset($aOldFeed['time_stamp']) ? $aOldFeed['time_stamp'] : PHPFOX_TIME);	
	}
	
	public function getTimeLineYears($iUserId, $iLastTimeStamp)
	{					
		static $aCachedYears = array();
		
		if (isset($aCachedYears[$iUserId]))
		{
			return $aCachedYears[$iUserId];	
		}
		
		$aNewYears = array();
		$sCacheId = $this->cache()->set(array('timeline', $iUserId));
		if (!($aNewYears = $this->cache()->get($sCacheId)))
		{
			$aYears = range(date('Y', PHPFOX_TIME), date('Y', $iLastTimeStamp));		
			foreach ($aYears as $iYear)
			{
				$iStartYear = mktime(0, 0, 0, 1, 1, $iYear);
				$iEndYear = mktime(0, 0, 0, 12, 31, $iYear);			

				$iCnt = $this->database()->select('COUNT(*)')
					->from(Phpfox::getT('feed'))
                    ->forceIndex('time_stamp')
					->where('user_id = ' . (int) $iUserId .' AND feed_reference = 0 AND time_stamp > \'' . $iStartYear . '\' AND time_stamp <= \'' . $iEndYear . '\'')
					->execute('getSlaveField');

				if ($iCnt)
				{
					$aNewYears[] = $iYear;
				}
			}
			
			$this->cache()->save($sCacheId, $aNewYears);
		}

		if (!is_array($aNewYears))
		{
			$aNewYears = array();
		}
		
		$iBirthYear = date('Y', $iLastTimeStamp);
		
		$sDobCacheId = $this->cache()->set(array('udob', $iUserId));
		if (!($iDOB = $this->cache()->get($sDobCacheId)))
		{
			$iDOB = $this->database()->select('dob_setting')->from(Phpfox::getT('user_field'))->where('user_id = ' . (int)$iUserId)->execute('getSlaveField');
			$this->cache()->save($sDobCacheId, $iDOB);
		}
				
		if ($iDOB == 0)
		{
			$sPermission = Phpfox::getParam('user.default_privacy_brithdate');
			$bShowBirthYear = ($sPermission == 'full_birthday' || $sPermission == 'show_age');			
		}
		
		if (!in_array($iBirthYear, $aNewYears) && ($iDOB == 2 || $iDOB == 4 || ($iDOB == 0 && isset($bShowBirthYear) && $bShowBirthYear)))
		{
			$aNewYears[] = $iBirthYear;
		}
		
		$aYears = array();
		foreach ($aNewYears as $iYear)
		{
			$aMonths = array();
			foreach (range(1, 12) as $iMonth)
			{
				if ($iYear == date('Y', PHPFOX_TIME) && $iMonth > date('n', PHPFOX_TIME))
				{
					
				}
				elseif ($iYear == date('Y', $iLastTimeStamp) && $iMonth > date('n', $iLastTimeStamp))
				{
					
				}
				else
				{
					$aMonths[] = array(
						'id' => $iMonth,
						'phrase' => Phpfox::getTime('F', mktime(0, 0 , 0, $iMonth, 1, $iYear), false)
					);
				}
			}
			
			$aMonths = array_reverse($aMonths);

			$aYears[] = array(
				'year' => $iYear,
				'months' => $aMonths
			);
		}

		$aCachedYears[$iUserId] = $aYears;
		
		return $aYears;
	}
	
	public function getForItem($sModule, $iItemId)
	{
		$aRow = $this->database()->select('*')
			->from(Phpfox::getT('feed'))
			->where('type_id = \'' . $this->database()->escape($sModule) . '\' AND item_id = ' . (int) $iItemId)
			->execute('getSlaveRow');
	
		if (isset($aRow['feed_id']))
		{
			return $aRow;
		}
		
		return false;
	}
	
	public function callback($aCallback)
	{
		$this->_aCallback = $aCallback;
		
		return $this;
	}
	
	public function setTable($sTable)
	{
		$this->_sTable = $sTable;
	}

	public function get($iUserid = null, $iFeedId = null, $iPage = 0, $bForceReturn = false)
	{
		$oUrl = Phpfox::getLib('url');
		$oReq = Phpfox::getLib('request');
		$oParseOutput = Phpfox::getLib('parse.output');
		
		if ($oReq->get('get-new'))
		{
			// $bForceReturn = true;
		}

		if (($iCommentId = $oReq->getInt('comment-id')))
		{
			if (isset($this->_aCallback['feed_comment']))
			{
				$aCustomCondition = array('feed.type_id = \'' . $this->_aCallback['feed_comment'] . '\' AND feed.item_id = ' . (int) $iCommentId . ' AND feed.parent_user_id = ' . (int) $this->_aCallback['item_id']);
			}
			else
			{
				$aCustomCondition = array('feed.type_id IN(\'feed_comment\', \'feed_egift\') AND feed.item_id = ' . (int) $iCommentId . ' AND feed.parent_user_id = ' . (int) $iUserid);
			}

			$iFeedId = true;
		}
		elseif (($iStatusId = $oReq->getInt('status-id')))
		{
			$aCustomCondition = array('feed.type_id = \'user_status\' AND feed.item_id = ' . (int) $iStatusId . ' AND feed.user_id = ' . (int) $iUserid);
			$iFeedId = true;
		}
		elseif (($iLinkId = $oReq->getInt('link-id')))
		{
			$aCustomCondition = array('feed.type_id = \'link\' AND feed.item_id = ' . (int) $iLinkId . ' AND feed.user_id = ' . (int) $iUserid);
			$iFeedId = true;
		}
		elseif (($iLinkId = $oReq->getInt('plink-id')))
		{
			$aCustomCondition = array('feed.type_id = \'link\' AND feed.item_id = ' . (int) $iLinkId . ' AND feed.parent_user_id  = ' . (int) $iUserid);
			$iFeedId = true;
		}		
		elseif (($iPokeId = $oReq->getInt('poke-id')))
		{
			$aCustomCondition = array('feed.type_id = \'poke\' AND feed.item_id = ' . (int) $iPokeId . ' AND feed.user_id = ' . (int) $iUserid);
			$iFeedId = true;
		}			
		
		$iTotalFeeds = (int) Phpfox::getComponentSetting(($iUserid === null ? Phpfox::getUserId() : $iUserid), 'feed.feed_display_limit_' . ($iUserid !== null ? 'profile' : 'dashboard'), Phpfox::getParam('feed.feed_display_limit'));
		$iOffset = ($iPage * $iTotalFeeds);
		
		(($sPlugin = Phpfox_Plugin::get('feed.service_feed_get_start')) ? eval($sPlugin) : false);		
		
		$sOrder = 'feed.time_update DESC';
		if (Phpfox::getUserBy('feed_sort') || defined('PHPFOX_IS_USER_PROFILE'))
		{
			$sOrder = 'feed.time_stamp DESC';
		}

		$aCond = array();
		if (isset($this->_aCallback['module']))
		{
			$aNewCond = array();
			if (($iCommentId = $oReq->getInt('comment-id')))
			{
				if (!isset($this->_aCallback['feed_comment']))
				{
					$aCustomCondition = array('feed.type_id = \'' . $this->_aCallback['module'] . '_comment\' AND feed.item_id = ' . (int) $iCommentId . '');
				}				
			}			
			$aNewCond[] = 'AND feed.parent_user_id = ' . (int) $this->_aCallback['item_id'];
			if ($iUserid !== null && $iFeedId !== null)
			{
				$aNewCond[] = 'AND feed.feed_id = ' . (int) $iFeedId . ' AND feed.user_id = ' . (int) $iUserid;	
			}
			
			$iTimelineYear = 0;
			if (($iTimelineYear = Phpfox::getLib('request')->get('year')) && !empty($iTimelineYear))
			{
				$iMonth = 12;
				$iDay = 31;
				if (($iTimelineMonth = Phpfox::getLib('request')->get('month')) && !empty($iTimelineMonth))
				{
					$iMonth = $iTimelineMonth;
					$iDay = Phpfox::getLib('date')->lastDayOfMonth($iMonth, $iTimelineYear);
				}
				$aNewCond[] = 'AND feed.time_stamp <= \'' . mktime(0, 0, 0, $iMonth, $iDay, $iTimelineYear) . '\'';
			}			

			$aRows = $this->database()->select('feed.*, ' . Phpfox::getUserField() .', u.view_id')
				->from(Phpfox::getT($this->_aCallback['table_prefix'] . 'feed'), 'feed')			
				->join(Phpfox::getT('user'), 'u', 'u.user_id = feed.user_id')			
				->where((isset($aCustomCondition) ? $aCustomCondition : $aNewCond))
				->order($sOrder)
				->limit($iOffset, $iTotalFeeds)
				->execute('getSlaveRows');			
				
			// Fixes missing page_user_id, required to create the proper feed target
			if($this->_aCallback['module'] == 'pages')
			{
				foreach($aRows as $iKey => $aValue)
				{
					$aRows[$iKey]['page_user_id'] = $iUserid;
				}
			}					
		}
        elseif (($sIds = $oReq->get('ids')))
        {
			$aParts = explode(',', $oReq->get('ids'));
			$sNewIds = '';
			foreach ($aParts as $sPart)
			{
				$sNewIds .= (int) $sPart . ',';
			}
            $sNewIds = rtrim($sNewIds, ',');
            
            $aRows = $this->database()->select('feed.*, ' . Phpfox::getUserField().', u.view_id')
				->from($this->_sTable, 'feed')			
				->join(Phpfox::getT('user'), 'u', 'u.user_id = feed.user_id')	
                ->where('feed.feed_id IN(' . $sNewIds . ')')            
				->order('feed.time_stamp DESC')
				->execute('getSlaveRows');	            
        }
        elseif ($iUserid === null && $iFeedId !== null)
        {            
            $aRows = $this->database()->select('feed.*, ' . Phpfox::getUserField().', u.view_id')
				->from($this->_sTable, 'feed')			
				->join(Phpfox::getT('user'), 'u', 'u.user_id = feed.user_id')	
                ->where('feed.feed_id = ' . (int) $iFeedId)            
				->order('feed.time_stamp DESC')
				->execute('getSlaveRows');	            
        }		
		elseif ($iUserid !== null && $iFeedId !== null)
		{            			
            $aRows = $this->database()->select('feed.*, apps.app_title, ' . Phpfox::getUserField().', u.view_id')
				->from($this->_sTable, 'feed')			
				->join(Phpfox::getT('user'), 'u', 'u.user_id = feed.user_id')
				->leftJoin(Phpfox::getT('app'), 'apps', 'apps.app_id = feed.app_id')
				->where((isset($aCustomCondition) ? $aCustomCondition : 'feed.feed_id = ' . (int) $iFeedId . ' AND feed.user_id = ' . (int) $iUserid . ''))
				->order('feed.time_stamp DESC')
				->limit(1)			
				->execute('getSlaveRows');			
		}
		elseif ($iUserid !== null)
		{
			if ($iUserid == Phpfox::getUserId())
			{
				$aCond[] = 'AND feed.privacy IN(0,1,2,3,4)';
			}
			else 
			{
				if (Phpfox::getService('user')->getUserObject($iUserid)->is_friend)
				{
					$aCond[] = 'AND feed.privacy IN(0,1,2)';
				}	
				else if (Phpfox::getService('user')->getUserObject($iUserid)->is_friend_of_friend)
				{
					$aCond[] = 'AND feed.privacy IN(0,2)';
				}
				else 
				{
					$aCond[] = 'AND feed.privacy IN(0)';
				}
			}
			
			// There is no reciprocal feed when you add someone as friend
			$this->database()->select('feed.*')
			->from($this->_sTable, 'feed')
			->where('feed.type_id = \'friend\' AND feed.user_id = ' . (int) $iUserid)
			->union();
			
			(($sPlugin = Phpfox_Plugin::get('feed.service_feed_get_userprofile')) ? eval($sPlugin) : '');
			
			$iTimelineYear = 0;
			if (($iTimelineYear = Phpfox::getLib('request')->get('year')) && !empty($iTimelineYear))
			{
				$iMonth = 12;
				$iDay = 31;
				if (($iTimelineMonth = Phpfox::getLib('request')->get('month')) && !empty($iTimelineMonth))
				{
					$iMonth = $iTimelineMonth;
					$iDay = Phpfox::getLib('date')->lastDayOfMonth($iMonth, $iTimelineYear);										
				}		
				$aCond[] = 'AND feed.time_stamp <= \'' . mktime(0, 0, 0, $iMonth, $iDay, $iTimelineYear) . '\'';				
			}

			$this->database()->select('feed.*')
				->from($this->_sTable, 'feed')
				->where(array_merge($aCond, array('AND type_id = \'feed_comment\' AND feed.user_id = ' . (int) $iUserid . '')))
				->union();
			
			$this->database()->select('feed.*')
			->from($this->_sTable, 'feed')
			->where(array_merge($aCond, array('AND feed.user_id = ' . (int) $iUserid . ' AND feed.feed_reference = 0 AND feed.parent_user_id = 0')))
			->union();			
			
			if (Phpfox::isUser())
			{
                if (Phpfox::isModule('privacy'))
                {
                    $this->database()->join(Phpfox::getT('privacy'), 'p', 'p.module_id = feed.type_id AND p.item_id = feed.item_id')
                        ->join(Phpfox::getT('friend_list_data'), 'fld', 'fld.list_id = p.friend_list_id AND fld.friend_user_id = ' . Phpfox::getUserId() . '');
                }
				$this->database()->select('feed.*')
					->from($this->_sTable, 'feed')				
					->where('feed.privacy IN(4) AND feed.user_id = ' . (int) $iUserid . ' AND feed.feed_reference = 0')							
					->union();					
			}			
			
			$this->database()->select('feed.*')
				->from($this->_sTable, 'feed')
				->where(array_merge($aCond, array('AND feed.parent_user_id = ' . (int) $iUserid)))
				->union();
			
			$aRows = $this->database()->select('feed.*, apps.app_title,  ' . Phpfox::getUserField())
				->unionFrom('feed')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = feed.user_id')
				->leftJoin(Phpfox::getT('app'), 'apps', 'apps.app_id = feed.app_id')
				->order('feed.time_stamp DESC')
				->group('feed.feed_id')
				->limit($iOffset, $iTotalFeeds)			
				->execute('getSlaveRows');		
		}
		else
		{
			// Users must be active within 7 days or we skip their activity feed
			$iLastActiveTimeStamp = ((int) Phpfox::getParam('feed.feed_limit_days') <= 0 ? 0 : (PHPFOX_TIME - (86400 * Phpfox::getParam('feed.feed_limit_days'))));			
			if (Phpfox::isModule('privacy') && Phpfox::getUserParam('privacy.can_view_all_items'))
			{
				$this->_hashSearch();
				
				$sSelect = 'feed.*, apps.app_title, ' . Phpfox::getUserField();
				if (Phpfox::isModule('friend'))
				{
					$sSelect .= ', f.friend_id AS is_friend';
					$this->database()->leftJoin(Phpfox::getT('friend'), 'f', 'f.user_id = feed.user_id AND f.friend_user_id = ' . Phpfox::getUserId());
				}

				$aRows = $this->database()->select($sSelect)
						->from(Phpfox::getT('feed'), 'feed')			
						->join(Phpfox::getT('user'), 'u', 'u.user_id = feed.user_id')
						->leftJoin(Phpfox::getT('app'), 'apps', 'apps.app_id = feed.app_id')
						->order($sOrder)
						->group('feed.feed_id')
						->limit($iOffset, $iTotalFeeds)			
						->where('feed.time_stamp > \'' . $iLastActiveTimeStamp . '\' AND feed.feed_reference = 0')
						->execute('getSlaveRows');
			}
			else
			{
				if (Phpfox::getParam('feed.feed_only_friends'))
				{					
					if (Phpfox::isModule('friend'))
					{
						// Get my friends feeds
						$this->database()->select('feed.*')
							->from($this->_sTable, 'feed')
							->join(Phpfox::getT('friend'), 'f', 'f.user_id = feed.user_id AND f.friend_user_id = ' . Phpfox::getUserId())
							->where('feed.privacy IN(0,1,2) AND feed.time_stamp > \'' . $iLastActiveTimeStamp . '\' AND feed.feed_reference = 0')
							// ->limit($iTotalFeeds)
							->union();

						// Get my feeds
						$this->database()->select('feed.*')
							->from($this->_sTable, 'feed')
							->where('feed.privacy IN(0,1,2,3,4) AND feed.user_id = ' . Phpfox::getUserId() . ' AND feed.time_stamp > \'' . $iLastActiveTimeStamp . '\' AND feed.feed_reference = 0')
							// ->limit($iTotalFeeds)
							->union();
					}
				}
				else 
				{				
					$sMyFeeds = '1,2,3,4';
					(($sPlugin = Phpfox_Plugin::get('feed.service_feed_get_buildquery')) ? eval($sPlugin) : '');
					
					if (Phpfox::isModule('friend'))
					{
						// Get my friends feeds
						$this->database()->select('feed.*')
							->from($this->_sTable, 'feed')
							->join(Phpfox::getT('friend'), 'f', 'f.user_id = feed.user_id AND f.friend_user_id = ' . Phpfox::getUserId())
							->where('feed.privacy IN(1,2) AND feed.time_stamp > \'' . $iLastActiveTimeStamp . '\' AND feed.feed_reference = 0')
							->limit($iTotalFeeds)
							->union();		

						// Get my friends of friends feeds
						$this->database()->select('feed.*')
							->from($this->_sTable, 'feed')
							->join(Phpfox::getT('friend'), 'f1', 'f1.user_id = feed.user_id')
							->join(Phpfox::getT('friend'), 'f2', 'f2.user_id = ' . Phpfox::getUserId() . ' AND f2.friend_user_id = f1.friend_user_id')					
							->where('feed.privacy IN(2) AND feed.time_stamp > \'' . $iLastActiveTimeStamp .  '\' AND feed.feed_reference = 0')
							->limit($iTotalFeeds)
							->union();
					}				

					// Get my feeds
					$this->database()->select('feed.*')
						->from($this->_sTable, 'feed')
						->where('feed.privacy IN(' . $sMyFeeds . ') AND feed.user_id = ' . Phpfox::getUserId() . ' AND feed.time_stamp > \'' . $iLastActiveTimeStamp . '\' AND feed.feed_reference = 0')
						->union();

					// Get public feeds
					$this->database()->select('feed.*')
						->from($this->_sTable, 'feed')
						->where('feed.privacy IN(0) AND feed.time_stamp > \'' . $iLastActiveTimeStamp . '\' AND feed.feed_reference = 0')
						->union();					

                    if (Phpfox::isModule('privacy'))
                    {
                        $this->database()->join(Phpfox::getT('privacy'), 'p', 'p.module_id = feed.type_id AND p.item_id = feed.item_id')
                            ->join(Phpfox::getT('friend_list_data'), 'fld', 'fld.list_id = p.friend_list_id AND fld.friend_user_id = ' . Phpfox::getUserId() . '');

                    }
					// Get feeds based on custom friends lists	
					$this->database()->select('feed.*')
						->from($this->_sTable, 'feed')						
						->where('feed.privacy IN(4) AND feed.time_stamp > \'' . $iLastActiveTimeStamp . '\' AND feed.feed_reference = 0')
						->union();				
				}

				$this->_hashSearch();

				$sSelect = 'feed.*, apps.app_title, u.view_id,  ' . Phpfox::getUserField();
				if (Phpfox::isModule('friend'))
				{
					$sSelect .= ', f.friend_id AS is_friend';
					$this->database()->leftJoin(Phpfox::getT('friend'), 'f', 'f.user_id = feed.user_id AND f.friend_user_id = ' . Phpfox::getUserId());
				}
					
				$aRows = $this->database()->select($sSelect)
						->unionFrom('feed')			
						->join(Phpfox::getT('user'), 'u', 'u.user_id = feed.user_id')
						->leftJoin(Phpfox::getT('app'), 'apps', 'apps.app_id = feed.app_id')
						->order($sOrder)
						->group('feed.feed_id')
						->limit($iOffset, $iTotalFeeds)			
						->execute('getSlaveRows');					
			}
		}	

		
		if ($bForceReturn === true)
		{
			return $aRows;
		}
		
		
		$bFirstCheckOnComments = false;
		if (Phpfox::getParam('feed.allow_comments_on_feeds') && Phpfox::isUser() && Phpfox::isModule('comment'))
		{
			$bFirstCheckOnComments = true;	
		}
		
		$iLoopMaxCount = Phpfox::getParam('feed.group_duplicate_feeds');	
		if (Phpfox::getService('profile')->timeline() || Phpfox::getParam('feed.cache_each_feed_entry'))
		{
			$iLoopMaxCount = 0;
		}
		
		if (defined('PHPFOX_SKIP_LOOP_MAX_COUNT'))
		{
			$iLoopMaxCount = 0;
		}
		
		$aFeedLoop = array();
		$aLoopHistory = array();
		if (Phpfox::getLib('request')->get('hashtagsearch'))
		{
			$aFeedLoop = $aRows;
		}
		else
		{
			if ($iLoopMaxCount > 0)
			{
				foreach ($aRows as $iKey => $aRow)
				{
					$sFeedKey = $aRow['user_id'] . $aRow['type_id'] . date('dmyH', $aRow['time_stamp']);
					if (isset($aRow['type_id']))
					{
						$aModule = explode('_', $aRow['type_id']);
						if (isset($aModule[0]) && Phpfox::isModule($aModule[0]) && Phpfox::hasCallback($aModule[0] . (isset($aModule[1]) ? '_' . $aModule[1] : ''), 'getReportRedirect'))
						{
							$aRow['report_module'] = $aRows[$iKey]['report_module'] = $aModule[0] . (isset($aModule[1]) ? '_' . $aModule[1] : '');
							$aRow['report_phrase'] = $aRows[$iKey]['report_phrase'] = Phpfox::getPhrase('feed.report_this_entry');
							$aRow['force_report'] = $aRows[$iKey]['force_report'] = true;
						}
					}

					if (isset($aFeedLoop[$sFeedKey]))
					{
						if (!isset($aLoopHistory[$sFeedKey]))
						{
							$aLoopHistory[$sFeedKey] = 0;
						}

						$aLoopHistory[$sFeedKey]++;

						if ($aLoopHistory[$sFeedKey] >= ($iLoopMaxCount - 1))
						{
							$bIsLoop = true;

							$this->_aViewMoreFeeds[$sFeedKey][] = $aRow;
						}
						else
						{

							$aFeedLoop[$sFeedKey . $aLoopHistory[$sFeedKey]] = $aRow;

							continue;
						}
					}
					else
					{
						$aFeedLoop[$sFeedKey] = $aRow;
					}

					if (isset($bIsLoop))
					{
						unset($bIsLoop);
					}
				}
			}
			else
			{
				$aFeedLoop = $aRows;
			}
		}
		
		$aFeeds = array();
		$aCacheData = array();
		$sLastFriendId = '';
		$sLastPhotoId = 0;
		if (Phpfox::isModule('like'))
		{
		    $oLike = Phpfox::getService('like');
		}
		
		$aParentFeeds = array();
		foreach ($aFeedLoop as $sKey => $aRow)
		{
			$aRow['feed_time_stamp'] = $aRow['time_stamp'];
			if (($aReturn = $this->_processFeed($aRow, $sKey, $iUserid, $bFirstCheckOnComments)))
			{
				if (isset($aReturn['force_user']))
				{
					$aReturn['user_name'] = $aReturn['force_user']['user_name'];
					$aReturn['full_name'] = $aReturn['force_user']['full_name'];
					$aReturn['user_image'] = $aReturn['force_user']['user_image'];
					$aReturn['server_id'] = $aReturn['force_user']['server_id'];
				}
				
				$aReturn['feed_month_year'] = date('m_Y', $aRow['feed_time_stamp']);
				$aReturn['feed_time_stamp'] = $aRow['feed_time_stamp'];
				if (isset($aReturn['like_type_id']) && isset($oLike) && Phpfox::getParam('like.allow_dislike'))
				{
				 	$aReturn['marks'] = $oLike->getActionsFor($aReturn['like_type_id'], (isset($aReturn['like_item_id']) ? $aReturn['like_item_id'] : $aReturn['item_id']));
				}
				
				/* Lets figure out the phrases for like.display right here */
				//if (Phpfox::getParam('like.allow_dislike'))				
				if(Phpfox::isModule('like'))
				{
					$this->getPhraseForLikes($aReturn);
				}

				if (Phpfox::getParam('feed.cache_each_feed_entry') && !empty($aReturn['like_type_id']) && Phpfox::isUser() && isset($aReturn['likes']) && count($aReturn['likes']))
				{					
					$iUserLiked = (isset($aReturn['likes_history'][Phpfox::getUserId()]) ? true : false);
					$aReturn['feed_is_liked'] = $iUserLiked;
					$aReturn['is_liked'] = $iUserLiked;
				}
				

				if (Phpfox::getParam('feed.cache_each_feed_entry') && isset($aReturn['comments']) && count($aReturn['comments']))
				{
					foreach ($aReturn['comments'] as $iCommentKey => $aCommentValue)
					{					
						$aReturn['comments'][$iCommentKey]['is_liked'] = (isset($aCommentValue['liked_history'][Phpfox::getUserId()]) ? true : false);
					}
				}								
				
				$aFeeds[] = $aReturn;
			}
			
			// Show the feed properly. If user A posted on page 1, then feed will say "user A > page 1 posted ..."
			if (isset($this->_aCallback['module']) && $this->_aCallback['module'] == 'pages')
			{
				// If defined parent user, and the parent user is not the same page (logged in as a page)
				if (isset($aRow['page_user_id']) && $aReturn['page_user_id'] != $aReturn['user_id'])
				{
					$aParentFeeds[$aReturn['feed_id']] = $aRow['page_user_id'];
				}
			}
			elseif (isset($this->_aCallback['module']) && $this->_aCallback['module'] == 'event')
			{
				// Keep it empty
				$aParentFeeds = array();
			}
			elseif (isset($aRow['parent_user_id']) && !isset($aRow['parent_user']) && $aRow['type_id'] != 'friend')
			{
				$aParentFeeds[$aRow['feed_id']] = $aRow['parent_user_id'];
			}
			
			if(empty($aFeeds) && defined('PHPFOX_IS_USER_PROFILE'))
			{
				return $this->get($iUserid, $iFeedId, ++$iPage, $bForceReturn);
			}
		}
		
		// Get the parents for the feeds so it displays arrow.png 
		if (!empty($aParentFeeds))
		{
			$aParentUsers = $this->database()->select(Phpfox::getUserField())
				->from(Phpfox::getT('user'), 'u')
				->where('user_id IN (' . implode(',',array_values($aParentFeeds)) . ')')
				->execute('getSlaveRows');
			
			$aFeedsWithParents = array_keys($aParentFeeds);
			foreach ($aFeeds as $sKey => $aRow)
			{
				if (in_array($aRow['feed_id'], $aFeedsWithParents) && $aRow['type_id'] != 'photo_tag')
				{
					foreach ($aParentUsers as $aUser)
					{
						if ($aUser['user_id'] == $aRow['parent_user_id'])
						{
							$aTempUser = array();
							foreach ($aUser as $sField => $sVal)
							{
								$aTempUser['parent_' . $sField] = $sVal;
							}
							$aFeeds[$sKey]['parent_user'] = $aTempUser;
						}
					}					
				}
			}
		}
		
		$oReq = Phpfox::getLib('request');
		if (($oReq->getInt('status-id')
				|| $oReq->getInt('comment-id')
				|| $oReq->getInt('link-id')
				|| $oReq->getInt('poke-id')
		)
				&& isset($aFeeds[0]))
		{
			$aFeeds[0]['feed_view_comment'] = true;
			// $this->setParam('aFeed', array_merge(array('feed_display' => 'view', 'total_like' => $aRows[0]['feed_total_like']), $aRows[0]));
		}		
		
		if (Phpfox::getService('profile')->timeline())
		{		
			$iSubCnt = 0;
			foreach ($aFeeds as $iKey => $aFeed)
			{
				if (is_int($iKey/2))
				{
					$this->_aFeedTimeline['left'][] = $aFeed;
				}
				else
				{
					$this->_aFeedTimeline['right'][] = $aFeed;
				}
				
				$iSubCnt++;
				if ($iSubCnt === 1)
				{
					$sMonth = date('m', $aFeed['feed_time_stamp']);
					$sYear = date('Y', $aFeed['feed_time_stamp']);
					if ($sMonth == date('m', PHPFOX_TIME) && $sYear == date('Y', PHPFOX_TIME))
					{
						$this->_sLastDayInfo = '';
					}
					elseif ($sYear == date('Y', PHPFOX_TIME))
					{
						$this->_sLastDayInfo = Phpfox::getTime('F', $aFeed['feed_time_stamp'], false);
					}
					else
					{
						$this->_sLastDayInfo = Phpfox::getTime('F Y', $aFeed['feed_time_stamp'], false);
					}
				}
			}
		}
		if ($oReq->getInt('page') == 0 && Phpfox::isModule('ad') && Phpfox::getParam('ad.multi_ad') && $iFeedId == null && ( ($iAd = Phpfox::getService('ad')->getSponsoredFeed()) != false))
		{
			$aFeeds = array_splice($aFeeds, 0, count($aFeeds) - 1);
			$aSponsored = $this->get(null, $iAd);
			if (isset($aSponsored[0]))
			{
				$aSponsored[0]['sponsored_feed'] = true;			
				$aFeeds = array_merge($aSponsored, $aFeeds);
			}
		}
		return $aFeeds;
	}

	public function _hashSearch()
	{
		if (Phpfox::getLib('request')->get('req1') != 'hashtag' && Phpfox::getLib('request')->get('hashtagsearch') == '')
		{
			return;
		}

		$sRequest = (isset($_GET[PHPFOX_GET_METHOD]) ? $_GET[PHPFOX_GET_METHOD] : '');
		$sReq2 = '';
		if (!empty($sRequest))
		{
			$aParts = explode('/', trim($sRequest, '/'));
			$iCnt = 0;
			// http://www.phpfox.com/tracker/view/15000/
			// We have to count the "mobile" part as a req1
			// add one to the count
			$iCntTotal = (Phpfox::isMobile() ? 3 : 2);
			foreach ($aParts as $sPart)
			{
				$iCnt++;
				
				if ($iCnt === $iCntTotal)
				{
					$sReq2 = $sPart;
					break;
				}
			}
		}

		$sTag = (Phpfox::getLib('request')->get('hashtagsearch') ? Phpfox::getLib('request')->get('hashtagsearch') : $sReq2);

		if (empty($sTag))
		{
			return;
		}
		
		$sTag = Phpfox::getLib('parse.input')->clean($sTag, 255);		
		
		$this->database()->join(Phpfox::getT('tag'), 'hashtag', 'hashtag.item_id = feed.item_id AND hashtag.category_id = feed.type_id AND (tag_text = \'' . Phpfox::getLib('database')->escape($sTag) . '\' OR tag_url = \''. Phpfox::getLib('database')->escape($sTag) .'\')');
	}
	
	/** This function replaces the routine in the like.block.display template
	*	but it also controls if the entire div should be shown or not, including the dislikes
	 */
	public function getPhraseForLikes(&$aFeed, $bForce = false)
	{
		$sOriginalIsLiked = ((isset($aFeed['feed_is_liked']) && $aFeed['feed_is_liked']) ? $aFeed['feed_is_liked'] : '');

		if(!isset($aFeed['feed_total_like']))
		{
			$aFeed['feed_total_like'] = isset($aFeed['likes']) ? count($aFeed['likes']) : 0;
		}
		
		if(!isset($aFeed['like_type_id']))
		{
			$aFeed['like_type_id'] = isset($aFeed['type_id']) ? $aFeed['type_id'] : null;
		}
                
	    $sPhrase = '';
	    $oParse = Phpfox::getLib('phpfox.parse.output');
	    if (Phpfox::isModule('like'))
	    {
            $oLike = Phpfox::getService('like');
	    }
	    $oUrl = Phpfox::getLib('url');
	    
	    if ((!isset($aFeed['likes']) && isset($oLike)) || count($aFeed['likes']) > Phpfox::getParam('feed.total_likes_to_display'))
	    {
            $aFeed['likes'] = $oLike->getLikesForFeed($aFeed['type_id'], $aFeed['item_id'], false, Phpfox::getParam('feed.total_likes_to_display'));
            $aFeed['total_likes'] = count($aFeed['likes']);
	    }

	    $bDidILikeIt = false;
	    /* Check to see if I liked this */
		if (Phpfox::getParam('feed.cache_each_feed_entry'))
		{
			$aFeed['feed_is_liked'] = false;
		}
		else
		{
			if (!isset($aFeed['feed_is_liked']))
			{
				if(Phpfox::isModule('like'))
				{
					$aFeed['feed_is_liked'] = Phpfox::getService('like')->didILike($aFeed['type_id'], $aFeed['item_id']);
				}
			}
		}

		$iCountLikes = (isset($aFeed['likes']) && !empty($aFeed['likes'])) ? count($aFeed['likes']) : 0;

		if ($aFeed['feed_total_like'] < count($aFeed['likes']))
		{
			$aFeed['feed_total_like'] = count($aFeed['likes']);
		}
		
		$iPhraseLimiter = Phpfox::getParam('feed.total_likes_to_display');
	    if (isset($aFeed['feed_is_liked']) && $aFeed['feed_is_liked'])		
	    {
                if ($iPhraseLimiter == 1 || $iPhraseLimiter == 2)
                {
					if ($aFeed['feed_total_like'] == 2)
					{
						$sPhrase = Phpfox::getPhrase('like.you_and') . '&nbsp;';
					}
					else
					{
						$sPhrase = Phpfox::getPhrase('like.you');
					}
                }
                else if ($aFeed['feed_total_like'] == 1)
                {
					$sPhrase = Phpfox::getPhrase('like.you');
				}
				else if ($aFeed['feed_total_like'] == 2)
                {
					$sPhrase = Phpfox::getPhrase('like.you_and') . '&nbsp;';
				}
                else if ($iPhraseLimiter > 2)
                {
                    $sPhrase = Phpfox::getPhrase('like.you_comma') . '&nbsp;';
                }
                $bDidILikeIt = true;
	    }
	    else
	    {
                if(Phpfox::isModule('like'))
                {
                    $sPhrase = Phpfox::getPhrase('like.article_to_upper');
                }
	    }

	    if (isset($aFeed['likes']) && is_array($aFeed['likes']) && $iCountLikes > 0)
	    {
			$iIteration = ($bDidILikeIt && ($iPhraseLimiter < $aFeed['feed_total_like']) ? 1 : 0);
			$aLikes = array();
            foreach ($aFeed['likes'] as $aLike)
            {
                if($iIteration >= $iCountLikes)
                {
                    break;
                }
                else
                {
                        if ($aLike['user_id'] == Phpfox::getUserId() && !Phpfox::getParam('feed.cache_each_feed_entry'))
                        {
                                continue;
                        }
                        $sUserLink = '<span class="user_profile_link_span" id="js_user_name_link_'. $aLike['user_name'] . '"><a href="' . $oUrl->makeUrl($aLike['user_name']) . '">'.$oParse->shorten($aLike['full_name'], 30) .'</a></span>';
                        $aLikes[] = $sUserLink;
                        $iIteration++;
                }            
            }
			
			$sTempUser = array_pop($aLikes);
			$sImplode = implode(', ', $aLikes);
			$sPhrase .=  $sImplode . ' ';

			if (isset($aFeed['feed_is_liked']) && $aFeed['feed_is_liked'] && $iPhraseLimiter >= 2 && $aFeed['feed_total_like'] > $iPhraseLimiter)
			{
				$sPhrase = trim($sPhrase) . ', ' /*. Phpfox::getPhrase('like.and') . ' '*/;
			}
			else if ( isset($aFeed['feed_total_like']) && ($aFeed['feed_total_like'] > Phpfox::getParam('feed.total_likes_to_display')) && Phpfox::getParam('feed.total_likes_to_display') != 1)
			{
				$sPhrase = trim($sPhrase) . ', ';
			}
			else if (count($aLikes) > 0) 
			{
				$sPhrase .= Phpfox::getPhrase('like.and') . ' ';
			}
			else
			{
				$sPhrase = trim($sPhrase);
			}
			$sPhrase .= $sTempUser;
			
	    }
		
	    if (isset($aFeed['feed_total_like']) && $aFeed['feed_total_like'] > Phpfox::getParam('feed.total_likes_to_display') && Phpfox::getParam('feed.total_likes_to_display') != 0)
	    {
                $sPhrase .= '<a href="#" onclick="return $Core.box(\'like.browse\', 400, \'type_id='. $aFeed['like_type_id'] . '&amp;item_id='. $aFeed['item_id'] . '\');">';
                $iTotalLeftShow = ($aFeed['feed_total_like'] - Phpfox::getParam('feed.total_likes_to_display'));

                if ($iTotalLeftShow == 1)
                {
                    $sPhrase .= '&nbsp;'. Phpfox::getPhrase('like.and') . '&nbsp;' . Phpfox::getPhrase('like.1_other_person') . '&nbsp;';
                }
                else
                {
                    $sPhrase .= '&nbsp;'. Phpfox::getPhrase('like.and') . '&nbsp;'. number_format($iTotalLeftShow) . '&nbsp;' . Phpfox::getPhrase('like.others') . '&nbsp;';
                }
                $sPhrase .= '</a>' . Phpfox::getPhrase('like.likes_this');
	    }
	    else
	    {
            if (isset($aFeed['likes']) && count($aFeed['likes']) > 1)
            {
                $sPhrase .= '&nbsp;'. Phpfox::getPhrase('like.like_this');
            }
            else
            {
                if (isset($aFeed['feed_is_liked']) && $aFeed['feed_is_liked'])
                {
                    if (count($aFeed['likes']) == 0 || count($aFeed['likes']) == 1)
                    {
                        $sPhrase .= '&nbsp;' . Phpfox::getPhrase('like.like_this');

                    }
                    else
                    {
                        if (count($aFeed['likes']) > 1)
                        {
                            $sPhrase .= '<a href="#" onclick="return $Core.box(\'like.browse\', 400, \'type_id='. $aFeed['like_type_id'] . '&amp;item_id='. $aFeed['item_id'] . '\');">';
                            $sPhrase .= number_format($aFeed['feed_total_like']) . '&nbsp;' . Phpfox::getPhrase('like.others') . '&nbsp;';
                            $sPhrase .= '</a>' . Phpfox::getPhrase('like.likes_this');
                        }
                        else
                        {
                            $sPhrase .= Phpfox::getPhrase('like.likes_this');
                        }
                    }
                }
                else
                {
                    if (isset($aFeed['likes']) && count($aFeed['likes']) == 1)
                    {
                        $sPhrase .= '&nbsp;' . Phpfox::getPhrase('like.likes_this');
                    }
                    else if (strlen($sPhrase) > 1)
                    {
                        $sPhrase .= Phpfox::getPhrase('like.like_this');			    
                    }			
                }
            }
	    }
	    
	    // $aActions = Phpfox::getService('like')->getActionsFor($aFeed['type_id'], $aFeed['item_id']);	    
		$aActions = array();
		
		if(Phpfox::isModule('like'))
		{
			$aActions = Phpfox::getService('like')->getDislikes($aFeed['type_id'], $aFeed['item_id']) ;
		}
	    
		if (count($aActions) > 0)
		{
			$aFeed['bShowEnterCommentBlock'] = true;
			$aFeed['call_displayactions'] = true;
		}
	    if (strlen($sPhrase) > 1 || count($aActions) > 0)
	    {
            $aFeed['bShowEnterCommentBlock'] = true;
	    }
	    $sPhrase = str_replace(array("&nbsp;&nbsp;", '  ', "\n"), array('&nbsp;',' ',''), $sPhrase);
	    $sPhrase = str_replace(array('  '," &nbsp;", "&nbsp; "), ' ', $sPhrase);
	    
	    //',&nbsp;,'
	    $sPhrase = str_replace(array("\r\n", "\r"), "\n", $sPhrase);
		
	    $aFeed['feed_like_phrase'] = $sPhrase;

		if (!empty($sOriginalIsLiked) && !$bForce)
		{
			$aFeed['feed_is_liked'] = $sOriginalIsLiked;
		}

        if (empty($sPhrase))
        {
            $aFeed['feed_is_liked'] = false;
            $aFeed['feed_total_like'] = 0;
        }
		
	    return $sPhrase;
	}
	
	public function getTimeline()
	{
		return $this->_aFeedTimeline;
	}
	
	public function getLastDay()
	{
		return $this->_sLastDayInfo;
	}	
	
	public function getLikeForFeed($iFeed)
	{
		$aLikeRows = $this->database()->select('fl.feed_id, ' . Phpfox::getUserField())
			->from(Phpfox::getT('feed_like'), 'fl')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fl.user_id')
			->where('fl.feed_id = ' . (int) $iFeed)
			->execute('getSlaveRows');
						
		$aLikes = array();
		$aLikesCount = array();
		foreach ($aLikeRows as $aLikeRow)
		{
			if (!isset($aLikesCount[$aLikeRow['feed_id']]))
			{
				$aLikesCount[$aLikeRow['feed_id']] = 0;
			}
						
			$aLikesCount[$aLikeRow['feed_id']]++;
						
			if ($aLikesCount[$aLikeRow['feed_id']] > 3)
			{
				continue;
			}
						
			$aLikes[$aLikeRow['feed_id']][] = $aLikeRow;	
		}
					
		return array($aLikesCount, $aLikes);
	}

	/**
	 * We get the redirect URL of the item depending on which module
	 * it belongs to. We use the callback to connect to the correct module.
	 *
	 * @param integer $iId Is the ID# of the feed
	 * @return boolean|string If we are unable to find the correct feed, If we find the correct feed
	 */
	public function getRedirect($iId)
	{
		// Get the feed
		$aFeed = $this->database()->select('privacy_comment, feed_id, type_id, item_id, user_id')
			->from($this->_sTable)
			->where('feed_id =' . (int) $iId)
			->execute('getSlaveRow');
		
		
		// Make sure we found a feed
		if (!isset($aFeed['feed_id']))
		{
			return false;
		}
		$aProcessedFeed = $this->_processFeed($aFeed, false, $aFeed['user_id'], false);		
		Phpfox::getLib('url')->send($aProcessedFeed['feed_link'], array(), null, 302);
                /* Apparently in some CGI servers for some reason the redirect
                 * triggers a 500 error when the callback doesnt exist
                 * http://www.phpfox.com/tracker/view/6356/
                 */
                if (!Phpfox::hasCallback($aFeed['type_id'], 'getFeedRedirect'))
                {
                    return false;
                }
		// Run the callback so we get the correct link
		return Phpfox::callback($aFeed['type_id'] . '.getFeedRedirect', $aFeed['item_id'], $aFeed['child_item_id']);
	}
	
	public function getFeed($iId)
	{
		return $this->database()->select('*')
			->from(Phpfox::getT((isset($this->_aCallback['table_prefix']) ? $this->_aCallback['table_prefix'] : '') . 'feed'))
			->where('feed_id =' . (int) $iId)
			->execute('getSlaveRow');
	}
	
	public function shortenText($sText)
	{
		$oParseOutput = Phpfox::getLib('parse.output');
		
		return $oParseOutput->split($oParseOutput->shorten($oParseOutput->parse($sText), 300, 'feed.view_more', true), 40);	
	}
	
	public function shortenTitle($sText)
	{
		$oParseOutput = Phpfox::getLib('parse.output');
		
		return $oParseOutput->shorten($oParseOutput->clean($sText), 60, '...');
	}
	
	public function quote($sText)
	{
		Phpfox::getLib('parse.output')->setImageParser(array('width' => 200, 'height' => 200));

		$sNewText = '<div class="p_4">' . $this->shortenText($sText) . '</div>';
		
		Phpfox::getLib('parse.output')->setImageParser(array('clear' => true));
		
		return $sNewText;
	}
	
	public function getForBrowse($aConds, $sSort = 'feed.time_stamp DESC', $iRange = '', $sLimit = '')
	{
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'feed')
			->where($aConds)
			->execute('getSlaveField');				
			
			$aRows = $this->database()->select('feed.*, fl.feed_id AS is_liked, ' . Phpfox::getUserField('u1', 'owner_') . ', ' . Phpfox::getUserField('u2', 'viewer_'))
				->from($this->_sTable, 'feed')
				->join(Phpfox::getT('user'), 'u1', 'u1.user_id = feed.user_id')
				->leftJoin(Phpfox::getT('user'), 'u2', 'u2.user_id = feed.item_user_id')
				->leftJoin(Phpfox::getT('feed_like'), 'fl', 'fl.feed_id = feed.feed_id AND fl.user_id = ' . Phpfox::getUserId())
				->where($aConds)
				->order($sSort)
				->limit($iRange, $sLimit, $iCnt)
				->execute('getSlaveRows');			
			
			$aFeeds = array();
			foreach ($aRows as $aRow)
			{
				$aRow['link'] = Phpfox::getLib('url')->makeUrl('feed.view', array('id' => $aRow['feed_id']));

				$aParts1 = explode('.', $aRow['type_id']);
				$sModule = $aParts1[0];
				if (strpos($sModule, '_'))
				{
					$aParts = explode('_', $sModule);
					$sModule = $aParts[0];
					if ($sModule == 'comment' && isset($aParts[1]) && !Phpfox::isModule($aParts[1]))
					{
					    continue;
					}
				}				
				
				if (!Phpfox::isModule($sModule))
				{
					continue;
				}
				
				if (($aFeed = Phpfox::callback($aRow['type_id'] . '.getNewsFeed', $aRow)))
				{
					if (isset($aLikes[$aFeed['feed_id']]))
					{
						$aFeed['like_rows'] = $aLikes[$aFeed['feed_id']];
					}
					
					if (isset($aLikesCount[$aFeed['feed_id']]))
					{
						$aFeed['like_count'] = ($aLikesCount[$aFeed['feed_id']] - count($aFeed['like_rows']));
					}					
					
					$aFeeds[] = $aFeed;
				}
			}
			
		return array($iCnt, $aFeeds);
	}
	
	public function processAjax($iId)
	{
		$oAjax = Phpfox::getLib('ajax');
				
		$aFeeds = Phpfox::getService('feed')->get(Phpfox::getUserId(), $iId);
		
		if (!isset($aFeeds[0]))
		{
			$oAjax->alert(Phpfox::getPhrase('feed.this_item_has_successfully_been_submitted'));
			$oAjax->call('$Core.resetActivityFeedForm();');	
				
			return;
		}
		
		
		if (isset($aFeeds[0]['type_id']))
		{
			Phpfox::getLib('template')->assign(array(
				'aFeed' => $aFeeds[0],
				'aFeedCallback' => array('module' => str_replace('_comment','',$aFeeds[0]['type_id']), 'item_id' => $aFeeds[0]['item_id'])
				))->getTemplate((Phpfox::getService('profile')->timeline() ? 'feed.block.timeline' : 'feed.block.entry'));				
		}
		else
		{
			Phpfox::getLib('template')->assign(array('aFeed' => $aFeeds[0]))->getTemplate('feed.block.entry');				
		}	
		
		$sId = 'js_tmp_comment_' . md5('feed_' . uniqid() . Phpfox::getUserId()) . '';
		
		$sNewContent =  '<div id="' . $sId . '" class="js_temp_new_feed_entry js_feed_view_more_entry_holder">' . $oAjax->getContent(false) . '</div>';
		
		if (Phpfox::getService('profile')->timeline())
		{
			$oAjax->prepend('.timeline_left_new', '<div class="timeline_feed_row"><div class="timeline_arrow_left">0</div><div class="timeline_float_left">0</div>' . $sNewContent . '</div>');
		}
		else
		{
			$oAjax->prepend('#js_new_feed_comment', $sNewContent);
		}
		
		$oAjax->call('$(\'#' . $sId . '\').highlightFade();');
		
		$oAjax->removeClass('.js_user_feed', 'row_first');
		$oAjax->call("iCnt = 0; \$('.js_user_feed').each(function(){ iCnt++; if (iCnt == 1) { \$(this).addClass('row_first'); } });");
		if ($oAjax->get('force_form'))
		{
			$oAjax->call('tb_remove();');
			$oAjax->show('#js_main_feed_holder');			
			$oAjax->call('$Core.resetActivityFeedForm();');			
		}
		else
		{
			$oAjax->call('$Core.resetActivityFeedForm();');
		}	
		$oAjax->call('$Core.loadInit();');
	}
	
	public function getShareLinks()
	{
		if ($sPlugin = Phpfox_Plugin::get('feed.service_feed_getsharelinks__start'))
		{
			eval($sPlugin);
			if (isset($aPluginReturn))
			{
				return $aPluginReturn;
			}
		}
		$sCacheId = $this->cache()->set('feed_share_link');
		
		if (!($aLinks = $this->cache()->get($sCacheId)))
		{
			$aLinks = $this->database()->select('fs.*')
				->from(Phpfox::getT('feed_share'), 'fs')
				->join(Phpfox::getT('module'), 'm', 'm.module_id = fs.module_id AND m.is_active = 1')
				->order('fs.ordering ASC')
				->execute('getSlaveRows');
				
			foreach ($aLinks as $iKey => $aLink)
			{
				$aLinks[$iKey]['module_block'] = $aLink['module_id'] . '.' . $aLink['block_name'];
			}
				
			$this->cache()->save($sCacheId, $aLinks);
		}
		$aNoDuplicates = array();
		if (!is_array($aLinks) || empty($aLinks))
		{
			return $aLinks;
		}
		foreach ($aLinks as $iKey => $aLink)
		{
			unset($aLink['share_id']);
			if (in_array(serialize($aLink), $aNoDuplicates))
			{
				unset($aLinks[$iKey]);
				continue;
			}
			if (Phpfox::hasCallback($aLink['module_id'], 'checkFeedShareLink') && Phpfox::callback($aLink['module_id'] . '.checkFeedShareLink') === false)
			{
				unset($aLinks[$iKey]);
			}
			$aNoDuplicates[] = serialize($aLink);
		}
		
        if ($sPlugin = Phpfox_Plugin::get('feed.service_feed_getsharelinks__end')){eval($sPlugin);if (isset($aPluginReturn)){return $aPluginReturn;}}
        
		return $aLinks;
	}

	public function getInfoForAction($aItem)
	{
		$aRow = $this->database()->select('fc.feed_comment_id, fc.content as title, fc.user_id, u.gender, u.user_name, u.full_name')	
			->from(Phpfox::getT('feed_comment'), 'fc')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = fc.user_id')
			->where('fc.feed_comment_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');
        
        if (empty($aRow))
        {
            return false;
        }
		$aRow['link'] = Phpfox::getLib('url')->makeUrl($aRow['user_name']);
        
        
		return $aRow;
	}
	
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('feed.service_feed__call'))
		{
			return eval($sPlugin);
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
		
	private function _parseFeed($sLink, $sStr, $sUserName)
	{
		$sLink = stripslashes($sLink);
		$sStr = stripslashes($sStr);
		$sUserName = stripslashes($sUserName);
		
		$bAddSpan = true;
		if (preg_match('/feed\/view/i', $sLink))
		{
			$bAddSpan = false;	
		}
		
		return ($bAddSpan ? '<span class="user_profile_link_span" id="js_user_name_link_' . $sUserName . '">' : '') . '<a href="' . $sLink . '">' . $sStr . '</a>' . ($bAddSpan ? '</span>' : '');
	}		
	
	private function _processFeed($aRow, $sKey, $iUserid, $bFirstCheckOnComments)
	{			
		switch ($aRow['type_id'])
		{
			case 'comment_profile':
			case 'comment_profile_my':
				$aRow['type_id'] = 'profile_comment'; break;
			case 'profile_info':
				$aRow['type_id'] = 'custom'; break;
			case 'comment_photo':
				$aRow['type_id'] = 'photo_comment'; break;
			case 'comment_blog':
				$aRow['type_id'] = 'blog_comment'; break;
			case 'comment_video':
				$aRow['type_id'] = 'video_comment'; break;
			case 'comment_group':
				$aRow['type_id'] = 'pages_comment'; break;				
		}
		
		if (preg_match('/(.*)_feedlike/i', $aRow['type_id'])
				|| $aRow['type_id'] == 'profile_design'
		)
		{
			$this->database()->delete(Phpfox::getT('feed'), 'feed_id = ' . (int) $aRow['feed_id']);

			return false;
		}


		if (!Phpfox::hasCallback($aRow['type_id'], 'getActivityFeed'))
		{
			return false;
		}
		
		$bCacheFeed = false;
		if (Phpfox::getParam('feed.cache_each_feed_entry'))
		{
			$bCacheFeed = true;
		}

		$sFeedCacheId = $this->cache()->set(array('feeds', $aRow['type_id'] . '_' . $aRow['item_id']));
		if ($bCacheFeed && ($aFeed = $this->cache()->get($sFeedCacheId)))
		{
			if (Phpfox::hasCallback($aRow['type_id'], 'getActivityFeedCustomChecks'))
			{
				$aFeed = Phpfox::callback($aRow['type_id'] . '.getActivityFeedCustomChecks', $aFeed, $aRow);
				if ($aFeed === false)
				{
					return false;
				}
			}
		}
		else
		{
			$aFeed = Phpfox::callback($aRow['type_id'] . '.getActivityFeed', $aRow, (isset($this->_aCallback['module']) ? $this->_aCallback : null));

			if ($aFeed === false)
			{
				return false;
			}
			/*
			  if (!empty($aRow['feed_reference']))
			  {
			  $aRow['item_id'] = $aRow['feed_reference'];
			  }
			 */
			 
			if (isset($this->_aViewMoreFeeds[$sKey]))
			{
				foreach ($this->_aViewMoreFeeds[$sKey] as $iSubKey => $aSubRow)
				{
					$mReturnViewMore = $this->_processFeed($aSubRow, $iSubKey, $iUserid, $bFirstCheckOnComments);

					if ($mReturnViewMore === false)
					{
						continue;
					}
					
					// http://www.phpfox.com/tracker/view/15457/
					$mReturnViewMore['call_displayactions'] = true;
					// END

					$aFeed['more_feed_rows'][] = $mReturnViewMore;
				}
			}
		
			if (Phpfox::isModule('like') && (isset($aFeed['like_type_id']) || isset($aRow['item_id'])) && ( (isset($aFeed['enable_like']) && $aFeed['enable_like'])) || (!isset($aFeed['enable_like'])) &&  (isset($aFeed['feed_total_like']) && (int) $aFeed['feed_total_like'] > 0))
			{
				$aFeed['likes'] = Phpfox::getService('like')->getLikesForFeed($aFeed['like_type_id'], (isset($aFeed['like_item_id']) ? $aFeed['like_item_id'] : $aRow['item_id']), ((int) $aFeed['feed_is_liked'] > 0 ? true : false), Phpfox::getParam('feed.total_likes_to_display'), true);				
				$aFeed['feed_total_like'] = Phpfox::getService('like')->getTotalLikeCount();
				
				
				if (Phpfox::getParam('feed.cache_each_feed_entry'))
				{
					$aAllLikesRows = $this->database()->select('user_id')
						->from(Phpfox::getT('like'))
						->where('type_id = \'' . $aFeed['like_type_id'] . '\' AND item_id = ' . (isset($aFeed['like_item_id']) ? $aFeed['like_item_id'] : $aRow['item_id']))
						->execute('getSlaveRows');
					foreach ($aAllLikesRows as $aAllLikesRow)
					{
						$aFeed['likes_history'][$aAllLikesRow['user_id']] = true;
					}
				}                  
			}

			if (isset($aFeed['comment_type_id']) && (int) $aFeed['total_comment'] > 0 && Phpfox::isModule('comment'))
			{	
					$aFeed['comments'] = Phpfox::getService('comment')->getCommentsForFeed($aFeed['comment_type_id'], $aRow['item_id'], Phpfox::getParam('comment.total_comments_in_activity_feed'));
					//$aFeed['comments'] = Phpfox::getService('comment')->getCommentsForFeed($aFeed['comment_type_id'], (!empty($aRow['feed_reference']) ? $aRow['feed_reference'] : $aRow['item_id']), Phpfox::getParam('comment.total_comments_in_activity_feed'));
					if (Phpfox::getParam('feed.cache_each_feed_entry'))
					{
						foreach ($aFeed['comments'] as $iCommentRowCnt => $aCommentRow)
						{
							$aCommentLikesRows = $this->database()->select('user_id')
								->from(Phpfox::getT('like'))
								->where('type_id = \'feed_mini\' AND item_id = ' . $aCommentRow['comment_id'])
								->execute('getSlaveRows');
							foreach ($aCommentLikesRows as $aCommentLikesRow)
							{
								$aFeed['comments'][$iCommentRowCnt]['liked_history'][$aCommentLikesRow['user_id']] = true;
							}	
						}	
					}
			}	
			
			if ($bCacheFeed)
			{
				$this->cache()->save($sFeedCacheId, $aFeed);
			}
		}		
		
		if (isset($aRow['app_title']) && $aRow['app_id'])
		{
				$sLink = '<a href="' . Phpfox::permalink('apps', $aRow['app_id'], $aRow['app_title']) . '">' . $aRow['app_title'] . '</a>';
				$aFeed['app_link'] = $sLink;			
		}

		// Check if user can post comments on this feed/item
		$bCanPostComment = false;
		if ($bFirstCheckOnComments)
		{
				$bCanPostComment = true;	
		}		
		if ($iUserid !== null && $iUserid != Phpfox::getUserId())
		{
		    switch ($aRow['privacy_comment'])
		    {
				case '1':
					// http://www.phpfox.com/tracker/view/14418/ instead of "if(!Phpfox::getService('user')->getUserObject($iUserid)->is_friend)"
					if (Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $aRow['user_id']))
					{
					$bCanPostComment = false;
					}
					break;
				case '2':
					// http://www.phpfox.com/tracker/view/14418/ instead of "if (!Phpfox::getService('user')->getUserObject($iUserid)->is_friend && !Phpfox::getService('user')->getUserObject($iUserid)->is_friend_of_friend)"
					if (Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $aRow['user_id']) && Phpfox::getService('friend')->isFriendOfFriend($aRow['user_id']))
					{
					$bCanPostComment = false;
					}
					break;
				case '3':
					$bCanPostComment = false;
					break;
		    }
		}

		if ($iUserid === null)
		{
			if ($aRow['user_id'] != Phpfox::getUserId())
			{
				switch ($aRow['privacy_comment'])
				{	
					case '1':
					case '2':
							if (!isset($aRow['is_friend']) || !$aRow['is_friend'])
							{
									$bCanPostComment = false;
							}
							break;
					case '3':
							$bCanPostComment = false;
							break;
				}
			}
		}

		$aRow['can_post_comment'] = $bCanPostComment;
		
		
		if (!isset($aFeed['marks']))
		{
			if(Phpfox::isModule('like'))
                        {
                            $aFeed['marks'] = Phpfox::getService('like')->getDislikes($aRow['type_id'], $aRow['item_id']);
                        }
		}		
		
		$aFeed['bShowEnterCommentBlock'] = false;
		if (
			( isset($aFeed['feed_total_like']) && $aFeed['feed_total_like'] > 0) ||
			( isset($aFeed['marks']) && is_array($aFeed['marks']) && count($aFeed['marks'])) ||
			( isset($aFeed['comments']) && is_array($aFeed['comments']) && count($aFeed['comments']))
		    )
		{
		    $aFeed['bShowEnterCommentBlock'] = true;
		}
		$aOut = array_merge($aRow, $aFeed);
		
		
		return $aOut;		
	}
}

?>
