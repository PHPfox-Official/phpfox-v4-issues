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
 * @package 		Phpfox_Service
 * @version 		$Id: grab.class.php 7284 2014-04-25 13:02:09Z Fern $
 */
class Video_Service_Grab extends Phpfox_Service
{
	private $_aSites = array(
		'youtube' => 'YouTube',
		'myspace' => 'MySpace Video',
		// 'break' => 'Break',
		'metacafe' => 'Metacafe'
	);

	private $_aData = array(
		'site_id' => 0,
		'url' => '',
		'html' => '',
		'lines' => array()
	);
	
	private $_aRegex = array();

	private $_bHasImage = false;
	
	private $_aCustom = array();
	
	private $_aSiteCache = array();

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_aSiteCache = $this->_aSites;
		
		if (Phpfox::getParam('video.enabled_embedly_import'))
		{
			$sCacheId = $this->cache()->set('video_api_embed_ly');
			$sCacheId2 = $this->cache()->set('video_api_embed_ly_site');
			$aSites = array();		
			if ((!($this->_aRegex = $this->cache()->get($sCacheId)) || (!($aSites = $this->cache()->get($sCacheId2)))))
			{			
				$oOutput = json_decode(Phpfox::getLib('request')->send('http://api.embed.ly/1/services/php', array(), 'GET', $_SERVER['HTTP_USER_AGENT']));

				foreach ($oOutput as $aOutput)
				{
					if (!isset($aOutput->regex))
					{
						continue;
					}

					if ($aOutput->type != 'video')
					{
						continue;
					}

					if ($aOutput->displayname == 'National Geographic')
					{
						continue;
					}
					$aSites[] = preg_replace_callback('/&#(.{1,8});/i', 
						function($matches) 
						{
							return '&#' . hexdec($matches[0]) . ';';
						}, 
					$aOutput->displayname);

					foreach ($aOutput->regex as $sRegex)
					{
						$this->_aRegex[] = $sRegex;
					}
				}

				if (count($aSites))
				{
					$this->_aRegex[] = '#http://.*myspace.com/video/.*#i';
				}

				$this->cache()->save($sCacheId, $this->_aRegex);
				$this->cache()->save($sCacheId2, $aSites);
			}

			if (is_array($aSites) && count($aSites))
			{
				$this->_aSites = $aSites;
			}		
		}				
	}

	public function getSites($bIsArray = false)
	{		
		if ($bIsArray)
		{
			return $this->_aSites;
		}
		
		$aSites = array();
		foreach ($this->_aSites as $sSite => $sName)
		{
			$aSites[] = $sName;
		}

		return implode(', ', $aSites);
	}

	public function get($sUrl)
	{
		(($sPlugin = Phpfox_Plugin::get('video.service_grab_get_1')) ? eval($sPlugin) : false);
		$sUrl = trim($sUrl);
		
		if (substr($sUrl, 0, 7) == 'http://' || substr($sUrl, 0, 8) == 'https://')
		{		
			if (strpos($sUrl, 'youtube') || (preg_match('/http:\/\/youtu\.be\/(.*)/i', $sUrl, $aMatches) && isset($aMatches[1])))
			{
				$this->_aRegex = false;
				$this->_aSites = $this->_aSiteCache;
				if (isset($aMatches) && $aMatches[1])
				{
					$sUrl = 'http://www.youtube.com/watch?v=' . $aMatches[1];
				}				
			}
			
			// http://www.phpfox.com/tracker/view/15289/
			if (strpos($sUrl, 'ted.com') && !preg_match('/\.html/i', $sUrl))
			{
				$sUrl .= '.html';
			}
			
			if (is_array($this->_aRegex) && count($this->_aRegex))
			{
				foreach ($this->_aRegex as $sSiteRegex)
				{
					if (preg_match($sSiteRegex, $sUrl))
					{
						$this->_aData['url'] = $sUrl;
						
						if ($this->parse($sUrl))
						{
							return true;
						}						
					}
				}
				
				return Phpfox_Error::set(Phpfox::getPhrase('video.not_a_valid_video_site_url'));
			}
			else 
			{
				$aSites = array();

				foreach ($this->_aSites as $sSite => $sName)
				{
					if (strpos($sUrl, $sSite))
					{
						$this->_aData['url'] = $sUrl;
						$this->_aData['site_id'] = $sSite;
					}
		
					$aSites[] = $sName;
				}
		
				if (!$this->_aData['site_id'])
				{
					// 'Not a valid site. Valid sites: ' . implode(', ', $aSites)
					return Phpfox_Error::set(Phpfox::getPhrase('video.not_a_valid_site_valid_sites_asites', array('aSites' => implode(', ', $aSites))));
				}
			}
	
			return true;
		}
		
		(($sPlugin = Phpfox_Plugin::get('video.service_grab_get_2')) ? eval($sPlugin) : false);
		
		return Phpfox_Error::set(Phpfox::getPhrase('video.please_provide_a_valid_url_for_your_video'));
	}

	public function parse()
	{
		static $bSent = false;
		
		// Plugin call
		if ($sPlugin = Phpfox_Plugin::get('video.service_grab_parse__start'))
		{
			eval($sPlugin);
		}

		if ($bSent === false)
		{
			$bSent = true;
			
			if (is_array($this->_aRegex) && count($this->_aRegex))
			{
				$sKey = '';
				if (Phpfox::getParam('video.embedly_api_key') != '')
				{
					$sKey = 'key=' . Phpfox::getParam('video.embedly_api_key') . '&';
				}
				
				$oVideo = json_decode(Phpfox::getLib('request')->send('http://api.embed.ly/1/oembed?' . $sKey . 'format=json&maxwidth=400&url=' . urlencode($this->_aData['url']), array(), 'GET', $_SERVER['HTTP_USER_AGENT']));
				
				// http://www.phpfox.com/tracker/view/15256/
				if(!isset($oVideo->thumbnail_url))
				{
					if(preg_match('/facebook/i', $this->_aData['url']))
					{
						$aRegexes = array(
							'/https?:\/\/www\.facebook\.com\/v\/([0-9]+)/i', // Flash Embed
							'/https?:\/\/www\.facebook\.com\/.*\?v=([0-9]+)/i', // New Flash Embed
							'/https?:\/\/www\.facebook\.com\/video\/embed\?video_id=([0-9]+)/i' // iFrame Embed
						);
						
						foreach($aRegexes as $sRegex)
						{
							if (preg_match($sRegex, $this->_aData['url'], $aMatches)) 
							{
								$iId = $aMatches[1];
							}
						}
						
						$oThumbnail = json_decode(Phpfox::getLib('request')->send('https://graph.facebook.com/' . $iId . '/picture?redirect=false', array(), 'GET', $_SERVER['HTTP_USER_AGENT']));
						$oVideo->thumbnail_url = $oThumbnail->data->url;
						$oVideo->type = 'video';
						$oVideo->html = '<iframe src="https://www.facebook.com/video/embed?video_id=' . $iId . '" width="560" height="430" frameborder="0"></iframe>';
					}
				}
				// END
				
				if (isset($oVideo->provider_url))
				{				
					$this->_aCustom = array(
						'link' => $this->_aData['url'],
						'title' => strip_tags($oVideo->title),
						'description' => strip_tags($oVideo->description),
						'default_image' => $oVideo->thumbnail_url,
						'embed_code' => ($oVideo->type == 'video' ? $oVideo->html : '')
					);	
				}
				else 
				{
					return false;
				}
			}
			else 
			{
				switch($this->_aData['site_id'])
				{
					case 'youtube':
						$aUrl = parse_url($this->_aData['url']);
						if (!isset($aUrl['query']) && isset($aUrl['path']))
						{
							$aFix = explode('/',$aUrl['path']);
							$aUrl['query'] = 'v=' . $aFix[2];
	
						}
						parse_str($aUrl['query'], $aStr);
						$xVideo = Phpfox::getLib('request')->send('http://gdata.youtube.com/feeds/api/videos/' . $aStr['v'], array(), 'GET');
						if ($xVideo == 'Video not found' || $xVideo == 'Private video')
						{
							return false;
						}
						$this->_aData['html'] = Phpfox::getLib('xml.parser')->parse($xVideo, 'UTF-8');
						if (isset($this->_aData['html']['yt:noembed']))
						{					
							return false;
						}					
						break;
					case 'myspace':
					case 'break':
					case 'metacafe':
						// metacafe video pages need the trailing slash to be fetched
						if (strrpos($this->_aData['url'], '/') != strlen($this->_aData['url']))
						{
							$this->_aData['url'] .= '/';
						}
						$this->_aData['html'] = Phpfox::getLib('request')->send($this->_aData['url'], array(), 'GET');
						break;
					default:
	
						break;
				}
			}
		}
		
		if ($sPlugin = Phpfox_Plugin::get('video.service_grab_parse__end'))
		{
			eval($sPlugin);
		}
		
		return $this;
	}

	public function title()
	{
		if ($sPlugin = Phpfox_Plugin::get('video.service_grab_title_1'))
		{
			eval($sPlugin);
		}
		if (isset($this->_aCustom['title']))
		{
			return $this->_aCustom['title'];
		}
		
		$this->parse();

		switch($this->_aData['site_id'])
		{
			// YouTube
			case 'youtube':
				if (isset($this->_aData['html']['media:group']['media:title']['value']))
				{
					$sTitle = $this->_aData['html']['media:group']['media:title']['value'];
				}
				break;
			case 'myspace':
				preg_match('/<meta property="og:title" content="(.*?)" \/>/i', $this->_aData['html'], $aMatches);
				if (isset($aMatches[1]))
				{
					$sTitle = trim($aMatches[1]);
				}
				break;
			case 'break':
				// fixes importing video title
				if (preg_match('/<meta name=["|\']embed_video_title["|\'] id=["|\']vid_title["|\'] content=["|\'](.*?)["|\']>/i', $this->_aData['html'], $aMatches))
				{
					$sTitle = trim($aMatches[1]);
				}
				break;
			case 'metacafe':
				preg_match('/<title>(.*?)<\/title>/is', $this->_aData['html'], $aMatches);
				if (isset($aMatches[1]))
				{
					$sTitle = str_replace('- Video', '', trim($aMatches[1]));
				}
				break;
			default:

				break;
		}
		if ($sPlugin = Phpfox_Plugin::get('video.service_grab_title_3'))
		{
			eval($sPlugin);
		}
		
		if (!isset($sTitle))
		{
			if ($sPlugin = Phpfox_Plugin::get('video.service_grab_title_4'))
			{
				eval($sPlugin);
			}
			return false;
		}
		
		if ($sPlugin = Phpfox_Plugin::get('video.service_grab_title_2'))
		{
			eval($sPlugin);
		}
		return $sTitle;
	}

	public function image($iId, $bExist = false, $sFilename = '')
	{
		(($sPlugin = Phpfox_Plugin::get('video.service_grab_image_1')) ? eval($sPlugin) : false);
		if (isset($this->_aCustom['default_image']))
		{		
			$sImage = $this->_aCustom['default_image'];
		}
		else 
		{		
			switch($this->_aData['site_id'])
			{
				// YouTube
				case 'youtube':
					$aUrl = parse_url($this->_aData['url']);
					if (!isset($aUrl['query']) && isset($aUrl['path']))
					{
						$aFix = explode('/',$aUrl['path']);
						$aUrl['query'] = 'v=' . $aFix[2];
					}
					parse_str($aUrl['query'], $aStr);
					$sImage = (Phpfox::getParam('core.force_https_secure_pages') == true && Phpfox::getParam('core.force_secure_site') == true)? 'https://' : 'http://';
					$sImage .= 'img.youtube.com/vi/' . $aStr['v'] . '/default.jpg';
					break;
				case 'myspace':
					preg_match('/<meta property="og:image" content="(.*?)" \/>/i', $this->_aData['html'], $aMatches);
					if (isset($aMatches[1]))
					{
						$sImage = trim($aMatches[1]);
					}
					break;
				case 'break':
					// Fixes fetching the thumbnail
					if (preg_match('/<meta name=["|\']embed_video_thumb_url["|\'] content=["|\'](.*?)["|\']>/i', $this->_aData['html'], $aMatches))
					{
						$sImage = trim($aMatches[1]);
					}
					break;
				case 'metacafe':
					preg_match('/<link rel="image_src" href="(.*?)" \/>/i', $this->_aData['html'], $aMatches);
					if (isset($aMatches[1]))
					{
						$sImage = trim($aMatches[1]);
					}
					break;
				default:
	
					break;
			}
		}

		if (isset($sImage))
		{
			if($bExist)
			{
				$sImageLocation = $sFilename;
			}
			else
			{
				$sImageLocation = Phpfox::getLib('file')->getBuiltDir(Phpfox::getParam('video.dir_image')) . md5($iId) . '%s.jpg';
			}

			//@copy($sImage, sprintf($sImageLocation, '_120'));
			$oImage = Phpfox::getLib('request')->send($sImage, array(), 'GET');
			$sTempImage = 'video_temporal_image_'.$iId;
			Phpfox::getLib('file')->writeToCache($sTempImage, $oImage);
			@copy(PHPFOX_DIR_CACHE . $sTempImage, sprintf($sImageLocation, '_120'));
			unlink(PHPFOX_DIR_CACHE . $sTempImage);

			$this->_bHasImage = true;
			
			if (Phpfox::getParam('core.allow_cdn'))
			{
				Phpfox::getLib('cdn')->put(sprintf($sImageLocation, '_120'));
			}			
			
			(($sPlugin = Phpfox_Plugin::get('video.service_grab_image_3')) ? eval($sPlugin) : false);
			return true;
		}
		(($sPlugin = Phpfox_Plugin::get('video.service_grab_image_2')) ? eval($sPlugin) : false);
		return false;
	}

	public function description()
	{
		if (isset($this->_aCustom['description']))
		{
			return $this->_aCustom['description'];
		}		
		
		$this->parse();

		switch($this->_aData['site_id'])
		{
			// YouTube
			case 'youtube':
				if (isset($this->_aData['html']['media:group']['media:description']['value']))
				{
					$sDescription = $this->_aData['html']['media:group']['media:description']['value'];
				}
				break;
			case 'myspace':
				preg_match('/<b id="tv_vid_vd_fulldesc_text">(.*?)<\/b>/is', $this->_aData['html'], $aMatches);
				if (isset($aMatches[1]))
				{
					$sDescription = Phpfox::getLib('parse.format')->unhtmlspecialchars(trim($aMatches[1]));
				}
				break;
			case 'break':
				if (preg_match('/<meta name="embed_video_description" id="vid_desc" content="(.*?)" \/>/i', $this->_aData['html'], $aMatches))
				{
					$sDescription = Phpfox::getLib('parse.format')->unhtmlspecialchars(trim($aMatches[1]));
				}
				break;
			case 'metacafe':
				if (preg_match('/<meta name="description" content="(.*?)" \/>/i', $this->_aData['html'], $aMatches))
				{
					$sDescription = Phpfox::getLib('parse.format')->unhtmlspecialchars(trim($aMatches[1]));
				}
				break;
			default:

				break;
		}

		if (!isset($sDescription))
		{
			return false;
		}

		return $sDescription;
	}

	public function duration()
	{
		if (isset($this->_aCustom['description']))
		{
			return false;
		}
		
		$this->parse();

		switch($this->_aData['site_id'])
		{
			// YouTube
			case 'youtube':
				if (isset($this->_aData['html']['media:group']['yt:duration']['seconds']))
				{
					$sSeconds = $this->_aData['html']['media:group']['yt:duration']['seconds'];
					$iMins = floor($sSeconds / 60);
					$iSecs = $sSeconds % 60;
					$sDuration = $iMins . ':' . (($iSecs < 10) ? '0' : '') . $iSecs;
				}
				break;
			default:

				break;
		}

		if (!isset($sDuration))
		{
			return false;
		}

		return $sDuration;
	}

	public function embed()
	{		
		(($sPlugin = Phpfox_Plugin::get('video.service_grab_embed_1')) ? eval($sPlugin) : false);
		
		if (isset($this->_aCustom['embed_code']))
		{
			return $this->_aCustom['embed_code'];
		}		
		
		if ($this->parse() == false)
		{
			return false;
		}

		switch($this->_aData['site_id'])
		{
			// YouTube
			case 'youtube':
					$aUrl = parse_url($this->_aData['url']);
					if (!isset($aUrl['query']) && isset($aUrl['path']))
					{
						$aFix = explode('/',$aUrl['path']);
						$aUrl['query'] = 'v=' . $aFix[2];
					}
					parse_str($aUrl['query'], $aStr);
					$sEmbed = '<object width="425" height="344"><param name="wmode" value="transparent"></param><param name="movie" value="http://www.youtube.com/v/' . $aStr['v'] . (Phpfox::getParam('video.embed_auto_play') ? '&amp;autoplay=1' : '') . (Phpfox::getParam('video.full_screen_with_youtube') ? '&amp;fs=1' : '') . (Phpfox::getParam('video.disable_youtube_related_videos') ? '&amp;rel=0' : '') . '"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed wmode="transparent" src="http://www.youtube.com/v/' . $aStr['v'] . (Phpfox::getParam('video.embed_auto_play') ? '&amp;autoplay=1' : '') . (Phpfox::getParam('video.full_screen_with_youtube') ? '&amp;fs=1' : '') . (Phpfox::getParam('video.disable_youtube_related_videos') ? '&amp;rel=0' : '') . '" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>';
				break;
			case 'myspace':
				if (preg_match('/id="mainVideoPlayer"/i', $this->_aData['html']))
				{
					$this->_aData['lines'] = explode("\n", $this->_aData['html']);
					foreach ($this->_aData['lines'] as $sLine)
					{
						if (preg_match('/id="msVideoPlayer"/i', $sLine))
						{
			                if (isset($sLine))
							{
								$aParts = explode('<object', Phpfox::getLib('parse.format')->unhtmlspecialchars($sLine));
								if (isset($aParts[1]))
								{
									$sEmbed = '<object' . $aParts[1];
								}
							}
							break;
						}
					}
				}
				break;
			case 'break':
		        $mediaSearch = preg_match('/http:\/\/[www\.]?embed.break.com\/[0-9]*/i', $this->_aData['html'], $aMatches);
				//return '<embed src="'.$aMatches[0].'" width="'.Phpfox::getParam('video.player_width').'" height="'.Phpfox::getParam('video.player_height').'"></embed>';
				return '<embed src="'.$aMatches[0].'"></embed>';
				

				/*
				if (preg_match('/name="EmbedTextBox"/i', $this->_aData['html']))
				{
					$this->_aData['lines'] = explode("\n", $this->_aData['html']);
					foreach ($this->_aData['lines'] as $sLine)
					{
						if (preg_match('/name="EmbedTextBox"/i', $sLine))
						{
							preg_match('/value="&lt;object(.*?)"/i', $sLine, $aMatches);
							$aParts = explode('</object>', Phpfox::getLib('parse.format')->unhtmlspecialchars($aMatches[1]));
							if (isset($aParts[0]))
							{
								$sEmbed = '<object' . $aParts[0] . '<param name="wmode" value="transparent"></param></object>';
							}
							$aEmbed = explode('<embed ', $sEmbed);
							$sEmbed = $aEmbed[0] . '<embed wmode="transparent" ' . $aEmbed[1];
							break;
						}
					}
				}*/
				break;
			case 'metacafe':
				// get the list of swfs
				preg_match_all('/http:\/\/(.*swf)/i', $this->_aData['html'], $aMatches);
				// get the last word from the URL
				$bVidName = preg_match('/\/[0-9]+\/(.*[^\/])/', $this->_aData['url'], $aVidName);
				if (!$bVidName)
				{
					return Phpfox_Error::display('Could not identify video name.');
				}
				foreach ($aMatches[0] as $sMatch)
				{
					// find the video
					if (strpos($sMatch, $aVidName[1]) !== false)
					{
						/* First way of fixing it */
						/** @TODO need to add 2 settings to control the height */
						//$sEmbed = '<embed flashVars="playerVars=showStats=no|autoPlay='.(Phpfox::getParam('video.embed_auto_play') ? 'yes' : 'no').'" src="'.$sMatch.'" width="'.Phpfox::getParam('video.player_width').'" height="'.Phpfox::getParam('video.player_height').'" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"> </embed>';
						$sEmbed = '<embed class="metacafe_video_player" flashVars="playerVars=showStats=no|autoPlay=' . (Phpfox::getParam('video.embed_auto_play') ? 'yes' : 'no') . '" src="' . $sMatch . '" width="400" height="348" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"> </embed>';
						/* Second way to fix it */
						//$sEmbed = '<iframe class="sEmbed" width="400" height="300"	src="'.$sMatch.'" /></iframe>';
						
						return $sEmbed;
						break;
					}
				}
				// left here as a plan B
				if (preg_match('/name="embedCode"/i', $this->_aData['html']))
				{
					$this->_aData['lines'] = explode("\n", $this->_aData['html']);
					foreach ($this->_aData['lines'] as $sLine)
					{
						if (preg_match('/name="embedCode"/i', $sLine))
						{
							preg_match('/value="(.*?)"/i', $sLine, $aMatches);
							if (isset($aMatches[1]))
							{
								$aParts = explode('</embed>', Phpfox::getLib('parse.format')->unhtmlspecialchars($aMatches[1]));
								if (isset($aParts[0]))
								{
									$sEmbed = $aParts[0] . '</embed>';
								}
							}
							break;
						}
					}
				}
				break;
			default:

				break;
		}

		if (!isset($sEmbed))
		{
			return false;
		}

		(($sPlugin = Phpfox_Plugin::get('video.service_grab_embed_2')) ? eval($sPlugin) : false);
		return $sEmbed;
	}

	public function hasImage()
	{
		return $this->_bHasImage;
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
		if ($sPlugin = Phpfox_Plugin::get('video.service_grab__call'))
		{
			return eval($sPlugin);
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
}

?>
