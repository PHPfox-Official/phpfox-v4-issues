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
 * @version 		$Id: link.class.php 7240 2014-03-31 15:22:15Z Fern $
 */
class Link_Service_Link extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('link');	
	}
	
	public function getLink($sUrl)
	{
		if (substr($sUrl, 0, 7) != 'http://' && substr($sUrl, 0, 8) != 'https://')
		{
			$sUrl = 'http://' . $sUrl;
		}
			
		$aParts = parse_url($sUrl);	
				
		if (!isset($aParts['host']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('link.not_a_valid_link'));
		}
				
		$aReturn = array();		
		$oVideo = json_decode(Phpfox_Request::instance()->send('http://api.embed.ly/1/oembed?format=json&maxwidth=400&url=' . urlencode($sUrl), array(), 'GET', $_SERVER['HTTP_USER_AGENT']));

		// http://www.phpfox.com/tracker/view/15305/
		if(!isset($oVideo->thumbnail_url))
		{
			if(preg_match('/facebook/i', $sUrl))
			{
				$aRegexes = array(
					'/https?:\/\/www\.facebook\.com\/v\/([0-9]+)/i', // Flash Embed
					'/https?:\/\/www\.facebook\.com\/.*\?v=([0-9]+)/i', // New Flash Embed
					'/https?:\/\/www\.facebook\.com\/video\/embed\?video_id=([0-9]+)/i' // iFrame Embed
				);
				
				foreach($aRegexes as $sRegex)
				{
					if (preg_match($sRegex, $sUrl, $aMatches)) 
					{
						$iId = $aMatches[1];
					}
				}
				
				$oThumbnail = json_decode(Phpfox_Request::instance()->send('https://graph.facebook.com/' . $iId . '/picture?redirect=false', array(), 'GET', $_SERVER['HTTP_USER_AGENT']));
				$oVideo->thumbnail_url = $oThumbnail->data->url;
				$oVideo->type = 'video';
				$oVideo->html = '<iframe src="https://www.facebook.com/video/embed?video_id=' . $iId . '" width="400" height="300" frameborder="0"></iframe>';
			}
		}
		// END

		// http://embed.ly/docs/embed/api/endpoints/1/oembed => object->photo does not exist as response
		if (isset($oVideo->provider_url) || (isset($oVideo->photo)))
		{
			$aReturn = array(
				'link' => $sUrl,
				'title' => (isset($oVideo->title) ? strip_tags($oVideo->title) : ''),
				'description' => (isset($oVideo->description) ? strip_tags($oVideo->description) : ''),
				'default_image' => ($oVideo->type == 'photo' ? $oVideo->url : (isset($oVideo->thumbnail_url) ? $oVideo->thumbnail_url : '')),
				'embed_code' => ($oVideo->type == 'video' ? $oVideo->html : '')
			);
					
			return $aReturn;
		}	
		
		$aParseBuild = array();
		$sContent = Phpfox_Request::instance()->send($sUrl, array(), 'GET', $_SERVER['HTTP_USER_AGENT']);
		preg_match_all('/<(meta|link)(.*?)>/i', $sContent, $aRegMatches);		
		if (isset($aRegMatches[2]))
		{
			foreach ($aRegMatches as $iKey => $aMatch)
			{
				if ($iKey !== 2)
				{
					continue;
				}				
				
				foreach ($aMatch as $sLine)
				{
					$sLine = rtrim($sLine, '/');
					$sLine = trim($sLine);
					
					preg_match('/(property|name|rel)=("|\')(.*?)("|\')/ise', $sLine, $aType);
					if (count($aType) && isset($aType[3]))
					{
						$sType = $aType[3];
						preg_match('/(content|type)=("|\')(.*?)("|\')/i', $sLine, $aValue);
						if (count($aValue) && isset($aValue[3]))
						{						
							if ($sType == 'alternate')
							{
								$sType = $aValue[3];
								preg_match('/href=("|\')(.*?)("|\')/i', $sLine, $aHref);
								if (isset($aHref[2]))
								{
									$aValue[3] = $aHref[2];
								}
							}
							$aParseBuild[$sType] = $aValue[3];
						}
					}
				}
			}
			
			if (isset($aParseBuild['og:title']))
			{
				$aReturn['link'] = $sUrl;
				$aReturn['title'] = $aParseBuild['og:title'];
				$aReturn['description'] = (isset($aParseBuild['og:description']) ? $aParseBuild['og:description'] : '');
				$aReturn['default_image'] = (isset($aParseBuild['og:image']) ? $aParseBuild['og:image'] : '');
				if (isset($aParseBuild['application/json+oembed']))
				{
					$oJson = json_decode(Phpfox_Request::instance()->send($aParseBuild['application/json+oembed'], array(), 'GET', $_SERVER['HTTP_USER_AGENT']));					if (isset($oJson->html))
					{
						$aReturn['embed_code'] = $oJson->html;	
					}
				}

				return $aReturn;
			}
		}		
		
		
		$sContent = Phpfox_Request::instance()->send($sUrl, array(), 'GET', $_SERVER['HTTP_USER_AGENT'], null, true);
		
		if( function_exists('mb_convert_encoding') )
      	{
      		$sContent = mb_convert_encoding($sContent, 'HTML-ENTITIES', "UTF-8");
      	}		
      	      	
      	$aReturn['link'] = $sUrl;
		
		Phpfox_Error::skip(true);
		$oDoc = new DOMDocument();
		$oDoc->loadHTML($sContent);
		Phpfox_Error::skip(false);
		
		if (($oTitle = $oDoc->getElementsByTagName('title')->item(0)) && !empty($oTitle->nodeValue))
		{
			$aReturn['title'] = strip_tags($oTitle->nodeValue);
		}
		
		if (empty($aReturn['title']))
		{
			if (preg_match('/^(.*?)\.(jpg|png|jpeg|gif)$/i', $sUrl, $aImageMatches))
			{
				return array(
					'link' => $sUrl,
					'title' => '',
					'description' => '',
					'default_image' => $sUrl,
					'embed_code' => ''
				);
			}

			return Phpfox_Error::set(Phpfox::getPhrase('link.not_a_valid_link_unable_to_find_a_title'));
		}
		
		$oXpath = new DOMXPath($oDoc);	
		$oMeta = $oXpath->query("//meta[@name='description']")->item(0);
		if (method_exists($oMeta, 'getAttribute'))
		{
			$sMeta = $oMeta->getAttribute('content');
			if (!empty($sMeta))
			{
				$aReturn['description'] = strip_tags($sMeta);
			}
		}
		
		$aImages = array();		
		$oMeta = $oXpath->query("//meta[@property='og:image']")->item(0);
		if (method_exists($oMeta, 'getAttribute'))
		{			
			$aReturn['default_image'] = strip_tags($oMeta->getAttribute('content'));
			$aImages[] = strip_tags($oMeta->getAttribute('content'));
		}		
		
		$oMeta = $oXpath->query("//link[@rel='image_src']")->item(0);
		if (method_exists($oMeta, 'getAttribute'))
		{			
			if (empty($aReturn['default_image']))
			{
				$aReturn['default_image'] = strip_tags($oMeta->getAttribute('href'));
			}
			$aImages[] = strip_tags($oMeta->getAttribute('href'));
		}			
		
		if (!isset($aReturn['default_image']))
		{
			$oMeta = $oXpath->query("//meta[@itemprop='image']")->item(0);
			if (method_exists($oMeta, 'getAttribute'))
			{
				$aReturn['default_image'] = strip_tags($oMeta->getAttribute('content'));
				if (strpos($aReturn['default_image'], $sUrl) === false)
				{
					$aReturn['default_image'] = $sUrl . '/' . $aReturn['default_image'];
				}
			}			
		}
		
		
		if (!isset($aReturn['default_image']))
		{						
			$oImages = $oDoc->getElementsByTagName('img');
			$iIteration = 0;
			foreach ($oImages as $oImage)
			{
				$sImageSrc = $oImage->getAttribute('src');
				
				if (substr($sImageSrc, 0, 7) != 'http://' && substr($sImageSrc, 0, 1) != '/')
				{
					continue;	
				}
				
				if (substr($sImageSrc, 0, 2) == '//')
				{
					continue;
				}
				
				$iIteration++;		
				
				if (substr($sImageSrc, 0, 1) == '/')
				{					
					$sImageSrc = 'http://' . $aParts['host'] . $sImageSrc;
				}			
				
				if ($iIteration === 1 && empty($aReturn['default_image']))
				{
					$aReturn['default_image'] = strip_tags($sImageSrc);
				}
				
				if ($iIteration > 10)
				{
					break;
				}
				
				$aImages[] = strip_tags($sImageSrc);
			}
		}
		
		if (count($aImages))
		{
			$aReturn['images'] = $aImages;
		}
		
		$oLink = $oXpath->query("//link[@type='text/xml+oembed']")->item(0);
		if (method_exists($oLink, 'getAttribute'))
		{	
			$aXml = Phpfox::getLib('xml.parser')->parse(Phpfox_Request::instance()->send($oLink->getAttribute('href'), array(), 'GET', $_SERVER['HTTP_USER_AGENT']));
			if (isset($aXml['html']))
			{
				$aReturn['embed_code'] = $aXml['html'];	
			}
		}				
		
		return $aReturn;
	}
	
	/**
	 * Takes into account redirects.
	 */
	public function getHTML($sUrl)
	{
		$iMaxCount = 2;
		$sContent = '';
		while( ($iMaxCount--) > 0)
		{
			$sContent = Phpfox_Request::instance()->send($sUrl, array(), 'GET', $_SERVER['HTTP_USER_AGENT'], null, true);
			$sHeaders = substr($sContent, 0, strpos($sContent, '<'));
			// if (strpos($sHeaders, 'Moved') !== false && 
			d($sHeaders);
			//d($sContent, true);
			die();
		}
	}
	
	public function getEmbedCode($iId, $bIsPopUp = false)
	{
		$aLinkEmbed = $this->database()->select('embed_code')	
			->from(Phpfox::getT('link_embed'))
			->where('link_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		$iWidth = 640;
		$iHeight = 390;
		if (!$bIsPopUp)
		{
			$iWidth = 480;
			$iHeight = 295;
		}
		
		$aLinkEmbed['embed_code'] = preg_replace('/width=\"(.*?)\"/i', 'width="' . $iWidth . '"', $aLinkEmbed['embed_code']);
		$aLinkEmbed['embed_code'] = preg_replace('/height=\"(.*?)\"/i', 'height="' . $iHeight . '"', $aLinkEmbed['embed_code']);		
		$aLinkEmbed['embed_code'] = preg_replace_callback('/<object(.*?)>(.*?)<\/object>/is', array($this, '_embedWmode'), $aLinkEmbed['embed_code']);
		$aLinkEmbed['embed_code'] = str_replace(array('&lt;', '&gt;'), array('<', '>'), $aLinkEmbed['embed_code']);
		if (Phpfox::isModule('video') && Phpfox::getParam('video.disable_youtube_related_videos'))
		{
			 if (preg_match('/src=(["\'])(.*?)\1/', $aLinkEmbed['embed_code'], $aMatch) > 0)
			 {
				$aLinkEmbed['embed_code'] = str_replace($aMatch[2], $aMatch[2] . '&amp;rel=0', $aLinkEmbed['embed_code']);
			 }
		}
		
		// http://www.phpfox.com/tracker/view/14676/
		if(Phpfox::getParam('core.force_https_secure_pages') && Phpfox::getParam('core.force_secure_site'))
		{
			$aLinkEmbed['embed_code'] = str_replace('http://', 'https://', $aLinkEmbed['embed_code']);
		}
		
		return $aLinkEmbed['embed_code'];
	}
	
	public function getLinkById($iId)
	{
		$aLink = $this->database()->select('l.*, u.user_name')
			->from(Phpfox::getT('link'), 'l')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = l.user_id')
			->where('l.link_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		if (!isset($aLink['link_id']))
		{
			return false;
		}
		
		return $aLink;
	}
	
	/* Havent tested this */
	public function getInfoForAction($aItem)
	{
		if (is_numeric($aItem))
		{
			$aItem = array('item_id' => $aItem);
		}
		$aRow = $this->database()->select('l.link_id, l.title, l.user_id, u.gender, u.full_name')
			->from(Phpfox::getT('link'), 'l')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = l.user_id')
			->where('l.link_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');
		
		$aRow['link'] = Phpfox_Url::instance()->permalink('link', $aRow['link_id'], $aRow['title']);
		return $aRow;
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
		if ($sPlugin = Phpfox_Plugin::get('link.service_link__call'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
	
    private function _embedWmode($aMatches)
    {
    	return '<object ' . $aMatches[1] . '><param name="wmode" value="transparent"></param>' . str_replace('<embed ', '<embed  wmode="transparent" ', $aMatches[2]) . '</object>';
    }	
}

?>
