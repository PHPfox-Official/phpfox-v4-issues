<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: stat.html.php 683 2009-06-16 11:44:55Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<ul class="action">
{foreach from=$aSiteStats item=aSiteStat}
<li>
	<a href="{url link=$aSiteStat.stat_link}">{img theme='stat/'$aSiteStat.stat_image'' default='stat/default.png' style='vertical-align:middle'} {phrase var=$aSiteStat.phrase_var}: {$aSiteStat.count}</a>
</li>
{/foreach}
</ul>