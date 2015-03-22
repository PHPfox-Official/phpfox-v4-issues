<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>video_enable_mass_uploader</var_name>
			<phrase_var_name>setting_video_enable_mass_uploader</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.8</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group>formatting</group>
			<module_id>video</module_id>
			<is_hidden>0</is_hidden>
			<type>boolean</type>
			<var_name>allow_youtube_iframe</var_name>
			<phrase_var_name>setting_allow_youtube_iframe</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.1.0beta1</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.8</version_id>
			<var_name>setting_video_enable_mass_uploader</var_name>
			<added>1295446768</added>
			<value><![CDATA[<title>Enable Mass Uploader</title><info>When enabled users will be allowed to use SWFUpload to upload videos, this shows a progress bar for the percentage of the video that has been uploaded. 

This uses an integration of SWFUpload (http://code.google.com/p/swfupload/) and thus it uses a Flash object.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.8</version_id>
			<var_name>use_simple_uploader</var_name>
			<added>1296655127</added>
			<value>Use simple uploader</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.0.8</version_id>
			<var_name>use_mass_uploader</var_name>
			<added>1296655149</added>
			<value>Use mass uploader</value>
		</phrase>
		<phrase>
			<module_id>video</module_id>
			<version_id>2.1.0beta1</version_id>
			<var_name>setting_allow_youtube_iframe</var_name>
			<added>1299846652</added>
			<value><![CDATA[<title>Allow iFrame From Youtube</title><info>iFrames pose a security risk and are disabled by default in the script. 
If you want to allow users to embed videos from youtube you can enable iframes only for youtube here.</info>]]></value>
		</phrase>
	</phrases>
	<components>
		<component>
			<module_id>video</module_id>
			<component>share</component>
			<m_connection>video.share</m_connection>
			<module>video</module>
			<is_controller>1</is_controller>
			<is_block>0</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
</upgrade>