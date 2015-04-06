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
 * @version 		$Id: reparser.class.php 1604 2010-05-31 06:42:26Z Raymond_Benc $
 */
class Admincp_Component_Controller_Maintain_Reparser extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$aModules = Phpfox::massCallback('reparserList');
		foreach ($aModules as $iKey => $aModule)
		{
			if (!isset($aModule['name']))
			{
				unset($aModules[$iKey]);
				$iCnt = 0;
				foreach ($aModule as $iModuleKey => $aCacheModule)
				{					
					$iCnt++;
					$aModules = array_merge($aModules, array('custom' . $iCnt => $aCacheModule));
				}
			}
		}		
		
		foreach ($aModules as $iKey => $aModule)
		{
			if (!isset($aModule['name']))
			{
				foreach ($aModule as $iSubKey => $aSub)
				{
					$aModules[$iKey . '_' . $iSubKey] = $aSub;
				}
				
				unset($aModules[$iKey]);	
			}
			
			if (is_array($aModule['table']))
			{
				$aModule['table'] = $aModule['table'][0];
			}
			
			$aModules[$iKey]['total_record'] = Phpfox_Database::instance()->select('COUNT(*)')
				->from(Phpfox::getT($aModule['table']))
				->execute('getSlaveField');
				
			if ($aModules[$iKey]['total_record'] == 0)
			{
				unset($aModules[$iKey]);
			}
		}
		$iPage = $this->request()->get('page');
		$iLimit = 200;
		
		if (($sModule = $this->request()->get('module')) && isset($aModules[$sModule]))
		{			
			$iCnt = Phpfox::getService('admincp.maintain')->reParseText($aModules[$sModule], $iPage, $iLimit);
			
			Phpfox_Pager::instance()->set(array('page' => $iPage, 'size' => $iLimit, 'count' => $iCnt));
			
			$iTotalPages = (int) Phpfox_Pager::instance()->getTotalPages();
			$iCurrentPage = (int) Phpfox_Pager::instance()->getCurrentPage();
			$iPage = (int) Phpfox_Pager::instance()->getNextPage();
			
			if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
			{				
				$this->url()->send('admincp.maintain.reparser', null, Phpfox::getPhrase('admincp.parsing_completed'));
			}
			else 
			{
				$this->template()->assign(array(
							'bInProcess' => true,
							'iCurrentPage' => $iCurrentPage,
							'iTotalPages' => $iTotalPages
						)
					)
					->setHeader(array(
						'<meta http-equiv="refresh" content="2;url=' . Phpfox_Url::instance()->makeUrl('admincp.maintain.reparser', array('module' => $sModule, 'page' => $iPage)) . '" />'
					)
				);
			}	
		}		
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.text_reparser'))
			->setSectionTitle('Content Re-Parser')
			->assign(array(
				'aReparserLists' => $aModules
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_maintain_reparser_clean')) ? eval($sPlugin) : false);
	}
}

?>