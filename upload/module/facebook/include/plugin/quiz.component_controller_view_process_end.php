<?php
	// Minimum size according to Facebook
	$iSize = '200';
	
	$sImagePath = Phpfox::getLib('image.helper')->display(array(
			'server_id' => $aQuiz['server_id'],
			'path' => 'quiz.url_image',
			'file' => $aQuiz['image_path'],
			//'suffix' => '_'.$iSize,
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
