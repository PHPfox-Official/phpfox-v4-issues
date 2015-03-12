<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Shows the congratulate ajax box
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Friend
 * @version 		$Id: detail.class.php 254 2009-02-23 12:36:20Z Miguel_Espinoza $
 */
class Friend_Component_Block_Congratulate extends Phpfox_Component
{
	public function process()
	{
		$aUser = $this->getParam('aUser');
		if (empty($aUser))
		{
			$aUser = $this->request()->get('iUser');
		}
		//$iUser = (PHPFOX_IS_AJAX ? $this->request()->get('iUser') : $this->getParam('iUser'));
		
		$this->template()->assign(array(
				'iUser' => $aUser['user_id']
			)
		);
		
		if (!PHPFOX_IS_AJAX)
		{
			if (Phpfox::getService('friend')->isBirthdaySent(Phpfox::getUserId(), $aUser['user_id']))
			{
				return false;
			}
			
			$this->template()->assign(array(
					'sHeader' => Phpfox::getPhrase('friend.birthday_notification')					
				)
			);
			
			return 'block';
		}
	}
}
?>
