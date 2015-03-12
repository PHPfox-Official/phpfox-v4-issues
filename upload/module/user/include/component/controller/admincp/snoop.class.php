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
 * @version 		$Id: index.class.php 1068 2009-09-24 09:27:36Z Miguel_Espinoza $
 */
class User_Component_Controller_Admincp_Snoop extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('user.can_member_snoop', true);

		$aUser = Phpfox::getService('user')->getUser($this->request()->getInt('user', 0));
		if (empty($aUser))
		{
			$this->url()->send('admincp',array(), Phpfox::getPhrase('user.that_user_does_not_exist'));
		}
		if (($sVal = $this->request()->get('action')) == 'proceed' && Phpfox::getService('user.auth')->snoop($aUser))
		{
			$this->url()->send('');
		}
		$this->template()
				->setHeader(array(
					'snoop.css' => 'module_user'
				))
				->setBreadCrumb(Phpfox::getPhrase('user.member_snoop'), null, true)
				->assign(array(
					'aUser' => $aUser,
					'user_name' => $aUser['user_name'],
					'full_name' => $aUser['full_name'],
					'user_link' => $this->url()->makeUrl($aUser['user_name'])

				));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>