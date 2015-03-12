<upgrade>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>owner_full_name_commented_on_full_names_feed</var_name>
			<added>1256492983</added>
			<value><![CDATA[<a href="{owner_link}">{owner_full_name}</a> commented on <a href="{viewer_link}">{viewer_full_name}'s <a href="{link}">feed</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>a_href_owner_link_owner_full_name_a_commented_on_their_own_a_href_link_feed_a</var_name>
			<added>1256493985</added>
			<value><![CDATA[<a href="{owner_link}">{owner_full_name}</a> commented on their own <a href="{link}">feed</a>.]]></value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>write_a_comment</var_name>
			<added>1256502047</added>
			<value>Write a comment...</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>loading</var_name>
			<added>1256542012</added>
			<value>Loading...</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>hide</var_name>
			<added>1256542058</added>
			<value>Hide</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>viewing_feed_with_a_comment_id</var_name>
			<added>1256660407</added>
			<value>Viewing Feed with a Comment: #{id}</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>viewing_feed_id</var_name>
			<added>1256660424</added>
			<value>Viewing Feed: #{id}</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>view_all</var_name>
			<added>1256660461</added>
			<value>View All</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>full_name_commented_on_their_own_profile</var_name>
			<added>1256661031</added>
			<value><![CDATA[<a href="{user_link}">{full_name}</a> wrote on their own <a href="{user_link}">profile</a>.]]></value>
		</phrase>
	</phrases>
	<phpfox_update_blocks>
		<block>
			<m_connection>core.index-member</m_connection>
			<module_id>feed</module_id>
			<component>display</component>
			<location>2</location>
			<is_active>1</is_active>
			<ordering>11</ordering>
			<can_move>1</can_move>
			<value />
		</block>
	</phpfox_update_blocks>
	<update_templates>
		<file type="block">entry.html.php</file>
		<file type="block">display.html.php</file>
	</update_templates>
</upgrade>