<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Image Helper
 * Displays all the images we see on a phpFox site. Each image runs thru this class where
 * we perform many sanity and file size checks before they are displayed on a site.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: helper.class.php 7287 2014-04-28 16:29:52Z Fern $
 */
class Phpfox_Image_Helper
{	
	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{			
	}
	
	/**
	 * Returns a new width/height for an image based on the max arguments passed
	 *
	 * @param string $sImage Full path to the image
	 * @param int $iMaxHeight Max height of the image
	 * @param int $iMaxWidth Max width of the image
	 * @param int $iWidth Actual width of the image (optional)
	 * @param int $iHeight Actual height of the image (optional)
	 * @return array Returns an ARRAY, where argument 1 is the new height and argument 2 is the new width
	 */
	public function getNewSize($sImage = null, $iMaxHeight, $iMaxWidth, $iWidth = 0, $iHeight = 0)
	{
		if (is_array($sImage))
		{
			if(Phpfox::getParam('core.allow_cdn') && !Phpfox::getParam('core.keep_files_in_server') && isset($sImage[1]) && isset($sImage[2]))
			{
				$iWidth = $sImage[1];
				$iHeight = $sImage[2];
			}
			$sImage = $sImage[0];
		}
		else
		{
			if ($sImage !== null && (!file_exists($sImage) || filesize($sImage) < 1))
			{
				return array(0,0);
			}
		}
			
	    if (!$iWidth && !$iHeight)
	    {
			list($iWidth, $iHeight) = getimagesize($sImage);
	    }
	    
	    $k = "";		
	    //get scaling factor
	    if ($iMaxWidth && $iMaxHeight && $iWidth && $iHeight)
	    {
	        $kX = $iMaxWidth / $iWidth;
	        $kY = $iMaxHeight / $iHeight;
	        $k = min($kX, $kY);
	    }
	    elseif ($iMaxHeight && $iHeight)
	    {
	        $k = $iMaxHeight / $iHeight;
	    }
	    elseif ($iMaxWidth && $iWidth)
	    {
	        $k = $iMaxWidth / $iWidth;
	    }
	
	    //correct scaling factor
	    if (((0 >= $k) || ($k > 1)))
	    {
	        $k = 1;
	    }
	
	    $iHeight *= $k;
	    $iWidth *= $k;	    

		if ($iHeight < 1)
		{
			$iHeight = 1;
		}
		if ($iWidth < 1)
		{
			$iWidth = 1;
		}
	    return array(round($iHeight), round($iWidth));
	}
	
