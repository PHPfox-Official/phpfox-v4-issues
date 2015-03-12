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
 * @version 		$Id: add.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class User_Component_Controller_Admincp_Cancellations_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->_setMenuName('admincp.user.cancellations.add');
		// is user trying to edit or add an item?
		if (($aVals = $this->request()->getArray('val')))
		{
			if (Phpfox::getService('user.cancellations.process')->add($aVals))
			{	
				if (isset($aVals['iDeleteId']))
				{
					$sMessage = Phpfox::getPhrase('user.option_updated_successfully');
				}
				else 
				{
					$sMessage = Phpfox::getPhrase('user.option_added_successfully');
				}
				
				$this->url()->send('admincp.user.cancellations.manage', null, $sMessage);
			}
		}

		// is user requesting an item for edit?
		if (($iId = $this->request()->getInt('id')))
		{
			$aDelete = Phpfox::getService('user.cancellations')->get($iId);
			if (empty($aDelete))
			{
				Phpfox_Error::set(Phpfox::getPhrase('user.item_not_found'));
			}
			$aDelete = reset($aDelete);
			$this->template()->assign(array('aForms' => $aDelete));
		}
		
		
		$this->template()->setTitle(Phpfox::getPhrase('user.add_cancellation_options'))
			->setBreadcrumb(Phpfox::getPhrase('user.add_cancellation_options'), $this->url()->makeUrl('admincp.user.cancellations.add'))			
			->assign(array(
					// used when editing
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