<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: search.html.php 7102 2014-02-11 14:28:49Z Fern $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
{if !defined('PHPFOX_IS_FORCED_404') && !empty($aSearchTool) && is_array($aSearchTool)}
	<div class="header_bar_menu">
		<div class="row">
		{if isset($aSearchTool.search)}
			<div class="header_bar_search col-lg-4 col-md-3 col-sm-3">
				<form id="form_main_search" class="" method="GET" action="{$aSearchTool.search.action|clean}" onbeforesubmit="$Core.Search.checkDefaultValue(this,\'{$aSearchTool.search.default_value}\');">
					<div class="hidden">
						{if (isset($aSearchTool.search.hidden))}
						{$aSearchTool.search.hidden}
						{/if}
					</div>
					<div class="header_bar_search_holder form-group form-group-sm has-feedback">
						<div class="header_bar_search_inner">
							<div class="input-group" style="width: 100%">

								<input type="search" class="form-control" name="search[{$aSearchTool.search.name}]" value="{if isset($aSearchTool.search.actual_value)}{$aSearchTool.search.actual_value|clean}{/if}" placeholder="{$aSearchTool.search.default_value}" />
								<a class="form-control-feedback">
									<i class="fa fa-search"></i>
								</a>
								<div class="input-group-btn visible-xs">
									<button type="button" class="btn btn-default btn-sm" data-expand="expander" data-target="#mobile_search_expander">
										<i class="fa fa-ellipsis-h"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<div id="js_search_input_holder">
						<div id="js_search_input_content pull-right">
							{if isset($sModuleForInput)}
								{module name='input.add' module=$sModuleForInput bAjaxSearch=true}
							{/if}
						</div>
					</div>
				</form>
			</div>
		{/if}

		{if isset($aSearchTool.filters) && count($aSearchTool.filters)}
			<div class="header_filter_holder hidden-xs col-lg-8 col-md-9 col-sm-9">
				<div class="pull-right btn-group">
					{foreach from=$aSearchTool.filters key=sSearchFilterName item=aSearchFilters name=fkey}
					{if !isset($aSearchFilters.is_input)}
					<div class="btn-group">
						<a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="">{$sSearchFilterName}:</span>
								<span>{if isset($aSearchFilters.active_phrase)}{$aSearchFilters.active_phrase}{else}{$aSearchFilters.default_phrase}{/if}<span>
								<span class="caret"></span>
						</a>
						<ul class="dropdown-menu {if $phpfox.iteration.fkey < 2}{else}dropdown-menu-right{/if} dropdown-menu-limit">
							{foreach from=$aSearchFilters.data item=aSearchFilter}
							<li>
								<a href="{$aSearchFilter.link}" class="ajax_link {if isset($aSearchFilter.is_active)}active{/if}" {if isset($aSearchFilter.nofollow)}rel="nofollow"{/if}>
								{$aSearchFilter.phrase}
								</a>
							</li>
							{/foreach}
							{if (isset($aSearchFilters.default))}
							<li class="divider"></li>
							<li><a href="{$aSearchFilters.default.url}" class="is_default">{$aSearchFilters.default.phrase}</a></li>
							{/if}
						</ul>
					</div>
					{/if}
					{/foreach}
					{if Phpfox::isModule('input') && isset($bHasInputs) && $bHasInputs == true}
					<div class="header_bar_float">
						<div class="header_bar_drop_holder">
							<ul class="header_bar_drop">
								<li>
									<a href="#" class="header_bar_drop" onclick="$('#js_search_input_holder').show(); return false;">
										{phrase var='input.advanced_filters'}
									</a>
								</li>
							</ul>
						</div>
					</div>
					{/if}
				</div>
			</div>
		{/if}

		{if isset($aSearchTool.filters) && count($aSearchTool.filters)}
		<div class="header_filter_holder visible-xs col-lg-8 col-md-9 col-sm-9 close" id="mobile_search_expander">
			<div class="">
				{foreach from=$aSearchTool.filters key=sSearchFilterName item=aSearchFilters name=fkey}
				{if !isset($aSearchFilters.is_input)}
				<div class="form-group">
					<a class="btn btn-sm btn-default btn-block" data-toggle="dropdown">
						<span class="">{$sSearchFilterName}:</span>
							<span>{if isset($aSearchFilters.active_phrase)}{$aSearchFilters.active_phrase}{else}{$aSearchFilters.default_phrase}{/if}<span>
							<span class="caret"></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right dropdown-menu-limit">
						{foreach from=$aSearchFilters.data item=aSearchFilter}
						<li>
							<a href="{$aSearchFilter.link}" class="ajax_link {if isset($aSearchFilter.is_active)}active{/if}" {if isset($aSearchFilter.nofollow)}rel="nofollow"{/if}>
							{$aSearchFilter.phrase}
							</a>
						</li>
						{/foreach}
						{if (isset($aSearchFilters.default))}
						<li class="divider"></li>
						<li><a href="{$aSearchFilters.default.url}" class="is_default">{$aSearchFilters.default.phrase}</a></li>
						{/if}
					</ul>
				</div>
				{/if}
				{/foreach}
				{if Phpfox::isModule('input') && isset($bHasInputs) && $bHasInputs == true}
				<div class="form-group">
					<div class="header_bar_drop_holder">
						<ul class="header_bar_drop">
							<li>
								<a href="#" class="header_bar_drop" onclick="$('#js_search_input_holder').show(); return false;">
									{phrase var='input.advanced_filters'}
								</a>
							</li>
						</ul>
					</div>
				</div>
				{/if}
			</div>
		</div>
		{/if}
		</div>
	</div>
{/if}

