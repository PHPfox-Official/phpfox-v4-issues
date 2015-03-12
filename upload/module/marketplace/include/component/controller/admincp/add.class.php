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
 * @version 		$Id: add.class.php 5538 2013-03-25 13:20:22Z Miguel_Espinoza $
 */
class Marketplace_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		if ($iEditId = $this->request()->getInt('id'))
		{
			if ($aCategory = Phpfox::getService('marketplace.category')->getForEdit($iEditId))
			{
				$bIsEdit = true;
				
				$this->template()->setHeader('<script type="text/javascript">$Behavior.marketplace_add_2 = function(){$(\'#js_mp_category_item_' . $aCategory['parent_id'] . '\').attr(\'selected\', true);};</script>')->assign('aForms', $aCategory);
			}
		}		
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('marketplace.category.process')->update($aCategory['category_id'], $aVals))
				{
					$this->url()->send('admincp.marketplace.add', array('id' => $aCategory['category_id']), Phpfox::getPhrase('marketplace.category_successfully_updated'));
				}
			}
			else 
			{
				if (Phpfox::getService('marketplace.category.process')->add($aVals))
				{
					$this->url()->send('admincp.marketplace.add', null, Phpfox::getPhrase('marketplace.category_successfully_added'));
				}
			}
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('marketplace.edit_a_category') : Phpfox::getPhrase('marketplace.create_a_new_category')))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('marketplace.edit_a_category') : Phpfox::getPhrase('marketplace.create_a_new_category')), $this->url()->makeUrl('admincp.marketplace'))
			->assign(array(
					'sOptions' => Phpfox::getService('marketplace.category')->display('option')->get(),
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
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>