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
class Blog_Service_Export extends Phpfox_Service {

	public function __construct() {
		$this->_sTable = Phpfox::getT('blog');
	}

	public function getContent($exportTo) {
		if($exportTo == 'wordpresstemplate')
		{
			list($iOwnerUserId, $aItems) = Phpfox::getService('blog.export')->getBlogWordPress(Phpfox::getUserId());
				
			$aTitleUrls = array();
			foreach($aItems as $iKey => $aItem)
			{
				$sTitle = $aItem["title"];
				$aItems[$iKey]["title_url"] = Phpfox::getLib('url')->cleanTitle($sTitle);
				$aItems[$iKey]["pub_date"] = date('r', $aItem["time_stamp"]);
				$aItems[$iKey]["post_date"] = date('Y-m-d H:i:s', $aItem["time_stamp"]);

				$iIndex = 2;
				while(in_array($aItems[$iKey]["title_url"], $aTitleUrls))
				{
					preg_match('/(.*?)(-\d+)*$/', $aItems[$iKey]["title_url"], $aMatch);
					if(empty($aMatch[1]))
					break;
					$aItems[$iKey]["title_url"] = $aMatch[1] . "-$iIndex";
					$iIndex++;
				}
				$aTitleUrls[] = $aItems[$iKey]["title_url"];
			}
			//print_r($aItems);
			//exit();
		}
		else if($exportTo == 'bloggertemplate')
		{
			list($iOwnerUserId, $aItems) = Phpfox::getService('blog.export')->getBlogExportBlogger(Phpfox::getUserId());
		}
		else 
		{
			list($iOwnerUserId, $aItems) = Phpfox::getService('blog.export')->getBlogExport(Phpfox::getUserId());
		}

		$aUser = Phpfox::getLib('phpfox.database')->select('*')
		->from(Phpfox::getT('user'))
		->execute('getRow');
		$username = $aUser['user_name'];
		$aCats = Phpfox::getService('blog.export')->getBlogCategory();
		$basePath = Phpfox::getParam('core.path');

		(($sPlugin = Phpfox_Plugin::get('blog.component_controller_index_process_end')) ? eval($sPlugin) : false);
			
		Phpfox::isUser(true);
		ob_clean();
		ob_start();
		$result = '';

		if($exportTo == 'wordpresstemplate')
		{
			$result .= '<?xml version="1.0" encoding="UTF-8"?>';

		}
		else if($exportTo == 'bloggertemplate')
		{
			$result .= '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet href="http://www.blogger.com/styles/atom.css" type="text/css"?>';
		}
		else
		{
			$result .= '<?xml version="1.0" encoding="UTF-8"?>';
		}
		$templateName = 'blog.block.export.' . $exportTo;
		$pubDate = date('Y-m-d:h:m:s',  time());
		phpfox::getLib('template')->assign(array(
			'aItems' => $aItems,
			'username' => $username,
			'pubDate'=>$pubDate,
			'basePath' => $basePath,
			'categories' => $aCats
		))->getTemplate($templateName);

		$result .= ob_get_clean();

		return $result;
	}


	public function downloader($fullpath, $ctype ='xml') {


		// File Exists?
		if (file_exists($fullpath)) {
			if ($fd = @fopen($fullpath, "r")) {
				$fsize = @filesize($fullpath);
				$path_parts = @pathinfo($fullpath);
				header("Content-type: application/xml");
				header("Content-Disposition: attachment; filename=" . basename($fullpath));
				header("Content-length: $fsize"); //use this to open files directly
				while (!feof($fd)) {
					header("Cache-control: private");
					$buffer = fread($fd, 2048);
					echo $buffer;
				}
			}

			fclose($fd);
			@unlink($fullpath);
			exit;
		}
		else
		die("File is not found");

	}

