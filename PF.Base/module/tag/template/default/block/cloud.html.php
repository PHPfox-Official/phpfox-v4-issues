<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Tag
 * @version 		$Id: cloud.html.php 6951 2013-11-29 13:01:17Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aRows)}
	{if Phpfox::getParam('tag.enable_hashtag_support')}
		<div id="hashtag_cloud">
	{/if}
	<div class="tag_cloud">
		<ul>
			{foreach from=$aRows item=aRow}
				<li>
					<a href="{$aRow.link}" data-text="{$aRow.key}">
						{if Phpfox::getParam('tag.enable_hashtag_support')}#{/if}{$aRow.key}
					</a>
				</li>
			{/foreach}
		</ul>
		<div class="clear"></div>
	</div>
	<div class="extra_info">
		{phrase var='tag.trending_since_since' since=$sTrendingSince}
	</div>
	{if Phpfox::getParam('tag.enable_hashtag_support')}
		</div>
	{/if}
{else}
	<div class="message">
		{phrase var='tag.no_tags_have_been_found'}
	</div>
{/if}