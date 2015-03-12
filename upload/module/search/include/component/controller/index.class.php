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
 * @package  		Module_Search
 * @version 		$Id: index.class.php 4489 2012-07-10 08:57:27Z Raymond_Benc $
 */
class Search_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		Phpfox::getUserParam('search.can_use_global_search', true);
		
		$this->template()->setHeader(array(
					'search.css' => 'style_css'
				)
			)
			->setTitle(Phpfox::getPhrase('search.results'))
			->setBreadcrumb(Phpfox::getPhrase('search.search'), $this->url()->makeUrl('search'));
		
		$sQuery = $this->request()->get('q', null);
		$sView = $this->request()->get('view', null);
		$sGetHistory = $this->request()->get('history');
		if ($this->request()->get('encode'))
		{
			$sQuery = urldecode($sQuery);
		}
		$iTotalShow = 10;
		$iPage = $this->request()->getInt('page');	
		
		if ($sQuery !== null)
		{		
			if (empty($sQuery))
			{
				Phpfox_Error::set(Phpfox::getPhrase('search.provide_a_search_query'));	
			}
			else 
			{
				$aSearchResults = Phpfox::getService('search')->query($sQuery, $iPage, $iTotalShow, $sView);
				
				if (count($aSearchResults))
				{
					$aFilterMenu = array(
						Phpfox::getPhrase('search.all_results') => $this->url()->makeUrl('search', array('q' => urlencode($sQuery), 'encode' => '1'))
					);
					
					if (empty($sGetHistory))
					{
						$sHistory = '';
						foreach ($aSearchResults as $aSearchResult)
						{
							if (isset($aSearchTypes[$aSearchResult['item_type_id']]))
							{
								continue;
							}	
		
							$aSearchTypes[$aSearchResult['item_type_id']] = true;
							$sHistory .= $aSearchResult['item_type_id'] . ',';
						}
						$sHistory = rtrim($sHistory, ',');
					}
					else 
					{
						$sHistory = $sGetHistory;			
					}
					
					$aHistoryParts = explode(',', $sHistory);
					
					foreach ($aHistoryParts as $sHistoryPart)
					{					
						$aSearchInfo = Phpfox::callback($sHistoryPart . '.getSearchTitleInfo');					
	
						$aFilterMenu[$aSearchInfo['name']] = $this->url()->makeUrl('search', array('q' => urlencode($sQuery), 'view' => $sHistoryPart, 'encode' => '1', 'history' => $sHistory));
					}
					
					$this->template()->buildSectionMenu('search', $aFilterMenu);
			
					$this->template()->setBreadcrumb(Phpfox::getPhrase('search.results_for') . ': ' . $sQuery, '', true)
						->assign(array(
							'aSearchResults' => $aSearchResults,
							'sQuery' => $sQuery,
							'sNextPage' => 'q=' . urlencode($sQuery) . '&amp;encode=1&amp;view=' . $sView . '&amp;history=' . $sHistory . '&amp;page=' . ($iPage + 1)
						)
					);			
				}
			}	
		}		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('search.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>