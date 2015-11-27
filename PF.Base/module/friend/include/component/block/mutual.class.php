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
class Friend_Component_Block_Mutual extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		list($iTotal, $aRows) = Friend_Service_Friend::instance()->getMutualFriends($this->getParam('mutual_friend_id'));
		
		$this->template()->assign(array(
				'aMutualFriends' => $aRows
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_mutual_clean')) ? eval($sPlugin) : false);
	}
}

?>