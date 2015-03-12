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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class User_Component_Controller_Admincp_Ban extends Phpfox_Component
{

	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($this->request()->getInt('user', 0) == 0)
		{
			$this->url()->send('admincp.user.browse', null, Phpfox::getPhrase('ban.you_need_to_choose_a_user_to_ban'));
		}
		$aUser = Phpfox::getService('user')->get((int)$this->request()->getInt('user'), true);
		if (($aVals = $this->request()->getArray('aBan')))
		{			
			if (Phpfox::getService('ban.process')->banUser($aVals['user'], $aVals['days_banned'], $aVals['return_user_group'], $aVals['reason']))
			{				
				$this->url()->send('admincp.user.browse', null
						, Phpfox::getPhrase('ban.the_user_a_href_link_user_a_has_been_banned',array(
					'link' => $this->url()->makeUrl($aUser['user_name']),
					'user_name' => $aUser['user_name'])
								));
			}
			// this should not happen :P banUser should always work ;)
		}
		$this->template()->assign(array(
			'aUser' => $aUser
				))
				->setBreadCrumb(Phpfox::getPhrase('user.ban_user'));
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_admincp_ban_clean')) ? eval($sPlugin) : false);
	}

}

?>