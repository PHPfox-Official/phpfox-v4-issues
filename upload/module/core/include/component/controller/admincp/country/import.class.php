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
 * @version 		$Id: import.class.php 1572 2010-05-06 12:37:24Z Raymond_Benc $
 */
class Core_Component_Controller_Admincp_Country_Import extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$oArchiveImport = Phpfox::getLib('archive.import')->set(array('zip'));
		$bOverwrite = ($this->request()->getInt('overwrite') ? true : false);		
		
		if (isset($_FILES['file_import']) && ($aFile = $_FILES['file_import']) && ($aVals = $this->request()->getArray('val')))
		{
			if (($aLog = Phpfox::getService('core.country.process')->importFromText($aVals, $aFile)) && $aLog['completed'] > 0)
			{
				$this->url()->send('admincp.core.country.child', array('id' => $aVals['country_iso']), Phpfox::getPhrase('admincp.text_import_successfully_completed', array('completed' => $aLog['completed'], 'failed' => $aLog['failed'])));
			}
		}
		
		if (isset($_FILES['import']) && ($aFile = $_FILES['import']))
		{
			if (Phpfox::getService('core.country.process')->import($aFile, $bOverwrite))
			{
				$this->url()->send('admincp.core.country', null, Phpfox::getPhrase('admincp.import_successfully_completed'));
			}
		}		
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.import_countries_states_provinces'))	
			->setBreadcrumb(Phpfox::getPhrase('admincp.country_manager'), $this->url()->makeUrl('admincp.core.country'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.import'), null, true)
			->assign(array(
					
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_admincp_country_import_clean')) ? eval($sPlugin) : false);
	}
}

?>