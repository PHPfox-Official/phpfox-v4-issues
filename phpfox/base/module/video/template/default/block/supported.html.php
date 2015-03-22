<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox
 * @version 		$Id: supported.html.php 2501 2011-04-04 20:13:13Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="label_flow" style="height:300px;">
	<ul>
	{foreach from=$aSites item=sSite}
		<li>{$sSite|clean}</li>
	{/foreach}
	</ul>
</div>