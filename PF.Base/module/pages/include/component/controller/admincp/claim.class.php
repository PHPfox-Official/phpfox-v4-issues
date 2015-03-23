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
 * @package  		Module_Mail
 * @version 		$Id: compose.class.php 4607 2012-08-27 07:23:45Z Miguel_Espinoza $
 */
class Pages_Component_Controller_Admincp_Claim extends Phpfox_Component
{

	public function process()
	{
		$aClaims = Phpfox::getService('pages')->getClaims();
		
		$this->template()->setTitle('Claims')
			->setBreadcrumb('Claims')
			->setHeader(array(
				'claim.js' => 'module_pages'
			))
			->assign(array(
				'aClaims' => $aClaims			
			));
	}
}