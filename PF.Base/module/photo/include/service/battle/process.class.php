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
 * @version 		$Id: process.class.php 2633 2011-05-30 13:57:44Z Raymond_Benc $
 */
class Photo_Service_Battle_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('photo');
	}
	
	public function add($iWinner, $iLoser)
	{
		$iCheck = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('photo_battle'))
			->where('(photo_1 = ' . (int) $iWinner . ' AND photo_2 = ' . (int) $iLoser . ') OR (photo_2 = ' . (int) $iWinner . ' AND photo_1 = ' . (int) $iLoser . ')')
			->execute('getSlaveField');
			
		if ($iCheck)
		{
			return false;
		}
		
		$aPhoto_1 = $this->database()->select('total_battle')
			->from($this->_sTable)
			->where('photo_id = ' .(int) $iWinner)
			->execute('getSlaveRow');
			
		$aPhoto_2 = $this->database()->select('total_battle')
			->from($this->_sTable)
			->where('photo_id = ' .(int) $iWinner)
			->execute('getSlaveRow');			
		
		$this->database()->update($this->_sTable, array('total_battle' => ($aPhoto_1['total_battle'] + 1)), 'photo_id = ' . (int) $iWinner);
		$this->database()->update($this->_sTable, array('total_battle' => ($aPhoto_2['total_battle'] - 1)), 'photo_id = ' . (int) $iLoser);
				
		$this->database()->insert(Phpfox::getT('photo_battle'), array(
				'user_id' => Phpfox::getUserId(),
				'photo_1' => $iWinner,
				'photo_2' => $iLoser,
				'time_stamp' => PHPFOX_TIME
			)
		);				
		
		return true;
	}

	/**
	 * Deletes the votes on the Batle section given a user id. It updates the total_battle field from the photo table
	 * @param int $iUser
	 */
	public function deleteByUser($iUser)
	{
		// Select all the image_id that this user has rated in battle
		$aPhotos = $this->database()
			->select('pb.photo_1, pb.battle_id, p.total_battle')
			->from(Phpfox::getT('photo_battle'), 'pb')
			->leftjoin($this->_sTable, 'p', 'p.photo_id = pb.photo_1')
			->where('pb.user_id = ' . (int)$iUser)
			->execute('getSlaveRows');
		
		// Now decrement the total_battle
		foreach ($aPhotos as $aPhoto)
		{						
			//delete the vote on the battles
			$this->database()->delete(Phpfox::getT('photo_battle'), 'battle_id = ' . $aPhoto['battle_id']);
		}
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
		if ($sPlugin = Phpfox_Plugin::get('photo.service_battle_process__call'))
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