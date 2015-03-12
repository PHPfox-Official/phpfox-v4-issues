<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: loaddates.html.php 5521 2013-03-19 12:58:06Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{select_date bUseDatepicker=false prefix='start_' id='_start' start_year='current_year' end_year='user.date_of_birth_start' field_separator=' / ' field_order='YMD' default_all=true}