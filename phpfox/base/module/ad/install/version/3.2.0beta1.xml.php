<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>ad</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>how_many_ads_per_location</var_name>
			<phrase_var_name>setting_how_many_ads_per_location</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.2.0beta1</version_id>
			<value>1</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>ad</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>setting_how_many_ads_per_location</var_name>
			<added>1332855052</added>
			<value><![CDATA[<title>How Many Ads Per Location</title><info>This setting tells how many ads will be shown per location. 

If you set this to a numerical zero (0) it will load every ad available for that location.

The default is 1</info>]]></value>
		</phrase>
		<phrase>
			<module_id>ad</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>completed</var_name>
			<added>1332928081</added>
			<value>Completed</value>
		</phrase>
		<phrase>
			<module_id>ad</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>block_location_cost_ppc</var_name>
			<added>1333024947</added>
			<value>Block {location} - {cost} per click</value>
		</phrase>
		<phrase>
			<module_id>ad</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>you_are_not_the_owner_of_this_ad</var_name>
			<added>1333451181</added>
			<value>You are not the owner of this ad</value>
		</phrase>
		<phrase>
			<module_id>ad</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>this_ad_has_used_all_its_views</var_name>
			<added>1333451198</added>
			<value>This ad has used all its views</value>
		</phrase>
		<phrase>
			<module_id>ad</module_id>
			<version_id>3.2.0beta1</version_id>
			<var_name>this_ad_has_used_all_its_clicks</var_name>
			<added>1333451211</added>
			<value>This ad has used all its clicks</value>
		</phrase>
	</phrases>
	<sql><![CDATA[a:1:{s:9:"ADD_FIELD";a:2:{s:9:"phpfox_ad";a:1:{s:6:"is_cpm";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}}s:14:"phpfox_ad_plan";a:1:{s:6:"is_cpm";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}}}}]]></sql>
</upgrade>