<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: blog.class.php 1599 2010-05-28 04:31:26Z Raymond_Benc $
 */
class Blog_Service_Import extends Phpfox_Service
{
	
	public function uploadXML($userID)
	{
		if ( $userID != Phpfox::getUserId())
		{
			return;
		}
		$file = $_FILES['import_blog'];
		if ($file['name'] == ''){
			Phpfox_Error::set(Phpfox::getPhrase('blog.please_choose_a_file'));
			return '';
		}

		$fXML = phpfox::getLib('file')->load('import_blog', array('xml'));
			
		if(!empty ($fXML['error']) || $fXML['size'] > 10485760)
		{
			Phpfox_Error::set('Upload File Failed !Choose a file from your computer: (Maximum size: 10MB)');
			return '';
		}

		$uploaded_file = '';
		if(isset($_FILES['import_blog']['tmp_name']))
		{
			$uploaded_file = $_FILES['import_blog']['tmp_name'];
		}
		return $uploaded_file;
	}

	public function mb_truncate($string, $length = 255, $etc = '...', $charset='UTF-8', $break_words = false, $middle = false)
	{
		if ($length == 0)
		return '';
			
		if (strlen($string) > $length) {
			$length -= min($length, strlen($etc));
			if (!$break_words && !$middle) {
				$string = preg_replace('/\s+?(\S+)?$/', '', mb_substr($string, 0, $length+1, $charset));
			}
			if(!$middle) {
				return mb_substr($string, 0, $length, $charset) . $etc;
			} else {
				return mb_substr($string, 0, $length/2, $charset) . $etc . mb_substr($string, -$length/2, $charset);
			}
		} else {
			return $string;
		}
	}

	public function addImporter($aVals)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.service_process__start')) ? eval($sPlugin) : false);
		$oFilter = Phpfox::getLib('parse.input');

