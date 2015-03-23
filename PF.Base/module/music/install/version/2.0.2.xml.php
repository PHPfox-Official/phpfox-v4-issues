<upgrade>
	<hooks>
		<hook>
			<module_id>music</module_id>
			<hook_type>component</hook_type>
			<module>music</module>
			<call_name>music.component_block_profile_clean</call_name>
			<added>1263387694</added>
			<version_id>2.0.2</version_id>
			<value />
		</hook>
	</hooks>
	<components>
		<component>
			<module_id>music</module_id>
			<component>profile</component>
			<m_connection />
			<module>music</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>profile.index</m_connection>
			<module_id>music</module_id>
			<component>profile</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>20</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title>Favorite Songs</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<update_templates>
		<file type="block">song.html.php</file>
		<file type="block">entry.html.php</file>
	</update_templates>
</upgrade>