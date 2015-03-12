<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>im</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>im_php_sleep</var_name>
			<phrase_var_name>setting_im_php_sleep</phrase_var_name>
			<ordering>2</ordering>
			<version_id>3.0.0beta1</version_id>
			<value>5</value>
		</setting>
		<setting>
			<group />
			<module_id>im</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>im_php_loops</var_name>
			<phrase_var_name>setting_im_php_loops</phrase_var_name>
			<ordering>3</ordering>
			<version_id>3.0.0beta1</version_id>
			<value>6</value>
		</setting>
		<setting>
			<group />
			<module_id>im</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>js_interval_value</var_name>
			<phrase_var_name>setting_js_interval_value</phrase_var_name>
			<ordering>4</ordering>
			<version_id>3.0.0beta1</version_id>
			<value>3000</value>
		</setting>
		<setting>
			<group />
			<module_id>im</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>server_for_ajax_calls</var_name>
			<phrase_var_name>setting_server_for_ajax_calls</phrase_var_name>
			<ordering>5</ordering>
			<version_id>3.0.0beta1</version_id>
			<value />
		</setting>
	</settings>
	<phpfox_update_settings>
		<setting>
			<group>time_stamps</group>
			<module_id>im</module_id>
			<is_hidden>0</is_hidden>
			<type>string</type>
			<var_name>im_time_stamp</var_name>
			<phrase_var_name>setting_im_time_stamp</phrase_var_name>
			<ordering>10</ordering>
			<version_id>2.0.0beta5</version_id>
			<value>G:i</value>
		</setting>
		<setting>
			<group />
			<module_id>im</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>total_friends_to_display_in_im</var_name>
			<phrase_var_name>setting_total_friends_to_display_in_im</phrase_var_name>
			<ordering>6</ordering>
			<version_id>2.0.0rc1</version_id>
			<value>50</value>
		</setting>
	</phpfox_update_settings>
	<phrases>
		<phrase>
			<module_id>im</module_id>
			<version_id>3.0.0beta1</version_id>
			<var_name>setting_im_php_sleep</var_name>
			<added>1312373490</added>
			<value><![CDATA[<title>Server Sleep Timeout</title><info>When the IM requests an update from the server, the server will check for new messages and other information, if nothing new is found it will wait to check again, this value sets how long (in seconds) should the server wait.

The lower the value the more real time the IM will look, but it will use more server resources. 

Too low a value and your server may not be able to handle it, use carefully.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>im</module_id>
			<version_id>3.0.0beta1</version_id>
			<var_name>setting_im_php_loops</var_name>
			<added>1312373834</added>
			<value><![CDATA[<title>Server Number Of Checks</title><info>When the IM requests an update from the server, the server will check for new messages and other information, if nothing new is found it will wait to check again, this happens in the same ajax call. This setting tells how many times should the same process check for new updates before closing the connection.

Some servers limit how long can a PHP process run (for example 30 seconds), you can use this value and "Server Sleep Timeout" to schedule the updates for the IM.

The default combination allows the checks to run for 30 seconds before returning control to the web browser for another run.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>im</module_id>
			<version_id>3.0.0beta1</version_id>
			<var_name>setting_js_interval_value</var_name>
			<added>1312374230</added>
			<value><![CDATA[<title>JS Ajax Interval Check Timeout</title><info>This setting controls how often will the IM check on the state of an Ajax call. The value is in milliseconds, so it defaults to 3 seconds.

If the value is too low the web browser may become unresponsive. It is advised to keep it in the thousands range.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>im</module_id>
			<version_id>3.0.0beta1</version_id>
			<var_name>setting_server_for_ajax_calls</var_name>
			<added>1312528680</added>
			<value><![CDATA[<title>Server For Ajax Calls</title><info>To improve performance you can distribute the load from the IM to a different server.
This setting tells to which server should the IM query for updates.

Keep in mind that the server must still be under the same domain.

If you leave it blank the IM will query the main server.
Acceptable values are in the form of a domain or an IP address, for example:
http://im.domain.com/
http://67.15.104.63/

are valid examples. Also dont forget the http:// and the ending /</info>]]></value>
		</phrase>
	</phrases>
	<sql><![CDATA[a:2:{s:11:"ALTER_FIELD";a:1:{s:9:"phpfox_im";a:1:{s:6:"is_new";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:9:"ADD_FIELD";a:1:{s:14:"phpfox_im_text";a:1:{s:7:"text_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}}}}]]></sql>
</upgrade>