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
class Language_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		if (($sLangId = $this->request()->get('id')))
		{
			if (($aLanguage = Phpfox::getService('language')->getLanguage($sLangId)) && isset($aLanguage['language_id']))
			{
				$bIsEdit = true;
				$this->template()->assign(array(
						'aForms' => $aLanguage
					)
				);
			}
		}
		
		if (($sLanguageId = $this->request()->get('import-phrase')))
		{
			$iPage = $this->request()->getInt('page', 0);
			$iLimit = 500;
			
			$iCnt = Phpfox::getService('language.phrase.process')->importPhrases($sLanguageId, $iPage, $iLimit);			
			
			Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iLimit, 'count' => $iCnt));
			
			$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();		
			$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();		
			$iPage = (int) Phpfox::getLib('pager')->getNextPage();					
			
			if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
			{
				$this->url()->send('admincp.language', null, Phpfox::getPhrase('language.language_package_successfully_added'));
			}			
			
			$this->template()
				->setHeader('<meta http-equiv="refresh" content="2;url=' . $this->url()->makeUrl('admincp.language.add', array('import-phrase' => $sLanguageId, 'page' => $iPage)) . '">')
				->assign(array(
					'bImportingPhrases' => true,
					'iCurrentPage' => $iCurrentPage,
					'iTotalPages' => $iTotalPages
				)
			);						
		}
		else 
		{
			if (($aVals = $this->request()->getArray('val')))
			{
				if ($bIsEdit)
				{
					if (Phpfox::getService('language.process')->update($sLangId, $aVals))
					{
						$this->url()->send('admincp.language.add', array('id' => $sLangId), Phpfox::getPhrase('language.language_package_successfully_updated'));
					}
				}
				else 
				{
					if (($sLanguageId = Phpfox::getService('language.process')->add($aVals)))
					{
						$this->url()->send('admincp.language.add', array('import-phrase' => $sLanguageId));
					}
				}
			}		
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('language.editing_language_package') . ': ' . $aLanguage['title'] : Phpfox::getPhrase('language.create_a_new_language_package')))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('language.editing_language_package') . ': ' . $aLanguage['title'] : Phpfox::getPhrase('language.create_language_package')))
			->assign(array(
					'aLanguages' => Phpfox::getService('language')->getAll(),
					'bIsEdit' => $bIsEdit
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('language.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>