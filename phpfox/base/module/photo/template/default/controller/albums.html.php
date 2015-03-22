<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: albums.html.php 6060 2013-06-14 09:28:36Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if $bSpecialMenu}
    {template file='photo.block.specialmenu'}
{/if}


{if count($aAlbums)}
    <div class="albums_container">
		<div class="albums_container_row">
			{foreach from=$aAlbums item=aAlbum name=albums}	
				{template file='photo.block.album-entry'}
				{if Phpfox::getParam('photo.show_info_on_mouseover') && (is_int($phpfox.iteration.albums/3))}
					</div>
					{if $phpfox.iteration.albums < count($aAlbums)}
						<div class="albums_container_row">
					{/if}
				{/if}
			{/foreach}
			
			{if Phpfox::getParam('photo.show_info_on_mouseover') && (!is_int($phpfox.iteration.albums/3))}
				</div>
			{/if}			
		</div>    
    </div>
    <div class="clear"></div>
    {pager}
{else}
    <div class="extra_info">
	    {phrase var='photo.no_albums_found_here'}
    </div>
{/if}