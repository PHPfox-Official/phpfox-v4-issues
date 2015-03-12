<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: import.html.php 4961 2012-10-29 07:11:34Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
	<form method="post" action="{url link='admincp.apps.import'}" enctype="multipart/form-data">
		<div class="table_header">
			Install
		</div>
		<div class="table">	
			<div class="table_left">
				App Key:
			</div>
			<div class="table_right">
				<input type="text" name="key" size="40" />
			</div>
			<div class="clear"></div>
		</div>		
		<div class="table">	
			<div class="table_left">
				File:
			</div>
			<div class="table_right">
				<input type="file" name="import" size="40" />
			</div>
			<div class="clear"></div>
		</div>
		<div class="table_clear">
			<input type="submit" value="Import" class="button" />
		</div>	
	</form>