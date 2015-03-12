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
 * @package  		Module_Page
 * @version 		$Id: add.class.php 2847 2011-08-19 07:47:27Z Raymond_Benc $
 */
class Page_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$bIsEdit = false;
		$oSession = Phpfox::getLib('session');
		$aValidation = array(
			'product_id' => Phpfox::getPhrase('page.select_product'),
			'title' => Phpfox::getPhrase('page.missing_title'),
			'title_url' => Phpfox::getPhrase('page.missing_url_title'),
			'is_active' => Phpfox::getPhrase('page.specify_page_active'),
			'text' => Phpfox::getPhrase('page.page_missing_data')
		);		

		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));
		
		if (($iPageId = $this->request()->getInt('id')) || ($iPageId = $this->request()->getInt('page_id')))
		{
			Phpfox::getUserParam('page.can_manage_custom_pages', true);
			
			$aPage = Phpfox::getService('page')->getForEdit($iPageId);
			if (isset($aPage['page_id']))
			{
				$bIsEdit = true;
				// $aPage['attachment'] = (Phpfox::isModule('attachment') ? Phpfox::getService('attachment')->getForItemEdit($aPage['page_id'], 'page', Phpfox::getUserId()) : '');
			
				if (Phpfox::isModule('tag'))
				{
					$aTags = Phpfox::getService('tag')->getTagsById('page', $aPage['page_id']);
					if (isset($aTags[$aPage['page_id']]))
					{
						$aPage['tag_list'] = '';					
						foreach ($aTags[$aPage['page_id']] as $aTag)
						{
							$aPage['tag_list'] .= ' ' . $aTag['tag_text'] . ',';	
						}
						$aPage['tag_list'] = trim(trim($aPage['tag_list'], ','));
					}
				}
					
				$this->template()->assign(array(
						'aForms' => $aPage,
						'aAccess' => (empty($aPage['disallow_access']) ? null : unserialize($aPage['disallow_access']))
					)
				);
			}
		}		
		
		if ($aVals = $this->request()->getArray('val'))
		{			
			Phpfox::getLib('parse.input')->allowTitle(Phpfox::getLib('parse.input')->cleanTitle($aVals['title_url']), Phpfox::getPhrase('page.invalid_title'));	
			
			if ($oValid->isValid($aVals))
			{
				if ($bIsEdit)
				{
					$sMessage = Phpfox::getPhrase('page.page_successfully_updated');
					$sReturn = Phpfox::getService('page.process')->update($aPage['page_id'], $aVals, $aPage['user_id']);
					$aUrl = null;
				}
				else 
				{
					$sMessage = Phpfox::getPhrase('page.successfully_added');
					$sReturn = Phpfox::getService('page.process')->add($aVals);
					$aUrl = null;	
				}
				
				if ($sReturn)
				{
					if ($aVals['add_menu'])
					{
						$this->url()->send('admincp.menu.add', array('page' => $sReturn), Phpfox::getPhrase('page.page_added_continue'));
					}
					else 
					{
						$this->url()->send($sReturn, $aUrl, $sMessage);
					}
				}
			}
		}		

		$this->template()->setTitle(Phpfox::getPhrase('page.add_new_page'))
			->setBreadCrumb(Phpfox::getPhrase('page.add_new_page'))
			->assign(array(
					'aProducts' => Phpfox::getService('admincp.product')->get(),
					'aUserGroups' => Phpfox::getService('user.group')->get(),
					'sCreateJs' => $oValid->createJS(),
					'sGetJsForm' => $oValid->getJsForm(),			
					'bIsEdit' => $bIsEdit,
					'aModules' => Phpfox::getLib('module')->getModules(),
					'bFormIsPosted' => (count($aVals) ? true : false)
				)
			)				
			->setEditor()
			->setHeader(array(
				'jquery/plugin/jquery.highlightFade.js' => 'static_script',
				'switch_menu.js' => 'static_script',	
				'<script type="text/javascript">var Attachment = {sCategory: "page", iItemId: "' . (isset($aPage['page_id']) ? $aPage['page_id'] : '') . '"};</script>'
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('page.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>