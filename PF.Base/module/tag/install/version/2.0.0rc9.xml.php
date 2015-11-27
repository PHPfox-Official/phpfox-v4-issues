<upgrade>
	<phrases>
		<phrase>
			<module_id>tag</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>tag_cloud</var_name>
			<added>1258731513</added>
			<value>Tag Cloud</value>
		</phrase>
		<phrase>
			<module_id>tag</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>no_tags_have_been_found</var_name>
			<added>1258731805</added>
			<value>No tags have been found.</value>
		</phrase>
	</phrases>
	<blocks>
		<block>
			<m_connection>core.index-member</m_connection>
			<module_id>tag</module_id>
			<component>cloud</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>15</ordering>
			<can_move>1</can_move>
			<value />
		</block>
		<block>
			<m_connection>photo.index</m_connection>
			<module_id>tag</module_id>
			<component>cloud</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<can_move>0</can_move>
			<value />
		</block>
		<block>
			<m_connection>video.index</m_connection>
			<module_id>tag</module_id>
			<component>cloud</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<can_move>0</can_move>
			<value />
		</block>
	</blocks>
	<sql><![CDATA[a:1:{s:7:"ADD_KEY";a:1:{s:10:"phpfox_tag";a:1:{s:9:"item_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"item_id";i:1;s:11:"category_id";i:2;s:7:"tag_url";}}}}}]]></sql>
	<update_templates>
		<file type="block">cloud.html.php</file>
	</update_templates>
</upgrade>