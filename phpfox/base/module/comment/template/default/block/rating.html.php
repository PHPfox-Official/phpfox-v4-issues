<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Comment
 * @version 		$Id: rating.html.php 1195 2009-10-19 10:35:24Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $sRating == '+1' || $sRating == '-1'}{phrase var='comment.vote' total=$sRating}{else}{phrase var='comment.votes' total=$sRating}{/if} {if $bSameUser}{img theme='misc/vote_up_off.gif' alt='' style='vertical-align:middle;'}{img theme='misc/vote_down_off.gif' alt='' style='vertical-align:middle;'}{else}{if $bHasRating && $iLastVote == '+1'}{img theme='misc/vote_up_off.gif' alt='' style='vertical-align:middle;'}{else}<a href="#" onclick="{if Phpfox::isUser()}$('#js_comment_rating{$iCommentId}').html($.ajaxProcess()); {/if}$.ajaxCall('comment.rate', 'id={$iCommentId}&amp;type=up'); return false;" title="{phrase var='comment.vote_this_comment'}">{img theme='misc/vote_up.gif' alt='' style='vertical-align:middle;'}</a>{/if}{if $bHasRating && $iLastVote == '-1'}{img theme='misc/vote_down_off.gif' alt='' style='vertical-align:middle;'}{else}<a href="#" onclick="{if Phpfox::isUser()}$('#js_comment_rating{$iCommentId}').html($.ajaxProcess()); {/if}$.ajaxCall('comment.rate', 'id={$iCommentId}&amp;type=down'); return false;" title="{phrase var='comment.vote_this_comment_down'}">{img theme='misc/vote_down.gif' alt='' style='vertical-align:middle;'}</a>{/if}{/if}