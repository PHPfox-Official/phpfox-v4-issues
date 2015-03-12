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
 * @version 		$Id: friend.class.php 6223 2013-07-09 08:40:27Z Miguel_Espinoza $
 */
class Share_Component_Block_Friend extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		$sMessage = Phpfox::getPhrase('share.hi_check_this_out_bbcode', array('url' => $this->request()->get('url')));
		$sMessage = str_replace("\n", "",  $sMessage);
		
		$this->template()->assign(array(
				'sTitle' => $this->request()->get('title'),
				'sMessage' => $sMessage
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('share.component_block_friend_clean')) ? eval($sPlugin) : false);
	}
}

?>