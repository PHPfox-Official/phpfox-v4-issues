<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Service
 * @version 		$Id: promotion.class.php 4146 2012-05-02 10:02:43Z Miguel_Espinoza $
 */
class User_Service_Promotion_Promotion extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('user_promotion');	
	}
	
	public function getPromotion($iId)
	{
		$aPromotion = $this->database()->select('*')
			->from($this->_sTable)
			->where('promotion_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aPromotion['promotion_id']))
		{
			return false;
		}
			
		return $aPromotion;
	}
	
	public function get()
	{
		return $this->database()->select('up.*, ug1.title AS user_group_title, ug2.title AS upgrade_user_group_title')
			->from($this->_sTable, 'up')
			->join(Phpfox::getT('user_group'), 'ug1', 'ug1.user_group_id = up.user_group_id')
			->join(Phpfox::getT('user_group'), 'ug2', 'ug2.user_group_id = up.upgrade_user_group_id')
			->execute('getSlaveRows');
	}
	
	public function check()
	{
		if (!Phpfox::getParam('user.check_promotion_system'))
		{
			return false;
		}
		
		if (!Phpfox::isUser())
		{
			return false;
		}
		
		$sCacheId = $this->cache()->set('promotion_' . Phpfox::getUserBy('user_group_id'));
		$aPromotion = array();
		if (!($aPromotion = $this->cache()->get($sCacheId)))
		{
			$aPromotion = $this->database()->select('*')
				->from($this->_sTable)
				->where('user_group_id = ' . Phpfox::getUserBy('user_group_id'))
				->execute('getSlaveRow');
			
			$this->cache()->save($sCacheId, $aPromotion);
		}
		
		if (isset($aPromotion['promotion_id']))
		{
			if ((int) Phpfox::getUserBy('activity_points') >= (int) $aPromotion['total_activity'] && ((int)$aPromotion['total_activity']))
			{
				//if ((str_replace('-', '', (Phpfox::getUserBy('joined') - PHPFOX_TIME)) >= ($aPromotion['total_day'] * 86400)))
				{
					$this->database()->update(Phpfox::getT('user'), array('user_group_id' => $aPromotion['upgrade_user_group_id']), 'user_id = ' . Phpfox::getUserId());
					
					Phpfox::getLib('url')->send('user.promotion');
				}
			}
			else if ( ((int)$aPromotion['total_day'] > 0))
			{
				if ((str_replace('-', '', (Phpfox::getUserBy('joined') - PHPFOX_TIME)) >= ($aPromotion['total_day'] * 86400)))
				{
					$this->database()->update(Phpfox::getT('user'), array('user_group_id' => $aPromotion['upgrade_user_group_id']), 'user_id = ' . Phpfox::getUserId());
					
					Phpfox::getLib('url')->send('user.promotion');
				}
			}
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_promotion_promotion__call'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>