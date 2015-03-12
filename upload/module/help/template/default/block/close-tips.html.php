<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Help
 * @version 		$Id: close-tips.html.php 1298 2009-12-05 16:19:23Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<input type="button" name="session_only" value="{phrase var='help.hide_this_tip'}" class="button" onclick="$.ajaxCall('help.closePerSession', 'tip={$sTip}'); tb_remove();" />
<input type="button" name="close_all" value="{phrase var='help.hide_all_tips'}" class="button" onclick="if (confirm('{phrase var='core.are_you_sure' phpfox_squote=true}')) {literal}{{/literal} $.ajaxCall('help.closeAllTips'); tb_remove(); {literal}}{/literal}" />
<div class="p_4">
	{phrase var='help.add_back_tips_info'}
</div>