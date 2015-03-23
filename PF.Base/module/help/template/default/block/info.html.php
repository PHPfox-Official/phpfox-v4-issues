<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Help
 * @version 		$Id: info.html.php 1161 2009-10-09 07:42:41Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="tip" id="tip_{$sPhrase}">
	<a href="#?call=help.closeTips&amp;width=300&amp;height=200&amp;tip={$sPhrase}" title="{phrase var='help.hide_all_tips'}" class="inlinePopup">{img theme='misc/delete_hover.gif' class='go_right'}</a>
	{img theme='misc/bulb.gif' alt=''} {$sMessage}
</div>