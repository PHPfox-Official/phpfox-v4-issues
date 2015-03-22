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
 * @package 		Phpfox_Service
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Forum_Service_Subscribe_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('forum_subscribe');
	}
	
	public function add($iThreadId, $iUserId)
	{
		Phpfox::isUser(true);
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('thread_id = ' . (int) $iThreadId . ' AND user_id = ' . (int) $iUserId)
			->execute('getSlaveField');
			
		if ($iCnt)
		{
			return false;
		}
		
		$this->database()->insert($this->_sTable, array(
				'thread_id' => (int) $iThreadId,
				'user_id' => (int) $iUserId
			)
		);	
	}
	
	public function delete($iThreadId, $iUserId)
	{
		$this->database()->delete($this->_sTable, 'thread_id = ' . (int) $iThreadId . ' AND user_id = ' . (int) $iUserId);
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
		if ($sPlugin = Phpfox_Plugin::get('forum.service_subscribe_process__call'))
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