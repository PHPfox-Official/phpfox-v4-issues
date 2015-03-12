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
 * @package 		Phpfox_Component
 * @version 		$Id: sync.class.php 2096 2010-11-09 10:35:56Z Raymond_Benc $
 */
class Facebook_Component_Controller_Sync extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{			
		$this->template()->setTitle(Phpfox::getPhrase('facebook.facebook_sync'))
			->setBreadcrumb(Phpfox::getPhrase('facebook.facebook_sync'))
			->setHeader(array(
					
				)
			);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('facebook.component_controller_sync_clean')) ? eval($sPlugin) : false);
	}
}

?>