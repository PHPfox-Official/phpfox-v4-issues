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
 * @package  		Module_Mail
 * @version 		$Id: process.class.php 3296 2011-10-12 13:29:57Z Raymond_Benc $
 */
class Mail_Service_Folder_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('mail_folder');
	}
	
	public function move($mFolder, $aIds)
	{
		foreach ($aIds as $iId)
		{
			if ($mFolder == 'trash')
			{
				Phpfox::getService('mail.process')->delete($iId);
				
				continue;			
			}
			else 
			{
				$aUpdate = array(
					'viewer_folder_id' => (int) $mFolder,
					'viewer_type_id' => '0'
				);				
			}
			
			$this->database()->update(Phpfox::getT('mail'), $aUpdate, 'mail_id = ' . (int) $iId);
		}
		
		(($sPlugin = Phpfox_Plugin::get('mail.service_folder_process_move')) ? eval($sPlugin) : false);
		
		return true;
	}
	
	public function add($sName)
	{
		if (Phpfox::getLib('parse.format')->isEmpty($sName))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('mail.provide_a_name_for_your_folder'));
		}
		
		$iId = $this->database()->insert($this->_sTable, array(
				'name' => Phpfox::getLib('parse.input')->clean($sName, 255),
				'user_id' => Phpfox::getUserId()
			)
		);
		
		$this->_clearFolderCache();
		
		(($sPlugin = Phpfox_Plugin::get('mail.service_folder_process_add')) ? eval($sPlugin) : false);
		
		return $iId;
	}
	
	public function update($aVals)
	{
		$oMailFolder = Phpfox::getService('mail.folder');
		
		foreach ($aVals['name'] as $iFolder => $sName)
		{
			if ($oMailFolder->isFolder($sName))
			{
				continue;
			}
			
			$this->database()->update($this->_sTable, array('name' => Phpfox::getLib('parse.input')->clean($sName, 255)), 'folder_id = ' . (int) $iFolder . ' AND user_id = ' . Phpfox::getUserId());
		}
		
		$this->_clearFolderCache();
		
		(($sPlugin = Phpfox_Plugin::get('mail.service_folder_process_update')) ? eval($sPlugin) : false);
		
		return true;
	}
	
	public function delete($iId)
	{
		$aRows = $this->database()->select('m.mail_id')
			->from(Phpfox::getT('mail'), 'm')
			->where('m.viewer_folder_id = ' . (int) $iId . ' AND m.viewer_user_id = ' . Phpfox::getUserId())
			->execute('getRows');
			
		foreach ($aRows as $aRow)
		{
			$this->database()->update(Phpfox::getT('mail'), array('viewer_folder_id' => 0), 'mail_id = ' . $aRow['mail_id']);
		}
		
		$this->database()->delete($this->_sTable, 'folder_id = ' . (int) $iId);
		$this->_clearFolderCache();
		
		(($sPlugin = Phpfox_Plugin::get('mail.service_folder_process_delete')) ? eval($sPlugin) : false);
		
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
		if ($sPlugin = Phpfox_Plugin::get('mail.service_folder_process__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
	
	private function _clearFolderCache()
	{
		$oCache = Phpfox::getLib('cache');
		$sCacheId = $oCache->set('user_mail_folder_' . Phpfox::getUserId());
		$oCache->remove($sCacheId);
	}
}

?>