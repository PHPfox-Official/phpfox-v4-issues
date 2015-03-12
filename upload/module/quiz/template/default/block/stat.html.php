<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: stat.html.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aQuizTakers)}
<ul class="block_listing">
{foreach from=$aQuizTakers key=iLatestUser item=aQuizTaker}
	<li>
		<div class="block_listing_image">
			{if isset($aQuizTaker.user_info)}
				{img user=$aQuizTaker.user_info suffix='_50_square' max_width=50 max_height=50}
			{else}			
			{img user=$aQuizTaker suffix='_50_square' max_width=50 max_height=50}
			{/if}
		</div>
		<div class="block_listing_title" style="padding-left:56px;">
			{if isset($aQuizTaker.user_info)}
				{$aQuizTaker.user_info|user}
			{else}
				{$aQuizTaker|user}
			{/if}				
			<div class="extra_info">
				{if (Phpfox::getParam('quiz.show_percentage_in_track'))}
					({$aQuizTaker.iSuccessPercentage}%)
				{else}
					({$aQuizTaker.total_correct} / {$aQuizTaker.iTotalCorrectAnswers})
				{/if}				
				<div class="p_top_8">
					<a href="{permalink module='quiz' id=$aQuizTaker.user_info.quiz_id title=$aQuizTaker.user_info.title}results/id_{if isset($aQuizTaker.user_info)}{$aQuizTaker.user_info.user_id}{else}{$aQuizTaker.user_id}{/if}/">{phrase var='quiz.view_results'}</a>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</li>	
{/foreach}
</ul>
{else}
<div class="extra_info">
	{phrase var='quiz.be_the_first_to_answer_this_quiz'}
</div>
{/if}