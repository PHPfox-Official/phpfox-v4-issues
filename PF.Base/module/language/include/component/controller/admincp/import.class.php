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
 * @version 		$Id: import.class.php 4961 2012-10-29 07:11:34Z Raymond_Benc $
 */
class Language_Component_Controller_Admincp_Import extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{		
		$iPage = $this->request()->getInt('page', 0);
		$bImportPhrases = false;
		$base = true;

		if ($install = $this->request()->get('install')) {
			$base = false;
			$dir = PHPFOX_DIR_INCLUDE . 'xml/language/' . $install . '/';
			Language_Service_Process::instance()->installPackFromFolder($install, $dir);

			$this->request()->set('dir', $dir);
			if (!is_dir($dir)) {
				Phpfox_Error::set('Language package cannot be found at: ' . $dir);
			}
		}

		if (($dir = $this->request()->get('dir'))) {
			$dir = ($base ? base64_decode($dir) : $dir);
			$parts = explode('language/', rtrim($dir, '/'));

			$bImportPhrases = true;
			$mReturn = Language_Service_Phrase_Process::instance()->installFromFolder($parts[1], $dir, $iPage);
			if ($mReturn === 'done')
			{
				$sPhrase = Phpfox::getPhrase('language.successfully_installed_the_language_package');

				Phpfox::getLib('cache')->remove('locale', 'substr');

				$this->url()->send('admincp.language', null, $sPhrase);
			}
			else
			{
				if ($mReturn)
				{
					$this->template()->setHeader('<meta http-equiv="refresh" content="2;url=' . $this->url()->makeUrl('admincp.language.import', array('dir' => base64_encode($dir), 'page' => ($iPage + 1))) . '">');
				}
			}
		}

		/*
		if (($sModulePackage = $this->request()->get('module')) || $this->request()->get('dir'))
		{
			if ($this->request()->get('dir'))
			{
				$sModulePackage = array($this->request()->get('dir'), $this->request()->get('module'));
			}
			$bImportPhrases = true;
			$mReturn = Phpfox::getService('language.phrase.process')->installFromFolder($sModulePackage, $iPage);
			
			if ($mReturn === 'done')
			{
				$sPhrase = Phpfox::getPhrase('language.successfully_installed_the_language_package');
				
				Phpfox::getLib('cache')->remove('locale', 'substr');
				
				$this->url()->send('admincp.language', null, $sPhrase);
			}
			else
			{
				if ($mReturn)
				{
					if ($this->request()->get('dir'))
					{
						$this->template()->setHeader('<meta http-equiv="refresh" content="2;url=' . $this->url()->makeUrl('admincp.language.import', array('module' => $this->request()->get('module'), 'dir' => $this->request()->get('dir'), 'page' => ($iPage + 1))) . '">');
					}
					else
					{
						$this->template()->setHeader('<meta http-equiv="refresh" content="2;url=' . $this->url()->makeUrl('admincp.language.import', array('module' => $sModulePackage, 'page' => ($iPage + 1))) . '">');
					}
				}
			}
		}
		else
		{
			$sDir = '';
			if (!empty($_FILES['import']) && Phpfox::getParam('core.is_auto_hosted'))
			{
				$sDir = PHPFOX_DIR_CACHE . md5($_FILES['import']['name']) . PHPFOX_DS;
				if (!is_dir($sDir))
				{
					mkdir($sDir);
					chdir($sDir);
					shell_exec('unzip ' . $_FILES['import']['tmp_name']);
				}	
				$sDir = $sDir . 'upload' . PHPFOX_DS;
			}
			
			if ((($sPackToInstall = $this->request()->get('install')) || !empty($sDir)) && Phpfox::getService('language.process')->installPackFromFolder($sPackToInstall, $sDir))
			{
				if (!empty($sDir))
				{
					preg_match('/phpfox-language-([a-zA-Z0-9]+)\.zip/i', $_FILES['import']['name'], $aMatches);					
					
					$this->url()->send('admincp.language.import', array('module' => $aMatches[1], 'dir' => md5($_FILES['import']['name'])));
				}
				$this->url()->send('admincp.language.import', array('module' => $sPackToInstall));
			}		
		}
		*/
		
		$this->template()->setTitle(Phpfox::getPhrase('language.manage_language_packages'))
			->setBreadCrumb(Phpfox::getPhrase('language.manage_language_packages'))
			->assign(array(
					'aNewLanguages' => Phpfox::getService('language')->getForInstall(),
					'bImportPhrases' => $bImportPhrases
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('language.component_controller_admincp_import_clean')) ? eval($sPlugin) : false);
	}
}

?>
