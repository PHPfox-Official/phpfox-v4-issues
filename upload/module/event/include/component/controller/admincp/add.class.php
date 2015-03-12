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
class Event_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		if ($iEditId = $this->request()->getInt('id'))
		{
			if ($aCategory = Phpfox::getService('event.category')->getForEdit($iEditId))
			{
				$bIsEdit = true;
				
				$this->template()->setHeader('<script type="text/javascript">$Behavior.event_add_set_attr = function(){$(\'#js_mp_category_item_' . $aCategory['parent_id'] . '\').attr(\'selected\', true);};</script>')->assign('aForms', $aCategory);
			}
		}		
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('event.category.process')->update($aCategory['category_id'], $aVals))
				{
					$this->url()->send('admincp.event.add', array('id' => $aCategory['category_id']), Phpfox::getPhrase('event.category_successfully_updated'));
				}
			}
			else 
			{
				if (Phpfox::getService('event.category.process')->add($aVals))
				{
					$this->url()->send('admincp.event.add', null, Phpfox::getPhrase('event.category_successfully_added'));
				}
			}
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('event.edit_a_category') : Phpfox::getPhrase('event.create_a_new_category')))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('event.edit_a_category') : Phpfox::getPhrase('event.create_a_new_category')), $this->url()->makeUrl('admincp.event'))
			->assign(array(
					'sOptions' => Phpfox::getService('event.category')->display('option')->get(),
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
		(($sPlugin = Phpfox_Plugin::get('event.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>