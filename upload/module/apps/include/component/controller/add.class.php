<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Apps_Component_Controller_Add extends Phpfox_Component
{
	/**
	 * This controller orchestrates to register a new application
	 */
	public function process()
	{
		$bIsAdd = $bIsEdit = false;
		Phpfox::getUserParam('apps.can_add_app', true);
		if (!Phpfox::getParam('apps.enable_api_support'))
		{
			//return Phpfox_Error::display('No api');
		}
		if (($aVals = $this->request()->getArray('app')))
		{
			$bIsAdd = true;
			$aApp = Phpfox::getService('apps.process')->addApp($aVals);
			if ($aApp == false)
			{				
				$this->template()->assign(array('sErrorMessage' => Phpfox_Error::get()));
			}
			else
			{
				$this->url()->send('apps.add', array('id' => $aApp['app_id']), Phpfox::getPhrase('apps.app_successfully_created'));
			}			
		}
		
		
		if (($iId = $this->request()->getInt('id')) && $this->request()->get('req2') == 'add')
		{
			// is editing an app
			$aApp = Phpfox::getService('apps')->getAppById($iId);
			$this->template()->assign('aForms', $aApp);
			
			$bIsEdit = true;
			$aMenus = array(
				'general' => Phpfox::getPhrase('apps.general'),			
				'photo' => Phpfox::getPhrase('apps.photo'),
				'url' => Phpfox::getPhrase('apps.url'),
			);	
			$this->template()->buildPageMenu('js_apps_block', 
				$aMenus,
				array(
					'link' => Phpfox::permalink('apps', $aApp['app_id'], $aApp['app_title']),
					'phrase' => Phpfox::getPhrase('apps.view_this_app')
				)				
			);
			if (($aVals = $this->request()->getArray('val')))
			{
				if (Phpfox::getService('apps.process')->updateApp($aVals, $aApp))
				{
					$this->url()->send('apps.add', array('id' => $aApp['app_id']), Phpfox::getPhrase('apps.successfully_updated_the_app'));
				}
			}
			
			// check that this user is owner of the app
			// we can have a user group setting here
			if ($aApp['user_id'] != Phpfox::getUserId() && !Phpfox::isAdmin()) 
			{
				Phpfox_Error::display(Phpfox::getPhrase('apps.you_are_not_allowed_to_edit_this_app'));
			}
			else
			{
				$this->template()->assign(array(
							'aApp' => $aApp
						)
					)->setHeader(array(
							'index.js' => 'module_apps'
						)
					);
			}
		}		
		
		$aCategories = Phpfox::getService('apps.category')->getAllCategories();
		
		$this->template()->setTitle($bIsEdit ? Phpfox::getPhrase('apps.editing_app') . ': ' . $aApp['app_title'] : Phpfox::getPhrase('apps.create_an_app'))
				->setFullSite()
				->setBreadcrumb(Phpfox::getPhrase('apps.apps'), $this->url()->makeUrl('apps'))
				->setBreadcrumb($bIsEdit ? Phpfox::getPhrase('apps.editing_app') . ': ' . $aApp['app_title'] : Phpfox::getPhrase('apps.create_an_app'), $this->url()->makeUrl('apps.add'), true)				
				->assign(array(
					'aCategories' => $aCategories
				)
			);			
	}
}
?>
