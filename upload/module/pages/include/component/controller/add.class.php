<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');
define('PHPFOX_IS_PAGES_ADD', true);
/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: add.class.php 7101 2014-02-11 13:47:16Z Fern $
 */
class Pages_Component_Controller_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('pages.can_add_new_pages', true);
		
		Phpfox::getService('pages')->setIsInPage();
		
		$bIsEdit = false;
		$bIsNewPage = $this->request()->getInt('new');
		$sStep = $this->request()->get('req3');
		if (($iEditId = $this->request()->getInt('id')) && ($aPage = Phpfox::getService('pages')->getForEdit($iEditId)))			
		{
			$bIsEdit = true;
			$this->template()->assign('aForms', $aPage);
			
			$aMenus = array(
				'detail' => Phpfox::getPhrase('pages.details'),
				'info' => Phpfox::getPhrase('pages.information')				
			);
			
			if (!$aPage['is_app'])
			{
				$aMenus['photo'] = Phpfox::getPhrase('pages.photo');
			}
			$aMenus['permissions'] = Phpfox::getPhrase('pages.permissions');
			if (Phpfox::isModule('friend') && Phpfox::getUserBy('profile_page_id') == 0)
			{
				$aMenus['invite'] = Phpfox::getPhrase('pages.invite');
			}			
			if (!$bIsNewPage)
			{
				$aMenus['url'] = Phpfox::getPhrase('pages.url');
				$aMenus['admins'] = Phpfox::getPhrase('pages.admins');
				$aMenus['widget'] = Phpfox::getPhrase('pages.widgets');
			}
			
			if (Phpfox::getParam('core.google_api_key'))
			{
			    $aMenus['location'] = Phpfox::getPhrase('pages.location');
			}
			
			if ($bIsNewPage)
			{
				$iCnt = 0;
				foreach ($aMenus as $sMenuName => $sMenuValue)
				{
					$iCnt++;
					$aMenus[$sMenuName] = Phpfox::getPhrase('pages.step_count', array('count' => $iCnt)) . ': ' . $sMenuValue;
				}
			}
			
			
			$this->template()->buildPageMenu('js_pages_block', 
				$aMenus,
				array(
					'link' => Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'], $aPage['vanity_url']),
					'phrase' => ($bIsNewPage ? Phpfox::getPhrase('pages.skip_view_this_page') : Phpfox::getPhrase('pages.view_this_page'))
				)				
			);					
			
			if (($aVals = $this->request()->getArray('val')))
			{
				if (Phpfox::getService('pages.process')->update($aPage['page_id'], $aVals, $aPage))
				{
					if ($bIsNewPage && $this->request()->getInt('action') == '1')
					{
						switch ($sStep)
						{
							case 'invite':
								if (Phpfox::isModule('friend'))
								{
									$this->url()->send('pages.add.url', array('id' => $aPage['page_id'], 'new' => '1'));
								}
								break;							
							case 'permissions':
								$this->url()->send('pages.add.invite', array('id' => $aPage['page_id'], 'new' => '1'));
								break;									
							case 'photo':
								$this->url()->send('pages.add.permissions', array('id' => $aPage['page_id'], 'new' => '1'));
								break;						
							case 'info':
								$this->url()->send('pages.add.photo', array('id' => $aPage['page_id'], 'new' => '1'));
								break;
							default:
								$this->url()->send('pages.add.info', array('id' => $aPage['page_id'], 'new' => '1'));
								break;
						}
					}
					
					$aNewPage = Phpfox::getService('pages')->getForEdit($aPage['page_id']);
					
					$this->url()->forward(Phpfox::getService('pages')->getUrl($aNewPage['page_id'], $aNewPage['title'], $aNewPage['vanity_url']));
				}
			}
		}		
		
		
		if (Phpfox::getParam('core.google_api_key') != '' && $this->request()->get('id') != '')
		{
			$this->template()->setHeader(array(
				'<script type="text/javascript">oParams["core.google_api_key"] = "'.Phpfox::getParam('core.google_api_key') .'";</script>',
				'places.js' => 'module_pages',				
			));
			//d($aPage);
			if (isset($aPage['location']) && ( (int)$aPage['location_latitude'] != 0 || (int)$aPage['location_longitude'] != 0))
			{
				$this->template()->setHeader(array(
					'<script type="text/javascript">$Behavior.setLocation = function(){ $Core.PagesLocation.setLocation("'. $aPage['location_latitude'] .'","' . $aPage['location_longitude'] .'","'. $aPage['location']['name'] . '");};</script>'
				));
			}
		}
		
		$this->template()->setTitle(($bIsEdit ? '' . Phpfox::getPhrase('pages.editing_page') . ': ' . $aPage['title']: Phpfox::getPhrase('pages.creating_a_page')))
			->setBreadcrumb(Phpfox::getPhrase('pages.pages'), $this->url()->makeUrl('pages'))
			->setBreadcrumb(($bIsEdit ? '' . Phpfox::getPhrase('pages.editing_page') . ': ' . $aPage['title']: Phpfox::getPhrase('pages.creating_a_page')), $this->url()->makeUrl('pages.add'), true)
			->setEditor()
			->setFullSite()
			->setPhrase(array(
					'core.select_a_file_to_upload'
				)
			)			
			->setHeader(array(
					'pages.css' => 'style_css',
					'privacy.css' => 'module_user',
					'progress.js' => 'static_script',
					'pages.js' => 'module_pages'
				)
			)
			->setHeader(array('<script type="text/javascript">$Behavior.pagesProgressBarSettings = function(){ if ($Core.exists(\'#js_pages_block_customize_holder\')) { oProgressBar = {holder: \'#js_pages_block_customize_holder\', progress_id: \'#js_progress_bar\', uploader: \'#js_progress_uploader\', add_more: false, max_upload: 1, total: 1, frame_id: \'js_upload_frame\', file_id: \'image\'}; $Core.progressBarInit(); } }</script>'))			
			->assign(array(
					'aPermissions' => (isset($aPage) ? Phpfox::getService('pages')->getPerms($aPage['page_id']) : array()),
					'aTypes' => Phpfox::getService('pages.type')->get(),
					'bIsEdit' => $bIsEdit,
					'iMaxFileSize' => Phpfox::getLib('phpfox.file')->filesize((Phpfox::getUserParam('pages.max_upload_size_pages') / 1024) * 1048576),
					'aWidgetEdits' => Phpfox::getService('pages')->getWidgetsForEdit(),
					'bIsNewPage' => $bIsNewPage,
					'sStep' => $sStep
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('pages.component_controller_add_clean')) ? eval($sPlugin) : false);
	}
}

?>
