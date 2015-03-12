<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel_Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: index.class.php 786 2009-07-21 13:42:56Z Miguel_Espinoza $
 */
class Emoticon_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->url()->send('admincp.emoticon.package', null, 'That package does not exist.');
		if ($sAction = $this->request()->get('req4'))
		{
			die(d($sAction));
		}

		if ($iId = $this->request()->getInt('packageid'))
		{
			$aPackages = Phpfox::getService('emoticon')->getPackages($iId);
		}
		else
		{
			$aPackages = Phpfox::getService('emoticon')->getPackages();
		}
		if (empty($aPackages))
		{
			$this->url()->send('admincp.emoticon.manage'. null, 'That package does not exist.');
		}

		$this->template()->setTitle('Manage Emoticons')
			->setBreadcrumb('Manage Emoticons')
			->assign(array(
				'aPackages' => $aPackages
			));
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('event.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>