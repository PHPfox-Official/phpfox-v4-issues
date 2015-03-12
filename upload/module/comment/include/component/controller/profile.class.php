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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Comment_Component_Controller_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (PHPFOX_IS_AJAX_CONTROLLER)
		{
			$aUser = Phpfox::getService('user')->get($this->request()->get('profile_id'));
			$this->setParam('aUser', $aUser);
		}		
		
		$aRow = $this->getParam('aUser');
		
		$this->setParam(array(
				'bIsProfileIndex' => true,
				'sType' => 'profile',
				'iItemId' => $aRow['user_id'],
				'iTotal' => $aRow['total_comment'],
				'user_id' => $aRow['user_id'],
				'type_id' => 'user_main',
				'item_id' => $aRow['user_id'],
				'template' => 'content'
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('comment.component_controller_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>