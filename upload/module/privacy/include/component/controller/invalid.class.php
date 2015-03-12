<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Privacy invalid page
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Privacy
 * @version 		$Id: invalid.class.php 3661 2011-12-05 15:42:26Z Miguel_Espinoza $
 */
class Privacy_Component_Controller_Invalid extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$this->template()->setTitle(Phpfox::getPhrase('privacy.item_section_privacy'))->setBreadcrumb(Phpfox::getPhrase('privacy.item_section_privacy'), null, true);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('privacy.component_controller_invalid_clean')) ? eval($sPlugin) : false);
	}
}

?>