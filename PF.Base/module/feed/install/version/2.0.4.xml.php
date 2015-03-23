<upgrade>
	<phrases>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.4</version_id>
			<var_name>successfully_added_your_comment</var_name>
			<added>1267542907</added>
			<value>Successfully added your comment</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.4</version_id>
			<var_name>successfully_liked_this_feed</var_name>
			<added>1267542946</added>
			<value>Successfully liked this feed</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.4</version_id>
			<var_name>successfully_unliked_this_feed</var_name>
			<added>1267542968</added>
			<value>Successfully unliked this feed</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.4</version_id>
			<var_name>not_a_valid_feed</var_name>
			<added>1267542980</added>
			<value>Not a valid feed.</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.4</version_id>
			<var_name>total_comments</var_name>
			<added>1267544302</added>
			<value>{total} Comments</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.4</version_id>
			<var_name>1_comment</var_name>
			<added>1267544350</added>
			<value>1 Comment</value>
		</phrase>
		<phrase>
			<module_id>feed</module_id>
			<version_id>2.0.4</version_id>
			<var_name>comments</var_name>
			<added>1267544379</added>
			<value>Comments</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>feed</module_id>
			<hook_type>service</hook_type>
			<module>feed</module>
			<call_name>feed.service_feed_get_mobile_types</call_name>
			<added>1267629983</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
		<hook>
			<module_id>feed</module_id>
			<hook_type>controller</hook_type>
			<module>feed</module>
			<call_name>feed.component_controller_view_mobile_clean</call_name>
			<added>1267629983</added>
			<version_id>2.0.4</version_id>
			<value />
		</hook>
	</hooks>
	<update_templates>
		<file type="block">entry.html.php</file>
	</update_templates>
</upgrade>