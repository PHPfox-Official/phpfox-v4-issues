<?php 
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: sponsored-song.html.php 1559 2010-05-04 13:06:56Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="content">
    <ul class="action">
	{foreach from=$aSponsorSong item=aSong}
	    <li>
		{if isset($aSong.name_url)}
		    <a href="{url link='ad.sponsor' view=$aSong.sponsor_id}">{$aSong.title}
		{else}
		    <a href="{url link=''$aSong.user_name'.music.view.'$aSong.title_url'}">{$aSong.title}
		{/if}
		by {$aSong.user_name}</a>
	    </li>
	{/foreach}
    </ul>
</div>