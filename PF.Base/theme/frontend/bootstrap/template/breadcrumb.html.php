<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: breadcrumb.html.php 5844 2013-05-09 08:00:59Z Raymond_Benc $
 */

defined('PHPFOX') or exit('NO DICE!');
?>
<div class="row hide-overflow">
	<div class="col-md-12">
		<div class="pull-left breadcrumbs_left_section">
			{if isset($aBreadCrumbs) && count($aBreadCrumbs) > 0}
			<div class="breadcrumbs">
				{if empty($aBreadCrumbTitle) == false }

				<a href="{ $aBreadCrumbTitle[1] }" class="ajax_link"><h1>{ $aBreadCrumbTitle[0] }</h1></a>
				{else}
				{if isset($aBreadCrumbs) && count($aBreadCrumbs) == 1}
				{foreach from=$aBreadCrumbs key=sLink item=sCrumb name=link}
				<h1>
					{if !empty($sLink)}<a href="{$sLink}" class="ajax_link">{/if}
						{$sCrumb|clean}
						{if !empty($sLink)}</a>{/if}
				</h1>
				{/foreach}
				{/if}

				{if isset($aBreadCrumbs) && count($aBreadCrumbs) > 1}
				{breadcrumb_list}
				{/if}
				{/if}
			</div>
			{/if}
		</div>
		<div class="pull-right breadcrumbs_right_section">
			{breadcrumb_menu}
		</div>
	</div>
</div>