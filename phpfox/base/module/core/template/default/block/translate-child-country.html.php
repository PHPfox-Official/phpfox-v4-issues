<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: translate-child-country.html.php 1329 2009-12-16 17:01:32Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
<h3>{phrase var='core.translating_name' name=$sCountryName}</h3>
<form method="post" action="#" onsubmit="tb_remove(); $(this).ajaxCall('core.admincp.translateCountryChildProcess'); return false;">
	<div><input type="hidden" name="val[child_id]" value="{$sChildId}" /></div>
	{module name='language.admincp.form' id='text' var_name=$sChildVarName}
	<input type="submit" value="{phrase var='core.submit'}" class="button" />	
</form>