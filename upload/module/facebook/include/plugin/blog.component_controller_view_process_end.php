<?php
	// Minimum size according to Facebook
	$iSize = '200';
	
	$sImagePath = Phpfox::getLib('image.helper')->display(array(
			'server_id' => $aItem['user_server_id'],
			'path' => 'core.url_user',
			'file' => $aItem['user_image'],
			'suffix' => '_'.$iSize,
			'max_width' => $iSize,
			'max_height' => $iSize,
			'return_url' => true
		)
	);
	
	if (!empty($sImagePath))
	{
		$this->template()->setMeta('og:image', $sImagePath);
	}
?>
