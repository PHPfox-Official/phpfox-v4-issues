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
 * @version 		$Id: delete.class.php 2137 2010-11-15 13:37:06Z Raymond_Benc $
 */
class User_Component_Controller_Admincp_Group_Delete extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('user.can_delete_user_group', true);
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if (Phpfox::getService('user.group.process')->delete($aVals))
			{
				$this->url()->send('admincp.user.group', null, Phpfox::getPhrase('user.successfully_deleted_user_group'));
			}
		}
		
		$aGroup = Phpfox::getService('user.group')->getGroup($this->request()->getInt('id'));
		
		if (!isset($aGroup['user_group_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('user.unable_to_find_the_user_group_you_want_to_delete'));
		}
		
		if ($aGroup['is_special'])
		{
			return Phpfox_Error::display(Phpfox::getPhrase('user.not_allowed_to_delete_this_user_group'));
		}
		
		$this->template()
			->setTitle(Phpfox::getPhrase('user.delete_user_group'))
			->setBreadcrumb(Phpfox::getPhrase('user.delete_user_group'))
			->setBreadcrumb($aGroup['title'], null, true)
			->assign(array(
					'aGroup' => $aGroup,
					'aGroups' => Phpfox::getService('user.group')->get()
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_admincp_group_delete_clean')) ? eval($sPlugin) : false);
	}
}

?>