<upgrade>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.1.0beta1</version_id>
			<var_name>full_name_wrote_a_comment_on_your_wall</var_name>
			<added>1331645835</added>
			<value>{full_name} wrote a comment on your wall.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>3.1.0beta1</version_id>
			<var_name>full_name_wrote_a_comment_on_your_wall_message</var_name>
			<added>1331646391</added>
			<value><![CDATA[{full_name} wrote a comment on your <a href="{link}">wall</a>.
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></value>
		</phrase>
	</phrases>
	<sql><![CDATA[a:2:{s:9:"ADD_FIELD";a:1:{s:11:"phpfox_feed";a:1:{s:14:"feed_reference";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}}s:9:"ALTER_KEY";a:1:{s:11:"phpfox_feed";a:5:{s:9:"privacy_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"privacy";i:1;s:10:"time_stamp";i:2;s:14:"feed_reference";}}s:9:"privacy_3";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"privacy";i:1;s:7:"user_id";i:2;s:14:"feed_reference";}}s:9:"privacy_4";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"privacy";i:1;s:14:"parent_user_id";i:2;s:14:"feed_reference";}}s:7:"type_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"type_id";i:1;s:7:"item_id";i:2;s:14:"feed_reference";}}s:7:"privacy";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"privacy";i:1;s:7:"user_id";i:2;s:10:"time_stamp";i:3;s:14:"feed_reference";}}}}}]]></sql>
</upgrade>