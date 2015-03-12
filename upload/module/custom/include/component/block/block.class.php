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
 * @version 		$Id: block.class.php 3325 2011-10-20 08:33:09Z Miguel_Espinoza $
 */
class Custom_Component_Block_Block extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aData = $this->getParam('data');		
		$sTemplate = $this->getParam('template');
		
		if (!is_array($aData))
		{			
			return false;
		}
		
		if (!defined('PHPFOX_IN_DESIGN_MODE') && Phpfox::getParam('custom.hide_custom_fields_when_empty') && empty($aData['value']))
		{			
			return false;
		}		
		
		$sEditLink = '';
		$sJsClick = ' $(\'#js_custom_content_' . $aData['field_id'] . '\').hide();';
		$sJsClick .= ' $(this).parent().removeClass(\'extra_info\');';
		$sJsClick .= ' $.ajaxCall(\'custom.edit\', \'field_id=' . $aData['field_id'] . '&amp;item_id=' . $this->getParam('item_id') . '&amp;edit_user_id=' . $this->getParam('edit_user_id') . '\');';
		$sJsClick .= ' return false;';
		
		if (($this->getParam('edit_user_id') && empty($aData['value']) && $this->getParam('edit_user_id') != Phpfox::getUserId()))
		{				
			return false;
		}				
		
		if ($this->getParam('edit_user_id') && $this->getParam('edit_user_id') == Phpfox::getUserId() && empty($aData['value']))
		{
			switch ($sTemplate)
			{
				case 'info':
					$aData['value'] = 'N/A';
					break;
				default:				
					$aData['value'] = '<div class="js_custom_content_holder">';
					$aData['value'] .= '<div id="js_custom_content_' . $aData['field_id'] . '" class="extra_info js_custom_content">' . Phpfox::getPhrase('custom.nothing_added_yet_click_to_edit', array('link' => $sJsClick)) . '</div>';					
					$aData['value'] .= '<div id="js_custom_field_' . $aData['field_id'] . '" class="js_custon_field" style="display:none;"></div>';
					$aData['value'] .= '</div>';
					break;	
			}			
		}
		else 
		{
			$oParseOutput = Phpfox::getLib('parse.output');
			
			switch ($aData['var_type'])
			{
				case 'select':
				case 'radio':
					$sValue = Phpfox::getPhrase($aData['value']);
					
					$aData['value'] = '<div class="js_custom_content_holder">';
					$aData['value'] .= '<div id="js_custom_content_' . $aData['field_id'] . '" class="js_custom_content">' . $sValue . '</div>';
					$aData['value'] .= '<div id="js_custom_field_' . $aData['field_id'] . '" class="js_custon_field" style="display:none;"></div>';
					$aData['value'] .= '</div>';						
					break;
				case 'multiselect':
				case 'checkbox':
					$aValues = is_array($aData['value']) ? $aData['value'] : unserialize($aData['value']);
					$aPhrases = array();
					foreach ($aValues as $sPhrase)
					{
						$aPhrases[] = Phpfox::getPhrase($sPhrase);
					}
					$aData['value'] = '<div class="js_custom_content_holder">';
					$aData['value'] .= '<div id="js_custom_content_' . $aData['field_id'] . '" class="js_custom_content">' . implode(', ', $aPhrases). '</div>';
					$aData['value'] .= '<div id="js_custom_field_' . $aData['field_id'] . '" class="js_custon_field" style="display:none;"></div>';
					$aData['value'] .= '</div>';
					
					//$sJsClick = 'window.location=\'' . Phpfox::getLib('url')->makeUrl('user.profile') .'\'';
					break;
				default:
					if ($aData['type_id'] == 'profile_panel')
					{
						Phpfox::getLib('parse.output')->setEmbedParser(array(
								'width' => 300,
								'height' => 260
							)
						);
						
						Phpfox::getLib('parse.output')->setImageParser(array(
								'width' => 300,
								'height' => 260
							)
						);						
					}
					$sValue = $oParseOutput->parse($aData['value']);
					
					$aData['value'] = '<div class="js_custom_content_holder">';
					$aData['value'] .= '<div id="js_custom_content_' . $aData['field_id'] . '" class="js_custom_content">' . $sValue . '</div>';
					$aData['value'] .= '<div id="js_custom_field_' . $aData['field_id'] . '" class="js_custon_field" style="display:none;"></div>';
					$aData['value'] .= '</div>';					
					break;
			}			
		}		
		
		if ($this->getParam('edit_user_id') && ($this->getParam('edit_user_id') == Phpfox::getUserId() && Phpfox::getUserParam('custom.can_edit_own_custom_field')) || (Phpfox::getUserParam('custom.can_edit_other_custom_fields')))
		{
			$sEditLink = '<div class="js_edit_header_bar">';
			$sEditLink .= '<span id="js_custom_loader_' . $aData['field_id'] . '" style="display:none;"><img src="' . $this->template()->getStyle('image', 'ajax/small.gif') . '" alt="" class="v_middle" /></span>';			
			$sEditLink .= '<a href="#" onclick="' . $sJsClick . '" id="js_custom_link_' . $aData['field_id'] . '">';
			$sEditLink .= '<img src="' . $this->template()->getStyle('image', 'misc/page_white_edit.png') . '" alt="" class="v_middle" />';
			$sEditLink .= '</a>';			
			$sEditLink .= '</div>';
		}
		
		$this->template()->assign(array(
				'sHeader' => $sEditLink . Phpfox::getPhrase($aData['phrase_var_name']),
				'sBlockBorderJsId' => str_replace('.', '_', $aData['phrase_var_name']),
				'sContent' => $aData['value'],
				'sTemplate' => $sTemplate,
				//'bBlockCanMove' => true,
				'sCustomValue' => $aData['value']
			)
		);
		
		if ($aData['type_id'] == 'user_main')
		{
			return 'block';
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('custom.component_block_block_clean')) ? eval($sPlugin) : false);
	}
}

?>