	public function exportXML($contentXML,$fileTemplate) {
		/*
		 * Change to wordpress.
		 */
		$file = "";
		if($fileTemplate == 'wordpresstemplate')
		{
			//$file = 'blog.wordpress.' . date('Y-m-d', time()) . '.xml';
			$file = 'wordpress.' . date('Y-m-d', time()) . '.xml';
		}
		else if($fileTemplate == 'bloggertemplate')
		{
			//$file = 'blog.blogger.' . date('Y-m-d', time()) . '.xml';
			$file = 'blogger.' . date('Y-m-d', time()) . '.xml';
		}
		else if($fileTemplate == 'tumblrtemplate')
		{
			//$file = 'blog.tumblr.' . date('Y-m-d', time()) . '.xml';
			$file = 'tumblr.' . date('Y-m-d', time()) . '.xml';
		}
		if ($contentXML != null) {
			$path = PHPFOX_DIR_FILE . 'export';
			$path2 = phpfox::getParam('core.path') . 'file/export';
			$aParts = explode('/', Phpfox::getParam('core.build_format'));

			foreach ($aParts as $sPart) {
				$sDate = date($sPart) . '/';
				$path .= $sDate;
				$path2.= $sDate;
				if (!is_dir($path)) {
					@mkdir($path, 0777);
					@chmod($path, 0777);
				}
			}

			$filename = $path . PHPFOX_DS . $file;
			$f = fopen($filename, 'w+');
			fwrite($f, $contentXML);
			fclose($f);
			$exportFile = $path2 . $file;
		}
		$this->downloader($filename, 'xml');
	}

	public function getBlogCategory() {

		$aCats = Phpfox::getLib('phpfox.database')->select('*')
		->from(Phpfox::getT('blog_category'))
		->where('1')
		->limit(0,3)
		->execute('getRows');
		return $aCats;
	}

	public function getBlogCategoryName($blogID) {

		$aCatNames = Phpfox::getLib('phpfox.database')->select('category.name')
		->from(Phpfox::getT('blog'), 'blog')
		->leftjoin(Phpfox::getT('blog_category_data'), 'category_data', 'blog.blog_id = category_data.blog_id')
		->leftjoin(Phpfox::getT('blog_category'), 'category', 'category_data.category_id = category.category_id')
		->where('blog.blog_id=' . $blogID)
		->execute('getRows');
		return $aCatNames;
	}

	public function getBlogComment($blogID) {

		$aComments = Phpfox::getLib('phpfox.database')->select("comment.*," . (Phpfox::getParam('core.allow_html') ? "comment_text.text_parsed" : "comment_text.text") . " AS text, u.*")
		->from(Phpfox::getT('comment'), 'comment')
		->join(Phpfox::getT('comment_text'), 'comment_text', 'comment.comment_id = comment_text.comment_id')
		->join(Phpfox::getT('user'), 'u', 'u.user_id = comment.user_id')
		->where("comment.type_id = 'blog' AND comment.item_id=" . $blogID)
		->execute('getRows');
		foreach ($aComments  as $key => $aComment) {
			$aRows[$key]['pubDate'] = date('Y-m-d:h:m:s',$aComment['time_stamp']) ;
		}
		return $aComments;
	}

	public function getBlog($userID) {
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_get__start')) ? eval($sPlugin) : false);

		(($sPlugin = Phpfox_Plugin::get('blog.service_blog_get')) ? eval($sPlugin) : false);

		if (defined('PHPFOX_IS_USER_PROFILE') && Phpfox::getUserId()) {
			if (Phpfox::isModule('privacy')) {
				$this->database()->select('p.item_id AS privacy_pass, ')->leftJoin(Phpfox::getT('privacy'), 'p', "p.item_id = blog.blog_id AND p.category_id = 'blog' AND p.user_id = " . Phpfox::getUserId());
			}

			if (Phpfox::isModule('friend')) {
				$this->database()->select('f.friend_id AS is_friend, ')->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = blog.user_id AND f.friend_user_id = " . Phpfox::getUserId());
			}
		}

		$limit = Phpfox::getUserParam('blog.number_of_export_blogs');

		$aRows = $this->database()->select("blog.*," . (Phpfox::getParam('core.allow_html') ? "blog_text.text_parsed" : "blog_text.text") . " AS text, " . Phpfox::getUserField())
		->from($this->_sTable, 'blog')
		->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id')
		->join(Phpfox::getT('user'), 'u', 'u.user_id = blog.user_id')
		->where('1')
		->limit($limit)
		->order('blog.time_stamp DESC')
		->execute('getSlaveRows');

		$aCache = array();

		foreach ($aRows as $key => $aRow) {
			$categoryNames = $this->getBlogCategoryName($aRow['blog_id']);
			$comment = $this->getBlogComment($aRow['blog_id']);
			$aRows[$key]['pubDate'] = date('Y-m-d:h:m',$aRow['time_stamp']) ;
			$aRows[$key]['upDate'] = date('Y-m-d:h:m',$aRow['time_update']) ;
			$aRows[$key]['category_name'] = $categoryNames;
			$aRows[$key]['comment'] = $comment;
		}

		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_get__end')) ? eval($sPlugin) : false);
		$iOwnerUserId = $userID;
		return array($iOwnerUserId, $aRows);
	}

