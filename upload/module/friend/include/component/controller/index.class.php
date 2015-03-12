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
 * @version 		$Id: index.class.php 3441 2011-11-02 15:53:59Z Miguel_Espinoza $
 */
class Friend_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		Phpfox::isUser(true);
		
		if (($iDeleteList = $this->request()->getInt('dlist')) && Phpfox::getService('friend.list.process')->delete($iDeleteList))
		{
			$this->url()->send('friend', true, Phpfox::getPhrase('friend.list_successfully_deleted'));
		}
		
		$sView = $this->request()->get('view');
		$iPage = $this->request()->getInt('page');		
		$this->template()->setTitle(Phpfox::getPhrase('friend.friends'))->setBreadcrumb(Phpfox::getPhrase('friend.friends'), $this->url()->makeUrl('friend'));
			
		$aSort = array();
		if ($sView == 'list')
		{
			$aSort['custom'] = array(
				'fld.ordering', Phpfox::getPhrase('friend.custom_order')
			);
		}
		
		$aSort['latest'] = array('friend.time_stamp', Phpfox::getPhrase('friend.newest_friends'));
		$aSort['first-name'] = array('u.full_name', Phpfox::getPhrase('friend.by_first_name'), 'ASC');
					
		$aParams = array(
				'type' => 'friend',
				'field' => 'friend.friend_id',				
				'search_tool' => array(
					'table_alias' => 'friend',
					'search' => array(
						'action' =>  $this->url()->makeUrl('friend', array('view' => $this->request()->get('view'))),
						'default_value' => Phpfox::getPhrase('friend.search_friends_dot_dot_dot'),
						'name' => 'search',
						'field' => 'u.full_name'
					),
					'sort' => $aSort,
					'show' => array(10, 15, 20)
				)
			);					
		
		$this->search()->set($aParams);	

		$iPageSize = $this->search()->getDisplay();

		$bIsOnline = false;
		$iListId = 0;
		$aSend = null;
		$aList = array();
		switch ($sView)
		{
			case 'list':
				if (($iListId = $this->request()->getInt('id')) && ($aList = Phpfox::getService('friend.list')->getList($iListId, Phpfox::getUserId())) && isset($aList['list_id']))
				{
					$this->search()->setCondition('AND fld.list_id = ' . (int) $aList['list_id']);
					$aSend = array('list' => $iListId);
					$this->template()->setTitle($aList['name'])->setBreadcrumb($aList['name'], $this->url()->makeUrl('friend', array('view' => 'list', 'id' => $iListId)), true);
				}
				else
				{
					return Phpfox_Error::display(Phpfox::getPhrase('friend.invalid_friend_list'));
				}				
				break;
			default:
				$this->search()->setCondition('AND friend.is_page = 0 AND friend.user_id = ' . Phpfox::getUserId());
				break;
		}
		
		if (($aVals = $this->request()->getArray('val')) && isset($aVals['id']) && is_array($aVals['id']))
		{
			$oServiceFriendProcess = Phpfox::getService('friend.process');
			foreach ($aVals['id'] as $iId)
			{
				$oServiceFriendProcess->delete($iId);
			}
			
			$this->url()->send('friend', $aSend, Phpfox::getPhrase('friend.successfully_deleted'));
		}
		
		list($iCnt, $aRows) = Phpfox::getService('friend')->get($this->search()->getConditions(), $this->search()->getSort(), $this->search()->getPage(), $iPageSize, true, true, $bIsOnline, null, true);		
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'ajax' => 'friend.viewMoreFriends'));
		
		Phpfox::getService('friend')->buildMenu();
		
		$this->template()->setHeader('jquery/ui.js', 'static_script');
		$this->template()->setHeader('cache', array(
					'pager.css' => 'style_css',						
					'friend.js' => 'module_friend',
					'friend.css' => 'style_css'
				)
			)				
			->assign(array(
				'aFriends' => $aRows,
				'aList' => $aList,
				'iList' => $iListId,
				'sView' => $sView,
				'iTotalFriendRequests' => Phpfox::getService('friend.request')->getUnseenTotal()
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>