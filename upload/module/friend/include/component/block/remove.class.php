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
 * @package  		Module_Friend
 * @version 		$Id: top.class.php 1135 2009-10-05 12:59:10Z Miguel_Espinoza $
 */
class Friend_Component_Block_Remove extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (!defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::isUser())
		{
			return false;
		}
		
		$aUser = $this->getParam('aUser');
		if (empty($aUser))
		{
			return false;
		}

		if (!$aUser['is_friend'])
		{
			return false;
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_top_clean')) ? eval($sPlugin) : false);
	}	
}

?>