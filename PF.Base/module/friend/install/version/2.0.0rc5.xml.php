<upgrade>
	<phrases>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>mutual_friends</var_name>
			<added>1256236952</added>
			<value>Mutual Friends</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>1_friend_in_common</var_name>
			<added>1256237194</added>
			<value>1 friend in common</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>total_friends_in_common</var_name>
			<added>1256237212</added>
			<value>{total} friends in common</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>friends_online</var_name>
			<added>1256239756</added>
			<value>Friends Online</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>suggestions</var_name>
			<added>1256241942</added>
			<value>Suggestions</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>add_to_friends</var_name>
			<added>1256252043</added>
			<value>Add to Friends</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>friend_suggestions</var_name>
			<added>1256304055</added>
			<value>Friend Suggestions</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>mutual_friends_will_be_listed_here</var_name>
			<added>1256308926</added>
			<value>Mutual friends will be listed here.</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>videos</var_name>
			<added>1256373148</added>
			<value>Videos</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>that_s_you</var_name>
			<added>1256630526</added>
			<value><![CDATA[That's You!]]></value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>the_following_users_are_already_a_member_of_our_community</var_name>
			<added>1256630550</added>
			<value>The following users are already a member of our community</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>requests</var_name>
			<added>1256648176</added>
			<value>Requests</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>you_do_not_have_any_friends_requests_at_the_moment</var_name>
			<added>1256650329</added>
			<value>You do not have any friends requests at the moment.</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>menu_friends_requests</var_name>
			<added>1256650846</added>
			<value>Friends Requests</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>view_friend_request_id</var_name>
			<added>1256664976</added>
			<value>View Friend Request: #{id}</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>viewing_friends_request_id</var_name>
			<added>1256664985</added>
			<value>Viewing Friends Request: #{id}</value>
		</phrase>
		<phrase>
			<module_id>friend</module_id>
			<version_id>2.0.0rc4</version_id>
			<var_name>you_have_denied_user_link_s_friends_request</var_name>
			<added>1256665043</added>
			<value><![CDATA[You have denied {user_link}'s friends request.]]></value>
		</phrase>
	</phrases>
	<menus>
		<menu>
			<module_id>friend</module_id>
			<parent_id>0</parent_id>
			<m_connection>friend</m_connection>
			<var_name>menu_friends_requests</var_name>
			<ordering>91</ordering>
			<url_value>friend.accept</url_value>
			<version_id>2.0.0rc4</version_id>
			<disallow_access />
			<module>friend</module>
			<value />
		</menu>
	</menus>
	<components>
		<component>
			<module_id>friend</module_id>
			<component>mutual-friend</component>
			<m_connection />
			<module>friend</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
		<component>
			<module_id>friend</module_id>
			<component>suggestion</component>
			<m_connection />
			<module>friend</module>
			<is_controller>0</is_controller>
			<is_block>1</is_block>
			<is_active>1</is_active>
			<value />
		</component>
	</components>
	<blocks>
		<block>
			<m_connection>profile.index</m_connection>
			<module_id>friend</module_id>
			<component>mutual-friend</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>105</ordering>
			<can_move>1</can_move>
			<value />
		</block>
		<block>
			<m_connection>core.index-member</m_connection>
			<module_id>friend</module_id>
			<component>suggestion</component>
			<location>1</location>
			<is_active>0</is_active>
			<ordering>3</ordering>
			<can_move>1</can_move>
			<value />
		</block>
	</blocks>
	<phpfox_update_blocks>
		<block>
			<m_connection>core.index-member</m_connection>
			<module_id>friend</module_id>
			<component>mini</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>4</ordering>
			<can_move>1</can_move>
			<value />
		</block>
		<block>
			<m_connection>core.index-member</m_connection>
			<module_id>friend</module_id>
			<component>birthday</component>
			<location>1</location>
			<is_active>1</is_active>
			<ordering>7</ordering>
			<can_move>1</can_move>
			<value />
		</block>
	</phpfox_update_blocks>
	<update_templates>
		<file type="controller">index.html.php</file>
		<file type="controller">profile.html.php</file>
		<file type="block">menu.html.php</file>
		<file type="block">request.html.php</file>
		<file type="block">accept.html.php</file>
	</update_templates>
</upgrade>