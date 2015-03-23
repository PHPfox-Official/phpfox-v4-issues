<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Shoutbox
 * @version 		$Id: display.html.php 6909 2013-11-20 14:01:14Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<script type="text/javascript">
{literal}
	function addShoutOut(oObj)
	{
		if ($('#js_shoutbox_input').val() == '')
		{
			return false;
		}
		
		$('#js_shoutbox_form').hide();
		{/literal}
		$('#js_shoutbox_message').html($.ajaxProcess('{phrase var='shoutbox.adding_your_shoutout' phpfox_squote=true}'));
		{literal}
		$(oObj).ajaxCall('shoutbox.add');
		
		return false;
	}
{/literal}
</script>
<div id="js_shoutbox_messages" class="label_flow shoutbox_holder">
	{if Phpfox::getParam('shoutbox.load_content_ajax') && !PHPFOX_IS_AJAX}
		<script type="text/javascript">
			var bLoadShoutboxOnce = false;
			$Behavior.loadShouts = function()
			{l}
				if (bLoadShoutboxOnce){l}
					return;
				{r}
				bLoadShoutboxOnce = true;
				setTimeout("$.ajaxCall('shoutbox.getMessages', {if isset($aCallbackShoutbox.module)}'module={$aCallbackShoutbox.module}&item={$aCallbackShoutbox.item}'{else}''{/if}, 'GET')", 2000);
			{r};			
		</script>	
	{/if}
	{foreach from=$aShoutouts item=aShoutout key=iShoutCount name=shoutout}
	{template file='shoutbox.block.entry'}
	{/foreach}
</div>
<div id="js_shoutbox_form">
	<form method="post" action="{url link='current'}" onsubmit="return addShoutOut(this);">	
	{if isset($aCallbackShoutbox.module)}
		<div><input type="hidden" name="module" value="{$aCallbackShoutbox.module}" /></div>
	{/if}	
	{if isset($aCallbackShoutbox.item)}
		<div><input type="hidden" name="item" value="{$aCallbackShoutbox.item}" /></div>
	{/if}
	{if Phpfox::getUserParam('shoutbox.can_add_shoutout')}	
		<div><input id="js_shoutbox_input" type="text" name="shoutout" size="20" maxlength="255" value="" class="shoutbox_input" /></div>
	{/if}
	</form>
</div>
<div id="js_shoutbox_message"></div>
{if Phpfox::getParam('shoutbox.load_content_ajax') && !PHPFOX_IS_AJAX}

{else}
{if Phpfox::getParam('shoutbox.shoutbox_is_live')}
	<script type="text/javascript">
		$Behavior.refreshShouts = function()
		{l}
			if (typeof $Core.Shoutbox == 'undefined')
			{literal}
			{
				$Core.Shoutbox = {};
				$Core.Shoutbox.sParams = '';
			}
			{/literal}			
			$Core.Shoutbox.sParams = {if isset($aCallbackShoutbox.module)}'module={$aCallbackShoutbox.module}&item={$aCallbackShoutbox.item}'{else}''{/if};
			
			setTimeout("$.ajaxCall('shoutbox.getMessages', $Core.Shoutbox.sParams, 'GET');", {$iShoutboxRefresh});
		{r};
	</script>
{/if}
{/if}