	/**
	 * Displays an image on the site based on params passed
	 *
	 * @param array $aParams Holds an ARRAY of params about the image
	 * @return string Returns the HTML <image> or the full path to the image based on the params passed with the 1st argument
	 */
	public function display($aParams, $bIsLoop = false)
	{
		static $aImages = array();
		
		// Create hash for cache
		$sHash = md5(serialize($aParams));
		
		// Return cached image
		if (isset($aImages[$sHash]))
		{
			return $aImages[$sHash];
		}
		
		$bIsServer = (!empty($aParams['server_id']) ? true : false);
				
		if (($sPlugin = Phpfox_Plugin::get('image_helper_display_start'))){eval($sPlugin);if (isset($mReturnPlugin)){return $mReturnPlugin;}}

		if (isset($aParams['theme']))
		{
			$sSrc = Phpfox::getLib('template')->getStyle('image', $aParams['theme']);				
			$sDirSrcTemp = str_replace(Phpfox::getParam('core.path'), PHPFOX_DIR, $sSrc);										
			if (isset($aParams['default']) && !file_exists($sDirSrcTemp))
			{				
				$sSrc = Phpfox::getLib('template')->getStyle('image', $aParams['default']);	
			}							
		}
				
		if (isset($aParams['max_height']) && !is_numeric($aParams['max_height']))
		{
			$aParams['max_height'] = Phpfox::getParam($aParams['max_height']);
		}
		
		if (isset($aParams['max_width']) && !is_numeric($aParams['max_width']))
		{
			$aParams['max_width'] = Phpfox::getParam($aParams['max_width']);
		}
		
		// Check if this is a users profile image
		$bIsOnline = false;
		$bDefer = false;
		
		if (isset($aParams['user']))
		{
			$bDefer = Phpfox::getParam('core.defer_loading_user_images');
			$sSuffix = '';
			if (isset($aParams['user_suffix']))
			{
				$sSuffix = $aParams['user_suffix'];	
			}
			
			$sOnline = '';			
			if (!defined('PHPFOX_INSTALLER')
				&& Phpfox::getParam('user.display_user_online_status')
				&& isset($aParams['user']) 
				&& isset($aParams['user'][$sSuffix . 'is_invisible']) 
				&& !$aParams['user'][$sSuffix . 'is_invisible'] 
				&& isset($aParams['user'][$sSuffix . 'last_activity'])
				&& $aParams['user'][$sSuffix . 'last_activity'] > (PHPFOX_TIME - (Phpfox::getParam('log.active_session') * 60))
				&& !isset($aParams['no_online_status'])
			)
			{
				$bIsOnline = true;		
			}				
			
			// Create the local params
			$aParams['server_id'] = (isset($aParams['user']['user_' . $sSuffix . 'server_id']) ? $aParams['user']['user_' . $sSuffix . 'server_id'] : (isset($aParams['user'][$sSuffix . 'server_id']) ? $aParams['user'][$sSuffix . 'server_id'] : '')) ;
			$aParams['file'] = $aParams['user'][$sSuffix . 'user_image'];
			$aParams['path'] = 'core.url_user';
			$aParams['title'] = ($bIsOnline ? Phpfox::getPhrase('core.full_name_is_online', array('full_name' => Phpfox::getLib('parse.output')->shorten($aParams['user'][$sSuffix . 'full_name'], Phpfox::getParam('user.maximum_length_for_full_name')))) : Phpfox::getLib('parse.output')->shorten($aParams['user'][$sSuffix . 'full_name'], Phpfox::getParam('user.maximum_length_for_full_name')));
			
			// Create the users link
			// $sLink = Phpfox::getLib('url')->makeUrl('profile', $aParams['user'][$sSuffix . 'user_name']);
			if(!empty($aParams['user']['profile_page_id']) && !empty($aParams['user']['page_id']))
			{
				if(empty($aParams['user']['user_name']))
				{
					$sLink = Phpfox::getLib('url')->makeUrl('pages', $aParams['user']['page_id']);
				}
			}
			else
			{
				$sLink = Phpfox::getLib('url')->makeUrl('profile', $aParams['user'][$sSuffix . 'user_name']);
			}			
			
			if (!empty($aParams['server_id']))
			{
				$bIsServer = true;	
			}
			
			if (Phpfox::getParam('user.prevent_profile_photo_cache') && isset($aParams['user'][$sSuffix . 'user_id']) && $aParams['user'][$sSuffix . 'user_id'] == Phpfox::getUserId())
			{
				$aParams['time_stamp'] = true;
			}			
		}		
		
		$bIsValid = true;
		if (!isset($aParams['theme']))
		{
			if (empty($aParams['file']))
			{			
				$iWidth = 80;			
				$iHeight = 70;
				if (isset($aParams['path']) && $aParams['path'] == 'core.url_user' && !isset($aParams['is_page_image']))
				{
					static $aGenders = null;
					
					if ($aGenders === null)
					{
						$aGenders = array();
						foreach ((array) Phpfox::getParam('core.global_genders') as $iKey => $aGender)
						{
							if (isset($aGender[3]))
							{
								$aGenders[$iKey] = $aGender[3];
							}
						}						
					}
					
					$sGender = '';				
					if (isset($aParams['user']) && isset($aParams['user'][$sSuffix . 'gender']))
					{					
						if (isset($aGenders[$aParams['user'][$sSuffix . 'gender']]))
						{
							$sGender = $aGenders[$aParams['user'][$sSuffix . 'gender']] . '_';	
						}
					}
					
					$sImageSuffix = '';
					if (!empty($aParams['suffix']))
					{
						$aParams['suffix'] = str_replace('_square', '', $aParams['suffix']); 				
						$iHeight = ltrim($aParams['suffix'], '_');
						$iWidth = ltrim($aParams['suffix'], '_');
						if ((int) $iWidth >= 200)
						{
							// $sSrc .= '_noimage';							
						}
						else 
						{
							$sImageSuffix = $aParams['suffix'];				
						}					
					}		
					
					$sSrc = Phpfox::getLib('template')->getStyle('image', 'noimage/' . $sGender . 'profile' . $sImageSuffix . '.png');	
				}
				else 
				{
					$sSrc = Phpfox::getLib('template')->getStyle('image', 'noimage/item.png');
				}
				
				$bIsValid = false;			
			}
			else 
			{
				$aParams['file'] = preg_replace('/%[^s]/', '%%', $aParams['file']);
				$sSrc = Phpfox::getParam($aParams['path']) . sprintf($aParams['file'], (isset($aParams['suffix']) ? $aParams['suffix'] : ''));
			}	
		}
		
		if (!defined('PHPFOX_INSTALLER') && !Phpfox::getParam('core.allow_cdn'))
		{
			$bIsServer = false;
		}		
		
		if ($bIsServer === false && !file_exists(str_replace(Phpfox::getParam('core.path'), PHPFOX_DIR, $sSrc)))
		{
			(($sPlugin = Phpfox_Plugin::get('image_helper_display_notfound')) ? eval($sPlugin) : false);
			
			if (preg_match("/\{file\/videos\/(.*)\/(.*)\.jpg\}/i", $sSrc, $aMatches))
			{
				$sSrc = Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]);
			}
			
