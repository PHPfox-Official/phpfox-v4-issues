<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handles the rating of photos.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox_Service
 * @version 		$Id: rate.class.php 2632 2011-05-26 19:28:02Z Raymond_Benc $
 */
class Photo_Service_Rate_Rate extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('photo');	
	}
	
	public function getForRating($sCategory = null, $iPhotoId = null)
	{		
		$aConds = array();				
		
		if ($iPhotoId !== null)
		{
			$aConds[] = ' AND p.photo_id = ' . (int) $iPhotoId;
		}
		else 
		{
			$aConds[] = 'p.privacy = 0 AND p.allow_rate = 1 AND ' . $this->database()->isNull('pr.rating_id');
			if ($sCategory !== null)
			{
				$sCategoryIds = Phpfox::getService('photo.category')->getAllCategories($sCategory);
				
				if (!empty($sCategoryIds))
				{
					$aConds[] = ' AND pcd.category_id IN (' . $sCategoryIds . ')';
					
					$this->database()->innerJoin(Phpfox::getT('photo_category_data'), 'pcd', 'pcd.photo_id = p.photo_id');
				}
			}			
		}
				
		$aPhoto = $this->database()->select('p.photo_id, p.server_id, p.destination, p.total_rating, p.total_vote, p.time_stamp, pr.rating_id, ' . Phpfox::getUserField())
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->leftJoin(Phpfox::getT('photo_rating'), 'pr', 'pr.photo_id = p.photo_id AND pr.user_id = ' . Phpfox::getUserId())
			->where($aConds)
			->order('RAND()')
			->execute('getRow');
			
		if (!isset($aPhoto['photo_id']))
		{
			return false;
		}
		
		$aPhoto['destination'] = Phpfox::getService('photo')->getPhotoUrl($aPhoto);
			
		return $aPhoto;		
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
		if ($sPlugin = Phpfox_Plugin::get('photo.service_rate__call'))
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