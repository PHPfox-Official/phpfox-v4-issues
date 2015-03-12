<?php
if (Phpfox::getParam('core.wysiwyg') == 'tiny_mce')
{
	echo ' $(\'#message\').html(tinyMCE.activeEditor.getContent()); ';
}
?>