			if ((preg_match('/file\/pic\/pages\/\[GROUP\](.*)/i', $sSrc, $aMatches) || preg_match('/file\/pic\/user\/\[GROUP\](.*)/i', $sSrc, $aMatches)) && isset($aMatches[1]))
			{
				$sSrc = Phpfox::getParam('core.path') . 'file/pic/group/' . $aMatches[1];
			}
			
			if (preg_match("/\{file\/pic\/(.*)\/(.*)\.jpg\}/i", $sSrc, $aMatches))
			{
				switch ($aMatches[1])
				{
					case 'album':
						$sSrc = Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]);
					break;					
					case 'groups/gallery':
						if (isset($aParams['max_width']))
						{
							if ($aParams['max_width'] >= 300)
							{
								if (file_exists(PHPFOX_DIR . 'file' . PHPFOX_DS . 'pic' . PHPFOX_DS . 'groups' . PHPFOX_DS . 'gallery' . PHPFOX_DS . str_replace(array('{', '}'), '', $aMatches[2]) . '_view.jpg'))
								{
									$sSrc = Phpfox::getParam('core.path') . 'file/pic/groups/gallery/' . str_replace(array('{', '}'), '', $aMatches[2]) . '_view.jpg';
								}
								else 
								{
									$sSrc = Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]);
								}								
							}
							elseif ($aParams['max_width'] <= 250)
							{
								$sSrc = Phpfox::getParam('core.path') . 'file/pic/groups/gallery/thumb/' . str_replace(array('{', '}'), '', $aMatches[2]) . '.jpg';							
							}								
						}
						else 
						{
							$sSrc = Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]);	
						}				
						break;
					case 'user':
						if (preg_match('/(.*)_(.*?)_square/i', $aMatches[2]))
						{
							$sSrc = Phpfox::getParam('core.path') . preg_replace('/(.*)_square/i', '\\1', str_replace(array('{', '}'), '', $aMatches[0]));
						}
						else 
						{
							if (isset($aParams['max_width']) && $aParams['max_width'] > 120)
							{							
								$sSrc = Phpfox::getParam('core.path') . 'file/pic/user/' . preg_replace('/(.*)_(.*)/i', '\\1_120', str_replace(array('{', '}'), '', $aMatches[2])) . '.jpg';							
							}
							else 
							{
								$sSrc = Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]);
							}
						}
						break;
					case 'gallery':
						if (isset($aParams['max_width']))
						{
							if ($aParams['max_width'] >= 300)
							{
								if (!empty($aParams['suffix']) && file_exists(PHPFOX_DIR . str_replace(array('{', '.jpg}'), array('', $aParams['suffix'] . '.jpg'), $aMatches[0])))
								{
									$sSrc = Phpfox::getParam('core.path') . str_replace(array('{', '.jpg}'), array('', $aParams['suffix'] . '.jpg'), $aMatches[0]);
								}								
								else 
								{
									if (file_exists(PHPFOX_DIR . 'file' . PHPFOX_DS . 'pic' . PHPFOX_DS . 'gallery' . PHPFOX_DS . str_replace(array('{', '}'), '', $aMatches[2]) . '_view.jpg'))
									{
										$sSrc = Phpfox::getParam('core.path') . 'file/pic/gallery/' . str_replace(array('{', '}'), '', $aMatches[2]) . '_view.jpg';
									}
									else 
									{
										$sSrc = Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]);		
									}								
								}
							}
							elseif ($aParams['max_width'] <= 250)
							{
								if (!empty($aParams['suffix']) && file_exists(PHPFOX_DIR . str_replace(array('{', '.jpg}'), array('', $aParams['suffix'] . '.jpg'), $aMatches[0])))
								{
									$sSrc = Phpfox::getParam('core.path') . str_replace(array('{', '.jpg}'), array('', $aParams['suffix'] . '.jpg'), $aMatches[0]);
								}								
								else 
								{
									if (file_exists(PHPFOX_DIR . 'file/pic/gallery/thumb/' . str_replace(array('{', '}'), '', $aMatches[2]) . '.jpg'))
									{
										$sSrc = Phpfox::getParam('core.path') . 'file/pic/gallery/thumb/' . str_replace(array('{', '}'), '', $aMatches[2]) . '.jpg';								
									}
									else 
									{	
										$sSrc = Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]);		
									}											
								}
							}								
						}
						else 
						{
							$sSrc = Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]);	
						}
						break;
					default:
						
						break;
				}	
			}

			$bForcePassImage = false;
			$sNewDirSrc = '';
			if (preg_match("/file\/pic\/photo\//i", $sSrc))
			{
				if (preg_match('/(.*)\[PHPFOX_CUSTOM_URL\](.*)\-(.*)\.(.*)/i', $sSrc, $aCustomMatches))
				{
					$sSrc = str_replace('[PHPFOX_CUSTOM_URL]', '', $sSrc);
					// http://www.phpfox.com/tracker/view/15350/
					if(Phpfox::getParam('photo.delete_original_after_resize'))
					{
						$aSizes = Phpfox::getParam('photo.photo_pic_sizes');
						$sSize = max($aSizes);
						$sNewDirSrc = Phpfox::getParam('photo.dir_photo') . $aCustomMatches[2] . '_' . $sSize . '.' . $aCustomMatches[4];
					}
					// Original code
					else
					{
						$sNewDirSrc = Phpfox::getParam('photo.dir_photo') . $aCustomMatches[2] . '.' . $aCustomMatches[4];
					}
					$bForcePassImage = true;
				}
				else 
				{
					preg_match("/^(.*?)_(75|100|150|240|500|1024)\.(.*?)$/i", $sSrc, $aMatches);				
					if (isset($aMatches[2]))
					{
						if (!in_array((int) $aMatches[2], Phpfox::getParam('photo.photo_pic_sizes')))
						{							
							$aUserPicSizes = Phpfox::getParam('photo.photo_pic_sizes');
									
							uasort($aUserPicSizes, array($this, '_cmp'));
									
							if (isset($aUserPicSizes[0]))
							{
								$sSrc = $aMatches[1] . '_' . $aUserPicSizes[0] . preg_replace("/([0-9])/i", "", $aMatches[2]) . '.' . $aMatches[3];						
							}
						}
					}
				}
			}
			
			if (preg_match('/\{([0-9]+)\}(.*)/i', $sSrc, $aCustomMatches))
			{
				$bForcePassImage = true;				
				$bIsServer = true;
				$sSrc = Phpfox::getService('video')->getCustomUrl($aCustomMatches[1]) . 'view/' . $aCustomMatches[2];
			}
			
			if (preg_match("/file\/pic\/user\//i", $sSrc))
			{
				preg_match("/^(.*)_(.*?)\.(.*?)$/i", $sSrc, $aMatches);
				
				if (isset($aMatches[2]))
				{
					if ($aMatches[2] == 'square')
					{
						$aSubParts = explode('_', $aMatches[1]);
						$aMatches[2] = $aSubParts[1];
					}
					
					if (!in_array((int) $aMatches[2], Phpfox::getParam('user.user_pic_sizes')))
					{							
						$aUserPicSizes = Phpfox::getParam('user.user_pic_sizes');
								
						uasort($aUserPicSizes, array($this, '_cmp'));
								
						if (isset($aUserPicSizes[0]))
						{
							$sSrc = $aMatches[1] . '_' . $aUserPicSizes[0] . preg_replace("/([0-9])/i", "", $aMatches[2]) . '.' . $aMatches[3];
						}						
					}
					else
					{						
						if (!file_exists(str_replace(Phpfox::getParam('core.path'), PHPFOX_DIR, $sSrc)))
						{
							$sSrc = $aMatches[1] . '.' . $aMatches[3];  
						}				
					}					
				}
			}
			else 
			{
				if (preg_match("/^(.*)_square\.(.*?)$/i", $sSrc, $aMatches))
				{
					$sNewSrc = $aMatches[1] . '.' . $aMatches[2];					
					if (file_exists(str_replace(Phpfox::getParam('core.path'), PHPFOX_DIR, $sNewSrc)))
					{
						$sSrc = $sNewSrc;
					}
				}
			}
		}		
		
		$sDirSrc = str_replace(Phpfox::getParam('core.path'), PHPFOX_DIR, $sSrc);
		if ($bIsServer === true)
		{
			if (Phpfox::getParam('core.allow_cdn'))
			{
				if (!$bIsValid)
				{				
					
				}
				else
				{				
					$sSrc = Phpfox::getLib('cdn')->getUrl($sSrc, $aParams['server_id']);
				}	
			}
			else 
			{
				if (substr($aParams['file'], 0, 7) == 'http://')
				{
					$sSrc = $aParams['file'];
				}
			}
		}	

		if (!defined('PHPFOX_INSTALLER') && Phpfox::isModule('photo') && Phpfox::getParam('photo.protect_photos_from_public') && preg_match("/photo/i", $sDirSrc))
		{
			$_SESSION[Phpfox::getTokenName()]['image']['photo_' . md5($sDirSrc)] = true;
		}

		if (isset($aParams['max_height']) && isset($aParams['max_width']))
		{
			if ($bIsServer === true)
			{
				if (file_exists($sDirSrc) && !is_dir($sDirSrc))
				{
					list($iHeight, $iWidth) = $this->getNewSize($sDirSrc, $aParams['max_height'], $aParams['max_width']);
				}
				else 
				{
					preg_match('/(.*)\/(.*)-(.*)-(.*)_(.*?)/i', $aParams['file'], $aLbMatches);
					if (isset($aLbMatches[2]) && isset($aLbMatches[3]))
					{
						list($iHeight, $iWidth) = $this->getNewSize(null, $aParams['max_height'], $aParams['max_width'], $aLbMatches[2], $aLbMatches[3]);
					}	
					else
					{
						$bNoWidthHeightFound = true;
					}				
				}										
			}
			else
			{
				if (isset($bForcePassImage) && $bForcePassImage === true)
				{
					$sDirSrc = $sNewDirSrc;
				}
				
				if (file_exists($sDirSrc) && !is_dir($sDirSrc))
				{			
					list($iHeight, $iWidth) = $this->getNewSize($sDirSrc, $aParams['max_height'], $aParams['max_width']);
				}
				else 
				{
					if (isset($aParams['no_default']) && $aParams['no_default'])
					{
						return '';
					}
					
					$iWidth = $aParams['max_width'];			
					$iHeight = $aParams['max_height'];
					if ($aParams['max_width'] > 120)
					{
						$iWidth = 120;			
						$iHeight = 105;
					}
					$sSize = '';							
					
					if (strpos($sSrc, '_') && preg_match("/^(.*?)_(.*?)\.(.*?)$/i", $sSrc, $aMatches) && isset($aMatches[2]) && in_array($aMatches[2], array(20, 50, 60, 75, 100, 120)))
					{
						$sSize = (($aMatches[1] == 'thumb' || $aMatches[1] == 'view') ? '' : '_' . $aMatches[2]);						
					}			
					
					if (isset($aParams['path']) && $aParams['path'] == 'core.url_user')
					{		
									
						if (Phpfox::getParam('user.cache_user_inner_joins') && !$bIsLoop && isset($sSuffix))
						{
							$aCachedUserInfo = Phpfox::getService('user')->getStaticInfo($aParams['user'][$sSuffix . 'user_id']);							
							if (!empty($aCachedUserInfo['user_image']))
							{					
								$aParams['user'][$sSuffix . 'user_image'] = $aCachedUserInfo['user_image'];
	
								return $this->display($aParams, true);
							}								
						}	
					
						$sSrc = Phpfox::getLib('template')->getStyle('image', 'noimage/' . (empty($sGender) ? '' : $sGender) . 'profile' . $sSize . '.png');
						preg_match("/^(.*?)_(.*?)\.(.*?)$/i", $sSrc, $aMatches);						
					}
					else 
					{	
						$sSrc = Phpfox::getLib('template')->getStyle('image', 'noimage/item.png');
					}
					
					if (!empty($sSize))
					{
						$sSrc = preg_replace("/(.*?)_square\.(.*?)/i", "\\1.\\2", $sSrc);
						
						$sNoImageSrc = str_replace(Phpfox::getParam('core.path'), PHPFOX_DIR, $sSrc);		
						
						list($iHeight, $iWidth) = $this->getNewSize($sNoImageSrc, $aParams['max_height'], $aParams['max_width']);
					}				
				}		
			}
			
			if (isset($aParams['href']))
			{
				$sLink = $aParams['href'];
				
				// Check if image is a thumbnail or a general view image
				if (strpos($sSrc, '_thumb') || strpos($sSrc, '_view'))			
				{				
					// Get the original image source
					if ($bIsServer)
					{				
						$sOrigSrc = preg_replace("/(_thumb|_view)/i", "", $sSrc);	
						$sLink = $sOrigSrc;					
					}
					else 
					{
						$sOrigSrc = str_replace(array(Phpfox::getParam('core.path'), '/'), array('', PHPFOX_DS), PHPFOX_DIR . ltrim(preg_replace("/(_thumb|_view)/i", "", $sSrc), '/'));	
					}				
	
					// Get the original image width/height
					list($iOrigWidth, $iOrigHeight) = getimagesize($sOrigSrc);
					
					// If the width/height is less then the max width/height then we should not display the thickbox feature
					if ($iOrigWidth < $aParams['max_width'] && $iOrigHeight < $aParams['max_height'])
					{
						unset($sLink);
					}
				}
			}			
		}
		
		// Use thickbox effect?
		if (isset($aParams['thickbox']))
		{
			// Remove the image suffix (eg _thumb.jpg, _view.jpg, _75.jpg etc...).
			if (preg_match('/female\_noimage\.png/i', $sSrc))
			{
				$sLink = $sSrc;	
			}
			elseif (preg_match('/^(.*)_(.*)_square\.(.*)$/i', $sSrc, $aMatches))
			{
				$sLink = $aMatches[1] . (isset($aParams['thickbox_suffix']) ? $aParams['thickbox_suffix'] : '') . '.' . $aMatches[3];	
			} 
			else 
			{
				$sLink = preg_replace("/^(.*)_(.*)\.(.*)$/i", "$1" . (isset($aParams['thickbox_suffix']) ? $aParams['thickbox_suffix'] : '') . ".$3", $sSrc);
			}			
		}		
		
		if (isset($aParams['no_link']) && $aParams['no_link'])
		{
			unset($sLink);
		}		
		
		// Windows slash fix
		$sSrc = str_replace("\\", '/', $sSrc);		
		if (preg_match("/file\/pic\/photo\//i", $sSrc))
		{
			if (Phpfox::getParam('core.defer_loading_images'))
			{
				$bDefer = true;
			}			
		}
		
		if (isset($aParams['return_url']) && $aParams['return_url'])
		{
			return $sSrc . (isset($aParams['time_stamp']) ? '?t=' . uniqid() : '');
		}

		if (isset($aParams['title']))
		{
			$aParams['title'] = Phpfox::getLib('parse.output')->clean(html_entity_decode($aParams['title'], null, 'UTF-8'));
		}
		/*
		if (Phpfox::getParam('core.allow_cdn') && preg_match('/s3\.amazonaws\.com/i', $sSrc))
		{
			$aParams['class'] = 'js_cdn_image' . (isset($aParams['class']) ? ' ' . $aParams['class'] : '') ;
		}
		*/		
		$sImage = '';
		$sAlt = '';
		if (isset($aParams['alt_phrase']))
		{
			$sAlt = html_entity_decode(Phpfox::getPhrase($aParams['alt_phrase']), null, 'UTF-8');
			unset($aParams['alt_phrase']);
		}
		
		if (isset($aParams['class']) && $aParams['class'] == 'js_hover_title')
		{
			$aParams['title'] = Phpfox::getLib('parse.output')->shorten($aParams['title'], 100, '...');
		}
		
		
		if (isset($sLink))
		{
			$sImage .= '<a href="' . $sLink;
			if (isset($aParams['thickbox']) && isset($aParams['time_stamp']))
			{
				$sImage .= '?t=' . uniqid();
			}
			$sImage .= '"';
			if (isset($aParams['title']))
			{
				$sImage .= ' title="' . htmlspecialchars($aParams['title']) . '"';
			}
			if (isset($aParams['thickbox']))
			{
				$sImage .= ' class="thickbox"';
			}
			if (isset($aParams['target']))
			{
				$sImage .= ' target="' . $aParams['target'] . '"';
			}
			$sImage .= '>';
		}

		if (PHPFOX_IS_AJAX)
		{
			$aAjaxCall = Phpfox::getLib('request')->get('core');
			if (isset($aAjaxCall['call']) && in_array($aAjaxCall['call'], array('core.loadDelayedBlocks')))
			{

			}
			else
			{
				$bDefer = false;
			}
		}
		
		$sImage .= '<img';
		if ($bDefer == true)
		{
			$aParams['class'] = ' image_deferred ' . (isset($aParams['class']) ? ' ' . $aParams['class'] : '');
			$sImage .= ' data-src="' . $sSrc . (isset($aParams['time_stamp']) ? '?t=' . uniqid() : '') . '" src="' . Phpfox::getLib('template')->getStyle('image', 'misc/defer_holder.gif') . '" ';
		}
		else
		{
			$sImage .= ' src="' . $sSrc . (isset($aParams['time_stamp']) ? '?t=' . uniqid() : '') . '" ';
		}
		if (isset($aParams['title']))
		{
			$sImage .= ' alt="' . htmlspecialchars($aParams['title']) . '" ';
		}
		else
		{
			$sImage .= ' alt="' . htmlspecialchars($sAlt) . '" ';
		}
		
		if(!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.display_user_online_status') && isset($aParams['user']))
		{
			$sImage .= ' title="' . htmlspecialchars($aParams['title']) . '"';
		}
		
		if (isset($aParams['js_hover_title']))
		{
			$sImage .= ' class="js_hover_title" ';
			unset($aParams['js_hover_title']);
		}
		
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.display_user_online_status') && isset($aParams['user']) && !isset($aParams['no_online_status']))
		{
			$sImage .= ' class="' . ($bIsOnline ? 'image_online_status' : 'image_online') . (isset($aParams['class']) ? ' ' . $aParams['class'] : '') . '" ';
			unset($aParams['class']);
		}
		
		if (isset($aParams['force_max']))
		{
			$iHeight = $aParams['max_height'];
			$iWidth = $aParams['max_width'];
		}
		
		if (!empty($iHeight))
		{
			$sImage .= 'height="' . $iHeight . '" ';
		}
		if (!empty($iWidth))
		{
			$sImage .= 'width="' . $iWidth . '" ';
		}
		
		if (isset($bNoWidthHeightFound))
		{
			$sImage .= ' style="max-width:' . $aParams['max_width'] . 'px;max-height:' . $aParams['max_height'] . 'px;' . (isset($aParams['style']) ? $aParams['style'] : '') . '" ';
		}
		
		if (isset($aParams['force_max']))
		{
			unset($aParams['force_max']);
		}
		
		unset($aParams['server_id'], 
			$aParams['src'], 
			$aParams['max_height'], 
			$aParams['max_width'], 
			$aParams['href'], 
			$aParams['user_name'], 
			$aParams['file'], 
			$aParams['suffix'], 
			$aParams['path'],
			$aParams['thickbox'],
			$aParams['no_default'],
			$aParams['full_name'],
			$aParams['user_id'],
			$aParams['time_stamp'],
			$aParams['user'],
			$aParams['title'],
			$aParams['theme'],
			$aParams['default'],
			$aParams['user_suffix'],
			$aParams['target'],
			$aParams['alt']
		);		
		
		foreach ($aParams as $sKey => $sValue)
		{
			$sImage .= ' '. $sKey . '="' . str_replace('"', '\"', $sValue) . '" ';
		}
		$sImage .= '/>' . (isset($sLink) ? '</a>' : '');		
		
		$aImages[$sHash] = $sImage;
		
		return $sImage;
	}
	
	/**
	 * Runs a check on two variables if they are equal, less then or greater then
	 *
	 * @param string $a Variable 1 to check against variable 2
	 * @param string $b Variable 2 to check against variable 1
	 * @return int Returns an INT based on the output
	 */
	private function _cmp($a, $b) 
	{
	    if ($a == $b) 
	    {
	        return 0;
	    }
	    return ($a < $b) ? -1 : 1;
	}	
}

?>
