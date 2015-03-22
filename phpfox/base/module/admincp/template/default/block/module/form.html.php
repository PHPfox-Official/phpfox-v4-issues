<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: form.html.php 2526 2011-04-13 18:15:51Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table">
	<div class="table_left">
	{if $bModuleFormRequired}{required}{/if}{$sModuleFormTitle}:
	</div>
	<div class="table_right">			
		<select name="val[{$sModuleFormId}]" {if $bUseClass}class{else}id{/if}="{$sModuleFormId}">
		<option value="">{$sModuleFormValue}</option>
		{foreach from=$aModules key=sModule item=iModuleId}
			<option value="{$sModule}"{value type='select' id=''$sModuleFormId'' default=$sModule}>{translate var=$sModule prefix='module'}</option>
		{/foreach}
		</select>	
	</div>
</div>