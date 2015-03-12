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
 * @package  		Module_Admincp
 * @version 		$Id: add.class.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
class Admincp_Component_Controller_Block_Add extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		Phpfox::getUserParam('admincp.can_add_new_block', true);
		$bIsEdit = false;
				
		if (($iEditId = $this->request()->getInt('id')) || ($iEditId = $this->request()->getInt('block_id')))
		{
			$aRow = Phpfox::getService('admincp.block')->getForEdit($iEditId);			
			$bIsEdit = true;
			
			$this->template()->assign(array(
					'aForms' => $aRow,
					'aAccess' => (empty($aRow['disallow_access']) ? null : unserialize($aRow['disallow_access']))
				)
			);			
		}		
		
		$aValidation = array(
			'product_id' => Phpfox::getPhrase('admincp.select_product'),
			'location' => Phpfox::getPhrase('admincp.select_block_placement'),
			'is_active' => Phpfox::getPhrase('admincp.specify_block_active')
		);		
		
		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));		
		
		if ($aVals = $this->request()->getArray('val'))
		{			
			if ($oValid->isValid($aVals))
			{
				if ($bIsEdit)
				{
					$sMessage = Phpfox::getPhrase('admincp.successfully_updated');
					$aUrl = array('block', 'add', 'id' => $aRow['block_id']);
					Phpfox::getService('admincp.block.process')->update($aRow['block_id'], $aVals);
				}
				else 
				{
					$sMessage = Phpfox::getPhrase('admincp.block_successfully_added');
					$aUrl = array('block');
					Phpfox::getService('admincp.block.process')->add($aVals);
				}				
				
				$this->url()->send('admincp', $aUrl, $sMessage);
			}
		}
		
		if (Phpfox::getParam('core.enabled_edit_area'))
		{
			$this->template()->setHeader(array(
					'editarea/edit_area_full.js' => 'static_script',
					'<script type="text/javascript">				
						editAreaLoader.init({
							id: "source_code"	
							,start_highlight: true
							,allow_resize: "both"
							,allow_toggle: false
							,word_wrap: false
							,language: "en"
							,syntax: "php"
						});		
					</script>'
				)
			);
		}
		
		$aStyles = Phpfox::getService('theme.style')->getStyles();
		if ($bIsEdit)
		{		
			foreach ($aStyles as $iKey => $aStyle)
			{
				if (isset($aRow['style_id']) && isset($aRow['style_id'][$aStyle['style_id']]))
				{
					$aStyles[$iKey]['block_is_selected'] = $aRow['style_id'][$aStyle['style_id']];
				}
			}
		}
		
		$this->template()->assign(array(
					'aProducts' => Phpfox::getService('admincp.product')->get(),
					'aControllers' => Phpfox::getService('admincp.component')->get(true),
					'aComponents' => Phpfox::getService('admincp.component')->get(),
					'aUserGroups' => Phpfox::getService('user.group')->get(),
					'sCreateJs' => $oValid->createJS(),
					'sGetJsForm' => $oValid->getJsForm(),
					'bIsEdit' => $bIsEdit,
					'aStyles' => $aStyles
				)
			)
			->setTitle(Phpfox::getPhrase('admincp.block_manager'))	
			->setBreadcrumb(Phpfox::getPhrase('admincp.block_manager'), $this->url()->makeUrl('admincp.block'))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('admincp.editing') . ': ' . (empty($aRow['m_connection']) ? Phpfox::getPhrase('admincp.site_wide') : $aRow['m_connection']) . (empty($aRow['component']) ? '' : '::' . rtrim(str_replace('|', '::', $aRow['component']), '::')) . (empty($aRow['title']) ? '' : ' (' . Phpfox::getLib('locale')->convert($aRow['title']) . ')') : Phpfox::getPhrase('admincp.add_new_block')), $this->url()->makeUrl('admincp.block.add'), true)
			->setTitle(Phpfox::getPhrase('admincp.add_new_block'));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_block_add_clean')) ? eval($sPlugin) : false);
	}
}

?>