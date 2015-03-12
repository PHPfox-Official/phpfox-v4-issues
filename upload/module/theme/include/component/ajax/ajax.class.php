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
 * @package  		Module_Theme
 * @version 		$Id: ajax.class.php 5345 2013-02-13 09:44:03Z Raymond_Benc $
 */
class Theme_Component_Ajax_Ajax extends Phpfox_Ajax
{
	
	/**
	 * Shows the block to add an existing block to the current controller
	 * by letting the user drag and drop it where he wants it
	 * This feature requires user group permission core.can_design_dnd
	 */
	public function addBlockDnD()
	{
		if (Phpfox::getService('theme')->isInDnDMode() == false)
		{
			return $this->alert(Phpfox::getPhrase('theme.please_enable_designdnd_first'));
		}
		
		$this->setTitle(Phpfox::getPhrase('theme.add_new_block'));
		
		Phpfox::getBlock('theme.addBlockDnD', array(		
			)
		);
	}
	
	public function deleteMenu()
	{
		Phpfox::isUser(true);
		Phpfox::getService('theme.process')->deleteUserMenu($this->get('id'), ($this->get('add') ? true : false));
	}
	
	public function sample()
	{
		if (Phpfox::getUserParam('theme.can_view_theme_sample'))
		{
			echo '<iframe src="' . Phpfox::getLib('url')->makeUrl('theme', array('sample', 'get-block-layout' => 'true')) . '" width="1300" height="400" frameborder="0"></iframe>';
		}
	}
	
