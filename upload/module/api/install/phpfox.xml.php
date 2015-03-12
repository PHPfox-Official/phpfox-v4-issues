<module>
	<data>
		<module_id>api</module_id>
		<product_id>phpfox</product_id>
		<is_core>1</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_api</phrase_var_name>
		<writable />
	</data>
	<hooks>
		<hook module_id="api" hook_type="controller" module="api" call_name="api.component_controller_index_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="api" hook_type="controller" module="api" call_name="api.component_controller_admincp_gateway_index_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="api" hook_type="controller" module="api" call_name="api.component_controller_admincp_gateway_add_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="api" hook_type="controller" module="api" call_name="api.component_controller_gateway_callback_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="api" hook_type="component" module="api" call_name="api.component_block_list_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="api" hook_type="service" module="api" call_name="api.service_gateway_gateway__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="api" hook_type="service" module="api" call_name="api.service_gateway_process__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="api" hook_type="service" module="api" call_name="api.service_process__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="api" hook_type="service" module="api" call_name="api.service_api__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="api" hook_type="service" module="api" call_name="api.service_callback__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="api" hook_type="template" module="api" call_name="api.template_block_gateway_form_start" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="api" hook_type="template" module="api" call_name="api.template_block_gateway_form_end" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="api" hook_type="controller" module="api" call_name="api.component_controller_method_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="api" hook_type="controller" module="api" call_name="api.component_controller_token_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="api" hook_type="service" module="api" call_name="api.service_api_sendresponse_1" added="1358258443" version_id="3.5.0beta1" />
		<hook module_id="api" hook_type="service" module="api" call_name="api.service_api_createtoken_1" added="1361180401" version_id="3.5.0rc1" />
		<hook module_id="api" hook_type="service" module="api" call_name="api.service_gateway_gateway_getactive_1" added="1362126685" version_id="3.5.0" />
	</hooks>
	<phrases>
		<phrase module_id="api" version_id="2.0.0beta4" var_name="module_api" added="1244660981">Api</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="unable_to_find_the_payment_gateway" added="1252912087">Unable to find the payment gateway.</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="gateway_successfully_updated" added="1252912098">Gateway successfully updated.</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="payment_gateways" added="1252912106">Payment Gateways</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="editing" added="1252912117">Editing</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="cost_per_month" added="1252912239">{cost} per month</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="default_cost_and_then_cost_per_month" added="1252912274">{default_cost} and then {cost} per month</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="cost_per_quarter" added="1252912309">{cost} per quarter</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="default_cost_and_then_cost_per_quarter" added="1252912343">{default_cost} and then {cost} per quarter</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="cost_biannualy" added="1252912372">{cost} biannualy</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="cost_annually" added="1252912385">{cost} annually</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="default_cost_and_then_cost_biannualy" added="1252912426">{default_cost} and then {cost} biannualy</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="default_cost_and_then_cost_annually" added="1252912446">{default_cost} and then {cost} annually</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="provide_a_name" added="1252912486">Provide a name.</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="provide_a_description" added="1252912494">Provide a description.</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="select_if_the_gateway_is_active_or_not" added="1252912503">Select if the gateway is active or not.</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="select_if_the_gateway_is_in_test_mode" added="1252912513">Select if the gateway is in test mode.</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="opps_no_payment_gateways_have_been_set_up_yet" added="1252912564">Opps! No payment gateways have been set up yet.</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="purchase_with_gateway_name" added="1252912577">Purchase with {gateway_name}</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="gateway_details" added="1252912604">Gateway Details</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="title" added="1252913445">Title</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="description" added="1252913463">Description</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="test_mode" added="1252913532">Test Mode</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="update" added="1252913593">Update</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="gateways" added="1252913669">Gateways</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="active" added="1252913703">Active</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="edit_gateway_settings" added="1252913717">Edit Gateway Settings</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="disable_test_mode" added="1252922033">Disable Test Mode</phrase>
		<phrase module_id="api" version_id="2.0.0rc2" var_name="enable_test_mode" added="1252922041">Enable Test Mode</phrase>
		<phrase module_id="api" version_id="3.3.0beta1" var_name="initial_fee_one_time" added="1337757755">{currency_symbol}{cost} one time</phrase>
		<phrase module_id="api" version_id="3.3.0beta1" var_name="initial_fee_recurring_fee_annually" added="1337758574">{currency_symbol}{initial_fee} one time and then {currency_symbol}{recurring_fee} annually.</phrase>
		<phrase module_id="api" version_id="3.3.0beta1" var_name="initial_fee_then_cost_per_month" added="1337760039">{currency_symbol}{initial_fee} one time and then {currency_symbol}{recurring_fee} monthly</phrase>
		<phrase module_id="api" version_id="3.3.0beta1" var_name="no_initial_then_cost_per_month" added="1337760884">Free for the first month, then {currency_symbol}{recurring_fee} monthly</phrase>
		<phrase module_id="api" version_id="3.3.0beta1" var_name="initial_fee_then_cost_per_quarter" added="1337768761">{currency_symbol}{initial_fee} one time and then {currency_symbol}{recurring_fee} quarterly.</phrase>
		<phrase module_id="api" version_id="3.3.0beta1" var_name="no_initial_then_cost_per_quarter" added="1337768842">Free for the first month, then {currency_symbol}{recurring_fee} quarterly</phrase>
		<phrase module_id="api" version_id="3.3.0beta1" var_name="initial_fee_then_cost_biannually" added="1337769065">{currency_symbol}{initial_fee} one time and then {currency_symbol}{recurring_fee} biannually</phrase>
		<phrase module_id="api" version_id="3.3.0beta1" var_name="no_initial_then_cost_biannually" added="1337769102">Free for the first month, then {currency_symbol}{recurring_fee} biannually.</phrase>
		<phrase module_id="api" version_id="3.3.0beta1" var_name="initial_fee_then_cost_yearly" added="1337769140">{currency_symbol}{initial_fee} one time and then {currency_symbol}{recurring_fee} yearly.</phrase>
		<phrase module_id="api" version_id="3.3.0beta1" var_name="no_initial_then_cost_yearly" added="1337769197">Free for the first month, then {currency_symbol}{recurring_fee} yearly.</phrase>
	</phrases>
	<tables><![CDATA[a:2:{s:18:"phpfox_api_gateway";a:2:{s:7:"COLUMNS";a:6:{s:10:"gateway_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:150";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"description";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"is_test";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"setting";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:2:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}s:10:"gateway_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:10:"gateway_id";i:1;s:9:"is_active";}}}}s:22:"phpfox_api_gateway_log";a:2:{s:7:"COLUMNS";a:5:{s:6:"log_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"gateway_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"log_data";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"ip_address";a:4:{i:0;s:8:"VCHAR:15";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:6:"log_id";}}]]></tables>
	<install><![CDATA[		
	$aGateways = array(
		array(
			'gateway_id' => 'paypal',
			'title' => 'PayPal',
			'description' => 'Some information about PayPal...',
			'is_active' => '0',
			'is_test' => '0',
			'setting' => serialize(array(
					'paypal_email' => ''
				)
			)
		),
		array(
			'gateway_id' => '2checkout',
			'title' => '2checkout',
			'description' => 'Some information about 2checkout...',
			'is_active' => '0',
			'is_test' => '0',
			'setting' => serialize(array(
					'2co_id' => '',
					'2co_secret' => ''
				)
			)
		)	
	);	
	foreach ($aGateways as $aGateways)
	{
		$this->database()->insert(Phpfox::getT('api_gateway'), $aGateways);	
	}	
	]]></install>
</module>