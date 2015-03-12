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
 * @version 		$Id: admin.class.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
class Group_Component_Block_Admin extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aGroup = $this->getParam('aGroup');
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('group.admins'),
				'aGroupAdmins' => Phpfox::getService('group')->getAdmins($aGroup['group_id'])
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
		(($sPlugin = Phpfox_Plugin::get('group.component_block_admin_clean')) ? eval($sPlugin) : false);
	}
}

?>