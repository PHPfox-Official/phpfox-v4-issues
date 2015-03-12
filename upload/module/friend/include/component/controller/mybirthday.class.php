<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display the image details when viewing an image.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Friend
 * @version 		$Id: detail.class.php 254 2009-02-23 12:36:20Z Miguel_Espinoza $
 */
class Friend_Component_Controller_Mybirthday extends Phpfox_Component
{
	public function process()
	{
		Phpfox::isUser(true);
		// get the request for just one message
		$iId = (int)$this->request()->get('id');		
		$aMessages = Phpfox::getService('friend')->getBirthdayMessages(Phpfox::getUserId(), $iId);		
		
		$this->template()->assign(array(
			'aMessages' => $aMessages
		))
		->setBreadcrumb(Phpfox::getPhrase('friend.my_friends'), $this->url()->makeUrl('friend'))
		->setBreadCrumb(Phpfox::getPhrase('friend.birthday_e_cards'), $this->url()->makeUrl('friend.mybirthday'), true)
		->setTitle(Phpfox::getPhrase('friend.birthday_e_cards'));

		Phpfox::isModule('notification') ? Phpfox::getService('notification.process')->delete('friend_birthday', $iId, Phpfox::getUserId()) : null;
	}
}
?>
