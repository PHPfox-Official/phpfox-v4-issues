<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: genre.html.php 2217 2010-11-29 12:33:01Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{for $i = 1; $i <= $iGenerCount; $i++}
	<div class="{if PHPFOX_IS_AJAX && !$bIsGlobalEdit}info{else}table{/if} js_custom_groups js_custom_group_genre"{if Phpfox::getLib('request')->get('req1') == 'user'} style="display:none;"{/if}>
		<div class="{if PHPFOX_IS_AJAX && !$bIsGlobalEdit}info{else}table{/if}_left">
			{phrase var='music.genre_total' total=$i}:
		</div>
		<div class="{if PHPFOX_IS_AJAX && !$bIsGlobalEdit}info{else}table{/if}_right">
			<select name="custom[music_genre][{$i}]">
				<option value="">{phrase var='music.none'}</option>
			{foreach from=$aGenres item=aGenre}
				<option value="{$aGenre.genre_id}"{if isset($aUserGenres[$i]) && $aUserGenres[$i].genre_id == $aGenre.genre_id} selected="selected"{/if}>{$aGenre.name|convert|clean}</option>
			{/foreach}
			</select>
		</div>
	</div>
{/for}