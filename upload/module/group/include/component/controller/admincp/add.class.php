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
 * @version 		$Id: add.class.php 1522 2010-03-11 17:56:49Z Miguel_Espinoza $
 */
class Group_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		if ($iEditId = $this->request()->getInt('id'))
		{
			if ($aCategory = Phpfox::getService('group.category')->getForEdit($iEditId))
			{
				$bIsEdit = true;
				
				$this->template()->setHeader('<script type="text/javascript">$(function(){$(\'#js_mp_category_item_' . $aCategory['parent_id'] . '\').attr(\'selected\', true);});</script>')->assign('aForms', $aCategory);
			}
		}		
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('group.category.process')->update($aCategory['category_id'], $aVals))
				{
					$this->url()->send('admincp.group.add', array('id' => $aCategory['category_id']), Phpfox::getPhrase('group.category_successfully_updated'));
				}
			}
			else 
			{
				if (Phpfox::getService('group.category.process')->add($aVals))
				{
					$this->url()->send('admincp.group.add', null, Phpfox::getPhrase('group.category_successfully_added'));
				}
			}
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('group.edit_a_category') : Phpfox::getPhrase('group.create_a_new_category')))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('group.edit_a_category') : Phpfox::getPhrase('group.create_a_new_category')), $this->url()->makeUrl('admincp.group'))
			->assign(array(
					'sOptions' => Phpfox::getService('group.category')->display('option')->get(),
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
		(($sPlugin = Phpfox_Plugin::get('group.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>