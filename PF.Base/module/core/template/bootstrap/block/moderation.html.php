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
	<div class="moderation_holder btn-group">
		<a role="button" class="btn btn-sm btn-danger moderation_drop{if !$iTotalInputFields} not_active{/if}"><span>{phrase var='core.with_selected'} (<strong class="js_global_multi_total">{$iTotalInputFields}</strong>)</span></a>
		<a role="button" class="moderation_action moderation_action_select btn btn-sm btn-primary"
		   rel="select">{phrase var='core.select_all'}
		</a>

		<ul class="dropdown-menu">
			<li>
				<a role="button" class="moderation_clear_all">{phrase var='core.clear_all_selected'}</a>
			</li>
			{foreach from=$aModerationParams.menu item=aModerationMenu}
			<li>
				<a href="#{$aModerationMenu.action}" class="moderation_process_action" rel="{$aModerationParams.ajax}">{$aModerationMenu.phrase}</a>
			</li>
			{/foreach}
		</ul>
		<span class="moderation_process">{img theme='ajax/add.gif'}
		</span>
		<a role="button"
		   class="moderation_action moderation_action_unselect btn btn-sm btn-default"
		   rel="unselect">{phrase var='core.un_select_all'}</a>
	</div>
</form>