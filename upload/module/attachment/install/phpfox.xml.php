<module>
	<data>
		<module_id>attachment</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:2:{s:34:"attachment.admin_menu_manage_types";a:1:{s:3:"url";a:1:{i:0;s:10:"attachment";}}s:34:"attachment.admin_menu_add_new_type";a:1:{s:3:"url";a:2:{i:0;s:10:"attachment";i:1;s:3:"add";}}}]]></menu>
		<phrase_var_name>module_attachment</phrase_var_name>
		<writable><![CDATA[a:1:{i:0;s:16:"file/attachment/";}]]></writable>
	</data>
	<settings>
		<setting group="" module_id="attachment" is_hidden="0" type="array" var_name="attachment_valid_images" phrase_var_name="setting_attachment_valid_images" ordering="0" version_id="2.0.0alpha1"><![CDATA[s:35:"array('gif', 'jpg', 'jpeg', 'png');";]]></setting>
		<setting group="" module_id="attachment" is_hidden="0" type="integer" var_name="attachment_max_thumbnail" phrase_var_name="setting_attachment_max_thumbnail" ordering="0" version_id="2.0.0alpha1">120</setting>
		<setting group="" module_id="attachment" is_hidden="0" type="integer" var_name="attachment_max_medium" phrase_var_name="setting_attachment_max_medium" ordering="0" version_id="2.0.0alpha1">400</setting>
		<setting group="" module_id="attachment" is_hidden="1" type="integer" var_name="attachment_upload_bars" phrase_var_name="setting_attachment_upload_bars" ordering="0" version_id="2.0.0alpha1">4</setting>
		<setting group="" module_id="attachment" is_hidden="1" type="boolean" var_name="attachment_enable_mass_uploader" phrase_var_name="setting_attachment_enable_mass_uploader" ordering="1" version_id="2.0.8">0</setting>
	</settings>
	<hooks>
		<hook module_id="attachment" hook_type="component" module="attachment" call_name="attachment.component_block_list_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="component" module="attachment" call_name="attachment.component_block_list_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="component" module="attachment" call_name="attachment.component_block_upload_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="component" module="attachment" call_name="attachment.component_block_add_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="component" module="attachment" call_name="attachment.component_block_current_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_attachment___construct" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_attachment_get_count" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_attachment_select" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_attachment_getforitemedit_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_attachment_getforitemedit_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_attachment_getfordownload" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_attachment_hasaccess_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_attachment_hasaccess_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_attachment__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_type___construct" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_type__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_process_add" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_process_updatecounter" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_process_updateinline" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_process_deleteforitem" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_process_delete" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_process_updateitemcount_category" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_process_updateitemcount" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_process__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="attachment" hook_type="controller" module="attachment" call_name="attachment.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="attachment" hook_type="service" module="attachment" call_name="attachment.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="attachment" hook_type="controller" module="attachment" call_name="attachment.component_controller_admincp_index_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="attachment" hook_type="controller" module="attachment" call_name="attachment.component_controller_admincp_add_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="attachment" hook_type="component" module="attachment" call_name="attachment.component_block_share_clean" added="1319729453" version_id="3.0.0rc1" />
	</hooks>
	<components>
		<component module_id="attachment" component="ajax" m_connection="" module="attachment" is_controller="0" is_block="0" is_active="1" />
		<component module_id="attachment" component="add" m_connection="" module="attachment" is_controller="0" is_block="1" is_active="1" />
		<component module_id="attachment" component="upload" m_connection="" module="attachment" is_controller="0" is_block="1" is_active="1" />
		<component module_id="attachment" component="frame" m_connection="attachment.frame" module="attachment" is_controller="1" is_block="0" is_active="1" />
		<component module_id="attachment" component="current" m_connection="" module="attachment" is_controller="0" is_block="1" is_active="1" />
		<component module_id="attachment" component="archive" m_connection="" module="attachment" is_controller="0" is_block="1" is_active="1" />
		<component module_id="attachment" component="list" m_connection="" module="attachment" is_controller="0" is_block="1" is_active="1" />
		<component module_id="attachment" component="download" m_connection="attachment.download" module="attachment" is_controller="1" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="user_setting_points_attachment" added="1214982452">Points received when adding a new attachment for an item.</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="user_setting_can_attach_on_blog" added="1214982579">Can attach items on blogs?</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="user_setting_attachment_limit" added="1214982711"><![CDATA[Specify the attachment limit.

This will control how many attachments a user can upload and attach on other items.

If you do not want to allow users the ability to upload items set this to <b>0</b>.

If you do not want to set a limit set this to <b>null</b>.]]></phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="user_setting_delete_own_attachment" added="1218706131">Can delete their own attachments?</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="user_setting_delete_user_attachment" added="1218706185">Can delete attachments added by other users?</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="module_attachment" added="1213971163">Attachment Information</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="file_extension_is_not_valid" added="1212128638">Failed. File extension is not valid.</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="done" added="1212128667">Done!</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="uploading" added="1212128993">Uploading</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="attached_files" added="1215267860">Attached Files</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="views" added="1215268272">{total} views</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="attach_files" added="1218197611">Attach Files</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="upload_new_attachment" added="1218533823">Upload New Attachment(s)</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="browse_archives" added="1218533834">Browse Archives</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="current_attachments" added="1218533856">Current Attachments</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="attachments" added="1218533866">No attachments</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="upload_attachments" added="1218533908">Upload Attachments(s)</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="add_more_attachments" added="1218533925">Add More Attachments</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="valid_file_extensions" added="1218533937">Valid file extensions</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="cancel" added="1218533951">Cancel</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="add_description" added="1218534271">Add Description...</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="use_inline_full_image" added="1218534304">Use Inline (Full Image)</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="use_inline_thumbnail" added="1218534316">Use Inline (Thumbnail)</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="use_inline" added="1218534331">Use Inline</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="delete" added="1218534340">Delete</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="you_have_reached_your_upload_limit" added="1218633812">You have reached your upload limit.</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="failed_limit_reached" added="1218705195">Failed: Limit Reached</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="usage" added="1218705232">Usage</phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="setting_test" added="1230599222"><![CDATA[<title>This is a test</title><info>this is just a test...</info>]]></phrase>
		<phrase module_id="attachment" version_id="2.0.0alpha1" var_name="user_setting_can_attach_on_bulletin" added="1234186901">Tells if the members of this usergroup can attach to their bulletins</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc1" var_name="user_setting_item_max_upload_size" added="1249942555"><![CDATA[Max file size for items upload in kilobits (kb).
