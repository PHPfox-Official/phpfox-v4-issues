<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Invite
 * @version 		$Id: find.html.php 5538 2013-03-25 13:20:22Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
<script type="text/javascript">
<!--
{literal}
	var sSearchByFindValue = '';
	$Behavior.invite_find_search = function()
	{
		sSearchByFindValue = $('.js_is_find_enter').val();		
	};

	function toggleSearchValue(oObj, sType)
	{
		if (sType == 'focus')
		{
			{/literal}
			if (oObj.value == sSearchByFindValue)
			{literal}
			{
				oObj.value = '';
				$(oObj).removeClass('default_value');
			}
		}
		else
		{
			if (empty(oObj.value))
			{
				{/literal}
				oObj.value = sSearchByFindValue;
				{literal}
				$(oObj).addClass('default_value');				
			}
		}
	}
{/literal}
-->
</script>
<form method="post" action="{url link='user.browse'}">
	<input type="text" name="search[keyword]" value="{phrase var='invite.search_by_name_or_email'}" onfocus="toggleSearchValue(this, 'focus');" onblur="toggleSearchValue(this, 'blur');" size="25" class="default_value js_is_find_enter" />
	<div class="p_top_8">
		<input type="submit" value="{phrase var='invite.search'}" class="button" />
	</div>
</form>
{if count($aRandomUsers)}
<div class="separate" style="margin-top:10px;"></div>
<div class="t_center">
	{foreach from=$aRandomUsers item=aUser}
	{img user=$aUser suffix='_50_square' max_width=50 max_height=50 style='padding-right:8px'}
	{/foreach}
</div>
{/if}