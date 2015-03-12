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
 * @version 		$Id: process.class.php 6876 2013-11-12 10:48:57Z Miguel_Espinoza $
 */
class Tag_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('tag');
	}
	
	public function add($sType, $iItemId, $iUserId, $sTags, $bHashTags = false)
	{			
		$oFilter = Phpfox::getLib('parse.input');
		if ($bHashTags)
		{
			$aTags = Phpfox::getLib('parse.output')->getHashTags($sTags);
		}
		else
		{
			Phpfox::getService('ban')->checkAutomaticBan($sTags);
			$aTags = explode(',', $sTags);
		}

		$aCache = array();
		foreach ($aTags as $sTag)
		{
			$sTag = trim($sTag);
			
			if (empty($sTag))
			{
				continue;
			}
			
			if (isset($aCache[$sTag]))
			{
				continue;
			}
			
			$this->database()->insert(Phpfox::getT('tag'), array(
					'item_id' => $iItemId,
					'category_id' => $sType,
					'user_id' => $iUserId,
					'tag_text' => $oFilter->clean($sTag, 255),
					'tag_url' => $oFilter->cleanTitle($sTag),
					'added' => PHPFOX_TIME
				)
			);
			
			$aCache[$sTag] = true;
		}		
	}
	
	/**
	 * 
	 *
	 * @param unknown_type $sType
	 * @param unknown_type $iItemId
	 * @param unknown_type $sTags
	 * @return unknown
	 */	
	public function update($sType, $iItemId, $iUserId, $sTags = null, $bHashTags = false)
	{
		if ($sTags !== null)
		{
			/* Since tags are unique to each item it should be safe to delete every tag
			 * belonging to one item and add the new ones
			 */
            $this->database()->delete(Phpfox::getT('tag'), 'item_id = ' . (int)$iItemId . ' AND category_id = \'' . $this->database()->escape($sType) . '\' AND user_id = ' . (int)$iUserId);

			return $this->add($sType, $iItemId, $iUserId, $sTags, $bHashTags);
                    
			// get the tags for this item
			$aCurrentTags = $this->database()
					->select('*')
					->from(Phpfox::getT('tag'))
					->where('item_id = ' . (int)$iItemId . ' AND category_id = \'' . $this->database()->escape($sType) .'\' AND user_id = ' . (int)$iUserId)
					->execute('getSlaveRows');

				// loop through the tags to see which ones do we need to delete
			$aDelete = array();
			foreach ($aCurrentTags as $iKey => $aTag)
			{

				if (strpos($sTags, $aTag['tag_text']) !== false)// if the tag that the user entered is already in the database, skip
				{
					// we remove it because its already added
					$sTags = str_replace($aTag['tag_text'], '', $sTags);
					continue;
				}

				// tag was modified, we add to the delete
				$aDelete[] = $aTag['tag_id'];
				// and we remove it from the sTags so it doesnt get added twice
				$sTags = str_replace($aTag['tag_text'], '', $sTags);
			}
			// now delete the tags that are in aDelete
			if (!empty($aDelete))
			{
				$sDelete = '';
				foreach ($aDelete as $aTag)
				{
					$sDelete .= $aTag['tag_id'] . ',';
				}
				$sDelete = rtrim($sDelete,',');
				$this->database()->delete(Phpfox::getT('tag'), 'tag_id IN ('.$sDelete.')');
			}
			$this->add($sType, $iItemId, $iUserId, $sTags);
		}
		else
		{
			// just delete every tag
			$this->database()->delete(Phpfox::getT('tag'), "item_id = " . (int) $iItemId . " AND category_id = '" . $this->database()->escape($sType) . "' AND user_id = " . (int) $iUserId);
		}
		
		$this->cache()->remove('tag', 'substr');
		
		return true;
	}
	
	public function deleteForItem($iUserId, $iItemId, $sCategory)
	{		
		$this->database()->delete($this->_sTable, "item_id = " . $iItemId . " AND category_id = '" . $this->database()->escape($sCategory) . "'");		
		
		$this->cache()->remove('tag', 'substr');
		
		return true;
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
		if ($sPlugin = Phpfox_Plugin::get('tag.service_process__call'))
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