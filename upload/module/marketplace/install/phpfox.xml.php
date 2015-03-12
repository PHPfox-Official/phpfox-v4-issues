<module>
	<data>
		<module_id>marketplace</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:2:{s:35:"marketplace.admin_menu_add_category";a:1:{s:3:"url";a:2:{i:0;s:11:"marketplace";i:1;s:3:"add";}}s:40:"marketplace.admin_menu_manage_categories";a:1:{s:3:"url";a:1:{i:0;s:11:"marketplace";}}}]]></menu>
		<phrase_var_name>module_marketplace</phrase_var_name>
		<writable><![CDATA[a:1:{i:0;s:21:"file/pic/marketplace/";}]]></writable>
	</data>
	<menus>
		<menu module_id="marketplace" parent_var_name="" m_connection="main" var_name="menu_marketplace" ordering="59" url_value="marketplace" version_id="2.0.0alpha4" disallow_access="" module="marketplace" />
		<menu module_id="marketplace" parent_var_name="" m_connection="marketplace.index" var_name="menu_add_new_listing" ordering="60" url_value="marketplace.add" version_id="2.0.0alpha4" disallow_access="" module="marketplace" />
		<menu module_id="marketplace" parent_var_name="" m_connection="mobile" var_name="menu_marketplace_marketplace_532c28d5412dd75bf975fb951c740a30" ordering="120" url_value="marketplace" version_id="3.1.0rc1" disallow_access="" module="marketplace" mobile_icon="small_marketplace.png" />
	</menus>
	<settings>
		<setting group="time_stamps" module_id="marketplace" is_hidden="0" type="string" var_name="marketplace_view_time_stamp" phrase_var_name="setting_marketplace_view_time_stamp" ordering="1" version_id="2.0.0alpha4">F j, Y</setting>
		<setting group="" module_id="marketplace" is_hidden="0" type="integer" var_name="total_listing_more_from" phrase_var_name="setting_total_listing_more_from" ordering="1" version_id="2.0.0rc1">10</setting>
		<setting group="" module_id="marketplace" is_hidden="0" type="integer" var_name="how_many_sponsored_listings" phrase_var_name="setting_how_many_sponsored_listings" ordering="1" version_id="2.0.5">5</setting>
		<setting group="" module_id="marketplace" is_hidden="0" type="integer" var_name="days_to_expire_listing" phrase_var_name="setting_days_to_expire_listing" ordering="1" version_id="3.5.0beta1">0</setting>
		<setting group="" module_id="marketplace" is_hidden="0" type="integer" var_name="days_to_notify_expire" phrase_var_name="setting_days_to_notify_expire" ordering="1" version_id="3.5.0beta1">0</setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="marketplace.view" module_id="marketplace" component="my" location="1" is_active="1" ordering="3" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="marketplace.index" module_id="marketplace" component="category" location="1" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="marketplace.index" module_id="marketplace" component="sponsored" location="3" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="marketplace.view" module_id="marketplace" component="image" location="1" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title>Listing Photos</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="marketplace.view" module_id="marketplace" component="price" location="3" is_active="1" ordering="5" disallow_access="" can_move="0">
			<title>Listing Price</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="marketplace.index" module_id="marketplace" component="featured" location="3" is_active="1" ordering="5" disallow_access="" can_move="0">
			<title>Featured Listings</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="marketplace.index" module_id="marketplace" component="invite" location="3" is_active="1" ordering="4" disallow_access="" can_move="0">
			<title>Users Invites</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_admincp_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_admincp_add_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_view_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_add_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_profile_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_image_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_photo_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_menu_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_info_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_filter_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_profile_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_list_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_category_category__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_category_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_browse__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_marketplace__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_my_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_category_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_process_add__start" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_process_add__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_sponsor__end" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_invoice_index_clean" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_purchase_clean" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_sponsorhelp_clean" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="marketplace" hook_type="template" module="marketplace" call_name="marketplace.template_default_controller_view_extra_info" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_process_add" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_process_update" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_browse_execute_query" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_browse_execute" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_callback_getnewsfeed_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_category_getforbrowse" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_marketplace_getlisting" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_marketplace_getforedit" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_marketplace_getforprofileblock" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_marketplace_getuserlistings_count" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_marketplace_getuserlistings_query" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_add_process_update_complete" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_add_process" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_index_process_search" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_index_process_filter" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_process_end" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="controller" module="marketplace" call_name="marketplace.component_controller_view_process_end" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_profile_process" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_category_section_name" added="1286546859" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_callback_getfeedredirect" added="1290072896" version_id="2.0.7" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_featured_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_invite_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="marketplace" hook_type="component" module="marketplace" call_name="marketplace.component_block_price_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.component_service_callback_getactivityfeed__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_process_update__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_process_delete__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_process_setdefault__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_process_deleteimage__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="marketplace" hook_type="service" module="marketplace" call_name="marketplace.service_process_approve__1" added="1335951260" version_id="3.2.0" />
	</hooks>
	<components>
		<component module_id="marketplace" component="image" m_connection="" module="marketplace" is_controller="0" is_block="1" is_active="1" />
		<component module_id="marketplace" component="view" m_connection="marketplace.view" module="marketplace" is_controller="1" is_block="0" is_active="1" />
		<component module_id="marketplace" component="menu" m_connection="" module="marketplace" is_controller="0" is_block="1" is_active="1" />
		<component module_id="marketplace" component="filter" m_connection="" module="marketplace" is_controller="0" is_block="1" is_active="1" />
		<component module_id="marketplace" component="index" m_connection="marketplace.index" module="marketplace" is_controller="1" is_block="0" is_active="1" />
		<component module_id="marketplace" component="profile" m_connection="" module="marketplace" is_controller="0" is_block="1" is_active="1" />
		<component module_id="marketplace" component="info" m_connection="" module="marketplace" is_controller="0" is_block="1" is_active="1" />
		<component module_id="marketplace" component="my" m_connection="" module="marketplace" is_controller="0" is_block="1" is_active="1" />
		<component module_id="marketplace" component="category" m_connection="" module="marketplace" is_controller="0" is_block="1" is_active="1" />
		<component module_id="marketplace" component="sponsored" m_connection="" module="marketplace" is_controller="0" is_block="1" is_active="1" />
		<component module_id="marketplace" component="invoice" m_connection="marketplace.invoice" module="marketplace" is_controller="1" is_block="0" is_active="1" />
		<component module_id="marketplace" component="price" m_connection="" module="marketplace" is_controller="0" is_block="1" is_active="1" />
		<component module_id="marketplace" component="featured" m_connection="" module="marketplace" is_controller="0" is_block="1" is_active="1" />
		<component module_id="marketplace" component="profile" m_connection="marketplace.profile" module="marketplace" is_controller="1" is_block="0" is_active="1" />
		<component module_id="marketplace" component="invite" m_connection="" module="marketplace" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="marketplace" version_id="2.0.0alpha4" var_name="module_marketplace" added="1239387125">Marketplace</phrase>
		<phrase module_id="marketplace" version_id="2.0.0alpha4" var_name="menu_marketplace" added="1239387152">Marketplace</phrase>
		<phrase module_id="marketplace" version_id="2.0.0alpha4" var_name="setting_marketplace_view_time_stamp" added="1239457199"><![CDATA[<title>Marketplace View Time Stamp</title><info>Marketplace View Time Stamp</info>]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0alpha4" var_name="user_setting_can_post_comment_on_listing" added="1239459827">Can post a comment on marketplace listing?</phrase>
		<phrase module_id="marketplace" version_id="2.0.0alpha4" var_name="user_setting_can_edit_own_listing" added="1239463634">Can edit own marketplace listing?</phrase>
		<phrase module_id="marketplace" version_id="2.0.0alpha4" var_name="user_setting_can_edit_other_listing" added="1239463695">Can edit marketplace listings added by other users?</phrase>
		<phrase module_id="marketplace" version_id="2.0.0alpha4" var_name="menu_add_new_listing" added="1239472943">Add New Listing</phrase>
		<phrase module_id="marketplace" version_id="2.0.0alpha4" var_name="user_setting_can_delete_own_listing" added="1239541511">Can delete own marketplace listing?</phrase>
		<phrase module_id="marketplace" version_id="2.0.0alpha4" var_name="user_setting_can_delete_other_listings" added="1239541555">Can delete marketplace listings added by other users?</phrase>
		<phrase module_id="marketplace" version_id="2.0.0alpha4" var_name="admin_menu_add_category" added="1239552185">Add Category</phrase>
		<phrase module_id="marketplace" version_id="2.0.0alpha4" var_name="admin_menu_manage_categories" added="1239552185">Manage Categories</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc1" var_name="user_setting_max_upload_size_listing" added="1250258666"><![CDATA[Max file size for photos upload in kilobits (kb).
(1000 kb = 1 mb)
For unlimited add "0" without quotes.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc1" var_name="setting_total_listing_more_from" added="1250340296"><![CDATA[<title>Total "More From" Listings to Display</title><info>Define how many listings to display within the "More From" block when viewing a listing.</info>]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc1" var_name="user_setting_can_feature_listings" added="1250355847">Can feature listings?</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc1" var_name="user_setting_listing_approve" added="1250357077">Enable if listings should be approved first before they are displayed publicly.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc1" var_name="user_setting_can_approve_listings" added="1250357731">Can approve marketplace listings?</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="categories" added="1255076189">Categories</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="sub_categories" added="1255076202">Sub-Categories</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="browse_filter" added="1255076215">Browse Filter</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="price" added="1255076233">Price</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="free" added="1255076244">Free</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="invites" added="1255076258">Invites</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="visited" added="1255076267">Visited</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="not_responded" added="1255076279">Not Responded</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="more_from" added="1255076293">More From</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="view_more" added="1255076304">View More</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="marketplace_listings" added="1255076319">Marketplace Listings</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="category_successfully_updated" added="1255076338">Category successfully updated.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="category_successfully_added" added="1255076349">Category successfully added.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="edit_a_category" added="1255076358">Edit a Category</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="create_a_new_category" added="1255076369">Create a New Category</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="category_order_successfully_updated" added="1255076387">Category order successfully updated.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="category_successfully_deleted" added="1255076397">Category successfully deleted.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="manage_categories" added="1255076405">Manage Categories</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="provide_a_name_for_this_listing" added="1255076432">Provide a name for this listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="provide_a_location_for_this_listing" added="1255076442">Provide a location for this listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="listing_successfully_updated" added="1255076452">Listing successfully updated.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="successfully_uploaded_images_for_this_listing" added="1255076461">Successfully uploaded images for this listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="successfully_invited_users_for_this_listing" added="1255076470">Successfully invited users for this listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="successfully_updated_this_listing" added="1255076481">Successfully updated this listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="listing_successfully_added" added="1255076490">Listing successfully added.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="edit_a_marketplace_listing" added="1255076501">Edit a Marketplace Listing</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="edit_a_listing" added="1255076526">Edit a Listing</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="create_a_marketplace_listing" added="1255076534">Create a Marketplace Listing</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="create_a_listing" added="1255076542">Create a Listing</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="marketplace" added="1255076548">Marketplace</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="listing_successfully_deleted" added="1255076562">Listing successfully deleted.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="date_added" added="1255076575">Date Added</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="name" added="1255076582">Name</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="recent_listings" added="1255076608">Recent Listings</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="my_listings" added="1255076616">My Listings</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="featured" added="1255076623">Featured</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="invitations" added="1255076629">Invitations</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="pending" added="1255076637">Pending</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="the_listing_you_are_looking_for_either_does_not_exist_or_has_been_removed" added="1255076663">The listing you are looking for either does not exist or has been removed.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="select" added="1255076724">Select</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="select_a_sub_category" added="1255076733">Select a Sub-Category</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="provide_a_category_name" added="1255076745">Provide a category name.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="invalid_callback_on_marketplace_listing" added="1255076781">Invalid callback on marketplace listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title" added="1255076800">{user_name} left you a comment on {site_title}.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_your_marketplace_listing" added="1255076862"><![CDATA[{user_name} left you a comment on your Marketplace listing.

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_their_own_a_href_title_link_listin" added="1255077003"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on their own <a href="{title_link}">listing</a>.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_your_a_href_title_link_listing_a" added="1255077073"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on your <a href="{title_link}">listing</a>.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_a_href_item_user_link_item_user_n" added="1255077120"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on <a href="{item_user_link}">{item_user_name}'s</a> <a href="{title_link}">listing</a>.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="a_href_user_link_owner_full_name_a_added_a_new_listing_a_href_title_link_title_a" added="1255077808"><![CDATA[<a href="{user_link}">{owner_full_name}</a> added a new listing "<a href="{title_link}">{title}</a>".]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="your_listing_title_has_been_approved" added="1255077901"><![CDATA[Your listing "{title}" has been approved.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="listings" added="1255077920">Listings</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="user_link_invited_you_to_a_marketplace_listing" added="1255077951">{user_link} invited you to a marketplace listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="no_listing_invites" added="1255077972">No listing invites.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="marketplace_invites" added="1255078002">Marketplace Invites</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="marketplace_text" added="1255078012">Marketplace Text</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="full_name_invited_you_to_view_the_marketplace_listing_title" added="1255078462"><![CDATA[{full_name} invited you to view the marketplace listing "{title}".

To check out this listing, follow the link below:
<a href="{link}">{link}</a>"]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="full_name_added_the_following_personal_message" added="1255078552">{full_name} added the following personal message</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="full_name_invited_you_to_view_the_listing_title" added="1255078586"><![CDATA[{full_name} invited you to view the listing "{title}".]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="unable_to_find_the_listing_you_want_to_delete" added="1255078649">Unable to find the listing you want to delete.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="you_do_not_have_sufficient_permission_to_delete_this_listing" added="1255078659">You do not have sufficient permission to delete this listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="you_do_not_have_sufficient_permission_to_modify_this_listing" added="1255078673">You do not have sufficient permission to modify this listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="unable_to_find_the_listing_you_want_to_approve" added="1255078695">Unable to find the listing you want to approve.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="your_listing_has_been_approved_on_site_title" added="1255078720">Your listing has been approved on {site_title}.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="your_listing_has_been_approved_on_site_title_message" added="1255078774"><![CDATA[Your listing has been approved on {site_title}.

To view this listing, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="provide_a_category_this_listing_will_belong_to" added="1255078805">Provide a category this listing will belong to.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="are_you_sure_this_will_delete_all_listings_that_belong_to_this_category_and_cannot_be_undone" added="1255078851">Are you sure? This will delete all listings that belong to this category and cannot be undone.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="posted_on_time_stamp" added="1255080265">Posted on {time_stamp}.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="the_file_size_limit_is_file_size_if_your_upload_does_not_work_try_uploading_a_smaller_picture" added="1255080312">The file size limit is {file_size}. If your upload does not work, try uploading a smaller picture.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="click_here_to_approve_listings" added="1255080631">Click here to approve listings.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="posted_time_samp_in_country_iso" added="1255080684">Posted {time_samp} in {country_iso}.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="posted_time_stamp_by_user_info_in_country_iso" added="1255080740">Posted {time_stamp} by {user_info}.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="this_song_has_been_added_to_your_profile" added="1255081050">This song has been added to your profile.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="this_song_has_been_removed_from_your_profile" added="1255081059">This song has been removed from your profile.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc4" var_name="basic_info" added="1255081085">Basic Info</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="keywords" added="1254402580">Keywords</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="location" added="1254402616">Location</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="city" added="1254402631">City</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="zip_postal_code" added="1254402651">Zip/Postal Code</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="sort" added="1254402662">Sort</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="submit" added="1254402705">Submit</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="reset" added="1254402715">Reset</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="photos" added="1254402743">Photos</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="summary" added="1254402845">Summary</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="posted_on" added="1254402857">Posted On</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="posted_by" added="1254402869">Posted By</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="user_rating" added="1254402880">User Rating</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="user_activity" added="1254402889">User Activity</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="no_visits" added="1254402947">No visits.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="no_results" added="1254402982">No results.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="add_new_listing" added="1254403011">Add New Listing</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="edit_listing" added="1254403026">Edit Listing</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="manage_photos" added="1254403038">Manage Photos</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="send_invitations" added="1254403047">Send Invitations</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="manage_invites" added="1254403080">Manage Invites</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="contact" added="1254403096">Contact</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="report_this_listing" added="1254403154">Report this Listing</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="report" added="1254403163">Report</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="delete_listing" added="1254403180">Delete Listing</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="delete_this_image_for_the_listing" added="1254403406">Delete this image for the listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="are_you_sure" added="1254403483">Are you sure?</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="click_to_set_as_default_image" added="1254403502">Click to set as default image.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="no_listings_added_yet" added="1254403561">No listings added yet.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="add_a_listing" added="1254403593">Add a Listing</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="marketplace_category_details" added="1254403721">Marketplace Category Details</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="parent_category" added="1254403743">Parent Category</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="edit" added="1254403812">Edit</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="delete" added="1254403821">Delete</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="update_order" added="1254403847">Update Order</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="view_this_listing" added="1254403868">View This Listing</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="skip_amp_view_this_listing" added="1254403899"><![CDATA[Skip &amp; View This Listing]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="step_1" added="1254403972">Step 1</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="listing_details" added="1254403981">Listing Details</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="step_2" added="1254403992">Step 2</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="step_3" added="1254404014">Step 3</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="invite" added="1254404022">Invite</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="title" added="1254404178">Title</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="short_description" added="1254404192">Short Description</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="full_description" added="1254404207">Full Description</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="usd" added="1254404241">USD</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="select_image_s" added="1254404309">Select Image(s)</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="you_can_upload_a_jpg_gif_or_png_file" added="1254404325">You can upload a JPG, GIF or PNG file.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="upload" added="1254404368">Upload</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="invite_friends" added="1254404380">Invite Friends</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="invite_people_via_email" added="1254404393">Invite People via Email</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="separate_multiple_emails_with_a_comma" added="1254404408">Separate multiple emails with a comma.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="add_a_personal_message" added="1254404419">Add a Personal Message</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="new_guest_list" added="1254404448">New Guest List</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="unable_to_find_what_you_are_looking_for" added="1254404484">Unable to find what you are looking for.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="no_listings_have_been_added" added="1254404494">No listings have been added.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="be_the_first_to_add_a_listing" added="1254404504">Be the first to add a listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="there_is_one_listing_that_is_pending_approval" added="1254404516">There is one listing that is pending approval.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="there_are_total_listings_that_are_pending_approval" added="1254404607">There are {total} listings that are pending approval.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="approve_this_listing" added="1254404827">Approve this listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="approve" added="1254404842">Approve</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="feature_this_listing" added="1254404858">Feature this listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="feature" added="1254404873">Feature</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="un_feature_this_listing" added="1254404888">Un-Feature this listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="unfeature" added="1254404901">Unfeature</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="listing_is_pending_approval" added="1254404992">Listing is pending approval.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="successfully_deleted_listing" added="1254405051">Successfully deleted listing.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc3" var_name="rating" added="1254405133">Rating</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc8" var_name="category" added="1258986746">Category</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc8" var_name="update" added="1258986799">Update</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc8" var_name="cancel" added="1258986813">Cancel</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc10" var_name="you_have_not_added_any_listings_yet" added="1259610367">You have not added any listings yet.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc10" var_name="no_listings_have_been_featured" added="1259610438">No listings have been featured.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc10" var_name="you_have_not_received_any_invites" added="1259610865">You have not received any invites.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc10" var_name="no_listings_pending_approval" added="1259610971">No listings pending approval.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc11" var_name="this_category_name_cannot_be_used_due_to_that_there_is_already_another_category_with_the_same_name_being_used" added="1260237609">This category name cannot be used due to that there is already another category with the same name being used.</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc11" var_name="user_setting_can_access_marketplace" added="1260286697">Can browse and view listings?</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc11" var_name="user_setting_can_create_listing" added="1260329360">Can create a listing?</phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_your_a_href_link_listing_a" added="1260470252"><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">listing</a>.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_their_own_a_href_link_listing_a" added="1260470283"><![CDATA[<a href="{user_link}">{full_name}</a> likes {gender} own <a href="{link}">listing</a>.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_likes_a_href_view_user_link_view_full_name_a_s_a_href_link_listing_a" added="1260470300"><![CDATA[<a href="{user_link}">{full_name}</a> likes <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">listing</a>.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="sponsored_listing" added="1270732646">Sponsored Listings</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="setting_how_many_sponsored_listings" added="1270733482"><![CDATA[<title>How Many Sponsor Listings To Show</title><info>This setting tells how many sponsored listings will be shown on the sponsor block. Default is 5.</info>]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="user_setting_can_sponsor_listing" added="1270806106">Can members of this user group mark a listing in the marketplace as sponsor?</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="sponsor_this_listing" added="1270806257">Sponsor</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="unsponsor_this_listing" added="1270806408">Unsponsor</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="listing_successfully_sponsored" added="1270807171">Listing successfully sponsored</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="listing_successfully_un_sponsored" added="1270807213">Listing successfully unsponsored</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="encourage_sponsor" added="1270810350">Sponsor your listings</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="sponsor_help" added="1270810696"><![CDATA[To sponsor a listing please click on "Sponsor" next to the item]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="user_setting_can_purchase_sponsor" added="1270811006">Can members of this user group purchase a sponsored ad space?</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="user_setting_marketplace_sponsor_price" added="1271938987">How much is the sponsor space worth for marketplace listings?
This works in a CPM basis.</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="sponsor_error_not_found" added="1271944391">The listing you are trying to sponsor cannot be found.</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="sponsor_title" added="1271944423">Marketplace Listing: {sListingTitle}</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="sponsor_paypal_message" added="1271944508">Payment for the sponsor space of marketplace listing: {sListingTitle}</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="user_setting_auto_publish_sponsored_item" added="1272007636">After the user has purchased a sponsored space, should the listing be published right away?
If set to false, the admin will have to approve each new purchased sponsored listing space before it is shown in the site.</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="buy_it_now" added="1272015921">Buy It Now</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="enable_instant_payment" added="1272015950">Enable Instant Payment</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="user_setting_can_sell_items_on_marketplace" added="1272016020">Can sell items on the marketplace?</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="unable_to_find_the_listing_you_are_looking_for" added="1272016275">Unable to find the listing you are looking for.</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="sold" added="1272277592">Sold</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="this_listing_has_already_been_marked_as_sold" added="1272278384"><![CDATA[This listing has already been marked as "sold".]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="notice_this_listing_is_marked_as_sold" added="1272278515"><![CDATA[Notice: This listing is marked as "Sold".]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="auto_sold" added="1272278527">Auto-Sold</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="if_you_enable_this_option_buyers_can_make_a_payment_to_one_of_the_payment_gateways_you_have_on_file_with_us_to_manage_your_payment_gateways_go_a_href_link_here_a" added="1272278556"><![CDATA[If you enable this option, buyers can make a payment to one of the payment gateways you have on file with us. To manage your payment gateways go <a href="{link}">here</a>.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="if_this_is_enabled_and_once_a_successful_purchase_of_this_item_is_made" added="1272278641"><![CDATA[If this is enabled and once a successful purchase of this item is made it will automatically close this item and mark it as "Sold".]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="closed_item_sold" added="1272278655">Closed (Item Sold)</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="enable_this_option_if_this_item_is_sold_and_this_listing_should_be_closed" added="1272278665"><![CDATA[Enable this option if this item is "sold" and this listing should be closed.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="unable_to_purchase_this_item" added="1272278822">Unable to purchase this item.</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="review_and_confirm_purchase" added="1272278843">Review and Confirm Purchase</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="item_you_re_buying" added="1272278863"><![CDATA[Item you're buying]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="by_clicking_on_the_button_below_you_commit_to_buy_this_item_from_the_seller" added="1272278880">By clicking on the button below, you commit to buy this item from the seller.</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="commit_to_buy" added="1272278890">Commit to Buy</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="payment_methods" added="1272278912">Payment Methods</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="item_sold_title" added="1272279705">Item Sold: {title}</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="full_name_has_purchased_an_item_of_yours_on_site_name" added="1272279966"><![CDATA[{full_name} has purchased one of your items on {site_name}.

Item Name: {title}
Item Link: <a href="{link}">{link}</a>
Users Name: {full_name}
Users Profile: <a href="{user_link}">{user_link}</a>
Price: {price}]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="purchased_by" added="1272462303">Purchased by</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="you_haven_t_made_any_purchases_yet" added="1272462603"><![CDATA[You haven't made any purchases yet.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="you_haven_t_sold_any_items_yet" added="1272462628"><![CDATA[You haven't sold any items yet.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="purchased" added="1272462658">Purchased</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="you_do_not_have_any_invoices" added="1272550735">You do not have any invoices.</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="id" added="1272550744">ID</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="status" added="1272550751">Status</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="date" added="1272550762">Date</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="pay_now" added="1272550771">Pay Now</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="marketplace_invoices" added="1272550785">Marketplace Invoices</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="invoices" added="1272550799">Invoices</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="paid" added="1272550810">Paid</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="cancelled" added="1272550817">Cancelled</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="pending_payment" added="1272550825">Pending Payment</phrase>
		<phrase module_id="marketplace" version_id="2.0.5dev1" var_name="user_setting_can_sponsor_marketplace" added="1274299652">Can sponsor a marketplace listing?</phrase>
		<phrase module_id="marketplace" version_id="2.0.5dev2" var_name="user_setting_flood_control_marketplace" added="1275108549"><![CDATA[How many minutes should a user wait before they can create another marketplace listing?

Note: Setting it to "0" (without quotes) is default and users will not have to wait.]]></phrase>
		<phrase module_id="marketplace" version_id="2.0.5dev2" var_name="you_are_creating_a_listing_a_little_too_soon" added="1275108611">You are creating a listing a little too soon.</phrase>
		<phrase module_id="marketplace" version_id="2.0.5" var_name="menu_marketplace_manage_invoices_ad23f7587e12dc025eefdfbc37ca854a" added="1272550993">Manage Invoices</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta1" var_name="user_setting_points_marketplace" added="1304598138">How many activity points should the user get when adding a new listing?</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="listing_successfully_featured" added="1319183858">Listing successfully featured</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="listing_successfully_un_featured" added="1319183873">Listing successfully un-featured</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="un_feature" added="1319183880">Un-Feature</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="listing_has_been_approved" added="1319183893">Listing has been approved.</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="listing_approved" added="1319183904">Listing Approved</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="search_listings" added="1319456698">Search Listings...</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="latest" added="1319456704">Latest</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="most_viewed" added="1319456716">Most Viewed</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="most_liked" added="1319456724">Most Liked</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="most_discussed" added="1319456733">Most Discussed</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="anywhere" added="1319456742">Anywhere</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="all_listings" added="1319456760">All Listings</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="listing_invites" added="1319456779">Listing Invites</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="friends_listings" added="1319456933"><![CDATA[Friends' Listings]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="pending_listings" added="1319456941">Pending Listings</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="full_name_s_listings" added="1319456961"><![CDATA[{full_name}'s Listings]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="no_marketplace_listings_found" added="1319457071">No marketplace listings found.</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="pending_approval" added="1319457090">Pending Approval</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="sponsored" added="1319457102">Sponsored</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="actions" added="1319457110">Actions</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="see_more" added="1319457128">See More</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="what_are_you_selling" added="1319457178">What are you selling?</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="description" added="1319457186">Description</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="add_city_zip" added="1319457214">Add city/zip</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="listing_privacy" added="1319457259">Listing Privacy</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="control_who_can_see_this_listing" added="1319457267">Control who can see this listing.</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="comment_privacy" added="1319457274">Comment Privacy</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="control_who_can_comment_on_this_listing" added="1319457285">Control who can comment on this listing.</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="successfully_uploaded_images" added="1319457355">Successfully uploaded images.</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="successfully_invited_users" added="1319457363">Successfully invited users.</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="editing_listing" added="1319457416">Editing Listing</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="align_left" added="1319463767">Align Left</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="report_this_listing_lowercase" added="1319464027">Report this listing</phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="full_name_liked_your_listing_title" added="1319530743"><![CDATA[{full_name} liked your listing "{title}"]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0beta5" var_name="full_name_liked_your_listing_message" added="1319530825"><![CDATA[{full_name} liked your listing "<a href="{link}">{title}</a>"
To view this listing follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0rc1" var_name="loading" added="1320324900">Loading...</phrase>
		<phrase module_id="marketplace" version_id="3.0.0rc1" var_name="close" added="1320324906">Close</phrase>
		<phrase module_id="marketplace" version_id="3.0.0rc1" var_name="more_from_seller" added="1320324937">More From Seller</phrase>
		<phrase module_id="marketplace" version_id="3.0.0rc2" var_name="users_wants_you_to_check_out_the_listing_title" added="1321347798"><![CDATA[{users} wants you to check out the listing "{title}"]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0rc2" var_name="contact_seller" added="1321350297">Contact Seller</phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="full_name_commented_on_your_listing_title" added="1322466110"><![CDATA[{full_name} commented on your listing "{title}".]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="featured_listings" added="1322467168">Featured Listings</phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="posted_a_comment_on_gender_listing_a_href_link_title_a" added="1322565737"><![CDATA[posted a comment on {gender} listing <a href="{link}">{title}</a>]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="posted_a_comment_on_user_name_s_listing_a_href_link_title_a" added="1322565852"><![CDATA[posted a comment on {user_name}'s listing "<a href="{link}"> {title} </a>"]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="full_name_commented_on_your_listing_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322566098"><![CDATA[{full_name} commented on your listing "<a href="{link}">{title}</a>". To see the comment thread, follow the link below: <a href="{link}"> {link} </a>]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="full_name_commented_on_gender_listing" added="1322566215">{full_name} commented on {gender} listing.</phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_listing" added="1322566288"><![CDATA[{full_name} commented on {other_full_name}'s listing.]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="full_name_commented_on_gender_listing_a_href_link_title_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322566654"><![CDATA[{full_name} commented on {gender} listing "<a href="{link}">{title}</a>". 
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="full_name_commented_on_other_full_name" added="1322566833"><![CDATA[{full_name} commented on {other_full_name}'s listing "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="a_href_link_on_name_s_listing_a" added="1322567030"><![CDATA[<a href="{link}">On {name}'s listing.</a>]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="user_name_liked_gender_own_listing_title" added="1322567423"><![CDATA[{user_name} liked {gender} own listing "{title}"]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="user_names_liked_your_listing_title" added="1322567624"><![CDATA[{user_names} liked your listing "{title}"]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="user_names_liked_span_class_drop_data_user_full_name_s_span_listing_title" added="1322567869"><![CDATA[{user_names} liked <span class="drop_data_user">{full_name}'s</span> listing "{title}"]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="user_names_commented_on_gender_listing_title" added="1322568005"><![CDATA[{user_names} commented on {gender} listing "{title}"]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="user_names_commented_on_your_listing_title" added="1322568178"><![CDATA[{user_names} commented on your listing "{title}"]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="user_names_commented_on_span_class_drop_data_user_full_name_s_span_listing_title" added="1322568344"><![CDATA[{user_names} commented on <span class="drop_data_user">{full_name}'s</span> listing "{title}"]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="your_marketplace_listing_title_has_been_approved" added="1322568476"><![CDATA[Your marketplace listing "{title}" has been approved]]></phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="listing_s_successfully_approved" added="1322739750">Listing(s) successfully approved.</phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="listing_s_successfully_deleted" added="1322739765">Listing(s) successfully deleted.</phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="listing_s_successfully_featured" added="1322739778">Listing(s) successfully featured.</phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="listing_s_successfully_un_featured" added="1322739794">Listing(s) successfully un-featured.</phrase>
		<phrase module_id="marketplace" version_id="3.0.0" var_name="user_setting_total_photo_upload_limit" added="1323674894">Control how many photos a user can upload to a marketplace listing each time.</phrase>
		<phrase module_id="marketplace" version_id="3.1.0beta1" var_name="user_name_tagged_you_in_a_marketplace_listing" added="1331221452">{user_name} tagged you in a marketplace listing</phrase>
		<phrase module_id="marketplace" version_id="3.1.0beta1" var_name="html_not_allowed" added="1331555316">HTML Not Allowed</phrase>
		<phrase module_id="marketplace" version_id="3.1.0rc1" var_name="menu_marketplace_marketplace_532c28d5412dd75bf975fb951c740a30" added="1332257838">Marketplace</phrase>
		<phrase module_id="marketplace" version_id="3.3.0beta1" var_name="visted" added="1339155389">Visited</phrase>
		<phrase module_id="marketplace" version_id="3.3.0beta1" var_name="invited" added="1339155396">Invited</phrase>
		<phrase module_id="marketplace" version_id="3.5.0beta1" var_name="item_phrase" added="1352732222">marketplace listing</phrase>
		<phrase module_id="marketplace" version_id="3.5.0beta1" var_name="setting_days_to_expire_listing" added="1352993376"><![CDATA[<title>Days to Expire</title><info>If you want marketplace listings to expire you can enter the number of days here.

If you enter 0 days listings will not expire.</info>]]></phrase>
		<phrase module_id="marketplace" version_id="3.5.0beta1" var_name="expired" added="1353055149">Expired</phrase>
		<phrase module_id="marketplace" version_id="3.5.0beta1" var_name="user_setting_can_view_expired" added="1353058986"><![CDATA[Can members of this user group view the section "Expired" in the marketplace?]]></phrase>
		<phrase module_id="marketplace" version_id="3.5.0beta1" var_name="listing_expired_and_not_available_main_section" added="1353062219">This listing has expired and is no longer available from the main marketplace section.</phrase>
		<phrase module_id="marketplace" version_id="3.5.0beta1" var_name="setting_days_to_notify_expire" added="1353317991"><![CDATA[<title>Days to Notify Expiring Listing</title><info>When you allow listings to expire you can also set a notification to be sent automatically to the owner of the listing, you can define here how many days in advanced to notify them.

If you set this to 0 no email will be sent to the owner.</info>]]></phrase>
		<phrase module_id="marketplace" version_id="3.5.0beta1" var_name="listing_expiring_subject" added="1353321414"><![CDATA[Your listing "{title}" is soon to expire.]]></phrase>
		<phrase module_id="marketplace" version_id="3.5.0beta1" var_name="listing_expiring_message" added="1353322352"><![CDATA[Your listing <a href="{link}">"{title}"</a> at {site_name} will expire in {days} days.]]></phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="1" user="1" guest="0" staff="1" module="marketplace" ordering="0">can_post_comment_on_listing</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="1" user="1" guest="0" staff="1" module="marketplace" ordering="0">can_edit_own_listing</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="1" user="0" guest="0" staff="1" module="marketplace" ordering="0">can_edit_other_listing</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="1" user="1" guest="0" staff="1" module="marketplace" ordering="0">can_delete_own_listing</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="1" user="0" guest="0" staff="1" module="marketplace" ordering="0">can_delete_other_listings</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="integer" admin="500" user="500" guest="500" staff="500" module="marketplace" ordering="0">max_upload_size_listing</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="1" user="0" guest="0" staff="1" module="marketplace" ordering="0">can_feature_listings</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="0" user="0" guest="0" staff="0" module="marketplace" ordering="0">listing_approve</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="1" user="0" guest="0" staff="1" module="marketplace" ordering="0">can_approve_listings</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="1" user="1" guest="1" staff="1" module="marketplace" ordering="0">can_access_marketplace</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="1" user="1" guest="0" staff="1" module="marketplace" ordering="0">can_create_listing</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="false" user="false" guest="false" staff="false" module="marketplace" ordering="0">can_sponsor_marketplace</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="false" user="false" guest="false" staff="false" module="marketplace" ordering="0">can_purchase_sponsor</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="string" admin="null" user="null" guest="null" staff="null" module="marketplace" ordering="0">marketplace_sponsor_price</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="true" user="false" guest="false" staff="false" module="marketplace" ordering="0">auto_publish_sponsored_item</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="0" user="0" guest="0" staff="0" module="marketplace" ordering="0">can_sell_items_on_marketplace</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="integer" admin="0" user="0" guest="0" staff="0" module="marketplace" ordering="0">flood_control_marketplace</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="integer" admin="1" user="1" guest="0" staff="1" module="marketplace" ordering="0">points_marketplace</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="integer" admin="6" user="6" guest="6" staff="6" module="marketplace" ordering="0">total_photo_upload_limit</setting>
		<setting is_admin_setting="0" module_id="marketplace" type="boolean" admin="true" user="false" guest="false" staff="false" module="marketplace" ordering="0">can_view_expired</setting>
	</user_group_settings>
	<tables><![CDATA[a:7:{s:18:"phpfox_marketplace";a:3:{s:7:"COLUMNS";a:26:{s:10:"listing_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"group_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_featured";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_sponsor";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"currency_id";a:4:{i:0;s:6:"CHAR:3";i:1;s:3:"USD";i:2;s:0:"";i:3;s:2:"NO";}s:5:"price";a:4:{i:0;s:10:"DECIMAL:14";i:1;s:4:"0.00";i:2;s:0:"";i:3;s:2:"NO";}s:11:"country_iso";a:4:{i:0;s:6:"CHAR:2";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:16:"country_child_id";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"postal_code";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:4:"city";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"image_path";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"server_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"is_sell";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_closed";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"auto_sell";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:16:"mini_description";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"is_notified";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"listing_id";s:4:"KEYS";a:5:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"privacy";}}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:11:"is_featured";}}s:10:"listing_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:10:"listing_id";i:1;s:7:"view_id";}}s:11:"is_notified";a:2:{i:0;s:5:"INDEX";i:1;s:11:"is_notified";}}}s:27:"phpfox_marketplace_category";a:3:{s:7:"COLUMNS";a:8:{s:11:"category_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"parent_id";a:4:{i:0;s:4:"UINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"name_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"used";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"category_id";s:4:"KEYS";a:2:{s:9:"parent_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"parent_id";i:1;s:9:"is_active";}}s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:9:"is_active";i:1;s:8:"name_url";}}}}s:32:"phpfox_marketplace_category_data";a:2:{s:7:"COLUMNS";a:2:{s:10:"listing_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"category_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:11:"category_id";a:2:{i:0;s:5:"INDEX";i:1;s:11:"category_id";}s:10:"listing_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"listing_id";}}}s:24:"phpfox_marketplace_image";a:3:{s:7:"COLUMNS";a:5:{s:8:"image_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"listing_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"image_path";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"server_id";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"image_id";s:4:"KEYS";a:1:{s:10:"listing_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"listing_id";}}}s:25:"phpfox_marketplace_invite";a:3:{s:7:"COLUMNS";a:8:{s:9:"invite_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"listing_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"visited_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"invited_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"invited_email";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"invite_id";s:4:"KEYS";a:6:{s:10:"listing_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"listing_id";}s:12:"listing_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:10:"listing_id";i:1;s:15:"invited_user_id";}}s:15:"invited_user_id";a:2:{i:0;s:5:"INDEX";i:1;s:15:"invited_user_id";}s:12:"listing_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:10:"listing_id";i:1;s:10:"visited_id";}}s:12:"listing_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:10:"listing_id";i:1;s:10:"visited_id";i:2;s:15:"invited_user_id";}}s:10:"visited_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:10:"visited_id";i:1;s:15:"invited_user_id";}}}}s:26:"phpfox_marketplace_invoice";a:3:{s:7:"COLUMNS";a:8:{s:10:"invoice_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:10:"listing_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"currency_id";a:4:{i:0;s:6:"CHAR:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"price";a:4:{i:0;s:10:"DECIMAL:14";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"status";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:15:"time_stamp_paid";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:10:"invoice_id";s:4:"KEYS";a:4:{s:10:"listing_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"listing_id";}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:12:"listing_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:10:"listing_id";i:1;s:6:"status";}}s:12:"listing_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:10:"listing_id";i:1;s:7:"user_id";i:2;s:6:"status";}}}}s:23:"phpfox_marketplace_text";a:2:{s:7:"COLUMNS";a:3:{s:10:"listing_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"description";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:18:"description_parsed";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:10:"listing_id";a:2:{i:0;s:5:"INDEX";i:1;s:10:"listing_id";}}}}]]></tables>
	<install><![CDATA[
		$aCategories = array(
			'Community',
			'Houses',
			'Jobs',
			'Pets',
			'Rentals',
			'Services',
			'Stuff',
			'Tickets',
			'Vehicle'
		);		
		
		$iCategoryOrder = 0;
		foreach ($aCategories as $sCategory)
		{
			$iCategoryOrder++;
			$iCategoryId = $this->database()->insert(Phpfox::getT('marketplace_category'), array(					
					'name' => $sCategory,
					'is_active' => 1,
					'ordering' => $iCategoryOrder			
				)
			);
		}
	]]></install>
</module>