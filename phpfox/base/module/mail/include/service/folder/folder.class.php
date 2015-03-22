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
 * @version 		$Id: folder.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Mail_Service_Folder_Folder extends Phpfox_Service 
{
	private $_aFolders = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('mail_folder');	
	}
	
	public function get()
	{
		$this->_getCache();
		
		if (!is_array($this->_aFolders))
		{
			return array();
		}
		
		return $this->_aFolders;
	}
	
	public function getFolder($iId)
	{
		$this->_getCache();
		
		return (isset($this->_aFolders[$iId]) ? $this->_aFolders[$iId] : false);
	}
	
	public function reachedLimit()
	{
		if ($this->database()->select('COUNT(*)')->from($this->_sTable)->where('user_id = ' .  Phpfox::getUserId())->execute('getField') >= Phpfox::getUserParam('mail.total_folders'))
		{
			return true;
		}
		
		return false;
	}

	public function isFolder($sName)
	{
		$aRows = $this->database()->select('lp.text')
			->from(Phpfox::getT('language'), 'l')
			->join(Phpfox::getT('module'), 'm', "m.module_id = 'mail'")
			->join(Phpfox::getT('language_phrase'), 'lp', "lp.module_id = m.module_id AND lp.language_id = l.language_id AND lp.var_name = 'inbox'")			
			->execute('getSlaveRows');
			
		foreach ($aRows as $aRow)
		{
			if ($sName == $aRow['text'])
			{
				return true;
			}
		}		
		
		return ($this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where("name = '" . $this->database()->escape(Phpfox::getLib('parse.input')->clean($sName, 255)) . "' AND user_id = " . Phpfox::getUserId())
			->execute('getField') ? true : false);
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
		if ($sPlugin = Phpfox_Plugin::get('mail.service_folder_folder__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
	
	private function _getCache()
	{
		$oCache = Phpfox::getLib('cache');
		$sCacheId = $oCache->set('user_mail_folder_' . Phpfox::getUserId());
		if (!($this->_aFolders = $oCache->get($sCacheId)))
		{
			$aFolders = $this->database()->select('mf.folder_id, mf.name')
				->from($this->_sTable, 'mf')
				->where('mf.user_id = ' . Phpfox::getUserId())
				->order('mf.name ASC')
				->execute('getSlaveRows');
			foreach ($aFolders as $aFolder)
			{
				$this->_aFolders[$aFolder['folder_id']] = $aFolder;
			}
			$oCache->save($sCacheId, $this->_aFolders);
		}
	}
}

?>