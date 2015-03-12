<module>
	<data>
		<module_id>like</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_like</phrase_var_name>
		<writable />
	</data>
	<settings>
		<setting group="" module_id="like" is_hidden="0" type="boolean" var_name="show_user_photos" phrase_var_name="setting_show_user_photos" ordering="1" version_id="3.3.0beta2">0</setting>
		<setting group="" module_id="like" is_hidden="0" type="boolean" var_name="allow_dislike" phrase_var_name="setting_allow_dislike" ordering="1" version_id="3.5.0beta1">0</setting>
	</settings>
	<hooks>
		<hook module_id="like" hook_type="component" module="like" call_name="like.component_block_browse_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="like" hook_type="component" module="like" call_name="like.component_block_link_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="like" hook_type="controller" module="like" call_name="like.component_controller_index_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="like" hook_type="service" module="like" call_name="like.service_callback__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="like" hook_type="service" module="like" call_name="like.service_like__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="like" hook_type="service" module="like" call_name="like.service_process__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="like" hook_type="service" module="like" call_name="like.service_process_add__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="like" hook_type="service" module="like" call_name="like.service_process_delete__1" added="1335951260" version_id="3.2.0" />
	</hooks>
	<phrases>
		<phrase module_id="like" version_id="2.1.0Beta1" var_name="module_like" added="1293004519">Like</phrase>
		<phrase module_id="like" version_id="3.0.0beta5" var_name="you" added="1319121089">You</phrase>
		<phrase module_id="like" version_id="3.0.0beta5" var_name="you_and" added="1319121111">You and</phrase>
		<phrase module_id="like" version_id="3.0.0beta5" var_name="you_comma" added="1319121128">You,</phrase>
		<phrase module_id="like" version_id="3.0.0beta5" var_name="and" added="1319121140">and</phrase>
		<phrase module_id="like" version_id="3.0.0beta5" var_name="1_other_person" added="1319121152">1 other person</phrase>
		<phrase module_id="like" version_id="3.0.0beta5" var_name="others" added="1319121160">others</phrase>
		<phrase module_id="like" version_id="3.0.0beta5" var_name="like_this" added="1319121169">like this.</phrase>
		<phrase module_id="like" version_id="3.0.0beta5" var_name="likes_this" added="1319121177">likes this.</phrase>
		<phrase module_id="like" version_id="3.0.0beta5" var_name="1_person" added="1319121390">1 person</phrase>
		<phrase module_id="like" version_id="3.0.0beta5" var_name="total_people" added="1319121408">{total} people</phrase>
		<phrase module_id="like" version_id="3.0.0beta5" var_name="members" added="1319122349">Members</phrase>
		<phrase module_id="like" version_id="3.0.0beta5" var_name="people_who_like_this" added="1319122357">People who like this</phrase>
		<phrase module_id="like" version_id="3.0.0" var_name="nobody_likes_this" added="1323438376">Nobody likes this.</phrase>
		<phrase module_id="like" version_id="3.0.0" var_name="this_group_has_no_members" added="1323438391">This group has no members.</phrase>
		<phrase module_id="like" version_id="3.0.0" var_name="article_to_upper" added="1323687563" />
		<phrase module_id="like" version_id="3.0.0" var_name="article_to_lower" added="1323689277" />
		<phrase module_id="like" version_id="3.0.0" var_name="you_like" added="1323786728">like this</phrase>
		<phrase module_id="like" version_id="3.0.1" var_name="notification_for_likes" added="1327479557"><![CDATA[Notification for "Likes"]]></phrase>
		<phrase module_id="like" version_id="3.3.0beta2" var_name="setting_show_user_photos" added="1340878575"><![CDATA[<title>Show User Photos</title><info>Enable this feature to show user photos instead of their names when displaying the "like" preview for each item.</info>]]></phrase>
		<phrase module_id="like" version_id="3.4.0" var_name="likes" added="1351494364">Likes</phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="users_disliked_gender_own_item_title" added="1352293257"><![CDATA[{users} disliked {gender} own {item} "{title}"]]></phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="users_disliked_your_item_title" added="1352293601"><![CDATA[{users} disliked your {item} "{title}"]]></phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="users_disliked_users_item" added="1352293889"><![CDATA[{users} disliked <span class="drop_data_user">{row_full_name}&#039;s</span> {item} "{title}"]]></phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="users_disliked_users_item_email" added="1352296137"><![CDATA[{full_name} disliked your {item} "<a href="{link}">{title}</a>"
To view this {item} follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="disliked_many_users" added="1352727007">You and {votes_from_non_friends} others disliked this {item_type}</phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="disliked_you_and_one_more" added="1352727482">You and one other disliked this {item_type}</phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="dislike_you_disliked" added="1352727869">You disliked this {item_type}</phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="disliked_friends_and_you" added="1352729238">{my_friends} and you disliked this {item_type}</phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="dislike_friends_disliked_this" added="1352729413">{my_friends} disliked this {item_type}</phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="disliked_users_disliked_this" added="1352729536">{non_friends} disliked this {item_type}</phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="setting_allow_dislike" added="1355132881"><![CDATA[<title>Allow Dislike</title><info>Allow users to dislike items?</info>]]></phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="unlike" added="1356619649">unlike</phrase>
		<phrase module_id="like" version_id="3.5.0beta1" var_name="like" added="1356621184">like</phrase>
		<phrase module_id="like" version_id="3.5.0" var_name="like_uppercase" added="1361783897">Like</phrase>
		<phrase module_id="like" version_id="3.5.0" var_name="unlike_uppercase" added="1361783926">Unlike</phrase>
		<phrase module_id="like" version_id="3.5.0" var_name="dislike" added="1361783942">Dislike</phrase>
		<phrase module_id="like" version_id="3.5.0" var_name="undislike" added="1361783968">Undislike</phrase>
		<phrase module_id="like" version_id="3.5.0" var_name="remove" added="1361801562">Remove</phrase>
		<phrase module_id="like" version_id="3.6.0rc1" var_name="people_who_disliked_this" added="1371744168">People who disliked this</phrase>
	</phrases>
	<tables><![CDATA[a:3:{s:11:"phpfox_like";a:3:{s:7:"COLUMNS";a:5:{s:7:"like_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"type_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"like_id";s:4:"KEYS";a:4:{s:7:"type_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"type_id";i:1;s:7:"item_id";}}s:9:"type_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"type_id";i:1;s:7:"item_id";i:2;s:7:"user_id";}}s:9:"type_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"type_id";i:1;s:7:"user_id";}}s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"item_id";}}}s:17:"phpfox_like_cache";a:2:{s:7:"COLUMNS";a:3:{s:7:"type_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:9:"type_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"type_id";i:1;s:7:"item_id";i:2;s:7:"user_id";}}}}s:13:"phpfox_action";a:3:{s:7:"COLUMNS";a:6:{s:9:"action_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:14:"action_type_id";a:4:{i:0;s:5:"USINT";i:1;s:1:"2";i:2;s:0:"";i:3;s:2:"NO";}s:12:"item_type_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:9:"action_id";s:4:"KEYS";a:4:{s:7:"type_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:12:"item_type_id";i:1;s:7:"item_id";}}s:9:"type_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:12:"item_type_id";i:1;s:7:"item_id";i:2;s:7:"user_id";}}s:9:"type_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:12:"item_type_id";i:1;s:7:"user_id";}}s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"item_id";}}}}]]></tables>
</module>