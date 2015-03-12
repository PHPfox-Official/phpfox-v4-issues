<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Comment
 * @version 		$Id: rating.html.php 1251 2009-11-09 21:02:59Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if Phpfox::isModule('comment')}
{if $sRating == '+1' || $sRating == '-1'}{phrase var='comment.vote' total=$sRating}{else}{phrase var='comment.votes' total=$sRating}{/if} {if $bSameUser}{img theme='misc/vote_up_off.gif' alt='' style='vertical-align:middle;'}{img theme='misc/vote_down_off.gif' alt='' style='vertical-align:middle;'}{else}{if $bHasRating && $iLastVote == '+1'}{img theme='misc/vote_up_off.gif' alt='' style='vertical-align:middle;'}{else}<a href="#" onclick="{if Phpfox::isUser()}$('#js_feed_rating{$iFeedId}').html($.ajaxProcess()); {/if}$.ajaxCall('feed.rate', 'id={$iFeedId}&amp;type=up'); return false;" title="{phrase var='comment.vote_this_comment'}">{img theme='misc/vote_up.gif' alt='' style='vertical-align:middle;'}</a>{/if}{if $bHasRating && $iLastVote == '-1'}{img theme='misc/vote_down_off.gif' alt='' style='vertical-align:middle;'}{else}<a href="#" onclick="{if Phpfox::isUser()}$('#js_feed_rating{$iFeedId}').html($.ajaxProcess()); {/if}$.ajaxCall('feed.rate', 'id={$iFeedId}&amp;type=down'); return false;" title="{phrase var='comment.vote_this_comment_down'}">{img theme='misc/vote_down.gif' alt='' style='vertical-align:middle;'}</a>{/if}{/if}
{/if}