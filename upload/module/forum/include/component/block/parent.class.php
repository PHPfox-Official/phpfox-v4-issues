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
 * @version 		$Id: parent.class.php 1124 2009-10-02 14:07:30Z Raymond_Benc $
 */
class Forum_Component_Block_Parent extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aGroup = $this->getParam('aGroup');
		
		$aThreads = Phpfox::getService('forum.thread')->getForParent($aGroup['group_id']);	
		
		if (!count($aThreads) && !defined('PHPFOX_IN_DESIGN_MODE'))
		{
			return false;
		}
		
		if (!Phpfox::getService('group')->hasAccess($aGroup['group_id'], 'can_use_forum'))
		{
			return false;
		}		
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('forum.recent_topics'),				
				'aThreads' => $aThreads,
				'aGroup' => $aGroup		
			)
		);
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_block_parent_clean')) ? eval($sPlugin) : false);
	}
}

?>