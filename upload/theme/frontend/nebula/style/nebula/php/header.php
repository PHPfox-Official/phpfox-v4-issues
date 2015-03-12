<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

$sUserProfileImage = Phpfox::getLib('image.helper')->display(array_merge(array('user' => Phpfox::getService('user')->getUserFields(true)), array(
		'path' => 'core.url_user',
		'file' => Phpfox::getUserBy('user_image'),
		'suffix' => '_50_square',
		'max_width' => 50,
		'max_height' => 50
		)
	)
);

$oTpl->assign(array(
		'sUserProfileImage' => $sUserProfileImage,
		'sUserProfileUrl' => Phpfox::getLib('url')->makeUrl('profile', Phpfox::getUserBy('user_name')), // Create the users profile URL
		'sCurrentUserName' => Phpfox::getLib('parse.output')->shorten(Phpfox::getLib('parse.output')->clean(Phpfox::getUserBy('full_name')), Phpfox::getParam('user.max_length_for_username'), '...'), // Get the users display name
		)
	);
$oTpl->setHeader('cache', array(
		'main.js' => 'style_script',
		'custom.js' => 'style_script'
	)
);

$oTpl->setHeader(array(
		"<!--[if IE 7]>\n\t\t\t<script type=\"text/javascript\" src=\"" . $oTpl->getStyle('jscript', 'ie7.js') . "?v=" . Phpfox::getLib('template')->getStaticVersion() . "\"></script>\n\t\t<![endif]-->"
	)
);

?>