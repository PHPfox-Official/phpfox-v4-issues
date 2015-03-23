<module>
	<data>
		<module_id>request</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_request</phrase_var_name>
		<writable />
	</data>
	<settings>
		<setting group="" module_id="request" is_hidden="1" type="boolean" var_name="display_request_box_on_empty" phrase_var_name="setting_display_request_box_on_empty" ordering="1" version_id="2.0.0alpha3">0</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="request.index" module_id="request" component="feed" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="request" hook_type="component" module="request" call_name="request.component_block_feed_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="request" hook_type="component" module="request" call_name="request.component_block_feed_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="request" hook_type="controller" module="request" call_name="request.component_controller_index_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="request" hook_type="controller" module="request" call_name="request.component_controller_index_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="request" hook_type="service" module="request" call_name="request.service_request_getfeed" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="request" hook_type="service" module="request" call_name="request.service_request__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="request" hook_type="service" module="request" call_name="request.service_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="request" hook_type="template" module="request" call_name="request.template_controller_index" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="request" hook_type="controller" module="request" call_name="request.component_controller_view_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="request" hook_type="service" module="request" call_name="request.service_callback__call" added="1244973584" version_id="2.0.0beta4" />
	</hooks>
	<components>
		<component module_id="request" component="feed" m_connection="" module="request" is_controller="0" is_block="1" is_active="1" />
		<component module_id="request" component="index" m_connection="request.index" module="request" is_controller="1" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="request" version_id="2.0.0alpha1" var_name="module_request" added="1221480181">Request</phrase>
		<phrase module_id="request" version_id="2.0.0alpha3" var_name="setting_display_request_box_on_empty" added="1239098595"><![CDATA[<title>Display Request Box</title><info>Select True if you would like to display the requests (eg. friend requests) block on the sites index page even when a user has no requests.</info>]]></phrase>
		<phrase module_id="request" version_id="2.0.0rc4" var_name="requests" added="1255330458">Requests</phrase>
		<phrase module_id="request" version_id="2.0.0rc4" var_name="confirm_requests" added="1255330482">Confirm Requests</phrase>
		<phrase module_id="request" version_id="2.0.0rc4" var_name="invalid_request_redirect" added="1255330761">Invalid request redirect.</phrase>
		<phrase module_id="request" version_id="2.0.0rc4" var_name="there_are_no_new_requests" added="1255330810">There are no new requests.</phrase>
	</phrases>
</module>