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
 * @version 		$Id: friend.class.php 2621 2011-05-22 20:09:22Z Raymond_Benc $
 */
class Privacy_Component_Block_Friend extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->assign(array(
				'aLists' => Phpfox::getService('friend.list')->get(),
				'bNoCustomDiv' => (bool) $this->getParam('bNoCustomDiv', false),
				'iNewListId' => (int) $this->getParam('list_id'),
				'sCustomPrivacyId' => $this->request()->get('custom-id'),
				'sPrivacyArray' => $this->request()->get('privacy-array')
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('privacy.component_block_friend_clean')) ? eval($sPlugin) : false);
	}
}

?>