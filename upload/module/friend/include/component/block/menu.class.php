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
 * @package  		Module_Friend
 * @version 		$Id: menu.class.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
class Friend_Component_Block_Menu extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$aUser = $this->getParam('aUser');
		if (!($this->getParam('aTotalFriends')))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sTopFriendOnlineLink' => Phpfox::getService('user')->getLink($aUser['user_id'], $aUser['user_name'], array('friend', 'view' => 'online'))
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_menu_clean')) ? eval($sPlugin) : false);
	}
}

?>