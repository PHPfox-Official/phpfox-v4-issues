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
 * @package  		Module_Privacy
 * @version 		$Id: ajax.class.php 6871 2013-11-11 12:19:49Z Miguel_Espinoza $
 */
class Privacy_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function getFriends()
	{
		Phpfox::getBlock('privacy.friend');
		
		$this->setTitle(Phpfox::getPhrase('privacy.custom_privacy'));
	}
	
	public function addItemToFriendsLists()
	{
		$aLists = $this->get('lists');
		if (!empty($aLists))
		{
			Phpfox::getService('privacy.process')->add($this->get('module'), $this->get('item_id'), $aLists);
			
		}
	}
}

?>