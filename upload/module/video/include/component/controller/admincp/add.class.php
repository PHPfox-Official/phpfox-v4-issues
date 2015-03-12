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
 * @version 		$Id: add.class.php 405 2009-04-15 13:10:28Z Raymond_Benc $
 */
class Video_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		if ($iEditId = $this->request()->getInt('id'))
		{
			if ($aCategory = Phpfox::getService('video.category')->getForEdit($iEditId))
			{
				$bIsEdit = true;
				
				$this->template()->setHeader('<script type="text/javascript">$Behavior.video_controller_add_2 = function(){$(\'#js_mp_category_item_' . $aCategory['parent_id'] . '\').attr(\'selected\', true);};</script>')->assign('aForms', $aCategory);
			}
		}		
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('video.category.process')->update($aCategory['category_id'], $aVals))
				{
					$this->url()->send('admincp.video.add', array('id' => $aCategory['category_id']), Phpfox::getPhrase('video.category_successfully_updated'));
				}
			}
			else 
			{
				if (Phpfox::getService('video.category.process')->add($aVals))
				{
					$this->url()->send('admincp.video.add', null, Phpfox::getPhrase('video.category_successfully_added'));
				}
			}
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('video.edit_a_category') : Phpfox::getPhrase('video.create_a_new_category')))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('video.edit_a_category') : Phpfox::getPhrase('video.create_a_new_category')), $this->url()->makeUrl('admincp.video'))
			->assign(array(
					'sOptions' => Phpfox::getService('video.category')->display('option')->get(),
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
		(($sPlugin = Phpfox_Plugin::get('video.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>