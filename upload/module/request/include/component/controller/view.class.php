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
 * @version 		$Id: view.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class Request_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$sUrl = Phpfox::callback($this->request()->get('req3') . '.getRedirectRequest', $this->request()->get('id'));
		if ($sUrl === false)
		{
			return Phpfox_Error::display(Phpfox::getPhrase('request.invalid_request_redirect'));
		}
		
		$this->url()->forward($sUrl);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('request.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>