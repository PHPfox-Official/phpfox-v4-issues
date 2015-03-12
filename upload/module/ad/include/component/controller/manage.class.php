<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

define('PHPFOX_SKIP_POST_PROTECTION', true);

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: manage.class.php 6314 2013-07-19 07:16:21Z Miguel_Espinoza $
 */
class Ad_Component_Controller_Manage extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		$sView = $this->request()->get('view');
		
		$aCond = array();
		switch ($sView)
		{
			case 'pending':
				$aCond[] = 'AND a.is_custom = 2';
				break;
			case 'payment':
				$aCond[] = 'AND a.is_custom = 1';
				break;				
			case 'denied':
				$aCond[] = 'AND a.is_custom = 4';
				break;				
			default:
				$aCond[] = 'AND a.is_custom = 3';
				break;	
		}		
		$aCond[] = 'AND a.user_id = ' . Phpfox::getUserId();
		
		if (Phpfox::getParam('ad.multi_ad'))
		{
			$aCond[] = ' AND a.location = 50';
		}
		$aAds = Phpfox::getService('ad')->getForUser($aCond);
		
		Phpfox::getService('ad')->getSectionMenu();
		
		$this->template()->setTitle(Phpfox::getPhrase('ad.ad_management'))	
			->setFullSite()
			->setBreadcrumb(Phpfox::getPhrase('ad.advertise'), $this->url()->makeUrl('ad'))
			->setBreadcrumb(Phpfox::getPhrase('ad.advertise'), $this->url()->makeUrl('ad.manage'), true)			
			->setHeader(array(
					'table.css' => 'style_css',
					'manage.js' => 'module_ad'
				)
			)
			->assign(array(
					'aAllAds' => $aAds,
					'sView' => $sView,
					'bNewPurchase' => $this->request()->get('payment')
				)
			);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_manage_clean')) ? eval($sPlugin) : false);
	}
}

?>