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
 * @package  		Module_Help
 * @version 		$Id: ajax.class.php 852 2009-08-10 18:05:32Z Raymond_Benc $
 */
class Help_Component_Ajax_Ajax extends Phpfox_Ajax
{	
	public function closeTips()
	{
		Phpfox::getBlock('help.close-tips', array(
			'tip' => $this->get('tip')
		));
	}
	
	public function closePerSession()
	{
		Phpfox::getLib('session')->set('tip_' . $this->get('tip'), true);
		$this->call('$("#tip_' . $this->get('tip') . '").hide();');
	}
	
	public function closeAllTips()
	{
		Phpfox::getService('help.process')->toggleTips(true);
		$this->call('$(".tip").hide();');
	}
}

?>