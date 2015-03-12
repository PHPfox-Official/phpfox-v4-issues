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
 * @package  		Module_Comment
 * @version 		$Id: rating.class.php 981 2009-09-15 13:53:22Z Raymond_Benc $
 */
class Comment_Component_Block_Rating extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$this->template()->assign(array(
			'sRating' => (int) $this->getParam('sRating'),
			'iCommentId' => $this->getParam('iCommentId'),
			'bHasRating' => $this->getParam('bHasRating'),
			'iLastVote' => $this->getParam('iLastVote'),
			'bSameUser' => ($this->getParam('iUserId') == Phpfox::getUserId() ? true : false)
		));
		
		(($sPlugin = Phpfox_Plugin::get('comment.component_block_rating_process')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		$this->template()->clean(array(
			'sRating',
			'iCommentId',
			'bHasRating',
			'iLastVote'
		));
		
		(($sPlugin = Phpfox_Plugin::get('comment.component_block_rating_clean')) ? eval($sPlugin) : false);
	}
}

?>