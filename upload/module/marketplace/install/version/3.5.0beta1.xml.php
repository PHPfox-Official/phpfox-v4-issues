<upgrade>
	<settings>
		<setting>
			<group />
			<module_id>marketplace</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>days_to_expire_listing</var_name>
			<phrase_var_name>setting_days_to_expire_listing</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.5.0beta1</version_id>
			<value>0</value>
		</setting>
		<setting>
			<group />
			<module_id>marketplace</module_id>
			<is_hidden>0</is_hidden>
			<type>integer</type>
			<var_name>days_to_notify_expire</var_name>
			<phrase_var_name>setting_days_to_notify_expire</phrase_var_name>
			<ordering>1</ordering>
			<version_id>3.5.0beta1</version_id>
			<value>0</value>
		</setting>
	</settings>
	<phrases>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>item_phrase</var_name>
			<added>1352732222</added>
			<value>marketplace listing</value>
		</phrase>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>setting_days_to_expire_listing</var_name>
			<added>1352993376</added>
			<value><![CDATA[<title>Days to Expire</title><info>If you want marketplace listings to expire you can enter the number of days here.

If you enter 0 days listings will not expire.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>expired</var_name>
			<added>1353055149</added>
			<value>Expired</value>
		</phrase>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>user_setting_can_view_expired</var_name>
			<added>1353058986</added>
			<value>If you have enabled listings to expire this setting can still display them for this specific user group. This is intended for site administrators.</value>
		</phrase>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>listing_expired_and_not_available_main_section</var_name>
			<added>1353062219</added>
			<value>This listing has expired and is no longer available from the main marketplace section.</value>
		</phrase>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>setting_days_to_notify_expire</var_name>
			<added>1353317991</added>
			<value><![CDATA[<title>Days to Notify Expiring Listing</title><info>When you allow listings to expire you can also set a notification to be sent automatically to the owner of the listing, you can define here how many days in advanced to notify them.

If you set this to 0 no email will be sent to the owner.</info>]]></value>
		</phrase>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>listing_expiring_subject</var_name>
			<added>1353321414</added>
			<value><![CDATA[Your listing "{title}" is soon to expire.]]></value>
		</phrase>
		<phrase>
			<module_id>marketplace</module_id>
			<version_id>3.5.0beta1</version_id>
			<var_name>listing_expiring_message</var_name>
			<added>1353322352</added>
			<value><![CDATA[Your listing <a href="{link}">"{title}"</a> at {site_name} will expire in {days} days.]]></value>
		</phrase>
	</phrases>
	<user_group_settings>
		<setting>
			<is_admin_setting>0</is_admin_setting>
			<module_id>marketplace</module_id>
			<type>boolean</type>
			<admin>true</admin>
			<user>false</user>
			<guest>false</guest>
			<staff>false</staff>
			<module>marketplace</module>
			<ordering>0</ordering>
			<value>can_view_expired</value>
		</setting>
	</user_group_settings>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:18:"phpfox_marketplace";a:2:{s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_notified";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:7:"ADD_KEY";a:1:{s:18:"phpfox_marketplace";a:1:{s:11:"is_notified";a:2:{i:0;s:5:"INDEX";i:1;s:11:"is_notified";}}}}]]></sql>
</upgrade>