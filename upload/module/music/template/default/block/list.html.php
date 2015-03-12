<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: list.html.php 2556 2011-04-21 20:02:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="sub_section_menu">
	<ul>
	{foreach from=$aGenres item=aGenre}
		<li {if $iCurrentGenre == $aGenre.genre_id} class="active"{/if}><a href="{$aGenre.link}" id="music_genre_{$aGenre.genre_id}">{$aGenre.name|convert|clean}</a></li>
	{/foreach}
	</ul>
</div>