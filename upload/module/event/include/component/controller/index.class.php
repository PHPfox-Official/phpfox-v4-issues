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
 * @package  		Module_Event
 * @version 		$Id: index.class.php 7268 2014-04-11 18:04:29Z Fern $
 */
class Event_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		Phpfox::getUserParam('event.can_access_event', true);
		
		$aParentModule = $this->getParam('aParentModule');	
			
		if ($aParentModule === null && $this->request()->getInt('req2') > 0)
		{
			return Phpfox::getLib('module')->setController('event.view');
		}		
		
		if (($sLegacyTitle = $this->request()->get('req2')) && !empty($sLegacyTitle))
		{
			if ($this->request()->get('req3') != '')
			{
				$sLegacyTitle = $this->request()->get('req3');
			}
			
			$aLegacyItem = Phpfox::getService('core')->getLegacyItem(array(
					'field' => array('category_id', 'name'),
					'table' => 'event_category',		
					'redirect' => 'event.category',
					'title' => $sLegacyTitle,
					'search' => 'name_url'
				)
			);		
		}		
		
		if (($iRedirectId = $this->request()->getInt('redirect')) 
			&& ($aEvent = Phpfox::getService('event')->getEvent($iRedirectId, true)) 
			&& $aEvent['module_id'] != 'event'
			&& Phpfox::hasCallback($aEvent['module_id'], 'getEventRedirect')
		)
		{
			if (($sForward = Phpfox::callback($aEvent['module_id'] . '.getEventRedirect', $aEvent['event_id'])))
			{	
				Phpfox::getService('notification.process')->delete('event_invite', $aEvent['event_id'], Phpfox::getUserId());
				
				$this->url()->forward($sForward);
			}
		}			
		
		if (($iDeleteId = $this->request()->getInt('delete')))
		{
			if (($mDeleteReturn = Phpfox::getService('event.process')->delete($iDeleteId)))
			{
				if (is_bool($mDeleteReturn))
				{
					$this->url()->send('event', null, Phpfox::getPhrase('event.event_successfully_deleted'));
				}
				else
				{
					$this->url()->forward($mDeleteReturn, Phpfox::getPhrase('event.event_successfully_deleted'));
				}
			}
		}
		
		if (($iRedirectId = $this->request()->getInt('redirect')) && ($aEvent = Phpfox::getService('event')->getEvent($iRedirectId, true)))
		{
			Phpfox::getService('notification.process')->delete('event_invite', $aEvent['event_id'], Phpfox::getUserId());
			
			$this->url()->permalink('event', $aEvent['event_id'], $aEvent['title']);	
		}
		
		$bIsUserProfile = false;
		if (defined('PHPFOX_IS_AJAX_CONTROLLER'))
		{
			$bIsUserProfile = true;
			$aUser = Phpfox::getService('user')->get($this->request()->get('profile_id'));
			$this->setParam('aUser', $aUser);
		}		
		
		if (defined('PHPFOX_IS_USER_PROFILE'))
		{
			$bIsUserProfile = true;
			$aUser = $this->getParam('aUser');
		}		
		
		$oServiceEventBrowse = Phpfox::getService('event.browse');
		$sCategory = null;
		$sView = $this->request()->get('view', false);
		$aCallback = $this->getParam('aCallback', false);			
		
		$this->search()->set(array(				
				'type' => 'event',
				'field' => 'm.event_id',				
				'search_tool' => array(
					'default_when' => 'upcoming',
					'when_field' => 'start_time',
					'when_upcoming' => true,
					'table_alias' => 'm',
					'search' => array(
						'action' => ($aParentModule === null ? ($bIsUserProfile === true ? $this->url()->makeUrl($aUser['user_name'], array('event', 'view' => $this->request()->get('view'))) : $this->url()->makeUrl('event', array('view' => $this->request()->get('view')))) : $aParentModule['url'] . 'event/view_' . $this->request()->get('view') . '/'),
						'default_value' => Phpfox::getPhrase('event.search_events'),
						'name' => 'search',
						'field' => 'm.title'
					),
					'sort' => array(
						'latest' => array('m.start_time', Phpfox::getPhrase('event.latest'), 'ASC'),
						//'most-viewed' => array('m.total_view', Phpfox::getPhrase('event.most_viewed')),
						'most-liked' => array('m.total_like', Phpfox::getPhrase('event.most_liked')),
						'most-talked' => array('m.total_comment', Phpfox::getPhrase('event.most_discussed'))
					),
					'show' => array(12, 15, 18, 21)
				)
			)
		);
		
		$aBrowseParams = array(
			'module_id' => 'event',
			'alias' => 'm',
			'field' => 'event_id',
			'table' => Phpfox::getT('event'),
			'hide_view' => array('pending', 'my')
		);		
		
		switch ($sView)
		{
			case 'pending':
				if (Phpfox::getUserParam('event.can_approve_events'))
				{
					$this->search()->setCondition('AND m.view_id = 1');
				}
				break;
			case 'my':
				Phpfox::isUser(true);
				$this->search()->setCondition('AND m.user_id = ' . Phpfox::getUserId());
				break;
			default:
				if ($bIsUserProfile)
				{					
					$this->search()->setCondition('AND m.view_id ' . ($aUser['user_id'] == Phpfox::getUserId() ? 'IN(0,2)' : '= 0') . ' AND m.module_id = "event" AND m.privacy IN(' . (Phpfox::getParam('core.section_privacy_item_browsing') ? '%PRIVACY%' : Phpfox::getService('core')->getForBrowse($aUser)) . ') AND m.user_id = ' . (int) $aUser['user_id']);
				}
				elseif ($aParentModule !== null)
				{
					$this->search()->setCondition('AND m.view_id = 0 AND m.privacy IN(%PRIVACY%) AND m.module_id = \'' . Phpfox::getLib('database')->escape($aParentModule['module_id']) . '\' AND m.item_id = ' . (int) $aParentModule['item_id'] . '');
				}
				else
				{			
					switch ($sView)
					{
						case 'attending':				
							$oServiceEventBrowse->attending(1);
							break;
						case 'may-attend':				
							$oServiceEventBrowse->attending(2);
							break;	
						case 'not-attending':				
							$oServiceEventBrowse->attending(3);
							break;
						case 'invites':				
							$oServiceEventBrowse->attending(0);
							break;							
					}						
					
					if ($sView == 'attending')
					{
						$this->search()->setCondition('AND m.view_id = 0 AND m.privacy IN(%PRIVACY%)');
					}
					else
					{
						$this->search()->setCondition('AND m.view_id = 0 AND m.privacy IN(%PRIVACY%) AND m.item_id = ' . ($aCallback !== false ? (int) $aCallback['item'] : 0) . '');
					}
					
					if ($this->request()->getInt('user') && ($aUserSearch = Phpfox::getService('user')->getUser($this->request()->getInt('user'))))
					{
						$this->search()->setCondition('AND m.user_id = ' . (int) $aUserSearch['user_id']);
						$this->template()->setBreadcrumb($aUserSearch['full_name'] . '\'s Events', $this->url()->makeUrl('event', array('user' => $aUserSearch['user_id'])), true);
					}
				}
				break;
		}
		
		if ($this->request()->getInt('sponsor') == 1)
		{
		    $this->search()->setCondition('AND m.is_sponsor != 1');
		    Phpfox::addMessage(Phpfox::getPhrase('event.sponsor_help'));
		}			
		
		if ($this->request()->get('req2') == 'category')
		{
			$sCategory = $this->request()->getInt('req3');
			$this->search()->setCondition('AND mcd.category_id = ' . (int) $sCategory);
		}
		
		if ($sView == 'featured')
		{
			$this->search()->setCondition('AND m.is_featured = 1');
		}		
		
		$this->setParam('sCategory', $sCategory);		
		
		$oServiceEventBrowse->callback($aCallback)->category($sCategory);	
			
		$this->search()->browse()->params($aBrowseParams)->execute();
		
		$aFilterMenu = array();
		$bSetFilterMenu = (!defined('PHPFOX_IS_USER_PROFILE') && !defined('PHPFOX_IS_PAGES_VIEW') );
		if ($sPlugin = Phpfox_Plugin::get('event.component_controller_index_set_filter_menu_1'))
		{
			eval($sPlugin);
			if (isset($mReturnFromPlugin))
			{
				return $mReturnFromPlugin;
			}
		}
		
		if ($bSetFilterMenu)
		{
			$aFilterMenu = array(
				Phpfox::getPhrase('event.all_events') => '',
				Phpfox::getPhrase('event.my_events') => 'my'
			);							
				
			if (Phpfox::isModule('friend') && !Phpfox::getParam('core.friends_only_community'))
			{
				$aFilterMenu[Phpfox::getPhrase('event.friends_events')] = 'friend';	
			}			
			
			list($iTotalFeatured, $aFeatured) = Phpfox::getService('event')->getFeatured();
			if ($iTotalFeatured)
			{
				$aFilterMenu[Phpfox::getPhrase('event.featured_events') . '<span class="pending">' . $iTotalFeatured . '</span>'] = 'featured';
			}				
			
			if (Phpfox::getUserParam('event.can_approve_events'))
			{
				$iPendingTotal = Phpfox::getService('event')->getPendingTotal();
				
				if ($iPendingTotal)
				{
					$aFilterMenu[Phpfox::getPhrase('event.pending_events') . '<span class="pending">' . $iPendingTotal . '</span>'] = 'pending';
				}
			}
			
			$aFilterMenu[] = true;
			
			$aFilterMenu[Phpfox::getPhrase('event.events_i_m_attending')] = 'attending';
			$aFilterMenu[Phpfox::getPhrase('event.events_i_may_attend')] = 'may-attend';
			$aFilterMenu[Phpfox::getPhrase('event.events_i_m_not_attending')] = 'not-attending';
			$aFilterMenu[Phpfox::getPhrase('event.event_invites')] = 'invites';
			
			$this->template()->buildSectionMenu('event', $aFilterMenu);	
		}							
		
		$this->template()->setTitle(($bIsUserProfile ? Phpfox::getPhrase('event.full_name_s_events', array('full_name' => $aUser['full_name'])) : Phpfox::getPhrase('event.events')))->setBreadcrumb(Phpfox::getPhrase('event.events'), ($aCallback !== false ? $this->url()->makeUrl($aCallback['url_home'][0], array_merge($aCallback['url_home'][1], array('event'))) : ($bIsUserProfile ? $this->url()->makeUrl($aUser['user_name'], 'event') : $this->url()->makeUrl('event'))))
			->setHeader('cache', array(
					'pager.css' => 'style_css',
					'country.js' => 'module_core',
					'comment.css' => 'style_css',
					'browse.css' => 'module_event',
					'feed.js' => 'module_feed'				
				)
			)
			->assign(array(
					'aEvents' => $this->search()->browse()->getRows(),
					'sView' => $sView,
					'aCallback' => $aCallback,
					'sParentLink' => ($aCallback !== false ? $aCallback['url_home'][0] . '.' . implode('.', $aCallback['url_home'][1]) . '.event' : 'event'),
					'sApproveLink' => $this->url()->makeUrl('event', array('view' => 'pending'))
				)
			);
			
		if ($sCategory !== null)
		{
			$aCategories = Phpfox::getService('event.category')->getParentBreadcrumb($sCategory);			
			$iCnt = 0;
			foreach ($aCategories as $aCategory)
			{
				$iCnt++;
				
				$this->template()->setTitle($aCategory[0]);
				
				if ($aCallback !== false)
				{
					$sHomeUrl = '/' . Phpfox::getLib('url')->doRewrite($aCallback['url_home'][0]) . '/' . implode('/', $aCallback['url_home'][1]) . '/' . Phpfox::getLib('url')->doRewrite('event') . '/';
					$aCategory[1] = preg_replace('/^http:\/\/(.*?)\/' . Phpfox::getLib('url')->doRewrite('event') . '\/(.*?)$/i', 'http://\\1' . $sHomeUrl . '\\2', $aCategory[1]);
				}
				
				$this->template()->setBreadcrumb($aCategory[0], $aCategory[1], (empty($sView) ? true : false));
			}			
		}
		
		if ($aCallback !== false)
		{
			$this->template()->rebuildMenu('event.index', $aCallback['url_home']);			
		}

		Phpfox::getLib('pager')->set(array('page' => $this->search()->getPage(), 'size' => $this->search()->getDisplay(), 'count' => $this->search()->browse()->getCount()));
		
		$this->setParam('global_moderation', array(
				'name' => 'event',
				'ajax' => 'event.moderation',
				'menu' => array(
					array(
						'phrase' => Phpfox::getPhrase('event.delete'),
						'action' => 'delete'
					),
					array(
						'phrase' => Phpfox::getPhrase('event.approve'),
						'action' => 'approve'
					)					
				)
			)
		);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('event.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>
