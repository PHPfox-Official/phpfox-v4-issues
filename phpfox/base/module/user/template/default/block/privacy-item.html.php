<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_User
 * @version 		$Id: privacy-item.html.php 2692 2011-06-27 19:13:17Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>		
		<div class="table">
			<div class="table_left">
				{$aItem.phrase}
			</div>
			<div class="table_right">
				{module name='privacy.form' privacy_name='privacy' privacy_info='' privacy_array=$sPrivacy privacy_name=$sPrivacy privacy_custom_id='js_custom_privacy_input_holder_'$aItem.custom_id'' privacy_no_custom=true}	
			</div>			
		</div>		