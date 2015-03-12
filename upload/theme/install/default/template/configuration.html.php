<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: configuration.html.php 1390 2010-01-13 13:30:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{$sCreateJs}
<script type="text/javascript">
<!--
function processDatabase()
{literal}{{/literal}
	if ({$sGetJsForm})
	{literal}
	{		
		$('.button').attr('disabled', true);
		$('.button').val('Processing...');
		return true;
	}
	{/literal}	
	return false;
{literal}}{/literal}
-->
</script>
{if count($aTables)}
<div class="label_flow" style="height:200px;">
	<ul>
	{foreach from=$aTables item=sTable}
		<li>{$sTable}</li>
	{/foreach}
	</ul>
</div>
<div class="p_4">
	<b>Notice</b>: To resolve this problem you can change the current table prefix. This setting can be found in "Advanced Configuration". Another option is you can use another database.
	<p>
		If you do not need any of the data in the table(s) mentioned above we could drop each of the table(s) and continue with the installation. If you prefer this method click on the button "Drop Tables and Continue with Installation" below.
		Note, that this method will only drop the needed phpFox tables.
	</p>
</div>
{/if}
<form method="post" action="{url link=""$sUrl".configuration"}" id="js_form" onsubmit="return processDatabase();">
{if count($aTables)}
{foreach from=$aTables item=sTable}
	<div><input type="hidden" name="table[]" value="{$sTable}" /></div>
{/foreach}
{/if}
<div class="table_header">
	Database Configuration
</div>
<div class="table">
	<div class="table_left">
		Database Driver:
	</div>
	<div class="table_right">
		<select name="val[driver]">
		{foreach from=$aDrivers item=aDriver}
			<option value="{$aDriver.driver}"{value type='select' id='driver' default='`$aDriver.driver`'}>{$aDriver.label}</option>
		{/foreach}
		</select>
	</div>
</div>
<div class="table">
	<div class="table_left">
		Database Host:
	</div>
	<div class="table_right">
		<input type="text" name="val[host]" id="host" value="{value type='input' id='host'}" size="30" />	
	</div>
</div>
<div class="table">
	<div class="table_left">
		Database Name:
	</div>
	<div class="table_right">
		<input type="text" name="val[name]" id="name" value="{value type='input' id='name'}" size="30" />	
	</div>
</div>
<div class="table">
	<div class="table_left">
		Database User Name:
	</div>
	<div class="table_right">
		<input type="text" name="val[user_name]" id="user_name" value="{value type='input' id='user_name'}" size="30" />	
	</div>
</div>
<div class="table">
	<div class="table_left">
		Database Password:
	</div>
	<div class="table_right">
		<input type="password" name="val[password]" id="password" value="{value type='input' id='password'}" size="30" />	
	</div>
</div>

<div class="table_header">
	Advanced Configuration
</div>
<div class="table" style="padding:10px;">
	<a href="#" onclick="$('#js_advanced').toggle('fast'); return false;">Display Advanced Configuration</a>
</div>
<div id="js_advanced" style="display:none;">

	<div class="table_sub_header">
		Database
	</div>
	<div class="table">
		<div class="table_left">
			Database Port:
		</div>
		<div class="table_right">
			<input type="text" name="val[port]" id="port" value="{value type='input' id='port'}" size="30" />	
		</div>
	</div>
	<div class="table">
		<div class="table_left">
			Prefix for Tables in Database:
		</div>
		<div class="table_right">
			<input type="text" name="val[prefix]" id="prefix" value="{value type='input' id='prefix' default='phpfox_'}" size="30" />	
		</div>
	</div>
	
	<div class="table_sub_header">
		Modules
	</div>	
	<div class="table">
		<div class="table_left">
			Modules:
		</div>
		<div class="table_right">
			Core:
			<div class="moduleList">		
			{foreach from=$aModules.core item=aModule}
				<div class="p_4">
					<div><input type="hidden" name="val[module][]" value="{$aModule.name}" /></div>
					<label><input type="checkbox" name="null" value="{$aModule.name}" checked="checked" disabled="disabled" /> {$aModule.name}</label>
				</div>
			{/foreach}	
			</div>
			<br />
			Extended:
			<div class="moduleList">		
			{foreach from=$aModules.plugin item=aModule}
				<div class="p_4">
					<label><input type="checkbox" name="val[module][]" value="{$aModule.name}" checked="checked" /> {$aModule.name}</label>
				</div>
			{/foreach}	
			</div>
		</div>
	</div>		
	
	{template file='video.block.install'}
	
</div>

<div class="table_clear">
{if count($aTables)}
	<div><input type="hidden" name="val[drop]" value="1" /></div>
	<input type="button" value="Clear Values and Retry" class="button" onclick="window.location.href='{url link=""$sUrl".configuration"}';" />
	<input type="submit" value="Drop Tables and Continue with Installation" class="button warning" onclick="return confirm('Are you sure?');" />
{else}
	<input type="submit" value="Start the Install" class="button" />
{/if}
</div>
</form>