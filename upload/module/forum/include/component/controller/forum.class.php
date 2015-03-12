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
 * @package  		Module_Forum
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Forum_Component_Controller_Forum extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (Phpfox::isMobile() && Phpfox::getLib('module')->getFullControllerName() == 'forum.forum' && !$this->request()->getInt('req2') && !in_array($this->request()->get('view'), array('subscribed','new','my-thread')))
		{
			return Phpfox::getLib('module')->setController('forum.index');
		}
		
		
		Phpfox::getUserParam('forum.can_view_forum', true);
		
		$aParentModule = $this->getParam('aParentModule');	
		
		$bIsSearch = ($this->request()->getInt('search-id', false) ? true : false);	
		$aCallback = $this->getParam('aCallback', null);
		$sView = $this->request()->get('view');	
		$bShowPosts = false;
		
		$bIsTagSearch = false;
		$bIsModuleTagSearch = false;
		if ($this->request()->get('req2') == 'tag' && $this->request()->get('req3'))
		{
			$bIsSearch = true;
			$bIsTagSearch = true;
		}
		
		if ($this->request()->get('req2') == 'tag' && $this->request()->get('req5') && $this->request()->get('module'))
		{			
			if ($aCallback = Phpfox::getService('group')->getGroup($this->request()->get('item')))
			{
				$bIsSearch = true;
				$bIsTagSearch = true;
				$bIsModuleTagSearch = true;
				$aCallback['url_home'] = 'group.' . $aCallback['title_url'] . '.forum';
			}			
		}
		
		$oSearch = Phpfox::getService('forum')->getSearchFilter($this->getParam('bIsSearchQuery', false));
		
		if ($oSearch->isSearch())
		{
			$aSearch = $this->request()->getArray('search');	

			if (!empty($aSearch['forum']) && is_array($aSearch['forum']))
			{
				$sForumIds = '';
				foreach ($aSearch['forum'] as $iSearchForum)
				{
					if (!is_numeric($iSearchForum))
					{
						continue;
					}
					
					if (empty($aSearch['group_id']))
					{
						if (!Phpfox::getService('forum')->hasAccess($iSearchForum, 'can_view_forum'))
						{
							continue;
						}
					}
					
					$sForumIds .= $iSearchForum . ',';
				}
				$sForumIds = rtrim($sForumIds, ',');				
				
				if (!empty($sForumIds))
				{
					$oSearch->setCondition('AND ft.forum_id IN(' . $sForumIds . ')');
				}
			}
			else 
			{
				if (empty($aSearch['group_id']))
				{
					$sForums = Phpfox::getService('forum')->getCanViewForumAccess('can_view_forum');
					if ($sForums !== false)
					{
						$oSearch->setCondition('AND ft.forum_id NOT IN(' . $sForums . ')');	
					}
				}
			}
			
			if (!empty($aSearch['user']))
			{
				$oSearch->search('like%', 'u.full_name', $aSearch['user']);
			}
			
			if (($sCustomModule = $this->request()->get('module')) && ($iCustomId = $this->request()->getInt('item')))
			{
				$oSearch->setCondition('AND ft.group_id = ' . (int) $iCustomId);
			}
			else
			{
				$oSearch->setCondition('AND ft.group_id = 0');
			}
			
			if (($this->request()->get('view') == 'pending-post' && Phpfox::getUserParam('forum.can_approve_forum_post')))
			{
				$aSearch['result'] = '1';
				$oSearch->setCondition('AND fp.view_id = 1');
				$this->url()->clearParam('view');
			}
			
			if (empty($aSearch['result']))
			{
				if (!empty($aSearch['keyword']))
				{
					$oSearch->search('like%', array('ft.title'), $aSearch['keyword']);
				}
				
				if (!empty($aSearch['days_prune']) && $aSearch['days_prune'] != '-1')
				{
					$oSearch->setCondition('AND ft.time_stamp >= ' . (PHPFOX_TIME - ($aSearch['days_prune'] * 86400)));					
				}		
				
				$aSearchResults = Phpfox::getService('forum.thread')->getSearch($oSearch->getConditions(), $oSearch->getSort());				
			}
			else 
			{
				if (!empty($aSearch['keyword']))
				{
					$oSearch->search('like%', array('fp.title', 'fpt.text'), $aSearch['keyword']);
				}				
				
				if (!empty($aSearch['days_prune']) && $aSearch['days_prune'] != '-1')
				{
					$oSearch->setCondition('AND fp.time_stamp >= ' . (PHPFOX_TIME - ($aSearch['days_prune'] * 86400)));					
				}
				
				if (empty($aSearch['group_id']))
				{
					$sForums = Phpfox::getService('forum')->getCanViewForumAccess('can_view_thread_content');
					if ($sForums !== false)
					{
						$oSearch->setCondition('AND ft.forum_id NOT IN(' . $sForums . ')');	
					}					
				}				
				
				$aSearchResults = Phpfox::getService('forum.post')->getSearch($oSearch->getConditions(), $oSearch->getSort());										
			}				

			if ((!count($aSearchResults)) || (count($aSearchResults) && !$oSearch->cacheResults(array('keyword', 'user'), $aSearchResults)))
			{
				if (is_array($aCallback) && isset($aCallback['group_id']))
				{
					$this->url()->send('forum.search', array('module' => 'pages', 'item' => $aCallback['group_id']), Phpfox::getPhrase('forum.no_results_found'));
				}
				else 
				{
					$this->url()->send('forum.search', null, Phpfox::getPhrase('forum.no_results_found'));
				}
			}
		}					
		
		define('PHPFOX_PAGER_FORCE_COUNT', true);
		
		$iPage = $this->request()->getInt('page');
		$iPageSize = $oSearch->getDisplay();
		
		$sViewId = 'ft.view_id = 0';
		if ($aCallback === null)
		{			
			$iForumId = $this->request()->getInt('req2');
			if (Phpfox::getUserParam('forum.can_approve_forum_thread') || Phpfox::getService('forum.moderate')->hasAccess($iForumId, 'approve_thread'))
			{
				$sViewId = 'ft.view_id >= 0';	
			}
		}
		
		if ($aParentModule == null)
		{
			$iForumId = $this->request()->getInt('req2');		

			$aForums = Phpfox::getService('forum')->live()->id($iForumId)->getForums();		
			$aForum = Phpfox::getService('forum')->id($iForumId)->getForum();
		}
		else
		{
			$aForum = array();
			$aForums = array();
		}
				
		if (!$bIsSearch && $this->request()->get('view') != 'pending-post')
		{
			if ($aParentModule === null)
			{							
				if (!isset($aForum['forum_id']) && empty($sView))
				{				
					return Phpfox_Error::display(Phpfox::getPhrase('forum.not_a_valid_forum'));
				}
				
				if (isset($aForum['forum_id']))
				{
					$this->setParam('iActiveForumId', $aForum['forum_id']);
				}
				
				if (!empty($sView))
				{
					switch ($sView)
					{
						case 'my-thread':
							$oSearch->setCondition('AND ft.user_id = ' . Phpfox::getUserId());
							// $bShowPosts = true;
							break;
						case 'pending-thread':
							if (Phpfox::getUserParam('forum.can_approve_forum_thread'))
							{
								$sViewId = 'ft.view_id = 1';								
							}
							break;
						default:
							
							break;
					}					
					
					$oSearch->setCondition('AND ft.group_id = 0 AND ' . $sViewId . ' AND ft.is_announcement = 0');
					
					$bIsSearch = true;
				}
				else 
				{
					$oSearch->setCondition('ft.forum_id = ' . $aForum['forum_id'] . ' AND ft.group_id = 0 AND ' . $sViewId . ' AND ft.is_announcement = 0');
				}				
			}
			else 
			{				
				$oSearch->setCondition('ft.forum_id = 0 AND ft.group_id = ' . $aParentModule['item_id'] . ' AND ' . $sViewId . ' AND ft.is_announcement = 0');
			}
			
			// get the forums that we cant access
			$aForbiddenForums = Phpfox::getService('forum')->getForbiddenForums();
			if (!empty($aForbiddenForums))
			{
				$oSearch->setCondition(' AND ft.forum_id NOT IN (' . implode(',', $aForbiddenForums) . ')');
			}
		}

		if ($oSearch->get('result') || ($this->request()->get('view') == 'pending-post'))
		{			
			if ($this->request()->get('view') == 'pending-post')
			{
				$bIsSearch = true;
				$bForceResult = true;				
				$oSearch->setCondition('AND fp.view_id = 1');	
			}
			
			list($iCnt, $aThreads) = Phpfox::getService('forum.post')->callback($aCallback)->get($oSearch->getConditions(), $oSearch->getSort(), $oSearch->getPage(), $iPageSize);						
		}
		else 
		{			
			if (($iDaysPrune = $oSearch->get('days_prune')) && $iDaysPrune != '-1')
			{
				$oSearch->setCondition('AND ft.time_stamp >= ' . (PHPFOX_TIME - ($iDaysPrune * 86400)));					
			}			
			
			if ($bIsTagSearch === true)
			{
				if ($bIsModuleTagSearch)
				{
					$oSearch->setCondition("AND ft.group_id = " . (int) $aCallback['group_id'] . " AND tag.tag_url = '" . Phpfox::getLib('database')->escape($this->request()->get('req5')) . "'");					
				}
				else 
				{
					$oSearch->setCondition("AND ft.group_id = 0 AND tag.tag_url = '" . Phpfox::getLib('database')->escape($this->request()->get('req3')) . "'");
				}
			}			

			list($iCnt, $aThreads) = Phpfox::getService('forum.thread')->isSearch($bIsSearch)
				->isTagSearch($bIsTagSearch)
				->isNewSearch(($sView == 'new' ? true : false))
				->isSubscribeSearch(($sView == 'subscribed' ? true : false))
				->isModuleSearch($bIsModuleTagSearch)
				->get($oSearch->getConditions(), 'ft.order_id DESC, ' . $oSearch->getSort(), $oSearch->getPage(), $iPageSize);						
		}
		
		
		$aAccess = Phpfox::getService('forum')->getUserGroupAccess($iForumId, Phpfox::getUserBy('user_group_id'));
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
		
		$this->template()->assign(array(
						'aThreads' => $aThreads,
						'iSearchId' => $this->request()->getInt('search-id'),
						'aCallback' => $aParentModule,
						'sView' => $sView,
						'aPermissions' => $aAccess
					)
				)		
				->setHeader('cache', array(
						'forum.css' => 'style_css',
						'pager.css' => 'style_css',
						'selector.js' => 'static_script'
					)					
				);				

		if ($bIsSearch)
		{			
			if (is_array($aCallback))
			{
				$this->template()
					->setBreadcrumb('Pages', $this->url()->makeUrl('pages'))
					->setBreadcrumb($aCallback['title'], $aCallback['url_home']);					
			}
			else 
			{
				$this->template()->setBreadcrumb(Phpfox::getPhrase('forum.forum'), $this->url()->makeUrl('forum'));
			}
			
			if ($bIsTagSearch)
			{
				$aTag = Phpfox::getService('tag')->getTagInfo('forum', ($bIsModuleTagSearch ? $this->request()->get('req5') : $this->request()->get('req3')));
				if (!empty($aTag['tag_text']))
				{
					if ($bIsModuleTagSearch)
					{
						$this->template()->setBreadcrumb(Phpfox::getPhrase('forum.threads_tagged_with') . ': ' . $aTag['tag_text'], $this->url()->makeUrl('forum.tag.module_group.item_' . $this->request()->get('item') . '.'  . $this->request()->get('req5')), true);
					}
					else
					{
						$this->template()->setBreadcrumb(Phpfox::getPhrase('forum.tags'), $this->url()->makeUrl('forum.tag'))->setBreadcrumb(Phpfox::getPhrase('forum.threads_tagged_with') . ': ' . $aTag['tag_text'], $this->url()->makeUrl('forum.tag.'  . $this->request()->get('req3')), true);
					}
				}
			}
			else 
			{
				if (is_array($aCallback))
				{
					$this->template()->setBreadcrumb(Phpfox::getPhrase('forum.search'), $this->url()->makeUrl('forum.search', array('module' => 'pages', 'item' => $aCallback['group_id'])));
				}
				else 
				{
					$this->template()->setBreadcrumb(Phpfox::getPhrase('forum.search'), $this->url()->makeUrl('forum.search'));	
				}
			}
			
			$this->template()->assign(array(
					'bIsSearch' => true,
					'bResult' => (isset($bForceResult) ? true : $oSearch->get('result')),
					'aForumResults' => $oSearch->get('forum'),
					'bIsTagSearch' => $bIsTagSearch
				)
			);
		}
		else 
		{			
			if (Phpfox::getParam('forum.rss_feed_on_each_forum'))
			{
				if ($aParentModule === null)
				{
					$this->template()->setHeader('<link rel="alternate" type="application/rss+xml" title="' . Phpfox::getPhrase('forum.forum') . ': ' . $aForum['name'] . '" href="' . $this->url()->makeUrl('forum', array('rss', 'forum' => $aForum['forum_id'])) . '" />');
				}
				else 
				{
					$this->template()->setHeader('<link rel="alternate" type="application/rss+xml" title="' . Phpfox::getPhrase('forum.group_forum') . ': ' . $aCallback['title'] . '" href="' . $this->url()->makeUrl('forum', array('rss', 'group' => $aCallback['group_id'])) . '" />');				
				}
			}					
			
			if ($aParentModule === null)
			{			
				if (!Phpfox::getService('forum')->hasAccess($aForum['forum_id'], 'can_view_forum'))
				{
					$this->url()->send('forum');
				}
				
				$this->template()->setTitle(Phpfox::getLib('locale')->convert($aForum['name']))
					->setBreadcrumb($aForum['breadcrumb'])
					->setBreadcrumb(Phpfox::getLib('locale')->convert($aForum['name']), $this->url()->permalink('forum', $aForum['forum_id'], $aForum['name']), true)
					->assign(array(
						'bDisplayThreads' => true,
						'aAnnouncements' => Phpfox::getService('forum.thread')->getAnnoucements($iForumId),
						'aForums' => $aForums,
						'aForumData' => $aForum,
						'bHasCategory' => false,
						'bIsSubForum' => true,
						'bIsSearch' => false,
						'bIsTagSearch' => false
					)
				);
			}
			else 
			{
				$this->template()->setBreadcrumb(Phpfox::getPhrase('forum.forum'), $this->url()->makeUrl(''))
					->setTitle(Phpfox::getPhrase('forum.discussions'))
					->assign(array(
						'bDisplayThreads' => true,						
						'bHasCategory' => false,
						'bIsSubForum' => true,
						'bIsSearch' => false,
						'bIsTagSearch' => false,
						// 'aForumData' => array(),
						'aAnnouncements' => Phpfox::getService('forum.thread')->getAnnoucements(null, isset($aParentModule['item_id']) ? $aParentModule['item_id']: 1)
					)
				);				
			}
		}
		
		if ($bIsSearch && (isset($bForceResult) || $oSearch->get('result')))
		{				
			if (isset($bForceResult))
			{
				$this->setParam('global_moderation', array(
						'name' => 'forumpost',
						'ajax' => 'forum.postModeration',
						'menu' => array(
							array(
								'phrase' => Phpfox::getPhrase('forum.delete'),
								'action' => 'delete'
							),
							array(
								'phrase' => Phpfox::getPhrase('forum.approve'),
								'action' => 'approve'
							)					
						)
					)
				);				
			}
			else
			{
				$this->template()->assign('bIsPostSearch', true);
			}
		}
		else
		{
			$this->setParam('global_moderation', array(
					'name' => 'forum',
					'ajax' => 'forum.moderation',
					'menu' => array(
						array(
							'phrase' => Phpfox::getPhrase('forum.delete'),
							'action' => 'delete'
						),
						array(
							'phrase' => Phpfox::getPhrase('forum.approve'),
							'action' => 'approve'
						)					
					)
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
		(($sPlugin = Phpfox_Plugin::get('forum.component_controller_forum_clean')) ? eval($sPlugin) : false);
	}
}

?>