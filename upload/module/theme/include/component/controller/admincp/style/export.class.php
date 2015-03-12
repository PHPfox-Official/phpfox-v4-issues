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
 * @version 		$Id: export.class.php 1146 2009-10-06 18:36:51Z Raymond_Benc $
 */
class Theme_Component_Controller_Admincp_Style_Export extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$oArchiveExport = Phpfox::getLib('archive.export')->set(array('zip'));
		if (($aData = Phpfox::getService('theme.style')->export($this->request()->getInt('id'))))
		{
			$oArchiveExport->download('phpfox-style-' . $aData['name'] . '', 'zip', $aData['folder']);
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('theme.component_controller_admincp_style_export_clean')) ? eval($sPlugin) : false);
	}
}

?>