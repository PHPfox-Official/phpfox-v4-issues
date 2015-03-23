<upgrade>
	<phrases>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>cannot_comment_on_this_item_as_it_does_not_exist_any_longer</var_name>
			<added>1258388355</added>
			<value>Cannot comment on this item as it does not exist any longer.</value>
		</phrase>
		<phrase>
			<module_id>comment</module_id>
			<version_id>2.0.0rc8</version_id>
			<var_name>comments_activity</var_name>
			<added>1258500371</added>
			<value>Comments</value>
		</phrase>
	</phrases>
	<hooks>
		<hook>
			<module_id>comment</module_id>
			<hook_type>controller</hook_type>
			<module>comment</module>
			<call_name>comment.component_controller_admincp_spam_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>comment</module_id>
			<hook_type>controller</hook_type>
			<module>comment</module>
			<call_name>comment.component_controller_moderate_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>comment</module_id>
			<hook_type>controller</hook_type>
			<module>comment</module>
			<call_name>comment.component_controller_view_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
		<hook>
			<module_id>comment</module_id>
			<hook_type>controller</hook_type>
			<module>comment</module>
			<call_name>comment.component_controller_rss_clean</call_name>
			<added>1258389334</added>
			<version_id>2.0.0rc8</version_id>
			<value />
		</hook>
	</hooks>
</upgrade>