	public function getBlogExport($userID) {

		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_get__start')) ? eval($sPlugin) : false);

		(($sPlugin = Phpfox_Plugin::get('blog.service_blog_get')) ? eval($sPlugin) : false);

		$limit = Phpfox::getUserParam('blog.number_of_export_blogs');
		if ($limit == -1){
			$limit = $this->database()-> select ('COUNT(*)')
			-> from(phpfox::getT('blog'),'b')
			->where(1)
			->execute('getSlaveField');
		}


		if (defined('PHPFOX_IS_USER_PROFILE') && Phpfox::getUserId()) {
			if (Phpfox::isModule('privacy')) {
				$this->database()->select('p.item_id AS privacy_pass, ')->leftJoin(Phpfox::getT('privacy'), 'p', "p.item_id = blog.blog_id AND p.category_id = 'blog' AND p.user_id = " . Phpfox::getUserId());
			}

			if (Phpfox::isModule('friend')) {
				$this->database()->select('f.friend_id AS is_friend, ')->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = blog.user_id AND f.friend_user_id = " . Phpfox::getUserId());
			}
		}

		$aRows = $this->database()->select("blog.*,blog_text.text AS text,". Phpfox::getUserField())
		->from($this->_sTable, 'blog')
		->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id')
		->join(Phpfox::getT('user'), 'u', 'u.user_id = blog.user_id')
		->where('blog.user_id = '.$userID)
		->limit($limit)
		->order('blog.time_stamp DESC')
		->execute('getSlaveRows');

		$aCache = array();

		foreach ($aRows as $key => $aRow) {
			$categoryNames = $this->getBlogCategoryName($aRow['blog_id']);
			$comment = $this->getBlogComment($aRow['blog_id']);
			$sTitle  = preg_replace('/\&#?[\d\w]+[^;]$/' ,'', $aRow['title']);  // cleaning special character;
			$aRows[$key]['title'] = $sTitle;
			
			$aRows[$key]['pubDate'] = date('Y-m-d:h:m',$aRow['time_stamp']) ;
			$aRows[$key]['upDate'] = date('Y-m-d:h:m',$aRow['time_update']) ;
			$aRows[$key]['category_name'] = $categoryNames;
			$aRows[$key]['comment'] = $comment;
			$aRows[$key]['text_pasrse'] = str_replace(array('[img]','[/img]'), array('&lt;img src=&quot;','&quot; /&gt;'), $aRow['text']);
		}
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_get__end')) ? eval($sPlugin) : false);
		$iOwnerUserId = $userID;
		return array($iOwnerUserId, $aRows);
	}

