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
 * @package  		Module_Forum
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Forum_Component_Block_Jump extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (Phpfox::isModule('pages') && Phpfox::getService('pages')->isInPage())
		{
			return false;
		}
		
		if (Phpfox::isModule('pages') && $this->request()->get('module') == 'pages')
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sJumpTool' => Phpfox::getService('forum')->active($this->getParam('iActiveForumId', null))->getJumpTool()
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_block_jump_clean')) ? eval($sPlugin) : false);
	}
}

?>