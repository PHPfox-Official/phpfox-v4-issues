<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: moderation.html.php 4086 2012-04-05 12:32:32Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='current'}" id="js_global_multi_form_holder">
	{if !empty($sCustomModerationFields)}
	{$sCustomModerationFields}
	{/if}
	<div id="js_global_multi_form_ids">{$sInputFields}</div>
	<div class="moderation_holder">
		<a href="#" class="moderation_action moderation_action_select" rel="select">{phrase var='core.select_all'}</a>
		<a href="#" class="moderation_action moderation_action_unselect" rel="unselect">{phrase var='core.un_select_all'}</a>
		<span class="moderation_process">{img theme='ajax/add.gif'}</span>
		<a href="#" class="moderation_drop{if !$iTotalInputFields} not_active{/if}"><span>{phrase var='core.with_selected'} (<strong class="js_global_multi_total">{$iTotalInputFields}</strong>)</span></a>		
		<ul>
			<li><a href="#" class="moderation_clear_all">{phrase var='core.clear_all_selected'}</a></li>
			{foreach from=$aModerationParams.menu item=aModerationMenu}
			<li><a href="#{$aModerationMenu.action}" class="moderation_process_action" rel="{$aModerationParams.ajax}">{$aModerationMenu.phrase}</a></li>
			{/foreach}
		</ul>
	</div>
</form>