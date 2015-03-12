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
 * @version 		$Id: index.class.php 5948 2013-05-24 08:26:41Z Miguel_Espinoza $
 */
class Pages_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$bIsUserProfile = $this->getParam('bIsProfile');
		if ($bIsUserProfile)
		{
			$aUser = $this->getParam('aUser');
		}
		Phpfox::getUserParam('pages.can_view_browse_pages', true);
		
		if ($this->request()->getInt('req2') > 0)
		{
			Phpfox::getLib('module')->setCacheBlockData(array(
					'table' => 'pages_design_order',
					'field' => 'page_id',
					'item_id' => $this->request()->getInt('req2'),
					'controller' => 'pages.view'
				)
			);			
			
			return Phpfox::getLib('module')->setController('pages.view');			
		}	
		
		if (($iDeleteId = $this->request()->getInt('delete')) && Phpfox::getService('pages.process')->delete($iDeleteId))
		{
			$this->url()->send('pages', array(), Phpfox::getPhrase('pages.page_successfully_deleted'));
		}
		
		$sView = $this->request()->get('view');
		
		if (defined('PHPFOX_IS_AJAX_CONTROLLER'))
		{
			$bIsProfile = true;
			$aUser = Phpfox::getService('user')->get($this->request()->get('profile_id'));
			$this->setParam('aUser', $aUser);
		}
		else 
		{		
			$bIsProfile = $this->getParam('bIsProfile');	
			if ($bIsProfile === true)
			{
				$aUser = $this->getParam('aUser');
			}
		}		
		
        if ($bIsProfile)
        {
            $this->template()
                    ->setTitle(Phpfox::getPhrase('pages.full_name_s_pages', array('full_name' => $aUser['full_name'])))
                    ->setBreadcrumb(Phpfox::getPhrase('pages.pages'), $this->url()->makeUrl($aUser['user_name'], array('pages')) );
        }
        else
        {
            $this->template()
                    ->setTitle(Phpfox::getPhrase('pages.pages'))
                    ->setBreadcrumb(Phpfox::getPhrase('pages.pages'), $this->url()->makeUrl('pages'));
        }
            
		$this->search()->set(array(
				'type' => 'pages',
				'field' => 'pages.page_id',				
				'search_tool' => array(
					'table_alias' => 'pages',
					'search' => array(
						'action' => ($bIsProfile === true ? $this->url()->makeUrl($aUser['user_name'], array('pages', 'view' => $this->request()->get('view'))) : $this->url()->makeUrl('pages', array('view' => $this->request()->get('view')))),
						'default_value' => Phpfox::getPhrase('pages.search_pages'),
						'name' => 'search',
						'field' => 'pages.title'
					),
					'sort' => array(
						'latest' => array('pages.time_stamp', Phpfox::getPhrase('pages.latest')),
						'most-liked' => array('pages.total_like', Phpfox::getPhrase('pages.most_liked'))						
					),
					'show' => array(10, 15, 20)
				)
			)
		);				
		
		$aBrowseParams = array(
			'module_id' => 'pages',
			'alias' => 'pages',
			'field' => 'page_id',
			'table' => Phpfox::getT('pages'),
			'hide_view' => array('pending', 'my')				
		);			
		
		$aFilterMenu = array();
		if (!defined('PHPFOX_IS_USER_PROFILE'))
		{
			$aFilterMenu = array(
				Phpfox::getPhrase('pages.all_pages') => '',
				Phpfox::getPhrase('pages.my_pages') => 'my'							
			);
			
			if (!Phpfox::getParam('core.friends_only_community') && Phpfox::isModule('friend') && !Phpfox::getUserBy('profile_page_id'))
			{
				$aFilterMenu[Phpfox::getPhrase('pages.friends_pages')] = 'friend';	
			}	
			
			if (Phpfox::getUserParam('pages.can_moderate_pages'))
			{
				$iPendingTotal = Phpfox::getService('pages')->getPendingTotal();
				
				if ($iPendingTotal)
				{
					$aFilterMenu['' . Phpfox::getPhrase('pages.pending_pages') . '<span class="pending">' . $iPendingTotal . '</span>'] = 'pending';
				}
			}				
		}
		
		switch ($sView)
		{
			case 'my':
				Phpfox::isUser(true);
				$this->search()->setCondition('AND pages.app_id = 0 AND pages.view_id IN(0,1) AND pages.user_id = ' . Phpfox::getUserId());
				break;
			case 'pending':
				Phpfox::isUser(true);
				if (Phpfox::getUserParam('pages.can_moderate_pages'))
				{
					$this->search()->setCondition('AND pages.app_id = 0 AND pages.view_id = 1');
				}				
				break;			
			default:
				if (Phpfox::getUserParam('privacy.can_view_all_items'))
				{
					$this->search()->setCondition('AND pages.app_id = 0 ');  
				}
				else
				{
				    $this->search()->setCondition('AND pages.app_id = 0 AND pages.view_id = 0 AND pages.privacy IN(%PRIVACY%)');
				}
				break;
		}		
		
		$this->template()->buildSectionMenu('pages', $aFilterMenu);
		$bIsValidCategory = false;
		
		if ($this->request()->get('req2') == 'category' && ($iCategoryId = $this->request()->getInt('req3')) && ($aType = Phpfox::getService('pages.type')->getById($iCategoryId)))
		{
			$bIsValidCategory = true;
			$this->setParam('iCategory', $iCategoryId);
			$this->template()->setBreadcrumb(Phpfox::getLib('locale')->convert($aType['name']), Phpfox::permalink('pages.category', $aType['type_id'], $aType['name']) . ($sView ? 'view_' . $sView . '/' . '' : ''), true);
		}
		
		if ($this->request()->get('req2') == 'sub-category' && ($iSubCategoryId = $this->request()->getInt('req3')) && ($aCategory = Phpfox::getService('pages.category')->getById($iSubCategoryId)))
		{
			$bIsValidCategory = true;
			$this->setParam('iCategory', $aCategory['type_id']);
			$this->template()->setBreadcrumb(Phpfox::getLib('locale')->convert($aCategory['type_name']), Phpfox::permalink('pages.category', $aCategory['type_id'], $aCategory['type_name']) . ($sView ? 'view_' . $sView . '/' . '' : ''));
			$this->template()->setBreadcrumb(Phpfox::getLib('locale')->convert($aCategory['name']), Phpfox::permalink('pages.sub-category', $aCategory['category_id'], $aCategory['name']) . ($sView ? 'view_' . $sView . '/' . '' : ''), true);
		}
		
		if (isset($aType['type_id']))
		{
			$this->search()->setCondition('AND pages.type_id = ' . (int) $aType['type_id']);
		}
		
		if (isset($aType['category_id']))
		{
			$this->search()->setCondition('AND pages.category_id = ' . (int) $aType['category_id']);
		}
		elseif	(isset($aCategory['category_id']))
		{
			$this->search()->setCondition('AND pages.category_id = ' . (int) $aCategory['category_id']);
		}		
		
		if ($bIsUserProfile)
		{
			$this->search()->setCondition('AND pages.user_id = ' . (int) $aUser['user_id']);
		}
		
		$this->search()->browse()->params($aBrowseParams)->execute();
		
		$aPages = $this->search()->browse()->getRows();
		
		foreach ($aPages as $iKey => $aPage)
		{
			if (!isset($aPage['vanity_url']) || empty($aPage['vanity_url']))
			{
				$aPages[$iKey]['url'] = Phpfox::permalink('pages', $aPage['page_id'], $aPage['title']);
			}
			else
			{
				$aPages[$iKey]['url'] = $aPage['vanity_url'];
			}
		}
		
		Phpfox::getLib('pager')->set(array('page' => $this->search()->getPage(), 'size' => $this->search()->getDisplay(), 'count' => $this->search()->browse()->getCount()));		
		
		$this->template()->setHeader('cache', array(
					'comment.css' => 'style_css',
					'pager.css' => 'style_css',
					'feed.js' => 'module_feed',
					'pages.js' => 'module_pages'
				)
			)
			->assign(array(
					'sView' => $sView,
					'aPages' => $aPages
				)
			);
			
		
		$this->setParam('global_moderation', array(
				'name' => 'pages',
				'ajax' => 'pages.pageModeration',
				'menu' => array(
					array(
						'phrase' => Phpfox::getPhrase('pages.delete'),
						'action' => 'delete'
					),
					array(
						'phrase' => Phpfox::getPhrase('pages.approve'),
						'action' => 'approve'
					)					
				)
			)
		);
				
				
		$iStartCheck = 0;
		if ($bIsValidCategory == true)
		{
			$iStartCheck = 5;
		}
		$aRediAllow = array('category');
		if (defined('PHPFOX_IS_USER_PROFILE') && PHPFOX_IS_USER_PROFILE)
		{
			$aRediAllow[] = 'pages';
		}
		$aCheckParams = array(
			'url' => $this->url()->makeUrl('pages'),
			'start' => $iStartCheck,
			'reqs' => array(
					'2' => $aRediAllow
				)
			);
		
		if (Phpfox::getParam('core.force_404_check') && !Phpfox::getService('core.redirect')->check404($aCheckParams))
		{
			return Phpfox::getLib('module')->setController('error.404');
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('pages.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>