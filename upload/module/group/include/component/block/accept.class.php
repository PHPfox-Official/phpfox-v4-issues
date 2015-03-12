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
 * @version 		$Id: accept.class.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
class Group_Component_Block_Accept extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aGroups = Phpfox::getService('group')->getInvites();
		
		if (!count($aGroups))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'aGroups' => $aGroups
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('group.component_block_accept_clean')) ? eval($sPlugin) : false);
	}
}

?>