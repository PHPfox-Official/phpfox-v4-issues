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
 * @version 		$Id: process.class.php 6750 2013-10-08 13:58:53Z Miguel_Espinoza $
 */
class Subscribe_Service_Purchase_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('subscribe_purchase');	
	}
	
	public function add($aVals, $iUserId = null)
	{		
		if ($iUserId === null)
		{
			Phpfox::isUser(true);
		}
		
		$aForms = array(
			'package_id' => array(
				'message' => Phpfox::getPhrase('subscribe.package_is_required'),
				'type' => 'int:required'
			),
			'currency_id' => array(
				'message' => Phpfox::getPhrase('subscribe.currency_is_required'),
				'type' => array('string:required', 'regex:currency_id')
			),
			'price' => array(
				'message' => Phpfox::getPhrase('subscribe.price_is_required'),
				'type' => 'price:required'
			)
		);		
		
		$aVals = $this->validator()->process($aForms, $aVals);
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}		
		
		$aExtra = array(
			'user_id' => ($iUserId === null ? Phpfox::getUserId() : $iUserId),
			'time_stamp' => PHPFOX_TIME	
		);
		
		$iId = $this->database()->insert($this->_sTable, array_merge($aExtra, $aVals));
		
		return $iId;
	}
	
	public function update($iPurchaseId, $iPackageId, $sStatus, $iUserId, $iUserGroupId, $iFailUserGroupId)
	{		
		$sLink = Phpfox::getLib('url')->makeUrl('subscribe.view', array('id' => $iPurchaseId));		
		switch ($sStatus)
		{
			case 'completed':
				Phpfox::getService('user.process')->updateUserGroup($iUserId, $iUserGroupId);
				Phpfox::log('Moving user "' . $iUserId . '" to user group "' . $iUserGroupId . '"');
				$sSubject = array('subscribe.membership_successfully_updated_site_title', array('site_title' => Phpfox::getParam('core.site_title')));
				$sMessage = array('subscribe.your_membership_on_site_title_has_successfully_been_updated', array(
						'site_title' => Phpfox::getParam('core.site_title'),
						'link' => $sLink
					)
				);
				$this->database()->updateCounter('subscribe_package', 'total_active', 'package_id', $iPackageId);
				$this->database()->update(Phpfox::getT('user_field'), array('subscribe_id' => '0'), 'user_id = ' . (int) $iUserId);
				break;
			case 'pending':
				$sSubject = array('subscribe.membership_pending_site_title', array('site_title' => Phpfox::getParam('core.site_title')));
				$sMessage = array('subscribe.your_membership_subscription_on_site_title_is_currently_pending', array(
						'site_title' => Phpfox::getParam('core.site_title'),
						'link' => $sLink
					)
				);
				$this->database()->update(Phpfox::getT('user_field'), array('subscribe_id' => $iPurchaseId), 'user_id = ' . (int) $iUserId);
				break;
			case 'cancel':
				// User is cancelling a subscription but he has remaining days for that subscription.
				// Phpfox::getService('user.process')->updateUserGroup($iUserId, $iFailUserGroupId);
				
				// Store in the log that this user cancelled the subscription.
				$this->database()->insert(Phpfox::getT('api_gateway_log'), array(
					'log_data' => 'cancelled_subscription user_' . (int)($iUserId) . ' purchaseid_' . (int)$iPurchaseId . ' packageid_' . (int)$iPackageId,
					'time_stamp' => PHPFOX_TIME
				));
				
				// Phpfox::log('Moving user "' . $iUserId . '" to user group "' . $iFailUserGroupId . '"');
				
				// $this->database()->updateCounter('subscribe_package', 'total_active', 'package_id', $iPackageId, true);
				// 
				break;
		}
		if ($sPlugin = Phpfox_Plugin::get('subscribe.service_purchase_process_update_pre_log'))
		{
			eval($sPlugin);
		}
		Phpfox::log('Updating status of purchase order');
		
		$this->database()->update($this->_sTable, array('status' => $sStatus), 'purchase_id = ' . (int) $iPurchaseId);	
		
		Phpfox::log('Sending user an email');
		Phpfox::getLib('mail')->to($iUserId)
			->subject($sSubject)
			->message($sMessage)
			->notification('subscribe.payment_update')
			->send();		
			
		Phpfox::log('Email sent');
	}
	
	/* This function is called from a cron job.
	*	It searches the database for users who cancelled their subscription before their time was up
	*	and moves them to the correct user group.
	*	It is called once a day and gets the soonest subscription time
	*/
	public function downgradeExpiredSubscribers()
	{		
		// 1. The shortest term is 1 month
		$iOneMonthAgo = PHPFOX_TIME - (60 *60 * 24 * 30);
		
		// 3. Find records in api_gateway_log for people that have cancelled their subscription.
		$aExpiredRecords = $this->database()->select('*')
			->from(Phpfox::getT('api_gateway_log'))
			->where('log_data LIKE "cancelled_subscription%" AND time_stamp < ' . $iOneMonthAgo)
			->execute('getSlaveRows');
			
		// 4. Find their subscription.
		$aSubscriptionsRows = $this->database()->select('*')
			->from(Phpfox::getT('subscribe_package'))
			->execute('getSlaveRows');
		
		$iCount = 0;
		foreach ($aExpiredRecords as $aExpired)
		{
			// parse the log
			if (preg_match('/user_(?P<user_id>[0-9]+) purchaseid_(?P<purchase_id>[0-9]+) packageid_(?P<package_id>[0-9]+)/', $aExpired['log_data'], $aRecord))
			{
				// find when should this subscription expire
				$iThisExpires = Phpfox::getService('subscribe.purchase')->getExpireTime($aRecord['purchase_id']);
				
				if ($iThisExpires > PHPFOX_TIME)
				{
					continue;
				}
				// find the fail user group
				foreach ($aSubscriptionsRows as $aSubs)
				{
					if ($aSubs['package_id'] == $aRecord['package_id'])
					{
						// Move user to the on fail user group
						Phpfox::getService('user.process')->updateUserGroup($aRecord['user_id'], $aSubs['fail_user_group']);
						
						// Update this record so we dont process it again
						$this->database()->update(Phpfox::getT('api_gateway_log'), array('log_data' => 'processed ' . $aExpired['log_data']), 'log_id = ' . $aExpired['log_id']);
						$this->database()->update(Phpfox::getT('user_field'), array('subscribe_id' => $aRecord['purchase_id']), 'user_id = ' . (int)$aRecord['user_id']);
						$iCount++;
					}
				}
			}
		}
		
		return $iCount;
	}
	
	public function updatePurchase($iId, $sStatus)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);	

		$aStatus = array(
			'completed',
			'cancel',
			'pending'			
		);	
		
		if (empty($sStatus))
		{
			$this->database()->update($this->_sTable, array('status' => '0'), 'purchase_id = ' . (int) $iId);
			
			return  true;
		}
		else 
		{
			if (!in_array($sStatus, $aStatus))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('subscribe.not_a_valid_purchase_status'));
			}
			
			$aPurchase = $this->database()->select('sp.*, spack.*')
				->from($this->_sTable, 'sp')
				->join(Phpfox::getT('subscribe_package'), 'spack', 'spack.package_id = sp.package_id')
				->where('sp.purchase_id = ' . (int) $iId)
				->execute('getRow');
				
			if (!isset($aPurchase['purchase_id']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('subscribe.unable_to_find_the_purchase_you_are_editing'));
			}
			
			$this->update($aPurchase['purchase_id'], $aPurchase['package_id'], $sStatus, $aPurchase['user_id'], $aPurchase['user_group_id'], $aPurchase['fail_user_group']);
			
			return  true;
		}
	}
	
	public function delete($iId)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);

		$aPurchase = $this->database()->select('sp.*, spack.*')
			->from($this->_sTable, 'sp')
			->join(Phpfox::getT('subscribe_package'), 'spack', 'spack.package_id = sp.package_id')
			->where('sp.purchase_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aPurchase['purchase_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('subscribe.unable_to_find_the_purchase_you_are_trying_to_delete'));
		}			
		
		$this->database()->updateCounter('subscribe_package', 'total_active', 'package_id', $aPurchase['package_id'], true);
		$this->database()->delete($this->_sTable, 'purchase_id = ' . $aPurchase['purchase_id']);
		
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
		if ($sPlugin = Phpfox_Plugin::get('subscribe.service_purchase_process__call'))
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