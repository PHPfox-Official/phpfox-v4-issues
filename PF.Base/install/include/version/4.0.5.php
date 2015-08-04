<?php

return function(Phpfox_Installer $Installer) {
	$setThis = function($key, $value, $isHidden = null) use($Installer) {
		$db = Phpfox_Database::instance();

		list($module, $setting) = explode('.', $key);

		$params = [];
		if ($isHidden !== null) {
			$params = [
				'is_hidden' => $isHidden
			];
		}

		if ($value !== null) {
			$params['value_default'] = $value;
			$params['value_actual'] = $value;
		}

		$Installer->db->update(':setting', $params, ['var_name' => $setting]);
	};

	$toHideAndTrue = [
		'photo.html5_upload_photo',
		'photo.photo_upload_process',
		'tag.enable_hashtag_support',
		'ad.multi_ad',
		'mail.threaded_mail_conversation',
		'core.replace_url_with_links'
	];

	foreach ($toHideAndTrue as $setting) {
		$setThis($setting, '1', '1');
	}

	$toHideAndFalse = [
		'photo.protect_photos_from_public',
		'photo.can_rate_on_photos',
		'photo.ajax_refresh_on_featured_photos',
		'photo.auto_crop_photo',
		'photo.view_photos_in_theater_mode',
		'photo.enable_photo_battle',
		'photo.display_profile_photo_within_gallery',
		'photo.rename_uploaded_photo_names',
		'photo.show_info_on_mouseover',
		'core.enable_html_purifier',
		'core.allow_html',
		'core.resize_images',
		'core.resize_embed_video',
		'core.allow_html_in_activity_feed',
		'core.enable_html_purifier',
		'core.display_older_ie_error',
		'user.multi_step_registration_form',
		'user.suggest_usernames_on_registration'
	];

	foreach ($toHideAndFalse as $setting) {
		$setThis($setting, '0', '1');
	}

	$toHide = [
		'photo.rating_total_photos_cache',
		'photo.photo_battle_image_cache',
		'core.wysiwyg',
		'core.allowed_html',
		'core.activity_feed_line_breaks',
		'core.html_purifier_allowed_html',
		'core.html_purifier_allowed_iframes',
		'core.shorten_parsed_url_links',
		'core.meta_description_limit',
		'core.meta_keyword_limit',
		'core.description_time_stamp',
		'core.words_remove_in_keywords',
		'profile.profile_seo_for_meta_title',
		'core.crop_seo_url',
		'blog.blog_meta_description',
		'core.no_follow_on_external_links',
		'friend.friend_meta_keywords',
		'core.include_site_title_all_pages',
		'poll.poll_meta_description',
		'quiz.quiz_meta_keywords',
		'blog.blog_meta_keywords',
		'poll.poll_meta_keywords',
		'quiz.quiz_meta_description',
		'core.admin_debug_mode',
		'core.meta_description_profile',
		'user.registration_steps',
		'user.usernames_to_suggest',
		'user.how_many_usernames_to_suggest',
		'user.hide_main_menu',
		'user.new_user_terms_confirmation',
		'core.section_privacy_item_browsing',
		'core.disable_ie_warning',
		'core.use_dnscheck',
		'core.site_offline_no_template',
		'core.akismet_url',
		'core.akismet_password',
		'blog.allow_links_in_blog_title',
		'blog.spam_check_blogs',
		'comment.spam_check_comments',
		'mail.spam_check_messages',
		'user.user_browse_display_results_default'
	];

	foreach ($toHide as $setting) {
		$setThis($setting, null, '1');
	}

	$toSet = [
		'photo.in_main_photo_section_show' => 'a:2:{s:7:"default";s:6:"photos";s:6:"values";a:2:{i:0;s:6:"photos";i:1;s:6:"albums";}}',
		'photo.photo_meta_description' => '',
		'photo.photo_meta_keywords' => '',
		'photo.how_many_categories_to_show_in_title' => 0,
		'core.section_privacy_item_browsing' => 1,
		'core.friends_only_community' => 1,
		'core.disable_ie_warning' => 0,
		'core.registration_enable_dob' => 0,
		'core.registration_enable_gender' => 0,
		'user.disable_username_on_sign_up' => 0,
		'core.use_dnscheck' => 0,
		'feed.feed_only_friends' => 1
	];

	foreach ($toSet as $setting => $value) {
		$setThis($setting, $value);
	}
};
