<?php
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: form.html.php 2655 2011-06-03 11:40:56Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="lang_table">
{foreach from=$aLanguages item=aLanguage}
{if $sType == 'text'}
	<input type="text" name="val[{$sId}]{if isset($aLanguage.phrase_var_name)}[{$aLanguage.phrase_var_name}]{/if}[{$aLanguage.language_id}]{if isset($sMode)}[{$sMode}]{/if}" value="{$aLanguage.post_value|htmlspecialchars}" placeholder="{$aLanguage.title}" />
{elseif $sType == 'label'}
	{if $aLanguage.post_value != ''}
		<div class="lang_title">
			{$aLanguage.post_value|htmlspecialchars} <small>({$aLanguage.title})</small>
		</div>
	{/if}
{else}
	{$aLanguage.title}
	<div class="lang_value">
		<textarea cols="50" rows="5" name="val[{$sId}]{if isset($aLanguage.phrase_var_name)}[{$aLanguage.phrase_var_name}]{/if}[{$aLanguage.language_id}]{if isset($sMode)}[{$sMode}]{/if}">{$aLanguage.post_value|htmlspecialchars}</textarea>
	</div>
{/if}
{/foreach}
</div>