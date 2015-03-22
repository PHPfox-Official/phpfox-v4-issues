<module>
	<data>
		<module_id>subscribe</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:4:{s:36:"subscribe.admin_menu_manage_packages";a:1:{s:3:"url";a:1:{i:0;s:9:"subscribe";}}s:40:"subscribe.admin_menu_create_new_packages";a:1:{s:3:"url";a:2:{i:0;s:9:"subscribe";i:1;s:3:"add";}}s:36:"subscribe.admin_menu_purchase_orders";a:1:{s:3:"url";a:2:{i:0;s:9:"subscribe";i:1;s:4:"list";}}s:31:"subscribe.admin_menu_comparison";a:1:{s:3:"url";a:2:{i:0;s:9:"subscribe";i:1;s:7:"compare";}}}]]></menu>
		<phrase_var_name>module_subscribe</phrase_var_name>
		<writable><![CDATA[a:1:{i:0;s:19:"file/pic/subscribe/";}]]></writable>
	</data>
	<menus>
		<menu module_id="subscribe" parent_var_name="" m_connection="subscribe" var_name="menu_my_subscriptions" ordering="80" url_value="subscribe.list" version_id="2.0.0beta4" disallow_access="" module="subscribe" />
		<menu module_id="subscribe" parent_var_name="" m_connection="subscribe" var_name="menu_membership_packages" ordering="81" url_value="subscribe" version_id="2.0.0beta4" disallow_access="" module="subscribe" />
	</menus>
	<settings>
		<setting group="" module_id="subscribe" is_hidden="0" type="boolean" var_name="enable_subscription_packages" phrase_var_name="setting_enable_subscription_packages" ordering="1" version_id="2.0.0beta4">0</setting>
		<setting group="" module_id="subscribe" is_hidden="0" type="boolean" var_name="subscribe_is_required_on_sign_up" phrase_var_name="setting_subscribe_is_required_on_sign_up" ordering="1" version_id="2.0.0beta4">0</setting>
	</settings>
	<hooks>
		<hook module_id="subscribe" hook_type="component" module="subscribe" call_name="subscribe.component_block_message_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="subscribe" hook_type="controller" module="subscribe" call_name="subscribe.component_controller_admincp_index_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="controller" module="subscribe" call_name="subscribe.component_controller_admincp_add_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="controller" module="subscribe" call_name="subscribe.component_controller_view_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="controller" module="subscribe" call_name="subscribe.component_controller_register_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="controller" module="subscribe" call_name="subscribe.component_controller_complete_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="controller" module="subscribe" call_name="subscribe.component_controller_list_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="component" module="subscribe" call_name="subscribe.component_block_upgrade_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="component" module="subscribe" call_name="subscribe.component_block_list_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="service" module="subscribe" call_name="subscribe.service_process__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="service" module="subscribe" call_name="subscribe.service_callback__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="service" module="subscribe" call_name="subscribe.service_subscribe__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="service" module="subscribe" call_name="subscribe.service_purchase_process__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="service" module="subscribe" call_name="subscribe.service_purchase_purchase__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="subscribe" hook_type="controller" module="subscribe" call_name="subscribe.component_controller_admincp_list_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="subscribe" hook_type="service" module="subscribe" call_name="subscribe.service_purchase_process_update_pre_log" added="1286546859" version_id="2.0.7" />
		<hook module_id="subscribe" hook_type="controller" module="subscribe" call_name="subscribe.component_controller_list__1" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="controller" module="subscribe" call_name="subscribe.component_controller_register__1" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_register__1" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_register__2" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_register__3" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_register__4" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_register__5" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_register__6" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_register__7" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_list__1" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_list__2" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_list__3" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_list__4" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_list__5" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_list__6" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_list__7" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_view__1" added="1361175548" version_id="3.5.0rc1" />
		<hook module_id="subscribe" hook_type="template" module="subscribe" call_name="subscribe.template_controller_view__2" added="1361175548" version_id="3.5.0rc1" />
	</hooks>
	<components>
		<component module_id="subscribe" component="ajax" m_connection="" module="subscribe" is_controller="0" is_block="0" is_active="1" />
		<component module_id="subscribe" component="message" m_connection="" module="subscribe" is_controller="0" is_block="1" is_active="1" />
		<component module_id="subscribe" component="index" m_connection="subscribe.index" module="subscribe" is_controller="1" is_block="0" is_active="1" />
	</components>
	<crons>
		<cron module_id="subscribe" type_id="2" every="1"><![CDATA[Phpfox::getService('subscribe.purchase.process')->downgradeExpiredSubscribers();]]></cron>
	</crons>
	<phrases>
		<phrase module_id="subscribe" version_id="2.0.0alpha1" var_name="module_subscribe" added="1219063456">Subscribe</phrase>
		<phrase module_id="subscribe" version_id="2.0.0alpha1" var_name="membership_info" added="1219063471">Membership Info</phrase>
		<phrase module_id="subscribe" version_id="2.0.0alpha1" var_name="your_membership_group_does_not_have_rights" added="1219063496">Your membership group does not have the rights to perform this specific action.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0beta4" var_name="menu_my_subscriptions" added="1244749325">My Subscriptions</phrase>
		<phrase module_id="subscribe" version_id="2.0.0beta4" var_name="menu_membership_packages" added="1244749368">Membership Packages</phrase>
		<phrase module_id="subscribe" version_id="2.0.0beta4" var_name="admin_menu_manage_packages" added="1244803466">Manage Packages</phrase>
		<phrase module_id="subscribe" version_id="2.0.0beta4" var_name="admin_menu_create_new_packages" added="1244803466">Create New Package</phrase>
		<phrase module_id="subscribe" version_id="2.0.0beta4" var_name="setting_enable_subscription_packages" added="1244927162"><![CDATA[<title>Enable Subscription Packages</title><info>Enable Subscription Packages</info>]]></phrase>
		<phrase module_id="subscribe" version_id="2.0.0beta4" var_name="setting_subscribe_is_required_on_sign_up" added="1244930361"><![CDATA[<title>Subscription on registration is required?</title><info>If members should be required to select a subscription package when they register set this to <b>True</b>.</info>]]></phrase>
		<phrase module_id="subscribe" version_id="2.0.0beta4" var_name="admin_menu_purchase_orders" added="1244977924">Purchase Orders</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="unable_to_find_the_purchase_you_are_looking_for" added="1255337249">Unable to find the purchase you are looking for.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="unable_to_find_the_package_you_are_looking_for" added="1255337268">Unable to find the package you are looking for.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="attempting_to_upgrade_to_the_same_user_group_you_are_already_in" added="1255337280">Attempting to upgrade to the same user group you are already in.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="package_successfully_update" added="1255337403">Package successfully update.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="package_successfully_added" added="1255337421">Package successfully added.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="editing_subscription_package" added="1255337438">Editing Subscription Package</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="create_new_subscription_package" added="1255337451">Create New Subscription Package</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="subscription_packages" added="1255337499">Subscription Packages</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="editing" added="1255337507">Editing</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="package_successfully_deleted" added="1255337541">Package successfully deleted.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="purchase_order_successfully_deleted" added="1255337576">Purchase order successfully deleted.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="time" added="1255337589">Time</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="status" added="1255337601">Status</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="price" added="1255337611">Price</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="active" added="1255337622">Active</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="canceled" added="1255337628">Canceled</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="pending_payment" added="1255337641">Pending Payment</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="pending_action" added="1255337657">Pending Action</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="subscription_purchase_orders" added="1255337733">Subscription Purchase Orders</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="purchase_orders" added="1255337752">Purchase Orders</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="controller_is_disabled" added="1255337810">Controller is disabled.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="membership_packages" added="1255337830">Membership Packages</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="subscriptions" added="1255337875">Subscriptions</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="unable_to_find_this_invoice" added="1255337890">Unable to find this invoice.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="select_payment_gateway" added="1255337916">Select Payment Gateway</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="order_purchase_id_title" added="1255337966">Order #{purchase_id} ({title})</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="package_is_required" added="1255338021">Package is required.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="currency_is_required" added="1255338032">Currency is required.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="price_is_required" added="1255338045">Price is required.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="membership_successfully_updated_site_title" added="1255338077">Membership Successfully Updated: {site_title}</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="your_membership_on_site_title_has_successfully_been_updated" added="1255339250"><![CDATA[Your membership on {site_title} has successfully been updated.

