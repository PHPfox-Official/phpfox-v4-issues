<module>
	<data>
		<module_id>music</module_id>
		<product_id>phpfox</product_id>
		<is_core>0</is_core>
		<is_active>1</is_active>
		<is_menu>1</is_menu>
		<menu><![CDATA[a:2:{s:26:"music.admin_menu_add_genre";a:1:{s:3:"url";a:2:{i:0;s:5:"music";i:1;s:3:"add";}}s:30:"music.admin_menu_manage_genres";a:1:{s:3:"url";a:1:{i:0;s:5:"music";}}}]]></menu>
		<phrase_var_name>module_music</phrase_var_name>
		<writable><![CDATA[a:2:{i:0;s:11:"file/music/";i:1;s:15:"file/pic/music/";}]]></writable>
	</data>
	<menus>
		<menu module_id="music" parent_var_name="" m_connection="main" var_name="menu_music" ordering="9" url_value="music" version_id="2.0.0alpha1" disallow_access="" module="music" mobile_icon="music" />
		<menu module_id="music" parent_var_name="" m_connection="music.index" var_name="menu_upload_a_song" ordering="74" url_value="music.upload" version_id="2.0.0beta1" disallow_access="" module="music" />
	</menus>
	<settings>
		<setting group="" module_id="music" is_hidden="0" type="integer" var_name="music_user_group_id" phrase_var_name="setting_music_user_group_id" ordering="1" version_id="2.0.0beta1">0</setting>
		<setting group="" module_id="music" is_hidden="0" type="string" var_name="music_release_date_time_stamp" phrase_var_name="setting_music_release_date_time_stamp" ordering="1" version_id="2.0.0beta1">F j, Y</setting>
		<setting group="" module_id="music" is_hidden="0" type="integer" var_name="sponsored_songs_to_show" phrase_var_name="setting_sponsored_songs_to_show" ordering="1" version_id="2.0.5">5</setting>
		<setting group="" module_id="music" is_hidden="1" type="boolean" var_name="music_enable_mass_uploader" phrase_var_name="setting_music_enable_mass_uploader" ordering="1" version_id="2.0.8">0</setting>
		<setting group="" module_id="music" is_hidden="1" type="drop" var_name="music_index_controller" phrase_var_name="setting_music_index_controller" ordering="1" version_id="2.0.0rc6"><![CDATA[a:2:{s:7:"default";s:4:"song";s:6:"values";a:3:{i:0;s:4:"song";i:1;s:5:"album";i:2;s:6:"artist";}}]]></setting>
	</settings>
	<blocks>
		<block type_id="0" m_connection="music.view-album" module_id="music" component="album-info" location="1" is_active="1" ordering="3" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="music.index" module_id="music" component="list" location="1" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="music.browse.song" module_id="music" component="list" location="1" is_active="1" ordering="2" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="music.view-album" module_id="music" component="photo-album" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="music.browse.song" module_id="music" component="sponsored-song" location="1" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title></title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="music.index" module_id="music" component="new-album" location="3" is_active="1" ordering="4" disallow_access="" can_move="0">
			<title>New Albums</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="music.album" module_id="music" component="track" location="3" is_active="1" ordering="1" disallow_access="" can_move="0">
			<title>Manage Tracks for Albums</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="music.view-album" module_id="music" component="track" location="3" is_active="1" ordering="4" disallow_access="" can_move="0">
			<title>Album Tracklist</title>
			<source_code />
			<source_parsed />
		</block>
		<block type_id="0" m_connection="music.index" module_id="music" component="featured" location="3" is_active="1" ordering="5" disallow_access="" can_move="0">
			<title>Featured Songs</title>
			<source_code />
			<source_parsed />
		</block>
	</blocks>
	<hooks>
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_index_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_register_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_upload_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_song_clean" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_process__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_music__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_callback__call" added="1240687633" version_id="2.0.0beta1" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_genre_clean" added="1240688954" version_id="2.0.0beta1" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_genre_genre__call" added="1240688954" version_id="2.0.0beta1" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_genre_profile_clean" added="1240692039" version_id="2.0.0beta1" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_genre_process__call" added="1240692039" version_id="2.0.0beta1" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_info_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_track_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_album_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_list_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_album_info_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_admincp_index_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_admincp_add_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_album_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_view_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_player_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_view_album_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_profile_clean" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_album_album__call" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_album_process__call" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_browse__call" added="1242299564" version_id="2.0.0beta2" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_top_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_photo_album_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_menu_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_photo_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_latest_album_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_featured_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_filter_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_latest_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_featured_album_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_menu_album_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_browse_artist_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_browse_album_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_browse_song_clean" added="1258389334" version_id="2.0.0rc8" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_process_upload__end" added="1260366442" version_id="2.0.0rc11" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_profile_clean" added="1263387694" version_id="2.0.2" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_process_sponsorsong__end" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_process_sponsoralbum__end" added="1274286148" version_id="2.0.5dev1" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_callback_getnewsfeedsong_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.song_album_service_callback_getnewsfeed_start" added="1286546859" version_id="2.0.7" />
		<hook module_id="music" hook_type="template" module="music" call_name="music.template_block_menu" added="1286546859" version_id="2.0.7" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_genre_form_clean" added="1290072896" version_id="2.0.7" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_new_album_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="music" hook_type="component" module="music" call_name="music.component_block_share_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_frame_clean" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_upload_feed" added="1319729453" version_id="3.0.0rc1" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_callback_getpagemenu" added="1323240479" version_id="3.0.0" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_album_process_update__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_album_process_deleteimage__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_album_process_delete__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.component_service_callback_getactivityfeedsong__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_process_delete__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_process_delete__2" added="1335951260" version_id="3.2.0" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_process_update__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="music" hook_type="service" module="music" call_name="music.service_process_approve__1" added="1335951260" version_id="3.2.0" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_music_view" added="1395252715" version_id="3.7.6rc1" />
		<hook module_id="music" hook_type="controller" module="music" call_name="music.component_controller_music_index" added="1395252771" version_id="3.7.6rc1" />
	</hooks>
	<components>
		<component module_id="music" component="song" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="album" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="album-info" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="view" m_connection="music.view" module="music" is_controller="1" is_block="0" is_active="1" />
		<component module_id="music" component="view-album" m_connection="music.view-album" module="music" is_controller="1" is_block="0" is_active="1" />
		<component module_id="music" component="list" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="info" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="index" m_connection="music.index" module="music" is_controller="1" is_block="0" is_active="1" />
		<component module_id="music" component="top" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="latest" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="filter" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="browse" m_connection="music.browse" module="music" is_controller="1" is_block="0" is_active="1" />
		<component module_id="music" component="browse.song" m_connection="music.browse.song" module="music" is_controller="1" is_block="0" is_active="1" />
		<component module_id="music" component="browse.album" m_connection="music.browse.album" module="music" is_controller="1" is_block="0" is_active="1" />
		<component module_id="music" component="menu-album" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="photo-album" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="menu" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="photo" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="featured" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="profile" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="sponsored-song" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="sponsored-album" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="new-album" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="track" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="album" m_connection="music.album" module="music" is_controller="1" is_block="0" is_active="1" />
		<component module_id="music" component="tracklist" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="featured-album" m_connection="" module="music" is_controller="0" is_block="1" is_active="1" />
		<component module_id="music" component="profile" m_connection="music.profile" module="music" is_controller="1" is_block="0" is_active="1" />
	</components>
	<phrases>
		<phrase module_id="music" version_id="2.0.0alpha1" var_name="module_music" added="1232964704">Music</phrase>
		<phrase module_id="music" version_id="2.0.0alpha1" var_name="menu_music" added="1232964721">Music</phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="user_setting_can_upload_music_public" added="1240576566"><![CDATA[Can upload music?

<b>Notice:</b> This will allow this user group the right to upload songs to the public music section.]]></phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="setting_music_user_group_id" added="1240682173"><![CDATA[<title>Musician User Group ID#</title><info>Notice this setting is updated during the installation of this module. Edit with caution.</info>]]></phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="setting_music_release_date_time_stamp" added="1240750579"><![CDATA[<title>Album Release Date</title><info>Album Release Date</info>]]></phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="user_setting_can_add_comment_on_music_album" added="1240764774">Can add comments on music albums?</phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="user_setting_can_add_comment_on_music_song" added="1241093826">Can add a comment on a song?</phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="user_setting_can_edit_other_music_albums" added="1241094555">Can edit albums created by other users?</phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="user_setting_can_edit_own_albums" added="1241094832">Can edit own albums?</phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="user_setting_can_delete_own_track" added="1241096074">Can delete own track?</phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="user_setting_can_delete_other_tracks" added="1241096110">Can delete tracks added by other users?</phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="user_setting_can_delete_own_music_album" added="1241097159">Can delete own music album?</phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="user_setting_can_delete_other_music_albums" added="1241097213">Can delete albums added by other users?</phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="menu_upload_a_song" added="1241340149">Upload a Song</phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="admin_menu_add_genre" added="1241343069">Add Genre</phrase>
		<phrase module_id="music" version_id="2.0.0beta1" var_name="admin_menu_manage_genres" added="1241343084">Manage Genres</phrase>
		<phrase module_id="music" version_id="2.0.0beta2" var_name="user_setting_music_max_file_size" added="1242639441">Maximum file size of songs uploaded.</phrase>
		<phrase module_id="music" version_id="2.0.0beta2" var_name="band_artist_name" added="1242644077">Artist/Band Name</phrase>
		<phrase module_id="music" version_id="2.0.0rc1" var_name="user_setting_can_feature_songs" added="1250515236">Can feature songs?</phrase>
		<phrase module_id="music" version_id="2.0.0rc1" var_name="user_setting_can_approve_songs" added="1250517082">Can approve songs?</phrase>
		<phrase module_id="music" version_id="2.0.0rc1" var_name="user_setting_music_song_approval" added="1250581594">Songs must be approved first?</phrase>
		<phrase module_id="music" version_id="2.0.0rc1" var_name="user_setting_can_feature_music_albums" added="1250589165">Can feature music albums?</phrase>
		<phrase module_id="music" version_id="2.0.0rc1" var_name="user_setting_total_song_on_profile" added="1250598448">Define the number of songs that this user group can add to their profile.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="this_song_has_been_added_to_your_profile" added="1255081114">This song has been added to your profile.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="this_song_has_been_removed_from_your_profile" added="1255081122">This song has been removed from your profile.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="basic_info" added="1255081144">Basic Info</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="albums" added="1255081153">Albums</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="browse_filter" added="1255081171">Browse Filter</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="latest" added="1255081207">Latest</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="genres" added="1255081223">Genres</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="latest_tracks" added="1255081248">Latest Tracks</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="favorite_songs" added="1255081262">Favorite Songs</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="provide_a_genre_name" added="1255081283">Provide a genre name.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="genre_successfully_added" added="1255081291">Genre successfully added.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="add_genre" added="1255081298">Add Genre</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="successfully_deleted_genres" added="1255081310">Successfully deleted genres.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="manage_genres" added="1255081355">Manage Genres</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="date_added" added="1255081377">Date Added</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="name" added="1255081385">Name</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="music_albums" added="1255081396">Music Albums</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="music" added="1255081404">Music</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="popular" added="1255081436">Popular</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="recent_songs" added="1255081451">Recent Songs</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="featured" added="1255081458">Featured</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="pending" added="1255081472">Pending</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="music_songs" added="1255081485">Music Songs</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="songs" added="1255081498">Songs</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="provide_a_name_for_this_album" added="1255081511">Provide a name for this album.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="album_successfully_updated" added="1255081522">Album successfully updated.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="tracks_successfully_uploaded" added="1255081534">Tracks successfully uploaded.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="note_that_it_will_have_to_be_approved_first_before_it_is_displayed_publicly" added="1255081544">Note that it will have to be approved first before it is displayed publicly.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="album_art_successfully_updated" added="1255081616">Album art successfully updated.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="album_successfully_added" added="1255081768">Album successfully added.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="update_album" added="1255081778">Update Album</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="create_album" added="1255081791">Create Album</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="date_joined" added="1255081823">Date Joined</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="album_you_are_looking_for_cannot_be_found" added="1255081864">Album you are looking for cannot be found.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="provide_a_artist_band_name" added="1255081881">Provide a Artist/Band name.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="tick_the_box_to_agree_to_our_terms_and_privacy_policy" added="1255081890">Tick the box to agree to our Terms and Privacy Policy.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="provide_a_value_for" added="1255081900">Provide a value for</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="you_have_successfully_converted_your_account" added="1255081909">You have successfully converted your account.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="musician_registration" added="1255081922">Musician Registration</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="registration" added="1255081934">Registration</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="provide_a_name_for_this_song" added="1255081947">Provide a name for this song.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="your_song_was_successfully_uploaded" added="1255081959">Your song was successfully uploaded.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="upload_a_song" added="1255081996">Upload a Song</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="unable_to_find_the_album_you_are_looking_for" added="1255082018">Unable to find the album you are looking for.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="total_rating_ratings" added="1255082186">{total_rating} Ratings</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="poor" added="1255082230">Poor</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="nothing_special" added="1255082238">Nothing Special</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="worth_listening_too" added="1255082246">Worth Listening Too</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="pretty_cool" added="1255082256">Pretty Cool</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="awesome" added="1255082263">Awesome</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="you_have_already_voted" added="1255082288">You have already voted.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="you_cannot_rate_your_own_album" added="1255082297">You cannot rate your own album.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="the_song_you_are_looking_for_cannot_be_found" added="1255082310">The song you are looking for cannot be found.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="unable_to_find_the_album_this_song_belongs_to" added="1255082384">Unable to find the album this song belongs to.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="you_cannot_rate_your_own_song" added="1255082435">You cannot rate your own song.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="unable_to_find_the_album_you_want_to_edit" added="1255082469">Unable to find the album you want to edit.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="unable_to_edit_this_album" added="1255082477">Unable to edit this album.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="provide_a_title_for_this_track" added="1255082532">Provide a title for this track.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="not_allowed_to_edit_this_photo_album_art" added="1255082553">Not allowed to edit this photo album art.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="album_you_are_trying_to_delete_cannot_be_found" added="1255082564">Album you are trying to delete cannot be found.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="not_allowed_to_delete_this_album" added="1255082575">Not allowed to delete this album.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_their_own_a_href_title_link_song" added="1255082706"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on their own <a href="{title_link}">song</a>.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_your_a_href_title_link_song_a" added="1255082766"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on your <a href="{title_link}">song</a>.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_a_href_item_user_link_item_user_n" added="1255082794"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on <a href="{item_user_link}">{item_user_name}'s</a> <a href="{title_link}">song</a>.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="invalid_callback_on_music_song" added="1255082855">Invalid callback on music song.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_site_title" added="1255082873">{user_name} left you a comment on {site_title}.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_your_song_title" added="1255082959"><![CDATA[{user_name} left you a comment on your song "{title}".

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="user_name_left_you_a_comment_on_your_music_album_name" added="1255083035"><![CDATA[{user_name} left you a comment on your music album "{name}".

To view this comment, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_their_own_a_href_title_link_music" added="1255083989"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on their own <a href="{title_link}">music album</a>.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="a_href_user_link_full_name_a_added_a_new_comment_on_your_a_href_title_link_music_album" added="1255084044"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on your <a href="{title_link}">music album</a>.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="added_a_new_comment_on_a_href_item_user_link_item_user_name_s_album" added="1255084077"><![CDATA[<a href="{user_link}">{full_name}</a> added a new comment on <a href="{item_user_link}">{item_user_name}'s</a> <a href="{title_link}">music album</a>.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="your_song_title_has_been_approved" added="1255084164"><![CDATA[Your song "{title}" has been approved.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="manage_songs" added="1255084212">Manage Songs</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="music_album_text" added="1255084223">Music Album Text</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="select_an_mp3" added="1255084249">Select an MP3.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="you_have_reached_your_limit_max_songs_allowed_total" added="1255084287">You have reached your limit. Max songs allowed: {total}</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="unable_to_find_the_song_you_want_to_approve" added="1255084308">Unable to find the song you want to approve.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="your_song_title_has_been_approved_on_site_title" added="1255084330"><![CDATA[Your song "{title}" has been approved on {site_title}.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="your_song_title_has_been_approved_on_site_title_to_view_this_song" added="1255084396"><![CDATA[Your song "{title}" has been approved on {site_title}.

To view this song, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="there_is_one_song_that_is_pending_approval" added="1255084599">There is one song that is pending approval.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="there_are_total_songs_that_are_pending_approval" added="1255084611">There are {total} songs that are pending approval.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="click_here_to_approve_songs" added="1255084741">Click here to approve songs.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="no_songs_found" added="1255084750">No songs found.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="view_this_album" added="1255084762">View This Album</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="skip_amp_view_this_album" added="1255084770"><![CDATA[Skip &amp; View This Album]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="step_1" added="1255084781">Step 1</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="album_details" added="1255086513">Album Details</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="step_2" added="1255086674">Step 2</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="album_art" added="1255086683">Album Art</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="step_3" added="1255086715">Step 3</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="tracks" added="1255086722">Tracks</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="album_name" added="1255086736">Album Name</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="album_year" added="1255086745">Album Year</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="description" added="1255086752">Description</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="add_album" added="1255086770">Add Album</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="select_photo" added="1255086779">Select Photo</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="are_you_sure" added="1255086913">Are you sure?</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="click_a_href_onclick_javascript_here_a_to_delete_this_image_and_upload_a_new_one_in_its_p" added="1255086946"><![CDATA[Click <a href="#" onclick="{javascript}">here</a> to delete this image and upload a new one in its place.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="you_can_upload_a_jpg_gif_or_png_file" added="1255086964">You can upload a JPG, GIF or PNG file.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="upload" added="1255087033">Upload</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="upload_track" added="1255087042">Upload Track</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="album_tracks" added="1255087061">Album Tracks</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="no_musicians_found" added="1255087525">No musicians found.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="no_musicians_have_joined" added="1255087532">No musicians have joined.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="join_now_if_you_are_a_musician" added="1255087541">Join now if you are a musician.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="you_retain_all_rights_in_your_music_that_you_upload" added="1255087565"><![CDATA[<p>
		You retain all rights in your music that you upload. You must only upload music in which you own all the rights. If you upload any music in which you do not own all the rights, you may be violating copyright law.
	</p>
	<p>
		Uploading copyrighted music without the explicit consent of the copyright owner will result in your profile being cancelled.
	</p>
	<p>
		Musician profiles are for Musicians/Bands.
	</p>
	<p>
		<b>Notice:</b> You will convert your current profile into a Musicians profile.
	</p>]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="b_notice_b_you_have_an_admin_account_and_if_you_convert_your_account_into_a_musicians_account" added="1255087579"><![CDATA[<b>Notice:</b> You have an Admin account and if you convert your account into a "Musicians" account you will lose all your Admin rights.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="artist_band_name" added="1255087589">Artist/Band Name</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="register" added="1255087857">Register</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="play_all_total_track" added="1255087904">Play All ({total_track})</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="about_this_album" added="1255087923">About This Album</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="tracklist" added="1255087931">Tracklist</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="rating" added="1254405150">Rating</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="plays" added="1254405176">Plays</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="released" added="1254405185">Released</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="total_play_plays" added="1254405321">{total_play} plays</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="total_track_tracks" added="1254405469">{total_track} tracks</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="by" added="1254405591">By</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="album" added="1254405601">Album</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="approve_this_song" added="1254405626">Approve this song.</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="feature_this_song" added="1254405668">Feature this song.</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="un_feature_this_song" added="1254405706">Un-Feature this song.</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="add_this_song_to_your_profile" added="1254405724">Add this song to your profile.</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="report_this_song" added="1254406065">Report this Song</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="delete_track" added="1254406141">Delete Track</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="keywords" added="1254576099">Keywords</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="sort" added="1254576109">Sort</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="submit" added="1254576138">Submit</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="reset" added="1254576149">Reset</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="genre" added="1254576165">Genre</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="genre_total" added="1254576248">Genre {total}</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="none" added="1254576296">None</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="added" added="1254576519">Added</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="total_plays" added="1254576703">{total} plays</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="total_tracks" added="1254576826">{total} tracks</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="all" added="1254576960">All</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="edit" added="1254576993">Edit</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="upload_new_track" added="1254577009">Upload New Track</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="delete_album" added="1254577030">Delete Album</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="report" added="1254577104">Report</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="report_this_music_album" added="1254577196">Report this Music Album</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="feature_this_album" added="1254577227">Feature this album.</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="un_feature_this_album" added="1254577240">Un-Feature this album.</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="feature" added="1254577262">Feature</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="unfeature" added="1254577273">Unfeature</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="add_to_profile" added="1254577423">Add to Profile</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="remove_this_song_from_your_profile" added="1254577440">Remove this song from your profile.</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="remove_from_profile" added="1254577453">Remove from Profile</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="approve" added="1254577485">Approve</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="cannot_display_player_while_designing_your_profile" added="1254577663">Cannot display player while designing your profile.</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="you_retain_all_rights_in_your_music_that_you_upload_you_must_only_upload_music_in_which_you_own_all" added="1254578051">You retain all rights in your music that you upload. You must only upload music in which you own all the rights. If you upload any music in which you do not own all the rights, you may be violating copyright law.</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="uploading_copyrighted_music_without_the_explicit_consent_of_the_copyright_owner_will_result_in_your" added="1254578072">Uploading copyrighted music without the explicit consent of the copyright owner will result in your profile being cancelled.</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="select" added="1254578101">Select</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="select_mp3" added="1254578160">Select MP3</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="max_file_size" added="1254578172">Max file size</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="song_name" added="1254578184">Song Name</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="check_if_song_contains_explicit_lyrics" added="1254578225">Check if song contains explicit lyrics.</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="genre_details" added="1254578252">Genre Details</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="genre_name" added="1254578368">Genre Name</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="delete_selected" added="1254578467">Delete Selected</phrase>
		<phrase module_id="music" version_id="2.0.0rc3" var_name="no_albums_found" added="1254578672">No albums found.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="i_have_read_and_agree_to_the_terms_of_use_and_privacy_policy" added="1255089163"><![CDATA[I have read and agree to the <a href="#" id="js_terms_of_use">Terms of Use</a> and <a href="#" id="js_privacy_policy">Privacy Policy</a>.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="no_albums_have_been_created_yet" added="1255092650">No albums have been created yet.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="click_here_to_create_one" added="1255092682">Click here to create one.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="play" added="1255092732">Play</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="are_you_sure_this_will_delete_all_tracks_that_belong_to_this_album_and_cannot_be_undone" added="1255092976">Are you sure? This will delete all tracks that belong to this album and cannot be undone.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="no_songs_uploaded_yet" added="1255093004">No songs uploaded yet.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="no_songs_added_yet" added="1255093013">No songs added yet.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="click_here_to_upload" added="1255093081">Click here to upload.</phrase>
		<phrase module_id="music" version_id="2.0.0rc4" var_name="click_here_to_find_songs" added="1255093089">Click here to find songs.</phrase>
		<phrase module_id="music" version_id="2.0.0rc6" var_name="setting_music_index_controller" added="1256893249"><![CDATA[<title>Music Index Controller</title><info>Select which controller should be used when viewing the music sections index page.</info>]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc6" var_name="full_name_uploaded_a_new_song" added="1257252374"><![CDATA[<a href="{profile_link}">{full_name}</a> uploaded a new song "<a href="{link}">{title}</a>".]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc6" var_name="full_name_uploaded_a_new_song_to_the_album" added="1257253578"><![CDATA[<a href="{profile_link}">{full_name}</a> uploaded a song "<a href="{link}">{title}</a>" to the album "<a href="{album_link}">{album_title}</a>".]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc6" var_name="add_to_favorites" added="1257317596">Add to Favorites</phrase>
		<phrase module_id="music" version_id="2.0.0rc8" var_name="approved" added="1258377477">Approved</phrase>
		<phrase module_id="music" version_id="2.0.0rc8" var_name="no_music_albums_have_been_created" added="1258397590">No music albums have been created.</phrase>
		<phrase module_id="music" version_id="2.0.0rc8" var_name="there_are_new_featured_albums" added="1258397705">There are new featured albums.</phrase>
		<phrase module_id="music" version_id="2.0.0rc8" var_name="there_are_no_featured_albums" added="1258397713">There are no featured albums.</phrase>
		<phrase module_id="music" version_id="2.0.0rc8" var_name="music_album_count" added="1258979956">Music Album Count</phrase>
		<phrase module_id="music" version_id="2.0.0rc8" var_name="music_album_track_count" added="1258979966">Music Album Track Count</phrase>
		<phrase module_id="music" version_id="2.0.0rc8" var_name="no_tracks_have_been_added" added="1259090492">No tracks have been added.</phrase>
		<phrase module_id="music" version_id="2.0.0rc10" var_name="music_album_successfully_deleted" added="1259677776">Music album successfully deleted.</phrase>
		<phrase module_id="music" version_id="2.0.0rc11" var_name="user_setting_can_access_music" added="1260286510">Can browse and view the music module?</phrase>
		<phrase module_id="music" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_their_own_a_href_link_song_a" added="1260453013"><![CDATA[<a href="{user_link}">{full_name}</a> liked their own <a href="{link}">song</a>.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_a_href_view_user_link_view_full_name_a_s_a_href_link_song_a" added="1260453036"><![CDATA[<a href="{user_link}">{full_name}</a> liked <a href="{view_user_link}">{view_full_name}</a>'s <a href="{link}">song</a>.]]></phrase>
		<phrase module_id="music" version_id="2.0.0rc12" var_name="a_href_user_link_full_name_a_liked_your_a_href_link_song_a" added="1260457612"><![CDATA[<a href="{user_link}">{full_name}</a> liked your <a href="{link}">song</a>.]]></phrase>
		<phrase module_id="music" version_id="2.0.0" var_name="add_a_genre" added="1261510451">Add a genre.</phrase>
		<phrase module_id="music" version_id="2.0.4" var_name="album_plays_count" added="1266502930">plays</phrase>
		<phrase module_id="music" version_id="2.0.4" var_name="eg_1982" added="1266933559">eg. 1982</phrase>
		<phrase module_id="music" version_id="2.0.4" var_name="view_more" added="1266942360">View More</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="setting_sponsored_songs_to_show" added="1270126817"><![CDATA[<title>How Many Sponsor Songs To Show</title><info>This setting limits how many sponsor songs to show</info>]]></phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="sponsored_music_songs" added="1270130142">Sponsored Songs</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="user_setting_can_sponsor_song" added="1270548424">Can members of this user group mark a song as Sponsor?</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="unsponsor_this_song" added="1270558435">Unsponsor this Song</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="sponsor_this_song" added="1270558451">Sponsor this Song</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="song_successfully_sponsored" added="1270560707">Song successfully sponsored</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="song_successfully_un_sponsored" added="1270560725">Song successfully Unsponsored</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="encourage_sponsor_album" added="1270633729">Sponsor your Albums</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="user_setting_can_sponsor_album" added="1270640433">Can members of this user group mark an album as sponsor?</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="unsponsor_this_album" added="1270641522">Unsponsor</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="sponsor_this_album" added="1270641561">Sponsor</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="album_successfully_sponsored" added="1270644171">Album successfully sponsored.</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="album_successfully_un_sponsored" added="1270644956">Album successfully unsponsored</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="user_setting_can_purchase_sponsor_album" added="1271078054">Can members of this user group purchase a sponsored ad space for their music albums?</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="user_setting_can_purchase_sponsor_song" added="1271078677">Can members of this user group purchase a sponsored ad space for their songs?</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="encourage_sponsor_song" added="1271150070">Sponsor your Songs</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="sponsor_help_song" added="1271150643"><![CDATA[To sponsor your song, click on the link to listen to it and then click on the right hand side menu on "Sponsor".]]></phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="sponsored_music_album" added="1271151389">Sponsored Album</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="sponsor_help_album" added="1271151549"><![CDATA[To sponsor your album, click on it from the list below and then on the right hand side menu link "Sponsor"]]></phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="user_setting_music_album_sponsor_price" added="1271859991">How much is the sponsor space worth for music albums?
This works in a CPM basis.</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="user_setting_music_song_sponsor_price" added="1271925704">How much is the sponsor space worth for music songs?
This works in a CPM basis.</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="sponsor_error_album_not_found" added="1271942487">The music album you are trying to sponsor is not available.</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="album_sponsor_title" added="1271942615">Music album: {sAlbumTitle}</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="album_sponsor_paypal_message" added="1271942696">Payment for the sponsor space of music album: {sAlbumTitle}</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="sponsor_error_song_not_found" added="1271942847">The music album you are trying to sponsor is not available.</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="song_sponsor_title" added="1271942894">Song: {sSongTitle}</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="song_sponsor_paypal_message" added="1271943438">Payment for the sponsor space of music song: {sSongTitle}</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="user_setting_auto_publish_sponsored_album" added="1272007538">After the user has purchased a sponsored space, should the music album be published right away?
If set to false, the admin will have to approve each new purchased sponsored album space before it is shown in the site.</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="user_setting_auto_publish_sponsored_song" added="1272007589">After the user has purchased a sponsored space, should the song be published right away?
If set to false, the admin will have to approve each new purchased sponsored song space before it is shown in the site.</phrase>
		<phrase module_id="music" version_id="2.0.5" var_name="a_href_user_link_full_name_a_likes_your_a_href_link_music_a" added="1273170650"><![CDATA[<a href="{user_link}">{full_name}</a> likes your <a href="{link}">music</a>.]]></phrase>
		<phrase module_id="music" version_id="2.0.7" var_name="music_genres" added="1290008427">Music Genres</phrase>
		<phrase module_id="music" version_id="2.0.7" var_name="please_select_a_genre_for_your_music" added="1290010470">Please select a genre for your music.</phrase>
		<phrase module_id="music" version_id="2.0.7" var_name="update" added="1290010481">Update</phrase>
		<phrase module_id="music" version_id="2.0.7" var_name="note_that_you_can_edit_your_genre" added="1290010521"><![CDATA[Note that you can edit your genre at a later time by editing your profile <a href="{link}">here</a>.]]></phrase>
		<phrase module_id="music" version_id="2.0.8" var_name="setting_music_enable_mass_uploader" added="1294995190"><![CDATA[<title>Enable Mass Uploader</title><info>When enabled users will be allowed to use a mass song uploader to select multiple files from a single file select dialog.

This uses an integration of SWFUpload (http://code.google.com/p/swfupload/) and thus it uses a Flash object.</info>]]></phrase>
		<phrase module_id="music" version_id="3.0.0beta1" var_name="user_setting_can_edit_own_song" added="1303845553">Can edit own songs?</phrase>
		<phrase module_id="music" version_id="3.0.0beta1" var_name="user_setting_can_edit_other_song" added="1303845597">Can edit songs uploaded by other users?</phrase>
		<phrase module_id="music" version_id="3.0.0beta1" var_name="user_setting_activity_music_song" added="1303978055">How many activity points does a user get when uploading a song?</phrase>
		<phrase module_id="music" version_id="3.0.0beta1" var_name="say_something_about_this_song" added="1304063712">Say something about this song.</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="title" added="1319122685">Title</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="mp3" added="1319122691">MP3</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="select_a_song_to_attach" added="1319122698">Select a song to attach.</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="unable_to_find_the_song_you_are_trying_to_play" added="1319183938">Unable to find the song you are trying to play.</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="song_successfully_featured" added="1319183950">Song successfully featured</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="song_successfully_un_featured" added="1319183963">Song successfully un-featured</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="un_feature" added="1319183971">Un-Feature</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="album_successfully_featured" added="1319183983">Album successfully featured</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="album_successfully_un_featured" added="1319184000">Album successfully un-featured</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="song_has_been_approved" added="1319184020">Song has been approved.</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="song_approved" added="1319184028">Song Approved</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="song_successfully_deleted" added="1319448709">Song successfully deleted.</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="search_songs" added="1319448722">Search Songs...</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="most_viewed" added="1319448744">Most Viewed</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="most_liked" added="1319448768">Most Liked</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="most_discussed" added="1319448837">Most Discussed</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="delete" added="1319448850">Delete</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="all_songs" added="1319449191">All Songs</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="my_songs" added="1319449201">My Songs</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="friends_songs" added="1319449211"><![CDATA[Friends' Songs]]></phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="pending_songs" added="1319449218">Pending Songs</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="all_albums" added="1319449227">All Albums</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="my_albums" added="1319449237">My Albums</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="view_song" added="1319449263">View Song</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="successfully_uploaded_the_mp3" added="1319449780">Successfully uploaded the MP3</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="or_create_a_new_album" added="1319449808">or create a new album</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="optional" added="1319449820">(optional)</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="privacy" added="1319449843">Privacy</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="comment_privacy" added="1319449852">Comment Privacy</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="control_who_can_see_this_song" added="1319449861">Control who can see this song.</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="control_who_can_comment_on_this_song" added="1319449873">Control who can comment on this song.</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="upload_problems_try_the_basic_uploader" added="1319449986"><![CDATA[Upload problems? Try the <a href="{url}">basic uploader</a> (works on older computers and web browsers).]]></phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="year" added="1319450068">Year</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="photo" added="1319450078">Photo</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="control_who_can_see_this_album_and_any_songs_connected_to_it" added="1319450104">Control who can see this album and any songs connected to it.</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="control_who_can_comment_on_this_album" added="1319450117">Control who can comment on this album.</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="editing_album" added="1319450209">Editing Album</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="upload_songs" added="1319450233">Upload Songs</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="unable_to_view_this_item_due_to_privacy_settings" added="1319450280">Unable to view this item due to privacy settings.</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="report_this_song_lowercase" added="1319450300">Report this song</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="song_is_pending_approval" added="1319450333">Song is pending approval.</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="actions" added="1319450348">Actions</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="by_lowercase" added="1319455349">by</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="in" added="1319455357">in</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="album_is_pending_approval" added="1319455494">Album is pending approval.</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="report_this_album" added="1319455575">Report this album</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="play_all" added="1319455622">Play All</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="mp3_tracks" added="1319455870">MP3 Tracks</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="pending_approval" added="1319455996">Pending Approval</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="sponsored" added="1319456261">Sponsored</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="moderate" added="1319456275">Moderate</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="new_albums" added="1319456503">New Albums</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="1_track" added="1319456536">1 track</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="1_play" added="1319456563">1 play</phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="full_name_liked_your_song_title" added="1319530894"><![CDATA[{full_name} liked your song "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="full_name_liked_your_song_message" added="1319531290"><![CDATA[{full_name} liked your song "<a href="{link}">{title}</a>"
To view this song follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="full_name_liked_your_album_name" added="1319531346"><![CDATA[{full_name} liked your album "{name}"]]></phrase>
		<phrase module_id="music" version_id="3.0.0beta5" var_name="full_name_liked_your_album_message" added="1319531423"><![CDATA[{full_name} liked your album "<a href="{link}">{name}</a>"
To view this album follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="music" version_id="3.0.0rc2" var_name="users_liked_your_song_title" added="1321347866"><![CDATA[{users} liked your song "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.0.0rc2" var_name="who_can_share_songs" added="1321360179">Who can share songs?</phrase>
		<phrase module_id="music" version_id="3.0.0rc2" var_name="who_can_view_browse_songs" added="1321360189">Who can view/browse songs?</phrase>
		<phrase module_id="music" version_id="3.0.0rc3" var_name="featured_albums" added="1321961384">Featured Albums</phrase>
		<phrase module_id="music" version_id="3.0.0rc3" var_name="featured_songs" added="1321961407">Featured Songs</phrase>
		<phrase module_id="music" version_id="3.0.0rc3" var_name="tracks_lowercase" added="1321961447">tracks</phrase>
		<phrase module_id="music" version_id="3.0.0rc3" var_name="plays_lowercase" added="1321961468">plays</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="full_name_commented_on_your_song_title" added="1322466028"><![CDATA[{full_name} commented on your song "{title}".]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="posted_a_comment_on_gender_song_a_href_link_title_a" added="1322568716"><![CDATA[posted a comment on {gender} song "<a href="{link}">{title}</a>"]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="posted_a_comment_on_user_name_s_song_a_href_link_title_a" added="1322568784"><![CDATA[posted a comment on {user_name}'s song "<a href="{link}">{title}</a>]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="name_commented_on_your_song" added="1322569062"><![CDATA[{full_name} commented on your song "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="full_name_commented_on_gender_song" added="1322569299">{full_name} commented on {gender} song</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_song" added="1322569435"><![CDATA[{full_name} commented on {other_full_name}'s song]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="full_name_commented_on_gender_song_a_href_link_title_a_to_see_the_comment_thread_folow_the_link_below_a_href_link_link_a" added="1322569680"><![CDATA[{full_name} commented on {gender} song "<a href="{link}">{title}</a>".
To see the comment thread, folow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="full_name_commented_on_other_full_names_song" added="1322570036"><![CDATA[{full_name} commented on {other_full_name}'s song "<a href="{link}">{title}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="full_name_commented_on_gender_album" added="1322574397">{full_name} commented on {gender} album</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_album" added="1322574559"><![CDATA[{full_name} commented on {other_full_name}'s album]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="full_name_commented_on_gender_album_a_href_link_user_name_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322574867"><![CDATA[{full_name} commented on {gender} album "<a href="{link}">{user_name}</a>".
To see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="full_name_commented_on_other_full_name_s_album_a_href_link_user_name_a_to_see_the_comment_thread_follow_the_link_below_a_href_link_link_a" added="1322575669"><![CDATA[{full_name} commented on {other_full_name}'s album "<a href="{link}">{user_name}</a>".
TO see the comment thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="a_href_link_on_user_name_s_song_a" added="1322575936"><![CDATA[<a href="{link}">On {user_name}'s song.</a>]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="a_href_link_on_user_name_s_album_a" added="1322576194"><![CDATA[<a href="{link}">On {user_name}'s album.</a>]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="user_name_liked_gender_own_song_title" added="1322577088"><![CDATA[{user_name} liked {gender} own song "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="user_name_liked_span_class_drop_data_user_full_name_s_span_song_title" added="1322578321"><![CDATA[{user_name} liked <span class="drop_data_user">{full_name}'s</span> song "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="user_name_commented_on_span_class_drop_data_user_full_name_s_span_song_title" added="1322578686"><![CDATA[{user_name} commented on <span class="drop_data_user">{full_name}'s</span> song "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="user_name_liked_gender_own_album_title" added="1322579606"><![CDATA[{user_name} liked {gender} own album "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="user_name_liked_your_album_title" added="1322579759"><![CDATA[{user_name} liked your album "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="user_name_liked_span_class_drop_data_user_full_name_s_span_album_title" added="1322579940"><![CDATA[{user_name} liked <span class="drop_data_user">{full_name}'s</span> album "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="user_name_commented_on_gender_album_title" added="1322580305"><![CDATA[{user_name} commented on {gender} album "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="user_name_commented_on_your_album_title" added="1322580687"><![CDATA[{user_name} commented on your album "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="user_name_commented_on_span_class_drop_data_user_full_name_s_album_title" added="1322580821"><![CDATA[{user_name} commented on <span class="drop_data_user">{full_name}'s</span> album "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="your_song_was_named_successfully" added="1322739955">Your song was named successfully.</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="songs_s_successfully_approved" added="1322739969">Songs(s) successfully approved.</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="songs_s_successfully_deleted" added="1322739981">Songs(s) successfully deleted.</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="songs_s_successfully_featured" added="1322739993">Songs(s) successfully featured.</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="songs_s_successfully_un_featured" added="1322740004">Songs(s) successfully un-featured.</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="albums_s_successfully_deleted" added="1322740025">Albums(s) successfully deleted.</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="albums_s_successfully_featured" added="1322740058">Albums(s) successfully featured.</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="albums_s_successfully_un_featured" added="1322740075">Albums(s) successfully un-featured.</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="album_successfully_deleted" added="1322740121">Album successfully deleted.</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="search_albums" added="1322740165">Search Albums...</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="add_a_photo_category" added="1322740484">Add a Photo Category</phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="full_name_commented_on_your_album_title" added="1323096904"><![CDATA[{full_name} commented on your album "{title}".]]></phrase>
		<phrase module_id="music" version_id="3.0.0" var_name="full_name_commented_on_your_album_a_href_link_title_a_to_see_the_commented_thread_follow_the_link_below_a_href_link_link_a" added="1323097893"><![CDATA[{full_name} commented on your album "<a href="{link}">{title}</a>".
To see the commented thread, follow the link below:
<a href="{link}">{link}</a>]]></phrase>
		<phrase module_id="music" version_id="3.1.0beta1" var_name="user_name_tagged_you_in_a_comment_in_a_song" added="1331221740">{user_name} tagged you in a comment in a song</phrase>
		<phrase module_id="music" version_id="3.1.0beta1" var_name="user_name_tagged_you_in_a_comment_in_a_music_album" added="1331221780">{user_name} tagged you in a comment in a music album</phrase>
		<phrase module_id="music" version_id="3.1.0beta1" var_name="update_user_song_count" added="1331644171">Update User Song Count</phrase>
		<phrase module_id="music" version_id="3.1.0" var_name="fullname_s_songs" added="1332771039"><![CDATA[{full_name}&#039;s Songs]]></phrase>
		<phrase module_id="music" version_id="3.3.0beta1" var_name="editing_song" added="1339154155">Editing Song</phrase>
		<phrase module_id="music" version_id="3.3.0" var_name="users_commented_on_gender_song_title" added="1343032354"><![CDATA[{users} commented on {gender} song "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.3.0" var_name="users_commented_on_your_song_title" added="1343032427"><![CDATA[{users} commented on your song "{title}"]]></phrase>
		<phrase module_id="music" version_id="3.4.0beta1" var_name="song_successfully_uploaded" added="1347878252">Song successfully uploaded.</phrase>
		<phrase module_id="music" version_id="3.4.0beta2" var_name="user_setting_points_music_song" added="1348463640">How many activity points should a user receive for uploading a song?</phrase>
		<phrase module_id="music" version_id="3.5.0beta1" var_name="item_phrase_song" added="1352731847">song</phrase>
		<phrase module_id="music" version_id="3.5.0beta1" var_name="item_phrase_album" added="1352731874">music album</phrase>
	</phrases>
	<user_group_settings>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="1" guest="1" staff="1" module="music" ordering="0">can_upload_music_public</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="1" guest="0" staff="1" module="music" ordering="0">can_add_comment_on_music_album</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="1" guest="0" staff="1" module="music" ordering="0">can_add_comment_on_music_song</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="0" guest="0" staff="1" module="music" ordering="0">can_edit_other_music_albums</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="1" guest="0" staff="1" module="music" ordering="0">can_edit_own_albums</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="1" guest="0" staff="1" module="music" ordering="0">can_delete_own_track</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="0" guest="0" staff="1" module="music" ordering="0">can_delete_other_tracks</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="1" guest="0" staff="1" module="music" ordering="0">can_delete_own_music_album</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="0" guest="0" staff="1" module="music" ordering="0">can_delete_other_music_albums</setting>
		<setting is_admin_setting="0" module_id="music" type="integer" admin="10" user="8" guest="0" staff="10" module="music" ordering="0">music_max_file_size</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="0" guest="0" staff="1" module="music" ordering="0">can_feature_songs</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="0" guest="0" staff="1" module="music" ordering="0">can_approve_songs</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="0" user="0" guest="0" staff="0" module="music" ordering="0">music_song_approval</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="0" guest="0" staff="1" module="music" ordering="0">can_feature_music_albums</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="1" guest="1" staff="1" module="music" ordering="0">can_access_music</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="false" user="false" guest="false" staff="false" module="music" ordering="0">can_sponsor_song</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="false" user="false" guest="false" staff="false" module="music" ordering="0">can_sponsor_album</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="false" user="false" guest="false" staff="false" module="music" ordering="0">can_purchase_sponsor_album</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="false" user="false" guest="false" staff="false" module="music" ordering="0">can_purchase_sponsor_song</setting>
		<setting is_admin_setting="0" module_id="music" type="string" admin="null" user="null" guest="null" staff="null" module="music" ordering="0">music_album_sponsor_price</setting>
		<setting is_admin_setting="0" module_id="music" type="string" admin="null" user="null" guest="null" staff="null" module="music" ordering="0">music_song_sponsor_price</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="true" user="false" guest="false" staff="false" module="music" ordering="0">auto_publish_sponsored_album</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="true" user="false" guest="false" staff="false" module="music" ordering="0">auto_publish_sponsored_song</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="1" guest="0" staff="1" module="music" ordering="0">can_edit_own_song</setting>
		<setting is_admin_setting="0" module_id="music" type="boolean" admin="1" user="0" guest="0" staff="1" module="music" ordering="0">can_edit_other_song</setting>
		<setting is_admin_setting="0" module_id="music" type="integer" admin="1" user="1" guest="0" staff="1" module="music" ordering="0">points_music_song</setting>
	</user_group_settings>
	<tables><![CDATA[a:10:{s:18:"phpfox_music_album";a:3:{s:7:"COLUMNS";a:21:{s:8:"album_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_featured";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_sponsor";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"year";a:4:{i:0;s:6:"CHAR:4";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:10:"image_path";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"server_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_track";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_play";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_score";a:4:{i:0;s:9:"DECIMAL:4";i:1;s:4:"0.00";i:2;s:0:"";i:3;s:2:"NO";}s:12:"total_rating";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:8:"album_id";s:4:"KEYS";a:6:{s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"privacy";}}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:11:"is_featured";}}s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:9:"view_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:5:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:11:"total_track";i:3;s:9:"module_id";i:4;s:7:"item_id";}}s:9:"view_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:11:"total_track";i:3;s:7:"item_id";}}s:9:"view_id_5";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"user_id";i:2;s:7:"item_id";}}}}s:25:"phpfox_music_album_rating";a:3:{s:7:"COLUMNS";a:5:{s:7:"rate_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"rating";a:4:{i:0;s:9:"DECIMAL:4";i:1;s:4:"0.00";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"rate_id";s:4:"KEYS";a:2:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:7:"user_id";}}s:9:"item_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:7:"item_id";}}}s:23:"phpfox_music_album_text";a:2:{s:7:"COLUMNS";a:3:{s:8:"album_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:4:"text";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:11:"text_parsed";a:4:{i:0;s:5:"MTEXT";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:4:"KEYS";a:1:{s:8:"album_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:8:"album_id";}}}s:18:"phpfox_music_genre";a:3:{s:7:"COLUMNS";a:3:{s:8:"genre_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:4:"name";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"name_url";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}}s:11:"PRIMARY_KEY";s:8:"genre_id";s:4:"KEYS";a:1:{s:8:"name_url";a:2:{i:0;s:5:"INDEX";i:1;s:8:"name_url";}}}s:23:"phpfox_music_genre_user";a:2:{s:7:"COLUMNS";a:3:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"genre_id";a:4:{i:0;s:5:"USINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"order_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}}}s:20:"phpfox_music_profile";a:3:{s:7:"COLUMNS";a:3:{s:7:"play_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"song_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"play_id";s:4:"KEYS";a:1:{s:7:"song_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"song_id";i:1;s:7:"user_id";}}}}s:17:"phpfox_music_song";a:3:{s:7:"COLUMNS";a:25:{s:7:"song_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"view_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"privacy";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:15:"privacy_comment";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"is_featured";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"is_sponsor";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"album_id";a:4:{i:0;s:4:"UINT";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"genre_id";a:4:{i:0;s:5:"USINT";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:5:"title";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:11:"description";a:4:{i:0;s:9:"VCHAR:255";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"song_path";a:4:{i:0;s:8:"VCHAR:50";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:9:"server_id";a:4:{i:0;s:6:"TINT:1";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:8:"explicit";a:4:{i:0;s:6:"TINT:1";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:8:"duration";a:4:{i:0;s:7:"VCHAR:5";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:8:"ordering";a:4:{i:0;s:6:"TINT:3";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_play";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_comment";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"total_like";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:13:"total_dislike";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:11:"total_score";a:4:{i:0;s:9:"DECIMAL:4";i:1;s:4:"0.00";i:2;s:0:"";i:3;s:2:"NO";}s:12:"total_rating";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:9:"module_id";a:4:{i:0;s:8:"VCHAR:75";i:1;N;i:2;s:0:"";i:3;s:3:"YES";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;s:1:"0";i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"song_id";s:4:"KEYS";a:8:{s:7:"user_id";a:2:{i:0;s:5:"INDEX";i:1;s:7:"user_id";}s:9:"view_id_3";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"view_id";i:1;s:7:"privacy";}}s:7:"view_id";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:8:"genre_id";}}s:9:"view_id_2";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:11:"is_featured";}}s:9:"view_id_4";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"user_id";}}s:9:"view_id_5";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:5:"title";}}s:9:"view_id_6";a:2:{i:0;s:5:"INDEX";i:1;a:4:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:9:"module_id";i:3;s:7:"item_id";}}s:9:"view_id_7";a:2:{i:0;s:5:"INDEX";i:1;a:3:{i:0;s:7:"view_id";i:1;s:7:"privacy";i:2;s:7:"item_id";}}}}s:24:"phpfox_music_song_rating";a:3:{s:7:"COLUMNS";a:5:{s:7:"rate_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:14:"auto_increment";i:3;s:2:"NO";}s:7:"item_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}s:6:"rating";a:4:{i:0;s:9:"DECIMAL:4";i:1;s:4:"0.00";i:2;s:0:"";i:3;s:2:"NO";}s:10:"time_stamp";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:11:"PRIMARY_KEY";s:7:"rate_id";s:4:"KEYS";a:2:{s:7:"item_id";a:2:{i:0;s:5:"INDEX";i:1;a:2:{i:0;s:7:"item_id";i:1;s:7:"user_id";}}s:9:"item_id_2";a:2:{i:0;s:5:"INDEX";i:1;s:7:"item_id";}}}s:17:"phpfox_music_user";a:2:{s:7:"COLUMNS";a:1:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:7:"user_id";}}}s:23:"phpfox_music_user_value";a:2:{s:7:"COLUMNS";a:1:{s:7:"user_id";a:4:{i:0;s:7:"UINT:10";i:1;N;i:2;s:0:"";i:3;s:2:"NO";}}s:4:"KEYS";a:1:{s:7:"user_id";a:2:{i:0;s:6:"UNIQUE";i:1;s:7:"user_id";}}}}]]></tables>
	<install><![CDATA[		
		$aGenres = array(
			'Hip Hop',
			'Rock',
			'Pop',
			'Alternative',
			'Country',
			'Indie',
			'Rap',
			'R&B',
			'Metal',
			'Punk',
			'Hardcore',
			'House',
			'Electronica',
			'Techno',
			'Reggae',
			'Latin',
			'Jazz',
			'Classic Rock',
			'Blues',
			'Folk',
			'Progressive',
		);
		
		foreach ($aGenres as $sName)
		{
			$this->database()->insert(Phpfox::getT('music_genre'), array('name' => $sName));
		}		
	]]></install>
</module>