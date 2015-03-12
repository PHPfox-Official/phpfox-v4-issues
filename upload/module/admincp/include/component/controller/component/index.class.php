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
 * @version 		$Id: index.class.php 1931 2010-10-25 11:58:06Z Raymond_Benc $
 */
class Admincp_Component_Controller_Component_Index extends Phpfox_Component
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
		
		if (($iDeleteId = $this->request()->getInt('delete')) && Phpfox::getService('admincp.component.process')->delete($iDeleteId))
		{
			$this->url()->send('admincp.component', null, Phpfox::getPhrase('admincp.component_successfully_deleted'));
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.manage_components'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.manage_components'), $this->url()->makeUrl('admincp.component'))
			->assign(array(
				'aComponents' => Phpfox::getService('admincp.component')->getForManagement()
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_component_index_clean')) ? eval($sPlugin) : false);
	}
}

?>