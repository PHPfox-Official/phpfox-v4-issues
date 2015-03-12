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
class Emoticon_Component_Controller_Admincp_File extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (Phpfox::getParam('core.phpfox_is_hosted'))
		{
			$this->url()->send('admincp');
		}			
		
		$oArchiveExport = Phpfox::getLib('archive.export')->set(array('zip'));
		$oArchiveImport = Phpfox::getLib('archive.import')->set(array('zip'));
		
		if (($sExportId = $this->request()->get('id')) && !empty($sExportId))
		{
			if ($sData = Phpfox::getService('emoticon')->export($sExportId))
			{
				$oArchiveExport->download('phpfox-emoticon-' . $sExportId, 'xml', $sData);
			}
		}
		
		if (isset($_FILES['import']) && ($aFile = $_FILES['import']))
		{			
			if (preg_match('/^phpfox-emoticon-(.*?)\.xml$/i', $aFile['name'], $aMatches))
            {
				if ($sXmlData = file_get_contents($aFile['tmp_name']))
				{									
					$aParams = Phpfox::getLib('xml.parser')->parse($sXmlData);
					
					if (($mReturn = Phpfox::getService('emoticon.process')->import($this->request()->getArray('val'), $aParams)) && is_array($mReturn))
					{		
						$this->url()->send('admincp.emoticon.view', array('id' => $mReturn['id']), Phpfox::getPhrase('emoticon.emoticon_package_successfully_created', array('success' => $mReturn['success'], 'failed' => $mReturn['failed'])));
					}
				}
            }
            else 
            {
            	Phpfox_Error::set(Phpfox::getPhrase('emoticon.not_a_valid_emoticon_package_to_import'));
            }
		}		
		
		$this->template()->setTitle(Phpfox::getPhrase('emoticon.import_emoticons'))
				->setBreadcrumb(Phpfox::getPhrase('emoticon.emoticons'), $this->url()->makeUrl('admincp.emoticon.package'))
				->setBreadCrumb(Phpfox::getPhrase('emoticon.import_emoticons'), null, true);				
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('emoticon.component_controller_admincp_file_clean')) ? eval($sPlugin) : false);
	}
}

?>