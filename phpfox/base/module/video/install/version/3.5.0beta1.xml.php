<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>use_youtube_iframe</var_name>
			<phrase_var_name>setting_use_youtube_iframe</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.5.0beta1</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>item_phrase</var_name>
			<added>1352730777</added>
			<value>video</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>setting_use_youtube_iframe</var_name>
			<added>1353335900</added>
			<value><![CDATA[<title>Use Youtube iFrame</title><info>If enabled the script will use an iFrame instead of an object when displaying a video from Youtube.</info>]]></value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>video</module_id>
			<hook_type>controller</hook_type>
			<module>video</module>
			<call_name>video.component_controller_add_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>controller</hook_type>
			<module>video</module>
			<call_name>video.component_controller_add_2</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>controller</hook_type>
			<module>video</module>
			<call_name>video.component_controller_add_3</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>controller</hook_type>
			<module>video</module>
			<call_name>video.component_controller_add_4</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>controller</hook_type>
			<module>video</module>
			<call_name>video.component_controller_profile_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>controller</hook_type>
			<module>video</module>
			<call_name>video.component_controller_view_1</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>controller</hook_type>
			<module>video</module>
			<call_name>video.component_controller_view_2</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>video</module_id>
			<hook_type>controller</hook_type>
			<module>video</module>
			<call_name>video.component_controller_view_3</call_name>
			<added>1358258443</added>
			<version_id>3.5.0beta1</version_id>
			<value />
		</hook>
	</hooks>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:1:{s:12:"phpfox_video";a:1:{s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
</upgrade>