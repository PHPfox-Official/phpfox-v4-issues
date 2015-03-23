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
 * @version 		$Id: tag.class.php 3296 2011-10-12 13:29:57Z Raymond_Benc $
 */
class Video_Component_Controller_Tag extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		return Phpfox_Module::instance()->setController('video.index');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_controller_tag_clean')) ? eval($sPlugin) : false);
	}
}

?>