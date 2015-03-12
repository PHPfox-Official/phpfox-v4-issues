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
class Language_Component_Controller_Admincp_Missing extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aLanguage = Phpfox::getService('language')->getLanguage($this->request()->get('id'));
		if (!isset($aLanguage['language_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('language.not_a_valid_language_package'));
		}
		
		$iPage = $this->request()->getInt('page', 0);
		
		$aXml = Phpfox::getService('core')->getModulePager('phrases', $iPage, 5);
		
		if ($aXml === false)
		{
			$sPhrase = Phpfox::getPhrase('language.successfully_imported_missing_phrases');
			
			Phpfox::getLib('cache')->remove('locale', 'substr');
			
			if ($this->request()->get('check') == 'true')
			{
				$this->url()->send('admincp.language', null, $sPhrase);	
			}
			else 
			{
				$this->url()->send('admincp.language.missing', array('id' => $aLanguage['language_id'], 'check' => 'true'));
			}			
		}
		
		$aModules = array();
		if (is_array($aXml))
		{
			$iMissing = Phpfox::getService('language.phrase.process')->findMissingPhrases($aLanguage['language_id'], $aXml, ($this->request()->get('check') == 'true' ? true : false));
			
			foreach ($aXml as $sModule => $sPhrases)
			{
				$aModules[] = $sModule;
			}
			
			$this->template()->setHeader('<meta http-equiv="refresh" content="2;url=' . $this->url()->makeUrl('admincp.language.missing', array('id' => $aLanguage['language_id'], 'check' => $this->request()->get('check'), 'page' => ($iPage + 1))) . '">');
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('language.find_missing_phrases'))
			->setBreadcrumb(Phpfox::getPhrase('language.manage_language_packages'), $this->url()->makeUrl('admincp.language'))
			->setBreadcrumb(Phpfox::getPhrase('language.find_missing_phrases'), $this->url()->makeUrl('current'))
			->setBreadcrumb($aLanguage['title'], null, true)
			->assign(array(
					'aModules' => $aModules,
					'iMissing' => $iMissing
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('language.component_controller_admincp_missing_clean')) ? eval($sPlugin) : false);
	}
}

?>
