<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: news.html.php 2826 2011-08-11 19:41:03Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aPhpfoxNews name=news item=aNews}
<div class="p_bottom_10">
	<a href="{$aNews.link}" target="_blank">{$aNews.title|clean}</a>
	<div class="extra_info">
		{$aNews.posted_on}		
	</div>
</div>
{/foreach}