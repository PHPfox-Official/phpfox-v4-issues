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
 * @version 		$Id: moderate.class.php 598 2009-05-26 20:36:18Z Raymond_Benc $
 */
class Comment_Component_Block_Moderate extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		$aComments = Phpfox::getService('comment')->getPendingComments();
		
		if (!count($aComments))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'aComments' => $aComments
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('comment.component_block_moderate_clean')) ? eval($sPlugin) : false);
	}
}

?>