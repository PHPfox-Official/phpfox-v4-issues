<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: missing.html.php 1390 2010-01-13 13:30:08Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="message">
	{phrase var='admincp.checking_the_following_modules_for_missing_settings'}:
</div>
<ul>
{foreach from=$aModules item=sModule}
	<li>{$sModule}</li>
{/foreach}
</ul>