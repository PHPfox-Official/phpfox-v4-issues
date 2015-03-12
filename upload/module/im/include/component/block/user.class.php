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
 * @version 		$Id: user.class.php 742 2009-07-09 11:44:24Z Raymond_Benc $
 */
class Im_Component_Block_User extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aRooms = Phpfox::getService('im')->getRooms();
		/*
		foreach ($aRooms as $iKey => $aRoom)
		{
			if (!$aRoom['is_logged_in'])
			{
				unset($aRooms[$iKey]);
			}
		}
		*/
		$this->template()->assign(array(
				'aRooms' => $aRooms
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('im.component_block_user_clean')) ? eval($sPlugin) : false);
	}
}

?>