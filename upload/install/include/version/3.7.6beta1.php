<?php

$this->_db()->update(Phpfox::getT('user_group_setting'), array(
		'is_hidden' => 1
		), 'module_id = ' . "'photo'" . ' AND name = ' . "'can_search_for_photos'");
		
$this->_db()->update(Phpfox::getT('user_group_setting'), array(
		'is_hidden' => 1
		), 'module_id = ' . "'feed'" . ' AND name = ' . "'can_sponsor_feeds'");
		
// http://www.phpfox.com/tracker/view/15221/
$this->_db()->update(Phpfox::getT('setting'), array(
		'value_default' => 'br,p,i,em,u,ul,li,font,ol,div[class|style],span[id|class|style],blockquote,strike,b,strong,img[src|alt|class|height|width],a[class|href|rel|target],iframe[src|width|height|frameborder],object[width|height|data],param[name|value],embed[src|type|allowscriptaccess|allowfullscreen|width|height]',
		'value_actual' => 'br,p,i,em,u,ul,li,font,ol,div[class|style],span[id|class|style],blockquote,strike,b,strong,img[src|alt|class|height|width],a[class|href|rel|target],iframe[src|width|height|frameborder],object[width|height|data],param[name|value],embed[src|type|allowscriptaccess|allowfullscreen|width|height]'
		), 'var_name = ' . "'html_purifier_allowed_html'");
		
// Module no longer needed
Phpfox::getService('admincp.module.process')->delete('bulletin');
// Module no longer needed
Phpfox::getService('admincp.module.process')->delete('group');

$this->_upgradeDatabase('3.7.6beta1');
$bCompleted = true;

?>
