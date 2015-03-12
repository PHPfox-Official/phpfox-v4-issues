<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Forum
 * @version 		$Id: thread-entry.html.php 5844 2013-05-09 08:00:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{item name='CreativeWork'}
	<meta itemprop="dateCreated" content="{$aThread.time_stamp|micro_time}" />
	 <meta itemprop="interactionCount" content="Replies:{$aThread.total_post|number_format}" />
	 <meta itemprop="interactionCount" content="Views:{$aThread.total_view|number_format}" />
	<div class="forum_row js_selector_class_{$aThread.thread_id} checkRow table_row{if $aThread.is_announcement} forum_announcement{/if}{if $aThread.order_id == 1} forum_sticky {elseif $aThread.order_id == 2 && !defined('PHPFOX_IS_GROUP_VIEW')} forum_sponsor {/if}{if $aThread.view_id} row_moderate{/if}">
		<div class="forum_image">
			<div class="forum_image_holder">
				<div class="forum_mini_{$aThread.css_class} js_hover_title"><div class="js_hover_info">{$aThread.css_class_phrase}</div></div>
				{img user=$aThread suffix='_50_square'}			
			</div>		
			{if Phpfox::getUserParam('forum.can_approve_forum_thread') || Phpfox::getUserParam('forum.can_delete_other_posts')}<a href="#{$aThread.thread_id}" class="moderate_link" rel="forum">{phrase var='forum.moderate'}</a>{/if}
		</div>
		<div class="forum_title">
			<div class="forum_title_inner_holder">
				<header>
					{if $aThread.order_id == 1}
						<span class="forum_tag_sticky">{phrase var='forum.sticky'}</span>: 
					{/if}				
					<h1 itemprop="name"><a href="{permalink module='forum.thread' id=$aThread.thread_id title=$aThread.title}" class="forum_thread_link{if $aThread.css_class == 'new'} forum_thread_link_new{/if}" itemprop="url">{$aThread.title|clean|split:40|shorten:100:'...'}</a></h1>
					<div class="extra_info_link">
						{phrase var='forum.by_full_name_on_time' full_name=$aThread|user:'':'':50:'':'author' time=$aThread.time_stamp|convert_time}
					</div>
				</header>
			</div>
			
			{if !$aThread.is_announcement}
			{if Phpfox::isMobile()}
			<div class="forum_thread_total">
				<div class="extra_info">
					<ul class="extra_info_middot">{if $aThread.poll_id}<li><span class="js_hover_title">{img theme='misc/chart_bar.png' class='v_middle'}<span class="js_hover_info">{phrase var='forum.this_thread_contains_a_poll'}</span></span></li>{/if}<li>{phrase var='forum.replies'}: {$aThread.total_post|number_format}</li><li>&middot;</li><li>{phrase var='forum.views'}: {$aThread.total_view|number_format}</li></ul>
				</div>
			</div>	
			<div class="forum_thread_last_post">
				<a href="{permalink module='forum.thread' id=$aThread.thread_id title=$aThread.title}post_{$aThread.post_id}/">{$aThread.time_update|date:'forum.forum_time_stamp'}</a>
				<div class="extra_info_link">
					{phrase var='forum.by'} {if $aThread.last_user_id}{$aThread|user:'last_'}{else}{$aThread|user}{/if}	
				</div>
			</div>
			{/if}
			{/if}		
		</div>
		{if !$aThread.is_announcement}
		{if !Phpfox::isMobile()}
		<div class="forum_thread_total">
			<div class="extra_info">
				<ul class="extra_info_middot">{if $aThread.poll_id}<li><span class="js_hover_title">{img theme='misc/chart_bar.png' class='v_middle'}<span class="js_hover_info">{phrase var='forum.this_thread_contains_a_poll'}</span></span></li>{/if}<li>{phrase var='forum.replies'}: {$aThread.total_post|number_format}</li><li>&middot;</li><li>{phrase var='forum.views'}: {$aThread.total_view|number_format}</li></ul>
			</div>
		</div>	
		<div class="forum_thread_last_post">
			<a href="{permalink module='forum.thread' id=$aThread.thread_id title=$aThread.title}post_{$aThread.post_id}/">{$aThread.time_update|date:'forum.forum_time_stamp'}</a>
			<div class="extra_info_link">
				{phrase var='forum.by'} {if $aThread.last_user_id}{$aThread|user:'last_':'':'user.maximum_length_for_full_name'}{else}{$aThread|user:'':'':'user.maximum_length_for_full_name'}{/if}	
			</div>
		</div>
		{/if}
		{/if}
	</div>
{/item}