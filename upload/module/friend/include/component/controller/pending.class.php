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
 * @version 		$Id: pending.class.php 5916 2013-05-13 08:42:54Z Raymond_Benc $
 */
class Friend_Component_Controller_Pending extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);

		if ($iDeleteId = $this->request()->get('id'))
		{
			if (Phpfox::getService('friend.request.process')->delete($iDeleteId, Phpfox::getUserId()))
			{
				$this->url()->send('friend.pending', null, Phpfox::getPhrase('friend.friends_request_successfully_deleted'));
			}
		}
		
		$iPage = $this->request()->getInt('page');
		$iPageSize = 12;
		
		list($iCnt, $aPendingRequests) = Phpfox::getService('friend.request')->getPending($iPage, $iPageSize);
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
		
		Phpfox::getService('friend')->buildMenu();
		
		$this->template()->setTitle('Friends')->setBreadcrumb(Phpfox::getPhrase('friend.my_friends'), $this->url()->makeUrl('friend'));
		$this->template()->setTitle(Phpfox::getPhrase('friend.pending_friend_requests'))
			->setHeader('cache', array(
					'pager.css' => 'style_css',
					'friend.css' => 'style_css'
				)
			)
			->assign(array(
					'aPendingRequests' => $aPendingRequests
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_controller_pending_clean')) ? eval($sPlugin) : false);
	}
}

?>