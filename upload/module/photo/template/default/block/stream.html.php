<?php 
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: stream.html.php 5616 2013-04-10 07:54:55Z Miguel_Espinoza $
 */

defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aStreams.next) || count($aStreams.previous)}
<div class="photo_stream_holder">
    <div style="padding-top:15px;">
	<div style="float:left; width:40%;">
	{if count($aStreams.previous)}
	    {foreach from=$aStreams.previous item=aPreviousPhoto}
	    <div class="photo_stream_photo" style="float:right;">
		{if $aPreviousPhoto.user_id == Phpfox::getUserId() ||
			$aPreviousPhoto.mature == 0 ||
			(Phpfox::getUserId() && Phpfox::getUserParam('photo.photo_mature_age_limit') <= Phpfox::getUserBy('age'))}
		<a href="{$aPreviousPhoto.link}" title="{phrase var='photo.title_by_full_name' title=$aPreviousPhoto.title full_name=$aPreviousPhoto.full_name|clean}">
			{img server_id=$aPreviousPhoto.server_id path='photo.url_photo' file=$aPreviousPhoto.destination suffix='_50' max_width=75 max_height=75 title=$aPreviousPhoto.title}
		</a>

		{elseif $aPreviousPhoto.mature == 1}
		{* show warning *}
		<a href="{$aPreviousPhoto.link}"
		   onclick="tb_show('{phrase('photo.warning')}', $.ajaxBox('photo.warning', 'height=300&amp;width=350&amp;link={$aPreviousPhoto.link}'));
		    return false;">
		   {img theme='misc/no_access.png' width='75px'}
		</a>
		{elseif $aPreviousPhoto.mature == 2 && Phpfox::getUserParam('photo.photo_mature_age_limit') > Phpfox::getUserBy('age')}
		<a href="{$aPreviousPhoto.link}">
		    {img theme='misc/no_access.png' width='75px'}
		</a>
		{/if}
	    </div>
	    {/foreach}
	{else}
	    &nbsp;
	{/if}	
	</div>
	<div style="float:left; width:20%;">
	    <div class="photo_stream_photo photo_stream_photo_active">
			{img server_id=$aForms.server_id path='photo.url_photo' file=$aForms.destination suffix='_50' max_width=75 max_height=75 title=$aForms.title}
	    </div>
	</div>
	<div style="float:left; width:40%;">
	{if count($aStreams.next)}
	{foreach from=$aStreams.next item=aNextPhoto}
	    <div class="photo_stream_photo" style="float:left;">
		{if $aNextPhoto.user_id == Phpfox::getUserId() ||
			$aNextPhoto.mature == 0 ||
			(Phpfox::getUserId() && Phpfox::getUserParam('photo.photo_mature_age_limit') <= Phpfox::getUserBy('age'))}
		<a href="{$aNextPhoto.link}" title="{phrase var='photo.title_by_full_name' title=$aNextPhoto.title full_name=$aNextPhoto.full_name|clean}">
			{img server_id=$aNextPhoto.server_id path='photo.url_photo' file=$aNextPhoto.destination suffix='_50' max_width=75 max_height=75 title=$aNextPhoto.title}
		</a>

		{elseif $aNextPhoto.mature == 1}
		{* show warning *}
		<a href="{$aNextPhoto.link}" 
		   onclick="tb_show('{phrase('photo.warning')}', $.ajaxBox('photo.warning', 'height=300&amp;width=350&amp;link={$aNextPhoto.link}'));
		    return false;">
		   {img theme='misc/no_access.png' width='75px'}
		</a>
		{elseif $aNextPhoto.mature == 2 && Phpfox::getUserParam('photo.photo_mature_age_limit') > Phpfox::getUserBy('age')}
		<a href="{$aNextPhoto.link}">
		    {img theme='misc/no_access.png' width='75px'}
		</a>
		{/if}
	    </div>
	{/foreach}
	{/if}	
	</div>
    </div>
    <div class="clear"></div>
</div>
{else}
<br />
<br />
{/if}