<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>can_move_on_a_y_and_x_axis</var_name>
			<phrase_var_name>setting_can_move_on_a_y_and_x_axis</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc4</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group>formatting</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>resize_images</var_name>
			<phrase_var_name>setting_resize_images</phrase_var_name>
			<ordering>3</ordering>
			<version_id>2.0.0rc4</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>setting_can_move_on_a_y_and_x_axis</var_name>
			<added>1256500257</added>
			<value><![CDATA[<title>Drag/Drop Blocks</title><info>Set this setting to <b>True</b> if you want to allow users to move blocks on a Y or X axis within areas where they can move blocks (eg. Their own profile). By default we only allow users to move blocks on a Y axis and allowing users to move blocks anywhere will give them the freedom but can cause your site design to be destroyed.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>block</var_name>
			<added>1256542768</added>
			<value>Block</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>full_name_is_online</var_name>
			<added>1256550931</added>
			<value>{full_name} is online.</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>setting_resize_images</var_name>
			<added>1256639414</added>
			<value><![CDATA[<title>Resize Images</title><info>If you allow HTML on the site and users attempt to add images you can enable this option to set a maximum width/height in certain areas (eg. General Comments & News Feed).

<b>Note:</b> If enabled this will add an extra overhead to the script.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>you_cannot_write_more_then_limit_characters</var_name>
			<added>1256666443</added>
			<value>You cannot write more then {limit} characters!</value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>you_have_limit_character_s_left</var_name>
			<added>1256666594</added>
			<value>You have {limit} character(s) left.</value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>welcome</component>
			<location>7</location>
			<is_active>1</is_active>
			<ordering>13</ordering>
			<can_move>0</can_move>
			<value />
		</block>
		<block>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>dashboard</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>10</ordering>
			<can_move>1</can_move>
			<value />
		</block>
		<block>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>new</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>12</ordering>
			<can_move>1</can_move>
			<value />
		</block>
		<block>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>stat</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>9</ordering>
			<can_move>1</can_move>
			<value />
		</block>
	</phpfox_update_blocks>
	<update_templates>
		<file type="block">dashboard.html.php</file>
		<file type="layout">template.html.php</file>
	</update_templates>
	<update_styles>
		<file type="layout">announcement.css</file>
		<file type="layout">layout.css</file>
		<file type="layout">thickbox.css</file>
	</update_styles>
</upgrade>