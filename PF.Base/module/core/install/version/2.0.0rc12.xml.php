<upgrade>
	<settings>
		<setting>
			<group>time_stamps</group>
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>footer_watch_time_stamp</var_name>
			<phrase_var_name>setting_footer_watch_time_stamp</phrase_var_name>
			<ordering>13</ordering>
			<version_id>2.0.0rc12</version_id>
			<value>g:i A</value>
		</setting>
		<setting>
			<group />
			<module_id>core</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>categories_to_show_at_first</var_name>
			<phrase_var_name>setting_categories_to_show_at_first</phrase_var_name>
			<ordering>1</ordering>
			<version_id>2.0.0rc12</version_id>
			<value>5</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_footer_watch_time_stamp</var_name>
			<added>1260824135</added>
			<value><![CDATA[<title>Footer Bar Time Stamp</title><info>Footer Bar Time Stamp</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>setting_categories_to_show_at_first</var_name>
			<added>1260886987</added>
			<value><![CDATA[<title>How many categories to show at first</title><info>This setting tells how many categories are to be shown at first. If the list of categories is longer than this value the extra ones will be hidden and a "View More" option will be shown instead, allowing the user to display the hidden categories.

a "View Less" option will be available to provide the full "accordion" effect.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>core</module_id>
			<version_id>2.0.0rc12</version_id>
			<var_name>translating_name</var_name>
			<added>1260974997</added>
			<value>Translating: {name}</value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>welcome</component>
			<location>7</location>
			<is_active>1</is_active>
			<ordering>16</ordering>
			<disallow_access />
			<can_move>0</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>dashboard</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>13</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
		<block>
			<type_id>0</type_id>
			<m_connection>core.index-member</m_connection>
			<module_id>core</module_id>
			<component>new</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>11</ordering>
			<disallow_access />
			<can_move>1</can_move>
			<title />
			<source_code />
			<source_parsed />
		</block>
	</phpfox_update_blocks>
	<phpfox_update_pages>
		<page>
			<module_id>core</module_id>
			<is_phrase>1</is_phrase>
			<has_bookmark>0</has_bookmark>
			<parse_php>1</parse_php>
			<add_view>0</add_view>
			<full_size>1</full_size>
			<title>core.about</title>
			<title_url>about</title_url>
			<added>1231338597</added>
			<keyword />
			<description />
			<text>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris fringilla justo consectetur velit. Morbi volutpat. Nam et nibh. Sed nec metus vitae libero luctus cursus. Nulla facilisi. Duis at orci ut mauris imperdiet mattis. Integer quam enim, feugiat at, sagittis at, venenatis in, lacus. Phasellus at tellus. Praesent orci justo, malesuada ac, pulvinar sed, iaculis non, leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam eget quam. Nunc sed velit. Phasellus quis nisi. In nisi nisi, suscipit ut, lobortis non, vestibulum quis, sapien. Cras nisl. Proin tristique. Duis ac diam nec ante convallis elementum. Quisque eget purus.

Quisque mauris orci, feugiat et, ornare vitae, adipiscing tempus, metus. Nam tincidunt. Donec arcu. Sed augue risus, faucibus eu, laoreet sit amet, interdum eget, odio. Aliquam faucibus libero sed lorem. Nulla erat. Donec sapien dui, rutrum ac, pharetra id, fermentum sed, arcu. Donec elementum vulputate lectus. Nam vitae risus. Suspendisse semper consectetur nulla. Morbi mattis justo a mauris. Nam vel felis ac velit pharetra rhoncus. Praesent faucibus odio tincidunt massa. Etiam adipiscing libero vel erat. Vestibulum arcu. Donec convallis quam non lectus.</text>
			<text_parsed><![CDATA[<?php /* Cached: December 15, 2009, 4:39 pm */ ?>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris fringilla justo consectetur velit. Morbi volutpat. Nam et nibh. Sed nec metus vitae libero luctus cursus. Nulla facilisi. Duis at orci ut mauris imperdiet mattis. Integer quam enim, feugiat at, sagittis at, venenatis in, lacus. Phasellus at tellus. Praesent orci justo, malesuada ac, pulvinar sed, iaculis non, leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam eget quam. Nunc sed velit. Phasellus quis nisi. In nisi nisi, suscipit ut, lobortis non, vestibulum quis, sapien. Cras nisl. Proin tristique. Duis ac diam nec ante convallis elementum. Quisque eget purus.
<br class="pf_break" />
<br class="pf_break" />Quisque mauris orci, feugiat et, ornare vitae, adipiscing tempus, metus. Nam tincidunt. Donec arcu. Sed augue risus, faucibus eu, laoreet sit amet, interdum eget, odio. Aliquam faucibus libero sed lorem. Nulla erat. Donec sapien dui, rutrum ac, pharetra id, fermentum sed, arcu. Donec elementum vulputate lectus. Nam vitae risus. Suspendisse semper consectetur nulla. Morbi mattis justo a mauris. Nam vel felis ac velit pharetra rhoncus. Praesent faucibus odio tincidunt massa. Etiam adipiscing libero vel erat. Vestibulum arcu. Donec convallis quam non lectus.]]></text_parsed>
		</page>
	</phpfox_update_pages>
	<update_templates>
		<file type="block">dashboard.html.php</file>
		<file type="block">translate-country.html.php</file>
		<file type="block">translate-child-country.html.php</file>
		<file type="layout">breadcrumb.html.php</file>
		<file type="layout">template.html.php</file>
	</update_templates>
	<update_styles>
		<file type="layout">comment.css</file>
		<file type="layout">layout.css</file>
		<file type="layout">common.css</file>
	</update_styles>
</upgrade>