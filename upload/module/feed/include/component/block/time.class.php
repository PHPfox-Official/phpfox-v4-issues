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
 * @package  		Module_Feed
 * @version 		$Id: display.class.php 4171 2012-05-16 07:10:36Z Raymond_Benc $
 */
class Feed_Component_Block_Time extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!Phpfox::getService('profile')->timeline() && !$this->getParam('bIsPage'))
		{
			return false;
		}
		
		$aUser = $this->getParam('aUser');
		if ($aUser === null)
		{
			$aUser = $this->getParam('aPage');
			$this->setParam('aUser', $aUser);
		}
		if (isset($aUser['is_page']) && $aUser['is_page'] && isset($aUser['owner_language_id']) && isset($aUser['link']) && isset($aUser['page_user_id']))
		{
			$aUser['user_id'] = $aUser['page_user_id'];
		}
		
		if (empty($aUser['user_id']))
		{
			return false;
		}
		
		if (!isset($aUser['birthday_search']))
		{
			$aUser['birthday_search'] = PHPFOX_TIME;
		}
		
		if (defined('PHPFOX_IS_PAGES_VIEW'))
		{			
			$aUser['birthday_search'] = Phpfox::getService('feed')->getOldPost($aUser['page_id']);
		}

		//$aTimeline = Phpfox::getService('feed')->getTimeLineYears($aUser['user_id'], $aUser['birthday_search']);

		if(isset($aUser['birthday']) && $aUser['birthday'] == null)
		{
			$aTimeline = Phpfox::getService('feed')->getTimeLineYears($aUser['user_id'], $aUser['joined']);
		}
		else
		{
			$aTimeline = Phpfox::getService('feed')->getTimeLineYears($aUser['user_id'], $aUser['birthday_search']);
		}
		
		$this->template()->assign(array(
				'aTimelineDates' => $aTimeline
			)
		);
	}
}

?>