<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: view.html.php 4857 2012-10-09 06:32:38Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if Phpfox::getParam('mail.threaded_mail_conversation')}
{foreach from=$aMessage item=aMail}
<div class="row1 mail_thread_holder">
	<div class="row_title">
		<div class="row_title_image">
			{img user=$aMail suffix='_50_square' max_width=50 max_height=50}			
		</div>		
		<div class="row_title_info">	
			<div class="mail_action">
				<ul>
					<li><span class="extra_info">{$aMail.time_stamp|convert_time}</span></li>					
				</ul>
			</div>		
			<div class="mail_thread_user">		
				{$aMail|user}
			</div>	
			<div>
				{$aMail.text|parse|split:200}
			</div>			
		</div>	
	</div>	
</div>
{/foreach}
{else}
{phrase var='mail.private_message_from_timestamp' time_stamp=$aMessage.time_stamp|date:'mail.mail_time_stamp' owner=$aMessage|user:'owner_' viewer=$aMessage|user:'viewer_'}
<br />
<br />
{$aMessage.text|parse}
{/if}
<div class="t_right">
	<ul class="item_menu">
		<li><a href="{if Phpfox::getParam('mail.threaded_mail_conversation')}{url link='admincp.mail.private' delete=$aMessage[0].thread_id}{else}{url link='admincp.mail.private' delete=$aMessage.mail_id}{/if}" class="sJsConfirm">{phrase var='mail.delete'}</a></li>
	</ul>
	<div class="clear"></div>
</div>