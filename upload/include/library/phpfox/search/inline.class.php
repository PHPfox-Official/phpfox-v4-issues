<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Inline Search
 * Search used with AJAX request to create a drop down box.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: inline.class.php 6599 2013-09-06 08:18:37Z Miguel_Espinoza $
 */
class Phpfox_Search_Inline
{
	/**
	 * Class constructor.
	 *
	 */
	public function __construct()
	{		
	}
	
	/**
	 * Get HTML form.
	 *
	 * @param array $aArgs ARRAY of settings to pass to the form.
	 * @return string HTML form.
	 */
	public function get($aArgs = array())
	{
		$aVars = Phpfox::getLib('template')->getVar('aForms');		
		$sHtml = '';
		$sHtml .= '<input type="text" name="val[' . $aArgs['id'] . '][]" id="js_inline_input_' . $aArgs['id'] . '" style="width:' . $aArgs['width'] . ';" size="' . $aArgs['size'] . '"';
		$sHtml .= " autocomplete=\"off\"";
		if (isset($aArgs['edit']) && $aArgs['edit'] != '')
		{
			$sHtml .= " value=\"" . $aArgs['edit'] . "\" ";
		}
		elseif (isset($aArgs['display']))
		{
			$sHtml .= " value=\"" . $aArgs['display'] . "\" onfocus=\"if (this.value == '" . $aArgs['display'] . "') { this.value=''; }\"";
		}
		$sHtml .= " onkeyup=\"if (this.value != '') { oInlineSearch.call('" . $aArgs['id'] . "', '" . $aArgs['call'] . "', '" . Phpfox::getLib('template')->getVar('sTagType') . "'); }\" ";
		$sHtml .= ' />';
		if (isset($aArgs['type']) && $aArgs['type'] == 'comma')
		{
			$sHtml .= ' <input type="button" value="Add" class="button" onclick="return oInlineSearch.addWithComma(\'' . $aArgs['id'] . '\');" />';
		}
		$sHtml .= '<div style="position:relative; width:' . $aArgs['width'] . '; z-index:100;"><div class="drop_layer" id="js_inline_hidden_' . $aArgs['id'] . '" style="position:absolute;"></div></div>';	
		$sHtml .= '<div class="inline_search_box" id="js_inline_search_box_' . $aArgs['id'] . '" style="width:' . $aArgs['width'] . ';"><div style="overflow:scroll; height:60px;"><div id="js_inline_search_content_' . $aArgs['id'] . '" style="padding:5px;"></div></div></div>';
		if (isset($aArgs['info']))
		{
			$sHtml .= '<div class="p_4">' . $aArgs['info'] . '</div>';
		}				

		if (isset($aVars[$aArgs['id']]) && is_array($aVars[$aArgs['id']]))
		{
			$sHtml .= '<script type="text/javascript">';
			foreach ($aVars[$aArgs['id']] as $mKey => $mValue)
			{
				$sHtml .= "oInlineSearch.add('" . $aArgs['id'] . "', 'val[" . $aArgs['id']. "]', '{$mKey}', '{$mValue}');";
			}
			$sHtml .= '</script>';
		}
				
		return $sHtml;			
	}
}

?>