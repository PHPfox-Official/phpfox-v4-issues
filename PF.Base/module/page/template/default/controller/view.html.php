<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Page
 * @version 		$Id: view.html.php 3917 2012-02-20 18:21:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>


{plugin call='page.template_controller_view_start'}

{if $aPage.parse_php}{$aPage.text_parsed|eval}{else}{$aPage.text_parsed}{/if}

{if Phpfox::getUserParam('page.can_manage_custom_pages') && Phpfox::getUserParam('admincp.has_admin_access')}
<div class="p_4 t_right">
	<a href="{url link='admincp.page.add' id=$aPage.page_id}">{phrase var='page.edit'}</a>	
	- <a href="{url link='admincp.page' delete=$aPage.page_id}" class="sJsConfirm">{phrase var='page.delete'}</a>
</div>

{/if}
{if Phpfox::isModule('tag') && isset($aPage.tag_list)}{module name='tag.item' sType=page sTags=$aPage.tag_list iItemId=$aPage.page_id iUserId=$aPage.user_id}{/if}
{if Phpfox::isModule('attachment') && $aPage.total_attachment > 0}{module name='attachment.list' sType='page' iItemId=$aPage.page_id}{/if}
{if $aPage.add_view && $aPage.total_view > 0}
<em>{if $aPage.total_view == 1}{phrase var='page.page_has_been_viewed_once'}{else}{phrase var='page.page_has_been_viewed' total=$aPage.total_view}.{/if}</em>
{/if}

{plugin call='page.template_controller_view_end'}
{if Phpfox::isModule('share') && $aPage.has_bookmark}
<div class="p_4">
	{phrase var='page.bookmark'}: {module name='share.bookmark' type='page' url=$aPage.bookmark_url title=$aPage.title}
</div>
{/if}