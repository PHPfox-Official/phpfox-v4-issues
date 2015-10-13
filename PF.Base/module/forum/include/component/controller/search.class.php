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
class Forum_Component_Controller_Search extends Phpfox_Component
{	
	/**
	 * Controller
	 */
	public function process()
	{
		Phpfox::getService('forum')->buildMenu();
		return Phpfox_Module::instance()->setController('forum.forum');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_controller_search_clean')) ? eval($sPlugin) : false);
	}
}

?>