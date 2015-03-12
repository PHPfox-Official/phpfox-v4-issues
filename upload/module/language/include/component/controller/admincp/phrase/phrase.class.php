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
 * @package  		Module_Language
 * @version 		$Id: phrase.class.php 5538 2013-03-25 13:20:22Z Miguel_Espinoza $
 */
class Language_Component_Controller_Admincp_Phrase_Phrase extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		Phpfox::getUserParam('language.can_manage_lang_packs', true);
		
		$iPage = $this->request()->getInt('page');
		$oPhraseProcess = Phpfox::getService('language.phrase.process');
		$oCache = Phpfox::getLib('cache');
		
		if ($this->request()->get('save') && ($aTexts = $this->request()->getArray('text')))
		{
			foreach ($aTexts as $iKey => $sText)
			{			
				$oPhraseProcess->update($iKey, $sText);
			}
			
			$oCache->remove('locale', 'substr');
			
			$this->url()->send('current', null, Phpfox::getPhrase('language.phrase_s_updated'));
		}
		
		if ($this->request()->get('save_selected') && ($aTexts = $this->request()->getArray('text')) && ($aIds = $this->request()->getArray('id')))
		{			
			foreach ($aTexts as $iKey => $sText)
			{
				if (!in_array($iKey, $aIds))
				{
					continue;
				}
				$oPhraseProcess->update($iKey, $sText);
			}
			
			$oCache->remove('locale', 'substr');
			
			$this->url()->send('current', null, Phpfox::getPhrase('language.phrase_s_updated'));
		}
		
		if ($this->request()->get('revert_selected') && ($aIds = $this->request()->getArray('id')))
		{
			if ($oPhraseProcess->revert($aIds))
			{
				$oCache->remove('locale', 'substr');
				$this->url()->send('current', null, Phpfox::getPhrase('language.selected_phrase_s_successfully_reverted'));
			}			
		}
		
		if ($this->request()->get('delete') && ($aIds = $this->request()->getArray('id')))
		{			
			foreach ($aIds as $iId)
			{
				$oPhraseProcess->delete($iId);
			}			
			
			$oCache->remove('locale', 'substr');
			
			$this->url()->send('current', null, Phpfox::getPhrase('language.selected_phrase_s_successfully_deleted'));
		}
		
		$aModules = Phpfox::getService('admincp.module')->getModules();
		$aModules = array_flip($aModules);
		
		$aLanguages = Phpfox::getService('language')->get();		
		$aLangs = array();
		foreach ($aLanguages as $aLanguage)
		{
			$aLangs[$aLanguage['language_id']] = $aLanguage['title'];
		}		
		
		$aPages = array(20, 40, 60, 80, 100);
		$aDisplays = array();
		foreach ($aPages as $iPageCnt)
		{
			$aDisplays[$iPageCnt] = Phpfox::getPhrase('core.per_page', array('total' => $iPageCnt));
		}		
		
		$aSorts = array(
			'added' => Phpfox::getPhrase('core.time'),
			'phrase_id' => Phpfox::getPhrase('language.phrase_id')
		);
				
		$aFilters = array(
			'display' => array(
				'type' => 'select',
				'options' => $aDisplays,
				'default' => '20'
			),
			'sort' => array(
				'type' => 'select',
				'options' => $aSorts,
				'default' => 'added',
				'alias' => 'lp'
			),
			'sort_by' => array(
				'type' => 'select',
				'options' => array(
					'DESC' => Phpfox::getPhrase('core.descending'),
					'ASC' => Phpfox::getPhrase('core.ascending')
				),
				'default' => 'DESC'
			),
			'module_id' => array(
				'type' => 'select',
				'options' => $aModules,
				'add_select' => true,
				'search' => "AND lp.module_id = '[VALUE]'"
			),
			'language_id' => array(
				'type' => 'select',
				'options' => $aLangs,
				'add_select' => true,
				'search' => "AND lp.language_id = '[VALUE]'",
				'id' => 'js_language_id'
			),
			'translate_type' => array(
				'type' => 'select',
				'options' => array(
					'0' => Phpfox::getPhrase('language.all_phrases'),
					'1' => Phpfox::getPhrase('language.not_translated'),
					'2' => Phpfox::getPhrase('language.translated_only'),
				)				
			),			
			'search' => array(
				'type' => 'input:text',
			),
			'search_type' => array(
				'type' => 'input:radio',
				'options' => array(
					'0' => array(Phpfox::getPhrase('language.phrase_text_only'), "AND lp.text LIKE '%[VALUE]%'"),
					'1' => array(Phpfox::getPhrase('language.phrase_variable_name_only'), "AND lp.var_name LIKE '%[VALUE]%'"),
					'2' => array(Phpfox::getPhrase('language.phrase_text_and_phrase_variable_name'), "AND (lp.text LIKE '%[VALUE]%' OR lp.var_name LIKE '%[VALUE]%')")
				),	
				'depend' => 'search',
				'prefix' => '<div>',
				'suffix' => '</div>',
				'default' => '0'
			)		
		);
		
		$oSearch = Phpfox::getLib('search')->set(array(
			'type' => 'phrases',
			'filters' => $aFilters,
			'cache' => true,
			'field' => 'lp.phrase_id',
			'search' => 'search'
		));		
		
		if ($oSearch->isSearch())
		{			
			$aResults = Phpfox::getService('language.phrase')->getSearch($oSearch->getConditions(), $oSearch->getSort());
			if (count($aResults))
			{
				$oSearch->cacheResults('search', $aResults);
			}
		}
		
		$bIsForceLanguagePackage = false;
		if ($iLangId = $this->request()->get('lang-id'))
		{
			$bIsForceLanguagePackage = true;
			$oSearch->setCondition('AND lp.language_id = \'' . Phpfox::getLib('database')->escape($iLangId) . '\'');
			$this->template()->setHeader('<script type="text/javascript">$Behavior.language_admincp_phrase = function(){ $(\'#js_language_id\').val(\'' . $iLangId. '\'); };</script>');
		}
		
		if (empty($iLangId) && ($iLangId = $oSearch->get('language_id')))
		{
		}
		
		if (($sTranslate = $oSearch->get('translate_type')))
		{
			if ($sTranslate == '1')
			{
				$oSearch->setCondition('AND lp.text = lp.text_default');	
			}
			elseif ($sTranslate == '2')
			{
				$oSearch->setCondition('AND lp.text != lp.text_default');	
			}
		}
		
		$iPageSize = $oSearch->getDisplay();
		
		list($iCnt, $aRows) = Phpfox::getService('language.phrase')->get($oSearch->getConditions(), $oSearch->getSort(), $oSearch->getPage(), $iPageSize);

		$oSearchOutput = Phpfox::getLib('parse.output');
		$aOut = array();
		foreach ($aRows as $iKey => $aRow)
		{
			$aOut[$aRow['phrase_id']] = $aRow;
			$aOut[$aRow['phrase_id']]['sample_text'] = $oSearch->highlight('search', $oSearchOutput->htmlspecialchars($aRow['text_default']));	
			$aOut[$aRow['phrase_id']]['is_translated'] = (md5($aRow['text_default']) != md5($aRow['text']) ? true : false);
		}
		$aRows = $aOut;
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $oSearch->getSearchTotal($iCnt)));
			
		$this->template()->assign(array(
			'aRows' => $aRows,
			'iPage' => $iPage,
			'sSearchId' => $this->request()->get('search-rid'),
			'sSearchIdNormal' => $this->request()->get('search-id'),
			'iLangId' => $iLangId,
			'bIsForceLanguagePackage' => $bIsForceLanguagePackage
		))->setBreadCrumb(Phpfox::getPhrase('language.phrase_manager'))
			->setTitle(Phpfox::getPhrase('language.phrase_manager'));
	}
}

?>
