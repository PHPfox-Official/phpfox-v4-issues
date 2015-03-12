<upgrade>
	<phpfox_update_phrases>
		<phrase>
			<module_id>photo</module_id>
			<version_id>2.0.0alpha3</version_id>
			<var_name>setting_rename_uploaded_photo_names</var_name>
			<added>1239041807</added>
			<value><![CDATA[<title>Rename Photo Names</title><info>Set to <b>True</b> if you would like to rename a photo based on what the title of the photo or the title provided by the user when processing their recently uploaded photos. By default we use a 32 character unique hash to protect images, however enabling this feature will still create a unique ID for each image and help with image SEO.

<b>Notice:</b> Apache "mod_rewrite" will have to be enabled to use this feature. Once you have enabled this feature you must edit the file ".htaccess" find in your sites root directory.

Look for the following in that file:
[code]
# Rename Photo Names
[/code]
Under that line you will find 2 lines that have been commented out. Simply uncomment those 2 lines by removing the hash "#" symbol.
</info>]]></value>
		</phrase>
	</phpfox_update_phrases>
</upgrade>