		if (!Phpfox::getParam('blog.allow_links_in_blog_title'))
		{
			if (!Phpfox::getLib('validator')->check($aVals['title'], array('url')))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('blog.we_do_not_allow_links_in_titles'));
			}
		}


		$sTitle = $aVals['title'];
		//$sTitle = $oFilter->clean($aVals['title'], 255);
		if(empty($sTitle))
		{
			$sTitle = 'Untitled';
		}
		else
		{
			//$sTitle = $this->mb_truncate($sTitle, 255);
			$sTitle = $oFilter->clean($aVals['title'], 255);
		}

		//$bHasAttachments = (!empty($aVals['attachment']) && Phpfox::getUserParam('attachment.can_attach_on_blog'));
		//set default for other attributes
		if(!isset($aVals['privacy'])){
			$aVals['privacy'] ='0';
		}
		if (!isset($aVals['privacy_comment']))
		{
			$aVals['privacy_comment'] = 0;
		}
		if (!isset($aVals['post_status']))
		{
			$aVals['post_status'] = 1;
		}
		if (!isset($aVals['is_approved']))
		{
			$aVals['is_approved'] = 1;
		}

		if (!isset($aVals['post_status']))
		{
			$aVals['post_status'] = 1;
		}

		/*
		 * Change allow_comment to privacy_comment
		 * Don't have a password field and title_url, allow_ping
		 */
			
		$aInsert = array(
			'user_id' => Phpfox::getUserId(),
			'title' => substr($sTitle,0,255),
			'time_stamp' => $aVals['time_stamp'],
		//'title_url' => Phpfox::getService('blog')->prepareTitle($aVals['title']),
			'is_approved' => $aVals['is_approved'],
			'privacy' => $aVals['privacy'],
			'post_status' => $aVals['post_status'],
			'privacy_comment' => $aVals['privacy_comment'], //default    //default
		//'password' => (isset($aVals['password']) ? (empty($aVals['password']) ? null : $aVals['password']) : null),
		//'allow_comment' => (isset($aVals['allow_comment']) ? $aVals['allow_comment'] : '0'),
			
		//'allow_ping' => (isset($aVals['allow_ping']) ? $aVals['allow_ping'] : 0),
		//'total_attachment' => ($bHasAttachments ? Phpfox::getService('attachment')->getCount($aVals['attachment']) : 0)
		);

		$bIsSpam = false;
		if (Phpfox::getParam('blog.spam_check_blogs'))
		{
			if (Phpfox::getLib('spam')->check(array(
						'action' => 'isSpam',
						'params' => array(
							'module' => 'blog',
							'content' => $oFilter->prepare($aVals['text'])
			)
			)
			)
			)
			{
				$aInsert['is_approved'] = '9';
				$bIsSpam = true;
			}
		}

		if (Phpfox::getUserParam('blog.approve_blogs'))
		{
			$aInsert['is_approved'] = '0';
			$bIsSpam = true;
		}



		(($sPlugin = Phpfox_Plugin::get('blog.service_process_add_start')) ? eval($sPlugin) : false);
		if(($this->isAvailable($aInsert['title'], $aInsert['time_stamp']))){
			$iId = $this->database()->insert(Phpfox::getT('blog'), $aInsert);
		}
		else{
			echo 'i...';
		}

		(($sPlugin = Phpfox_Plugin::get('blog.service_process_add_end')) ? eval($sPlugin) : false);
		/*
		 * Clean text before inserting into database
		 */
		//$aVals['text'] = $oFilter->clean($aVals['text']); 
                
		if(isset($iId) && $iId){
			$this->database()->insert(Phpfox::getT('blog_text'), array(
				'blog_id' => $iId,
				'text' => $oFilter->fixHtml($aVals['text']),
                                //'text_parsed' =>$oFilter->fixHtml($aVals['text'])
				'text_parsed' => preg_replace('/<script.*?>/is', '', $aVals['text'])
			)
			);
                     
                        $this->database()->insert(Phpfox::getT('blog_importer'),array(
                                 'blog_id' => $iId
                        ));
			if (Phpfox::getUserParam('tag.can_add_tags_on_blogs') && Phpfox::isModule('tag') && isset($aVals['tag_list']) && ((is_array($aVals['tag_list']) && count($aVals['tag_list'])) || (!empty($aVals['tag_list'])))){
				Phpfox::getService('tag.process')->add('blog', $iId, Phpfox::getUserId(), $oFilter->clean($aVals['tag_list']));
			}
			//for feed

			if ($aVals['post_status'] == 1)
			{
				//(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('blog', $iId, $aVals['privacy'], (isset($aVals['privacy_comment']) ? (int) $aVals['privacy_comment'] : 0)) : null);

				// Update user activity
				Phpfox::getService('user.activity')->update(Phpfox::getUserId(), 'blog');
			}
			return $iId;
		}
		/* not user
		 * 	if (!empty($aVals['selected_categories']))
		 {
			Phpfox::getService('blog.category')->addCategoryForBlog($iId, explode(',', rtrim($aVals['selected_categories'], ',')), ($aVals['post_status'] == 1 ? true : false));
			}
			*/

		/*
		 if (Phpfox::isModule('privacy') && isset($aVals['privacy']) && $aVals['privacy'] == 4 && !empty($aVals['allow_list']))
		 {
			Phpfox::getService('privacy.process')->add('blog', $iId, $aVals['allow_list']);
			}

			// If we uploaded any attachments make sure we update the 'item_id'
			if ($bHasAttachments)
			{
			Phpfox::getService('attachment.process')->updateItemId($aVals['attachment'], Phpfox::getUserId(), $iId);
			}

			if ($bIsSpam === true)
			{
			return $iId;
			}
			*/
		/*
		 * Change code lines to code below
		 */
		/*if (Phpfox::isModule('feed') && $aVals['post_status'] == 1 && isset($aVals['privacy']) && $aVals['privacy'] == '1')
		 {
		 Phpfox::getService('feed.process')->add('blog', $iId, $sTitle);
		 // Update user activity
		 Phpfox::getService('user.activity')->update(Phpfox::getUserId(), 'blog');
		 }
	 	*/
		/*
		 * Code change
		 */


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		(($sPlugin = Phpfox_Plugin::get('blog.service_process__end')) ? eval($sPlugin) : false);
			
		return 0;
	}
	/**
	 * this is installation, create talbe ".$sPrefix."blog_blogimporter_setting insert phrase;
	 */
	public function install(){
		$sPrefix = Phpfox::getParam(array('db', 'prefix'));
		$phrases = array(
		array('back','Back'),
		array('choose_a_file_from_your_computer','Choose a file from your computer'),
		array('have_a_blogger_export_file','Have a Blogger export file?'),
		array('have_a_wordpress_export_file','Have a WordPress export file?'),
		array('import_blog','Import blog'),
		array('import_blogger','Import blogger'),
		array('import_tumblr','Import tumblr'),
		array('import_wordpress','Import WordPress'),
		//don't use 2 phrases blow due to inserting delay
		//array('install_fail','The module blog importer cannot installed, please try again'),
		//array('install_successfully','Congratulation ! The module blog importer has been installed successfully'),
		array('maximum_size','Maximum file size: 10MB'),
		array('size','size'),
		array('tumblr_import_instruction','Original Tumblr blog name [<i>xyz</i>.tumblr.com, not your email address or custom domain]:'),
		array('upload_file_and_import','Upload file and import'),
		array('url','URL'),
		array('blog_import_instruction','If you have posts in another system, you can import those into this site. To get started, choose a system to import from below'),
		array('blogger','Blogger'),
		array('import_post_s_from_a_blogger_export_file','Import posts from a blogger export file.'),
		array('import_post_s_from_a_tumblr_username','Import posts from a tumblr Username'),
		array('import_post_s_from_a_wordpress_export_file','Import posts from a WordPress export file.'),
		array('tumblr','Tumblr'),
		array('wordpress','Wordpress'),
		array('import_blog_s', 'Import Blogs'),
		array('export_blog_s', 'Export Blogs'),
		array('create_an_xml_file_wordpress_export','Create an xml wordpress export file'),
		array('create_an_xml_file_blogger_export','Create an xml blogger export file'),
		array('create_an_xml_file_tumblr_export','Create an xml tumblr export file'),
		//phrase for menus
		array('menu_blog_import_blog', 'Import blog'),
		array('menu_blog_export_blog', 'Export blog'),
		array('menu_import_add_new_blog','Add new blog'),
		array('menu_export_add_new_blog', 'Add new blog'),
		//phrase for settings
		array('user_setting_can_import_blog', 'Can import blog?'),
		array('user_setting_can_export_blog', 'Can export blog?'),
		array('user_setting_number_of_import_blogs','How many blogs can a user import?\r\n\r\nNote: Setting it to "-1" (without quotes) If you want user can import all'),
		array('user_setting_number_of_export_blogs', 'How many blogs can a user export?\r\n\r\nNote: Setting it to "-1" (without quotes) If you want user can export all'),
		array('blog_has_been_inserted', ' blog has been inserted'),
		array('blog_s_have_been_inserted', 'blogs have been inserted'),
		array('importing_records', 'Importing records...'),
		array('load_and_reading_file', 'Load and reading file...'),
		array('invalid_file', 'Invalid file'),
		array('there_is_no_any_blog_in_this_file_yet', 'There is no any blog in this file yet'),
		array('username_does_not_exist', 'Username does not exist'),
		array('please_choose_a_file', 'Please choose a file'),
		array('please_enter_a_username', 'Please enter a username'),
		array('admin_menu_uninstall_blog_importer_v4_01', 'Uninstall Blog Importer v4.01'),
		array('admin_menu_install_blog_importer_v4_01', 'Install Blog Importer v4.01')
		);

		$insertSql = "INSERT INTO `".phpfox::getT('language_phrase')."` ( `language_id`, `module_id`, `product_id`, `version_id`, `var_name`, `text`, `text_default`, `added`) VALUES";
		foreach ($phrases as $index=>$phrase){
			$insertSql .= "( 'en', 'blog', 'phpfox', '".PhpFox::getId()."', '".$phrase[0]."', '".$phrase[1]."', '".$phrase[1]."', ".PHPFOX_TIME." ),";
		}
		$insertSql = substr($insertSql,0, strlen($insertSql)-1);

                
		if(!$this->database()->query($insertSql)){
			return false;
		}

		//add menus import and export for module
		//$menus = array('menu_blog_import_blog', 'menu_blog_export_blog', 'menu_import_add_new_blog', 'menu_export_add_new_blog');
		$insertSql = "INSERT INTO `".phpfox::getT('menu')."` (`parent_id`, `page_id`, `m_connection`, `module_id`, `product_id`, `var_name`, `is_active`, `ordering`, `url_value`, `disallow_access`, `version_id`) VALUES
					(0, 0, 'blog.index', 'blog', 'phpfox', 'menu_blog_import_blog', 1, 120, 'blog.import', NULL, '3.0.0'),
					(0, 0, 'blog.index', 'blog', 'phpfox', 'menu_blog_export_blog', 1, 121, 'blog.export', NULL, '3.0.0'),
					(0, 0, 'blog.import', 'blog', 'phpfox', 'menu_import_add_new_blog', 1, 3, 'blog.add', NULL, '3.0.0'),
					(0, 0, 'blog.export', 'blog', 'phpfox', 'menu_export_add_new_blog', 1, 3, 'blog.add', NULL, '3.0.0')";

		if(!$this->database()->query($insertSql)){
			return false;
		}
		//add user group setting for module
		//$settings = array('can_import_blog', 'can_import_blog', 'number_of_import_blogs', 'number_of_export_blogs');
		$insertSql = "INSERT INTO `".phpfox::getT('user_group_setting')."` ( `is_admin_setting`, `is_hidden`, `module_id`, `product_id`, `name`, `type_id`, `default_admin`, `default_user`, `default_guest`, `default_staff`, `ordering`) VALUES
					( 0, 0, 'blog', 'phpfox', 'can_import_blog', 'boolean', '1', '0', '0', '0', 0),
					( 0, 0, 'blog', 'phpfox', 'can_export_blog', 'boolean', '1', '0', '0', '0', 0),
					( 0, 0, 'blog', 'phpfox', 'number_of_import_blogs', 'integer', '50', '50', '0', '50', 0),
					( 0, 0, 'blog', 'phpfox', 'number_of_export_blogs', 'integer', '50', '50', '0', '50', 0)";

		if(!$this->database()->query($insertSql)){
			return false;
		}
                //install new table blog_importer to manager blog was imported
                $insertSql = "CREATE TABLE IF NOT EXISTS`" . Phpfox::getT('blog_importer') . "`(`blog_id` int(10))";
                if(!$this->database()->query($insertSql))
                {
                    return false;
                }
		// change install to uninstall in admin cp
		$sMenu = Phpfox::getLib('database')->select('menu')
		->from(Phpfox::getT('module'))
		->where('module_id=\'blog\'')
		->execute('getField');
		$aMenu = unserialize($sMenu);
		unset($aMenu['blog.admin_menu_install_blog_importer_v4_01']);
		$aMenu['blog.admin_menu_uninstall_blog_importer_v4_01'] = array('url' => array('blog','installer', 'uninstall'));
		Phpfox::getLib('database')->update(Phpfox::getT('module'), array('menu' => serialize($aMenu)), 'module_id = \'blog\'' );
		return true;
	}

	/** check if blog is existed in database
	 *
	 */
	public function isAvailable($sTitle, $iTime_stamp){
		$aBlog = $this->database()->select('blog_id')
		->from(Phpfox::getT('blog'), 'blog')
		->where("title = '".($sTitle)."' AND time_stamp =".$iTime_stamp )
		->execute('getRow');
		if(empty($aBlog)){
			return true;
		}
		else{
			return false;
		}
	}
	/**
	 * uninstall
	 */
	public function uninstall(){
		$sPrefix = Phpfox::getParam(array('db', 'prefix'));
		//delete import and export menu from previous version
		$deleteSql = "DELETE FROM `".phpfox::getT('menu')."` WHERE (`var_name` LIKE '%menu_blog_import_blog%') OR (`var_name` LIKE '%menu_blog_export_blog%') OR (`var_name` LIKE '%menu_import_add_new_blog%') OR (`var_name` LIKE '%menu_export_add_new_blog%')";
		if(!$this->database()->query($deleteSql)){
			return false;
		}
            /*  $deleteTable = "DROP TABLE IF EXISTS`".  Phpfox::getT('blog_importer')."`";
                if(!$this->database()->query($deleteTable))
                {
                    return false;
                }*/
		$phrases = array(
		array('back','Back'),
		array('choose_a_file_from_your_computer','Choose a file from your computer'),
		array('have_a_blogger_export_file','Have a Blogger export file?'),
		array('have_a_wordpress_export_file','Have a WordPress export file?'),
		array('import_blog','Import blog'),
		array('import_blogger','Import blogger'),
		array('import_tumblr','Import tumblr'),
		array('import_wordpress','Import WordPress'),
		array('import_blog_s', 'Import Blogs'),
		array('export_blog_s', 'Export Blogs'),
		array('create_an_xml_file_wordpress_export','Create an xml wordpress export file'),
		array('create_an_xml_file_blogger_export','Create an xml blogger export file'),
		array('create_an_xml_file_tumblr_export','Create an xml tumblr export file'),
		//array('install_fail','The module blog importer cannot installed, please try again'),
		//array('install_successfully','Congratulation ! The module blog importer has been installed successfully'),
		array('maximum_size','Maximum file size: 10MB'),
		array('size','size'),
		array('tumblr_import_instruction','Original Tumblr blog name [<i>xyz</i>.tumblr.com, not your email address or custom domain]:'),
		array('upload_file_and_import','Upload file and import'),
		array('url','URL'),
		array('blog_import_instruction','If you have posts in another system, you can import those into this site. To get started, choose a system to import from below'),
		array('blogger','Blogger'),
		array('import_post_s_from_a_blogger_export_file','Import posts from a blogger export file.'),
		array('import_post_s_from_a_tumblr_username','Import posts from a tumblr Username'),
		array('import_post_s_from_a_wordpress_export_file','Import posts from a WordPress export file.'),
		array('tumblr','Tumblr'),
		array('wordpress','Wordpress'),
		//phrase for menus
		array('menu_blog_import_blog', 'Import blog'),
		array('menu_blog_export_blog', 'Export blog'),
		array('menu_import_add_new_blog','Add new blog'),
		array('menu_export_add_new_blog', 'Add new blog'),
		//phrase for settings
		array('user_setting_can_import_blog', 'Can import blog?'),
		array('user_setting_can_export_blog', 'Can export blog?'),
		array('user_setting_number_of_import_blogs','How many blogs can a user import?\r\n\r\nNote: Setting it to "-1" (without quotes) If you want user can import all'),
		array('user_setting_number_of_export_blogs', 'How many blogs can a user export?\r\n\r\nNote: Setting it to "-1" (without quotes) If you want user can export all'),
		array('blog_has_been_inserted', ' blog has been inserted'),
		array('blog_s_have_been_inserted', 'blogs have been inserted'),
		array('importing_records', 'Importing records...'),
		array('load_and_reading_file', 'Load and reading file...'),
		array('invalid_file', 'Invalid file'),
		array('there_is_no_any_blog_in_this_file_yet', 'Ther is no any blog in this file yet'),
		array('username_does_not_exist', 'Username does not exist'),
		array('please_choose_a_file', 'Please choose a file'),
		array('please_enter_a_username', 'Please enter a username'),


		);
		if($this->request()->get('req4') == 'install'){
			$phrases[] = array('admin_menu_uninstall_blog_importer', 'Uninstall blog Importer');
			$phrases[] = array('admin_menu_install_blog_importer', 'Install blog Importer');
		}
		$deleteSql = "DELETE FROM `".phpfox::getT('language_phrase')."` WHERE `var_name` IN(";
		foreach ($phrases as $index=>$phrase){
			$deleteSql .= "'".$phrase[0]."',";
		}
		$deleteSql = substr($deleteSql,0, strlen($deleteSql)-1).") AND module_id='blog'";

		if(!$this->database()->query($deleteSql)){
			return false;
		}

		//add menus import and export for module
		//$menus = array('menu_blog_import_blog', 'menu_blog_export_blog', 'menu_import_add_new_blog', 'menu_export_add_new_blog');
		$deleteSql = "DELETE FROM `".phpfox::getT('menu')."` WHERE `var_name` IN('menu_blog_import_blog', 'menu_blog_export_blog','menu_import_add_new_blog', 'menu_export_add_new_blog') AND module_id='blog'";
		if(!$this->database()->query($deleteSql)){
			return false;
		}

		//$settings = array('can_import_blog', 'can_import_blog', 'number_of_import_blogs', 'number_of_export_blogs');
		$deleteSql = "DELETE FROM `".phpfox::getT('user_group_setting')."` WHERE name IN('can_import_blog', 'can_export_blog', 'number_of_import_blogs', 'number_of_export_blogs') AND module_id='blog'";
		if(!$this->database()->query($deleteSql)){
			return false;
		}
		// change uninstall to install state
		//insert install phrase
		/*if($this->request()->get('req4') == 'uninstall'){
		$installPhrase = array('admin_menu_install_blog_importer', 'Install blog Importer');
		$insertSql = "INSERT INTO `".$sPrefix."language_phrase` ( `language_id`, `module_id`, `product_id`, `version_id`, `var_name`, `text`, `text_default`, `added`) VALUES";
		$insertSql .= "( 'en', 'blog', 'phpfox', '".PhpFox::getId()."', '".$installPhrase[0]."', '".$installPhrase[1]."', '".$installPhrase[1]."', ".PHPFOX_TIME." )";
		if (!$this->database()->query($insertSql)){
		return false;
		}
		}*/
		//insert into module menu;
		$sMenu = $this->database()->select('menu')
		->from(Phpfox::getT('module'))
		->where('module_id=\'blog\'')
		->execute('getField');
		$aMenu = unserialize($sMenu);
		unset($aMenu['blog.admin_menu_uninstall_blog_importer_v4_01']);

		$aMenu['blog.admin_menu_install_blog_importer_v4_01'] = array('url' => array('blog','installer', 'install'));
		$this->database()->update(Phpfox::getT('module'), array('menu' => serialize($aMenu)), 'module_id = \'blog\'' );
		return true;
	}
        public function getImportedBlogId()
        {
            return $this->database()->select('*')
                                    ->from(Phpfox::getT('blog_importer'))
                                    ->execute('getSlaveRows');
        }
        public function chekUserParam()
        {
            return $this->database()->select('*')
                                    ->from(Phpfox::getT('user_group_setting'),'us')
                                    ->where("us.name like '%can_import_blog%' or us.name like '%can_export_blog%' ")
                                    ->execute('getSlaveRows');
        }
    }
?>
