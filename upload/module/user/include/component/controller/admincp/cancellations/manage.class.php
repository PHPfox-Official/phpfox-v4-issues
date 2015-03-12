<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: manage.class.php 6113 2013-06-21 13:58:40Z Raymond_Benc $
 */
class User_Component_Controller_Admincp_Cancellations_Manage extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		// are we deleting a reason
		if ( ($iReasonId = $this->request()->get('delete')))
		{			
			if (Phpfox::getService('user.cancellations.process')->delete($iReasonId))
			{
				$this->url()->send('admincp.user.cancellations.manage', null, Phpfox::getPhrase('user.option_deleted_successfully'));
			}
		}
		// get all the cancellation reasons
		$aReasons = Phpfox::getService('user.cancellations')->get();
		$this->template()->setTitle(Phpfox::getPhrase('user.manage_cancellation_options'))
			->setBreadcrumb(Phpfox::getPhrase('user.manage_cancellation_options'), $this->url()->makeUrl('admincp.user.cancellations.manage'))
			->assign(array('aReasons' => $aReasons))
			->setHeader(array(
					'drag.js' => 'static_script',
					'<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'core.cancellationsOrdering\'}); }</script>'
				));
			
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_admincp_browse_clean')) ? eval($sPlugin) : false);
	}
}

?>