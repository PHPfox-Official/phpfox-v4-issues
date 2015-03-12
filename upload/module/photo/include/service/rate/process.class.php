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
 * @version 		$Id: process.class.php 2863 2011-08-22 07:13:41Z Raymond_Benc $
 */
class Photo_Service_Rate_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('photo_rating');	
	}
	
	public function add($iPhotoId, $iRating)
	{		
		$this->database()->insert($this->_sTable, array(
				'photo_id' => (int) $iPhotoId,
				'user_id' => Phpfox::getUserId(),
				'rating' => $iRating,
				'time_stamp' => PHPFOX_TIME
			)
		);					
		
		$aPhoto = $this->database()->select('p.photo_id, p.total_vote, AVG(pr.rating) AS average_rating')
			->from(Phpfox::getT('photo'), 'p')
			->innerJoin($this->_sTable, 'pr', 'pr.photo_id = p.photo_id')
			->where('p.photo_id = ' . (int) $iPhotoId)
			->group('p.photo_id')
			->execute('getRow');

		if (!isset($aPhoto['photo_id']))
		{
			return false;
		}		
	
		$this->database()->update(Phpfox::getT('photo'), array(
				'total_rating' => round($aPhoto['average_rating']),
				'total_vote' => ($aPhoto['total_vote'] + 1)
			), 'photo_id = ' . $aPhoto['photo_id']
		);
		
		return true;
	}

	/**
	 * Deletes the ratings given by one user, it updates the photo table and sets the new average and total votes
	 * @param int $iUser
	 */
	public function deleteByUser($iUser)
	{
		$aVotes = $this->database()
			->select('photo_id, rating_id')
			->from($this->_sTable)
			->where('user_id = ' . ($iUser))
			->execute('getSlaveRows');

		if (empty($aVotes))
		{
			return false;
		}
		$this->database()->delete($this->_sTable, 'user_id = ' . (int)$iUser);
		$sIds = '';
		foreach ($aVotes as $aVote)
		{
			$sIds .= $aVote['photo_id'] . ',';
		}
		$sIds = rtrim($sIds, ',');
		
		// Update the average rating
		$aPhotos = $this->database()->select('p.photo_id, p.total_vote, AVG(pr.rating) AS average_rating')
			->from(Phpfox::getT('photo'), 'p')
			->innerJoin($this->_sTable, 'pr', 'pr.photo_id = p.photo_id')
			->where('p.photo_id IN(' . $sIds . ')')
			->group('p.photo_id')
			->execute('getRows');

		foreach ($aPhotos as $aPhoto)
		{
			$this->database()->update(Phpfox::getT('photo'), array(
					'total_rating' => round($aPhoto['average_rating']),
					'total_vote' => ($aPhoto['total_vote'] - 1)
				), 'photo_id = ' . $aPhoto['photo_id']
			);
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
		if ($sPlugin = Phpfox_Plugin::get('photo.service_rate_process__call'))
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