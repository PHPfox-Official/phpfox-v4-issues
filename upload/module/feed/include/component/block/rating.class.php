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
 * @version 		$Id: rating.class.php 989 2009-09-17 07:21:44Z Raymond_Benc $
 */
class Feed_Component_Block_Rating extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$this->template()->assign(array(
				'sRating' => (int) $this->getParam('sRating'),
				'iFeedId' => $this->getParam('iFeedId'),
				'bHasRating' => $this->getParam('bHasRating'),
				'iLastVote' => $this->getParam('iLastVote'),
				'bSameUser' => false // ($this->getParam('iUserId') == Phpfox::getUserId() ? true : false)
			)
		);

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
				'iFeedId',
				'bHasRating',
				'iLastVote'
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('comment.component_block_rating_clean')) ? eval($sPlugin) : false);
	}
}

?>