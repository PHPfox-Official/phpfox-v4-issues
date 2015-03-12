<?php
	// {img server_id=$aVideo.image_server_id path='video.url_image' file=$aVideo.image_path suffix='_120' max_width=120 max_height=120 class='js_mp_fix_width' title=$aVideo.title}
	
	$bIsYoutube = false;
	// http://www.phpfox.com/tracker/view/15175/
	if(!$aVideo['is_stream'])
	{
		$iSize = '200';
	}
	else
	{
		$iSize = '120';
		
		if(isset($aVideo['youtube_video_url']))
		{
			$sImagePath = (Phpfox::getParam('core.force_https_secure_pages') && Phpfox::getParam('core.force_secure_site')) ? 'https' : 'http';
			$sImagePath .= '://img.youtube.com/vi/' . $aVideo['youtube_video_url'] . '/hqdefault.jpg';
			$this->template()->setMeta('og:image', $sImagePath);
			$bIsYoutube = true;
		}
	}
	
	$sImagePath = Phpfox::getLib('image.helper')->display(array(
			'server_id' => $aVideo['image_server_id'],
			'path' => 'video.url_image',
			'file' => $aVideo['image_path'],
			/*'suffix' => '_120',
			'max_width' => '120',
			'max_height' => '120',*/
			// http://www.phpfox.com/tracker/view/14924/
			'suffix' => '_'.$iSize,
			'max_width' => $iSize,
			'max_height' => $iSize,
			'return_url' => true
		)
	);
	
	if (!$bIsYoutube && !empty($sImagePath))
	{
		$this->template()->setMeta('og:image', $sImagePath);
	}
?>
