<?php
if (Phpfox::getParam('core.wysiwyg') == 'tiny_mce')
{
	$bSkipDefaultCheck = true;
	if ($this->_bParent === true)
	{
		
	}
	else 
	{
		$sStr .= $this->_createIfJS('' . ((($sFieldKey == 'text' || $sFieldKey == 'description' || $sFieldKey == 'message') && Phpfox::getParam('core.wysiwyg') == 'tiny_mce') ? '(Editor.sEditor == \'tiny_mce\' && typeof(tinyMCE) == \'object\' && tinyMCE.activeEditor != null && tinyMCE.activeEditor.getContent().replace(/<\/?[^>]+>/gi, \'\').length == 0) || (typeof(tinyMCE) != \'object\' && $(\'#'. $sFieldKey .'\').val() == \'\') || (Editor.sEditor != \'tiny_mce\' && typeof(tinyMCE) == \'object\' && $(\'#'. $sFieldKey .'\').val() == \'\')' : '$(\'#'. $sFieldKey .'\').val() == \'\'') . '', $aFieldValue['title'], $sFieldKey);
	}
}
?>