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
 * @package  		Module_Admincp
 * @version 		$Id: file.class.php 852 2009-08-10 18:05:32Z Raymond_Benc $
 */
class Admincp_Component_Controller_Setting_File extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		$aValidExt = array(
			'xml',
			'zip',
			'tar.gz'
		);
		
		$oArchiveExport = Phpfox::getLib('archive.export')->set($aValidExt);
		$oArchiveImport = Phpfox::getLib('archive.import')->set($aValidExt);
		
		// Run the export routine
		if ($iExportId = $this->request()->get('export'))
		{
			if ($sXml = Phpfox::getService('admincp.setting')->export($iExportId))
			{		
				$oArchiveExport->download($this->request()->get('file_extension'), 'phpfox_setting.xml', $sXml);
			}
		}

		// Run the import routine
		if (($aFile = $this->request()->get('import')))
		{
			if ($sXmlData = $oArchiveImport->process($aFile))
			{			
				$aParams = Phpfox::getLib('xml.parser')->parse($sXmlData);
				
				// Import the settings
				if (($iImported = Phpfox::getService('admincp.setting.process')->import($aParams, true)))
				{
					// Settings imported, mention how many settings were imported.
					$this->url()->send('admincp', array('setting', 'file'), Phpfox::getPhrase('admincp.setting_imported', array('total' => $iImported)));
				}
				else 
				{
					if (is_numeric($iImported))
					{
						// Nothing new to import
						Phpfox_Error::set(Phpfox::getPhrase('admincp.nothing_new_import'));
					}
				}				
			}
		}
		
		// Assign needed vars to the template
		$this->template()->assign(array(
			'aProducts' => Phpfox::getService('admincp.product')->get(),
			'aArchives' => $oArchiveExport->getSupported(),
			'sSupported' => $oArchiveImport->getSupported()
		))->setBreadCrumb(Phpfox::getPhrase('admincp.import_export_settings'))
			->setTitle(Phpfox::getPhrase('admincp.import_export_settings'));		
			
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_setting_file_process')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_setting_file_clean')) ? eval($sPlugin) : false);
	}
}

?>