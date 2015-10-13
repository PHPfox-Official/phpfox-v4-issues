<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: mutual-browse.class.php 2632 2011-05-26 19:28:02Z Raymond_Benc $
 */
class Friend_Component_Block_Mutual_Browse extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$iPage = $this->request()->getInt('page');
		$iPageSize = 5;
		
		$aCond = array();
		$aCond[] = 'AND friend.user_id = ' . Phpfox::getUserId();
		
		list($iCnt, $aFriends) = Friend_Service_Friend::instance()->get($aCond, 'friend.time_stamp DESC', $iPage, $iPageSize, true, false, false, $this->request()->getInt('user_id'));
    $sUserName = Friend_Service_Friend::instance()->getUserName($this->request()->getInt('user_id'));
		Phpfox_Pager::instance()->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'ajax' => 'friend.getMutualFriends'));
		
		$this->template()->assign(array(
				'aFriends' => $aFriends,
				'iPage' => $iPage,
        'sUserName' => $sUserName,
        'iTotalMutualFriends' => $iCnt
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_mutual_browse_clean')) ? eval($sPlugin) : false);
	}
}

?>