To view this subscription, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="membership_pending_site_title" added="1255339290">Membership Pending: {site_title}</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="your_membership_subscription_on_site_title_is_currently_pending" added="1255339333"><![CDATA[Your membership subscription on {site_title} is currently pending.

To view this subscription, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="membership_canceled_site_title" added="1255339371">Membership Canceled: {site_title}</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="your_membership_subscription_on_site_title_has_been_canceled" added="1255339409"><![CDATA[Your membership subscription on {site_title} has been canceled.

To view this subscription, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="not_a_valid_purchase_status" added="1255339444">Not a valid purchase status.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="unable_to_find_the_purchase_you_are_editing" added="1255339452">Unable to find the purchase you are editing.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="unable_to_find_the_purchase_you_are_trying_to_delete" added="1255339465">Unable to find the purchase you are trying to delete.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="purchase_is_not_valid" added="1255339497">Purchase is not valid.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="upgrades" added="1255339522">Upgrades</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="provide_a_message_for_the_package" added="1255339533">Provide a message for the package.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="provide_a_description_for_the_package" added="1255339540">Provide a description for the package.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="provide_a_user_group_on_success" added="1255339549">Provide a user group on success.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="provide_a_user_group_on_cancellation" added="1255339557">Provide a user group on cancellation.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="provide_if_the_package_should_be_added_to_the_registration_form" added="1255339565">Provide if the package should be added to the registration form.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="select_if_the_package_is_active_or_not" added="1255339574">Select if the package is active or not.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="provide_a_price_for_the_package" added="1255339583">Provide a price for the package.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="provide_a_recurring_cost" added="1255339591">Provide a recurring cost.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="provide_a_recurring_period" added="1255339602">Provide a recurring period.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="not_a_valid_request" added="1255339625">Not a valid request.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="unable_to_find_the_package" added="1255339638">Unable to find the package.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="select_upgrade" added="1255339738">Select Upgrade</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="upgrade" added="1255339745">Upgrade</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="purchase_id" added="1255339994">Purchase ID#</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="membership" added="1255339999">Membership</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="your_membership_status" added="1255340062">Your Membership Status</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="no_packages_available" added="1255340068">No packages available.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="recent_orders" added="1255340075">Recent Orders</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="order_purchase_id" added="1255340122">Order #{purchase_id}</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="view_more_orders" added="1255340152">View More Orders</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="your_membership_has_successfully_been_upgraded" added="1255340397">Your membership has successfully been upgraded.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="view_your_subscription" added="1255340403">View Your Subscription</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="subscription_details" added="1255340416">Subscription Details</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="title" added="1255340425">Title</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="description" added="1255340430">Description</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="description_will_be_parsed_as_html" added="1255340439">Description will be parsed as HTML.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="image" added="1255340451">Image</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="change_this_image" added="1255340476">Change this image.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="you_can_upload_a_jpg_gif_or_png_file" added="1255340486">You can upload a JPG, GIF or PNG file.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="user_group_on_success" added="1255340494">User Group on Success</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="select" added="1255340500">Select</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="once_a_user_successfully_purchased_the_package_they_will_be_moved_to_this_user_group" added="1255340509">Once a user successfully purchased the package they will be moved to this user group.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="user_group_on_failure" added="1255340517">User Group on Failure</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="once_a_user_cancels_or_fails_to_pay_their_subscription_they_will_be_moved_to_this_user_group" added="1255340530">Once a user cancels or fails to pay their subscription they will be moved to this user group.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="add_to_registration" added="1255340539">Add to Registration</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="yes" added="1255340545">Yes</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="no" added="1255340553">No</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="is_active" added="1255340560">Is Active</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="subscription_costs" added="1255340580">Subscription Costs</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="recurring" added="1255340592">Recurring</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="recurring_price" added="1255340610">Recurring Price</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="recurring_period" added="1255340617">Recurring Period</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="monthly" added="1255340629">Monthly</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="quarterly" added="1255340634">Quarterly</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="biannualy" added="1255340640">Biannualy</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="annually" added="1255340662">Annually</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="submit" added="1255340669">Submit</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="packages" added="1255340677">Packages</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="manage" added="1255341012">Manage</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="edit_package" added="1255341021">Edit Package</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="delete_package" added="1255341028">Delete Package</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="are_you_sure" added="1255341035">Are you sure?</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="view_active_subscriptions" added="1255341043">View Active Subscriptions</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="view_active_users" added="1255341050">View Active Users</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="deactivate" added="1255341074">Deactivate</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="activate" added="1255341080">Activate</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="no_packages_have_been_added" added="1255341086">No packages have been added.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="create_a_new_package" added="1255341093">Create a New Package</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="could_not_find_any_purchase_orders_with_your_search_criteria" added="1255341103">Could not find any purchase orders with your search criteria.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="filter" added="1255341110">Filter</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="sort_results_by" added="1255341121">Sort Results By</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="update" added="1255341128">Update</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="reset" added="1255341133">Reset</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="orders" added="1255341140">Orders</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="order_id" added="1255341146">Order ID#</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="package" added="1255341152">Package</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="user" added="1255341157">User</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="delete_order" added="1255341196">Delete Order</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="no_purchase_orders" added="1255341273">No purchase orders.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="thank_you_for_your_purchase_your_payment_is_currently_pending_approval" added="1255341300">Thank you for your purchase. Your payment is currently pending approval.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc4" var_name="add_tags" added="1255341331">Add tags.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc5" var_name="free" added="1256752482">Free</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc5" var_name="upgrade_now" added="1256752497">Upgrade Now</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc5" var_name="please_complete_your_purchase" added="1256754783">Please complete your purchase.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc12" var_name="membership_notice" added="1260896693">Membership Notice</phrase>
		<phrase module_id="subscribe" version_id="2.0.0rc12" var_name="the_feature_or_section_you_are_attempting_to_use_is_not_permitted_with_your_membership_level" added="1260896751">The feature or section you are attempting to use is not permitted with your membership level.</phrase>
		<phrase module_id="subscribe" version_id="2.0.0" var_name="on_sign_up_member_info" added="1261241167" />
		<phrase module_id="subscribe" version_id="3.0.0" var_name="manage_subscriptions" added="1322819955">Manage Subscriptions</phrase>
		<phrase module_id="subscribe" version_id="3.0.0" var_name="membership_membership_name" added="1322819984">Membership ({membership_name})</phrase>
		<phrase module_id="subscribe" version_id="3.3.0beta1" var_name="admin_menu_comparison" added="1336488124">Comparison</phrase>
		<phrase module_id="subscribe" version_id="3.3.0beta1" var_name="purchase" added="1337772322">Purchase</phrase>
		<phrase module_id="subscribe" version_id="3.3.0beta1" var_name="add_new_feature" added="1337772427">Add new feature</phrase>
		<phrase module_id="subscribe" version_id="3.3.0beta1" var_name="fee" added="1337772472">Fee</phrase>
		<phrase module_id="subscribe" version_id="3.3.0beta1" var_name="compare_subscription_packages" added="1338302115">Compare Subscription Packages</phrase>
		<phrase module_id="subscribe" version_id="3.3.0beta1" var_name="comparison_page_updated_successfully" added="1338302266">Comparison page updated successfully</phrase>
		<phrase module_id="subscribe" version_id="3.3.0beta1" var_name="compare" added="1338302553">Compare</phrase>
		<phrase module_id="subscribe" version_id="3.3.0beta1" var_name="add_a_feature" added="1338539919">Add a feature...</phrase>
		<phrase module_id="subscribe" version_id="3.3.0" var_name="no_subscription_package_has_been_created_you_need_at_least_one_subscription_package" added="1343032568">No subscription package has been created, you need at least one subscription package.</phrase>
		<phrase module_id="subscribe" version_id="3.3.0" var_name="save" added="1343032757">Save</phrase>
		<phrase module_id="subscribe" version_id="3.3.0" var_name="background_color_for_the_comparison_page" added="1343033051">Background color (for the comparison page)</phrase>
		<phrase module_id="subscribe" version_id="3.3.0" var_name="there_is_nothing_to_compare_at_this_time" added="1343033163">There is nothing to compare at this time.</phrase>
		<phrase module_id="subscribe" version_id="3.3.0" var_name="membership_package_comparison" added="1343033222">Membership Package Comparison</phrase>
		<phrase module_id="subscribe" version_id="3.3.0" var_name="package_info" added="1343033238">Package Info</phrase>
		<phrase module_id="subscribe" version_id="3.5.0beta2" var_name="no_subscriptions_found" added="1359461565">No subscriptions found.</phrase>
	</phrases>
	<tables><![CDATA[a:3:{s:24:"phpfox_subscribe_package";a:3:{s:7:"COLUMNS";a:17:{s:10:"package_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"description";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:4:"cost";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:14:"recurring_cost";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:16:"recurring_period";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"user_group_id";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"fail_user_group";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"image_path";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"server_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"is_registration";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_required";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"show_price";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"total_active";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"background_color";a:4:{i:0;s:8:"VCHAR:50";i:1;s:4:"null";i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:10:"package_id";s:4:"KEYS";a:3:{s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}s:10:"package_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:10:"package_id";i:1;s:9:"is_active";}}s:11:"is_active_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"is_active";i:1;s:15:"is_registration";}}}}s:25:"phpfox_subscribe_purchase";a:3:{s:7:"COLUMNS";a:7:{s:11:"purchase_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"package_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"currency_id";a:4:{i:0;s:6:"CHAR:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"price";a:4:{i:0;s:10:"DECIMAL:14";i:1;s:4:"0.00";i:2;s:0:"";i:3;s:2:"NO";}s:6:"status";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"purchase_id";s:4:"KEYS";a:3:{s:11:"purchase_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:11:"purchase_id";i:1;s:7:"user_id";}}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:9:"user_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"user_id";i:1;s:6:"status";}}}}s:24:"phpfox_subscribe_compare";a:2:{s:7:"COLUMNS";a:3:{s:10:"compare_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:13:"feature_title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:13:"feature_value";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"compare_id";}}]]></tables>
</module>