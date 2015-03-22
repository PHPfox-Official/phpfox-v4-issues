<?php
if (Phpfox::getParam('core.wysiwyg') == 'tiny_mce')
{
	if (Phpfox::getService('tinymce')->load())
	{
		$sStr .= '<div id="layer_' . $iId . '"><textarea style="width:100%;" name="val[' . $iId . ']" rows="' . (isset($aParams['rows']) ? $aParams['rows'] : '12') . '" cols="' . (isset($aParams['cols']) ? $aParams['cols'] : '50') . '" id="' . $iId . '">' . $this->getValue($iId) . '</textarea></div>';
	}
	else 
	{
		$sStr = $this->get($iId, $aParams, true);	
		$sStr .= '<script type="text/javascript">Editor.getEditors();</script>';
	}
}
?>