<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Quiz
 * @version 		$Id: index.html.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aQuizzes)}
{foreach from=$aQuizzes name=quizzes item=aQuiz}
	{template file='quiz.block.entry'}
{/foreach}
{if Phpfox::getUserParam('quiz.can_approve_quizzes')}
{moderation}
{/if}
{pager}
{else}
<div class="extra_info">
	{phrase var='quiz.no_quizzes_found'}
</div>
{/if}