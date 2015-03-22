<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>tag</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>enable_hashtag_support</var_name>
			<phrase_var_name>setting_enable_hashtag_support</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.7.0beta1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>tag</module_id>
			<version_id>3.7.0beta1</version_id>
			<var_name>setting_enable_hashtag_support</var_name>
			<added>1373896214</added>
			<value><![CDATA[<title>Enable Hashtags</title><info>Enable this option if you wish to allow hashtags on the site to create topics for the item being added. This will remove the default tagging system.</info>]]></value>
		</phrase>
	</phrases>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>tag</module_id>
			<component>cloud</component>
			<location>3</location>
			<is_active>1</is_active>
			<ordering>12</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title>Hashtags</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
</upgrade>