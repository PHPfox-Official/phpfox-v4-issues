<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Quiz
 * @version 		$Id: phpfox.class.php 1174 2009-10-11 13:56:13Z Raymond_Benc $
 */
class Module_Quiz
{	
	public static $aTables = array(
		'quiz',
		'quiz_answer',
		'quiz_question',
		'quiz_result',
		'quiz_track'
	);

	public static $aInstallWritable = array(
		'file/pic/quiz/'
	);
}

?>