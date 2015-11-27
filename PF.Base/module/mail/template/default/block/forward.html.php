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
<div class="row1 mail_thread_holder{if $phpfox.iteration.submessages == count($aMail.forwards)} is_last_submessage{/if}">	
	<div class="row_title">		
		<div class="row_title_image">
			{img user=$aSubMail suffix='_50_square' max_width=32 max_height=32}
		</div>
		<div class="row_title_info">			
			<div class="mail_action">
				<ul>
					<li><span class="extra_info">{$aSubMail.time_stamp|convert_time}</span></li>					
				</ul>
			</div>			
			<div class="mail_thread_user">		
				{$aSubMail|user}
			</div>	
			<div>
				{$aSubMail.text|parse|split:100}
			</div>			
		</div>
	</div>		
</div>