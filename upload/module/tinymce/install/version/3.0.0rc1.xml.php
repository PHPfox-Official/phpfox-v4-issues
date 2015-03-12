<upgrade>
	<phpfox_update_settings>
		<setting>
			<group />
			<module_id>tinymce</module_id>
			<is_hidden>0</is_hidden>
			<type>array</type>
			<var_name>tinymce_load_on_pages</var_name>
			<phrase_var_name>setting_tinymce_load_on_pages</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.0.0beta1</version_id>
			<value><![CDATA[s:312:"array(
  0 => 'blog.add|#text',
  1 => 'event.add|#description',
  2 => 'marketplace.add|#description',
  3 => 'mail.compose|#message',
  4 => 'forum.post|#text',
  5 => 'pages.add|#text',
  6 => 'mail.view|#message',
  7 => 'pages.widget|#text',
  8 => 'forum.thread|#text',
  9 => 'forum.post.thread|#text',
);";]]></value>
		</setting>
	</phpfox_update_settings>
	<hooks>
		<hook>
			<module_id>tinymce</module_id>
			<hook_type>controller</hook_type>
			<module>tinymce</module>
			<call_name>tinymce.component_controller_index_clean</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>tinymce</module_id>
			<hook_type>service</hook_type>
			<module>tinymce</module>
			<call_name>tinymce.service_callback__call</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>tinymce</module_id>
			<hook_type>service</hook_type>
			<module>tinymce</module>
			<call_name>tinymce.service_process__call</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
		<hook>
			<module_id>tinymce</module_id>
			<hook_type>service</hook_type>
			<module>tinymce</module>
			<call_name>tinymce.service_tinymce__call</call_name>
			<added>1319729453</added>
			<version_id>3.0.0rc1</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>