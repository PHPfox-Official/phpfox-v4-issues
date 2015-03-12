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
 * @package  		Module_Share
 * @version 		$Id: process.class.php 6970 2013-12-04 17:11:50Z Fern $
 */
class Share_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('share_bookmark');	
	}
	
	public function add($aVals, $iEditId = null)
	{
		$aForm = array(
			'type_id' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('share.select_what_type_of_a_site_this_is')
			),
			'title' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('share.provide_a_name_for_the_site')
			),
			'url' => array(
				'type' => 'string:required',
				'message' => Phpfox::getPhrase('share.provide_a_url_for_the_site')
			),
			'is_active' => array(
				'type' => 'int:required'
			)
		);
		
		$aVals = $this->validator()->process($aForm, $aVals);
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}
		Phpfox::getService('ban')->checkAutomaticBan($aVals['title']);
		$aVals['title'] = $this->preParse()->clean($aVals['title']);		
		
		if ($iEditId === null)
		{
			$iCheck = $this->database()->select('COUNT(*)')
				->from($this->_sTable)
				->where('title = \'' . $this->database()->escape($aVals['title']) . '\'')
				->execute('getField');
				
			if ($iCheck)
			{
				return Phpfox_Error::set(Phpfox::getPhrase('share.this_site_already_exists'));
			}			
			
			$aVals['icon'] = Phpfox::getLib('parse.input')->cleanFileName($aVals['title']);
			
			if (!($aVals['icon'] = $this->_uploadImage($aVals['icon'])))
			{
				return false;
			}
			
			$this->database()->insert($this->_sTable, $aVals);
		}
		else 
		{
			if (!empty($_FILES['icon']['name']))
			{
				$aVals['icon'] = Phpfox::getLib('parse.input')->cleanFileName($aVals['title']);
				
				$aOld = Phpfox::getService('share')->getForEdit($iEditId);
				if (file_exists(Phpfox::getParam('share.dir_image') . $aOld['icon']))
				{
					Phpfox::getLib('file')->unlink(Phpfox::getParam('share.dir_image') . $aOld['icon']);
				}				
				
				if (!($aVals['icon'] = $this->_uploadImage($aVals['icon'])))
				{
					return false;
				}				
			}
			
			$this->database()->update($this->_sTable, $aVals, 'site_id = ' . (int) $iEditId);
		}
		
		$this->cache()->remove('share', 'substr');
		
		return true;
	}
	
	public function update($iEditId, $aVals)
	{
		return $this->add($aVals, $iEditId);
	}
	
	public function delete($iId)
	{
		$aSite = Phpfox::getService('share')->getForEdit($iId);
		
		if (!isset($aSite['site_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('share.the_site_cannot_be_found'));
		}
		
		if (file_exists(Phpfox::getParam('share.dir_image') . $aSite['icon']))
		{
			Phpfox::getLib('file')->unlink(Phpfox::getParam('share.dir_image') . $aSite['icon']);
		}		
		
		$this->database()->delete($this->_sTable, 'site_id = ' . $aSite['site_id']);
		
		$this->cache()->remove('share', 'substr');
		
		return true;
	}
	
	public function sendEmails($aVals)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('share.can_send_emails', true);
		
		if ($sPlugin = Phpfox_Plugin::get('share.service_process_sendemails_1')){eval($sPlugin); if (isset($bReturnPlugin)){return $bReturnPlugin;}}
		
		Phpfox::getService('ban')->checkAutomaticBan($aVals['subject'] . ' ' . $aVals['message']);
		$aPassed = array();
		$aEmails = explode(',', $aVals['to'] . ',');
		$iCnt = 0;
		foreach ($aEmails as $sEmail)
		{
			if ($sPlugin = Phpfox_Plugin::get('share.service_process_sendemails_7')){eval($sPlugin); if (isset($bReturnPlugin)){return $bReturnPlugin;}}
			$sEmail = trim($sEmail);
			
			if (empty($sEmail))
			{
				continue;
			}
			
			if (Phpfox::getLib('mail')->checkEmail($sEmail))
			{
				$iCnt++;
				
				if (Phpfox::getUserParam('share.total_emails_per_round') > 0 && $iCnt >= Phpfox::getUserParam('share.total_emails_per_round'))
				{
					continue;
				}				
				
				if ($sPlugin = Phpfox_Plugin::get('share.service_process_sendemails_2')){eval($sPlugin); if (isset($bReturnPlugin)){return $bReturnPlugin;}}
				$this->database()->insert(Phpfox::getT('share_email'), array(
						'user_id' => Phpfox::getUserId(),
						'email' => $sEmail,
						'time_stamp' => PHPFOX_TIME
					)
				);
				
				if ($sPlugin = Phpfox_Plugin::get('share.service_process_sendemails_3')){eval($sPlugin); if (isset($bReturnPlugin)){return $bReturnPlugin;}}
				$aPassed[] = $sEmail;
			}
			
			if ($sPlugin = Phpfox_Plugin::get('share.service_process_sendemails_6')){eval($sPlugin); if (isset($bReturnPlugin)){return $bReturnPlugin;}}
		}

		if ($sPlugin = Phpfox_Plugin::get('share.service_process_sendemails_4')){eval($sPlugin); if (isset($bReturnPlugin)){return $bReturnPlugin;}}
		if (!count($aPassed))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('share.none_of_the_emails_entered_were_valid'));
		}
		
		Phpfox::getLib('mail')->to($aPassed)
			->subject($aVals['subject'])
			->message($aVals['message'])
			->messageHeader(false)
			->send();	
			
		if ($sPlugin = Phpfox_Plugin::get('share.service_process_sendemails_5')){eval($sPlugin); if (isset($bReturnPlugin)){return $bReturnPlugin;}}
		return true;
	}
	
	public function addConnect($sConnectType, $sToken = null, $sSecret = null)
	{
		$aInsert = array(
			'user_id' => Phpfox::getUserId(),
			'connect_id' => $sConnectType,
			'time_stamp' => PHPFOX_TIME
		);
		
		if ($sToken !== null)
		{
			$aInsert['token'] = $sToken;
			$aInsert['secret'] = $sSecret;
		}
		$this->database()->insert(Phpfox::getT('share_connect'), $aInsert);
	}
	
	public function deleteConnect($sConnectType)
	{
        $this->database()->delete(Phpfox::getT('share_connect'), "connect_id = '" . $sConnectType . "' AND user_id = " . Phpfox::getUserId());
               
        return "App Authorization not found. Connection to " . ucfirst($sConnectType) . " removed!";
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
		if ($sPlugin = Phpfox_Plugin::get('share.service_process__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
	
	private function _uploadImage($sName)
	{
		if (!empty($_FILES['icon']['name']))
		{
			$aImage = Phpfox::getLib('file')->load('icon', array('jpg', 'gif', 'png'));
			if ($aImage === false)
			{
				return false;
			}
			
			return Phpfox::getLib('file')->upload('icon', Phpfox::getParam('share.dir_image'), $sName, false, 0644, false);
		}
		
		return Phpfox_Error::set(Phpfox::getPhrase('share.provide_a_icon_for_this_site'));
	}
}

?>
