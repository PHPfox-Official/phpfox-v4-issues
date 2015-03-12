<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Language
 * @version 		$Id: delete.html.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link="admincp.language.delete"}">
{token}
<div><input type="hidden" name="id" value="{$aLanguage.language_id}" /></div>
{phrase var='language.are_you_sure' language=Phpfox::getLib(Filter_Output)->clean($aLanguage.language_id)}
<div class="p_4">
	<input type="submit" name="yes" value="{phrase var='language.yes'}" class="button" /> <input type="submit" name="no" value="{phrase var='language.no'}" class="button" />
</div>
</form>