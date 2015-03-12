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
 * @version 		$Id: process.class.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
class Attachment_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{		
		$this->_sTable = Phpfox::getT('attachment');
	}
	
	public function add($aVals)
	{		
		$aVals = array_merge($aVals, array(
				'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')
			)
		);
		
		$aInsert = array(
			'category_id' => $aVals['category'],
			'link_id' => (isset($aVals['link_id']) ? (int) $aVals['link_id'] : 0),
			'user_id' => Phpfox::getUserId(),
			'time_stamp' => PHPFOX_TIME,
			'file_name' => (empty($aVals['file_name']) ? null : $aVals['file_name']),
			'extension' => (empty($aVals['extension']) ? null : $aVals['extension']),
			'is_image' => ((isset($aVals['is_image']) && $aVals['is_image']) ? 1 : 0),
			'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')
		);

		$iId = $this->database()->insert(Phpfox::getT('attachment'), $aInsert);

		// Update user activity
		Phpfox::getService('user.activity')->update(Phpfox::getUserId(), 'attachment');
		
		(($sPlugin = Phpfox_Plugin::get('attachment.service_process_add')) ? eval($sPlugin) : false);
		
		return $iId;
	}
	
	public function update($aVals, $iId)
	{
		return $this->database()->update(Phpfox::getT('attachment'), $aVals, "attachment_id = " . $iId);
	}	
	
	public function updateItemId($sId, $iUserId, $iItemId)
	{
		$aIds = explode(',', $sId);
		foreach ($aIds as $iId)
		{
			$iId = trim($iId);
			if (empty($iId) || !is_numeric($iId))
			{
				continue;
			}
			
			$aAttachment = $this->database()->select('*')
				->from(Phpfox::getT('attachment'))
				->where('attachment_id = ' . (int) $iId)
				->execute('getSlaveRow');
			
			$this->database()->update(Phpfox::getT('attachment'), array('item_id' => $iItemId), "attachment_id = " . $iId . " AND user_id = " . $iUserId . "");
			
			$this->updateItemCount($aAttachment['category_id'], $iId, '+');
		}
	}
	
	public function updateDescription($iId, $iUserId, $sDescription)
	{		
		$this->database()->update(Phpfox::getT('attachment'), array('description' => Phpfox::getLib('parse.input')->clean($sDescription, 255)), "attachment_id = " . $iId . " AND user_id = " . $iUserId . "");
		
		return true;
	}
	
	public function updateCounter($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('attachment.service_process_updatecounter')) ? eval($sPlugin) : false);
		
		$this->database()->query("
			UPDATE " . $this->_sTable . "
			SET counter = counter + 1
			WHERE attachment_id = " . $iId . "
		");
		
		return true;
	}
	
	public function updateInline($iId, $bRemove = false)
	{
		(($sPlugin = Phpfox_Plugin::get('attachment.service_process_updateinline')) ? eval($sPlugin) : false);
		
		$this->database()->update($this->_sTable, array('is_inline' => ($bRemove ? 0 : 1)), 'attachment_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId());
		
		return true;
	}
	
	/**
	 * @todo Need to lower the total_attachment for items once it has been deleted.
	 *
	 * @param unknown_type $iUserId
	 * @param unknown_type $iItemId
	 * @param unknown_type $sCategory
	 * @return unknown
	 */
	public function deleteForItem($iUserId = null, $iItemId, $sCategory)
	{		
		$aRows = $this->database()->select('user_id, attachment_id, destination, server_id')
			->from($this->_sTable)
			->where("item_id = " . $iItemId . " AND category_id = '" . $this->database()->escape($sCategory) . "'". ($iUserId !== null ? " AND user_id = " . $iUserId . "" : ''))
			->execute('getRows');
		
		if (!count($aRows))
		{
			return false;
		}
		
		$aFileSizes = array();
		foreach ($aRows as $aRow)
		{
			$sThumbnail = Phpfox::getParam('core.dir_attachment') . sprintf($aRow['destination'], '_thumb');
			$sViewImage = Phpfox::getParam('core.dir_attachment') . sprintf($aRow['destination'], '_view');
			$sActualImage = Phpfox::getParam('core.dir_attachment') . sprintf($aRow['destination'], '');
			
			if (!isset($aFileSizes[$aRow['user_id']]))
			{
				$aFileSizes[$aRow['user_id']] = 0;
			}
			
			if(Phpfox::getParam('core.allow_cdn') && $aRow['server_id'] > 0)
		    {
				$aFilesToDelete = array($sThumbnail, $sViewImage, $sActualImage);
				foreach($aFilesToDelete as $sFilePath)
				{
					// Get the file size stored when the photo was uploaded
					$sTempUrl = Phpfox::getLib('cdn')->getUrl(str_replace(Phpfox::getParam('core.dir_attachment'), Phpfox::getParam('core.url_attachment'), $sFilePath));
					
					$aHeaders = get_headers($sTempUrl, true);
					if(preg_match('/200 OK/i', $aHeaders[0]))
					{
						$aFileSizes[$aRow['user_id']] += (int) $aHeaders["Content-Length"];
					}
					
					Phpfox::getLib('cdn')->remove($sFilePath);
				}
		    }
		    else
		    {				
				if (file_exists($sThumbnail))
				{
					$aFileSizes[$aRow['user_id']] += filesize($sThumbnail);
					Phpfox::getLib('file')->unlink($sThumbnail);
				}
				
				if (file_exists($sViewImage))
				{
					$aFileSizes[$aRow['user_id']] += filesize($sViewImage);
					Phpfox::getLib('file')->unlink($sViewImage);
				}

				if (file_exists($sActualImage))
				{
					$aFileSizes[$aRow['user_id']] += filesize($sActualImage);
					Phpfox::getLib('file')->unlink($sActualImage);
				}
			}
			
			// Delete attachments for this specific item and category
			$this->database()->delete($this->_sTable, 'attachment_id = ' . $aRow['attachment_id']);
			
			// Update user activity
			Phpfox::getService('user.activity')->update($aRow['user_id'], 'attachment', '-');	
		}
		
		foreach ($aFileSizes as $iUserId => $iFileSizes)
		{
			Phpfox::getService('user.space')->update($iUserId, 'attachment', $iFileSizes, '-');			
		}		
		
		(($sPlugin = Phpfox_Plugin::get('attachment.service_process_deleteforitem')) ? eval($sPlugin) : false);
	}
	
	public function delete($iUserId, $iId)
	{
		$aRow = $this->database()->select('*')
			->from($this->_sTable)
			->where('attachment_id = ' . (int) $iId . ' AND user_id = ' . (int) $iUserId)
			->execute('getRow');
		
		if (!empty($aRow['destination']))
		{
			$iFileSizes = 0;
			$sThumbnail = Phpfox::getParam('core.dir_attachment') . sprintf($aRow['destination'], '_thumb');
			$sViewImage = Phpfox::getParam('core.dir_attachment') . sprintf($aRow['destination'], '_view');
			$sActualImage = Phpfox::getParam('core.dir_attachment') . sprintf($aRow['destination'], '');
			
			if(Phpfox::getParam('core.allow_cdn') && $aRow['server_id'] > 0)
		    {		
				$aFilesToDelete = array($sThumbnail, $sViewImage, $sActualImage);
				foreach($aFilesToDelete as $sFilePath)
				{
					// Get the file size stored when the photo was uploaded
					$sTempUrl = Phpfox::getLib('cdn')->getUrl(str_replace(Phpfox::getParam('core.dir_attachment'), Phpfox::getParam('core.url_attachment'), $sFilePath));
					
					$aHeaders = get_headers($sTempUrl, true);
					if(preg_match('/200 OK/i', $aHeaders[0]))
					{
						$iFileSizes += (int) $aHeaders["Content-Length"];
					}
					
					Phpfox::getLib('cdn')->remove($sFilePath);
				}
		    }
		    else
		    {
				if (file_exists($sThumbnail))
				{
					$iFileSizes += filesize($sThumbnail);
					Phpfox::getLib('file')->unlink($sThumbnail);
				}
				
				if (file_exists($sViewImage))
				{
					$iFileSizes += filesize($sViewImage);
					Phpfox::getLib('file')->unlink($sViewImage);
				}

				if (file_exists($sActualImage))
				{
					$iFileSizes += filesize($sActualImage);
					Phpfox::getLib('file')->unlink($sActualImage);
				}
			}
			
			$this->updateItemCount($aRow['category_id'], $aRow['attachment_id'], '-');
			
			$this->database()->delete($this->_sTable, "attachment_id = " . $aRow['attachment_id'] . "");		
			
			// Update user space usage
			if ($iFileSizes > 0)
			{
				Phpfox::getService('user.space')->update($iUserId, 'attachment', $iFileSizes, '-');			
			}			
			
			Phpfox::getService('user.activity')->update($iUserId, 'attachment', '-');			
			
			(($sPlugin = Phpfox_Plugin::get('attachment.service_process_delete')) ? eval($sPlugin) : false);
			
			return true;
		}	
		
		return false;
	}
	
	public function updateItemCount($iCategory, $iId, $sType = '+')
	{		
		if (!Phpfox::hasCallback($iCategory, 'getAttachmentField'))
		{
			return false;
		}
		
		list($sTable, $sField) = Phpfox::callback($iCategory . '.getAttachmentField');
		if ($sField === false)
		{
			return false;
		}
		(($sPlugin = Phpfox_Plugin::get('attachment.service_process_updateitemcount_category')) ? eval($sPlugin) : false);
	
		$aRow = $this->database()->select("t.{$sField}, t.total_attachment")
			->from($this->_sTable, 'a')
			->leftJoin(Phpfox::getT($sTable), 't', "t.{$sField} = a.item_id")
			->where("a.attachment_id = " . (int) $iId . "")
			->execute('getRow');
			
		if (!isset($aRow[$sField]))
		{
			return false;
		}
		
		$iCnt = $aRow['total_attachment'];
		if ($sType == '+')
		{
			$iCnt = ($iCnt + 1);
		}
		else 
		{
			$iCnt = ($iCnt - 1);
			if ($iCnt < 0)
			{
				$iCnt = 0;
			}
		}		

		$this->database()->query("
			UPDATE " . Phpfox::getT($sTable) . "
			SET total_attachment = {$iCnt}
			WHERE {$sField} = {$aRow[$sField]}
		");
		
		(($sPlugin = Phpfox_Plugin::get('attachment.service_process_updateitemcount')) ? eval($sPlugin) : false);
		
		return true;
	}
	
	public function updateActivity($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);		
	
		$this->database()->update(Phpfox::getT('attachment_type'), array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'extension = \'' . $iId . '\'');
		
		$this->cache()->remove('attachment_type');
	}	
	
	public function addType($aVals, $sExt = null)
	{
		$aForm = array(
			'extension' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('attachment.provide_an_extension')
			),
			'mime_type' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('attachment.provide_a_mime_type')
			),
			'is_image' => array(
				'type' => 'int:required'
			),
			'is_active' => array(
				'type' => 'int:required'
			)
		);
		
		$aVals = $this->validator()->process($aForm, $aVals);
		if (strpos($aVals['extension'], '.') !== false)
		{
			Phpfox_Error::set(Phpfox::getPhrase('admincp.invalid_file_extension'));
		}
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}
		
		$iOldType = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('attachment_type'))
			->where('extension = \'' . $this->database()->escape($aVals['extension']) . '\' AND mime_type = \''.$aVals['mime_type'].'\'')
			->execute('getField');
			
		if ($iOldType)
		{
			return Phpfox_Error::set(Phpfox::getPhrase('attachment.this_extension_already_exists'));
		}
		
		if ($sExt === null)
		{
			$aVals['added'] = PHPFOX_TIME;
			
			$this->database()->insert(Phpfox::getT('attachment_type'), $aVals);
		}
		else 
		{
			$this->database()->update(Phpfox::getT('attachment_type'), $aVals, 'extension = \'' . $this->database()->escape($sExt) . '\'');
		}
		
		$this->cache()->remove('attachment_type');
		
		return true;
	}
	
	public function updateType($sExt, $aVals)
	{
		return $this->addType($aVals, $sExt);
	}
	
	public function deleteType($sExt)
	{
		$this->database()->delete(Phpfox::getT('attachment_type'), 'extension = \'' . $this->database()->escape($sExt) . '\'');
		
		$this->cache()->remove('attachment_type');
		
		return true;
	}
	
	public function process($aAttachments, $iUserId, $iItemId)
	{
		$sAttachmentType = '';
		if (isset($aAttachments['link']))
		{
			$sAttachmentType = 'link';	
		}
		/*
		if (!empty($sAttachmentType))
		{
			$this->database()->insert($this->_sTable, array(
					''
				)
			);
		}
		*/
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
		if ($sPlugin = Phpfox_Plugin::get('attachment.service_process__call'))
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
