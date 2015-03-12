<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Newsletter
 * @version 		$Id: view.html.php 2197 2010-11-22 15:26:08Z Raymond_Benc $
 */

?>
<div style="margin-left: 15px;">
	<div> 
		<div style="width:100%;"><h3> {$aNewsletter.subject} </h3> </div>
		<div style="position: absolute; right:2%; top:2%;">
			{phrase var='newsletter.view_in'} <select id="js_mode" onchange="$Core.Newsletter.toggleMode();">
				<option value="html">{phrase var='newsletter.html'}</option>
				<option value="plain">{phrase var='newsletter.plain'}</option>
			</select>
			<a href="{url link='newsletter'}">{phrase var='newsletter.go_back'}</a>
		</div>
	</div>
	<div>
		{if $aNewsletter.mode == 'html' && $aNewsletter.text_html != ''}
			{$aNewsletter.text_html}
		{elseif $aNewsletter.mode == 'plain' && $aNewsletter.text_plain != ''}
			{$aNewsletter.text_plain}
		{else}
			{phrase var='newsletter.this_newsletter_is_empty'}
		{/if}
	</div>
</div>