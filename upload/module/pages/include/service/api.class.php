<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Service
 * @version 		$Id: api.class.php 5616 2013-04-10 07:54:55Z Miguel_Espinoza $
 */
class Pages_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('pages');
		$this->_oApi = Phpfox::getService('api');	
	}
	
	public function categories()
	{
		/*
		@title
		@info Get a list of all the categories.
		@method GET
		@extra
		@return type_id=#{Parent category ID#|int}&name=#{Name of the category|string}&sub_categories=#{An array of sub-categories|array}
		*/		
		
		$aCategories = Phpfox::getService('pages.category')->getCategories();
		
		foreach ($aCategories as $iKey => $aCategory)
		{
			unset($aCategories[$iKey]['time_stamp']);
			unset($aCategories[$iKey]['ordering']);
			unset($aCategories[$iKey]['is_active']);
			
			if (isset($aCategory['sub_categories']) && is_array($aCategory['sub_categories']))
			{
				foreach ($aCategory['sub_categories'] as $iSubKey => $aSub)
				{
					unset($aCategories[$iKey]['sub_categories'][$iSubKey]['type_id']);
					unset($aCategories[$iKey]['sub_categories'][$iSubKey]['page_type']);
					unset($aCategories[$iKey]['sub_categories'][$iSubKey]['is_active']);
					unset($aCategories[$iKey]['sub_categories'][$iSubKey]['ordering']);
				}
			}
		}
		
		return $aCategories;
	}
	
	public function add()
	{
		/*
		@title
		@info Create a page. On success it will return information about the new page.
		@method POST
		@extra title=#{Title of the page|string|yes}&info=#{Information about the page|string|yes}&type_id=#{Parent category ID#. Use [action]page.categories[/action]|int|yes}&category_id=#{Sub-category ID#. Use [action]page.categories[/action]|int|yes}&image=#{Default avatar/logo for the page. Must be an HTTP path to an image|string|no}
		@return page_id=#{Page ID#|int}&profile_user_id=#{This is the profile user ID# for the page|int}&title=#{Title of the page|string}&likes=#{Total number of likes|int}&permalink=#{Link to the page|string}&info=#{Information about the page|string}&created_by=#{Person who created the page|string}&created_by_url=#{Profile link of the person who created the page|string}&photo_100px=#{Photo of the page. 100px|string}&photo_100px_square=#{Square photo of the page. 100px|string}
		*/
		
		if ($this->_oApi->isAllowed('pages.add_page') == false)
		{
			return $this->_oApi->error('pages.add_page', 'Unable to create a page for this user.');
		}		
		
		$aInsert = array(
				'title' => $this->_oApi->get('title'),
				'info' => $this->_oApi->get('info'),
				'type_id' => $this->_oApi->get('type_id'),
				'category_id' => $this->_oApi->get('category_id')
			);

		$iId = Phpfox::getService('pages.process')->add($aInsert);
		if (!$iId)
		{
			return $this->_oApi->error('pages.unable_to_add_page', implode('', Phpfox_Error::get()));
		}
		
		$aPages = $this->get($iId);

		if ($this->_oApi->get('image') != '')
		{
			$sType = $this->_oApi->get('image_type');
			$sImageContent = file_get_contents($this->_oApi->get('image'));
			
			$sImagePath = Phpfox::getParam('pages.dir_image') . $aPages[0]['page_id'] . '.' . $sType;
			
			$hFile = fopen($sImagePath, 'w');
			fwrite($hFile, $sImageContent);
			fclose($hFile);
			
			$_FILES['photo']['error'] = '';
			$_FILES['photo']['tmp_name'] = $sImagePath;
			$_FILES['photo']['name'] = $this->_oApi->get('photo_name');		
			
			$oFile = Phpfox::getLib('file');
			$oImage = Phpfox::getLib('image');		
			
			$aImage = $oFile->load('photo', array(
					'jpg',
					'gif',
					'png'), (Phpfox::getUserParam('pages.max_upload_size_pages') === 0 ? null : (Phpfox::getUserParam('pages.max_upload_size_pages') / 1024))
			);
			
			$sFileName = $oFile->upload('photo', Phpfox::getParam('pages.dir_image'), $iId);
			$sPath = Phpfox::getParam('pages.dir_image');		
			
			$iFileSizes = filesize(Phpfox::getParam('pages.dir_image') . sprintf($sFileName, ''));
				
			$aUpdate['image_path'] = $sFileName;
			$aUpdate['image_server_id'] = Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID');
				
			$iSize = 50;
			$oImage->createThumbnail(Phpfox::getParam('pages.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('pages.dir_image') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);
			$iFileSizes += filesize(Phpfox::getParam('pages.dir_image') . sprintf($sFileName, '_' . $iSize));
				
			$iSize = 120;
			$oImage->createThumbnail(Phpfox::getParam('pages.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('pages.dir_image') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);
			$iFileSizes += filesize(Phpfox::getParam('pages.dir_image') . sprintf($sFileName, '_' . $iSize));
			
			$iSize = 200;
			$oImage->createThumbnail(Phpfox::getParam('pages.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('pages.dir_image') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);
			$iFileSizes += filesize(Phpfox::getParam('pages.dir_image') . sprintf($sFileName, '_' . $iSize));
				
			define('PHPFOX_PAGES_IS_IN_UPDATE', true);
				
			Phpfox::getService('user.process')->uploadImage($aPages[0]['profile_user_id'], true, Phpfox::getParam('pages.dir_image') . sprintf($sFileName, ''));
				
			// Update user space usage
			Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'pages', $iFileSizes);
			
			$this->database()->update($this->_sTable, $aUpdate, 'page_id = ' . (int) $iId);
			
			$aPages = $this->get($iId);
		}		
		
		return $aPages[0];
	}
	
	public function get($iId = 0)
	{
		/*
		@title
		@info Get all public pages. If you pass a user ID# it will return just the pages for this user. If you pass a page ID# it will return just that page.
		@method GET
		@extra user_id=#{User ID#|int|no}&id=#{Page ID#|int|no}
		@return page_id=#{Page ID#|int}&profile_user_id=#{This is the profile user ID# for the page|int}&title=#{Title of the page|string}&likes=#{Total number of likes|int}&permalink=#{Link to the page|string}&info=#{Information about the page|string}&created_by=#{Person who created the page|string}&created_by_url=#{Profile link of the person who created the page|string}&photo_100px=#{Photo of the page. 100px|string}&photo_100px_square=#{Square photo of the page. 100px|string}
		*/		
		$iUserId = $this->_oApi->get('user_id');
		if ((int) $this->_oApi->get('id') !== 0)
		{
			$iId = $this->_oApi->get('id');
		}		
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'p')
			->where((empty($iId) ? 'p.app_id = 0 AND p.view_id = 0 ' . (empty($iUserId) ? '' : 'AND p.user_id = ' . (int) $iUserId . '') . ' AND p.privacy = 0' : 'p.page_id = ' . (int) $iId))
			->execute('getSlaveField');
		
		$this->_oApi->setTotal($iCnt);
		
		$aRows = $this->database()->select('p.*, u.user_id AS profile_user_id, u.user_image, u.server_id AS user_server_id, pu.vanity_url, pt.text_parsed, u2.full_name, u2.user_name')
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'), 'u', 'u.profile_page_id = p.page_id')
			->join(Phpfox::getT('user'), 'u2', 'u2.user_id = p.user_id')
			->leftJoin(Phpfox::getT('pages_url'), 'pu', 'pu.page_id = p.page_id')
			->leftJoin(Phpfox::getT('pages_text'), 'pt', 'pt.page_id = p.page_id')
			->where((empty($iId) ? 'p.app_id = 0 AND p.view_id = 0 ' . (empty($iUserId) ? '' : 'AND p.user_id = ' . (int) $iUserId . '') . ' AND p.privacy = 0' : 'p.page_id = ' . (int) $iId))
			->limit($this->_oApi->get('page'), 10, $iCnt)
			->order('p.time_stamp DESC')
			->execute('getSlaveRows');	

		$aReturn = array();
		foreach ($aRows as $iKey => $aRow)
		{	
			$aReturn[$iKey] = array(
					'page_id' => $aRow['page_id'],
					'profile_user_id' => $aRow['profile_user_id'],
					'title' => $aRow['title'],
					'permalink' => $aRow['total_like'],
					'url' => Phpfox::getService('pages')->getUrl($aRow['page_id'], $aRow['title'], $aRow['vanity_url']),
					'info' => Phpfox::getLib('parse.output')->parse($aRow['text_parsed']),
					'created_by' => $aRow['full_name'],
					'created_by_url' => Phpfox::getLib('url')->makeUrl($aRow['user_name'])
				);
			
			$aReturn[$iKey]['photo_100px'] = Phpfox::getLib('image.helper')->display(array(
					'path' => 'core.url_user',
					'server_id' => $aRow['user_server_id'],
					'file' => $aRow['user_image'],
					'suffix' => '_100',
					'return_url' => true
				)
			);		

			$aReturn[$iKey]['photo_120px_square'] = Phpfox::getLib('image.helper')->display(array(
					'path' => 'core.url_user',
					'server_id' => $aRow['user_server_id'],
					'file' => $aRow['user_image'],
					'suffix' => '_120_square',
					'return_url' => true
				)
			);			
		}
		
		return $aReturn;
	}	
}

?>