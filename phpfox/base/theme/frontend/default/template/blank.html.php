<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: blank.html.php 3118 2011-09-16 10:51:04Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$sLocaleDirection}" lang="{$sLocaleCode}">
	<head>
		<title>{title}</title>	
		{if !isset($bNoIFrameHeader)}
		{header}
		{/if}
		{if isset($sCustomHeader)}
		{$sCustomHeader}
		{/if}
	</head>
	<body>
		<div id="js_body_width_frame">
			{if !isset($bNoIFrameHeader)}
			{body}	
			{/if}
			{content}
			{if !isset($bNoIFrameHeader)}
			{footer}	
			{/if}
		</div>
	</body>
</html>