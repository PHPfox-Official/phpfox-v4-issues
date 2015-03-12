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
class Core_Component_Controller_Admincp_Country_Child_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$mCountry = Phpfox::getService('core.country')->getCountry($this->request()->get('id'));
		
		if ($mCountry === false)
		{
			return Phpfox_Error::display(Phpfox::getPhrase('admincp.not_a_valid_country'));
		}
		
		if (($iId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('core.country.child.process')->delete($iId))
			{
				$this->url()->send('admincp.core.country.child', array('id' => $this->request()->get('id')), Phpfox::getPhrase('admincp.state_province_successfully_deleted'));
			}
		}		
		
		if ($this->request()->getInt('deleteall'))
		{
			if (Phpfox::getService('core.country.child.process')->deleteAll($this->request()->get('id')))
			{
				$this->url()->send('admincp.core.country', null, Phpfox::getPhrase('admincp.country_child_entries_successfully_deleted'));
			}
		}		
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.country_manager'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.country_manager'), $this->url()->makeUrl('admincp.core.country'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.states_provinces') . ': ' . $mCountry, null, true)
			->setHeader('cache', array(
					'drag.js' => 'static_script',
					'<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'core.countryChildOrdering\'}); }</script>'
				)
			)			
			->assign(array(
					'aChildren' => Phpfox::getService('core.country')->getChildForEdit($this->request()->get('id')),
					'sParentId' => $this->request()->get('id')
				)
			);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_admincp_country_child_clean')) ? eval($sPlugin) : false);
	}
}

?>