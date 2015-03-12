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
class Share_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($iDeleteId = $this->request()->getInt('delete')) && Phpfox::getService('share.process')->delete($iDeleteId))
		{
			$this->url()->send('admincp.share', null, Phpfox::getPhrase('share.site_successfully_deleted'));
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('share.manage_sites'))
			->setBreadcrumb(Phpfox::getPhrase('share.share'), $this->url()->makeUrl('admincp.share'))
			->setBreadcrumb(Phpfox::getPhrase('share.manage_sites'), null, true)
			->setHeader('cache', array(
					'drag.js' => 'static_script',
					'<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'share.ordering\'}); }</script>'
				)
			)			
			->assign(array(
					'aSites' => Phpfox::getService('share')->get()
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('share.component_controller_admincp_social_index_clean')) ? eval($sPlugin) : false);
	}
}

?>