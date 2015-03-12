<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Poll
 * @version 		$Id: index.html.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !count($aPolls)}
<div class="extra_info">
	{phrase var='poll.no_polls_found'}
</div>
{else}
{foreach from=$aPolls item=aPoll key=iKey name=polls}
	{template file='poll.block.entry'}
{/foreach}
{if Phpfox::getUserParam('poll.poll_can_moderate_polls')}
{moderation}
{/if}
{pager}
{/if}