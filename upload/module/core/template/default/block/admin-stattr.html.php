<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: admin-stattr.html.php 4093 2012-04-16 12:54:05Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<tr{if is_int($phpfox.iteration.stats/2)} class="tr"{/if}>
	<td>{phrase var=$aStat.phrase}</td>
	<td>{$aStat.total|number_format}</td>
	<td>{if isset($aStat.average)}{$aStat.average}{else}N/A{/if}</td>
</tr>