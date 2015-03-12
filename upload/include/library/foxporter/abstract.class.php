<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: abstract.class.php 2921 2011-08-29 17:35:44Z Raymond_Benc $
 */
abstract class Foxporter_Abstract implements Foxporter_Interface
{	
	public function __construct()
	{	
	}
	
	public function database()
	{
		return Phpfox::getLib('database');	
	}
	
	public function parseInput()
	{
		return Phpfox::getLib('parse.input');	
	}	
	
	public function getSteps()
	{
		return $this->_aSteps;
	}
	
	public function getDetails()
	{
		return $this->_aDetails;
	}
	
	/**
	 * Adds a user.
	 * Required fields:
	 * - full_name - string(255) - Used as the site wide display name
	 * - email - string(255) - Users unique email
	 * 
	 * Option fields:
	 * - user_name - string(100) - Used to create vanity URL, if not passed we will create one from the "full_name"
	 * - birth_year - int - Users birth year
	 * - birth_month - int - Users birth month
	 * - birth_day - int - Users birth day
	 * - gender - string - Users gender (Must be "male" or "female")
	 * - country - string - Users location (eg. United States, Sweden etc...)
	 * - city - string - Users city (eg. Miami, Stockholm etc...)
	 * - state - string - Users state/province (eg. Florida, Skane etc...)
	 * - joined - int - Time stamp of when the user joined (Must be a UNIX time stamp)
	 *
	 * @param array $aVals Holds an array of all the required/option fields
	 */
	public function addUser($aVals)
	{
		static $aCacheData = null;
		
		if ($aCacheData === null)
		{
			$aRows = $this->database()->select('country_iso, name')
				->from(Phpfox::getT('country'))
				->execute('getRows');
			foreach ($aRows as $aRow)
			{
				$aCacheData['country'][strtolower($aRow['name'])] = $aRow['country_iso'];
				$aCacheData['country_iso'][$aRow['country_iso']] = $aRow['country_iso'];
			}
			
			$aRows = $this->database()->select('child_id, name')
				->from(Phpfox::getT('country_child'))
				->execute('getRows');
			foreach ($aRows as $aRow)
			{
				$aCacheData['country_child'][strtolower($aRow['name'])] = $aRow['child_id'];
			}			
		}
		
		if (empty($aVals['full_name']) || empty($aVals['email']))
		{
			return false;
		}
		
		$aUser = array(
			'user_group_id' => '2',
			'full_name' => $aVals['full_name'],
			'email' => $aVals['email']
		);
		
		$iEmailCheck = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('user'))
			->where('email = \'' . $this->database()->escape($aVals['email']) . '\'')
			->execute('getField');
			
		if ($iEmailCheck)
		{
			return false;
		}
		
		if (empty($aVals['password']))
		{
			$sSalt = '';
			for ($i = 0; $i < 3; $i++)
			{
				$sSalt .= chr(rand(33, 91));
			}			
		}		
		
		if (!empty($aVals['birth_year']))
		{
			$aVals['day'] = (int) (empty($aVals['day']) ? date('d') : $aVals['birth_day']);
			$aVals['month'] = (int) (empty($aVals['month']) ? date('m') : $aVals['birth_month']);
			$aVals['year'] = (int) (empty($aVals['year']) ? date('Y') : $aVals['birth_year']);
			if ($aVals['day'] === 0 || $aVals['day'] > 31)
			{
				$aVals['day'] = 1;
			}
			if ($aVals['month'] === 0 || $aVals['month'] > 12)
			{
				$aVals['month'] = 1;
			}
			if ($aVals['year'] < 1900)
			{
				$aVals['year'] = 1982;
			}		
			
			$aUser['birthday'] = Phpfox::getService('user')->buildAge($aVals['day'], $aVals['month'], $aVals['year']);
			$aUser['birthday_search'] = Phpfox::getLib('date')->mktime(0, 0, 0, $aVals['month'], $aVals['day'], $aVals['year']);
		}
		
		if (!empty($aVals['gender']))
		{
			$aUser['gender'] = (strtolower($aVals['gender']) == 'male' ? '1' : '2');	
		}
		
