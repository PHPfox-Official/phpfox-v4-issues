<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: twitter.html.php 982 2009-09-16 08:11:36Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aPhpfoxTweets name=tweets item=aTweet}
<div class="{if is_int($phpfox.iteration.tweets/2)}row1{else}row2{/if}{if $phpfox.iteration.tweets == 1} row_first{/if}">
	<a href="{$aTweet.link}" target="_blank">{$aTweet.title|clean}</a>
	<div class="extra_info">
		{$aTweet.posted_on}
	</div>
</div>
{/foreach}