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
 * @version 		$Id: preview.class.php 3008 2011-09-05 18:22:14Z Raymond_Benc $
 */
class Ad_Component_Controller_Preview extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		define('PHPFOX_IS_AD_PREVIEW', true);
		
		$this->template()->setTemplate('blank');		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_preview_clean')) ? eval($sPlugin) : false);
	}
}

?>