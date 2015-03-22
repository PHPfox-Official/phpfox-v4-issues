<module>
	<data>
		<module_id>favorite</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_favorite</phrase_var_name>
		<writable />
	</data>
	<menus>
		<menu module_id="favorite" parent_var_name="" m_connection="profile" var_name="menu_favorites" ordering="79" url_value="profile.favorite" version_id="2.0.0beta3" disallow_access="" module="favorite" />
	</menus>
	<hooks>
		<hook module_id="favorite" hook_type="controller" module="favorite" call_name="favorite.component_controller_index_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="favorite" hook_type="controller" module="favorite" call_name="favorite.component_controller_profile_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="favorite" hook_type="component" module="favorite" call_name="favorite.component_block_footer_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="favorite" hook_type="component" module="favorite" call_name="favorite.component_block_entry_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="favorite" hook_type="component" module="favorite" call_name="favorite.component_block_add_clean" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="favorite" hook_type="service" module="favorite" call_name="favorite.service_favorite__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="favorite" hook_type="service" module="favorite" call_name="favorite.service_process__call" added="1244973584" version_id="2.0.0beta4" />
		<hook module_id="favorite" hook_type="service" module="favorite" call_name="favorite.service_callback__call" added="1244973584" version_id="2.0.0beta4" />
	</hooks>
	<phrases>
		<phrase module_id="favorite" version_id="2.0.0beta3" var_name="module_favorite" added="1243243396">Favorites</phrase>
		<phrase module_id="favorite" version_id="2.0.0beta3" var_name="menu_favorites" added="1243248339">Favorites</phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="full_name_has_closed_their_favorites_section" added="1254464684"><![CDATA[<a href="{user_link}">{full_name}</a> has closed their favorites section.]]></phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="full_name_s_favorites" added="1254464709"><![CDATA[{full_name}'s Favorites]]></phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="view_favorites" added="1254464746">View Favorites</phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="not_a_valid_module" added="1254464765">Not a valid module.</phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="unable_to_add_this_item_as_a_favorite_due_to_privacy" added="1254464775"><![CDATA[Unable to add this item as a "Favorite" due to privacy.]]></phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="this_item_is_already_in_your_favorites_list" added="1254464785">This item is already in your favorites list.</phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="successfully_added_to_your_favorites" added="1254464814">Successfully added to your favorites.</phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="view_your_favorites" added="1254464824">View your Favorites</phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="close" added="1254464865">Close</phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="added_by_user_on_time_stamp_phrase" added="1254465107">Added by {user_link} on {time_stamp_phrase}</phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="are_you_sure" added="1254466140">Are you sure?</phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="delete" added="1254466166">Delete</phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="recently_added" added="1254466190">Recently Added</phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="you_do_not_have_any_items_or_users_listed_in_your_favorites_just_yet" added="1254466204">You do not have any items or users listed in your favorites just yet.</phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="you_have_not_added_any_favorites_yet" added="1254466219"><![CDATA[You have not added any "Favorites" yet.]]></phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="to_add_items_to_your_favorite_list_simply_view_public_items_on_the_site" added="1254466234"><![CDATA[To add items to your favorite list simply view public items on the site and look for the "Add to Favorite" link.]]></phrase>
		<phrase module_id="favorite" version_id="2.0.0rc3" var_name="user_link_has_not_added_any_favorites_yet" added="1254466379"><![CDATA[{user_link} has not added any "Favorites" yet.]]></phrase>
		<phrase module_id="favorite" version_id="2.0.0rc4" var_name="favorites" added="1255716351">Favorites</phrase>
	</phrases>
	<tables><![CDATA[a:1:{s:15:"phpfox_favorite";a:3:{s:7:"COLUMNS";a:5:{s:11:"favorite_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"favorite_id";s:4:"KEYS";a:3:{s:7:"type_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"type_id";i:1;s:7:"item_id";i:2;s:7:"user_id";}}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:11:"favorite_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:11:"favorite_id";i:1;s:7:"user_id";}}}}}]]></tables>
</module>