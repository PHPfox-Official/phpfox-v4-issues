<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="message">
	{phrase var='language.checking_the_following_modules_for_missing_phrases'}:
</div>
<ul>
{foreach from=$aModules item=sModule}
	<li>{$sModule}</li>
{/foreach}
</ul>