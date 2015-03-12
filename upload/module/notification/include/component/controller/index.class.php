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
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Notification_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		$iPage = $this->request()->getInt('page');
		$iPageTotal = 100;
		
		list($iCnt, $aNotifications) = Phpfox::getService('notification')->getForBrowse($iPage, $iPageTotal);
		
		$this->template()->setTitle(Phpfox::getPhrase('notification.notifications'))
			->setBreadcrumb(Phpfox::getPhrase('notification.notifications'), $this->url()->makeUrl('notification'))
			->setHeader(array(	
					'view.css' => 'module_notification',
					'view.js' => 'module_notification'
				)
			)
			->assign(array(
					'aNotifications' => $aNotifications
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('notification.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>