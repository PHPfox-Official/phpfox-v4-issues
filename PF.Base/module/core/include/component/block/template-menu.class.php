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
 * @version 		$Id: template-menu.class.php 2817 2011-08-08 16:59:43Z Raymond_Benc $
 */
class Core_Component_Block_Template_Menu extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (Phpfox::isUser() && Phpfox::isModule('pages')) {
			list(,$pages) = Pages_Service_Pages::instance()->getMyLoginPages(0, 20);
			$this->template()->assign([
				'pages' => $pages
			]);
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_template_menu_clean')) ? eval($sPlugin) : false);
	}
}

?>