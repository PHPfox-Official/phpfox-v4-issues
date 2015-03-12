<module>
	<data>
		<module_id>link</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_link</phrase_var_name>
		<writable />
	</data>
	<hooks>
		<hook module_id="link" hook_type="component" module="link" call_name="link.component_ajax_addviastatusupdate" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="link" hook_type="component" module="link" call_name="link.component_block_attach_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="link" hook_type="component" module="link" call_name="link.component_block_display_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="link" hook_type="component" module="link" call_name="link.component_block_preview_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="link" hook_type="component" module="link" call_name="link.component_block_share_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="link" hook_type="controller" module="link" call_name="link.component_controller_index_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="link" hook_type="service" module="link" call_name="link.service_callback__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="link" hook_type="service" module="link" call_name="link.service_link__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="link" hook_type="service" module="link" call_name="link.service_process__call" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="link" hook_type="service" module="link" call_name="link.component_service_callback_getactivityfeed__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="link" hook_type="service" module="link" call_name="link.service_callback_checkfeedsharelink" added="1358258443" version_id="3.5.0beta1" />
	</hooks>
	<feed_share>
		<share module_id="link" title="{phrase var='link.link'}" description="{phrase var='link.say_something_about_this_link'}" block_name="share" no_input="0" is_frame="0" ajax_request="addViaStatusUpdate" no_profile="0" icon="link.png" ordering="3" />
	</feed_share>
	<phrases>
		<phrase module_id="link" version_id="3.0.0Beta1" var_name="module_link" added="1295707931">Link</phrase>
		<phrase module_id="link" version_id="3.0.0Beta1" var_name="link" added="1302203071">Link</phrase>
		<phrase module_id="link" version_id="3.0.0Beta1" var_name="say_something_about_this_link" added="1302203078">Say something about this link...</phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="viewing_video" added="1319121883">Viewing Video</phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="attach_a_link" added="1319121895">Attach a Link</phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="paste_a_link_you_would_like_to_attach" added="1319122579">Paste a link you would like to attach.</phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="cancel" added="1319122589">Cancel</phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="attach" added="1319188035">Attach</phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="attach_link" added="1319188715">Attach Link</phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="full_name_liked_your_link_title" added="1319468306"><![CDATA[{full_name} liked your link "{title}"]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="full_name_liked_your_link_title_message" added="1319468391"><![CDATA[{full_name} liked your link "<a href="{link}">{title}</a>"
To view this link follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="users_liked_gender_own_link_title" added="1319553707"><![CDATA[{users} liked {gender} own link "{title}"]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="users_liked_your_link_title" added="1319553748"><![CDATA[{users} liked your link "{title}"]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="users_liked_span_class_drop_data_user_row_full_name_s_span_link_title" added="1319553789"><![CDATA[{users} liked <span class="drop_data_user">{row_full_name}'s</span> link "{title}"]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="full_name_commented_on_your_link_title" added="1319553867"><![CDATA[{full_name} commented on your link "{title}".]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="full_name_commented_on_your_link_a_href_link_title_a" added="1319553935"><![CDATA[{full_name} commented on your link "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="full_name_commented_on_gender_link" added="1319553987">{full_name} commented on {gender} link.</phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="full_name_commented_on_row_full_name_s_link" added="1319554075"><![CDATA[{full_name} commented on {row_full_name}'s link.]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="full_name_commented_on_gender_link_a_href_link_title_a" added="1319554215"><![CDATA[{full_name} commented on {gender} link "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="full_name_commented_on_row_full_name_s_link_a_href_link_title_a_message" added="1319554332"><![CDATA[{full_name} commented on {row_full_name}'s link "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="unable_to_post_a_comment_on_this_item_due_to_privacy_settings" added="1319554378">Unable to post a comment on this item due to privacy settings.</phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="users_commented_on_gender_link_title" added="1319554548"><![CDATA[{users} commented on {gender} link "{title}"]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="users_commented_on_your_link_title" added="1319554584"><![CDATA[{users} commented on your link "{title}"]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="users_commented_on_span_class_drop_data_user_row_full_name_s_span_link_title" added="1319554623"><![CDATA[{users} commented on <span class="drop_data_user">{row_full_name}'s</span> link "{title}"]]></phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="who_can_share_a_link" added="1319554655">Who can share a link?</phrase>
		<phrase module_id="link" version_id="3.0.0beta5" var_name="who_can_view_browse_links" added="1319554666">Who can view/browse links?</phrase>
		<phrase module_id="link" version_id="3.0.0rc2" var_name="no_thumbnail" added="1321364565">No Thumbnail</phrase>
		<phrase module_id="link" version_id="3.0.0rc2" var_name="previous" added="1321364574">Previous</phrase>
		<phrase module_id="link" version_id="3.0.0rc2" var_name="next" added="1321364582">Next</phrase>
		<phrase module_id="link" version_id="3.0.0rc2" var_name="choose_a_thumbnail" added="1321364589">Choose a Thumbnail</phrase>
		<phrase module_id="link" version_id="3.0.0rc2" var_name="play" added="1321446647">Play</phrase>
		<phrase module_id="link" version_id="3.0.0" var_name="not_a_valid_link_unable_to_find_a_title" added="1323337809">Not a valid link. Unable to find a title.</phrase>
		<phrase module_id="link" version_id="3.0.0" var_name="unable_to_build_api_embed_ly_array_of_sites" added="1323337819">Unable to build api.embed.ly array of sites.</phrase>
		<phrase module_id="link" version_id="3.0.0" var_name="not_a_valid_link" added="1323337827">Not a valid link.</phrase>
		<phrase module_id="link" version_id="3.1.0" var_name="full_name_posted_a_link_on_your_wall" added="1332846924">{full_name} posted a link on your wall</phrase>
		<phrase module_id="link" version_id="3.1.0" var_name="full_name_posted_a_link_on_your_wall_message" added="1332847017"><![CDATA[{full_name} posted a link on your <a href="{link}">wall</a>.
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="link" version_id="3.4.0beta2" var_name="full_name_tagged_you_in_a_link" added="1348471963">{full_name} tagged you in a link.</phrase>
	</phrases>
	<tables><![CDATA[a:2:{s:11:"phpfox_link";a:3:{s:7:"COLUMNS";a:18:{s:7:"link_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:14:"parent_user_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:9:"is_custom";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:4:"link";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"image";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"description";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"status_info";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"has_embed";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"link_id";s:4:"KEYS";a:1:{s:14:"parent_user_id";a:2:{i:0;s:5:"INDEX";i:1;s:14:"parent_user_id";}}}s:17:"phpfox_link_embed";a:2:{s:7:"COLUMNS";a:2:{s:7:"link_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:10:"embed_code";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:7:"link_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:7:"link_id";}}}}]]></tables>
</module>