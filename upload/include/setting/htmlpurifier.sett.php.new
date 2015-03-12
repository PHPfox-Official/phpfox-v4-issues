<?php
/**
 * For more settings check out: http://htmlpurifier.org/live/configdoc/plain.html
 */

// Comma separated HTML elements we should allow as well as their attributes.
$config->set('HTML.Allowed', Phpfox::getParam('core.html_purifier_allowed_html'));

// Allow the CSS classes for quoting in forums
$config->set('Attr.AllowedClasses', array('new_quote', 'new_quote_header', 'new_quote_content_holder', 'new_quote_content', 'play_link', 'play_link_img', 'attachment_is_video'));

// Allow iframes. Used for YouTube videos
$config->set('HTML.SafeIframe', true);

// Allow flash to go full screen
$config->set('HTML.FlashAllowFullScreen', true);

// Regex of sites we should allow
$config->set('URI.SafeIframeRegexp', Phpfox::getParam('core.html_purifier_allowed_iframes'));

// Allow object/embed. Needed for flash or old YouTube videos. Try to disable this.
$config->set('HTML.SafeObject', true);
$config->set('HTML.SafeEmbed', true);
$config->set('Output.FlashCompat', true);
$config->set('HTML.FlashAllowFullScreen', true);

// Cache directory. We use the PHPFox default dir.
$config->set('Cache.SerializerPath', PHPFOX_DIR_CACHE);

// http://www.phpfox.com/tracker/view/15221/
$config->set('Attr.EnableID', true);
$config->set('Attr.IDBlacklistRegex', '/^(?(!js_attachment))/i');
?>
