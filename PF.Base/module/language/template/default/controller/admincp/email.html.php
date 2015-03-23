<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Language
 * @version 		$Id: file.html.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{phrase var='language.search_filter'}
</div>
<div class="table">
	<div class="table_left">
		{phrase var='language.language_packages'}:
	</div>
	<div class="table_right">
		<select id="selectLanguage">
			{foreach from=$aLangs item=aLang}
				<option value="{$aLang.language_id}">{$aLang.title}</option>
			{/foreach}
		</select>
	</div>
	<div class="clear">	</div>
</div>

<div class="table_header">
	{phrase var='language.phrases_used_in_emails'}
</div>

<div id="phrasesContainer">
	<form action="{url link='admincp.language.email'}" method="post">
		<div><input type="hidden" name="val[language_id]" value="{$sLanguage}"></div>
		<table cellpadding="0" cellspacing="0" class="table_for_phrases">
			<tr>
				<th style="width:20%;">{phrase var='language.variable'}</th>
				<th style="width:55%;">{phrase var='language.text'}</th>
			</tr>
			{foreach from=$aPhrases key=iKey item=aPhrase}
				<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
					<td><input type="text" value="{$aPhrase.phrase_id}" size="35"></td>
					<td><textarea cols="75" rows="2" name="val[text][{$aPhrase.phrase_id}]">{phrase var=$aPhrase.phrase_id language=$sLanguage}</textarea></td>
				</tr>
			{/foreach}
		</table>
		<div class="table_clear">
			<input type="submit" value="{phrase var='language.save_all'}" class="button">
		</div>
	</form>
</div>
