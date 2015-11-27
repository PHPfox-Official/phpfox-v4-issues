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
	<div class="row_banner image_load" data-src="{if $aQuiz.image_path}{img server_id=$aQuiz.server_id path='quiz.url_image' file=$aQuiz.image_path suffix='' return_url=true}{/if}">
		<header>
			<h1 itemprop="name"><a href="{permalink module='quiz' id=$aQuiz.quiz_id title=$aQuiz.title}" class="link" itemprop="url">{$aQuiz.title|clean}</a></h1>
			<ul>
				<li>@ {$aQuiz.time_stamp|convert_time}</li>
				<li>by {$aQuiz|user}</li>
			</ul>
		</header>
	</div>
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