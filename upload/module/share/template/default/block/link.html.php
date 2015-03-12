<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Share
 * @version 		$Id: link.html.php 4154 2012-05-07 14:32:57Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $sBookmarkDisplay == 'menu'}
<li class="sub_menu_bar_li"><a href="#" onclick="tb_show('{phrase var='share.share' phpfox_squote=true}', $.ajaxBox('share.popup', 'height=300&amp;width=550&amp;type={$sBookmarkType}&amp;url={$sBookmarkUrl}&amp;title={$sBookmarkTitle}{if isset($sFeedShareId) && $sFeedShareId > 0}&amp;feed_id={$sFeedShareId}{/if}{if isset($sFeedType)}&amp;is_feed_view=1{/if}&amp;sharemodule={$sShareModuleId}')); return false;"{if $bIsFirstLink} class="first"{/if}>{phrase var='share.share'}</a></li>
{elseif $sBookmarkDisplay == 'menu_link'}
<li><a href="#" onclick="tb_show('{phrase var='share.share' phpfox_squote=true}', $.ajaxBox('share.popup', 'height=300&amp;width=550&amp;type={$sBookmarkType}&amp;url={$sBookmarkUrl}&amp;title={$sBookmarkTitle}')); return false;"{if $bIsFirstLink} class="first"{/if}>{img theme='icon/share.png' class='item_bar_image'} {phrase var='share.share'}</a></li>
{elseif $sBookmarkDisplay == 'image'}
<a href="#" onclick="tb_show('{phrase var='share.share' phpfox_squote=true}', $.ajaxBox('share.popup', 'height=300&amp;width=350&amp;type={$sBookmarkType}&amp;url={$sBookmarkUrl}&amp;title={$sBookmarkTitle}')); return false;">{img theme='misc/icn_share.png' class='v_middle'} {phrase var='share.share'}</a>
{else}
<a href="#">{img theme='misc/add.png' alt='' style='vertical-align:middle;'}</a> <a href="#" onclick="tb_show('{phrase var='share.share' phpfox_squote=true}', $.ajaxBox('share.popup', 'height=300&amp;width=350&amp;type={$sBookmarkType}&amp;url={$sBookmarkUrl}&amp;title={$sBookmarkTitle}')); return false;">{phrase var='share.share'}</a>
{/if}