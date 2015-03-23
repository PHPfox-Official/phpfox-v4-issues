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
 * @package  		Module_Shoutbox
 * @version 		$Id: callback.class.php 4858 2012-10-09 06:56:45Z Raymond_Benc $
 */
class Shoutbox_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function getPagePerms()
	{
		$aPerms = array();
	
		$aPerms['shoutbox.view_post_shoutbox'] = Phpfox::getPhrase('shoutbox.can_view_post_in_shoutbox');
	
		return $aPerms;
	}	
	
	public function getBlockDetailsDisplay()
	{
		return array(
			'title' => Phpfox::getPhrase('shoutbox.shoutbox')
		);
	}
	
	public function hideBlockDisplay($sType)
	{
		return array(
			'table' => ($sType == 'dashboard' ? 'user_dashboard' : '')
		);		
	}
	
	public function getGroupAccess()
	{
		return array(
			Phpfox::getPhrase('shoutbox.view_shoutbox') => 'can_use_shoutbox'
		);
	}
	
	public function onDeleteUser($iUser)
	{
	    $this->database()->delete(Phpfox::getT('shoutbox'), 'user_id = ' . (int) $iUser);
	}		
	
	public function getSqlTitleField()
	{
		return array(
			'table' => 'shoutbox',
			'field' => 'text'
		);		
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
		if ($sPlugin = Phpfox_Plugin::get('shoutbox.service_callback__call'))
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