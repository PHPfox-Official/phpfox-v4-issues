<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: edit.html.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aItems)}
{foreach from=$aItems key=iKey item=aBlog}
<div style="border-bottom:1px #ccc solid; margin-bottom:10px;">
<div class="go_left">
	<input type="checkbox" name="id[]" class="checkbox" value="{$aBlog.blog_id}" id="js_id_row{$aBlog.blog_id}" />
</div>
<div class="go_left">
	<a href="{url link='blog.add' id=$aBlog.blog_id}">{$aBlog.title|clean}</a>
	<div class="p_4">
		{if isset($aBlog.info)}{phrase var='blog.categories'}: {$aBlog.info} <br />{/if}
		{if isset($aBlog.tag_list)}{phrase var='blog.tags'}: {module name='tag.item' sType='my_blogs' sTags=$aBlog.tag_list iItemId=$aBlog.blog_id iUserId=$aBlog.user_id} <br />{/if}
		{phrase var='blog.status'}: <a href="#">{if $aBlog.post_status == 1}{phrase var='blog.published'}{else}{phrase var='blog.draft'}{/if}</a> <br />
		{phrase var='blog.date'}: {$aBlog.time_stamp|date:'core.global_update_time'} <br />		
	</div>
</div>
<div class="t_right">
	<a href="#">{phrase var='blog.delete'}</a>
</div>
<div class="clear"></div>
</div>
{/foreach}

<br />

{pager}

{/if}