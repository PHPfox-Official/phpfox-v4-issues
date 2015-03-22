<?php
if (Phpfox::getParam('core.wysiwyg') == 'tiny_mce')
{	
		if (Phpfox::getParam('core.site_wide_ajax_browsing'))
		{
			$oTpl->setHeader(array(
					'wysiwyg/tiny_mce/tiny_mce.js' => 'static_script',
					'wysiwyg/tiny_mce/core.js' => 'static_script'
				)
			);
			
			if (Phpfox::getService('tinymce')->load())
			{			
				$oTpl->setHeader(array(
						Phpfox::getService('tinymce')->getJsCode()
					)
				);
			}			
		}
		else
		{
			Phpfox::getService('tinymce')->load();			
			$oTpl->setHeader(array(
					'wysiwyg/tiny_mce/tiny_mce.js' => 'static_script',
					'wysiwyg/tiny_mce/core.js' => 'static_script',
					Phpfox::getService('tinymce')->getJsCode()
				)
			);			
		}
}
?>