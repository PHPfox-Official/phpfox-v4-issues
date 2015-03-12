<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

define('PHPFOX_SKIP_POST_PROTECTION', true);

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: login.class.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
class Janrain_Component_Controller_Login extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		$this->template()->assign('sJanUrl', $this->url()->makeUrl('janrain.rpx'));
		$this->template()->assign('sJanSiteName', Phpfox::getService('janrain')->getName());
	}
}

?>