<upgrade>
	<phrases>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>3.0.0beta1</version_id>
			<var_name>user_setting_points_marketplace</var_name>
			<added>1304598138</added>
			<value>How many activity points should the user get when adding a new listing?</value>
		</phrase>
	</phrases>
	<phpfox_update_menus>
		<menu>
			<module_id>marketplace</module_id>
			<parent_var_name />
			<m_connection>main</m_connection>
			<var_name>menu_marketplace</var_name>
			<ordering>59</ordering>
			<url_value>marketplace</url_value>
			<version_id>2.0.0alpha4</version_id>
			<disallow_access />
			<module>marketplace</module>
			<value />
		</menu>
	</phpfox_update_menus>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>marketplace</module_id>
			<type>integer</type>
			<admin>1</admin>
			<user>1</user>
			<guest>0</guest>
			<staff>1</staff>
			<module>marketplace</module>
			<ordering>0</ordering>
			<value>points_marketplace</value>
		</setting>
	</user_group_settings>
	<components>
		<component>
			<module_id>marketplace</module_id>
			<component>price</component>
			<m_connection />
			<module>marketplace</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>marketplace</module_id>
			<component>featured</component>
			<m_connection />
			<module>marketplace</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>marketplace</module_id>
			<component>profile</component>
			<m_connection>marketplace.profile</m_connection>
			<module>marketplace</module>
			<is_controller>1</is_controller>
			<is_block>0</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>marketplace</module_id>
			<component>invite</component>
			<m_connection />
			<module>marketplace</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>marketplace.view</m_connection>
			<module_id>marketplace</module_id>
			<component>image</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Listing Photos</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>marketplace.view</m_connection>
			<module_id>marketplace</module_id>
			<component>price</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Listing Price</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>marketplace.index</m_connection>
			<module_id>marketplace</module_id>
			<component>featured</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>5</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Featured Listings</title>
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>marketplace.index</m_connection>
			<module_id>marketplace</module_id>
			<component>invite</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Users Invites</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>marketplace.index</m_connection>
			<module_id>marketplace</module_id>
			<component>filter</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>marketplace</module_id>
			<component>profile</component>
			<location>3</location>
			<is_active>0</is_active>
			<ordering>6</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>marketplace.view</m_connection>
			<module_id>marketplace</module_id>
			<component>info</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>marketplace.view</m_connection>
			<module_id>marketplace</module_id>
			<component>menu</component>
			<location>3</location>
			<is_active>0</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>marketplace.view</m_connection>
			<module_id>marketplace</module_id>
			<component>my</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:4:{s:9:"ADD_FIELD";a:1:{s:18:"phpfox_marketplace";a:3:{s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:9:"ALTER_KEY";a:1:{s:18:"phpfox_marketplace";a:3:{s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"privacy";}}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:11:"is_featured";}}s:10:"listing_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:10:"listing_id";i:1;s:7:"view_id";}}}}s:10:"REMOVE_KEY";a:1:{s:18:"phpfox_marketplace";a:1:{i:0;a:2:{i:0;s:5:"INDEX";i:1;s:7:"view_id";}}}s:11:"ALTER_FIELD";a:1:{s:27:"phpfox_marketplace_category";a:1:{s:8:"name_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}}]]></sql>
</upgrade>