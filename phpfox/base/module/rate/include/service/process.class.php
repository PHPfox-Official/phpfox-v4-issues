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
class Rate_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function add($aRating)
	{
		Phpfox::isUser(true);
		
		if (!is_array($aRating))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('rate.not_a_valid_post'));
		}
		
		$sModule = $aRating['type'];
		$sExtra = '';
		if (strpos($aRating['type'], '_'))
		{
			$aParts = explode('_', $aRating['type']);
			$sModule = $aParts[0];
			$sExtra = ucfirst($aParts[1]);
		}
		
		$aCallback = Phpfox::callback($sModule . '.getRatingData' . $sExtra, $aRating['item_id']);
				
		$aRow = $this->database()->select($aCallback['field'] . ', user_id')
			->from(Phpfox::getT((isset($aCallback['check_table']) ? $aCallback['check_table'] : $aCallback['table'])))
			->where($aCallback['field'] . ' = ' . (int) $aRating['item_id'])
			->execute('getSlaveRow');
			
		if (!isset($aRow[$aCallback['field']]))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('rate.not_a_valid_item_to_rate'));
		}
		
		if ($aRow['user_id'] == Phpfox::getUserId())
		{
			return Phpfox_Error::set(Phpfox::getPhrase('rate.sorry_you_are_not_able_to_rate_your_own_item'));
		}
		
		$iIsRated = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT($aCallback['table_rating']))
			->where('item_id = ' . (int) $aRating['item_id'] . ' AND user_id = ' . Phpfox::getUserId())
			->execute('getSlaveField');
			
		if (!$iIsRated)
		{
			$aParts = explode('|', $aRating['star']);
			$iId = $this->database()->insert(Phpfox::getT($aCallback['table_rating']), array(
					'item_id' => $aRating['item_id'],
					'user_id' => Phpfox::getUserId(),
					'rating' => (int) $aParts[0],
					'time_stamp' => PHPFOX_TIME
				)
			);	
			
			$aAverage = $this->database()->select('COUNT(*) AS count, AVG(rating) AS average_rating')
				->from(Phpfox::getT($aCallback['table_rating']))
				->where('item_id = ' . (int) $aRating['item_id'])
				->execute('getRow');

			$this->database()->update(Phpfox::getT($aCallback['table']), array(
					'total_score' => round($aAverage['average_rating']),
					'total_rating' => $aAverage['count']
				), $aCallback['field'] . ' = ' . (int) $aRating['item_id']
			);
			
			return $iId;
		}
		
		return Phpfox_Error::set(Phpfox::getPhrase('rate.you_have_already_voted_on_this_item'));
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
		if ($sPlugin = Phpfox_Plugin::get('rate.service_process__call'))
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