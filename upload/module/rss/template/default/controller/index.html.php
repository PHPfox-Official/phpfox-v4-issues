<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Rss
 * @version 		$Id: index.html.php 3411 2011-11-02 09:27:55Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if is_array($aGroupFeeds)}
{foreach from=$aGroupFeeds key=sGroup item=aFeeds name=feeds}
<div class="row3">
	<div class="row_title_group">{phrase var=$sGroup}</div>
	<ul class="action">
	{foreach from=$aFeeds item=aFeed}
		{if isset($aFeed.child)}
		<li><div class="parent">{phrase var=$aFeed.title_var}</div>
			<ul>
			{foreach from=$aFeed.child key=sLink item=sPhrase}
				<li><a href="{$sLink}" class="no_ajax_link">{img theme='rss/tiny.png' class='v_middle'} {$sPhrase|convert}</a></li>	
			{/foreach}
			</ul>
		</li>
		{else}
		<li><a href="{url link='rss' id=$aFeed.feed_id}" class="no_ajax_link">{img theme='rss/tiny.png' class='v_middle'} {phrase var=$aFeed.title_var}</a></li>
		{/if}
	{/foreach}
	</ul>
</div>
{/foreach}
{else}
<div class="extra_info">
	{phrase var='rss.no_rss_feeds_are_available'}
</div>
{/if}