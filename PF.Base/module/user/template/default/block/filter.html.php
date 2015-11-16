<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: filter.html.php 6860 2013-11-06 20:17:19Z Fern $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
<form method="GET" action="{if isset($aCallback.url_home)}{url link=$aCallback.url_home view=$sView}{else}{url link='user.browse' view=$sView}{/if}">
{if isset($aCallback.url_home)}
	<div><input type="hidden" name="url_home" value="{$aCallback.url_home}" /></div>
{/if}
{if Phpfox::getUserParam('user.can_search_user_gender')}
	<div class="table">
		<div class="table_left">{phrase var='user.browse_for'}</div>
		<div class="table_right">
			{filter key='gender'}
		</div>
	</div>
{/if}
{if Phpfox::getUserParam('user.can_search_user_age')}
	<div class="table">
		<div class="table_left">{phrase var='user.between_ages'}</div>
		<div class="table_right form-inline">
			{filter key='from'}&nbsp;{filter key='to'}
		</div>
	</div>
{/if}
	<div class="table">
		<div class="table_left">{phrase var='user.located_within'}</div>
		<div class="table_right">
			{filter key='country'}
			{module name='core.country-child' country_child_filter=true country_child_type='browse'}
		</div>
	</div>

	<div class="table">
		<div class="table_left">{phrase var='user.city'}</div>
		<div class="table_right">
			{filter key='city'}
		</div>
	</div>
	
	{if Phpfox::getUserParam('user.can_search_by_zip')}
		<div class="table">
			<div class="table_left">{phrase var='user.zip_postal_code'}</div>
			<div class="table_right">
				{filter key='zip'}
			</div>
		</div>
	{/if}
	
	<div class="table">
		<div class="table_left">{phrase var='user.keywords'}</div>
		<div class="table_right">
			{filter key='keyword'}
			<div class="extra_info" style="display:none;">
				{phrase var='user.within'}: {filter key='type'}
			</div>
		</div>
	</div>

	<ul id="js_user_browse_advanced_link">
		<li><a href="#" onclick="$('.main_search_browse_button').toggle(); $('#js_user_browse_advanced').toggleClass('active'); return false;" id="user_browse_advanced_link">View Advanced Filters</a></li>
		{if isset($bIsInSearchMode) && $bIsInSearchMode}
		<li><a href="#"><a href="{url link='user.browse'}">{phrase var='user.reset_browse_criteria'}</a></a></li>
		{/if}
	</ul>
		
	<div class="table_clear main_search_browse_button">
		<input type="submit" value="Search" class="button" name="search[submit]" />
	</div>
	
	<div id="js_user_browse_advanced">
		<div class="user_browse_content">
			<div id="browse_custom_fields_popup_holder">
			    {foreach from=$aCustomFields name=customfield item=aCustomField}
				{if isset($aCustomField.fields)}
					{template file='custom.block.foreachcustom'}
				{/if}
			    {/foreach}
			</div>
			{if count($aForms)}
			{literal}
			<script type="text/javascript">
				$Behavior.user_filter_1 = function()
				{
					var iBrowseCnt = 0;
					$('#js_block_border_user_filter .menu li').each(function()
					{
						iBrowseCnt++;
						if (iBrowseCnt == 1)
						{
							$(this).removeClass('active');
						}
						else
						{
							$(this).addClass('active');
						}
					});
				};
			</script>
			{/literal}
			{/if}

			<div class="table" style="display:none;">
			    <div class="table_left">{phrase var='user.sort_results_by'}</div>
			    <div class="table">
				{filter key='sort'} {filter key='sort_by'}
			    </div>
			</div>

			<div class="table_clear">
			    <input type="submit" value="Search" class="button" name="search[submit]" />
			</div>
		</div>
	</div>
	
	{if isset($sCountryISO)}
		<script type="text/javascript">
			$Behavior.loadStatesAfterBrowse = function()
			{l}
				sCountryISO = "{$sCountryISO}";
				if(sCountryISO != "")
				{l}
					sCountryChildId = "{$sCountryChildId}";
					$.ajaxCall('core.getChildren', 'country_child_filter=true&country_child_type=browse&country_iso=' + sCountryISO + '&country_child_id=' + sCountryChildId);
				{r}
			{r}
		</script>
	{/if}
	
</form>
