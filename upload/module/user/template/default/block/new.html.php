<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: new.html.php 5616 2013-04-10 07:54:55Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aUsers name=users item=aUser}
{if Phpfox::getLib('module')->getBlockLocation('core.new') == 'content'}
<div class="t_center p_bottom_10" style="width:23%; float:left;">
{else}
<div class="t_center p_bottom_10" style="width:32%; float:left;">		
{/if}
	{if Phpfox::getLib('module')->getBlockLocation('core.new') == 'content'}
	{img user=$aUser suffix='_50_square' max_width=75 max_height=75}
	{else}
	{img user=$aUser suffix='_50_square' max_width=50 max_height=50}
	{/if}	
	<div class="p_top_4">
		{$aUser|user}
	</div>
</div>
{if Phpfox::getLib('module')->getBlockLocation('core.new') == 'content'}
{if $phpfox.iteration.users == 4}
<div class="clear"></div>
{/if}
{else}
{if is_int($phpfox.iteration.users/3)}
<div class="clear"></div>
{/if}
{/if}
{/foreach}
<div class="clear"></div>
<div class="t_right">
	<ul class="item_menu">
		<li><a href="{url link='user.browse' sort='joined'}">{phrase var='user.view_more'}</a></li>
	</ul>
</div>