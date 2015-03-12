<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Comment
 * @version 		$Id: moderate.html.php 981 2009-09-15 13:53:22Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="js_request_comment_holder">
	<div id="comment"><a name="comment"></a></div>
	<h3>{phrase var='comment.moderate_comments'}</h3>
	{foreach from=$aComments item=aComment name=comment}
	<form method="post" action="#">
		<div class="public_message" id="js_comment_message_{$aComment.comment_id}">
			{phrase var='comment.comment_successfully_approved'}
		</div>
		<div id="comment_id_{$aComment.comment_id}"><a name="comment_id_{$aComment.comment_id}"></a></div>
		<div class="{if is_int($phpfox.iteration.comment/2)}row1{else}row2{/if}{if $phpfox.iteration.comment == 1} row_first{/if}" id="js_comment_{$aComment.comment_id}">
			<div class="go_left t_center" style="width:60px;">
				{img user=$aComment suffix='_50' max_width=50 max_height=50}
			</div>
			<div style="margin-left:65px;">
				<div class="p_bottom_10">
					{$aComment.item_message}
				</div>
				<div class="p_bottom_10">
					{$aComment.text|parse}			
				</div>
				<input type="button" value="{phrase var='comment.approve'}" class="button" onclick="$.ajaxCall('comment.moderate' , 'action=approve&amp;id={$aComment.comment_id}'); return false;" /> 
				<input type="button" value="{phrase var='comment.deny'}" class="button" onclick="$.ajaxCall('comment.moderate' , 'action=deny&amp;id={$aComment.comment_id}'); return false;" />
			</div>
			<div class="clear"></div>		
		</div>
	</form>
	{/foreach}
</div>