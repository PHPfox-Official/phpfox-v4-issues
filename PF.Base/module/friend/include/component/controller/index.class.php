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
 * @version 		$Id: index.class.php 3441 2011-11-02 15:53:59Z Miguel_Espinoza $
 */
class Friend_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{		
		Phpfox::isUser(true);

		if (($users = $this->request()->get('users'))) {
			$users = array_keys(json_decode($users, true));
			$activeList = $this->request()->get('active_list');
			$listId = $this->request()->get('list_id');
			$Process = Friend_Service_List_Process::instance();

			if ($activeList) {
				foreach ($users as $user) {
					$Process->removeFriendsFromlist($activeList, $user);
				}
			}

			if ($listId != 'remove_from_list') {
				$Process->addFriendsTolist($listId, $users);
			}

			exit;
		}

		$this->url()->send('profile.friend');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>