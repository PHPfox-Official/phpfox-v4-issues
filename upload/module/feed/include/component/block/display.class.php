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
 * @version 		$Id: display.class.php 7270 2014-04-14 17:06:13Z Fern $
 */
class Feed_Component_Block_Display extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (defined('PHPFOX_IS_PAGES_WIDGET'))
		{
			return false;
		}
		
		if (defined('PHPFOX_IS_PAGES_VIEW') && ($this->request()->get('req3') == 'info' || $this->request()->get('req2') == 'info')) 
		{
		    return false;
		}
		
		$iUserId = $this->getParam('user_id');
		$aPage = $this->getParam('aPage');
        
		// Dont display the feed if approving users
		if (isset($aPage['page_id']) && $this->request()->get('req3') == 'pending')
		{
			return false;
		}
        if (isset($aPage['landing_page']) && $aPage['landing_page'] == 'info' && 
            ( 
                (empty($aPage['vanity_url']) && $this->request()->get('req3') == '') || 
                (!empty($aPage['vanity_url']) && ($this->request()->get('req2') == 'info' || $this->request()->get('req2') == ''))
            ))
        {
            return false;
        }
		
		$bForceFormOnly = $this->getParam('bForceFormOnly');
		if (isset($aPage['page_user_id']))
		{
			$bHasPerm = Phpfox::getService('pages')->hasPerm($aPage['page_id'], 'pages.view_browse_updates');
			if ($bHasPerm == false)
			{
				return false;
			}
			$iUserId = $aPage['page_user_id'];
			
			/* Get all blocks for location 2 and 3 */
			
			$oBlock = Phpfox::getLib('module');
			$aExtraBlocks = array();
			$aBlocks = $oBlock->getModuleBlocks(1, true);
			$aBlocks = array_merge($aBlocks, $oBlock->getModuleBlocks(3, true));
			foreach ($aBlocks as $iKey => $sBlock)
			{
				switch($sBlock)
				{
					case 'pages.menu':
					case 'pages.photo':		
						if ($sBlock == 'pages.menu')
						{
							$aExtraBlocks[] = $sBlock;
						}			
						unset($aBlocks[$iKey]);
						break;
				}
				
			}
			$aBlocks = array_merge($aBlocks, $aExtraBlocks);
			$this->template()->assign(array('aLoadBlocks' => $aBlocks));
		}
		$bIsCustomFeedView = false;
		$sCustomViewType = null;
		
		if (PHPFOX_IS_AJAX && ($iUserId = $this->request()->get('profile_user_id')))
		{
			if (!defined('PHPFOX_IS_USER_PROFILE'))
			{
				define('PHPFOX_IS_USER_PROFILE', true);
			}
			$aUser = Phpfox::getService('user')->get($iUserId);
			
			$this->template()->assign(array(
					'aUser' => $aUser
				)
			);
		}	
		
		if (PHPFOX_IS_AJAX && $this->request()->get('callback_module_id'))
		{
			$aCallback = Phpfox::callback($this->request()->get('callback_module_id') . '.getFeedDisplay', $this->request()->get('callback_item_id'));
			$this->setParam('aFeedCallback', $aCallback);
		}
		
		$aFeedCallback = $this->getParam('aFeedCallback', null);
		
		$bIsProfile = (is_numeric($iUserId) && $iUserId > 0);
		
		if ($this->request()->get('feed') && $bIsProfile)
		{
			switch ($this->request()->get('flike'))
			{
				default:
					if ($sPlugin = Phpfox_Plugin::get('feed.component_block_display_process_flike'))
					{
						eval($sPlugin);
					}					
					break;
			}
		}
		
		if (defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::getService('user.privacy')->hasAccess($iUserId, 'feed.view_wall'))
		{			
			return false;			
		}
		
		if (defined('PHPFOX_IS_PAGES_VIEW') && !Phpfox::getService('pages')->hasPerm(null, 'pages.share_updates'))
		{
			$aFeedCallback['disable_share'] = true;
		}		

		$iFeedPage = $this->request()->get('page', 0);
		
		if ($this->request()->getInt('status-id') 
			|| $this->request()->getInt('comment-id') 
			|| $this->request()->getInt('link-id')
			|| $this->request()->getInt('plink-id')
			|| $this->request()->getInt('poke-id')
			|| $this->request()->getInt('feed')
		)
		{
			$bIsCustomFeedView = true;
			if ($this->request()->getInt('status-id'))
			{
				$sCustomViewType = Phpfox::getPhrase('feed.status_update_iid',array('iId' => $this->request()->getInt('status-id')));
			}
			elseif ($this->request()->getInt('link-id'))
			{
				$sCustomViewType = Phpfox::getPhrase('feed.link_iid', array('iId' => $this->request()->getInt('link-id')));
			}
			elseif ($this->request()->getInt('plink-id'))
			{
				$sCustomViewType = Phpfox::getPhrase('feed.link_iid', array('iId' => $this->request()->getInt('plink-id')));
			}			
			elseif ($this->request()->getInt('poke-id'))
			{
				$sCustomViewType = Phpfox::getPhrase('feed.poke_iid',array('iId' =>$this->request()->getInt('poke-id')));
			}			
			elseif ($this->request()->getInt('comment-id'))
			{
				$sCustomViewType = Phpfox::getPhrase('feed.wall_comment_iid',array('iId' => $this->request()->getInt('comment-id')));						
				
				Phpfox::getService('notification.process')->delete('feed_comment_profile', $this->request()->getInt('comment-id'), Phpfox::getUserId());
			}
			elseif ($this->request()->getInt('feed'))
			{
				$sCustomViewType = Phpfox::getPhrase('feed.feed');
			}
		}
		
		if ((!isset($aFeedCallback['item_id']) || $aFeedCallback['item_id'] == 0))
		{
			$aFeedCallback['item_id'] = ((int)$this->request()->get('amp;callback_item_id')) > 0 ? $this->request()->get('amp;callback_item_id') : $this->request()->get('callback_item_id');
		}

		$bForceReloadOnPage = (PHPFOX_IS_AJAX ? false : Phpfox::getParam('feed.force_ajax_on_load'));
		$aRows = array();
		if (PHPFOX_IS_AJAX || !$bForceReloadOnPage || $bIsCustomFeedView)
		{
			$aRows = Phpfox::getService('feed')->callback($aFeedCallback)->get(($bIsProfile > 0 ? $iUserId : null), ($this->request()->get('feed') ? $this->request()->get('feed') : null), $iFeedPage);
			
			if (empty($aRows))
			{
				$iFeedPage++;
				$aRows = Phpfox::getService('feed')->callback($aFeedCallback)->get(($bIsProfile > 0 ? $iUserId : null), ($this->request()->get('feed') ? $this->request()->get('feed') : null), $iFeedPage);
			}
		}
		/*
		else
		{
			$aRows = Phpfox::getService('feed')->callback($aFeedCallback)->get(($bIsProfile > 0 ? $iUserId : null), ($this->request()->get('feed') ? $this->request()->get('feed') : null), $iFeedPage);
		}
		*/

		if (($this->request()->getInt('status-id') 
				|| $this->request()->getInt('comment-id') 
				|| $this->request()->getInt('link-id')
				|| $this->request()->getInt('poke-id')
				|| $this->request()->getInt('feed')
			) 
			&& isset($aRows[0]))
		{
			$aRows[0]['feed_view_comment'] = true;
			$this->setParam('aFeed', array_merge(array('feed_display' => 'view', 'total_like' => $aRows[0]['feed_total_like']), $aRows[0]));                        
		}	
		
		(($sPlugin = Phpfox_Plugin::get('feed.component_block_display_process')) ? eval($sPlugin) : false);		
		
		if ($bIsCustomFeedView && !count($aRows) && $bIsProfile)
		{
			$aUser = $this->getParam('aUser');
			
			$this->url()->send($aUser['user_name'], null, Phpfox::getPhrase('feed.the_activity_feed_you_are_looking_for_does_not_exist'));
		}
		
		$iUserid = ($bIsProfile > 0 ? $iUserId : null);
		$iTotalFeeds = (int) Phpfox::getComponentSetting(($iUserid === null ? Phpfox::getUserId() : $iUserid), 'feed.feed_display_limit_' . ($iUserid !== null ? 'profile' : 'dashboard'), Phpfox::getParam('feed.feed_display_limit'));

		/*	
		if (isset($sActivityFeedHeader))
		{
			$this->template()->assign(array(
					'sHeader' => $sActivityFeedHeader
				)
			);
		}
		*/
		
		$aUserLocation = Phpfox::getUserBy('location_latlng');
		if (!empty($aUserLocation))
		{
			$this->template()->assign(array('aVisitorLocation' => json_decode($aUserLocation, true)));
		}
		$bLoadCheckIn = false;
		if (!defined('PHPFOX_IS_PAGES_VIEW') && Phpfox::getParam('feed.enable_check_in') && (Phpfox::getParam('core.ip_infodb_api_key') || Phpfox::getParam('core.google_api_key') ) )
		{
			$bLoadCheckIn = true;
		}

		$oFeed = Phpfox::getService('feed');
		foreach ($aRows as $iKey => $aRow)
		{
			if (!isset($aRow['feed_like_phrase']))
			{
				if(Phpfox::isModule('like'))
				{
					$aRows[$iKey]['feed_like_phrase'] = $oFeed->getPhraseForLikes($aRow);
				}
			}
		}

		$bIsHashTagPop = ($this->request()->get('hashtagpopup') ? true : false);
		if ($bIsHashTagPop)
		{
			define('PHPFOX_FEED_HASH_POPUP', true);
		}
		
		// http://www.phpfox.com/tracker/view/15392/
		$sIsHashTagSearchValue = urldecode(strip_tags((($this->request()->get('hashtagsearch') ? $this->request()->get('hashtagsearch') : ($this->request()->get('req1') == 'hashtag' ? $this->request()->get('req2') : '')))));
		if(preg_match_all('/[0-9]+/', $sIsHashTagSearchValue, $aMatches))
		{
			$sIsHashTagSearchValue = '';
			foreach($aMatches[0] as $sMatch)
			{
				$sIsHashTagSearchValue .= preg_replace('/[0-9]+/', '&#$0;', $sMatch);
			}
		}

		$this->template()->assign(array(
				'bForceReloadOnPage' => $bForceReloadOnPage,				
				'bHideEnterComment' => true,
				'aFeeds' => $aRows,
				'iFeedNextPage' => ($bForceReloadOnPage ? 0 : ($iFeedPage + 1)),
				'iFeedCurrentPage' => $iFeedPage,
				'iTotalFeedPages' => 1,
				'aFeedVals' => $this->request()->getArray('val'),
				'sCustomViewType' => $sCustomViewType,
				'aFeedStatusLinks' => Phpfox::getService('feed')->getShareLinks(),
				'aFeedCallback' => $aFeedCallback,
				'bIsCustomFeedView' => $bIsCustomFeedView,
				'sTimelineYear' => $this->request()->get('year'),
				'sTimelineMonth' => $this->request()->get('month'),
				'iFeedUserSortOrder' => Phpfox::getUserBy('feed_sort'),
				'bLoadCheckIn' => $bLoadCheckIn,
				'bForceFormOnly' => $bForceFormOnly,
				'sIsHashTagSearch' => urlencode(strip_tags((($this->request()->get('hashtagsearch') ? $this->request()->get('hashtagsearch') : ($this->request()->get('req1') == 'hashtag' ? $this->request()->get('req2') : ''))))),
				'sIsHashTagSearchValue' => $sIsHashTagSearchValue,
				'bIsHashTagPop' => $bIsHashTagPop
			)
		);	
		
		if (Phpfox::getParam('video.convert_servers_enable') && !PHPFOX_IS_AJAX)
		{
			$aVideoServers = Phpfox::getParam('video.convert_servers');
			$sCustomServerUrl = $aVideoServers[rand(0, (count($aVideoServers) - 1))];
			$this->template()->assign('sVideoServerUrl', $sCustomServerUrl);
			$this->template()->assign('sCustomVideoHash', Phpfox::getService('video')->addCustomHash());
		}		
		
		if (Phpfox::getService('profile')->timeline())
		{
			$aFeedTimeline = Phpfox::getService('feed')->getTimeline();
			
			if (($this->request()->getInt('status-id') 
				|| $this->request()->getInt('comment-id') 
				|| $this->request()->getInt('link-id')
				|| $this->request()->getInt('poke-id')
				|| $this->request()->getInt('feed')
			) && isset($aRows[0]))
			{
				$aFeedTimeline['left'][0]['feed_view_comment'] = true;
			}
			
			$this->template()->assign(array(
					'aFeedTimeline' => $aFeedTimeline,
					'sLastDayInfo' => Phpfox::getService('feed')->getLastDay()
				)
			);
			
			if (!PHPFOX_IS_AJAX)
			{
				$aUser = $this->getParam('aUser');
				if( $aUser['birthday'] == null)
				{
					$aTimeline = Phpfox::getService('feed')->getTimeLineYears($aUser['user_id'], $aUser['joined']);
				}
				else
				{
					$aTimeline = Phpfox::getService('feed')->getTimeLineYears($aUser['user_id'], $aUser['birthday_search']);
				}
				
				$this->template()->assign(array(
						'aTimelineDates' => $aTimeline
					)
				);
			}
		}
		/*
		if ($bIsProfile)
		{			
			if (!Phpfox::getService('user.privacy')->hasAccess($iUserId, 'feed.display_on_profile'))
			{
				return false;
			}			
		}
		*/	
		return 'block';
	}

	public function clean()
	{
		$this->template()->clean(array(
				'sHeader',
				'aFeeds',
				'sBoxJsId'
			)
		);
	}	
}

?>
