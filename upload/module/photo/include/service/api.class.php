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
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Photo_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('photo');
		$this->_oApi = Phpfox::getService('api');	
	}
	
	public function add()
	{
		/*
		@title
		@info Share a photo. Simply pass a URL of a photo you wish to share. If successfull it will return an array of photos.
		@method GET
		@extra url=#{URL to the photo|string|yes}
		@return
		*/
		return $this->addPhoto();
	}	

	/**
	 * Adds a photo to an album of the name of the application.
	 * If such album does not exist it creates it.
	 */
	public function addPhoto()
	{
		// Check permission
		if ($this->_oApi->isAllowed('photo.add_photo') == false)
		{
			return $this->_oApi->error('photo.add_photo', 'User did not allow to upload photos on their behalf.');
		}	
		
		$oFile = Phpfox::getLib('file');
		$oImage = Phpfox::getLib('image');
		
		if (isset($_FILES['photo']))
		{
			$sType = 'png';
			switch($_FILES['photo']['type'])
			{
				case 'image/jpeg':
				case 'image/jpg':
					$sType = 'jpg';
					break;
				case 'image/gif':
					$sType = 'gif';
					break;
			}
		}
		
		$bIsUrlImage = false;
		if (empty($_FILES['photo']))
		{
			$sImage = $this->_oApi->get('url');
			$sType = $oFile->getFileExt($sImage);
			$sImageContent = file_get_contents($sImage);
			$bIsUrlImage = true;
		}
		
		$sImagePath = Phpfox::getParam('photo.dir_photo') . uniqid() . '.' . $sType;
		
		if ($bIsUrlImage)
		{
			$hFile = fopen($sImagePath, 'w');
			fwrite($hFile, $sImageContent);
			fclose($hFile);
			
			$_FILES['photo']['error'] = '';
			$_FILES['photo']['name'] = basename($sImagePath);
			$_FILES['photo']['size'] = filesize($sImagePath);
			$_FILES['photo']['type'] = $sType;
		}
		else
		{		
			move_uploaded_file($_FILES['photo']['tmp_name'], $sImagePath);
			$_FILES['photo']['name'] = $this->_oApi->get('photo_name');
		}		

		$_FILES['photo']['tmp_name'] = $sImagePath;
		
		$aImage = $oFile->load('photo', array(
			'jpg',
			'gif',
			'png'), (Phpfox::getUserParam('photo.photo_max_upload_size') === 0 ? null : (Phpfox::getUserParam('photo.photo_max_upload_size') / 1024))
		);

		$aImage['type_id'] = 1;
		$aImage['description'] = $this->_oApi->get('description');
		$aErrors = Phpfox_Error::get();
		if (!empty($aErrors))
		{
			return $this->_oApi->error('photo.photo_add_photo_load', array_pop($aErrors));
		}

		$aReturnPhotos = array();
		if ($iId = Phpfox::getService('photo.process')->add(PHPFOX_APP_USER_ID, $aImage))
		{
			$sFileName = $oFile->upload('photo', Phpfox::getParam('photo.dir_photo'), $iId);
			$sPath = Phpfox::getParam('photo.dir_photo');
			$aErrors = Phpfox_Error::get();
			if (!empty($aErrors))
			{
				return $this->_oApi->error('photo.photo_add_photo_upload', array_pop($aErrors));
			}

			$sPhotoTitle = $this->_oApi->get('photo_name');
			if (empty($sPhotoTitle))
			{
				$sPhotoTitle = $this->_oApi->getAppName() . ' ' . rand(100,999);
			}
			// Update the image with the full path to where it is located.
			$aSize = getimagesize(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, ''));
			Phpfox::getService('photo.process')->update(Phpfox::getUserId(), $iId, array(
					'destination' => $sFileName,
					'title' => $sPhotoTitle,
					'width' => $aSize[0],
					'height' => $aSize[1],					
					'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')
				)
			);		
			
			$aReturnPhotos['original'] = Phpfox::getParam('photo.url_photo') . sprintf($sFileName, '');
			
			foreach (Phpfox::getParam('photo.photo_pic_sizes') as $iSize)
			{
				if ($oImage->createThumbnail($sPath . sprintf($sFileName, ''), $sPath . sprintf($sFileName, '_' . $iSize), $iSize, $iSize) === false)
				{
					continue;
				}
				
				$aReturnPhotos[$iSize . 'px'] = Phpfox::getParam('photo.url_photo') . sprintf($sFileName, '_' . $iSize);

				if (Phpfox::getParam('photo.enabled_watermark_on_photos'))
				{
					$oImage->addMark($sPath . sprintf($sFileName, '_' . $iSize));
				}
			}

			if (Phpfox::getParam('photo.enabled_watermark_on_photos'))
			{
				$oImage->addMark($sPath . sprintf($sFileName, ''));
			}
			if (Phpfox::isModule('feed'))
			{
				$iPrivacy = null;
				$iPrivacyComment = null;
				$iFeedId = Phpfox::getService('feed.process')->add('photo', $iId, $iPrivacy, $iPrivacyComment, 0);
			}
			
			return $this->getPhotos($iId);
		}
	
		return $this->_oApi->error('photo.add_photo_process', 'Could not add photo to process');
	
	}
	
	public function get()
	{
		/*
		@title
		@info Get photos for a specific user or all public photos. Will return an array of different sizes.
		@method GET
		@extra user_id=#{User ID#|int|no}
		@return
		*/		
		return $this->getPhotos();
	}
	
	public function getPhotos($iId = 0)
	{
		if ((int) $this->_oApi->get('user_id') !== 0)
		{			
			$iUserId = $this->_oApi->get('user_id');
		}		
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'p')
			->where(($iId > 0 ? 'p.photo_id = ' . (int) $iId . '': 'p.view_id = 0 AND p.group_id = 0 AND p.type_id IN(0,1) AND p.privacy = 0 AND p.is_profile_photo = 0 ' . (isset($iUserId) ? ' AND p.user_id = ' . (int) $iUserId : '')))
			->execute('getSlaveField');
		
		$this->_oApi->setTotal($iCnt);
		
		$iOffset = ($this->_oApi->get('page') * 10);
		
		if (Phpfox::isModule('like'))
		{
			$this->database()->select('lik.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'lik', 'lik.type_id = \'photo\' AND lik.item_id = p.photo_id AND lik.user_id = ' . Phpfox::getUserId());
		}		
		
		$aRows = $this->database()->select('p.*, pi.description, ' . Phpfox::getUserField())
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->join(Phpfox::getT('photo_info'), 'pi', 'pi.photo_id = p.photo_id')
			->where(($iId > 0 ? 'p.photo_id = ' . (int) $iId . '': 'p.view_id = 0 AND p.group_id = 0 AND p.type_id IN (0,1) AND p.privacy = 0 AND p.is_profile_photo = 0 ' . (isset($iUserId) ? ' AND p.user_id = ' . (int) $iUserId : '')))			
			->limit($iOffset, 10)
			->order('p.time_stamp DESC')
			->execute('getSlaveRows');

		$aPhotos = array();
		foreach ($aRows as $iKey => $aRow)
		{
			$sImagePath = $aRow['destination'];

			$aPhotos[$iKey] = array(
					'id' => $aRow['photo_id'],
					'title' => $aRow['title'],
					'likes' => $aRow['total_like'],
					'comments' => $aRow['total_comment'],
					'uploaded_by' => $aRow['full_name'],
					'uploaded_by_id' => $aRow['user_id'],
					'uploaded_by_url' => Phpfox::getLib('url')->makeUrl($aRow['user_name']),
					'uploaded_by_username' => $aRow['user_name'],
					'description' => Phpfox::getLib('parse.output')->parse($aRow['description']),
					'permalink' => Phpfox::permalink('photo', $aRow['photo_id'], $aRow['title']),
					'is_liked' => (empty($aRow['is_liked']) ? false : true)
					);
			
			$aPhotos[$iKey]['convert_time_stamp'] = Phpfox::getLib('date')->convertTime($aRow['time_stamp'], 'comment.comment_time_stamp');
			
			$aPhotos[$iKey]['uploaded_by_image'] = Phpfox::getLib('image.helper')->display(array(
					'user' => $aRow,
					'suffix' => '_50_square',
					'return_url' => true
				)
			);			
			
			$aPhotos[$iKey]['photo_100px'] = Phpfox::getLib('image.helper')->display(array(
					'path' => 'photo.url_photo',
					'server_id' => $aRow['server_id'],
					'file' => $aRow['destination'],
					'suffix' => '_100',
					'return_url' => true
				)
			);	
			
			$aPhotos[$iKey]['photo_240px'] = Phpfox::getLib('image.helper')->display(array(
					'path' => 'photo.url_photo',
					'server_id' => $aRow['server_id'],
					'file' => $aRow['destination'],
					'suffix' => '_240',
					'return_url' => true
				)
			);
			
			$aPhotos[$iKey]['photo_500px'] = Phpfox::getLib('image.helper')->display(array(
					'path' => 'photo.url_photo',
					'server_id' => $aRow['server_id'],
					'file' => $aRow['destination'],
					'suffix' => '_500',
					'return_url' => true
				)
			);	

			$aPhotos[$iKey]['photo_1024px'] = Phpfox::getLib('image.helper')->display(array(
					'path' => 'photo.url_photo',
					'server_id' => $aRow['server_id'],
					'file' => $aRow['destination'],
					'suffix' => '_1024',
					'return_url' => true
				)
			);			
			
			$aPhotos[$iKey]['photo_original'] = Phpfox::getLib('image.helper')->display(array(
					'path' => 'photo.url_photo',
					'server_id' => $aRow['server_id'],
					'file' => $aRow['destination'],
					'suffix' => '',
					'return_url' => true
				)
			);				
		}
		
		if ($iId > 0)
		{
			return $aPhotos[0];
		}
		
		return $aPhotos;
	}
	
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing 
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('photo.service_api__call'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>
