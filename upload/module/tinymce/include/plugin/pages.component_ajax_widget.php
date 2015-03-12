<?php
if (Phpfox::getParam('core.wysiwyg') == 'tiny_mce' && Phpfox::getService('tinymce')->load())
{
	echo Phpfox::getService('tinymce')->getJsCode();
}
?>