<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Page
 * @version 		$Id: index.html.php 1194 2009-10-18 12:43:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aPages)}
<form method="post" action="{url link='admincp.page'}">
	<table cellpadding="0" cellspacing="0">
	{foreach from=$aPages key=iKey item=aPage}
	<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
		<td><a href="{url link=$aPage.title_url}" class="targetBlank {if !$aPage.is_active}inactive_page{/if}" {if !$aPage.is_active} title="{phrase var='page.inactive_page'}"{/if}>{if $aPage.is_phrase}{phrase var=$aPage.title}{else}{$aPage.title}{/if}</a></td>
		<td>
			<ul class="table_actions">
				<li>
					<a href="{url link='admincp.page.add.' id=$aPage.page_id}" class="is_edit popup" data-custom-class="js_box_full">
						<i class="fa fa-edit"></i>
					</a>
				</li>
				<li><a href="{url link='admincp.page.' delete=$aPage.page_id}" class="is_delete"><i class="fa fa-remove"></i></a></li>
			</ul>
		</td>
	</tr>
	{/foreach}
	</table>
</form>
{else}
{phrase var='page.no_pages_have_been_added'}
{/if}