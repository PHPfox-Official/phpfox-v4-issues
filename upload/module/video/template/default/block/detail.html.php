<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="video_info_box">
	<div class="video_info_box_content">
		<div class="video_info_view" itemprop="interactionCount">{if $aVideo.total_view == 0}1{else}{$aVideo.total_view|number_format}{/if}</div>	

		<ul class="video_info_box_list">
			<li class="full_name first">{$aVideo|user:'':'':50:'':'author'}</li>
			{foreach from=$aVideoDetails key=sKey item=sValue}
			<li>{$sValue} ({$sKey})</li>
			{/foreach}
		</ul>

		<div class="video_info_box_text" itemprop="description">
			{$aVideo.text|parse|shorten:'100':'video.view_more':true}
		</div>

		<div class="video_info_box_extra">	
			{if count($aVideo.breadcrumb)}
			<div class="table">
				<div class="table_left">
					{phrase var='video.category'}:
				</div>
				<div class="table_right js_allow_video_click">
				{foreach from=$aVideo.breadcrumb name=breadcrumbs item=aBredcrumb}
				{if $phpfox.iteration.breadcrumbs != 1}<div class="p_2">&raquo; {/if}
					<a href="{$aBredcrumb.1}">{$aBredcrumb.0}</a>
					{if $phpfox.iteration.breadcrumbs != 1}</div>{/if}
				{/foreach}
				</div>
			</div>
			{/if}

			{if !empty($aVideo.tag_list)}
			<div class="table">
				<div class="table_left">
					{phrase var='video.tags'}:
				</div>
				<div class="table_right js_allow_video_click">
				{foreach from=$aVideo.tag_list name=tags item=aTag}
					{if $phpfox.iteration.tags != 1}, {/if}<a href="{if isset($sGroup) && $sGroup !=''}{url link='group.'$sGroup'.video.tag.'$aTag.tag_url''}{else}{url link='video.tag.'$aTag.tag_url''}{/if}">{$aTag.tag_text}</a>
				{/foreach}
				</div>
			</div>
			{/if}	
		</div>
	</div>	
	<a href="#" class="video_info_toggle">
		<span class="js_info_toggle_show_more">{phrase var='video.show_more'} {img theme='layout/video_show_more.png'}</span>
		<span class="js_info_toggle_show_less">{phrase var='video.show_less'} {img theme='layout/video_show_less.png'}</span>
	</a>	
</div>