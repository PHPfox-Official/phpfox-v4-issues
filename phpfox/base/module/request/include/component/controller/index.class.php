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
 * @package  		Module_Request
 * @version 		$Id: index.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class Request_Component_Controller_Index extends Phpfox_Component
{
	public function process()
	{	
		Phpfox::isUser(true);
		
		$this->template()->setTitle(Phpfox::getPhrase('request.confirm_requests'))->setBreadcrumb(Phpfox::getPhrase('request.requests'));
		
		(($sPlugin = Phpfox_Plugin::get('request.component_controller_index_process')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('request.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>