<module>
	<data>
		<module_id>tinymce</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_tinymce</phrase_var_name>
		<writable />
	</data>
	<settings>
		<setting group="" module_id="tinymce" is_hidden="0" type="large_string" var_name="tinymce_button_1" phrase_var_name="setting_tinymce_button_1" ordering="1" version_id="2.0.5">bold,italic,underline,separator,bullist,numlist,separator,link,unlink,separator,fontselect,fontsizeselect,forecolor</setting>
		<setting group="" module_id="tinymce" is_hidden="0" type="large_string" var_name="tinymce_button_2" phrase_var_name="setting_tinymce_button_2" ordering="1" version_id="2.0.5" />
		<setting group="" module_id="tinymce" is_hidden="0" type="large_string" var_name="tinymce_button_3" phrase_var_name="setting_tinymce_button_3" ordering="1" version_id="2.0.5" />
		<setting group="" module_id="tinymce" is_hidden="0" type="string" var_name="tinymce_toolbar_location" phrase_var_name="setting_tinymce_toolbar_location" ordering="1" version_id="2.0.5">top</setting>
		<setting group="" module_id="tinymce" is_hidden="0" type="string" var_name="tinymce_toolbar_alignment" phrase_var_name="setting_tinymce_toolbar_alignment" ordering="1" version_id="2.0.5">left</setting>
		<setting group="" module_id="tinymce" is_hidden="0" type="large_string" var_name="tinymce_plugins" phrase_var_name="setting_tinymce_plugins" ordering="1" version_id="2.0.5" />
		<setting group="" module_id="tinymce" is_hidden="0" type="array" var_name="tinymce_load_on_pages" phrase_var_name="setting_tinymce_load_on_pages" ordering="1" version_id="3.0.0beta1"><![CDATA[s:344:"array(
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
  10 => 'mail.thread|#message',
);";]]></setting>
	</settings>
	<hooks>
		<hook module_id="tinymce" hook_type="controller" module="tinymce" call_name="tinymce.component_controller_index_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="tinymce" hook_type="service" module="tinymce" call_name="tinymce.service_callback__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="tinymce" hook_type="service" module="tinymce" call_name="tinymce.service_process__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="tinymce" hook_type="service" module="tinymce" call_name="tinymce.service_tinymce__call" added="1319729453" version_id="3.0.0rc1" />
	</hooks>
	<phrases>
		<phrase module_id="tinymce" version_id="2.0.5" var_name="module_tinymce" added="1270645008">TinyMCE Editor</phrase>
		<phrase module_id="tinymce" version_id="2.0.5" var_name="setting_tinymce_button_1" added="1271834312"><![CDATA[<title>Advanced Buttons 1</title><info>Here you can define what tools you want to be displayed on the first row of buttons.</info>]]></phrase>
		<phrase module_id="tinymce" version_id="2.0.5" var_name="setting_tinymce_button_2" added="1271835241"><![CDATA[<title>Advanced Buttons 2</title><info>Here you can define what tools you want to be displayed on the second row of buttons.</info>]]></phrase>
		<phrase module_id="tinymce" version_id="2.0.5" var_name="setting_tinymce_button_3" added="1271835304"><![CDATA[<title>Advanced Buttons 3</title><info>Here you can define what tools you want to be displayed on the third row of buttons.</info>]]></phrase>
		<phrase module_id="tinymce" version_id="2.0.5" var_name="setting_tinymce_toolbar_location" added="1271835401"><![CDATA[<title>Toolbar Location</title><info>This option enables you to specify where the toolbar should be located. This option can be set to "top" or "bottom" (the default) or "external".</info>]]></phrase>
		<phrase module_id="tinymce" version_id="2.0.5" var_name="setting_tinymce_toolbar_alignment" added="1271835547"><![CDATA[<title>Toolbar Alignment</title><info>This option enables you to specify the alignment of the toolbar, this value can be "left", "right" or "center" (the default).</info>]]></phrase>
		<phrase module_id="tinymce" version_id="2.0.5" var_name="setting_tinymce_plugins" added="1271835648"><![CDATA[<title>Plugins</title><info>This option should contain a comma separated list of plugins.</info>]]></phrase>
		<phrase module_id="tinymce" version_id="2.0.5" var_name="use_wysiwyg_editor" added="1271938494">Use WYSIWYG Editor</phrase>
		<phrase module_id="tinymce" version_id="2.0.5" var_name="use_default_editor" added="1271938509">Use Default Editor</phrase>
		<phrase module_id="tinymce" version_id="3.0.0beta1" var_name="setting_tinymce_load_on_pages" added="1305888867"><![CDATA[<title>Load TinyMCE on Controllers</title><info>Define where we should load TinyMCE.</info>]]></phrase>
	</phrases>
</module>