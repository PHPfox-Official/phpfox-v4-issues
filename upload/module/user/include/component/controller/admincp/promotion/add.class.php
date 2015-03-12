<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: add.class.php 1601 2010-05-30 05:20:59Z Raymond_Benc $
 */
class User_Component_Controller_Admincp_Promotion_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		if (($iId = $this->request()->getInt('id')) && ($aPromotion = Phpfox::getService('user.promotion')->getPromotion($iId)))
		{
			$bIsEdit = true;			
			$this->template()->assign(array(
					'aForms' => $aPromotion
				)
			);
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('user.promotion.process')->update($aPromotion['promotion_id'], $aVals))
				{
					$this->url()->send('admincp.user.promotion.add', array('id' => $aPromotion['promotion_id']), Phpfox::getPhrase('user.promotion_successfully_update'));
				}				
			}
			else 
			{
				if (Phpfox::getService('user.promotion.process')->add($aVals))
				{
					$this->url()->send('admincp.user.promotion', null, Phpfox::getPhrase('user.promotion_successfully_added'));
				}
			}
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('user.editing_promotion') : Phpfox::getPhrase('user.add_promotion')))
			->setBreadcrumb(Phpfox::getPhrase('user.promotions'), $this->url()->makeUrl('admincp.user.promotion'))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('user.editing_promotion') : Phpfox::getPhrase('user.add_promotion')), null, true)
			->assign(array(
					'bIsEdit' => $bIsEdit,
					'aUserGroups' => Phpfox::getService('user.group')->get(),
					'sEnableOptionLink' => $this->url()->makeUrl('admincp.setting.edit', array('module-id' => 'user'))
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_admincp_promotion_add_clean')) ? eval($sPlugin) : false);
	}
}

?>