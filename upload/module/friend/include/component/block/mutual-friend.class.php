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
 * @version 		$Id: mutual-friend.class.php 1418 2010-01-21 18:38:10Z Raymond_Benc $
 */
class Friend_Component_Block_Mutual_Friend extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aUser = $this->getParam('aUser');

		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'friend.view_friend'))
		{
			return false;
		}		
		
		if (Phpfox::getUserId() == $aUser['user_id'] && !defined('PHPFOX_IN_DESIGN_MODE'))
		{
			return false;
		}
		
		if (Phpfox::getUserId() == $aUser['user_id'])
		{
			$this->template()->assign(array(
					'sHeader' => Phpfox::getPhrase('friend.mutual_friends'),
					'sDeleteBlock' => 'profile'										
				)
			);			
			
			return 'block';
		}
		
		list($iTotal, $aRows) = Phpfox::getService('friend')->getMutualFriends($aUser['user_id']);
		
		if (!$iTotal)
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('friend.mutual_friends'),
				'sDeleteBlock' => 'profile',
				'aMutualFriends' => $aRows,
				'iTotalMutualFriends' => $iTotal
			)
		);
		
		if ($iTotal > 3)
		{
			$this->template()->assign(array(
					'aFooter' => array(
						Phpfox::getPhrase('friend.view_all') => $this->url()->makeUrl($aUser['user_name'], array('friend', 'mutual'))
					)
				)
			);
		}
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_mutual_friend_clean')) ? eval($sPlugin) : false);
	}
}

?>