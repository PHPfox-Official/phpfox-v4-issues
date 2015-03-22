<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Bulletin
 * @version 		$Id: display.html.php 981 2009-09-15 13:53:22Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

{foreach from=$aBulletins item=aBulletin name=bulletin}
	{template file='bulletin.block.entry'}	
{foreachelse}
	<div class="extra_info">
		{phrase var='bulletin.no_bulletins_have_been_added_yet'}
		<ul class="action" style="margin-top:10px;">
			<li><a href="{url link='bulletin.add'}">{phrase var='bulletin.be_the_first_to_add_a_bulletin'}</a></li>
		</ul>		
	</div>
{/if}