	/**
	 * 
	 * get BLog export for blogger
	 * @param unknown_type $userID
	 */
public function getBlogExportBlogger($userID) {

		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_get__start')) ? eval($sPlugin) : false);

		(($sPlugin = Phpfox_Plugin::get('blog.service_blog_get')) ? eval($sPlugin) : false);

		$limit = Phpfox::getUserParam('blog.number_of_export_blogs');
		if ($limit == -1){
			$limit = $this->database()-> select ('COUNT(*)')
			-> from(phpfox::getT('blog'),'b')
			->where(1)
			->execute('getSlaveField');
		}


		if (defined('PHPFOX_IS_USER_PROFILE') && Phpfox::getUserId()) {
			if (Phpfox::isModule('privacy')) {
				$this->database()->select('p.item_id AS privacy_pass, ')->leftJoin(Phpfox::getT('privacy'), 'p', "p.item_id = blog.blog_id AND p.category_id = 'blog' AND p.user_id = " . Phpfox::getUserId());
			}

			if (Phpfox::isModule('friend')) {
				$this->database()->select('f.friend_id AS is_friend, ')->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = blog.user_id AND f.friend_user_id = " . Phpfox::getUserId());
			}
		}

		$aRows = $this->database()->select("blog.*,blog_text.text AS text,". Phpfox::getUserField())
		->from($this->_sTable, 'blog')
		->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id')
		->join(Phpfox::getT('user'), 'u', 'u.user_id = blog.user_id')
		->where('blog.user_id = '.$userID)
		->limit($limit)
		->order('blog.time_stamp DESC')
		->execute('getSlaveRows');

		$aCache = array();

		foreach ($aRows as $key => $aRow) {
			$categoryNames = $this->getBlogCategoryName($aRow['blog_id']);
			$comment = $this->getBlogComment($aRow['blog_id']);
			$sTitle  = preg_replace('/\&#?[\d\w]+[^;]$/' ,'', $aRow['title']);  // cleaning special character;
			$aRows[$key]['title'] = $sTitle;
			
			$aRows[$key]['pubDate'] = date('c',$aRow['time_stamp']) ;
			$aRows[$key]['upDate'] = date('c',$aRow['time_update']) ;
			$aRows[$key]['category_name'] = $categoryNames;
			$aRows[$key]['comment'] = $comment;
			$aRows[$key]['text_pasrse'] = str_replace(array('[img]','[/img]'), array('&lt;img src=&quot;','&quot; /&gt;'), $aRow['text']);
		}
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_get__end')) ? eval($sPlugin) : false);
		$iOwnerUserId = $userID;
		return array($iOwnerUserId, $aRows);
	}
	
	
	public function getBlogWordPress($userID) {
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_get__start')) ? eval($sPlugin) : false);

		(($sPlugin = Phpfox_Plugin::get('blog.service_blog_get')) ? eval($sPlugin) : false);
		$limit = Phpfox::getUserParam('blog.number_of_export_blogs');

		if ($limit == -1){
			$limit = $this->database()-> select ('COUNT(*)')
			-> from(phpfox::getT('blog'),'b')
			->where(1)
			->execute('getSlaveField');
		}

		if (defined('PHPFOX_IS_USER_PROFILE') && Phpfox::getUserId()) {
			if (Phpfox::isModule('privacy')) {
				$this->database()->select('p.item_id AS privacy_pass, ')->leftJoin(Phpfox::getT('privacy'), 'p', "p.item_id = blog.blog_id AND p.category_id = 'blog' AND p.user_id = " . Phpfox::getUserId());
			}

			if (Phpfox::isModule('friend')) {
				$this->database()->select('f.friend_id AS is_friend, ')->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = blog.user_id AND f.friend_user_id = " . Phpfox::getUserId());
			}
		}


		$aRows = $this->database()->select("blog.*,blog_text.text_parsed AS text,". Phpfox::getUserField())
		->from($this->_sTable, 'blog')
		->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id')
		->join(Phpfox::getT('user'), 'u', 'u.user_id = blog.user_id')
		->where('blog.user_id = '.$userID)
		->limit($limit)
		->order('blog.time_stamp DESC')
		->execute('getSlaveRows');

		$aCache = array();

		foreach ($aRows as $key => $aRow) {

			$categoryNames = $this->getBlogCategoryName($aRow['blog_id']);
			$comment = $this->getBlogComment($aRow['blog_id']);
			$sTitle  = preg_replace('/\&#?[\d\w]+[^;]$/' ,'', $aRow['title']);  // cleaning special character;
			$aRows[$key]['title'] = $sTitle;
			$aRows[$key]['pubDate'] = date('Y-m-d:h:m',$aRow['time_stamp']) ;
			$aRows[$key]['upDate'] = date('Y-m-d:h:m',$aRow['time_update']) ;
			$aRows[$key]['category_name'] = $categoryNames;
			$aRows[$key]['comment'] = $comment;

		}

		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_get__end')) ? eval($sPlugin) : false);
		$iOwnerUserId = $userID;
		return array($iOwnerUserId, $aRows);
	}

}

?>
