<?php
	// Minimum size according to Facebook
	$iSize = '200';
	
	$sImagePath = Phpfox::getLib('image.helper')->display(array(
			'server_id' => $aPage['image_server_id'],
			'path' => 'pages.url_image',
			'file' => $aPage['pages_image_path'],
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
