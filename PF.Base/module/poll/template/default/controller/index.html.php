<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Poll
 * @version 		$Id: index.html.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aPolls)}
<div class="extra_info">
	{phrase var='poll.no_polls_found'}
</div>
{else}
	{foreach from=$aPolls item=aPoll key=iKey name=polls}
		<div class="row_banner image_load" data-src="{if $aPoll.image_path}{img server_id=$aPoll.server_id path='poll.url_image' file=$aPoll.image_path suffix='' return_url=true}{/if}">
			<header>
				<h1 itemprop="name"><a href="{permalink module='poll' id=$aPoll.poll_id title=$aPoll.question}" class="link" itemprop="url">{$aPoll.question|clean}</a></h1>
				<ul>
					<li>@ {$aPoll.time_stamp|convert_time}</li>
					<li>by {$aPoll|user}</li>
				</ul>
			</header>
		</div>
	{/foreach}

	{pager}
	{if !PHPFOX_IS_AJAX && Phpfox::getUserParam('poll.poll_can_moderate_polls')}
	{moderation}
	{/if}
{/if}