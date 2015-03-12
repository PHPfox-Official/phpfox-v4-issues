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
 * @package  		Module_Tag
 * @version 		$Id: tag.class.php 6277 2013-07-16 12:59:34Z Raymond_Benc $
 */
class Tag_Service_Tag extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('tag');
	}
	
	public function get($sCategory, $sTag, $aConds = array(), $sSort = '', $iPage = '', $sLimit = '')
	{
		return Phpfox::callback($sCategory . '.getTags', $sTag, $aConds, $sSort, $iPage, $sLimit);
	}
	
	public function getSearch($sCategory, $aConds = array(), $sSort)
	{		
		return Phpfox::callback($sCategory . '.getTagSearch', $aConds, $sSort);
	}	
	
	public function getTagInfo($sModule, $sTag)
	{
		$aRow = $this->database()->select('*, COUNT(item_id) AS total')
			->from(Phpfox::getT('tag'))
			->where('category_id = \'' . $this->database()->escape($sModule) . '\' AND tag_url = \'' . $this->database()->escape($sTag) . '\'')
			->group('tag_id')
			->execute('getSlaveRow');
			
		return (isset($aRow['tag_id']) ? $aRow : false);
	}
	
	public function getTagsById($sCategory, $sId)
	{		
		if (!$sId)
		{
			return array();
		}
		
		$aRows = $this->database()->select('tag_id, item_id, tag_text, tag_url')
			->from(Phpfox::getT('tag'))
			->where("item_id " . (is_numeric($sId) ? ' = ' . (int) $sId : "IN(" . $sId . ")") . " AND category_id = '" . $this->database()->escape($sCategory) . "'")
			->order('tag_id ASC')
			->execute('getSlaveRows');
			
		$aTags = array();
		foreach ($aRows as $aRow)
		{
			$aTags[$aRow['item_id']][] = $aRow;
		}		
					
		return $aTags;
	}	
	
	public function getForEdit($sCategory, $iId)
	{
		$sList = '';		
		$aTags = Phpfox::getService('tag')->getTagsById($sCategory, $iId);		
		
		if (isset($aTags[$iId]))
		{					
			foreach ($aTags[$iId] as $aTag)
			{
				$sList .= ' ' . $aTag['tag_text'] . ',';	
			}
			$sList = trim(trim($sList, ','));
		}	
				
		return $sList;
	}
	
	public function getTagCloud($sCategory, $iUserId = null, $mMaxDisplay = null)
	{		
		(($sPlugin = Phpfox_Plugin::get('tag.service_tag_gettagcloud_start')) ? eval($sPlugin) : false);
		
		if ($sCategory === null)
		{
			$aParams = Phpfox::massCallback('getTagCloud');
		}
		else 
		{
			$aParams = Phpfox::callback($sCategory . '.getTagCloud');
		}
				
		$aTempTags = array();
		$sCacheId = $this->cache()->set('tag_cloud_' . ($sCategory === null ? 'global' : str_replace('/', '_', $aParams['link']))	 . ($iUserId !== null ? '_' . $iUserId : '') . (defined('TAG_ITEM_ID') ? '_' . TAG_ITEM_ID : '') );
		
		if (defined('PHPFOX_IS_GROUP_INDEX'))
		{
			$sCategory = 'video_group';
		}
		
		if (!($aTempTags = $this->cache()->get($sCacheId, Phpfox::getParam('tag.tag_cache_tag_cloud'))))
		{
			$aWhere = array();
			
			if (defined('TAG_ITEM_ID'))
			{
				$aWhere[] = 'AND item_id = ' . (int)TAG_ITEM_ID;
			}
			
			if ($sCategory !== null)
			{
				$aWhere[] = "AND category_id = '" . $this->database()->escape($aParams['category']) . "'" . ($iUserId !== null ? ' AND user_id = ' . (int) $iUserId : '');
			}
			
			if (!defined('TAG_ITEM_ID'))
			{
				$aWhere[] = 'AND added > ' . (PHPFOX_TIME - (86400 * Phpfox::getParam('tag.tag_days_treading')));
			}
			
			$aRows = $this->database()->select('category_id, tag_text AS tag, tag_url, COUNT(item_id) AS total')
				->from(Phpfox::getT('tag'))		
				->where($aWhere)		
				->group('tag_text, tag_url')
				->having('total > ' . (int) Phpfox::getParam('tag.tag_min_display'))
				->order('total DESC')
				->limit(Phpfox::getParam('tag.tag_trend_total_display'))
				->execute('getSlaveRows');				
			
			if (!count($aRows))
			{
				return array();
			}		
			
			if ($sCategory === null)
			{
				$aParams['link'] = 	'search';
			}			

			$aTempTags = array();
			foreach ($aRows as $aRow)
			{				
	            $aTempTags[] = array
				(
	                'value' => $aRow['total'],
	                'key' => $aRow['tag'],
	                'url' => $aRow['tag_url'],
	            	'link' => (($sCategory === null && Phpfox::getParam('tag.enable_hashtag_support')) ? Phpfox::getLib('url')->makeUrl('hashtag', array($aRow['tag_url'])) : Phpfox::getLib('url')->makeUrl($aParams['link'], array('tag', $aRow['tag_url'])))
				);				
			}
			
			if (!count($aTempTags))
			{
				return array();
			}		
	
	        $this->cache()->save($sCacheId, $aTempTags);
		}	
		
		(($sPlugin = Phpfox_Plugin::get('tag.service_tag_gettagcloud_end')) ? eval($sPlugin) : false);
		
		return $aTempTags;
	}
	
	public function getInlineSearchForUser($iUserId, $sTag, $sCategory)
	{		
		(($sPlugin = Phpfox_Plugin::get('tag.service_tag_getinlinesearchforuser_start')) ? eval($sPlugin) : false);
		
		$aTags = array();
		$aRows = $this->database()->select('tag.tag_text')
			->from($this->_sTable, 'tag')
			->where("tag.category_id = '" . $this->database()->escape($sCategory) . "' AND tag.user_id = " . $iUserId . " AND tag.tag_text LIKE '%" . $this->database()->escape($sTag) . "%'")
			->limit(0, 5)
			->execute('getSlaveRows');
			
		foreach ($aRows as $aRow)
		{
			if (isset($aTags[$aRow['tag_text']]))
			{
				continue;
			}
			$aTags[$aRow['tag_text']]['tag_text'] = $aRow['tag_text'];
		}		
		unset($aRows);
			
		(($sPlugin = Phpfox_Plugin::get('tag.service_tag_getinlinesearchforuser_end')) ? eval($sPlugin) : false);
		
		return $aTags;		
	}
	
	public function hasAccess($sType, $iId, $sUserPerm, $sGlobalPerm)
	{		
		(($sPlugin = Phpfox_Plugin::get('tag.service_tag_hasaccess_start')) ? eval($sPlugin) : false);
		
		$aRow = $this->database()->select('u.user_id')
			->from($this->_sTable, 'tag')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = tag.user_id')
			->where("tag.item_id = " . (int) $iId . " AND tag.category_id = '" . $this->database()->escape($sType) . "'")
			->execute('getSlaveRow');
			
		(($sPlugin = Phpfox_Plugin::get('tag.service_tag_hasaccess_end')) ? eval($sPlugin) : false);		

		if (!isset($aRow['user_id']))
		{
			return false;
		}
		
		if ((Phpfox::getUserId() == $aRow['user_id'] && Phpfox::getUserParam('tag.' . $sUserPerm)) || Phpfox::getUserParam('tag.' . $sGlobalPerm))
		{
			return $aRow['user_id'];
		}
		
		return false;
	}	
	
	public function getCount($mTags)
	{		
		$iTagCount = 0;
		
		if (is_array($mTags))
		{
			foreach ($mTags as $sTag)
			{
				if (empty($sTag))
				{
					continue;
				}						
				$iTagCount++;
			}
		}
		else 
		{
			$iTagCount = count(explode(',', rtrim($mTags, ',')));
		}
			
		return $iTagCount;		
	}
	
	/**
	 * Returns the keywords used in a <meta> keyword call.
	 *
	 * @param array $aTags Is the array of tags
	 * @deprecated Use self::getTags() instead
	 * 
	 * @return string New string of tags seperated with a comma
	 */
	public function getKeywords($aTags)
	{
		$sTags = '';
		foreach ($aTags as $aTag)
		{
			$sTags .= $aTag['tag_text'] . ', ';
		}
		$sTags = rtrim(trim($sTags), ',');
		
		return Phpfox::getLib('parse.output')->clean($sTags);
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
		if ($sPlugin = Phpfox_Plugin::get('tag.service_tag__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>