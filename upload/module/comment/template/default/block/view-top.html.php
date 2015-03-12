<div id="js_comment_listing">
<a name="comment-view"></a>
<div id="js_new_comment" style="display:none;"></div>
	{if isset($bViewComment) && $bViewComment}
	<a href="{url link='current' comment=0}" id="feed_view_more">{{phrase var='comment.view_all_comments_total' total=$iTotalComments}</a>
	{/if}