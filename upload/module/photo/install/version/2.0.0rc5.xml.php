<upgrade>
	<phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>full_name_s_photo_from_time_stamp</var_name>
			<added>1256488497</added>
			<value><![CDATA[{full_name}'s Photo from {time_stamp}]]></value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>click_here_to_tag_as_yourself</var_name>
			<added>1256488630</added>
			<value>Click here to tag as yourself.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>groups</var_name>
			<added>1256489661</added>
			<value>Groups</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>select_an_area_on_your_photo_to_crop</var_name>
			<added>1256490113</added>
			<value>Select an area on your photo to crop.</value>
		</phrase>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>all_photos</var_name>
			<added>1256712979</added>
			<value>All Photos</value>
		</phrase>
	</phrases>
	<sql><![CDATA[a:1:{s:7:"ADD_KEY";a:1:{s:12:"phpfox_photo";a:1:{s:10:"photo_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:8:"photo_id";i:1;s:8:"album_id";i:2;s:8:"group_id";}}}}}]]></sql>
	<update_templates>
		<file type="controller">view.html.php</file>
		<file type="controller">upload.html.php</file>
		<file type="controller">profile.html.php</file>
		<file type="block">photo-entry.html.php</file>
		<file type="block">stream.html.php</file>
		<file type="block">menu.html.php</file>
		<file type="block">album-entry.html.php</file>
		<file type="block">profile.html.php</file>
	</update_templates>
</upgrade>