		if (empty($aVals['user_name']))
		{
			$aVals['user_name'] = $aVals['full_name'];	
		}			
		$aUser['user_name'] = Phpfox::getLib('parse.input')->cleanTitle($aVals['user_name']);
		Phpfox::getService('user.validate')->user($aUser['user_name']);
		// $aErrors = Phpfox_Error::get();		
		if (!Phpfox_Error::isPassed())
		{
			Phpfox_Error::reset();
			$aUser['user_name'] = $aUser['user_name'] . '_' . uniqid();
		}		
		
		if (!empty($aVals['country']) && isset($aCacheData['country']) && isset($aCacheData['country'][strtolower($aVals['country'])]))
		{
			$aUser['country_iso'] = $aCacheData['country'][strtolower($aVals['country'])];
		}
		
		if (!empty($aVals['country_iso']) && isset($aCacheData['country_iso']) && isset($aCacheData['country_iso'][$aVals['country_iso']]))
		{
			$aUser['country_iso'] = $aCacheData['country_iso'][$aVals['country_iso']];
		}		
		
		$sPassword = '';
		if (empty($aVals['password']))
		{		   	
			for ($i = 1; $i <= 10; $i++)
		   	{
		    	$sPassword .= substr('0123456789aBcDeF/()$#!', rand(0, 21), 1);
			}			
			
			$aUser['password'] = md5(md5($sPassword) . md5($sSalt));
			$aUser['password_salt'] = $sSalt;			
		}
		
		if (!empty($aVals['joined']))
		{
			$aUser['joined'] = $aVals['joined'];
		}
		
		if (!empty($aVals['last_login']))
		{
			$aUser['last_login'] = $aVals['last_login'];
		}
		
		if (!empty($aVals['last_activity']))
		{
			$aUser['last_activity'] = $aVals['last_activity'];
		}		
		
		$iId = $this->database()->insert(Phpfox::getT('user'), $aUser);
		
		$aUserField = array(
			'user_id' => $iId
		);
		
		if (!empty($aVals['city']))
		{
			$aUserField['city_location'] = $this->parseInput()->clean($aVals['city']);	
		}

		if (!empty($aVals['state']) && isset($aCacheData['country_child']) && isset($aCacheData['country_child'][strtolower($aVals['state'])]))
		{			
			$aUserField['country_child_id'] = $aCacheData['country_child'][strtolower($aVals['state'])];
		}		
		
		if (!empty($aVals['zip']))
		{
			$aUserField['postal_code'] = $this->parseInput()->clean($aVals['zip']);	
		}		
		
		if (!empty($aVals['birth_year']))
		{
			$aUserField['birthday_range'] = Phpfox::getService('user')->buildAge($aVals['day'], $aVals['month']);
		}
		
		if (!empty($aVals['total_view']))
		{
			$aUserField['total_view'] = (int) $aVals['total_view'];
		}
		
		$this->database()->insert(Phpfox::getT('user_field'), $aUserField);
		
		$aExtra = array(
			'user_id' => $iId
		);
		$this->database()->insert(Phpfox::getT('user_activity'), $aExtra);
		$this->database()->insert(Phpfox::getT('user_space'), $aExtra);
		$this->database()->insert(Phpfox::getT('user_count'), $aExtra);
		/*
		if (isset($aVals['import_user_id']))
		{
			$this->database()->insert(Phpfox::getT('user_import'), array(
					'import_user_id' => (int) $aVals['import_user_id'],
					'user_id' => $iId
				)
			);
		}		
		*/
		$oFile = Phpfox::getLib('file');
		$oImage = Phpfox::getLib('image');	
		
		if (!empty($aVals['profile_image']) && file_exists($aVals['profile_image']))
		{
			$sPath = $aVals['profile_image'];
			$sFileName = $iId . '%s.' . substr($sPath, -3);
			$sTo = Phpfox::getParam('core.dir_user') . sprintf($sFileName,'');
			
			if (file_exists($sTo))
			{
				$oFile->unlink($sTo);
			}
			$oFile->copy($sPath, $sTo);
			
			foreach(Phpfox::getParam('user.user_pic_sizes') as $iSize)
			{
				$oImage->createThumbnail(Phpfox::getParam('core.dir_user') . sprintf($sFileName, ''), Phpfox::getParam('core.dir_user') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);
				$oImage->createThumbnail(Phpfox::getParam('core.dir_user') . sprintf($sFileName, ''), Phpfox::getParam('core.dir_user') . sprintf($sFileName, '_' . $iSize . '_square'), $iSize, $iSize, false);									
			}				
			
			$this->database()->update(Phpfox::getT('user'), array('user_image' => $sFileName, 'server_id' => '0'), 'user_id = ' . (int) $iId);			
		}
		
