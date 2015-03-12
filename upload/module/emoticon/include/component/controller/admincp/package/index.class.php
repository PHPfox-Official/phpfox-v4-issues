<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel_Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: index.class.php 1121 2009-10-01 12:59:13Z Raymond_Benc $
 */
class Emoticon_Component_Controller_Admincp_Package_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{

		if ($iId = $this->request()->getInt('id'))
		{
			$aPackages = Phpfox::getService('emoticon')->getPackages($iId);
		}
		else
		{
			$aPackages = Phpfox::getService('emoticon')->getPackages();
		}

		if ($iId = $this->request()->get('delete'))
		{			
			Phpfox::getService('emoticon.process')->deletePackage($iId);
			$this->url()->send('admincp.emoticon.package', null, Phpfox::getPhrase('emoticon.package_successfully_deleted'));
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('emoticon.emoticons'))
			->setBreadcrumb(Phpfox::getPhrase('emoticon.emoticons'), $this->url()->makeUrl('admincp.emoticon.package'))
			->assign(array(
					'aPackages' => $aPackages
				)
			);
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