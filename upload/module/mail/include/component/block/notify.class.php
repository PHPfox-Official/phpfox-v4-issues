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
 * @version 		$Id: notify.class.php 2632 2011-05-26 19:28:02Z Raymond_Benc $
 */
class Mail_Component_Block_Notify extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$this->template()->assign(array(
				'iTotalUnseenMessages' => 0// Mail_Service_Mail::instance()->getUnseenTotal()
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('mail.component_block_notify_clean')) ? eval($sPlugin) : false);
	}
}

?>