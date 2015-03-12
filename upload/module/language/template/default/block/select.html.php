<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
<div id="js_loading_language"></div>
<div id="js_language_package_holder">
	{foreach from=$aLanguages item=aLanguage name=languages}
	<div class="{if is_int($phpfox.iteration.languages/2)}row1{else}row2{/if}{if $phpfox.iteration.languages == 1} row_first{/if}{if Phpfox::getLib('locale')->getLangId() == $aLanguage.language_id} row_focus{/if}">
	{if !empty($aLanguage.image)}
		<div class="go_right">
			<img src="{$aLanguage.image}" alt="{$aLanguage.language_code}" class="v_middle" /> 
		</div>
	{/if}
		{if Phpfox::getLib('locale')->getLangId() != $aLanguage.language_id}<a href="#" onclick="$('#js_language_package_holder').hide(); $('#js_loading_language').html($.ajaxProcess('{phrase var='language.loading' phpfox_squote=true}')); $.ajaxCall('language.process', 'id={$aLanguage.language_id}'); return false;">{/if}{$aLanguage.title}{if Phpfox::getLib('locale')->getLangId() != $aLanguage.language_id}</a>{/if}
	</div>
	<div class="clear"></div>
	{/foreach}
	<div class="clear"></div>
</div>