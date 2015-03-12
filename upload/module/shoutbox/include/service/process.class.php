<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Process class for shoutouts where we add, delete or update shoutouts.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Shoutbox
 * @version 		$Id: process.class.php 2526 2011-04-13 18:15:51Z Raymond_Benc $
 */
class Shoutbox_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('shoutbox');
	}
	
	/**
	 * Add a new shoutout.
	 *
	 * @param int $iUserId User ID of the user.
	 * @param string $sText Shoutout text.
	 * 
	 * @return boolean Return TRUE by default
	 */
	public function add($iUserId, $sText, $sModule = null, $iItemId = null)
	{
		Phpfox::getService('ban')->checkAutomaticBan($sText);
		// Clean the text, we don't allow HTML here.
		$sText = Phpfox::getLib('parse.input')->clean($sText, 255);
		
		$aSql = array(
			'user_id' => (int) $iUserId,
			'text' => $sText,
			'time_stamp' => PHPFOX_TIME
		);
		
		if ($sModule !== null && $iItemId !== null && Phpfox::hasCallback($sModule, 'getShoutboxData'))
		{
			$aCallback = Phpfox::callback($sModule . '.getShoutboxData');		
			if (isset($aCallback['table']))
			{
				$this->_sTable = Phpfox::getT($aCallback['table']);
				$aSql['item_id'] = (int) $iItemId;	
			}
		}
		
		// Insert the shoutout
		$iInsert = $this->database()->insert($this->_sTable, $aSql);
		if (defined('PHPFOX_USER_IS_BANNED') && PHPFOX_USER_IS_BANNED)
		{
			return false;
		}
		return $iInsert;
	}
	
	/**
	 * Used via a cron job and clears a certain amount of shoutouts
	 * from the shoutbox table so we keep this table slim.
	 * 
	 * Notice: We use PHP to contorl how many shoutouts we DELETE as more tests
	 * will be needed with our database drivers on the proper support for LIMITING a DELETE
	 * query that SQL standards support. (EG. DELETE FROM table WHERE id = 1 LIMIT 1
	 * 
	 * @param int $iLimit Define how many shoutouts we should keep.
	 */
	public function clear($iLimit = 100)
	{
		$aShoutouts = $this->database()->select('shout_id')
			->from($this->_sTable)
			->order('time_stamp DESC')			
			->execute('getRows');
		
		foreach ($aShoutouts as $iKey => $aShoutout)
		{
			if ($iKey < $iLimit)
			{
				continue;
			}
			
			$this->database()->delete($this->_sTable, 'shout_id =' . $aShoutout['shout_id']);
		}
	}
	
	public function delete($iId, $sModule = '')
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('shoutbox.can_delete_all_shoutbox_messages', true);
		
		$sTable = 'shoutbox';
		if (!empty($sModule) && Phpfox::hasCallback($sModule, 'getShoutboxData'))
		{
			$aCallback = Phpfox::callback($sModule . '.getShoutboxData');		
			if (isset($aCallback['table']))
			{
				$sTable = $aCallback['table'];
			}
		}		
		
		$this->database()->delete(Phpfox::getT($sTable), 'shout_id = ' . (int) $iId);
		
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
		if ($sPlugin = Phpfox_Plugin::get('shoutbox.service_process__call'))
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