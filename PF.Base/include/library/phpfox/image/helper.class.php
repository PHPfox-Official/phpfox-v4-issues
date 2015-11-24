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
	 * @return Phpfox_Image_Helper
	 */
	public static function instance() {
		return Phpfox::getLib('image.helper');
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
				return array(0, 0);
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
		$isObject = false;
				
		if (($sPlugin = Phpfox_Plugin::get('image_helper_display_start'))){eval($sPlugin);if (isset($mReturnPlugin)){return $mReturnPlugin;}}

		if (isset($aParams['theme']))
		{
			if (substr($aParams['theme'], 0, 5) == 'ajax/') {
				$type = str_replace(['ajax/', '.gif'], '', $aParams['theme']);
				// $image = '<span class="_ajax_image_' . $type . '"></span>';
				$image = '';
				switch ($type) {
					case 'large':
						$image = '<i class="fa fa-spin fa-circle-o-notch _ajax_image_' . $type . '"></i>';
						break;
				}

				return $image;
			}

			$sSrc = Phpfox_Template::instance()->getStyle('image', $aParams['theme']);

			return '<img src="' . $sSrc . '">';
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
		$sSuffix = '';
		if (isset($aParams['user']))
		{
			if (isset($aParams['user_suffix']))
			{
				$sSuffix = $aParams['user_suffix'];	
			}
			
			// Create the local params
			$aParams['server_id'] = (isset($aParams['user']['user_' . $sSuffix . 'server_id']) ? $aParams['user']['user_' . $sSuffix . 'server_id'] : (isset($aParams['user'][$sSuffix . 'server_id']) ? $aParams['user'][$sSuffix . 'server_id'] : '')) ;
			$aParams['file'] = $aParams['user'][$sSuffix . 'user_image'];
			$aParams['path'] = 'core.url_user';
			if (isset($aParams['user']['' . $sSuffix . 'is_user_page'])) {
				$aParams['path'] = 'pages.url_image';
				$aParams['suffix'] = '_120';
			}
			$aParams['title'] = ($bIsOnline ? Phpfox::getPhrase('core.full_name_is_online', array('full_name' => Phpfox::getLib('parse.output')->shorten($aParams['user'][$sSuffix . 'full_name'], Phpfox::getParam('user.maximum_length_for_full_name')))) : Phpfox::getLib('parse.output')->shorten($aParams['user'][$sSuffix . 'full_name'], Phpfox::getParam('user.maximum_length_for_full_name')));
			
			// Create the users link
			if(!empty($aParams['user']['profile_page_id']) && !empty($aParams['user']['page_id']))
			{
				if(empty($aParams['user']['user_name']))
				{
					$sLink = Phpfox_Url::instance()->makeUrl('pages', $aParams['user']['page_id']);
				}
			}
			else
			{
				$sLink = Phpfox_Url::instance()->makeUrl('profile', $aParams['user'][$sSuffix . 'user_name']);
			}
			
			if (Phpfox::getParam('user.prevent_profile_photo_cache')
				&& isset($aParams['user'][$sSuffix . 'user_id'])
				&& $aParams['user'][$sSuffix . 'user_id'] == Phpfox::getUserId())
			{
				$aParams['time_stamp'] = true;
			}

			if (Phpfox::getCookie('recache_image')
				&& isset($aParams['user'][$sSuffix . 'user_id'])
				&& $aParams['user'][$sSuffix . 'user_id'] == Phpfox::getUserId())
			{
				$aParams['time_stamp'] = true;
			}

			if (substr($aParams['file'], 0, 1) == '{') {
				$isObject = true;
				$aParams['org_file'] = $aParams['file'];
			}
		}		

		if (empty($aParams['file'])) {
				/*
				if (isset($aParams['return_url']) && $aParams['return_url']) {
					return '';
				}
				*/

				$iWidth = 80;			
				$iHeight = 70;
				if (isset($aParams['path'])
					&& ($aParams['path'] == 'core.url_user' || $aParams['path'] == 'pages.url_image')
					// && !isset($aParams['is_page_image'])
					// && isset($aParams['user'])
				)
				{
					static $aGenders = null;
					
					if ($aGenders === null)
					{
						$aGenders = array();
						foreach ((array) Phpfox::getParam('user.global_genders') as $iKey => $aGender)
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
					
					// $sSrc = Phpfox_Template::instance()->getStyle('image', 'noimage/' . $sGender . 'profile' . $sImageSuffix . '.png');
					$sImageSize = $sImageSuffix;
					// if (isset($aParams['user'])) {
					$name = (isset($aParams['user']) ? $aParams['user'][$sSuffix . 'full_name'] : (isset($aParams['title']) ? $aParams['title'] : ''));
					if (function_exists('iconv')) {
						setlocale(LC_ALL, 'en_US.UTF-8');
						$name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
					}

					$parts = explode(' ', $name);
          $name = trim($name);
					$first = 'P';
					$last = 'F';
						if (strlen($name) >= 2) {
              if (ctype_alnum($name[0])){
                $first = $name[0];
              }
              if (ctype_alnum($name[1])){
                $last = $name[1];
              }
							if (isset($parts[1])) {
                $lastChar = trim($parts[1]);
                if (!empty($lastChar)){
                  $last = $lastChar[0];
                }
							}
						} elseif(strlen($name) >= 1){
              if (ctype_alnum($name[0])){
                $first = $name[0];
                $last = $name[0];
              }
            }

						if (isset($aParams['max_width'])) {
							$sImageSize = '_' . $aParams['max_width'];
						}

						$ele = 'a';
						if (isset($aParams['no_link']) || !isset($sLink) || (isset($aParams['user']) && isset($aParams['user'][$sSuffix . 'no_link']))) {
							$ele = 'span';
						}

						$namekey  = preg_replace('/[^a-z]/m','p',strtolower($first.$last));

						$image = '<' . $ele . '' . ($ele == 'a' ? ' href="' . $sLink . '"' : '') . ' class="no_image_user _size_' . $sImageSize . ' _gender_' . $sGender . ' _first_' . $namekey . '"><span>' . $first . $last . '</span></' . $ele . '>';

						return $image;
					// }
				}
				else 
				{
					$ele = 'span';
					$sImageSize = '';
					if (isset($aParams['suffix'])) {
						$sImageSize = $aParams['suffix'];
					}
					if (isset($aParams['max_width'])) {
						$sImageSize = $aParams['max_width'];
					}
					$image = '<' . $ele . ' class="no_image_item i_size_' . $sImageSize . '"><span></span></' . $ele . '>';

					return $image;
				}
				
				$bIsValid = false;			
			}

		if (isset($aParams['no_link']) && $aParams['no_link'])
		{
			unset($sLink);
		}

		$aParams['file'] = preg_replace('/%[^s]/', '%%', $aParams['file']);
		$sSrc = Phpfox::getParam($aParams['path']) . sprintf($aParams['file'], (isset($aParams['suffix']) ? $aParams['suffix'] : ''));
		$sDirSrc = str_replace(Phpfox::getParam('core.path'), PHPFOX_DIR, $sSrc);

		if (isset($aParams['server_id']) && $aParams['server_id']) {
			$newPath = Phpfox_Cdn::instance()->getUrl($sSrc);
			if (!empty($newPath)) {
				$sSrc = $newPath;
			}
		}

		if (!file_exists($sDirSrc)) {
			$aParams['file'] = '';
		}
		
		// Windows slash fix
		$sSrc = str_replace("\\", '/', $sSrc);
		$sSrc = str_replace("\"", '\'', $sSrc);

		if (isset($aParams['return_url']) && $aParams['return_url'])
		{
			return $sSrc . (isset($aParams['time_stamp']) ? '?t=' . uniqid() : '');
		}

		if (isset($aParams['title']))
		{
			$aParams['title'] = Phpfox::getLib('parse.output')->clean(html_entity_decode($aParams['title'], null, 'UTF-8'));
		}

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

		$bDefer = true;
		$sImage .= '<img';
		if ($bDefer == true)
		{
			if ($isObject) {
				$object = json_decode($aParams['org_file'], true);
				$sSrc = array_values($object)[0];
				$sImage .= ' data-object="' . array_keys($object)[0] . '" ';
				// ob_clean(); d($sSrc); exit;
			}

			$size = (isset($aParams['suffix']) ? $aParams['suffix'] : '');
			if (isset($aParams['max_width'])) {
				$size = $aParams['max_width'];
			}

			$aParams['class'] = ' _image_' . $size . ' ' . ($isObject ? 'image_object' : 'image_deferred') . ' ' . (isset($aParams['class']) ? ' ' . $aParams['class'] : '');
			$sImage .= ' data-src="' . $sSrc . (isset($aParams['time_stamp']) ? '?t=' . uniqid() : '') . '" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" ';
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
		
		if (isset($aParams['js_hover_title']))
		{
			$sImage .= ' class="js_hover_title" ';
			unset($aParams['js_hover_title']);
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
		
		unset($aParams['server_id'],
			$aParams['force_max'],
			$aParams['org_file'],
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
