<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: view.html.php 2511 2011-04-08 19:56:57Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if isset($aQuiz)}	
<div class="item_view">
	{template file='quiz.block.entry'}
	
	<div id="js_comment_module" {if $aQuiz.view_id == 1}style="display:none;" class="js_moderation_on"{/if}>
		{module name='feed.comment'}
	</div>	
</div>
{else}
	<div class="extra_info">
		{phrase var='quiz.the_link_that_brought_you_here_is_wrong'}
		<ul class="action">
			<li><a href="{$sRealLink}">{phrase var='quiz.click_here_to_get_the_quiz_from_the_real_owner'}</a></li>
		</ul>
	</div>
{/if}