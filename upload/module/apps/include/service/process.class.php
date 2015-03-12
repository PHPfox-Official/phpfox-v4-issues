<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Service
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Apps_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		/*
		 * `phpfox_app_installed` 
		 *			Stores users who have installed a specific app
		 * `phpfox_app_disallow` 
		 *			Stores the variables that a user did not allow when 
		 * 				installing the app, every other is assumed allowed
		 * `phpfox_app_access`
		 *			Stores a token which is used to validate a user visiting an app
		*/	
	}	
	
	public function import($sAppKey, $aFile)
	{
		if (empty($sAppKey))
		{
			return Phpfox_Error::set('Provide an app key.');
		}
		
		$aXml = Phpfox::getLib('xml.parser')->parse($aFile['tmp_name']);
		if (!isset($aXml['appsinfo']))
		{
			return false;
		}
		
		$mReturn = (bool) Phpfox::getLib('request')->send($aXml['appsinfo']['url'], array('app_key' => $sAppKey, 'app_url' => Phpfox::getParam('core.path')));

		if ($mReturn)
		{
			$aReturn = array();
			$aExported = (isset($aXml['apps']['app']) ? $aXml['apps']['app'] : $aXml['apps']);

			foreach ($aExported as $aApps)
			{
				if (isset($aApps['images']) && !empty($aApps['images']['data'][0]['value']))
				{
					foreach ($aApps['images']['data'] as $aImage)
					{
						$sImageNameOriginal = md5(Phpfox::getUserId() . $sAppKey) . '%s.' . $aImage['ext'];
						$sImageName = md5(Phpfox::getUserId() . $sAppKey) . $aImage['size'] . '.' . $aImage['ext'];
						$sBuildDir = Phpfox::getLib('file')->getBuiltDir(Phpfox::getParam('app.dir_image')) . $sImageName;
						
						Phpfox::getLib('file')->writeToCache($sImageName, base64_decode($aImage['value']));
						
						copy(PHPFOX_DIR_CACHE . $sImageName, $sBuildDir);
						unlink(PHPFOX_DIR_CACHE . $sImageName);
					}
				}				

				$mReturn = $this->addApp($aApps, true);		
				if (isset($sImageNameOriginal))
				{
					$this->database()->update(Phpfox::getT('app'), array('image_path' => str_replace(Phpfox::getParam('app.dir_image'), '', Phpfox::getLib('file')->getBuiltDir(Phpfox::getParam('app.dir_image'))) . $sImageNameOriginal), 'app_id = ' . (int) $mReturn['app_id']);
				}
			}			
		}
		else
		{
			Phpfox_Error::set('Unable to find your site.');
		}
				
		return $mReturn;
	}
	
	/**
	 * Called from ajax this function keeps a token alive which grants an app access to
	 * the resources shared by Phpfox::getUser
	 */
	public function alive($iAppId)
	{
		/*
		Phpfox::isUser(true);
		$this->database()->update(Phpfox::getT('app_access'), array(
			'time_stamp' => PHPFOX_TIME
			), 'app_id = ' . (int)$iAppId . ' AND user_id = ' . Phpfox::getUserId());
		*/
	}
	
	/**
	 * Generates a key, that can be used as public or private by the apps
	 * @param int $iLength how long the key
	 * @return string
	 */
	public function generateKey($iLength = 32)
	{
		$aChars = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		for ($i = 0; $i < 10; $i++) $aChars[] = $i;
		
		$sKey = '';
		for ($i = 0; $i < $iLength; $i++)
		{
			$sKey .= $aChars[array_rand($aChars)];
		}
		return $sKey;
	}
	
	/**
	 * This function receives an array coming directly from the user and the register
	 * controller. It receives an image and creates a page as well as the thumbnails
	 * for the app
	 * @param type $aVals 
	 */
	public function addApp($aVals, $bForce = false)
	{
		if (!$bForce)
		{
			Phpfox::getUserParam('apps.can_add_app', true);
			if (empty($aVals['name']))
			{
				Phpfox_Error::set(Phpfox::getPhrase('apps.every_field_is_required'));
			}
		}
		$oParse = Phpfox::getLib('parse.input');
		
		if (Phpfox_Error::isPassed())
		{
			$sPublicKey = $this->generateKey(32);
			$sPrivateKey = $this->generateKey(32);
			
			$aInsert = array(
				'app_title' => $oParse->clean(($bForce ? $aVals['app_title'] : $aVals['name'])),
				'app_description' => ($bForce ? $oParse->clean($aVals['app_description']) : null),
				'public_key' => $sPublicKey,
				'private_key' => $sPrivateKey,				
				'user_id' => Phpfox::getUserId(),
				'time_stamp' => ($bForce ? $aVals['time_stamp'] : PHPFOX_TIME),
				'app_url' => ($bForce ? $oParse->clean($aVals['app_url']) : null),
				'view_id' => ((!$bForce && Phpfox::getUserParam('apps.apps_require_moderation')) ? '1' : '0')
			);
			
			// Insert in phpfox_app
			$iId = $this->database()->insert(Phpfox::getT('app'), $aInsert);			
			
			// Assign category
			if (!$bForce)
			{
				$iCategory = $this->database()->insert(Phpfox::getT('app_category_data'), array('category_id' => (int)$aVals['category'], 'app_id' => $iId));
			}			
			
			// define('PHPFOX_APP_CREATED', $iId);
			// Create the page
			$iPage = Phpfox::getService('pages.process')->add(array(
					'app_id' => $iId,
					'title' => ($bForce ? $aVals['app_title'] : $aVals['name'])
				), true
			);			
						
			return array('app_id' => $iId, 'app_title' => $aInsert['app_title']);
		}
		return false;
	}
	
	/**
	 * Ajax called
	 * @param type $aId
	 * @return type 
	 */
	public function approveApp($aId)
	{
		Phpfox::getUserParam('apps.can_moderate_apps', true);
		if (!is_array($aId))
		{
			$aId = array($aId);
		}
		$sWhere = '';
		foreach ($aId as $iId)
		{
			$sWhere .= 'app_id = ' . (int)$iId . ' OR ';
		}
		$sWhere = rtrim($sWhere, ' OR ');
		$this->database()->update(Phpfox::getT('app'), array('view_id' => '0'), $sWhere);
		return true;
	}
	
	/**
	 * This function installs an app for a user
	 * @param int $iUserId
	 * @param int $iAppId
	 * @return bool 
	 */
	public function install($iAppId, $aDisallow)
	{
		
		if ( ((int)$iAppId) < 1)
		{
			return Phpfox_Error::set('Invalid App');
		}
		$this->database()->insert(Phpfox::getT('app_installed'), array(
			'app_id' => (int)$iAppId, 
			'user_id' => Phpfox::getUserId(),
			'time_stamp' => PHPFOX_TIME));
		
		if (!empty($aDisallow))
		{
			$oParse = Phpfox::getLib('parse.input');
			foreach ($aDisallow as $sFunction)
			{
				$sFunction = $oParse->clean($sFunction);
				if (!empty($sFunction))
				{
					$this->database()->insert(Phpfox::getT('app_disallow'), array(
						'app_id' => (int)$iAppId,
						'user_id' => Phpfox::getUserId(),
						'var_name' => $sFunction
					));
				}				
			}
		}
		
		$this->cache()->remove(array('user', 'apps_' . Phpfox::getUserId()));
		
		return true;
	}
	
	private function _deleteApp($iId)
	{
		$aApp = $this->database()->select('*')
					->from(Phpfox::getT('app'))
					->where('app_id = ' . (int)$iId)
					->execute('getSlaveRow');
		
		if (!Phpfox::getUserParam('apps.can_moderate_apps') && ($aApp['user_id'] != Phpfox::getUserId()) )
		{		
			return Phpfox_Error::display(Phpfox::getPhrase('apps.you_are_not_allowed_to_delete_this_app'));
		}
		if (empty($aApp))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('apps.this_app_does_not_exist'));
		}
		// Delete the image
		if (!empty($aApp['image_path']))
		{
			if (file_exists(Phpfox::getParam('app.dir_image') . sprintf($aApp['image_path'], '_square')))
			{
				Phpfox::getLib('file')->unlink(Phpfox::getParam('app.dir_image') . sprintf($aApp['image_path'], '_square'));
			}
			if (file_exists(Phpfox::getParam('app.dir_image') . sprintf($aApp['image_path'], '_120')))
			{
				Phpfox::getLib('file')->unlink(Phpfox::getParam('app.dir_image') . sprintf($aApp['image_path'], '_120'));
			}
		}
		
		// Delete record holding users who installed this app
		$this->database()->delete(Phpfox::getT('app_installed'), 'app_id = ' . $aApp['app_id']);
		
		// Remove this app from the categories
		$this->database()->delete(Phpfox::getT('app_category_data'), 'app_id = ' . $aApp['app_id']);
		
		// Remove visits to this app
		// $this->database()->delete(Phpfox::getT('app_access'), 'app_id = ' . $aApp['app_id']);
		
		// remove permissions restrictions
		$this->database()->delete(Phpfox::getT('app_disallow'), 'app_id = ' . $aApp['app_id']);
		// Delete the page?
		
		// When we store Likes we could also delete them here unless they belong to the page.
		
		// Finally, remove the app
		$this->database()->delete(Phpfox::getT('app'), 'app_id = ' . $aApp['app_id']);
		
		// Delete the page
		$iPageId = $this->database()->select('page_id')
				->from(Phpfox::getT('pages'))
				->where('app_id = ' . $aApp['app_id'])
				->execute('getSlaveField');
		
		return Phpfox::getService('pages.process')->delete($iPageId);
		
	}
	/**
	 * Manages deleting an app, it stops at the first error.
	 * @param array|int $iId 
	 * @return bool
	 */
	public function deleteApp($aId)
	{
		if (!is_array($aId))
		{
			$aId = array($aId);
		}
		foreach ($aId as $iId)
		{
			if ($this->_deleteApp($iId) != true)
			{
				return false;
			}
		}
		return true;
	}
	
	
	/**
	 * Uninstalls the app for one user
	 * Removes records from phpfox_app_access, and phpfox_app_installed
	 * @param bool $iId 
	 */
	public function uninstallApp($iId)
	{
		// Remove from the install table
		$this->database()->delete(Phpfox::getT('app_installed'), 'app_id = ' . (int)$iId . ' AND user_id = ' . Phpfox::getUserId());
		// remove from the tokens table (the one that allows access)
		// $this->database()->delete(Phpfox::getT('app_access'), 'app_id = ' . (int)$iId .' AND user_id = ' . Phpfox::getUserId());
		
		$this->cache()->remove(array('user', 'apps_' . Phpfox::getUserId()));
		
		return true;
	}
	
	/**
	 * This function is called from the add controller when a user submitted an edited 
	 * version of their app. 
	 * @param type $aVals
	 * @param type $aApp 
	 */
	public function updateApp($aVals)
	{		
		// get the app and make sure this user is allowed to edit it
		$aApp = Phpfox::getService('apps')->getAppById($aVals['app_id']);
		
		if (empty($aApp) || ($aApp['user_id'] != Phpfox::getUserId() && !Phpfox::isAdmin()))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('apps.cannot_edit_this_app'));
		}
		
		$oParse = Phpfox::getLib('parse.input');
		
		$sUrl = null;
		if (!empty($aVals['app_url']))
		{
			$sUrl = rtrim($oParse->clean($aVals['app_url']), '/') . '/';
			
			if (!preg_match('/^(http|https):\/\/(.*)$/i', $sUrl))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('apps.please_provide_a_valid_url'));
			}
		}
		
		$sReturnUrl = true;
		if (!empty($aVals['return_url']) && strlen($aVals['return_url']) > 0)
		{
			$sReturnUrl = rtrim($oParse->clean($aVals['return_url']), '/') . '/';
		}
		
		$this->database()->update(Phpfox::getT('app'), array(
			'app_title' => $oParse->clean($aVals['title']),
			'app_description' => $oParse->clean($aVals['description']),
			'app_url' => $sUrl,
			'return_url' => ($sReturnUrl !== true ? $sReturnUrl : ''),
			'is_ext' => (isset($aVals['is_ext']) ? (int) $aVals['is_ext'] : '0')
		), 'app_id = ' . $aApp['app_id']);
		
		if (!empty($_FILES['image']['name']))
		{
			// Upload this picture before deleting the old one
			$oFile = Phpfox::getLib('file');
			$oImage = Phpfox::getLib('image');
			
			Phpfox::getLib('file')->load('image');
			$sFileName = $oFile->upload('image', Phpfox::getParam('app.dir_image'), $aApp['app_id']);
			$this->database()->update(Phpfox::getT('app'), array('image_path' => $sFileName), 'app_id = ' . $aApp['app_id']);
			
			// Create thumbnail						
			$oImage->createThumbnail(Phpfox::getParam('app.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('app.dir_image') . sprintf($sFileName, '_200'), 200, 200);
			
			// $iSize = 50;
			$aSizes = array(50, 120);
			foreach ($aSizes as $iSize)
			{
				$oImage->createThumbnail(Phpfox::getParam('app.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('app.dir_image') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);
				$oImage->createThumbnail(Phpfox::getParam('app.dir_image') . sprintf($sFileName . '', ''), Phpfox::getParam('app.dir_image') . sprintf($sFileName, '_square'), $iSize, $iSize, false);
			}
			
			// update the image from the database
			$this->database()->update(Phpfox::getT('app'), array('image_path' => $sFileName), 'app_id = ' . $aApp['app_id']);
			
			if (Phpfox::isModule('pages'))
			{
				$this->database()->update(Phpfox::getT('pages'), array('image_path' => $sFileName), 'app_id = ' . $aApp['app_id']);
			}
			
			// now we can delete the old image
			if (!empty($aApp['image_path']))
			{
				if (file_exists(Phpfox::getParam('app.dir_image') . sprintf($aApp['image_path'], '')))
				{
					Phpfox::getLib('file')->unlink(Phpfox::getParam('app.dir_image') . sprintf($aApp['image_path'], ''));
				}

				if (file_exists(Phpfox::getParam('app.dir_image') . sprintf($aApp['image_path'], '_' . $iSize)))
				{
					Phpfox::getLib('file')->unlink(Phpfox::getParam('app.dir_image') . sprintf($aApp['image_path'], '_' . $iSize));
				}
			}
		}
		// update the category for this app
		$this->database()->delete(Phpfox::getT('app_category_data'), 'app_id = ' . $aApp['app_id']);
		$this->database()->insert(Phpfox::getT('app_category_data'), array(
			'category_id' => (int)$aVals['category'],
			'app_id' => $aApp['app_id']
		));
		
		// http://www.phpfox.com/tracker/view/15245/
		// Update the page associated with the app
		$this->database()->update(Phpfox::getT('pages'), array('title' => $oParse->clean($aVals['title'])), 'app_id = ' . $aApp['app_id']);
		$iPageId = $this->database()->select('page_id')->from(Phpfox::getT('pages'))->where('app_id = ' . $aApp['app_id'])->execute('getSlaveField');
		$this->database()->update(Phpfox::getT('user'), array('full_name' => $oParse->clean($aVals['title'])), 'profile_page_id = ' . $iPageId);
		
		return true;
	}
	
	
	/**
	 * This function updates the variables disallowed by Phpfox::getUserId
	 * All the variables not in `app_disallow` are assumed allowed
	 * @param type $iAppId
	 * @param type $aPermissions 
	 */
	public function updatePermissions($iAppId, $aPermissions)
	{
		Phpfox::isUser(true);
		
		$this->database()->delete(Phpfox::getT('app_disallow'), 'app_id = ' . (int)$iAppId . ' AND user_id = ' . Phpfox::getUserId());
		// check for invalid functions
		$aAllPerms = Phpfox::getService('apps')->getPermissions();
		
		foreach ($aPermissions as $sFunction)
		{
			foreach ($aAllPerms as $aPerm)
			{
				if ($aPerm['sVariable'] == $sFunction)
				{
					$this->database()->insert(Phpfox::getT('app_disallow'), array(
						'app_id' => (int)$iAppId,
						'user_id' => Phpfox::getUserId(),
						'var_name' => $aPerm['sVariable']
					));
				}
			}
		}
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
		if ($sPlugin = Phpfox_Plugin::get('apps.service_process__call'))
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
