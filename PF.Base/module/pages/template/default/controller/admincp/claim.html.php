<?php
defined ('PHPFOX') or die('No dice!');
?>

<div class="table_header">
Claims
</div>
{if count($aClaims)}
<table>
	<tr>
		<th style="width:25px;"></th>
		<th>Claimed By</th>
		<th>Page Owner</th>
		<th>Page</th>
	</tr>
	{foreach from=$aClaims key=iKey item=aClaim}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}" id="claim_{$aClaim.claim_id}">
			<td> 
				<a href="#" class="js_drop_down_link" title="{phrase var='user.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
				<div class="link_menu">
					<ul>
						<li>
							<a href="#" onclick="$Core.Pages.Claim.approve({$aClaim.claim_id}); return false;">
								Grant
							</a>
							<a href="#" onclick="$Core.Pages.Claim.deny({$aClaim.claim_id}); return false;">
								Deny
							</a>
						</li>
					</ul>
				</div>
	
			</td>
			<td>{$aClaim|user}</td>
			<td>{$aClaim|user:'curruser_'}
			<td><a href="{$aClaim.url}">{$aClaim.title}</a></td>
			</td>
		</tr>
	{/foreach}
</table>
{else}
<div class="extra_info">
	There are no claims at the moment.
</div>
{/if}