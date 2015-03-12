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
 * @version 		$Id: activity.class.php 982 2009-09-16 08:11:36Z Raymond_Benc $
 */
class Core_Component_Block_Giftpoints extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('core.can_gift_points', true);
		
		$aUser = Phpfox::getService('user')->get($this->getParam('user_id'), true);		
			
		$this->template()->assign(array(
				'aUser' => $aUser,
				'iCurrentAvailable' => Phpfox::getUserBy('activity_points'),
				'iTrgUserId' => $this->getParam('user_id')
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_activity_clean')) ? eval($sPlugin) : false);
	}
}

?>