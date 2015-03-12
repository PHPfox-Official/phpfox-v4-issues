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
 * @package  		Module_Attachment
 * @version 		$Id: attachment.class.php 7033 2014-01-09 19:39:28Z Fern $
 */
class Attachment_Service_Attachment extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('attachment');
		
		(($sPlugin = Phpfox_Plugin::get('attachment.service_attachment___construct')) ? eval($sPlugin) : false);
	}	
	
	public function get($aConds, $sSort = 'attachment.time_stamp DESC', $iRange = '', $sLimit = '', $bCount = true)
	{		
		$iCnt = 0;
		$aItems = array();
		if ($bCount)
		{
			(($sPlugin = Phpfox_Plugin::get('attachment.service_attachment_get_count')) ? eval($sPlugin) : false);
			
			$iCnt = $this->database()->select('COUNT(*)')
				->from($this->_sTable, 'attachment')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = attachment.user_id')
				->where($aConds)
				->execute('getField');				
		}
		
		// if ($iCnt)
		{		
			(($sPlugin = Phpfox_Plugin::get('attachment.service_attachment_select')) ? eval($sPlugin) : false);
			
			$aItems = $this->database()->select('attachment.*')
				->from($this->_sTable, 'attachment')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = attachment.user_id')
				->where($aConds)
				->order($sSort)
				->limit($iRange, $sLimit)
				->execute('getRows');	

			foreach ($aItems as $iKey => $aItem)
			{
				$aItems[$iKey]['url'] = str_replace('%s', '', $aItem['destination']);
				
				if ($aItem['is_video'])
				{
					$aItems[$iKey]['video_image_destination'] = substr_replace($aItem['destination'], '%s.jpg', -4);
				}
			}
		}		
		
		return array($iCnt, $aItems);
	}
	
	public function getForItemEdit($iItemId, $sCategory, $iUserid = null)
	{
		(($sPlugin = Phpfox_Plugin::get('attachment.service_attachment_getforitemedit_start')) ? eval($sPlugin) : false);
		
		$aRows = $this->database()->select('attachment_id')
			->from($this->_sTable)
			->where("item_id = " . (int) $iItemId . " AND category_id = '" . $this->database()->escape($sCategory) . "' AND user_id = " . $iUserid)
			->execute('getRows');
			
		if (!count($aRows))
		{
			return '';
		}
			
		$aAttachments = array();
		foreach ($aRows as $aRow)
		{
			$aAttachments[] = $aRow['attachment_id'];
		}	
			
		(($sPlugin = Phpfox_Plugin::get('attachment.service_attachment_getforitemedit_end')) ? eval($sPlugin) : false);
			
		return implode(',', $aAttachments) . ',';
	}
	
	public function getForDownload($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('attachment.service_attachment_getfordownload')) ? eval($sPlugin) : false);

		$aRow = $this->database()->select('attachment.*, attachment_type.mime_type')
			->from($this->_sTable, 'attachment')
			->leftjoin(Phpfox::getT('attachment_type'), 'attachment_type', 'attachment_type.extension = attachment.extension')
			->where('attachment.attachment_id = ' . (int) $iId)
			->execute('getSlaveRow');		
		
		return $aRow;
	}
	
	public function getCount($sAttachments)
	{
		return 0;		
	}
	
	public function getCountForItem($iItemId, $sCategory)
	{
		return $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where("item_id = " . (int) $iItemId . " AND category_id = '" . $this->database()->escape($sCategory) . "'")
			->execute('getSlaveField');
	}
	
	public function verify($sIds)
	{
		if (empty($sIds))
		{
			return array();
		}
		
		$aRows = $this->database()->select('attachment.attachment_id, attachment.destination, attachment.extension, attachment.server_id, attachment.is_inline, attachment.is_image, attachment.is_video')
			->from($this->_sTable, 'attachment')
			->where('attachment.attachment_id IN(' . $sIds . ') AND user_id = ' . Phpfox::getUserId() . '')
			->execute('getRows');

		$aIds = array();
		foreach ($aRows as $aRow)
		{			
			$aRow['video_image_destination'] = substr_replace($aRow['destination'], '%s.jpg', -4);
			$aIds[$aRow['attachment_id']] = $aRow;			
		}
			
		return $aIds;
	}
	
	public function getTotal($iUserId = null)
	{				
		return $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('user_id = ' . ($iUserId === null ? Phpfox::getUserId() : (int) $iUserId))
			->execute('getField');	
	}
	
	public function isAllowed($iUserId = null)
	{
		if ($this->getTotal($iUserId) < Phpfox::getUserParam('attachment.attachment_limit'))
		{
			return true;
		}
		
		return false;
	}
	
	public function hasAccess($iId, $sUserPerm, $sGlobalPerm)
	{
		(($sPlugin = Phpfox_Plugin::get('attachment.service_attachment_hasaccess_start')) ? eval($sPlugin) : false);
		
		$aRow = $this->database()->select('u.user_id')
			->from($this->_sTable, 'a')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = a.user_id')
			->where('a.attachment_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		(($sPlugin = Phpfox_Plugin::get('attachment.service_attachment_hasaccess_end')) ? eval($sPlugin) : false);

		if (!isset($aRow['user_id']))
		{
			return false;
		}
		
		if ((Phpfox::getUserId() == $aRow['user_id'] && Phpfox::getUserParam('attachment.' . $sUserPerm)) || Phpfox::getUserParam('attachment.' . $sGlobalPerm))
		{
			return $aRow['user_id'];
		}
		
		return false;
	}	
	
	public function __call($sMethod, $aArguments)
	{
		if ($sPlugin = Phpfox_Plugin::get('attachment.service_attachment__call'))
		{
			return eval($sPlugin);
		}
		
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>
