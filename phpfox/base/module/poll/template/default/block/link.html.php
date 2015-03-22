<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Blog
 * @version 		$Id: link.html.php 2501 2011-04-04 20:13:13Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>		
					{if ($aPoll.bCanEdit)}
						{if !isset($bDesign) || $bDesign == false}
							<li>
								<a href="{url link='poll.add' id=$aPoll.poll_id}">
									{phrase var='poll.edit'}
								</a>	
							</li>
						{/if}
					{/if}
					{if !isset($bIsCustomPoll)}
					{if ((Phpfox::getUserParam('poll.poll_can_delete_own_polls') && $aPoll.user_id == Phpfox::getUserId())
						|| Phpfox::getUserParam('poll.poll_can_delete_others_polls'))}
						{if !isset($bDesign) || $bDesign == false}
							<li class="item_delete">
								<a {if isset($bIsViewingPoll)}href="{url link='poll' delete=$aPoll.poll_id}" class="sJsConfirm"{else}href="#" onclick="deletePoll({$aPoll.poll_id}); return false;"{/if}>
									{phrase var='poll.delete'}
								</a>
							</li>
						{/if}
					{/if}			
					{/if}