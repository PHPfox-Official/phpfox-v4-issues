<module>
	<data>
		<module_id>search</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>0</is_menu>
		<menu />
		<phrase_var_name>module_search</phrase_var_name>
		<writable />
	</data>
	<hooks>
		<hook module_id="search" hook_type="controller" module="search" call_name="search.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="search" hook_type="service" module="search" call_name="search.service_search__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="search" hook_type="service" module="search" call_name="search.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="search" hook_type="service" module="search" call_name="search.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="search" hook_type="controller" module="search" call_name="search.component_controller_tag_clean" added="1259160644" version_id="2.0.0rc9" />
	</hooks>
	<phrases>
		<phrase module_id="search" version_id="2.0.0alpha1" var_name="module_search" added="1232969305">Search</phrase>
		<phrase module_id="search" version_id="2.0.0rc8" var_name="provide_a_search_query" added="1258738780">Provide a search query.</phrase>
		<phrase module_id="search" version_id="2.0.0rc8" var_name="tags" added="1258740328">Tags</phrase>
		<phrase module_id="search" version_id="2.0.0rc8" var_name="results" added="1259089709">Results</phrase>
		<phrase module_id="search" version_id="2.0.0rc8" var_name="search" added="1259089719">Search</phrase>
		<phrase module_id="search" version_id="2.0.0rc8" var_name="results_for" added="1259089736">Results for</phrase>
		<phrase module_id="search" version_id="2.0.7" var_name="user_setting_can_use_global_search" added="1288616524">Can use the global search tool?</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="no_more_search_results_to_show" added="1322738857">No more search results to show.</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="no_search_results_found" added="1322738868">No search results found.</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="view_more" added="1322738882">View More</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="all_results" added="1323335939">All Results</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="poll" added="1323336059">Poll</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="members" added="1323336072">Members</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="videos" added="1323336086">Videos</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="video" added="1323336092">Video</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="listings" added="1323336105">Listings</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="marketplace_listing" added="1323336112">Marketplace Listing</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="songs" added="1323336131">Songs</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="song" added="1323336136">Song</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="photos" added="1323336144">Photos</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="photo" added="1323336151">Photo</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="quizzes" added="1323336160">Quizzes</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="quiz" added="1323336165">Quiz</phrase>
		<phrase module_id="search" version_id="3.0.0" var_name="forum_thread" added="1323336176">Forum Thread</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="search" type="boolean" admin="1" user="1" guest="1" staff="1" module="search" ordering="0">can_use_global_search</setting>
	</user_group_settings>
</module>