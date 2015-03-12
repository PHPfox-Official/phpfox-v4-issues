<?php

/**
 * [PHPFOX_HEADER]
 */
defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Service
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Egift_Service_Callback extends Phpfox_Service
{

	/**
	 * Class constructor
	 */
	public function __construct()
	{

	}

	/**
	 * Handles API callback for payment gateways.
	 *
	 * @param array $aParams ARRAY of params passed from the payment gateway after a payment has been made.
	 * @return bool|null FALSE if payment is not valid|Nothing returned if everything went well.
	 */
	public function paymentApiCallback($aParams)
	{
		Phpfox::log('Module callback recieved: ' . var_export($aParams, true));
		Phpfox::log('Attempting to retrieve purchase from the database');

		define('PHPFOX_API_CALLBACK', true); // used to override security checks in the processes
		// we get the sponsored ad
		$iId = preg_replace("/[^0-9]/", '', $aParams['item_number']);
		$aInvoice = Phpfox::getService('egift')->getEgiftInvoice((int) $iId);
		if (empty($aInvoice))
		{
			Phpfox::log('egift not found.');
			return false;
		}
		Phpfox::log('Found the invoice.');


		Phpfox::log('Purchase seems valid: ' . var_export($aInvoice, true));

		if ($aParams['status'] == 'completed')
		{
			if ($aParams['total_paid'] == $aInvoice['price'])
			{
				Phpfox::log('Paid correct price');
			}
			else
			{
				Phpfox::log('Paid incorrect price');
				return false;
			}
		}
		else
		{
			Phpfox::log('Payment is not marked as "completed".');
			return false;
		}

		Phpfox::log('Handling purchase');

		$this->database()->update(Phpfox::getT('egift_invoice'), array(
			'status' => $aParams['status'],
			'time_stamp_paid' => PHPFOX_TIME
				), 'invoice_id = ' . $aInvoice['invoice_id']
		);


		$this->database()->update(Phpfox::getT('friend_birthday'), array(
			'status_id' => '1'
				), 'birthday_id = ' . $aInvoice['birthday_id']
		);

		if (Phpfox::isModule('notification'))
			Phpfox::getService('notification.process')->add('friend_birthday', $aInvoice['birthday_id'], $aInvoice['user_to'], $aInvoice['user_from']);

		$sLink = Phpfox::getLib('url')->makeUrl('friend.mybirthday', array('id' => $aInvoice['birthday_id']));

		$sFullName = $this->database()->select('full_name')->from(Phpfox::getT('user'))
				->where('user_id = ' . (int)$aInvoice['user_from'])
				->execute('getSlaveField');

		Phpfox::getLib('mail')->to($aInvoice['user_to'])
				->subject(array('friend.full_name_wishes_you_a_happy_birthday_on_site_title', array('full_name' => $sFullName, 'site_title' => Phpfox::getParam('core.site_title'))))
				->message(array('friend.full_name_wrote_to_congratulate_you_on_your_birthday_on_site_title', array('full_name' => $sFullName, 'site_title' => Phpfox::getParam('core.site_title'), 'link' => $sLink)))
				->notification('friend.receive_new_birthday')
				->send();

		Phpfox::log('Handling complete');
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
		if ($sPlugin = Phpfox_Plugin::get('egift.service_callback__call'))
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