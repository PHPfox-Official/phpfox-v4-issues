<module>
	<data>
		<module_id>emoticon</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_emoticon</phrase_var_name>
		<writable><![CDATA[a:2:{i:0;s:18:"file/pic/emoticon/";i:1;s:26:"file/pic/emoticon/default/";}]]></writable>
	</data>
	<hooks>
		<hook module_id="emoticon" hook_type="component" module="emoticon" call_name="emoticon.component_block_preview_process" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="emoticon" hook_type="component" module="emoticon" call_name="emoticon.component_block_preview_clean" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="emoticon" hook_type="service" module="emoticon" call_name="emoticon.service_emoticon_getpreview_start" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="emoticon" hook_type="service" module="emoticon" call_name="emoticon.service_emoticon_getpreview_end" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="emoticon" hook_type="service" module="emoticon" call_name="emoticon.service_emoticon__call" added="1231838390" version_id="2.0.0alpha1" />
		<hook module_id="emoticon" hook_type="controller" module="emoticon" call_name="emoticon.component_controller_admincp_file_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="emoticon" hook_type="service" module="emoticon" call_name="emoticon.service_callback__call" added="1319729453" version_id="3.0.0rc1" />
	</hooks>
	<components>
		<component module_id="emoticon" component="ajax" m_connection="" module="emoticon" is_controller="0" is_block="0" is_active="1" />
		<component module_id="emoticon" component="preview" m_connection="" module="emoticon" is_controller="0" is_block="1" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="emoticon" version_id="2.0.0alpha1" var_name="module_emoticon" added="1218117503">Emoticons</phrase>
		<phrase module_id="emoticon" version_id="2.0.0alpha1" var_name="emoticons" added="1218117524">Emoticons</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc1" var_name="import_export_emoticon" added="1248619759">Import Emoticons</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="package_successfully_updated" added="1254388768">Package successfully updated.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="package_successfully_added" added="1254388782">Package successfully added.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="edit_package" added="1254388798">Edit Package</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="add_package" added="1254388814">Add Package</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="package_successfully_deleted" added="1254388860">Package successfully deleted.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="emoticon_successfully_deleted" added="1254388893">Emoticon successfully deleted.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="emoticon_successfully_updated" added="1254388906">Emoticon successfully updated.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="emoticon_successfully_added" added="1254388920">Emoticon successfully added.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="edit_emoticon" added="1254388930">Edit Emoticon</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="add_emoticon" added="1254388967">Add Emoticon</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="emoticon_package_successfully_created" added="1254389056">Emoticon package successfully created. Imported: {success} - Failed: {failed}</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="import_emoticons" added="1254389088">Import Emoticons</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="package_does_not_exist" added="1254389236">Package does not exist.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="emoticons_successfully_updated" added="1254389246">Emoticons successfully updated.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="view_emoticon_package" added="1254389255">View Emoticon Package</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="view_package" added="1254389277">View Package</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="emoticon_package_not_found" added="1254389313">Emoticon package not found.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="select_a_module" added="1254389331">Select a module.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="provide_a_emoticon_symbol" added="1254389381">Provide a emoticon symbol.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="define_a_path_for_the_package" added="1254389405">Define a path for the package.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="symbol_already_exists" added="1254389419">Symbol already exists.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="image_could_not_be_uploaded" added="1254389432">Image could not be uploaded.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="please_fill_in_the_package_name_field" added="1254389445">Please fill in the package name field.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="path_is_not_writable_and_the_folder_could_not_be_created" added="1254389476">{path} is not writable and the folder could not be created.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="not_a_valid_emoticon_package" added="1254389502">Not a valid emoticon package.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="unable_to_import_emoticon_package" added="1254389512">Unable to import emoticon package.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="name" added="1254389561">Name</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="mass_import" added="1254389571">Mass Import</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="you_can_optionally_mass_import_emoticons_from_a_zip_package" added="1254389591">You can optionally mass import emoticons from a ZIP package. All emoticons must be located within the root directory of the ZIP package in order for a successful import.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="add" added="1254389619">Add</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="package_details" added="1254389637">Package Details</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="packages" added="1254389649">Packages</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="active" added="1254389668">Active</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="view_emoticons" added="1254389677">View Emoticons</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="export_package" added="1254389696">Export Package</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="delete_package" added="1254389704">Delete Package</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="are_you_sure" added="1254389714">Are you sure?</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="deactivate" added="1254389727">Deactivate</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="activate" added="1254389733">Activate</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="no_emoticons_in_this_package" added="1254389744">No emoticons in this package.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="emoticon_details" added="1254389762">Emoticon Details</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="package" added="1254389776">Package</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="image" added="1254389788">Image</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="title" added="1254389795">Title</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="symbol" added="1254389802">Symbol</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="edit" added="1254389813">Edit</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="import" added="1254389831">Import</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="file" added="1254389839">File</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="zip_package_only_and_must_have_a_similar_name_structure" added="1254389853"><![CDATA[ZIP package only and must have a similar name structure: <i>productname</i>-emoticon-<i>packagename</i>.zip]]></phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="overwrite" added="1254389861">Overwrite</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="yes" added="1254389868">Yes</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="no" added="1254389874">No</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="delete_emoticon" added="1254389940">Delete Emoticon</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="this_package_contains_no_emoticons" added="1254389956">This package contains no emoticons.</phrase>
		<phrase module_id="emoticon" version_id="2.0.0rc3" var_name="update" added="1254389964">Update</phrase>
		<phrase module_id="emoticon" version_id="2.0.5" var_name="not_a_valid_emoticon_package_to_import" added="1273153931">Not a valid emoticon package to import.</phrase>
		<phrase module_id="emoticon" version_id="2.0.5" var_name="xml_files_only_and_must" added="1273153948">XML files only and must have a similar name structure: productname-emoticon-packagename.xml</phrase>
	</phrases>
	<tables><![CDATA[a:2:{s:15:"phpfox_emoticon";a:3:{s:7:"COLUMNS";a:6:{s:11:"emoticon_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:8:"CHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"text";a:4:{i:0;s:9:"VCHAR:200";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"image";a:4:{i:0;s:8:"CHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:12:"package_path";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:11:"emoticon_id";s:4:"KEYS";a:2:{s:4:"text";a:2:{i:0;s:6:"UNIQUE";i:1;a:2:{i:0;s:4:"text";i:1;s:12:"package_path";}}s:10:"package_id";a:2:{i:0;s:5:"INDEX";i:1;s:12:"package_path";}}}s:23:"phpfox_emoticon_package";a:2:{s:7:"COLUMNS";a:4:{s:12:"package_path";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"product_id";a:4:{i:0;s:8:"VCHAR:25";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:12:"package_name";a:4:{i:0;s:9:"VCHAR:100";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_active";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"1";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:2:{s:12:"package_path";a:2:{i:0;s:6:"UNIQUE";i:1;s:12:"package_path";}s:9:"is_active";a:2:{i:0;s:5:"INDEX";i:1;s:9:"is_active";}}}}]]></tables>
	<install><![CDATA[
		$aRows = array(
			array(
				'title' => 'Smile',
				'text' => ':)',
				'image' => 'smile.png',
				'ordering' => '1',
				'package_path' => 'default'
			),	
			array(
				'title' => 'Evilgrin',
				'text' => '>;->',
				'image' => 'evilgrin.png',
				'ordering' => '2',
				'package_path' => 'default'
			),
			array(
				'title' => 'Happy',
				'text' => ':-)',
				'image' => 'happy.png',
				'ordering' => '3',
				'package_path' => 'default'
			),
			array(
				'title' => 'Wink',
				'text' => ';)',
				'image' => 'wink.png',
				'ordering' => '4',
				'package_path' => 'default'
			),
			array(
				'title' => 'Tongue',
				'text' => ':P',
				'image' => 'tongue.png',
				'ordering' => '5',
				'package_path' => 'default'
			),
			array(
				'title' => 'Unhappy',
				'text' => ':(',
				'image' => 'unhappy.png',
				'ordering' => '6',
				'package_path' => 'default'
			),
			array(
				'title' => 'Surprised',
				'text' => '=:o',
				'image' => 'surprised.png',
				'ordering' => '7',
				'package_path' => 'default'
			),
			array(
				'title' => 'Grin',
				'text' => ':>',
				'image' => 'grin.png',
				'ordering' => '8',
				'package_path' => 'default'
			)			
		);
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('emoticon'), $aInsert);

		}
					$aPackage = array(
				'package_path' => 'default',
				'product_id' => 'phpfox',
				'package_name' => 'default',
				'is_active' => 1
			);
			$this->database()->insert(Phpfox::getT('emoticon_package'), $aPackage);
	]]></install>
</module>