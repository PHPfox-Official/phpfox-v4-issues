<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Poll
 * @version 		$Id: link.html.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
			{if ( (Phpfox::getUserId() == $aQuiz.user_id && (Phpfox::getUserParam('quiz.can_edit_own_questions') || Phpfox::getUserParam('quiz.can_edit_own_title'))) ||
					(Phpfox::getUserId() != $aQuiz.user_id && (Phpfox::getUserParam('quiz.can_edit_others_questions') || Phpfox::getUserParam('quiz.can_edit_others_title'))))}
				<li><a href="{url link='quiz.add' id=$aQuiz.quiz_id}">{phrase var='quiz.edit'}</a></li>
			{/if}
			{if ($aQuiz.user_id == Phpfox::getUserId())}
				<li><a href="{permalink module='quiz' id=$aQuiz.quiz_id title=$aQuiz.title}results/"">{phrase var='quiz.view_results'}</a></li>
			{/if}
			{if Phpfox::getUserParam('quiz.can_delete_others_quizzes') || ( ($aQuiz.user_id == Phpfox::getUserId()) && Phpfox::getUserParam('quiz.can_delete_own_quiz') )}
			<li class="item_delete"><a href="#" onclick="return $Core.quiz_moderate.deleteQuiz({$aQuiz.quiz_id}, '{if isset($bIsViewingQuiz) && $bIsViewingQuiz}viewing{else}browsing{/if}')">{phrase var='quiz.delete'}</a></li>
			{/if}			