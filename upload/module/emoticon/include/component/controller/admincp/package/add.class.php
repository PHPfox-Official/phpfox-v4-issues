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
 * @version 		$Id: add.class.php 1121 2009-10-01 12:59:13Z Raymond_Benc $
 */
class Emoticon_Component_Controller_Admincp_Package_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		// is user adding a package
		if ($aVal = $this->request()->getArray('val'))
		{			
			if ($sId = Phpfox::getService('emoticon.process')->addPackage($aVal))
			{
				if (isset($aVal['package_path']))
				{
					$this->url()->send('admincp.emoticon.package.add', array('id' => $aVal['package_path']), Phpfox::getPhrase('emoticon.package_successfully_updated'));
				}
				else
				{
					if (empty($_FILES['import']['name']))
					{
						$this->url()->send('admincp.emoticon.add', null, Phpfox::getPhrase('emoticon.package_successfully_added'));
					}
					else 
					{
						$this->url()->send('admincp.emoticon.view', array('id' => $sId), Phpfox::getPhrase('emoticon.package_successfully_added'));
					}
				}
				
			}
		}

		if ($sId = $this->request()->get('id'))
		{ // is editing
			$aPackages = Phpfox::getService('emoticon')->getPackages($sId);
			$this->template()
				->assign(array('aForms' => reset($aPackages)))				
				->setTitle(Phpfox::getPhrase('emoticon.edit_package'))
				->setBreadcrumb(Phpfox::getPhrase('emoticon.emoticons'), $this->url()->makeUrl('admincp.emoticon.package'))
				->setBreadcrumb(Phpfox::getPhrase('emoticon.edit_package'), null, true);
		}
		else
		{
			$this->template()
				->setTitle(Phpfox::getPhrase('emoticon.add_package'))
				->setBreadcrumb(Phpfox::getPhrase('emoticon.emoticons'), $this->url()->makeUrl('admincp.emoticon.package'))
				->setBreadcrumb(Phpfox::getPhrase('emoticon.add_package'), null, true)
				->assign(array(
					'aPackage' => array()
				)
			);
		}
		
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