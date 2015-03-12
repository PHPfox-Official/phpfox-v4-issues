<?php
if (Phpfox::getParam('core.wysiwyg') == 'tiny_mce')
{
	echo ' if (typeof tinyMCE != \'undefined\' && typeof tinyMCE.activeEditor != \'undefined\' && tinyMCE.activeEditor != null)$(\'#text\').html(tinyMCE.activeEditor.getContent()); ';
}
?>