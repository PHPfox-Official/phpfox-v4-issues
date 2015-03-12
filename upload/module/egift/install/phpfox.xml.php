<module>
	<data>
		<module_id>egift</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:3:{s:34:"egift.admin_menu_manage_categories";a:1:{s:3:"url";a:2:{i:0;s:5:"egift";i:1;s:10:"categories";}}s:27:"egift.admin_menu_add_e_gifs";a:1:{s:3:"url";a:1:{i:0;s:5:"egift";}}s:25:"egift.admin_menu_invoices";a:1:{s:3:"url";a:2:{i:0;s:5:"egift";i:1;s:7:"invoice";}}}]]></menu>
		<phrase_var_name>module_egift</phrase_var_name>
		<writable><![CDATA[a:1:{i:0;s:15:"file/pic/egift/";}]]></writable>
	</data>
	<hooks>
		<hook module_id="egift" hook_type="service" module="egift" call_name="egift.service_callback__call" added="1299062480" version_id="2.0.8" />
		<hook module_id="egift" hook_type="service" module="egift" call_name="egift.service_egift__call" added="1299062480" version_id="2.0.8" />
		<hook module_id="egift" hook_type="service" module="egift" call_name="egift.service_process__call" added="1299062480" version_id="2.0.8" />
		<hook module_id="egift" hook_type="controller" module="egift" call_name="egift.component_controller_index_clean" added="1299062480" version_id="2.0.8" />
	</hooks>
	<phrases>
		<phrase module_id="egift" version_id="2.0.8" var_name="admin_menu_manage_categories" added="1298969183">Manage Categories</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="admin_menu_add_e_gifs" added="1298969183">Add E-Gifts</phrase>
		<phrase module_id="egift" version_id="" var_name="module_egift" added="1215331034">Egift</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="add_category" added="1299593126">Add Category</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="maange_categories" added="1299593151">Manage Categories</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="no_categories_found" added="1299593267">No categories found</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="edit_categories" added="1299593310">Edit Categories</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="category_optional" added="1299593847">Category (Optional)</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="egift_added_successfully" added="1299593951">Egift added successfully</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="egift_edited_successfully" added="1299593972">Egift edited successfully</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="egift_deleted_successfully" added="1299593988">Egift deleted successfully</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="add_egift" added="1299594058">Add Egift</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="title" added="1299594071">Title</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="choose_file" added="1299594082">Choose File</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="allowed_file_extensions_jpg_png_gif" added="1299594101">Allowed file extensions: jpg, png, gif.</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="uploading_a_picture_will_overwrite_the_current_one_for_this_item" added="1299594115">Uploading a picture will overwrite the current one for this item</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="upload" added="1299594127">Upload</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="choose_category" added="1299594156">Choose Category</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="price" added="1299594169">Price</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="manage_egifts" added="1299594209">Manage Egifts</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="category" added="1299594234">Category</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="no_gifts_have_been_added" added="1299594277">No gifts have been added</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="thank_you_for_your_purchase" added="1299594330">Thank you for your purchase.</phrase>
		<phrase module_id="egift" version_id="2.0.8" var_name="admin_menu_invoices" added="1299599121">Invoices</phrase>
		<phrase module_id="egift" version_id="3.0.0" var_name="category_added_successfully" added="1323088136">Category added successfully</phrase>
		<phrase module_id="egift" version_id="3.0.0" var_name="update_successfully" added="1323088147">Update successfully</phrase>
		<phrase module_id="egift" version_id="3.0.0" var_name="delete_successfully" added="1323088160">Delete successfully</phrase>
		<phrase module_id="egift" version_id="3.1.0beta1" var_name="edit_egift" added="1331655588">Edit Egift</phrase>
		<phrase module_id="egift" version_id="3.1.0rc1" var_name="available_since" added="1332239978">Available since</phrase>
		<phrase module_id="egift" version_id="3.1.0rc1" var_name="available_until" added="1332239990">Available until</phrase>
		<phrase module_id="egift" version_id="3.1.0rc1" var_name="schedule_availability" added="1332240012">Schedule Availability</phrase>
		<phrase module_id="egift" version_id="3.1.0rc1" var_name="egift_category_6" added="1332241418">Birthday</phrase>
		<phrase module_id="egift" version_id="3.1.0rc1" var_name="egift_category_7" added="1332241460">Birthday $1</phrase>
		<phrase module_id="egift" version_id="3.1.0rc1" var_name="egift_category_8" added="1332241833">Hanuka in March</phrase>
		<phrase module_id="egift" version_id="3.1.0rc1" var_name="since" added="1332245596">Since</phrase>
		<phrase module_id="egift" version_id="3.1.0rc1" var_name="until" added="1332245614">Until</phrase>
		<phrase module_id="egift" version_id="3.1.0rc1" var_name="use_schedule" added="1332245628">Use Schedule</phrase>
		<phrase module_id="egift" version_id="3.1.0rc1" var_name="when_disabled_this_category_will_only_show_up_on_birthdays" added="1332245773">When disabled this category will only show up on birthdays</phrase>
		<phrase module_id="egift" version_id="3.3.0beta1" var_name="you_can_choose_an_egift_to_send" added="1338889552">You can choose an egift to send with your message below.</phrase>
	</phrases>
	<tables><![CDATA[a:3:{s:12:"phpfox_egift";a:3:{s:7:"COLUMNS";a:7:{s:8:"egift_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"file_path";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"category_id";a:4:{i:0;s:6:"TINT:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"price";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"egift_id";s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:21:"phpfox_egift_category";a:2:{s:7:"COLUMNS";a:5:{s:11:"category_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:6:"phrase";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"ordering";a:4:{i:0;s:7:"UINT:11";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_start";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"time_end";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:11:"category_id";}s:20:"phpfox_egift_invoice";a:2:{s:7:"COLUMNS";a:10:{s:10:"invoice_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:9:"user_from";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_to";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"egift_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"birthday_id";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"currency_id";a:4:{i:0;s:6:"CHAR:3";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"price";a:4:{i:0;s:10:"DECIMAL:14";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:18:"time_stamp_created";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:15:"time_stamp_paid";a:4:{i:0;s:7:"UINT:11";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:6:"status";a:4:{i:0;s:8:"VCHAR:20";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:10:"invoice_id";}}]]></tables>
</module>