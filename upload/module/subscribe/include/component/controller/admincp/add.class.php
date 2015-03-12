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
 * @version 		$Id: add.class.php 4179 2012-05-24 07:42:16Z Miguel_Espinoza $
 */
class Subscribe_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		if (($iId = $this->request()->getInt('id')))
		{
			if (($aPackage = Phpfox::getService('subscribe')->getForEdit($iId)))
			{
				$bIsEdit = true;
				$this->template()->assign('aForms', $aPackage);				
				$this->setParam('currency_value_val[cost]', unserialize($aPackage['cost']));	
				if (!empty($aPackage['recurring_cost']))
				{
					$this->setParam('currency_value_val[recurring_cost]', unserialize($aPackage['recurring_cost']));		
				}
			}
		}
		
		
		if (($aVals = $this->request()->getArray('val')))
		{
			
			if ($bIsEdit)
			{
				if (Phpfox::getService('subscribe.process')->update($aPackage['package_id'], $aVals))
				{
					$this->url()->send('admincp.subscribe.add', array('id' => $aPackage['package_id']), Phpfox::getPhrase('subscribe.package_successfully_update'));
				}				
			}
			else 
			{
				if (Phpfox::getService('subscribe.process')->add($aVals))
				{
						$this->url()->send('admincp.subscribe', null, Phpfox::getPhrase('subscribe.package_successfully_added'));
				}
			}
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('subscribe.editing_subscription_package') . ': ' . $aPackage['title'] : Phpfox::getPhrase('subscribe.create_new_subscription_package')))	
			->setBreadcrumb(Phpfox::getPhrase('subscribe.subscription_packages'), $this->url()->makeUrl('admincp.subscribe'))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('subscribe.editing') . ': ' . Phpfox::getLib('locale')->convert($aPackage['title']) : Phpfox::getPhrase('subscribe.create_new_subscription_package')), null, true)
			->assign(array(
					'aUserGroups' => Phpfox::getService('user.group')->get(),
					'bIsEdit' => $bIsEdit
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('subscribe.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>