<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div id="apps_developer_holder">
	<div class="apps_dev_menu">
		<ul>
			<li><a href="#" class="active js_apps_menu_click" rel="">{phrase var='apps.introduction'}</a></li>
		</ul>
		<div class="apps_dev_menu_title">
			{phrase var='apps.api'}
		</div>	
		<ul>
		{foreach from=$aMethods item=aMethodModule}
			<li><a href="#" class="js_apps_menu_click" rel="{$aMethodModule.module|clean}">{$aMethodModule.module|clean}</a></li>
		{/foreach}
		</ul>
	</div>

	<div class="apps_dev_info">
		<div class="apps_module_holder apps_module_holder_main" id="js_apps_module_">
			<div class="p_bottom_10">
				{phrase var='apps.as_a_developer_you_can_create_applications' site_name=$sSiteName}
			</div>
			
			<div class="p_bottom_10">
				<h3>{phrase var='apps.setting_up_an_app'}</h3>
				{phrase var='apps.to_interact_with_site_name_your' site_name=$sSiteName}
				<p>
					{phrase var='apps.when_you_add_an_application' link=$sAppLink}
				</p>
			</div>
				
			<div class="p_bottom_10">
				<h3>{phrase var='apps.requesting_a_token'}</h3>
				<div class="p_bottom_10">
					{phrase var='apps.whenever_you_plan_on_using_our_api_you_must_first_request_a_token_in_order_to_request_a_token_you_need_a_unique_key_that_we_send_to_you_when_a_user_visits_your_app_from_an_iframe_on_our_site_we_pass_this_along_as_b_get_key_b'}
				</div>
				<div class="p_bottom_10">
					<div class="p_bottom_5">
						{phrase var='apps.this_is_an_example_of_how_you_can_request_a_token'}:
					</div>
					<div class="apps_method_response">	
						{$sTokenSampleCall}
					</div>					
				</div>
				<div class="p_bottom_5">
					{phrase var='apps.if_successful_you_will_get_a_json_response_like'}:				
				</div>
				<div class="apps_method_response">	
					{$sTokenResponse}
				</div>				
			</div>			
			
			<div class="p_bottom_10">
				<h3>{phrase var='apps.sending_a_request'}</h3>
				<div class="p_bottom_5">
					{phrase var='apps.now_that_you_have_a_valid_token_you_can_make_requests_to_our_server_with_each_request_you_must_pass_the_token_we_created_for_you'}
				</div>
				<div class="p_bottom_5">					
					{phrase var='apps.an_example_call_to_our_api_server_would_look_like'}:
				</div>
				<div class="apps_method_response">	
					{$sSampleCall}
				</div>
			</div>

			<div class="p_bottom_10">
				<h3>{phrase var='apps.understanding_an_api_response'}</h3>		
				<p>
					{phrase var='apps.for_methods_that_could_return_more_than_on'}
				</p>
				<p>
					{phrase var='apps.to_the_left_you_will_find_a_list_of_the_modules_that_implement'}
				</p>		
			</div>
		</div>
		{foreach from=$aMethods item=aMethodModule}
		<div class="apps_module_holder" id="js_apps_module_{$aMethodModule.module|clean}">
			<div class="apps_module_title">{$aMethodModule.module|clean}</div>
			{foreach from=$aMethodModule.methods item=aMethod}
			<div class="apps_method_holder">
				<div class="apps_method_title">
					{$aMethod.call|clean}
				</div>
				<div class="apps_method_type">
					{$aMethod.type}{if isset($aMethod.url)} {$aMethod.url}{/if}
				</div>
				<div class="apps_method_info">
					{$aMethod.detail|clean}
				</div>	
				{if !empty($aMethod.response)}
				<div class="apps_method_response_title">
					{phrase var='apps.response'}
				</div>
				<div class="apps_method_response">					
						{$aMethod.response}
				</div>
				{/if}
			</div>
			{/foreach}
		</div>
		{/foreach}
	</div>
</div>