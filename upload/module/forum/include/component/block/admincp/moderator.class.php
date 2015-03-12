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
 * @package 		Phpfox_Component
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Forum_Component_Block_Admincp_Moderator extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('forum.can_manage_forum_moderators', true);
		
		$this->template()->assign(array(
				'sForumDropDown' => Phpfox::getService('forum')->active($this->getParam('id'))->getJumpTool(true),
				'aPerms' => Phpfox::getService('forum.moderate')->getPerms(),
				'aUsers' => Phpfox::getService('forum.moderate')->getForForum($this->getParam('id'))
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_block_admincp_moderator_clean')) ? eval($sPlugin) : false);
	}
}

?>