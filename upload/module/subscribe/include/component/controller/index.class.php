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
 * @package  		Module_Subscribe
 * @version 		$Id: index.class.php 1321 2009-12-15 18:19:30Z Raymond_Benc $
 */
class Subscribe_Component_Controller_Index extends Phpfox_Component
{	
	public function process()
	{
		if (Phpfox::getParam('subscribe.enable_subscription_packages'))
		{		
			$this->template()->setTitle(Phpfox::getPhrase('subscribe.membership_packages'))
				->setBreadcrumb(Phpfox::getPhrase('subscribe.membership_packages'))
				->assign(array(
					'aPackages' => Phpfox::getService('subscribe')->getPackages()
				)
			);		
		}
		else 
		{
			$this->template()->setTitle(Phpfox::getPhrase('subscribe.membership_notice'))->setBreadcrumb(Phpfox::getPhrase('subscribe.membership_notice'));
		}
	}
}


?>