(1000 kb = 1 mb)
For unlimited add "0" without quotes.]]></phrase>
		<phrase module_id="attachment" version_id="2.0.0rc1" var_name="admincp_attachment_menu" added="1250836473">Attachments</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc1" var_name="admincp_menu_attachment_types" added="1250836515">Manage Types</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc1" var_name="admincp_menu_attachment_add" added="1250844995">Add a Type</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="attachment_type_successfully_updated" added="1252922216">Attachment type successfully updated.</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="attachment_type_successfully_added" added="1252922228">Attachment type successfully added.</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="attachments_title" added="1252922250">Attachments</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="add_an_attachment_type" added="1252922262">Add an Attachment Type</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="editing_an_attachment_type" added="1252922270">Editing an Attachment Type</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="no_such_download_found" added="1252922297">No such download found.</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="successfully_uploaded" added="1252922318">Successfully uploaded!</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="provide_an_extension" added="1252922399">Provide an extension.</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="provide_a_mime_type" added="1252922407">Provide a MIME type.</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="remove_inline" added="1252922486">Remove Inline</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="use_image" added="1252922498">Use Image</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="no_attachments_available" added="1252922592">No attachments available.</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="jpg_gif_or_png" added="1252922647">JPG, GIF or PNG</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="the_file_size_limit_is_max_file_size" added="1252922669">The file size limit is {max_file_size}. If your upload does not work, try uploading a smaller item.</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="attachment_type_info" added="1252926402">Attachment Type Info</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="extension" added="1252926409">Extension</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="mime_type" added="1252926418">MIME Type</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="is_image" added="1252926429">Is Image</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="image" added="1252926531">Image</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc2" var_name="this_extension_already_exists" added="1253442098">This extension already exists.</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc6" var_name="admin_menu_manage_types" added="1256904823">Manage Types</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc6" var_name="admin_menu_add_new_type" added="1256904823">Add New Type</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc8" var_name="attachment_activity" added="1258500262">Attachments</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc8" var_name="select_attachment_s_to_upload" added="1259007508">Select attachment(s) to upload.</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc8" var_name="uploading_attachment_s" added="1259007526">Uploading attachment(s)</phrase>
		<phrase module_id="attachment" version_id="2.0.0rc10" var_name="done_normal" added="1259353842">Done</phrase>
		<phrase module_id="attachment" version_id="2.0.4" var_name="attachments_activity" added="1266500120">Attachments</phrase>
		<phrase module_id="attachment" version_id="2.0.6" var_name="add" added="1283787543">Add</phrase>
		<phrase module_id="attachment" version_id="2.0.8" var_name="setting_attachment_enable_mass_uploader" added="1295623916"><![CDATA[<title>Enable Mass Uploader</title><info>When enabled users will be allowed to use a mass file uploader to select multiple files from a single file select dialog.

This uses an integration of SWFUpload (http://code.google.com/p/swfupload/) and thus it uses a Flash object.</info>]]></phrase>
		<phrase module_id="attachment" version_id="2.1.0beta2" var_name="you_are_not_allowed_to_download_this_attachment" added="1300960934">You are not allowed to download this attachment</phrase>
		<phrase module_id="attachment" version_id="3.0.0beta5" var_name="attach_a_photo" added="1319122207">Attach a Photo</phrase>
		<phrase module_id="attachment" version_id="3.0.0beta5" var_name="attach_a_video" added="1319122215">Attach a Video</phrase>
		<phrase module_id="attachment" version_id="3.0.0beta5" var_name="attach_a_file" added="1319122224">Attach a File</phrase>
		<phrase module_id="attachment" version_id="3.0.0beta5" var_name="manage_attachments" added="1319188363">Manage Attachments</phrase>
		<phrase module_id="attachment" version_id="3.0.0beta5" var_name="insert" added="1319188369">Insert</phrase>
		<phrase module_id="attachment" version_id="3.0.0beta5" var_name="insert_a_photo" added="1319188389">Insert a Photo</phrase>
		<phrase module_id="attachment" version_id="3.0.0beta5" var_name="attach_a_link" added="1319188405">Attach a Link</phrase>
		<phrase module_id="attachment" version_id="3.0.0beta5" var_name="insert_a_video" added="1319188421">Insert a Video</phrase>
		<phrase module_id="attachment" version_id="3.0.0beta5" var_name="insert_emoticon" added="1319188439">Insert Emoticon</phrase>
		<phrase module_id="attachment" version_id="3.0.0beta5" var_name="attachments_display" added="1319188457">Attachments</phrase>
		<phrase module_id="attachment" version_id="3.0.0beta5" var_name="upload_a_photo" added="1319188601">Upload a Photo</phrase>
		<phrase module_id="attachment" version_id="3.0.0beta5" var_name="import_a_photo" added="1319188614">Import a Photo</phrase>
		<phrase module_id="attachment" version_id="3.0.0rc2" var_name="attachments_headline" added="1321446098">Attachments</phrase>
		<phrase module_id="attachment" version_id="3.3.0beta2" var_name="converting" added="1340964309">Converting</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="attachment" type="integer" admin="1" user="1" guest="1" staff="1" module="attachment" ordering="2">points_attachment</setting>
		<setting is_admin_setting="0" module_id="attachment" type="boolean" admin="1" user="1" guest="0" staff="1" module="attachment" ordering="3">can_attach_on_blog</setting>
		<setting is_admin_setting="0" module_id="attachment" type="string" admin="null" user="null" guest="0" staff="null" module="attachment" ordering="1">attachment_limit</setting>
		<setting is_admin_setting="0" module_id="attachment" type="boolean" admin="1" user="1" guest="0" staff="1" module="attachment" ordering="0">delete_own_attachment</setting>
		<setting is_admin_setting="0" module_id="attachment" type="boolean" admin="1" user="0" guest="0" staff="1" module="attachment" ordering="0">delete_user_attachment</setting>
		<setting is_admin_setting="0" module_id="attachment" type="boolean" admin="1" user="1" guest="0" staff="1" module="attachment" ordering="0">can_attach_on_bulletin</setting>
		<setting is_admin_setting="0" module_id="attachment" type="integer" admin="0" user="500" guest="1" staff="0" module="attachment" ordering="0">item_max_upload_size</setting>
	</user_group_settings>
	<tables><![CDATA[a:2:{s:17:"phpfox_attachment";a:3:{s:7:"COLUMNS";a:18:{s:13:"attachment_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"category_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"link_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"file_name";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"file_size";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"destination";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"extension";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"description";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:14:"video_duration";a:4:{i:0;s:7:"VCHAR:8";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"is_inline";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"is_image";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"is_video";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"counter";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"server_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:13:"attachment_id";s:4:"KEYS";a:4:{s:11:"category_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:11:"category_id";i:1;s:7:"user_id";}}s:9:"extension";a:2:{i:0;s:5:"INDEX";i:1;s:9:"extension";}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:7:"item_id";i:2;s:11:"category_id";i:3;s:7:"user_id";}}}}s:22:"phpfox_attachment_type";a:2:{s:7:"COLUMNS";a:5:{s:9:"extension";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"mime_type";a:4:{i:0;s:9:"VCHAR:250";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"is_image";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"added";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:9:"extension";a:2:{i:0;s:5:"INDEX";i:1;s:9:"extension";}}}}]]></tables>
	<install><![CDATA[
		$aExtensions = array(
			array(
				'extension' => 'jpg',
				'mime_type' => 'image/jpeg',
				'is_active' => '1',
				'is_image' => '1',
				'added' => '1208637306'
			),
			array(
				'extension' => 'jpeg',
				'mime_type' => 'image/jpeg',
				'is_active' => '1',
				'is_image' => '1',
				'added' => '1208637306'
			),
			array(
				'extension' => 'gif',
				'mime_type' => 'image/gif',
				'is_active' => '1',
				'is_image' => '1',
				'added' => '1208637335'
			),
			array(
				'extension' => 'png',
				'mime_type' => 'image/png',
				'is_active' => '1',
				'is_image' => '1',
				'added' => '1212577320'
			),			
			array(
				'extension' => 'zip',
				'mime_type' => 'image/zip',
				'is_active' => '1',
				'is_image' => '1',
				'added' => '1212577320'
			)			
		);
		foreach ($aExtensions as $aExtension)
		{
			$this->database()->insert(Phpfox::getT('attachment_type'), array(
					'extension' => $aExtension['extension'],
					'mime_type' => $aExtension['mime_type'],
					'is_active' => $aExtension['is_active'],
					'is_image' => $aExtension['is_image'],
					'added' => $aExtension['added']
				)
			);
		}
	]]></install>
</module>