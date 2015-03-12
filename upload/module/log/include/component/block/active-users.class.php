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
 * @package  		Module_Log
 * @version 		$Id: active-users.class.php 3342 2011-10-21 12:59:32Z Raymond_Benc $
 */
class Log_Component_Block_Active_Users extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aCond = array();
		if ($iForumId = $this->getParam('iForumId'))
		{
			$aCond[] = 'AND s.forum_id = "' . (int)$iForumId . '"';	
		}
		elseif ($this->getParam('bIsForum'))
		{
			$aCond[] = 'AND s.is_forum = 1';
		}
		
		list($iTotal, $aRows) = Phpfox::getService('log.session')->getActiveUsers($aCond);
		
		if ($iTotal === 0)
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('log.active_users_total', array('total' => $iTotal)),
				'aActiveUsers' => $aRows,
				'iActiveMembers' => $iTotal			
			)
		);
		
		return 'block';
	}
}

?>