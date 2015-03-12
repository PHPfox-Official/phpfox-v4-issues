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
 * @version 		$Id: feedback.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class User_Component_Controller_Admincp_Cancellations_Feedback extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$this->_setMenuName('admincp.user.cancellations.feedback');
		
		$aFeedbacks = Phpfox::getService('user.cancellations')->getFeedback();
		
		$this->template()->setTitle(Phpfox::getPhrase('user.view_feedback_on_cancellations'))
			->setBreadcrumb(Phpfox::getPhrase('user.view_feedback_on_cancellations'), $this->url()->makeUrl('admincp.user.cancellations.feedback'))
			->assign(array(
					'aFeedbacks' => $aFeedbacks
				)
			);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>