	public function revertDesign()
	{
		if (Phpfox::getService('theme.process')->revertDesign('profile'))
		{
			$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('profile.designer') . '\';');
		}
	}
	
	public function deleteCss()
	{
		$aVals = $this->get('val');
		
		if (Phpfox::getService('theme.style.process')->deleteCss($aVals['file_name'], $aVals['style_id'], $aVals['module_id']))
		{
			$iId = '' . $aVals['style_id'] . '_' . str_replace('.', '_', $aVals['file_name']) . '_' . $aVals['module_id'] . '';
			$this->call('editAreaLoader.closeFile(\'js_template_content\', \'' . $iId . '\');')
				->remove('.js_link_cache_' . $iId)
				->call('$Core.cssEditor.checkIfAnyOpen(\'' . $iId . '\');');
		}
	}
	
	public function deleteTemplate()
	{
		$aVals = $this->get('val');
		
		if (Phpfox::getService('theme.template.process')->delete($aVals))
		{
			$iId = '' . $aVals['type'] . '_' . $aVals['module'] . '_' . str_replace('.', '_', $aVals['name']) . '';
			$this->call('editAreaLoader.closeFile(\'js_template_content\', \'' . $iId . '\');')
				->remove('.js_link_cache_' . $aVals['type'] . '_' . str_replace('.', '_', $aVals['name']) . '_' . $aVals['module'] . '')
				->call('$Core.templateEditor.checkRevertChild();')
				->call('$Core.templateEditor.checkIfAnyOpen(\'' . $iId . '\');');
		}		
	}
	
	public function getCssFile($bRevert = false)
	{
		if ($aData = Phpfox::getService('theme.style')->getFile($this->get('style_id'), $this->get('file_name'), $this->get('module_id')))
		{
			if (is_array($aData['modified']))
			{
				$this->call('$(\'#js_last_modified\').show();')
					->hide('.js_theme_last_modified')
					->remove('#modify_' . $aData['id'] . '')
					->call('$(\'#js_last_modified_info\').append(\'<div id="modify_' . $aData['id'] . '" class="js_theme_last_modified extra_info"><i>' . Phpfox::getPhrase('theme.last_modified_time_stamp_by_full_name', array('phpfox_squote' => true, 'time_stamp' => Phpfox::getTime(Phpfox::getParam('core.global_update_time'), $aData['modified']['time_stamp']), 'full_name' => $aData['modified']['full_name'])) . '</i></div>\');');				
				$sProduct = $aData['product_id'];
			}
			else 
			{
				$this->call('$(\'#js_last_modified\').hide();')->hide('.js_theme_last_modified');
				$sProduct = 'phpfox';
			}
			
			if ($aData['is_custom'])
			{
				$this->show('#js_delete_custom');
			}
			else 
			{
				$this->hide('#js_delete_custom');
			}
			
			if ($bRevert)
			{
				$this->call('editAreaLoader.closeFile(\'js_template_content\', \'' . $aData['id'] . '\');');
				$this->call('$(\'.js_link_cache_' . $aData['id'] . '\').removeClass(\'modified\');');			
				$this->call('$(\'#js_last_modified\').hide();')->hide('.js_theme_last_modified');	
			}			
			
			$this->call('editAreaLoader.openFile(\'js_template_content\', {id:\'' . $aData['id'] . '\', text:"' . str_replace('"', '\"', $aData['content']) . '", title:\'' . $aData['title'] . '\'});')
				->hide('#js_template_content_loader')
				->val('#js_css_style_id', $this->get('style_id'))
				->val('#js_css_file', $this->get('file_name'))
				->val('#js_css_module', $this->get('module_id'))
				->remove('#' . $aData['id'])
				->val('#js_template_product_id', $sProduct)
				->call('$(\'#js_theme_cache_info\').append("<div class=\'js_append_theme_layer\' id=\'' . $aData['id'] . '\'>{style_id: \'' . $this->get('style_id') . '\', file: \'' . $this->get('file_name') . '\', module: \'' . $this->get('module_id') . '\', product: \'' . $sProduct . '\', custom: \'' . $aData['is_custom'] . '\'}</div>");')
				->hide('.js_css_ajax_' . str_replace('.', '_', $aData['title']));
		}
	}
	
	public function saveCssFile()
	{
		if (Phpfox::getService('theme.style.process')->update($this->get('val')))
		{
			$this->show('#js_last_modified');	
		}
	}
	
	public function revertCss()
	{		
		$this->set($this->get('val'));
		if (Phpfox::getService('theme.style.process')->revert($this->get('val')))
		{
			$this->getCssFile(true);
		}		
	}
	
	public function getTemplate($bRevert = false)
	{		
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);		
		
		$sData = Phpfox::getService('theme.template')->getTemplate($this->get('theme'), $this->get('type'), $this->get('name'), $this->get('module'));
		
		$this->show('#js_content_edit_area');
		
		if (is_array($sData))
		{						
			if ((int) $sData[1] > 0)
			{
				$this->call('$(\'#js_last_modified\').show();')
					->hide('.js_theme_last_modified')
					->remove('#modify_' . $this->get('type') . '_' . $this->get('module') . '_' . str_replace(array('.', '/'), '_', $this->get('name')) . '')					
					->call('$(\'#js_last_modified_info\').append(\'<div id="modify_' . $this->get('type') . '_' . $this->get('module') . '_' . str_replace(array('.', '/'), '_', $this->get('name')) . '" class="js_theme_last_modified extra_info"><i>' . Phpfox::getPhrase('theme.last_modified_time_stamp_by_full_name', array('time_stamp' => Phpfox::getTime(Phpfox::getParam('core.global_update_time'), $sData[1]), 'full_name' => $sData[2])) . '</i></div>\');');
			}
			else 
			{
				$this->call('$(\'#js_last_modified\').hide();')->hide('.js_theme_last_modified');					
			}

			$sProduct = $sData[3];	
			$sCustom = ($sData[4] ? '1' : '0');		
			$sData = $sData[0];					
		}
		else 
		{
			$this->call('$(\'#js_last_modified\').hide();')->hide('.js_theme_last_modified');	
			$sProduct = 'phpfox';
			$sCustom = '0';
		}
		
		$this->call('$("#js_template_type").val("' . $this->get('type') . '");')
			->call('$("#js_template_module").val("' . $this->get('module') . '");')
			->call('$("#js_template_theme").val("' . $this->get('theme') . '");')
			->call('$("#js_template_name").val("' . $this->get('name') . '");')
			->remove('#' . $this->get('type') . '_' . $this->get('module') . '_' . str_replace(array('.', '/'), '_', $this->get('name')) . '')
			->val('#js_template_product_id', $sProduct)
			->call('$(\'#js_theme_cache_info\').append("<div class=\'js_append_theme_layer\' id=\'' . $this->get('type') . '_' . $this->get('module') . '_' . str_replace(array('.', '/'), '_', $this->get('name')) . '\'>{type: \'' . $this->get('type') . '\', module: \'' . $this->get('module') . '\', theme: \'' . $this->get('theme') . '\', name: \'' . $this->get('name') . '\', product: \'' . $sProduct . '\', custom: \'' . $sCustom . '\'}</div>");');
		
		if ($bRevert)
		{
			$this->call('editAreaLoader.closeFile(\'js_template_content\', \'' . $this->get('type') . '_' . $this->get('module') . '_' . str_replace(array('.', '/'), '_', $this->get('name')) . '\');');
			$this->call('$(\'.js_link_cache_' . $this->get('type') . '_' . str_replace(array('.', '/'), '_', $this->get('name')) . '_' . $this->get('module') . '\').removeClass(\'modified\');');
			$this->call('$Core.templateEditor.checkRevertChild();');
		}
		$sData = str_replace('\\','\\\\', $sData);
		$this->call('editAreaLoader.openFile(\'js_template_content\', {id:\'' . $this->get('type') . '_' . $this->get('module') . '_' . str_replace(array('.', '/'), '_', $this->get('name')) . '\', text:"' . str_replace('"', '\"', $sData) . '", title:\'' . $this->get('name') . '\'});');
		
		$this->call('$(\'.js_link_cache_' . $this->get('type') . '_' . str_replace(array('.', '/'), '_', $this->get('name')) . '_' . $this->get('module') . '\').find(\'div:first\').hide().removeClass(\'.js_link_cache_' . $this->get('type') . '_' . str_replace(array('.', '/'), '_', $this->get('name')) . '_' . $this->get('module') . '\');')->hide('#js_template_content_loader');
	}
	
	public function updateTemplate()
	{		
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);				
		
		if (Phpfox::getService('theme.template.process')->update($this->get('val')))
		{			
			$this->show('#js_last_modified');
		}
	}
	
	public function revert()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);				
		
		$this->set($this->get('val'));
		if (Phpfox::getService('theme.template.process')->revert($this->get('val')))
		{
			$this->getTemplate(true);
		}
	}
	
	public function updateCss()
	{		
		if (Phpfox::getService('theme.process')->updateCss($this->get('type_id'), $this->get('css')))
		{
			$this->attr('#js_save_css_button', 'disabled', false)
				->removeClass('#js_save_css_button', 'disabled')
				->hide('#js_save_css');	
		}
	}
	
	public function updateTheme()
	{		
		if (($mReturn = Phpfox::getService('theme.process')->updateTheme($this->get('type_id'), $this->get('style_id'), $this->get('item_id', null))))
		{
			if (!is_bool($mReturn))
			{
				$this->call($mReturn);				
			}
		}
	}	
	
	public function updateBlock()
	{
		if (Phpfox::getService('theme.process')->updateBlock($this->get('val')))
		{
			
		}
	}	

	public function updateOrder()
	{		
		//Phpfox::getService('theme.process')->updateOrder($this->get('val'));
		
		if ($this->get('sMode', '') == 'designdnd') 
		{
			
			if (!Phpfox::getUserParam('core.can_design_dnd'))
			{
				$this->alert(Phpfox::getPhrase('theme.you_are_not_allowed_to_make_use_of_this_feature'));
			}
			if (Phpfox::getService('theme.process')->updateOrderDnD($this->get('val'), $this->get('sController')))
			{
				$this->softNotice(Phpfox::getPhrase('theme.order_updated'));
			}
			else
			{
				$this->alert(Phpfox::getPhrase('theme.something_bad_happened'));
			}
		}
		else
		{
			Phpfox::getService('theme.process')->updateOrder($this->get('val'));
		}
	}
	
	/**
	 * Loads a new block into the page. This function is used in the designDnD feature
	 * when the user drops a new block into the page.
	 * It calls $Core.loadInit() which calls the enableDnD() function after the new
	 * block has been added.
	 */
	public function loadNewBlock()
	{
		/* Need security checks here */
		$sName = str_replace('new_js_block_border_', '',$this->get('sId'));
		$aParts = explode('_',$sName);
		
		define('PHPFOX_DESIGN_DND_OVERWRITE', true);
		Phpfox::getBlock($aParts[0].'.'.$aParts[1], array('sDeleteBlock' => str_replace('new_js_block_border_', '',$this->get('sId')), 'bPassOverAjaxCall' => true), true);
		
		$sBlock = $this->getContent(false);
		$sBlock = str_replace(array("\n", "\t"), '', $sBlock);
		
		
		
		$this->html('#clone_'.$this->get('sId'), $sBlock);
		$this->call('$("#clone_'.$this->get('sId') . '").removeClass("do_not_count").addClass("js_sortable");');
		/* We rebuild the order to make sure it includes the new block */
		$this->call('$oDesignDnD.buildOrder();');
		$this->call('$Core.loadInit();');
		$this->call('$.ajaxCall("theme.updateOrder", $oDesignDnD.sOrder);');
	}
	
	public function processCss()
	{
		$sCss = $this->get('css');
		
		if ($this->get('action') == 'save')
		{
			Phpfox::getService('theme.process')->saveCssCode($this->get('type_id'), $sCss);
		}
		
		$this->remove('#js_cache_temp_style_data');
		
		if (!empty($sCss))
		{
			$this->append('body', '<div id="js_cache_temp_style_data"><style type="text/css">' . Phpfox::getLib('parse.css')->cleanCss($sCss) . '</style></div>');		
		}
		
		$this->attr('.js_save_css_code_button', 'disabled', false)
			->removeClass('.js_save_css_code_button', 'disabled')
			->hide('#js_save_css_code');		
	}
	
	public function updateStyleActivity()
	{
		if (Phpfox::getService('theme.style.process')->updateActivity($this->get('id'), $this->get('active')))
		{
			
		}		
	}
	
	public function updateThemeActivity()
	{
		if (Phpfox::getService('theme.process')->updateActivity($this->get('id'), $this->get('active')))
		{
			
		}	
	}
	
	public function updateStyleDefaultState()
	{
		if (Phpfox::getService('theme.style.process')->setToDefault($this->get('id'), $this->get('active')))
		{
			
		}
	}
}

?>