		return array(
			'user_id' => $iId,
			'password' => $sPassword,
			'user_name' => $aUser['user_name']
		);
	}
	
	public function addFriend($iUserId, $iFriendId)
	{
		$iCheck = (int) $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('friend'))
			->where('user_id = ' . (int) $iUserId . ' AND friend_user_id = ' . (int) $iFriendId)
			->execute('getSlaveField');
		
		if (!$iCheck)
		{
			$this->database()->insert(Phpfox::getT('friend'), array('user_id' => (int) $iUserId, 'friend_user_id' => (int) $iFriendId, 'time_stamp' => PHPFOX_TIME));
		}
		
		return true;
	}
	
	public function addPhotoCategory($sName, $iOrdering = 0)
	{
		$iId = $this->database()->insert(Phpfox::getT('photo_category'), array(
				'name' => Phpfox::getLib('parse.input')->clean($sName),
				'time_stamp' => PHPFOX_TIME,
				'ordering' => $iOrdering
			)
		);
		
		return $iId;
	}
	
	public function addPhotoAlbum($aVals)
	{
		$iId = $this->database()->insert(Phpfox::getT('photo_album'), array(
				'privacy' => '0',
				'privacy_comment' => '0',
				'user_id' => $aVals['user_id'],
				'name' => Phpfox::getLib('parse.input')->clean($aVals['name']),
				'time_stamp' => $aVals['time_stamp'],
				'time_stamp_update' => $aVals['time_stamp_update'],
				'total_comment' => (int) $aVals['total_comment']			
			)
		);
		
		$this->database()->insert(Phpfox::getT('photo_album_info'), array('album_id' => $iId));
		
		return $iId;
	}
	
	public function addPhoto($aVals)
	{
		$iId = $this->database()->insert(Phpfox::getT('photo'), array(
				'album_id' => (int) $aVals['album_id'],
				'title' => Phpfox::getLib('parse.input')->clean($aVals['title']),
				'user_id' => (int) $aVals['user_id'],
				'time_stamp' => (int) $aVals['time_stamp'],
				'total_view' => (int) $aVals['total_view'],
				'total_comment' => (int) $aVals['total_comment'],
				'server_id' => '0'
			)
		);
		
		if (!empty($aVals['category_id']))
		{
			$this->database()->insert(Phpfox::getT('photo_category_data'), array('photo_id' => $iId, 'category_id' => (int) $aVals['category_id']));
		}
		
		list($iWidth, $iHeight) = getimagesize($aVals['photo_path']);
		
		$this->database()->insert(Phpfox::getT('photo_info'), array(
				'photo_id' => $iId,
				'file_name' => $aVals['file_name'],
				'file_size' => $aVals['file_size'],
				'mime_type' => $aVals['mime_type'],
				'extension' => $aVals['extension'],
				'width' => $iWidth,
				'height' => $iHeight
			)
		);
		
		$oFile = Phpfox::getLib('file');
		$oImage = Phpfox::getLib('image');	
		
		if (!empty($aVals['photo_path']) && file_exists($aVals['photo_path']))
		{
			$sPath = $aVals['photo_path'];
			$sFileName = $iId . '%s.' . substr($sPath, -3);
			$sTo = Phpfox::getParam('photo.dir_photo') . sprintf($sFileName,'');
			
			if (file_exists($sTo))
			{
				$oFile->unlink($sTo);
			}
			$oFile->copy($sPath, $sTo);
			
			foreach(Phpfox::getParam('photo.photo_pic_sizes') as $iSize)
			{
				$oImage->createThumbnail(Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, ''), Phpfox::getParam('photo.dir_photo') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize, true, ((Phpfox::getParam('photo.enabled_watermark_on_photos') && Phpfox::getParam('core.watermark_option') != 'none') ? (Phpfox::getParam('core.watermark_option') == 'image' ? 'force_skip' : true) : false));
			}		
			
			$this->database()->update(Phpfox::getT('photo'), array('destination' => $sFileName, 'server_id' => '0'), 'photo_id = ' . (int) $iId);			
		}
		
		return $iId;
	}
}

?>