<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: birth.html.php 4189 2012-05-31 10:16:13Z Raymond_Benc $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

{foreach from=$aQuestions item=aQuestion}
	<div class="table">
		<div class="table_left">
			{$aQuestion.question_phrase|convert}:
		</div>
		<div class="table_right">
			{if isset($aQuestion.image_path) && !empty($aQuestion.image_path)}
				<img src="{$aQuestion.image_path}" />
			{/if}
			<div>
				<input type="text" name="val[spam][{$aQuestion.question_id}]" value="" />
			</div>
		</div>
	</div>
{/foreach}