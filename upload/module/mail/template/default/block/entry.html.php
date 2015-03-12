<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Mail
 * @version 		$Id: view.html.php 3369 2011-10-28 16:04:06Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="row1 mail_thread_holder{if (!PHPFOX_IS_AJAX && $phpfox.iteration.messages == count($aMessages)) || (PHPFOX_IS_AJAX && isset($bIsLastMessage) && $bIsLastMessage)} is_last_message{/if}">	
	<div class="row_title">		
		{if !defined('PHPFOX_IS_ADMIN_NEW')}
		<div class="row_title_image">
			{img user=$aMail suffix='_50_square' max_width=50 max_height=50}
			<a href="#{$aMail.message_id}" class="moderate_link" rel="mail">{phrase var='mail.moderate'}</a>
		</div>
		{/if}
		<div class="row_title_info">			
			<div class="mail_action">
				<ul>
					{if $aMail.is_mobile}
					<li class="js_hover_title">{img theme='misc/mobile.png'}<span class="js_hover_info">{phrase var='mail.sent_via_a_mobile_device'}</span></li>
					{/if}
					<li><span class="extra_info">{$aMail.time_stamp|convert_time}</span></li>					
				</ul>
			</div>			
			<div class="mail_thread_user">		
				{$aMail|user}
			</div>	
			<div>
				{$aMail.text|parse|split:100}
			</div>			
	
			
			{if isset($aMail.attachments)}
			{module name='attachment.list' sType='mail' attachments=$aMail.attachments}
			{/if}				
			
			{if isset($aMail.forwards) && count($aMail.forwards)}
			<div class="mail_thread_forward">
				{foreach from=$aMail.forwards name=submessages item=aSubMail}
					{template file='mail.block.forward'}
				{/foreach}
			</div>
			{/if}				
			
		</div>
	</div>		
</div>