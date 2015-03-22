<?php
if (Phpfox::getParam('core.wysiwyg') == 'tiny_mce')
{
	echo ' $(\'#text\').val(tinyMCE.activeEditor.getContent()); ';
}
?>