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
 * @version 		$Id: index-member-mobile.class.php 2766 2011-07-29 11:58:31Z Raymond_Benc $
 */
class Core_Component_Controller_Index_Member_Mobile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		if (($aVals = $this->request()->getArray('val')) && !empty($aVals['status']))
		{		
			if ($iId = Phpfox::getService('user.process')->updateStatus(Phpfox::getUserId(), $aVals['status']))
			{
				$this->url()->send('');	
			}
		}
		
		$iFeedPage = $this->request()->get('page', 1);
		
		if (Phpfox::isModule('feed'))
		{		
			$aFeeds = Phpfox::getService('feed')->get(null, null, $iFeedPage);		
			
			$iTotalFeeds = (int) Phpfox::getComponentSetting(Phpfox::getUserId(), 'feed.feed_display_limit_dashboard', Phpfox::getParam('feed.feed_display_limit'));
			
			$this->url()->setParam(array(				
					'core',
					'index-member'
				)
			);
			
			// Phpfox::getLib('pager')->set(array('page' => $iFeedPage, 'size' => $iTotalFeeds, 'count' => $iFeedCount));
			
			$this->template()
				->setMobileHeader(array(
						'feed.css' => 'module_feed'
					)
				)
				->assign(array(
					'bMobileHomeIsActive' => true,
					'aFeeds' => $aFeeds						
				)
			);
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_index_member_mobile_clean')) ? eval($sPlugin) : false);
	}
}

?>