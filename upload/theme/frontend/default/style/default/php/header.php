<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

$oTpl->setHeader('cache', array(
		'main.js' => 'style_script'
	)
);

$oTpl->setHeader('head',array(
		"<!--[if IE 7]>\n\t\t\t<script type=\"text/javascript\" src=\"" . $oTpl->getStyle('jscript', 'ie7.js') . "?v=" . Phpfox::getLib('template')->getStaticVersion() . "\"></script>\n\t\t<![endif]-->"
	)
);

?>