<?php
/**
 * Upgrade log
 * - Installs v2 tables like a normal install
 * - Import users
 * - Import custom fields
 * - Import custom fields for each user
 * - Import of users friends
 * - Import of private messages
 * - Import of blogs
 * - Import photo categories
 * - Import photos
 * - Import polls
 * - Import forums
 * - Import forum threads
 * - Import forum posts
 * - Import group categories
 * - Import groups
 * - Import group members
 * - Import group threads
 * - Import group posts
 * - Import group photos
 * - Import quiz
 * - Import quiz results
 * - Import event categories
 * - Import events
 * - Import event guest lists
 * - Import bulletins
 * - Import marketplace categories
 * - Import marketplace listings
 * - Import blog comments
 * - Import profile comments
 * - Import photo comments
 * - Import music song comments
 * - Import music album comments
 * - Import video comments
 * - Import users favorites (profile, videos, songs & music albums)
 * - Import emoticons
 * - Import users background photos
 * - Import certain system settings that are compatible with v2
 * 
 * Cannot upgrade
 * - Top Friends
 * 
 * Requirement
 * - Default English language package with ID#1 to import:
 * 		- Countries for users
 * 		- States for users
 * 		- Gallery categories for photos
 */

$bCompleted = false;
$iPage = 0;
switch($this->_oReq->get('action'))
{
	case 'completed':				
	
		$bCompleted = true;
		
		break;
	case 'import-setting':		

		$aRow = $this->_db()->select('*')
			->from($this->_getOldT('sys_sett'))
			->where('code = \'gd_watermark\'')
			->execute('getRow');	
		
		if (isset($aRow['sett_id']))
		{
			if ($aRow['val'] == '1')
			{
				$aImageType = $this->_db()->select('*')
					->from($this->_getOldT('sys_sett'))
					->where('code = \'gd_watermark_image\'')
					->execute('getRow');	
					
				$aActiveSetting = $this->_db()->select('*')
					->from(Phpfox::getT('setting'))
					->where('module_id = \'core\' AND var_name = \'watermark_option\'')
					->execute('getRow');
				$aActiveSetting = unserialize($aActiveSetting['value_actual']);				
				$aActiveSetting['default'] = ($aImageType['val'] == '1' ? 'image' : 'text');
				
				$this->_db()->update(Phpfox::getT('setting'), array(
						'value_actual' => serialize($aActiveSetting)
					), 'module_id = \'core\' AND var_name = \'watermark_option\''
				);
			}
		}

		$aRow = $this->_db()->select('*')
			->from($this->_getOldT('sys_sett'))
			->where('code = \'mail_type\'')
			->execute('getRow');

		if (isset($aRow['sett_id']) && $aRow['val'] == 'smtp')
		{
			$aActiveSetting = $this->_db()->select('*')
				->from(Phpfox::getT('setting'))
				->where('module_id = \'core\' AND var_name = \'method\'')
				->execute('getRow');

			$aActiveSetting = unserialize($aActiveSetting['value_actual']);
			$aActiveSetting['default'] = 'smtp';

			$this->_db()->update(Phpfox::getT('setting'), array(
					'value_actual' => serialize($aActiveSetting)
				), 'module_id = \'core\' AND var_name = \'method\''
			);
		}

		$this->_db()->update(Phpfox::getT('user_group_setting'), array(
				'default_admin' => '1',
				'default_user' => '1',
				'default_staff' => '1',
			), 'module_id = \'music\' AND name = \'can_upload_music_public\''
		);

		$aActiveSetting = $this->_db()->select('*')
			->from(Phpfox::getT('setting'))
			->where('module_id = \'user\' AND var_name = \'login_type\'')
			->execute('getRow');

		$aActiveSetting = unserialize($aActiveSetting['value_actual']);
		$aActiveSetting['default'] = 'user_name';

		$this->_db()->update(Phpfox::getT('setting'), array(
				'value_actual' => serialize($aActiveSetting)
			), 'module_id = \'user\' AND var_name = \'login_type\''
		);

		$aImportSettings = array(
			array('gd_watermark_text' => 'core.image_text'),
			array('gd_watermark_color' => 'core.image_text_hex'),
			array('smtp_host' => 'core.mailsmtphost'),
			array('smtp_user' => 'core.mail_smtp_username'),
			array('smtp_auth' => 'core.mail_smtp_authentication'),
			array('signup_image' => 'user.captcha_on_signup'),
			array('signup_email' => 'user.verify_email_at_signup'),
			array('site_name' => 'core.site_copyright'),
			array('site_email' => 'core.email_from_email'),
			array('site_name' => 'core.mail_from_name'),
			array('site_title' => 'core.site_title'),
			array('site_title' => 'core.footer_bar_site_name'),
			array('meta_keywords' => 'core.keywords'),
			array('meta_description' => 'core.description'),
			array('smtp_pass' => 'core.mail_smtp_password'),
			array('user_min' => 'user.min_length_for_username'),
			array('user_max' => 'user.max_length_for_username')
		);

		foreach ($aImportSettings as $aImportSetting)
		{
			foreach ($aImportSetting as $sOldSetting => $sNewSetting)
			{
				$aRow = $this->_db()->select('*')
					->from($this->_getOldT('sys_sett'))
					->where('code = \'' . $this->_db()->escape($sOldSetting) . '\'')
					->execute('getRow');

				if (isset($aRow['sett_id']))
				{
					list($sModule, $sVarName) = explode('.', $sNewSetting);

					$this->_db()->update(Phpfox::getT('setting'), array(
							'value_actual' => $aRow['val']
						), 'module_id = \'' . $sModule . '\' AND var_name = \'' . $sVarName . '\''
					);
				}
			}
		}

		$aBanNames = array(
			'public',
			'browse',
			'gallery',
			'groups',
			'listing'
		);
		foreach ($aBanNames as $sBanName)
		{
			$this->_db()->insert(Phpfox::getT('ban'), array(
					'type_id' => 'username',
					'find_value' => $sBanName,
					'time_stamp' => PHPFOX_TIME
				)
			);
		}

		$aRow = $this->_db()->select('lp.text')
			->from($this->_getOldT('language_phrase'), 'lp')
			->where('lp.languageid = 1 AND lp.varname = \'site_content_terms\'')
			->execute('getRow');
		if (isset($aRow['text']))
		{
			$aPage = $this->_db()->select('page_id')
				->from(Phpfox::getT('page'))
				->where('title_url = \'terms\'')
				->execute('getRow');
			if (isset($aPage['page_id']))
			{
				$this->_db()->update(Phpfox::getT('page_text'), array(
						'text' => Phpfox::getLib('parse.input')->clean($aRow['text']),
						'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
					)
				,'page_id = ' . $aPage['page_id']);
			}
		}

		$aRow = $this->_db()->select('lp.text')
			->from($this->_getOldT('language_phrase'), 'lp')
			->where('lp.languageid = 1 AND lp.varname = \'site_content_about_us\'')
			->execute('getRow');
		if (isset($aRow['text']))
		{
			$aPage = $this->_db()->select('page_id')
				->from(Phpfox::getT('page'))
				->where('title_url = \'about\'')
				->execute('getRow');
			if (isset($aPage['page_id']))
			{
				$this->_db()->update(Phpfox::getT('page_text'), array(
						'text' => Phpfox::getLib('parse.input')->clean($aRow['text']),
						'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
					)
				,'page_id = ' . $aPage['page_id']);
			}
		}

		$sMessage = 'importing of settings completed.';
		$sAction = 'completed';
		$iPage = 0;

		break;
	case 'import-custom-pages':		
	
		$aRows = $this->_db()->select('p.*')
			->from($this->_getOldT('pages'), 'p')			
			->execute('getRows');	
		
		foreach ($aRows as $aRow)
		{
			$iPageId = $this->_db()->insert(Phpfox::getT('page'), array(
					'user_id' => '0',
					'module_id' => 'core',
					'product_id' => 'phpfox',
					'is_active' => '1',
					'is_phrase' => '0',
					'parse_php' => $aRow['allow_php'],
					'has_bookmark' => '0',
					'add_view' => '0',
					'full_size' => '1',
					'title' => Phpfox::getLib('parse.input')->clean($aRow['title_head']),
					'title_url' => $aRow['title_url'],
					'disallow_access' => null,
					'added' => PHPFOX_TIME,
					'total_view' => '0',
					'total_attachment' => '0',
					'total_tag' => '0'
				)
			);
			
			$this->_db()->insert(Phpfox::getT('page_text'), array(
					'page_id' => $iPageId,
					'text' => Phpfox::getLib('parse.input')->clean($aRow['content']),
					'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['content']),
					'keyword' => $aRow['meta'],
					'description' => null
				)
			);
			
			if (!empty($aRow['title_menu']))
			{
				$aMenu = $this->_db()->select('*')
					->from($this->_getOldT('menu'))
					->where('parent = ' . $aRow['page_id'])
					->execute('getRow');
				
				if (isset($aMenu['menu_id']))
				{
					$sVarName =  'core_' . Phpfox::getService('language.phrase.process')->prepare($aMenu['title_menu']);
					$sVarName = 'menu_' . $sVarName;	
					
					$sConnection = 'main';
					if ($aMenu['location'] == '1')
					{
						$sConnection = 'main_right';
					}
					elseif ($aMenu['location'] == '2')
					{
						$sConnection = 'footer';
					}
					
					$this->_db()->insert(Phpfox::getT('menu'), array(
							'parent_id' => '0',
							'page_id' => $iPageId,
							'm_connection' => $sConnection,
							'module_id' => 'core',
							'product_id' => 'phpfox',
							'var_name' => $sVarName,
							'is_active' => '1',
							'url_value' => str_replace('-', '.', $aMenu['url']),
							'disallow_access' => null,
							'version_id' => Phpfox::getId()
						)
					);
					
					Phpfox::getService('language.phrase.process')->add(array(
							'var_name' => $sVarName,
							'module' => 'core|core',
							'product_id' => 'phpfox',
							'text' => array(
								'en' => $aMenu['title_menu']
							)
						)
					);
				}
			}
		}
		
		$sMessage = 'importing of custom pages completed.';
		$sAction = 'import-setting';
		$iPage = 0;		
		break;
	case 'import-user-background-photo':

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('template'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id')
			->from($this->_getOldT('template'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->where('m.bg_img = \'image\'')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			if (file_exists(PHPFOX_DIR_FILE . 'pic' . PHPFOX_DS . 'user_bg' . PHPFOX_DS . $aRow['user'] . '.jpg'))
			{
				$this->_db()->insert(Phpfox::getT('user_css'), array(
						'user_id' => $aRow['new_user_id'],
						'css_selector' => '#header_holder',
						'css_property' => 'background',
						'css_value' => 'none',
						'ordering' => '1'
					)
				);

				$this->_db()->insert(Phpfox::getT('user_css'), array(
						'user_id' => $aRow['new_user_id'],
						'css_selector' => 'body',
						'css_property' => 'background-image',
						'css_value' => 'url(\'' . Phpfox::getParam('core.http') . Phpfox::getParam('core.host') . Phpfox::getParam('core.folder') . 'file/pic/user_bg/' . $aRow['user'] . '.jpg\')'
					)
				);

				$this->_db()->update(Phpfox::getT('user_field'), array('css_hash' => md5(uniqid())), 'user_id = ' . $aRow['new_user_id']);
			}
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'importing of background images for users completed.';
			$sAction = 'import-custom-pages';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing background images for users. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-user-background-photo';
		}

		break;
	case 'create-background-photo-index':

			$this->_db()->addIndex($this->_getOldT('template'), 'bg_img');

			$sMessage = 'index created for users background photos.';
			$sAction = 'import-user-background-photo';
			$iPage = 0;

		break;
	case 'import-emoticon':

		$aFiles = Phpfox::getLib('file')->getAllFiles(PHPFOX_DIR_FILE . 'smile' . PHPFOX_DS);

		foreach ($aFiles as $sFile)
		{
			if (!preg_match('/(.*)\.(gif|jpg|png|jpeg)$/i', $sFile))
			{
				continue;
			}

			$sNewFile = str_replace(PHPFOX_DIR, '', $sFile);
			$aParts = explode(PHPFOX_DS, $sNewFile);

			if (!isset($aParts[(count($aParts) - 1)]))
			{
				continue;
			}

			$sName = $aParts[(count($aParts) - 1)];
			$sName = preg_replace('/(.*)\.(.*)/i', '\\1', $sName);

			if (file_exists(PHPFOX_DIR_FILE . 'file' . PHPFOX_DS . 'pic' . PHPFOX_DS . 'emoticon' . PHPFOX_DS . 'default' . PHPFOX_DS . $aParts[(count($aParts) - 1)]))
			{
				continue;
			}

			$iCheck = $this->_db()->select('COUNT(*)')
				->from(Phpfox::getT('emoticon'))
				//->where('image = \'' . $this->_db()->escape($aParts[(count($aParts) - 1)]) . '\'')
				->where('text = \':' . $this->_db()->escape($sName) . ':\'')
				->execute('getField');

			if ($iCheck)
			{
				continue;
			}

			copy($sFile, PHPFOX_DIR . 'file' . PHPFOX_DS . 'pic' . PHPFOX_DS . 'emoticon' . PHPFOX_DS . 'default' . PHPFOX_DS . $aParts[(count($aParts) - 1)]);

			$aInsert = array(
				'title' => $sName,
				'text' => ':' . $sName . ':',
				'image' => $aParts[(count($aParts) - 1)],
				'package_path' => 'default'
			);

			$this->_db()->insert(Phpfox::getT('emoticon'), $aInsert);
		}

		$sMessage = 'importing of emoticons completed.';
		$sAction = 'create-background-photo-index';
		$iPage = 0;

		break;
	case 'import-favorite-video':

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('videos_favorite'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, u2.video_id AS new_item_id')
			->from($this->_getOldT('videos_favorite'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.id = m.user_id')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('video'), 'u2', 'u2.upgrade_item_id = m.video_id ')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'type_id' => 'video',
				'item_id' => $aRow['new_item_id'],
				'user_id' => $aRow['new_user_id'],
				'time_stamp' => $aRow['time'],
				'upgrade_item_id' => $aRow['id']
			);

			$this->_db()->insert(Phpfox::getT('favorite'), $aInsert);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'importing of favorite videos for users completed.';
			$sAction = 'import-emoticon';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing favorite videos for users. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-favorite-video';
		}

		break;
	case 'import-favorite-music-song':
	case 'import-favorite-music-album':

		switch($this->_oReq->get('action'))
		{
			case 'import-favorite-music-song':
				$sItemTable = 'music_song';
				$sItemField = 'song_id';
				$sItemType = 'music_song';
				break;
			case 'import-favorite-music-album':
				$sItemTable = 'music_album';
				$sItemField = 'album_id';
				$sItemType = 'music_album';
				break;
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('music_favorite'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, u2.' . $sItemField . ' AS new_item_id')
			->from($this->_getOldT('music_favorite'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.id = m.user_id')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT($sItemTable), 'u2', 'u2.upgrade_item_id = m.' . $sItemField)
			->where('m.' . $sItemField . ' > 0')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'type_id' => $sItemType,
				'item_id' => $aRow['new_item_id'],
				'user_id' => $aRow['new_user_id'],
				'time_stamp' => '0',
				'upgrade_item_id' => $aRow['favorite_id']
			);

			$this->_db()->insert(Phpfox::getT('favorite'), $aInsert);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'importing of favorite songs for users completed.';
			$sAction = ($this->_oReq->get('action') == 'import-favorite-music-song' ? 'import-favorite-music-album' : 'import-favorite-video');
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing favorite songs for users. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = $this->_oReq->get('action');
		}

		break;
	case 'import-favorite-profile':

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('favorite'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('favorite'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('favorite'), 'upgrade_item_id');
		}

		// Limit how many items to import per round
		$iLimit = 1;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('favorite'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, unew2.user_id AS new_item_id')
			->from($this->_getOldT('favorite'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user1')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join($this->_getOldT('user'), 'u2', 'u2.user = m.user')
			->join(Phpfox::getT('user'), 'unew2', 'unew2.upgrade_user_id = u2.id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'type_id' => 'user',
				'item_id' => $aRow['new_item_id'],
				'user_id' => $aRow['new_user_id'],
				'time_stamp' => $aRow['time'],
				'upgrade_item_id' => $aRow['id']
			);

			$this->_db()->insert(Phpfox::getT('favorite'), $aInsert);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'importing of favorite profiles for users completed.';
			$sAction = 'import-favorite-music-song';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing favorite profiles for users. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-favorite-profile';
		}

		break;
	case 'import-comment-video':

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('videos_comments'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, i.video_id AS new_item_id, i.user_id AS owner_user_id')
			->from($this->_getOldT('videos_comments'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.id = m.cm_userid')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('video'), 'i', 'i.upgrade_item_id = m.cm_mainid')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'type_id' => 'video',
				'item_id' => $aRow['new_item_id'],
				'user_id' => $aRow['new_user_id'],
				'owner_user_id' => $aRow['owner_user_id'],
				'time_stamp' => $aRow['cm_time'],
				'upgrade_item_id' => $aRow['cm_id']
			);

			$iId = $this->_db()->insert(Phpfox::getT('comment'), $aInsert);

			$aInsertText = array(
				'comment_id' => $iId,
				'text' => Phpfox::getLib('parse.input')->clean($aRow['cm_text']),
				'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['cm_text'])
			);

			$this->_db()->insert(Phpfox::getT('comment_text'), $aInsertText);
			$this->_db()->updateCounter('video', 'total_comment', 'video_id', $aRow['new_item_id']);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'importing of video comments completed.';
			$sAction = 'import-favorite-profile';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing video comments. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-comment-video';
		}

		break;
	case 'import-comment-blog':
	case 'import-comment-profile':
	case 'import-comment-photo':
	case 'import-comment-music-song':
	case 'import-comment-music-album':

		switch ($this->_oReq->get('action'))
		{
			case 'import-comment-blog':
				$sCommentTable = 'blog';
				$sCommentField = 'blog_id';
				$sCommentImportField = 'upgrade_blog_id';
				$iOldTypeId = 1;
				$sNewTypeId = 'blog';
				$sUpdateCountField = 'total_comment';
				$sUpdateCountTable = 'blog';
				$sUpdateFieldName = 'blog_id';
				$sNextCommentUpdate = 'import-comment-profile';
				$sCommentPhrase = 'Importing blog comments.';
				$sCommentPhraseCompleted = 'Import of blog comments completed.';
				break;
			case 'import-comment-profile':
				$sCommentTable = 'user';
				$sCommentField = 'user_id';
				$sCommentImportField = 'upgrade_user_id';
				$iOldTypeId = 2;
				$sNewTypeId = 'profile';
				$sUpdateCountField = 'total_comment';
				$sUpdateCountTable = 'user_field';
				$sUpdateFieldName = 'user_id';
				$sNextCommentUpdate = 'import-comment-photo';
				$sCommentPhrase = 'Importing profile comments.';
				$sCommentPhraseCompleted = 'Import profile comments completed.';
				break;
			case 'import-comment-photo':
				$sCommentTable = 'photo';
				$sCommentField = 'photo_id';
				$sCommentImportField = 'upgrade_item_id';
				$iOldTypeId = 3;
				$sNewTypeId = 'photo';
				$sUpdateCountField = 'total_comment';
				$sUpdateCountTable = 'photo';
				$sUpdateFieldName = 'photo_id';
				$sNextCommentUpdate = 'import-comment-music-song';
				$sCommentPhrase = 'Importing photo comments.';
				$sCommentPhraseCompleted = 'Import photo comments completed.';
				break;
			case 'import-comment-music-song':
				$sCommentTable = 'music_song';
				$sCommentField = 'song_id';
				$sCommentImportField = 'upgrade_item_id';
				$iOldTypeId = 4;
				$sNewTypeId = 'music_song';
				$sUpdateCountField = 'total_comment';
				$sUpdateCountTable = 'music_song';
				$sUpdateFieldName = 'song_id';
				$sNextCommentUpdate = 'import-comment-music-album';
				$sCommentPhrase = 'Importing music song comments.';
				$sCommentPhraseCompleted = 'Import of music song comments completed.';
				break;
			case 'import-comment-music-album':
				$sCommentTable = 'music_album';
				$sCommentField = 'album_id';
				$sCommentImportField = 'upgrade_item_id';
				$iOldTypeId = 5;
				$sNewTypeId = 'music_album';
				$sUpdateCountField = 'total_comment';
				$sUpdateCountTable = 'music_album';
				$sUpdateFieldName = 'album_id';
				$sNextCommentUpdate = 'import-comment-video';
				$sCommentPhrase = 'Importing music album comments.';
				$sCommentPhraseCompleted = 'Import of music album comments completed.';
				break;
		}

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('comment'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('comment'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('comment'), 'upgrade_item_id');
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('comments'))
			->where('typeid = ' . $iOldTypeId)
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, i.' . $sCommentField . ' AS new_item_id, i.user_id AS owner_user_id')
			->from($this->_getOldT('comments'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.id = m.userid')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT($sCommentTable), 'i', 'i.' . $sCommentImportField . ' = m.itemid')
			->where('typeid = ' . $iOldTypeId)
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'type_id' => $sNewTypeId,
				'item_id' => $aRow['new_item_id'],
				'user_id' => $aRow['new_user_id'],
				'owner_user_id' => $aRow['owner_user_id'],
				'time_stamp' => $aRow['time'],
				'upgrade_item_id' => $aRow['cid']
			);

			$iId = $this->_db()->insert(Phpfox::getT('comment'), $aInsert);

			$aInsertText = array(
				'comment_id' => $iId,
				'text' => Phpfox::getLib('parse.input')->clean($aRow['text']),
				'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
			);

			$this->_db()->insert(Phpfox::getT('comment_text'), $aInsertText);

			if (isset($sUpdateCountField))
			{
				$this->_db()->updateCounter($sUpdateCountTable, $sUpdateCountField, $sUpdateFieldName, $aRow['new_item_id']);
			}
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = $sCommentPhraseCompleted;
			$sAction = $sNextCommentUpdate;
			$iPage = 0;
		}
		else
		{
			$sMessage = $sCommentPhrase . ' Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = $this->_oReq->get('action');
		}

		break;
	case 'import-music-profile':

		if (!$this->_db()->isField(Phpfox::getT('music_profile'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('music_profile'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('music_profile'), 'upgrade_item_id');
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('music_favorite'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, ma.song_id AS new_song_id')
			->from($this->_getOldT('music_favorite'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.id = m.user_id')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('music_song'), 'ma', 'ma.upgrade_item_id = m.song_id')
			->where('m.song_id > 0')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'song_id' => $aRow['new_song_id'],
				'user_id' => $aRow['new_user_id'],
				'upgrade_item_id' => $aRow['favorite_id']
			);

			$this->_db()->insert(Phpfox::getT('music_profile'), $aInsert);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of music songs saved for profiles completed.';
			$sAction = 'import-comment-blog';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing music songs saved for profiles. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-music-profile';
		}

		break;
	case 'import-music-song':

		if (!$this->_db()->isField(Phpfox::getT('music_song'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('music_song'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('music_song'), 'upgrade_item_id');
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('music_song'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, ma.album_id AS new_album_id')
			->from($this->_getOldT('music_song'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.id = m.user_id')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('music_album'), 'ma', 'ma.upgrade_item_id = m.album_id')
			->where('m.album_id > 0')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'is_featured' => $aRow['song_is_featured'],
				'album_id' => $aRow['new_album_id'],
				'user_id' => $aRow['new_user_id'],
				'title' => (empty($aRow['song_title']) ? $aRow['song_id'] : Phpfox::getLib('parse.input')->clean($aRow['song_title'], 255)),
				'title_url' => Phpfox::getLib('parse.input')->prepareTitle('music', (empty($aRow['song_title']) ? $aRow['song_id'] : $aRow['song_title']), 'title_url', null, Phpfox::getT('music_song')),
				'song_path' => '{file/music_folder/' . $aRow['song_id'] . '.mp3}',
				'total_play' => $aRow['song_play'],
				'time_stamp' => strtotime($aRow['song_cdate']),
				'upgrade_item_id' => $aRow['song_id']
			);

			$this->_db()->insert(Phpfox::getT('music_song'), $aInsert);
			$this->_db()->updateCounter('music_album', 'total_track', 'album_id', $aRow['album_id']);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of music songs completed.';
			$sAction = 'import-music-profile';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing music songs. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-music-song';
		}

		break;
	case 'import-music-album':

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('music_album'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('music_album'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('music_album'), 'upgrade_item_id');
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('music_album'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id')
			->from($this->_getOldT('music_album'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.id = m.user_id')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'user_id' => $aRow['new_user_id'],
				'name' => (empty($aRow['album_title']) ? $aRow['album_id'] : Phpfox::getLib('parse.input')->clean($aRow['album_title'], 255)),
				'name_url' => Phpfox::getLib('parse.input')->prepareTitle('music', (empty($aRow['album_title']) ? $aRow['album_id'] : $aRow['album_title']), 'name_url', null, Phpfox::getT('music_album')),
				'year' => $aRow['album_year'],
				'image_path' => '{file/pic/album/' . $aRow['album_id'] . '.jpg}',
				'time_stamp' => strtotime($aRow['album_cdate']),
				'upgrade_item_id' => $aRow['album_id']
			);

			$iId = $this->_db()->insert(Phpfox::getT('music_album'), $aInsert);

			$aInsertText = array(
				'album_id' => $iId,
				'text' => Phpfox::getLib('parse.input')->clean($aRow['album_description']),
				'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['album_description'])
			);

			$this->_db()->insert(Phpfox::getT('music_album_text'), $aInsertText);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of music albums completed.';
			$sAction = 'import-music-song';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing music albums. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-music-album';
		}

		break;
	case 'import-music-genre':

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('music_genre'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('music_genre'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('music_genre'), 'upgrade_item_id');
		}

		$aRows = $this->_db()->select('*')
			->from($this->_getOldT('music_genre'))
			->execute('getRows');

		if (count($aRows))
		{
			$this->_db()->delete(Phpfox::getT('music_genre'), 'genre_id > 0');
			foreach ($aRows as $aRow)
			{
				$this->_db()->insert(Phpfox::getT('music_genre'), array(
						'name' => Phpfox::getLib('parse.input')->clean($aRow['genre_name'], 255),
						'name_url' => Phpfox::getLib('parse.input')->prepareTitle('music', $aRow['genre_name'], 'name_url', null, Phpfox::getT('music_genre')),
						'upgrade_item_id' => $aRow['genre_id']
					)
				);
			}
		}

		$sMessage = 'import of music genres completed.';
		$sAction = 'import-music-album';
		$iPage = 0;

		break;
	case 'import-video':

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('video'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('video'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('video'), 'upgrade_item_id');
		}

		$aStreams = array(
			'1'
		);

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('videos'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, gc.category_id AS new_category_id')
			->from($this->_getOldT('videos'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.id = m.vid_userid')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('video_category'), 'gc', 'gc.upgrade_item_id = m.vid_list_id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$sDestination = '{file/videos/src/' . $aRow['vid_id'] . '.flv}';
			$sVideoUrl = null;
			if (empty($aRow['vid_type']))
			{
				if (!in_array($aRow['stream_id'], $aStreams))
				{
					continue;
				}

				$sDestination = null;
				$sVideoUrl = $aRow['vid_url'];
			}

			$sImagePath = '{file/videos/image/' . $aRow['vid_id'] . '.jpg}';

			$aInsert = array(
				'is_stream' => (empty($aRow['vid_type']) ? '1' : '0'),
				'is_featured' => $aRow['featured'],
				'view_id' => '0',
				'module_id' => 'video',
				'privacy' => '0',
				'title' => Phpfox::getLib('parse.input')->clean($aRow['vid_title'], 255),
				'title_url' => Phpfox::getLib('parse.input')->prepareTitle('video', $aRow['vid_title'], 'title_url', null, Phpfox::getT('video')),
				'user_id' => $aRow['new_user_id'],
				'destination' => $sDestination,
				'file_ext' => null,
				'duration' => (empty($aRow['duration']) ? $aRow['duration'] : null),
				'image_path' => $sImagePath,
				'total_score' => $aRow['vid_rating'],
				'total_rating' => $aRow['vid_rating_count'],
				'time_stamp' => $aRow['vid_time'],
				'upgrade_item_id' => $aRow['vid_id'],
				'total_view' => $aRow['vid_total']
			);

			$iId = $this->_db()->insert(Phpfox::getT('video'), $aInsert);

			if (empty($aRow['vid_type']))
			{
				$aEmbedInsert = array(
					'video_id' => $iId,
					'video_url' => $sVideoUrl,
					'embed_code' => ''
				);

				$this->_db()->insert(Phpfox::getT('video_embed'), $aEmbedInsert);
			}

			if (!empty($aRow['vid_info']))
			{
				$aInsertText = array(
					'video_id' => $iId,
					'text' => Phpfox::getLib('parse.input')->clean($aRow['vid_info']),
					'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['vid_info'])
				);

				$this->_db()->insert(Phpfox::getT('video_text'), $aInsertText);
			}

			if (!empty($aRow['vid_tags']))
			{
				Phpfox::getService('tag.process')->add('video', $iId, $aRow['new_user_id'], implode(',', explode(' ', $aRow['vid_tags'])));
			}

			$this->_db()->insert(Phpfox::getT('video_category_data'), array(
					'video_id' => $iId,
					'category_id' => $aRow['new_category_id']
				)
			);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of videos completed.';
			$sAction = 'import-music-genre';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing videos. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-video';
		}

		break;
	case 'import-video-category':

		if (!$this->_db()->isField(Phpfox::getT('video_category'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('video_category'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('video_category'), 'upgrade_item_id');
		}

		// Import photo categories
		$aCategories = $this->_db()->select('*')
			->from($this->_getOldT('videos_list'))
			->execute('getRows');
		if (count($aCategories))
		{
			$this->_db()->delete(Phpfox::getT('video_category'), 'category_id > 0');
			foreach ($aCategories as $aCategory)
			{
				$iCategoryId = $this->_db()->insert(Phpfox::getT('video_category'), array(
						'is_active' => '1',
						'name' => Phpfox::getLib('parse.input')->clean($aCategory['list_name'], 255),
						'name_url' => Phpfox::getLib('parse.input')->prepareTitle('video', $aCategory['list_name'], 'name_url', null, Phpfox::getT('video_category')),
						'used' => $aCategory['list_total'],
						'upgrade_item_id' => $aCategory['list_id']
					)
				);
			}
		}

		$sMessage = 'import of video categories completed.';
		$sAction = 'import-video';
		$iPage = 0;

		break;
	case 'import-marketplace':

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('marketplace'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('marketplace'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('marketplace'), 'upgrade_item_id');
		}

		$aCacheCountry = array();
		$aCountries = $this->_db()->select('text, c.country_iso')
			->from($this->_getOldT('language_options'), 'lo')
			->leftJoin(Phpfox::getT('country'), 'c', 'c.name = lo.`default`')
			->where('lo.languageid = 1 AND lo.varname = \'country\'')
			->execute('getRows');
		foreach ($aCountries as $aCountry)
		{
			$aCacheCountry[$aCountry['text']] = $aCountry['country_iso'];
		}

		$aCacheCountryChild = array();
		$aCountries = $this->_db()->select('name, c.child_id')
			->from($this->_getOldT('language_options'), 'lo')
			->leftJoin(Phpfox::getT('country_child'), 'c', 'c.name = lo.`default`')
			->where('lo.languageid = 1 AND lo.varname = \'us_stat\'')
			->execute('getRows');
		foreach ($aCountries as $aCountry)
		{
			$aCacheCountryChild[$aCountry['name']] = $aCountry['child_id'];
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('listing_main'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, gc.category_id AS new_category_id')
			->from($this->_getOldT('listing_main'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('marketplace_category'), 'gc', 'gc.upgrade_item_id = m.list_id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'view_id' => 0,
				'user_id' => $aRow['new_user_id'],
				'title' => Phpfox::getLib('parse.input')->clean($aRow['title'], 255),
				'title_url' => Phpfox::getLib('parse.input')->prepareTitle('marketplace', $aRow['title'], 'title_url', null, Phpfox::getT('marketplace')),
				'short_description' => (empty($aRow['headline']) ? null : Phpfox::getLib('parse.input')->clean($aRow['headline'], 255)),
				'country_iso' => (isset($aCacheCountry[$aRow['location']]) ? $aCacheCountry[$aRow['location']] : null),
				'country_child_id' => (isset($aCacheCountryChild[$aRow['state']]) ? $aCacheCountryChild[$aRow['state']] : 0),
				'city' => (empty($aRow['city']) ? null : Phpfox::getLib('parse.input')->clean($aRow['city'])),
				'time_stamp' => $aRow['time'],
				'upgrade_item_id' => $aRow['id']
			);

			$iId = $this->_db()->insert(Phpfox::getT('marketplace'), $aInsert);

			$aInsertText = array(
				'listing_id' => $iId,
				'description' => Phpfox::getLib('parse.input')->clean($aRow['text']),
				'description_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
			);

			$this->_db()->insert(Phpfox::getT('marketplace_text'), $aInsertText);

			$this->_db()->insert(Phpfox::getT('marketplace_category_data'), array(
					'listing_id' => $iId,
					'category_id' => $aRow['new_category_id']
				)
			);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of marketplace listings completed.';
			$sAction = 'import-video-category';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing marketplace listings. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-marketplace';
		}

		break;
	case 'import-marketplace-category':

		if (!$this->_db()->isField(Phpfox::getT('marketplace_category'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('marketplace_category'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('marketplace_category'), 'upgrade_item_id');
		}

		// Import photo categories
		$aCategories = $this->_db()->select('*')
			->from($this->_getOldT('listing'))
			->execute('getRows');
		if (count($aCategories))
		{
			$this->_db()->delete(Phpfox::getT('marketplace_category'), 'category_id > 0');
			foreach ($aCategories as $aCategory)
			{
				$iCategoryId = $this->_db()->insert(Phpfox::getT('marketplace_category'), array(
						'is_active' => '1',
						'name' => Phpfox::getLib('parse.input')->clean($aCategory['name'], 255),
						'name_url' => Phpfox::getLib('parse.input')->prepareTitle('marketplace', $aCategory['name'], 'name_url', null, Phpfox::getT('marketplace_category')),
						'used' => $aCategory['num'],
						'upgrade_item_id' => $aCategory['id']
					)
				);
			}
		}

		$sMessage = 'import of marketplace categories completed.';
		$sAction = 'import-marketplace';
		$iPage = 0;

		break;
	case 'import-bulletin':

		if (!$this->_db()->isField(Phpfox::getT('bulletin'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('bulletin'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('bulletin'), 'upgrade_item_id');
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('board'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id')
			->from($this->_getOldT('board'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'user_id' => $aRow['new_user_id'],
				'title' => Phpfox::getLib('parse.input')->clean($aRow['title'], 255),
				'time_stamp' => $aRow['time'],
				'allow_comment' => '1'
			);

			$iId = $this->_db()->insert(Phpfox::getT('bulletin'), $aInsert);

			$aInsertText = array(
				'bulletin_id' => $iId,
				'text' => Phpfox::getLib('parse.input')->clean($aRow['text']),
				'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
			);

			$this->_db()->insert(Phpfox::getT('bulletin_text'), $aInsertText);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of bulletins completed.';
			$sAction = 'import-marketplace-category';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing bulletins. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-bulletin';
		}

		break;
	case 'import-event-list':

		if (!$this->_db()->isField(Phpfox::getT('event_invite'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('event_invite'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('event_invite'), 'upgrade_item_id');
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('event_invite'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, e.event_id AS new_event_id')
			->from($this->_getOldT('event_invite'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('event'), 'e', 'e.upgrade_item_id = m.event_id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'event_id' => $aRow['new_event_id'],
				'type_id' => '0',
				'rsvp_id' => $aRow['invite'],
				'user_id' => $aRow['new_user_id'],
				'invited_user_id' => $aRow['new_user_id'],
				'time_stamp' => $aRow['time']
			);

			$this->_db()->insert(Phpfox::getT('event_invite'), $aInsert);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of event guest lists completed.';
			$sAction = 'import-bulletin';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing event guest lists. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-event-list';
		}

		break;
	case 'import-event':

		if (!$this->_db()->isField(Phpfox::getT('event'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('event'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('event'), 'upgrade_item_id');
			$this->_db()->addIndex($this->_getOldT('events'), 'type');
		}

		$aCacheCountry = array();
		$aCountries = $this->_db()->select('text, c.country_iso')
			->from($this->_getOldT('language_options'), 'lo')
			->leftJoin(Phpfox::getT('country'), 'c', 'c.name = lo.`default`')
			->where('lo.languageid = 1 AND lo.varname = \'country\'')
			->execute('getRows');
		foreach ($aCountries as $aCountry)
		{
			$aCacheCountry[$aCountry['text']] = $aCountry['country_iso'];
		}

		$aCacheCountryChild = array();
		$aCountries = $this->_db()->select('name, c.child_id')
			->from($this->_getOldT('language_options'), 'lo')
			->leftJoin(Phpfox::getT('country_child'), 'c', 'c.name = lo.`default`')
			->where('lo.languageid = 1 AND lo.varname = \'us_stat\'')
			->execute('getRows');
		foreach ($aCountries as $aCountry)
		{
			$aCacheCountryChild[$aCountry['name']] = $aCountry['child_id'];
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('events'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, gc.category_id AS new_category_id')
			->from($this->_getOldT('events'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('event_category'), 'gc', 'gc.name = m.type')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$iStartTime = Phpfox::getLib('date')->mktime(0, 0, 0, $aRow['month'], $aRow['day'], $aRow['year']);

			$aInsert = array(
				'view_id' => 0,
				'privacy' => ($aRow['private'] == '1' ? '0' : '1'),
				'module_id' => 'event',
				'user_id' => $aRow['new_user_id'],
				'title' => Phpfox::getLib('parse.input')->clean($aRow['title'], 255),
				'title_url' => Phpfox::getLib('parse.input')->prepareTitle('event', $aRow['title'], 'title_url', null, Phpfox::getT('event')),
				'tag_line' => (empty($aRow['short']) ? null : Phpfox::getLib('parse.input')->clean($aRow['short'], 255)),
				'host' => null,
				'location' => (empty($aRow['place']) ? null : Phpfox::getLib('parse.input')->clean($aRow['place'], 255)),
				'country_iso' => (isset($aCacheCountry[$aRow['country']]) ? $aCacheCountry[$aRow['country']] : null),
				'country_child_id' => (isset($aCacheCountryChild[$aRow['state']]) ? $aCacheCountryChild[$aRow['state']] : 0),
				'postal_code' => (empty($aRow['zip']) ? null : $aRow['zip']),
				'city' => (empty($aRow['city']) ? null : Phpfox::getLib('parse.input')->clean($aRow['city'])),
				'time_stamp' => $aRow['time'],
				'start_time' => $iStartTime,
				'end_time' => ($iStartTime + (3600 * 6)),
				'upgrade_item_id' => $aRow['id']
			);

			$iId = $this->_db()->insert(Phpfox::getT('event'), $aInsert);

			$aInsertText = array(
				'event_id' => $iId,
				'description' => Phpfox::getLib('parse.input')->clean($aRow['text']),
				'description_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
			);

			$this->_db()->insert(Phpfox::getT('event_text'), $aInsertText);

			$this->_db()->insert(Phpfox::getT('event_category_data'), array(
					'event_id' => $iId,
					'category_id' => $aRow['new_category_id']
				)
			);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of events completed.';
			$sAction = 'import-event-list';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing events. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-event';
		}

		break;
	case 'import-event-category':

		if (!$this->_db()->isField(Phpfox::getT('event_category'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('event_category'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('event_category'), 'upgrade_item_id');
		}

		// Import photo categories
		$aCategories = $this->_db()->select('lo.varid, lo.text, lo.time')
			->from($this->_getOldT('language_options'), 'lo')
			->where('lo.languageid = 1 AND lo.varname = \'event_items\'')
			->execute('getRows');
		if (count($aCategories))
		{
			$this->_db()->delete(Phpfox::getT('event_category'), 'category_id > 0');
			foreach ($aCategories as $aCategory)
			{
				$iCategoryId = $this->_db()->insert(Phpfox::getT('event_category'), array(
						'is_active' => '1',
						'name' => Phpfox::getLib('parse.input')->clean($aCategory['text'], 255),
						'name_url' => Phpfox::getLib('parse.input')->prepareTitle('event', $aCategory['text'], 'name_url', null, Phpfox::getT('event_category')),
						'time_stamp' => $aCategory['time'],
						'upgrade_item_id' => $aCategory['varid']
					)
				);
			}
		}

		$sMessage = 'import of event categories completed.';
		$sAction = 'import-event';
		$iPage = 0;

		break;
	case 'import-quiz-result':

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('quiz_2'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, q.quiz_id AS new_quiz_id')
			->from($this->_getOldT('quiz_2'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('quiz'), 'q', 'q.upgrade_item_id = m.quizid')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aResults = $this->_db()->select('q1.*, qq.question_id AS new_question_id, qa.answer_id AS new_answer_id')
				->from($this->_getOldT('quiz_1'), 'q1')
				->join(Phpfox::getT('quiz_question'), 'qq', 'qq.question = q1.q AND qq.quiz_id = ' . $aRow['new_quiz_id'])
				->join(Phpfox::getT('quiz_answer'), 'qa', 'qa.answer = q1.a1 AND qa.question_id = qq.question_id')
				->where('q1.id = ' . $aRow['id'])
				->execute('getRows');

			foreach ($aResults as $aResult)
			{
				$aInsert = array(
					'quiz_id' => $aRow['new_quiz_id'],
					'question_id' => $aResult['new_question_id'],
					'answer_id' => $aResult['new_answer_id'],
					'user_id' => $aRow['new_user_id'],
					'time_stamp' => $aRow['time']
				);

				$this->_db()->insert(Phpfox::getT('quiz_result'), $aInsert);
			}
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of quiz results completed.';
			$sAction = 'import-event-category';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing quiz results. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-quiz-result';
		}

		break;
	case 'import-quiz':

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('quiz'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('quiz'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('quiz'), 'upgrade_item_id');
			$this->_db()->query('ALTER TABLE ' . $this->_getOldT('quiz'). ' CHANGE `cid` `cid` INT NOT NULL');
			$this->_db()->addIndex($this->_getOldT('quiz'), 'cid');

			$this->_db()->query('ALTER TABLE ' . $this->_getOldT('quiz_1'). ' CHANGE `id` `id` INT NOT NULL');
			$this->_db()->addIndex($this->_getOldT('quiz_1'), 'id');
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('hot_quiz'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id')
			->from($this->_getOldT('hot_quiz'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'view_id' => ($aRow['type'] == '2' ? '0' : '1'),
				'user_id' => $aRow['new_user_id'],
				'title' => Phpfox::getLib('parse.input')->clean($aRow['title'], 255),
				'title_url' => Phpfox::getLib('parse.input')->prepareTitle('quiz', $aRow['title'], 'title_url', $aRow['new_user_id'], Phpfox::getT('quiz')),
				'privacy' => '1',
				'time_stamp' => $aRow['time'],
				'total_view' => $aRow['views'],
				'allow_comment' => '1',
				'upgrade_item_id' => $aRow['id']
			);

			$iId = $this->_db()->insert(Phpfox::getT('quiz'), $aInsert);

			$aQuestions = $this->_db()->select('*')
				->from($this->_getOldT('quiz'))
				->where('cid = ' . $aRow['id'])
				->execute('getRows');

			foreach ($aQuestions as $aQuestion)
			{
				$aInsertQuestion = array(
					'quiz_id' => $iId,
					'question' => Phpfox::getLib('parse.input')->clean($aQuestion['q1'], 255)
				);

				$iQuestionId = $this->_db()->insert(Phpfox::getT('quiz_question'), $aInsertQuestion);

				for ($i = 1; $i < 5; $i++)
				{

				    if (!isset($aQuestion['a' . $i]) || empty($aQuestion['a' . $i]))
				    {
					continue;
				    }
					$aInsertAnswer = array(
						'question_id' => $iQuestionId,
						'answer' => Phpfox::getLib('parse.input')->clean($aQuestion['a' . $i], 255),
						'is_correct' => ($aQuestion['answer'] == $aQuestion['a' . $i] ? '1' : '0')
					);

					$this->_db()->insert(Phpfox::getT('quiz_answer'), $aInsertAnswer);
				}
			}
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of quizzes completed.';
			$sAction = 'import-quiz-result';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing quizzes. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-quiz';
		}

		break;
	case 'import-group-photo':

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('group_gallery'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, g.group_id AS new_group_id')
			->from($this->_getOldT('group_gallery'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('group'), 'g', 'g.upgrade_item_id = m.group_id')
			->where('m.default = 0')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'privacy' => '0',
				'group_id' => $aRow['new_group_id'],
				'title' => (empty($aRow['title']) ? $aRow['id'] : Phpfox::getLib('parse.input')->clean($aRow['title'], 255)),
				'title_url' => (empty($aRow['title']) ? $aRow['id'] : Phpfox::getLib('parse.input')->prepareTitle('photo', $aRow['title'], 'title_url', null, Phpfox::getT('photo'))),
				'user_id' => $aRow['new_user_id'],
				'destination' => '{file/pic/groups/gallery/' . $aRow['id'] . '.jpg}',
				'allow_rate' => 0,
				'time_stamp' => $aRow['time'],
				'total_view' => 0,
				'total_rating' => '0.00',
				'total_vote' => 0,
				'total_battle' => 0,
				'is_featured' => 0,
				'upgrade_item_id' => $aRow['id']
			);

			$iId = $this->_db()->insert(Phpfox::getT('photo'), $aInsert);

			$sFilePath = PHPFOX_DIR_FILE . 'pic' . PHPFOX_DS . 'groups' . PHPFOX_DS . 'gallery' . PHPFOX_DS . $aRow['id'] . '.jpg';
			$iWidth = 0;
			$iHeight = 0;
			if (file_exists($sFilePath))
			{
				list($iWidth, $iHeight) = getimagesize($sFilePath);
			}

			$aInsertInfo = array(
				'photo_id' => $iId,
				'file_name' => '' . $aRow['id'] . '.jpg',
				'file_size' => (file_exists($sFilePath) ? filesize($sFilePath) : '0'),
				'mime_type' => 'image/jpeg',
				'extension' => 'jpg',
				'width' => $iWidth,
				'height' => $iHeight
			);
			
			$this->_db()->insert(Phpfox::getT('photo_info'), $aInsertInfo);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of group photos completed.';
			$sAction = 'import-quiz';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing group photos. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-group-photo';
		}

		break;
	case 'import-group-forum-reply':
		
		// Limit how many items to import per round
		$iLimit = 200;		
	
		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('group_forum'), 'm')
			->where('m.type = \'reply\'')
			->execute('getField');
			
		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, g.group_id AS new_group_id, ft.thread_id AS new_thread_id')
			->from($this->_getOldT('group_forum'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('group'), 'g', 'g.upgrade_item_id = m.group_id')
			->join(Phpfox::getT('forum_thread'), 'ft', 'ft.forum_id = 0 AND ft.upgrade_item_id = m.reply_id')
			->leftJoin($this->_getOldT('group_forum'), 'gf', 'gf.reply_id = m.id AND gf.type = \'reply\'')
			->where('m.type = \'reply\'')
			->group('m.id')
			->order('m.time ASC')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');
			
		foreach ($aRows as $aRow)
		{
			$aInsertPost = array(
				'thread_id' => $aRow['new_thread_id'],
				'user_id' => $aRow['new_user_id'],
				'title' => (empty($aRow['title']) ? null : Phpfox::getLib('parse.input')->clean($aRow['title'], 255)),
				'time_stamp' => $aRow['time'],
				'upgrade_item_id' => $aRow['id']
			);
			
			$iPostId = $this->_db()->insert(Phpfox::getT('forum_post'), $aInsertPost);
			
			$aInsertPostText = array(
				'post_id' => $iPostId,
				'text' => Phpfox::getLib('parse.input')->clean($aRow['text']),
				'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
			);
			
			$this->_db()->insert(Phpfox::getT('forum_post_text'), $aInsertPostText);
				
			$this->_db()->update(Phpfox::getT('forum_thread'), array(
					'post_id' => $iPostId,
					'last_user_id' => $aRow['new_user_id'],
					'time_update' => $aRow['time']
				), 'thread_id = ' . $aRow['new_thread_id']);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of group forum posts completed.';
			$sAction = 'import-group-photo';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing group forum posts. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-group-forum-reply';
		}
		break;
	case 'import-group-forum-thread':

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('group_forum'))
			->where('type = \'\'')
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, g.group_id AS new_group_id, COUNT(gf.id) AS total_post')
			->from($this->_getOldT('group_forum'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('group'), 'g', 'g.upgrade_item_id = m.group_id')
			->leftJoin($this->_getOldT('group_forum'), 'gf', 'gf.reply_id = m.id AND gf.type = \'reply\'')
			->where('m.type = \'\'')
			->group('m.id')
			->order('m.time DESC')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'forum_id' => 0,
				'group_id' => $aRow['new_group_id'],
				'is_announcement' => 0,
				'user_id' => $aRow['new_user_id'],
				'title' => Phpfox::getLib('parse.input')->clean($aRow['title'], 255),
				'title_url' => Phpfox::getLib('parse.input')->prepareTitle('forum', $aRow['title'], 'title_url', null, Phpfox::getT('forum_thread')),
				'time_stamp' => $aRow['time'],
				'time_update' => $aRow['time'],
				'order_id' => 0,
				'total_post' => $aRow['total_post'],
				'total_view' => $aRow['views'],
				'upgrade_item_id' => $aRow['id']
			);

			$iId = $this->_db()->insert(Phpfox::getT('forum_thread'), $aInsert);

			$aInsertPost = array(
				'thread_id' => $iId,
				'user_id' => $aRow['new_user_id'],
				'title' => Phpfox::getLib('parse.input')->clean($aRow['title'], 255),
				'time_stamp' => $aRow['time']
			);

			$iPostId = $this->_db()->insert(Phpfox::getT('forum_post'), $aInsertPost);

			$aInsertPostText = array(
				'post_id' => $iPostId,
				'text' => Phpfox::getLib('parse.input')->clean($aRow['text']),
				'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
			);

			$this->_db()->insert(Phpfox::getT('forum_post_text'), $aInsertPostText);

			$this->_db()->update(Phpfox::getT('forum_thread'), array('start_id' => $iPostId), 'thread_id = ' . (int) $iId);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of group threads completed.';
			$sAction = 'import-group-forum-reply';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing group threads. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-group-forum-thread';
		}

		break;
	case 'import-group-member':

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('group_invite'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('group_invite'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('group_invite'), 'upgrade_item_id');
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('group_member'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, g.group_id AS new_group_id, g.user_id AS group_admin_id')
			->from($this->_getOldT('group_member'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('group'), 'g', 'g.upgrade_item_id = m.group_id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'group_id' => $aRow['new_group_id'],
				'is_admin' => ($aRow['group_admin_id'] == $aRow['new_user_id'] ? '1' : '0'),
				'member_id' => '1',
				'user_id' => $aRow['new_user_id'],
				'invited_user_id' => $aRow['new_user_id'],
				'time_stamp' => $aRow['time']
			);

			$this->_db()->insert(Phpfox::getT('group_invite'), $aInsert);


		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of group members completed.';
			$sAction = 'import-group-forum-thread';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing group members. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-group-member';
		}

		break;
	case 'import-group':

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('group'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('group'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('group'), 'upgrade_item_id');
		}

		$aCacheCountry = array();
		$aCountries = $this->_db()->select('text, c.country_iso')
			->from($this->_getOldT('language_options'), 'lo')
			->leftJoin(Phpfox::getT('country'), 'c', 'c.name = lo.`default`')
			->where('lo.languageid = 1 AND lo.varname = \'country\'')
			->execute('getRows');
		foreach ($aCountries as $aCountry)
		{
			$aCacheCountry[$aCountry['text']] = $aCountry['country_iso'];
		}

		$aCacheCountryChild = array();
		$aCountries = $this->_db()->select('name, c.child_id')
			->from($this->_getOldT('language_options'), 'lo')
			->leftJoin(Phpfox::getT('country_child'), 'c', 'c.name = lo.`default`')
			->where('lo.languageid = 1 AND lo.varname = \'us_stat\'')
			->execute('getRows');
		foreach ($aCountries as $aCountry)
		{
			$aCacheCountryChild[$aCountry['name']] = $aCountry['child_id'];
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('group_main'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, gc.category_id AS new_category_id, COUNT(gm.id) AS total_member, gg.id AS group_image_id')
			->from($this->_getOldT('group_main'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('group_category'), 'gc', 'gc.upgrade_item_id = m.type')
			->leftJoin($this->_getOldT('group_member'), 'gm', 'gm.group_id = m.id')
			->leftJoin($this->_getOldT('group_gallery'), 'gg', 'gg.group_id = m.id AND gg.default = 1')
			->group('m.id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$iViewId = 0;
			if (strtolower($aRow['hide_group']) == 'yes')
			{
				$iViewId = 2;
			}
			else
			{
				if (strtolower($aRow['open_join']) == 'no')
				{
					$iViewId = 1;
				}
				else
				{

				}
			}

			$aInsert = array(
				'view_id' => $iViewId,
				'user_id' => $aRow['new_user_id'],
				'title' => Phpfox::getLib('parse.input')->clean($aRow['title'], 255),
				'title_url' => Phpfox::getLib('parse.input')->prepareTitle('group', $aRow['title'], 'title_url', null, Phpfox::getT('group')),
				'short_description' => (empty($aRow['headline']) ? null : Phpfox::getLib('parse.input')->clean($aRow['headline'], 255)),
				'country_iso' => (isset($aCacheCountry[$aRow['location']]) ? $aCacheCountry[$aRow['location']] : null),
				'postal_code' => (empty($aRow['zip']) ? null : $aRow['zip']),
				'country_child_id' => (isset($aCacheCountryChild[$aRow['state']]) ? $aCacheCountryChild[$aRow['state']] : 0),
				'city' => (empty($aRow['city']) ? null : Phpfox::getLib('parse.input')->clean($aRow['city'])),
				'time_stamp' => $aRow['time'],
				'image_path' => (empty($aRow['group_image_id']) ? null : '{file/pic/groups/gallery/' . $aRow['group_image_id'] . '.jpg}'),
				'total_member' => $aRow['total_member'],
				'upgrade_item_id' => $aRow['id']
			);

			$iId = $this->_db()->insert(Phpfox::getT('group'), $aInsert);

			$aInsertText = array(
				'group_id' => $iId,
				'description' => Phpfox::getLib('parse.input')->clean($aRow['text']),
				'description_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
			);

			$this->_db()->insert(Phpfox::getT('group_text'), $aInsertText);

			$this->_db()->insert(Phpfox::getT('group_category_data'), array(
					'group_id' => $iId,
					'category_id' => $aRow['new_category_id']
				)
			);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of groups completed.';
			$sAction = 'import-group-member';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing groups. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-group';
		}

		break;
	case 'import-group-category':

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('group_category'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('group_category'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('group_category'), 'upgrade_item_id');
		}

		$aRows = $this->_db()->select('*')
			->from($this->_getOldT('group_name'))
			->execute('getRows');

		if (count($aRows))
		{
			$this->_db()->delete(Phpfox::getT('group_category'), 'category_id > 0');
			foreach ($aRows as $aRow)
			{
				$aInsert = array(
					'is_active' => '1',
					'name' => Phpfox::getLib('parse.input')->clean($aRow['name'], 255),
					'name_url' => Phpfox::getLib('parse.input')->prepareTitle('group', $aRow['name'], 'name_url', null, Phpfox::getT('group_category')),
					'used' => $aRow['total'],
					'upgrade_item_id' => $aRow['id']
				);

				$this->_db()->insert(Phpfox::getT('group_category'), $aInsert);
			}
		}

		$sMessage = 'import of group categories completed.';
		$sAction = 'import-group';
		$iPage = 0;

		break;
	case 'import-forum-reply':

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('forum_post'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('forum_post'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('forum_post'), 'upgrade_item_id');
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('forum_reply'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			//->join(Phpfox::getT('forum'), 'f', 'f.upgrade_item_id = m.type')
			->join(Phpfox::getT('forum_thread'), 'ff', 'ff.upgrade_item_id = m.fid')
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, ff.forum_id AS new_forum_id, ff.thread_id AS new_thread_id')
			->from($this->_getOldT('forum_reply'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			//->join(Phpfox::getT('forum'), 'f', 'f.upgrade_item_id = m.type')
			->join(Phpfox::getT('forum_thread'), 'ff', 'ff.upgrade_item_id = m.fid')
			->order('m.time ASC')
			->group('m.id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsertPost = array(
				'thread_id' => $aRow['new_thread_id'],
				'user_id' => $aRow['new_user_id'],
				'title' => null,
				'time_stamp' => $aRow['time'],
				'upgrade_item_id' => $aRow['id']
			);

			$iPostId = $this->_db()->insert(Phpfox::getT('forum_post'), $aInsertPost);

			$aInsertPostText = array(
				'post_id' => $iPostId,
				'text' => Phpfox::getLib('parse.input')->clean($aRow['text']),
				'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
			);

			$this->_db()->insert(Phpfox::getT('forum_post_text'), $aInsertPostText);

			$this->_db()->update(Phpfox::getT('forum'), array(
					'thread_id' => $aRow['new_thread_id'],
					'post_id' => $iPostId,
					'last_user_id' => $aRow['new_user_id']
				), 'forum_id = ' . $aRow['new_forum_id']);

			$this->_db()->update(Phpfox::getT('forum_thread'), array(
					'post_id' => $iPostId,
					'last_user_id' => $aRow['new_user_id'],
					'time_update' => $aRow['time']
				), 'thread_id = ' . $aRow['new_thread_id']);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of forum posts completed.';
			$sAction = 'import-group-category';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing forum posts. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-forum-reply';
		}

		break;
	case 'import-forum-thread':

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('forum_thread'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('forum_thread'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('forum_thread'), 'upgrade_item_id');
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('forum_topic'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, f.forum_id AS new_forum_id')
			->from($this->_getOldT('forum_topic'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('forum'), 'f', 'f.upgrade_item_id = m.type')
			->order('m.last_time DESC')
			->group('m.id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'forum_id' => $aRow['new_forum_id'],
				'is_announcement' => ($aRow['forum_type'] == '4' ? '1' : '0'),
				'user_id' => $aRow['new_user_id'],
				'title' => Phpfox::getLib('parse.input')->clean($aRow['title'], 255),
				'title_url' => Phpfox::getLib('parse.input')->prepareTitle('forum', $aRow['title'], 'title_url', null, Phpfox::getT('forum_thread')),
				'time_stamp' => $aRow['time'],
				'time_update' => $aRow['last_time'],
				'order_id' => ($aRow['forum_type'] == '3' ? '1' : '0'),
				'total_post' => $aRow['total_replies'],
				'total_view' => $aRow['view'],
				'upgrade_item_id' => $aRow['id']
			);

			$iId = $this->_db()->insert(Phpfox::getT('forum_thread'), $aInsert);

			$aInsertPost = array(
				'thread_id' => $iId,
				'user_id' => $aRow['new_user_id'],
				'title' => Phpfox::getLib('parse.input')->clean($aRow['title'], 255),
				'time_stamp' => $aRow['time']
			);

			$iPostId = $this->_db()->insert(Phpfox::getT('forum_post'), $aInsertPost);

			$aInsertPostText = array(
				'post_id' => $iPostId,
				'text' => Phpfox::getLib('parse.input')->clean($aRow['text']),
				'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
			);

			$this->_db()->insert(Phpfox::getT('forum_post_text'), $aInsertPostText);

			$this->_db()->update(Phpfox::getT('forum_thread'), array('start_id' => $iPostId), 'thread_id = ' . (int) $iId);

			if ($aRow['forum_type'] == '4')
			{
				$this->_db()->insert(Phpfox::getT('forum_announcement'), array(
						'forum_id' => $aRow['new_forum_id'],
						'thread_id' => $iId
					)
				);
			}

			$this->_db()->update(Phpfox::getT('forum'), array(
					'thread_id' => $iId,
					'post_id' => $iPostId,
					'last_user_id' => $aRow['new_user_id']
				), 'forum_id = ' . $aRow['new_forum_id']);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of forum threads completed.';
			$sAction = 'import-forum-reply';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing forum threads. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-forum-thread';
		}

		break;
	case 'import-forum':

		// Add upgrade field for the table
		if (!$this->_db()->isField(Phpfox::getT('forum'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('forum'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('forum'), 'upgrade_item_id');
		}

		$aRows = $this->_db()->select('*')
			->from($this->_getOldT('forum'))
			->execute('getRows');

		if (count($aRows))
		{
			$this->_db()->delete(Phpfox::getT('forum'), 'forum_id > 0');
			foreach ($aRows as $aRow)
			{
				$aInsert = array(
					'name' => Phpfox::getLib('parse.input')->clean($aRow['forum_title'], 255),
					'name_url' => Phpfox::getLib('parse.input')->prepareTitle('forum', $aRow['forum_title'], 'name_url', null, Phpfox::getT('forum')),
					'description' => (empty($aRow['forum_info']) ? null : $aRow['forum_info']),
					'total_post' => $aRow['total_posts'],
					'total_thread' => $aRow['total_topics'],
					'upgrade_item_id' => $aRow['forum_id']
				);

				$this->_db()->insert(Phpfox::getT('forum'), $aInsert);
			}
		}

		$sMessage = 'import of forums completed.';
		$sAction = 'import-forum-thread';
		$iPage = 0;

		break;
	case 'import-poll-result':

		// Limit how many items to import per round
		$iLimit = 100;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('poll_vote'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, pa.answer_id, p.poll_id')
			->from($this->_getOldT('poll_vote'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->join(Phpfox::getT('poll'), 'p', 'p.upgrade_item_id = m.id')
			->join(Phpfox::getT('poll_answer'), 'pa', 'pa.poll_id = p.poll_id')
			->where('m.answer = pa.answer')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			if (empty($aRow['id']))
			{
				continue;
			}

			$this->_db()->insert(Phpfox::getT('poll_result'), array(
					'poll_id' => $aRow['poll_id'],
					'answer_id' => $aRow['answer_id'],
					'user_id' => $aRow['new_user_id'],
					'time_stamp' => $aRow['time']
				)
			);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of poll results completed.';
			$sAction = 'import-forum';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing poll results. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-poll-result';
		}

		break;
	case 'create-poll-result-index':

			$this->_db()->query('ALTER TABLE ' . $this->_getOldT('poll_vote'). ' CHANGE answer answer VARCHAR( 255 ) NOT NULL');
			$this->_db()->addIndex($this->_getOldT('poll_vote'), 'answer');

			$sMessage = 'index created for poll results.';
			$sAction = 'import-poll-result';
			$iPage = 0;

		break;
	case 'import-poll':

		// Add upgrade field for poll table
		if (!$this->_db()->isField(Phpfox::getT('poll'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('poll'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('poll'), 'upgrade_item_id');
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('polls'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id')
			->from($this->_getOldT('polls'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.user')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'user_id' => $aRow['new_user_id'],
				'question' => Phpfox::getLib('parse.input')->clean($aRow['poll'], 255),
				'question_url' => Phpfox::getLib('parse.input')->prepareTitle('poll', $aRow['poll'], 'question_url', $aRow['new_user_id'], Phpfox::getT('poll')),
				'privacy' => '1',
				'allow_comment' => '1',
				'time_stamp' => $aRow['time'],
				'upgrade_item_id' => $aRow['id']
			);

			$iId = $this->_db()->insert(Phpfox::getT('poll'), $aInsert);

			for ($i = 1; $i < 5; $i++)
			{
			    // Only add non-empty answers
			    if (!empty($aRow['o' . $i]) && strlen($aRow['o' . $i]) > 0)
			    {
				$aInsertAnswer = array(
					'poll_id' => $iId,
					'answer' => $aRow['o' . $i],
					'total_votes' => $aRow['a' . $i]
				);

				$this->_db()->insert(Phpfox::getT('poll_answer'), $aInsertAnswer);
			    }
			}
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of polls completed.';
			$sAction = 'create-poll-result-index';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing polls. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-poll';
		}

		break;
	case 'import-photo':

		// Add upgrade field for photo table
		if (!$this->_db()->isField(Phpfox::getT('photo'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('photo'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('photo'), 'upgrade_item_id');
		}

		// Limit how many items to import per round
		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('main'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id, pc.category_id AS new_category_id')
			->from($this->_getOldT('main'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.id = m.user_id')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->leftJoin(Phpfox::getT('photo_category'), 'pc', 'pc.upgrade_item_id = m.category')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');
		
		foreach ($aRows as $aRow)
		{
			$bIsOriginal = true;
			$sFilePath = PHPFOX_DIR_FILE . 'pic' . PHPFOX_DS . 'gallery' . PHPFOX_DS . $aRow['id'] . '.jpg';

			if (!file_exists($sFilePath))
			{
			    $sFilePath = PHPFOX_DIR_FILE . 'pic' . PHPFOX_DS . 'gallery' . PHPFOX_DS . $aRow['id'] . '_view.jpg';
			    $bIsOriginal = false;
			    if (!file_exists($sFilePath))
			    {

				continue;
			    }
			}

			$aInsert = array(
				'privacy' => (empty($aRow['who_view']) ? '0' : ($aRow['who_view'] == '1' ? '2' : '4')),
				'title' => (empty($aRow['text']) ? $aRow['id'] : Phpfox::getLib('parse.input')->clean($aRow['text'], 255)),
				'title_url' => (empty($aRow['text']) ? $aRow['id'] : Phpfox::getLib('parse.input')->prepareTitle('photo', $aRow['text'], 'title_url', $aRow['new_user_id'], Phpfox::getT('photo'))),
				'user_id' => $aRow['new_user_id'],
				//'destination' => '{file/pic/gallery/' . $aRow['id'] . '.jpg}',
				'destination' => $bIsOriginal? '{file/pic/gallery/' . $aRow['id'] . '.jpg}' : '{file/pic/gallery/' . $aRow['id'] . '_view.jpg}',
				'allow_rate' => (empty($aRow['who_view']) ? '1' : '0'),
				'time_stamp' => $aRow['time'],
				'total_view' => $aRow['view'],
				'total_rating' => $aRow['rating'],
				'total_vote' => $aRow['votes'],
				'total_battle' => $aRow['faceoff'],
				'is_featured' => $aRow['feature'],
				'upgrade_item_id' => $aRow['id']
			);

			$iId = $this->_db()->insert(Phpfox::getT('photo'), $aInsert);

			if (!empty($aRow['new_category_id']))
			{
				Phpfox::getService('photo.category.process')->updateForItem($iId, $aRow['new_category_id']);
			}

			$iWidth = 0;
			$iHeight = 0;
			if (file_exists($sFilePath))
			{
				list($iWidth, $iHeight) = getimagesize($sFilePath);
			}

			$aInsertInfo = array(
				'photo_id' => $iId,
				'file_name' => '' . $aRow['id'] . '.jpg',
				'file_size' => (file_exists($sFilePath) ? filesize($sFilePath) : '0'),
				'mime_type' => 'image/jpeg',
				'extension' => 'jpg',
				'width' => $iWidth,
				'height' => $iHeight
			);

			$this->_db()->insert(Phpfox::getT('photo_info'), $aInsertInfo);

			if (!empty($aRow['tags']))
			{
				Phpfox::getService('tag.process')->add('photo', $iId, $aRow['new_user_id'], implode(',', explode(' ', $aRow['tags'])));
			}
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of photos completed.';
			$sAction = 'import-poll';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing photos. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-photo';
		}

		break;
	case 'import-photo-category':

		if (!$this->_db()->isField(Phpfox::getT('photo_category'), 'upgrade_item_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('photo_category'),
					'field' => 'upgrade_item_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('photo_category'), 'upgrade_item_id');
		}

		// Import photo categories
		$aCategories = $this->_db()->select('lo.varid, lo.text, lo.time')
			->from($this->_getOldT('language_options'), 'lo')
			->where('lo.languageid = 1 AND lo.varname = \'image_cat\'')
			->execute('getRows');
		if (count($aCategories))
		{
			$this->_db()->delete(Phpfox::getT('photo_category'), 'category_id > 0');
			foreach ($aCategories as $aCategory)
			{
				$iCategoryId = $this->_db()->insert(Phpfox::getT('photo_category'), array(
						'name' => Phpfox::getLib('parse.input')->clean($aCategory['text'], 255),
						'name_url' => Phpfox::getLib('parse.input')->prepareTitle('photo', $aCategory['text'], 'name_url', null, Phpfox::getT('photo_category')),
						'time_stamp' => $aCategory['time'],
						'upgrade_item_id' => $aCategory['varid']
					)
				);
			}
		}

		$sMessage = 'import of photo categories completed.';
		$sAction = 'import-photo';
		$iPage = 0;

		break;
	case 'import-blog':

		if (!$this->_db()->isField(Phpfox::getT('blog'), 'upgrade_blog_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('blog'),
					'field' => 'upgrade_blog_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('blog'), 'upgrade_blog_id');
		}

		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('journal'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, unew.user_id AS new_user_id')
			->from($this->_getOldT('journal'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.id = m.user_id')
			->join(Phpfox::getT('user'), 'unew', 'unew.upgrade_user_id = u.id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'user_id' => $aRow['new_user_id'],
				'title' => (empty($aRow['title']) ? $aRow['id'] : Phpfox::getLib('parse.input')->clean($aRow['title'], 255)),
				'title_url' => Phpfox::getService('blog')->prepareTitle((empty($aRow['title']) ? $aRow['id'] : $aRow['title'])),
				'time_stamp' => $aRow['time'],
				'is_approved' => 1,
				'privacy' => '1',
				'post_status' => '1',
				'password' => null,
				'allow_comment' => '1',
				'allow_ping' => '0',
				'total_attachment' => '0',
				'total_view' => $aRow['view'],
				'upgrade_blog_id' => $aRow['id']
			);

			$iId = $this->_db()->insert(Phpfox::getT('blog'), $aInsert);

			$this->_db()->insert(Phpfox::getT('blog_text'), array(
					'blog_id' => $iId,
					'text' => Phpfox::getLib('parse.input')->clean($aRow['text']),
					'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
				)
			);

			if (!empty($aRow['tags']))
			{
				Phpfox::getService('tag.process')->add('blog', $iId, $aRow['new_user_id'], implode(',', explode(' ', $aRow['tags'])));
			}
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of blogs completed.';
			$sAction = 'import-photo-category';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing blogs. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-blog';
		}

		break;
	case 'import-pm':

		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('mail'))
			->execute('getField');

		$aRows = $this->_db()->select('m.*, viewer.user_id AS viewer_user_id, owner.user_id AS owner_user_id, u.id AS old_viewer_id, u2.id AS old_owner_id')
			->from($this->_getOldT('mail'), 'm')
			->join($this->_getOldT('user'), 'u', 'u.user = m.to')
			->join(Phpfox::getT('user'), 'viewer', 'viewer.upgrade_user_id = u.id')
			->join($this->_getOldT('user'), 'u2', 'u2.user = m.from')
			->join(Phpfox::getT('user'), 'owner', 'owner.upgrade_user_id = u2.id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		foreach ($aRows as $aRow)
		{
			$iViewerTypeId = 0;
			$iOwnerTypeId = 0;
			if ($aRow['is_del_sent'] > 0)
			{
				if ($aRow['old_viewer_id'] == $aRow['is_del_sent'])
				{
					$iViewerTypeId = 1;		
				}
				elseif ($aRow['old_owner_id'] == $aRow['is_del_sent'])
				{
					$iOwnerTypeId = 1;		
				}
			}
			
			$aInsert = array(
				'parent_id' => 0,
				'subject' => Phpfox::getLib('parse.input')->clean($aRow['title'], 255),
				'preview' => Phpfox::getLib('parse.input')->clean(strip_tags($aRow['text']), 255),
				'owner_user_id' => $aRow['owner_user_id'],
				'owner_type_id' => $iOwnerTypeId,
				'viewer_user_id' => $aRow['viewer_user_id'],
				'viewer_is_new' => 0,
				'viewer_type_id' => $iViewerTypeId,
				'time_stamp' => $aRow['time'],
				'time_updated' => $aRow['time'],
				'total_attachment' => 0
			);

			$iId = $this->_db()->insert(Phpfox::getT('mail'), $aInsert);

			$this->_db()->insert(Phpfox::getT('mail_text'), array(
					'mail_id' => $iId,
					'text' => Phpfox::getLib('parse.input')->clean($aRow['text']),
					'text_parsed' => Phpfox::getLib('parse.input')->prepare($aRow['text'])
				)
			);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of private messages completed.';
			$sAction = 'import-blog';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing private messages. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-pm';
		}

		break;
	case 'create-pm-index':

			$this->_db()->addIndex($this->_getOldT('mail'), '`to`');
			$this->_db()->addIndex($this->_getOldT('mail'), '`from`');

			$sMessage = 'index created for private messages.';
			$sAction = 'import-pm';
			$iPage = 0;

		break;
	case 'import-friend':

		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('friends'))
			->execute('getField');

		$aFriends = $this->_db()->select('nuser.user_id, nfriend.user_id AS friend_user_id, f.time, f.top, f.top_order')
			->from($this->_getOldT('friends'), 'f')
			->join($this->_getOldT('user'), 'u', 'u.user = f.user')
			->join(Phpfox::getT('user'), 'nuser', 'nuser.upgrade_user_id = u.id')
			->join($this->_getOldT('user'), 'uf', 'uf.user = f.friend')
			->join(Phpfox::getT('user'), 'nfriend', 'nfriend.upgrade_user_id = uf.id')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');
		foreach ($aFriends as $aFriend)
		{
	/*		$iIsFriend = $this->_db()->select('COUNT(*)')
				->from(Phpfox::getT('friend'), 'f')
				->where('f.user_id = ' . (int) $aFriend['user_id'] . ' AND f.friend_user_id = ' . (int) $aFriend['friend_user_id'])
				->execute('getSlaveField');

			if ($iIsFriend)
			{
				continue;
			}
*/
			$this->_db()->insert(Phpfox::getT('friend'), array(
					'user_id' => $aFriend['user_id'],
					'friend_user_id' => $aFriend['friend_user_id'],
					'is_top_friend' => $aFriend['top'],
					'ordering' => $aFriend['top_order'],
					'time_stamp' => $aFriend['time']
				)
			);
/*
			$this->_db()->insert(Phpfox::getT('friend'), array(
					'user_id' => $aFriend['friend_user_id'],
					'friend_user_id' => $aFriend['user_id'],
					//'is_top_friend' => $aFriend['top'],
					//'ordering' => $aFriend['top_order'],
					'time_stamp' => $aFriend['time']
				)
			);
*/
			// Update friend count
			Phpfox::getService('friend.process')->updateFriendCount($aFriend['user_id'], $aFriend['friend_user_id']);
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of users friends completed.';
			$sAction = 'create-pm-index';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing users friends. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-friend';
		}

		break;
	case 'create-friend-index':

			$this->_db()->addIndex($this->_getOldT('friends'), 'user');
			$this->_db()->addIndex($this->_getOldT('friends'), 'friend');

			$sMessage = 'index created for friends.';
			$sAction = 'import-friend';
			$iPage = 0;

		break;
	case 'import-custom-field-for-user':

		$iLimit = 200;

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('user'))
			->execute('getField');

		$aUsers = $this->_db()->select('u.id')
			->from($this->_getOldT('user'), 'u')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');
		foreach ($aUsers as $aUser)
		{
			$aCustomFieldText = $this->_db()->select('cf2t.textarea, cf.field_id, u.user_id')
				->from($this->_getOldT('custom_field2text'), 'cf2t')
				->join(Phpfox::getT('custom_field'), 'cf', 'cf.upgrade_field_id = cf2t.custom_field_id')
				->join(Phpfox::getT('user'), 'u', 'u.upgrade_user_id = cf2t.user_id')
				->where('cf2t.user_id = ' . $aUser['id'])
				->execute('getRows');
			foreach ($aCustomFieldText as $aText)
			{
				Phpfox::getService('custom.process')->updateField($aText['field_id'], $aText['user_id'], $aText['user_id'], $aText['textarea'], true);
			}

			$aCustomFieldOptions = $this->_db()->select('u.user_id, cf.field_id, co.option_id')
				->from($this->_getOldT('custom_field2user'), 'cf2u')
				->join(Phpfox::getT('user'), 'u', 'u.upgrade_user_id = cf2u.user_id')
				->join(Phpfox::getT('custom_field'), 'cf', 'cf.upgrade_field_id = cf2u.custom_field_id')
				->join(Phpfox::getT('custom_option'), 'co', 'co.upgrade_option_id = cf2u.custom_option_id')
				->where('cf2u.user_id = ' . $aUser['id'])
				->execute('getRows');
			foreach ($aCustomFieldOptions as $aOption)
			{
				Phpfox::getService('custom.process')->updateField($aOption['field_id'], $aOption['user_id'], $aOption['user_id'], $aOption['option_id'], true);
			}
		}

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of users custom fields completed.';
			$sAction = 'create-friend-index';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing custom user fields. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-custom-field-for-user';
		}

		break;
	case 'import-custom-field':

		if (!$this->_db()->isField(Phpfox::getT('custom_field'), 'upgrade_field_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('custom_field'),
					'field' => 'upgrade_field_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('custom_field'), 'upgrade_field_id');
		}

		if (!$this->_db()->isField(Phpfox::getT('custom_option'), 'upgrade_option_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('custom_option'),
					'field' => 'upgrade_option_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('custom_option'), 'upgrade_option_id');
		}

		$aOldFields = $this->_db()->select('field_id')
			->from(Phpfox::getT('custom_field'))
			->where('module_id = \'user\'')
			->execute('getRows');
		foreach ($aOldFields as $aOldField)
		{
			Phpfox::getService('custom.process')->delete($aOldField['field_id']);
		}

		$iCustomGroupIdCache = $this->_db()->select('group_id')
			->from(Phpfox::getT('custom_group'))
			->where('module_id = \'user\'')
			->order('group_id ASC')
			->execute('getField');

		$aCustomFields = $this->_db()->select('*')
			->from($this->_getOldT('custom_field'))
			->execute('getRows');
		foreach ($aCustomFields as $aCustomField)
		{
			$aOptions = array();
			if ($aCustomField['custom_field_type'] == '0')
			{
				$aCustomOptions = $this->_db()->select('*')
					->from($this->_getOldT('custom_field_option'))
					->where('custom_field_id = ' . $aCustomField['custom_field_id'])
					->execute('getRows');
				foreach ($aCustomOptions as $aCustomOption)
				{
					$aOptions[] = array('en' => $aCustomOption['custom_option_name']);
				}
			}

			$aParams = array(
					'name' => array('en' => $aCustomField['custom_field_name']),
					'var_type' => ($aCustomField['custom_field_type'] == '1' ? 'textarea' : 'select'),
					'option' => ($aCustomField['custom_field_type'] == '1' ? '' : $aOptions),
					'module_id' => 'user',
					'product_id' => 'phpfox',
					'type_id' => ($aCustomField['custom_field_type'] == '0' ? 'user_panel' : ($aCustomField['panel'] == '1' ? 'user_main' : 'profile_panel')),
					'is_required' => 0,
					'on_signup' => $aCustomField['signup'],
					'group_id' => $iCustomGroupIdCache
				);

			list($iId, $aOptionIds) = Phpfox::getService('custom.process')->add($aParams);

			$this->_db()->update(Phpfox::getT('custom_field'), array('upgrade_field_id' => $aCustomField['custom_field_id']), 'field_id = ' . (int) $iId);

			if ($aCustomField['custom_field_type'] == '0')
			{
				foreach ($aCustomOptions as $aCustomOption)
				{
					if (isset($aOptionIds[$aCustomOption['custom_option_name']]))
					{
						$this->_db()->update(Phpfox::getT('custom_option'), array('upgrade_option_id' => $aCustomOption['custom_option_id']), 'option_id = ' . (int) $aOptionIds[$aCustomOption['custom_option_name']]);
					}
				}
			}
		}

		$sMessage = 'import of custom fields completed.';
		$sAction = 'import-custom-field-for-user';

		break;
	case 'import-user':

		$iLimit = 200;

		if (!$this->_db()->isField(Phpfox::getT('user'), 'upgrade_user_id'))
		{
			$this->_db()->addField(array(
					'table' => Phpfox::getT('user'),
					'field' => 'upgrade_user_id',
					'type' => 'INT(11)'
				)
			);
			$this->_db()->addIndex(Phpfox::getT('user'), 'upgrade_user_id');
		}

		$aUserInfoFields = array(
			'gallery' => 'activity_photo',
			'journal' => 'activity_blog',
			'poll' => 'activity_poll',
			'quiz' => 'activity_quiz',
			'comment' => 'activity_comment',
			'forum' => 'activity_forum',
			'invite' => 'activity_invite'
		);

		$sUserPoints = '';
		foreach ($aUserInfoFields as $sKeyField => $sValueField)
		{
			$sUserPoints .= 'ui.' . $sKeyField . ' AS '. $sValueField . ', ';
		}
		$sUserPoints = rtrim($sUserPoints, ', ');

		$iCnt = $this->_db()->select('COUNT(*)')
			->from($this->_getOldT('user'))
			->execute('getField');

		$aUsers = $this->_db()->select('u.*, ui.total AS total_points, ui.bonus AS bonus_points, ' . $sUserPoints)
			->from($this->_getOldT('user'), 'u')
			->leftJoin($this->_getOldT('user_info'), 'ui', 'ui.user = u.user')
			->limit($this->_sPage, $iLimit, $iCnt)
			->execute('getRows');

		Phpfox::getLib('pager')->set(array('page' => $this->_sPage, 'size' => $iLimit, 'count' => $iCnt));

		$iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$iPage = (int) Phpfox::getLib('pager')->getNextPage();

		$oParseInput = Phpfox::getLib('parse.input');

		$aCacheCountry = array();
		$aCountries = $this->_db()->select('varid, c.country_iso')
			->from($this->_getOldT('language_options'), 'lo')
			->leftJoin(Phpfox::getT('country'), 'c', 'c.name = lo.`default`')
			->where('lo.languageid = 1 AND lo.varname = \'country\'')
			->execute('getRows');
		foreach ($aCountries as $aCountry)
		{
			$aCacheCountry[$aCountry['varid']] = $aCountry['country_iso'];
		}

		$aCacheCountryChild = array();
		$aCountries = $this->_db()->select('name, c.child_id')
			->from($this->_getOldT('language_options'), 'lo')
			->leftJoin(Phpfox::getT('country_child'), 'c', 'c.name = lo.`default`')
			->where('lo.languageid = 1 AND lo.varname = \'us_stat\'')
			->execute('getRows');
		foreach ($aCountries as $aCountry)
		{
			$aCacheCountryChild[$aCountry['name']] = $aCountry['child_id'];
		}

		$aCacheGender = array();
		$aGenders = $this->_db()->select('varid, `default` AS text')
			->from($this->_getOldT('language_options'))
			->where('languageid = 1 AND varname = \'gender\'')
			->execute('getRows');
		foreach ($aGenders as $aGender)
		{
			$aCacheGender[$aGender['varid']] = ($aGender['text'] == 'Male' ? 1 : 2);
		}

		foreach ($aUsers as $aUser)
		{
			$sSalt = '';
			for ($i = 0; $i < 3; $i++)
			{
				$sSalt .= chr(rand(33, 91));
			}

			$aUser['day'] = (int) (empty($aUser['day']) ? date('d') : $aUser['day']);
			$aUser['month'] = (int) (empty($aUser['month']) ? date('m') : $aUser['month']);
			$aUser['year'] = (int) (empty($aUser['year']) ? date('Y') : $aUser['year']);
			if ($aUser['day'] === 0 || $aUser['day'] > 31)
			{
				$aUser['day'] = 1;
			}
			if ($aUser['month'] === 0 || $aUser['month'] > 12)
			{
				$aUser['month'] = 1;
			}
			if ($aUser['year'] < 1900)
			{
				$aUser['year'] = 1982;
			}

			$aUser['user_name'] = $aUser['user'];
			$aUser['user_name'] = str_replace(' ', '_', $aUser['user_name']);

			Phpfox::getService('user.validate')->user($aUser['user_name']);
			if (!Phpfox_Error::isPassed())
			{
				Phpfox_Error::reset();
				$aUser['user_name'] = $aUser['user_name'] . '_' . uniqid();
			}

			$aInsert = array(
				'user_group_id' => ($aUser['type'] == '0' ? '1' : '2'),
				'user_name' => $oParseInput->clean($aUser['user_name'], 255),
				'full_name' => $oParseInput->clean($aUser['user'], 255),
				'status' => $oParseInput->clean($aUser['headline'], 255),
				'password' => md5($aUser['password'] . md5($sSalt)),
				'password_salt' => $sSalt,
				'email' => $aUser['email'],
				'joined' => $aUser['signup'],
				'gender' => (isset($aCacheGender[$aUser['gender']]) ? $aCacheGender[$aUser['gender']] : 0),
				'birthday' => Phpfox::getService('user')->buildAge($aUser['day'],$aUser['month'],$aUser['year']),
				'birthday_search' => Phpfox::getLib('date')->mktime(0, 0, 0, $aUser['month'], $aUser['day'], $aUser['year']),
				'country_iso' => (isset($aCacheCountry[$aUser['location']]) ? $aCacheCountry[$aUser['location']] : null),
				'language_id' => 'en',
				'time_zone' => null,
				'last_login' => $aUser['login'],
				'upgrade_user_id' => $aUser['id'],
				'user_image' => '{file/pic/user/' . $aUser['user'] . '%s.jpg}'
			);

			$iId = $this->_db()->insert(Phpfox::getT('user'), $aInsert);

			// check if user profile was private
			if ($aUser['friends_only'] == 1)
			{
			    $aPrivacy = array('user_id' => $iId, 'user_privacy' => 'profile.view_profile', 'user_value' => 2);
			    $this->_db()->insert(Phpfox::getT('user_privacy'), $aPrivacy);
			}
			// check if only friends could add comments
			if ($aUser['friends_comment'] == 1)
			{
			    $aPrivacy = array('user_id' => $iId, 'user_privacy' => 'comment.add_comment', 'user_value' => 2);
			    $this->_db()->insert(Phpfox::getT('user_privacy'), $aPrivacy);
			}
			// Notifications
			if ($aUser['not_1'] == 2)
			{
			    $aNotification = array('user_id' => $iId, 'user_notification' => 'comment.add_new_comment');
			    $this->_db()->insert(Phpfox::getT('user_notification'), $aNotification);
			}
			if ($aUser['not_2'] == 2)
			{
			    $aNotification = array('user_id' => $iId, 'user_notification' => 'mail.new_message');
			    $this->_db()->insert(Phpfox::getT('user_notification'), $aNotification);
			}
			if ($aUser['not_4'] == 2)
			{
			    $aNotification = array('user_id' => $iId, 'user_notification' => 'forum.subscribe_new_post');
			    $this->_db()->insert(Phpfox::getT('user_notification'), $aNotification);
			}
			if ($aUser['not_5'] == 2)
			{
			    $aNotification = array('user_id' => $iId, 'user_notification' => 'friend.new_friend_request');
			    $this->_db()->insert(Phpfox::getT('user_notification'), $aNotification);
			}


			$iTotalRating = $this->_db()->select('COUNT(*)')
				->from($this->_getOldT('user_rating'))
				->where('user = \'' . $this->_db()->escape($aUser['user']) . '\'')
				->execute('getField');

			$aExtras = array(
				'user_id' => $iId
			);

			$aUpdate = array();
			foreach ($aUserInfoFields as $sKeyField => $sValueField)
			{
				if (isset($aUser[$sValueField]))
				{
					$aUpdate[$sValueField] = $aUser[$sValueField];
				}
			}

			$this->_db()->insert(Phpfox::getT('user_activity'), array_merge($aExtras, $aUpdate, array(
						'activity_total' => (int) $aUser['total_points'],
						'activity_points' => (int) ($aUser['total_points'] + $aUser['bonus_points']),
					)
				)
			);

			$this->_db()->insert(Phpfox::getT('user_field'), array_merge($aExtras, array(
						'postal_code' => (empty($aUser['zip']) ? null : $aUser['zip']),
						'country_child_id' => (isset($aCacheCountryChild[$aUser['state']]) ? $aCacheCountryChild[$aUser['state']] : 0),
						'city_location' => (empty($aUser['city']) ? null : $oParseInput->clean($aUser['city'])),
						'total_view' => (int) $aUser['views'],
						'total_score' => $aUser['user_rating'],
						'total_rating' => (int) $iTotalRating,
						'total_post' => (int) $aUser['activity_forum']
					)
				)
			);
			$this->_db()->insert(Phpfox::getT('user_space'), $aExtras);
			$this->_db()->insert(Phpfox::getT('user_count'), $aExtras);

			$this->_db()->update(Phpfox::getT('user_field'), array('birthday_range' => '\''.Phpfox::getService('user')->buildAge($aUser['day'], $aUser['month']) .'\''), 'user_id = ' . $iId, false);

			if ($aUser['feature'] > 0)
			{
				$this->_db()->insert(Phpfox::getT('user_featured'), array('user_id' => $iId));
			}
		}

		if ($iTotalPages === $iCurrentPage || $iTotalPages === 0)
		{
			$sMessage = 'import of users completed.';
			$sAction = 'import-custom-field';
			$iPage = 0;
		}
		else
		{
			$sMessage = 'importing users. Page ' . $iCurrentPage . '/' . $iTotalPages . '';
			$sAction = 'import-user';
		}
		break;
	case 'final':
		$sMessage = 'System check completed.';
		$sAction = 'import-user';
		break;
	case 'post':
		$this->_post();
		$sMessage = 'Post install completed.';
		$sAction = 'final';
		break;
	case 'module':
		if ($this->_module())
		{
			$sMessage = 'Import of modules completed';
			$sAction = 'post';
		}
		else
		{
			$sMessage = 'Importing modules...';
			$sAction = 'module';
		}
		break;
	case 'language':
		$this->_language();
		$sMessage = 'Language package imported.';
		$sAction = 'module';
		break;
	case 'import':
		$this->_import();
		$sMessage = 'Database import completed.';
		$sAction = 'language';
		break;
	case 'process':
		$this->_process();
		if (Phpfox::getLib('file')->isWritable(PHPFOX_DIR_SETTING . 'server.sett.php'))
		{
			$sContent = file_get_contents(PHPFOX_DIR_SETTING . 'server.sett.php');
			$sContent = preg_replace("/\\\$_CONF\['core.db_table_installed'\] = (.*?);/i", "\\\$_CONF['core.db_table_installed'] = true;", $sContent);
			if ($hServerConf = @fopen(PHPFOX_DIR_SETTING . 'server.sett.php', 'w'))
			{
	            fwrite($hServerConf, $sContent);
	            fclose($hServerConf);
			}
		}
		$sMessage = 'Site configuration process completed.';
		$sAction = 'import';
		break;
	default:

		require(PHPFOX_DIR_SETTING . 'server.sett.php');

		if (isset($_CONF['core.db_table_installed']) && $_CONF['core.db_table_installed'] === true)
		{
			// d($_SERVER);
			//exit('The script needs to exit as it is about to go over the same update routine.');

			$sMessage = 'configuration completed';
			$sAction = 'process';
		}
		else
		{
			Phpfox::getLib('cache')->remove();

			$aModules = Phpfox::getLib('module')->getModuleFiles();
			$aCacheModules = array_merge($aModules['core'], $aModules['plugin']);
			$aFinal = array();
			foreach ($aCacheModules as $aCacheModule)
			{
				$aFinal[] = $aCacheModule['name'];
			}

			$sCacheModules = PHPFOX_DIR_FILE . 'log' . PHPFOX_DS . 'installer_modules.php';
			if (file_exists($sCacheModules))
			{
				unlink($sCacheModules);
			}
			$sData = '<?php' . "\n";
			$sData .= '$aModules = ';
			$sData .= var_export($aFinal, true);
			$sData .= ";\n?>";
			Phpfox::getLib('file')->write($sCacheModules, $sData);

			require(PHPFOX_DIR . 'include' . PHPFOX_DS . 'settings' . PHPFOX_DS . 'server.sett.php');

			Phpfox::getLibClass('phpfox.database.dba');

			$sDriver = 'phpfox.database.driver.mysql';

			Phpfox::getLibClass($sDriver);

			$oDb = Phpfox::getLib($sDriver);

			$oDb->connect($_CONF['db']['host'], $_CONF['db']['user'], $_CONF['db']['pass'], $_CONF['db']['name']);

			$oDbSupport = Phpfox::getLib('database.support');

			$sTablePrefix = 'phpfox%s_';

			$aTables = $oDbSupport->getTables('mysql', $oDb);
			$bDefaultTaken = false;
			foreach ($aTables as $sTable)
			{
				if (substr($sTable, 0, 7) == 'phpfox_')
				{
					$bDefaultTaken = true;

					break;
				}
			}

			if ($bDefaultTaken === true)
			{
				$aNumbers = array();
				foreach ($aTables as $sTable)
				{
					if (preg_match('/phpfox(.*?)\_(.*)/i', $sTable, $aMatches))
					{
						if (!is_numeric($aMatches[1]))
						{
							continue;
						}

						$aNumbers[$aMatches[1]] = $aMatches[1];
					}
				}

				krsort($aNumbers);

				$aParts = array_keys($aNumbers);

				if (count($aParts))
				{
					$sPrefix = sprintf($sTablePrefix, ($aParts[0] + 1));
				}
				else
				{
					$sPrefix = 'phpfox2_';
				}
			}
			else
			{
				$sPrefix = sprintf($sTablePrefix, '');
			}

			$this->_saveSettings(array(
					'driver' => 'mysql',
					'host' => $_CONF['db']['host'],
					'user_name' => $_CONF['db']['user'],
					'password' => $_CONF['db']['pass'],
					'name' => $_CONF['db']['name'],
					'prefix' => $sPrefix,
					'port' => ''
					// 'rewrite' => ((isset($_CONF['rewrite_engine']) && $_CONF['rewrite_engine'] === true) ? true : false)
				)
			);

			$sMessage = 'Configuration setup completed.';
			$sAction = 'process';
		}

		break;
}

if ($bCompleted === false)
{
	$this->_oTpl->assign(array(
			'sMessage' => $sMessage,
			'sNext' => $this->_step(array(
					'update',
					'action' => $sAction,
					'version' => str_replace('.', '-', $sVersion),
					'page' => $iPage
				)
			)
		)
	);
}

?>