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
 * @version 		$Id: index.class.php 6113 2013-06-21 13:58:40Z Raymond_Benc $
 */
class Core_Component_Controller_Admincp_Country_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($sExport = $this->request()->get('export')))
		{
			$oArchiveExport = Phpfox::getLib('archive.export')->set(array('zip'));
			if (($aData = Phpfox::getService('core.country')->export($sExport)))
			{
				$oArchiveExport->download('phpfox-country-' . $aData['name'] . '', 'xml', $aData['file']);
			}			
		}
		
		if (($sIso = $this->request()->get('delete')))
		{
			if (Phpfox::getService('core.country.process')->delete($sIso))
			{
				$this->url()->send('admincp.core.country', null, Phpfox::getPhrase('admincp.country_successfully_deleted'));
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.country_manager'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.country_manager'), $this->url()->makeUrl('admincp.core.country'))
			->setHeader('cache', array(
					'drag.js' => 'static_script',
					'<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'core.countryOrdering\'}); }</script>'
				)
			)			
			->assign(array(
					'aCountries' => Phpfox::getService('core.country')->getForEdit()
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_admincp_country_index_clean')) ? eval($sPlugin) : false);
	}
}

?>