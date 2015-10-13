<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: mutual-browse.html.php 2632 2011-05-26 19:28:02Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !$iPage && !count($aFriends)}
<div class="extra_info">
	No mutual friends found.
</div>
{else}
<div id="js_friend_mutual_view_information">
  <a href="{url link=''$sUserName'.friend.mutual'}">
    {if $iTotalMutualFriends == 1}
    {phrase var='friend.1_friend_in_common'}
    {else}
    {phrase var='friend.total_friends_in_common' total=$iTotalMutualFriends}
    {/if}
  </a>
</div>
{foreach from=$aFriends name=friends item=aFriend}
<div class="row1{if $phpfox.iteration.friends == 1 && !$iPage} row_first{/if}">
	<div class="go_left" style="width:55px; text-align:center;">
		{img user=$aFriend suffix='_50_square' max_width=50 max_height=50}	
	</div>
	<div style="margin-left:55px;">
		{$aFriend|user}
	</div>
	<div class="clear"></div>
</div>
{/foreach}
  {if !$iPage}
    <!--<div id="js_friend_mutual_browse_append"></div>-->
    <div id="js_friend_mutual_view_more_link">
      <a href="{url link=''$sUserName'.friend.mutual'}">
        {phrase var='core.view_more'}
      </a>
    </div>
  {else}
    <div id="js_friend_mutual_browse_append_pager">
      {pager}
    </div>
  {/if}
{/if}