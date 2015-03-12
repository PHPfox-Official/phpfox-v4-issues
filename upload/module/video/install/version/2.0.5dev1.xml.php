<upgrade>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_can_sponsor_video</var_name>
			<added>1270026188</added>
			<value>Can members of this user group mark videos as sponsor?</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>unsponsor_this_video</var_name>
			<added>1270026492</added>
			<value>Unsponsor this video</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_this_video</var_name>
			<added>1270026503</added>
			<value>Sponsor this video</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>video_successfully_sponsored</var_name>
			<added>1270029791</added>
			<value>Video successfully sponsored.</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>video_successfully_un_sponsored</var_name>
			<added>1270029804</added>
			<value>Video successfully unsponsored.</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsored_video</var_name>
			<added>1270031934</added>
			<value>Sponsored Video</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_can_purchase_sponsor</var_name>
			<added>1271076186</added>
			<value>Can members of this user group purchase a sponsored ad space?</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_help</var_name>
			<added>1271148643</added>
			<value><![CDATA[To purchase sponsor space for your video, view your video by clicking on it and then click on "Sponsor" on the right hand side menu]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>encourage_sponsor</var_name>
			<added>1271150347</added>
			<value>Sponsor your Videos</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_video_sponsor_price</var_name>
			<added>1271756668</added>
			<value>How much is the sponsor space worth?
This works in a CPM basis.</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_paypal_message</var_name>
			<added>1271941483</added>
			<value>Payment for the sponsor space of video: {sVideoTitle}</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_title</var_name>
			<added>1271941956</added>
			<value>Video: {sVideoTitle}</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>sponsor_error_not_found</var_name>
			<added>1271942415</added>
			<value>The video you are trying to sponsor cannot be found.</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>user_setting_auto_publish_sponsored_item</var_name>
			<added>1272007206</added>
			<value>After the user has purchased a sponsored space, should the video be published right away?
If set to false, the admin will have to approve each new purchased sponsored video space before it is shown in the site.</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>comments_total_comment</var_name>
			<added>1273233241</added>
			<value>Comments ({total_comment})</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.5</version_id>
			<var_name>total_score_out_of_10</var_name>
			<added>1273233268</added>
			<value>{total_score} out of 10</value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>video</module_id>
			<type>boolean</type>
			<admin>false</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>video</module>
			<ordering>0</ordering>
			<value>can_sponsor_video</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>video</module_id>
			<type>boolean</type>
			<admin>false</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>video</module>
			<ordering>0</ordering>
			<value>can_purchase_sponsor</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>video</module_id>
			<type>string</type>
			<admin>null</admin>
			<user>null</user>
			<guest>null</guest>
			<staff>null</staff>
			<module>video</module>
			<ordering>0</ordering>
			<value>video_sponsor_price</value>
		</setting>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>video</module_id>
			<type>boolean</type>
			<admin>true</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>video</module>
			<ordering>0</ordering>
			<value>auto_publish_sponsored_item</value>
		</setting>
	</user_group_settings>
	<hooks>
		<hook>
			<module_id>video</module_id>
			<hook_type>service</hook_type>
			<module>video</module>
			<call_name>video.service_process_sponsor__end</call_name>
			<added>1274286148</added>
			<version_id>2.0.5dev1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>template</hook_type>
			<module>video</module>
			<call_name>video.template_default_controller_view_extra_info</call_name>
			<added>1274286148</added>
			<version_id>2.0.5dev1</version_id>
			<value />
		</hook>
	</hooks>
	<components>
		<component>
			<module_id>video</module_id>
			<component>sponsored</component>
			<m_connection />
			<module>video</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>video.index</m_connection>
			<module_id>video</module_id>
			<component>sponsored</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>1</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>video.index</m_connection>
			<module_id>video</module_id>
			<component>category</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>3</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>video.index</m_connection>
			<module_id>video</module_id>
			<component>filter</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>video.index</m_connection>
			<module_id>video</module_id>
			<component>spotlight</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>2</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:12:"phpfox_video";a:1:{s:10:"is_sponsor";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:11:"ALTER_FIELD";a:1:{s:12:"phpfox_video";a:2:{s:11:"destination";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"image_path";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}}}]]></sql>
	<update_templates>
		<file type="controller">view.html.php</file>
		<file type="block">entry.html.php</file>
		<file type="block">menu.html.php</file>
	</update_templates>
</upgrade>