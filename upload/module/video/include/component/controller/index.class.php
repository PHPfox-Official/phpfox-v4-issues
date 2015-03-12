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
 * @package  		Module_Video
 * @version 		$Id: index.class.php 4202 2012-05-31 15:01:29Z Miguel_Espinoza $
 */
class Video_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (defined('PHPFOX_IS_USER_PROFILE') && ($sLegacyTitle = $this->request()->get('req3')) && !empty($sLegacyTitle))
		{			
			Phpfox::getService('core')->getLegacyItem(array(
					'field' => array('video_id', 'title'),
					'table' => 'video',		
					'redirect' => 'video',
					'title' => $sLegacyTitle
				)
			);
		}			
		
		Phpfox::getUserParam('video.can_access_videos', true);
		
		$aParentModule = $this->getParam('aParentModule');			
		
		if (($iRedirectId = $this->request()->getInt('redirect'))
			&& ($aVideo = Phpfox::getService('video')->getVideo($iRedirectId, true))
			&& $aVideo['module_id'] != 'video'
			&& Phpfox::hasCallback($aVideo['module_id'], 'getVideoRedirect')
		)
		{
			if (($sForward = Phpfox::callback($aVideo['module_id'] . '.getVideoRedirect', $aVideo['video_id'])))
			{	
				$this->url()->forward($sForward);
			}
		}
		
		if (($iRedirectId = $this->request()->getInt('redirect')) && ($aVideo = Phpfox::getService('video')->getVideo($iRedirectId, true)))
		{
			$this->url()->send($aVideo['user_name'], array('video', $aVideo['title_url']));
		}
		
		if (($iDeleteId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('video.process')->delete($iDeleteId))
			{
				$this->url()->send('video', null, Phpfox::getPhrase('video.video_successfully_deleted'));
			}
		}
		
		if ($aParentModule === null && $this->request()->getInt('req2'))
		{
			return Phpfox::getLib('module')->setController('video.view');
		}
		
		if ($this->request()->get('req2') == 'category' && ($sLegacyTitle = $this->request()->get('req3')) && !is_numeric($sLegacyTitle) && !empty($sLegacyTitle))
		{
			$aLegacyItem = Phpfox::getService('core')->getLegacyItem(array(
					'field' => array('category_id', 'name'),
					'table' => 'video_category',		
					'redirect' => 'video.category',
					'title' => $sLegacyTitle,
					'search' => 'name_url'
				)
			);		
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
		
		$oServiceVideoBrowse = Phpfox::getService('video.browse');
		$sView = $this->request()->get('view');
		$sCategory = null;		
		$aCallback = false;
		$this->setParam('sTagType', 'video');
		$sAction = (defined('PHPFOX_IS_PAGES_VIEW') ? $aParentModule['url'] . 'video/' : $this->url()->makeUrl('video', array('view' => $this->request()->get('view'))));
		if ( ($sPlugin = Phpfox_Plugin::get('video.component_controller_index_set_action')) && ( eval($sPlugin) === false)){ return false;}
		
		$this->search()->set(array(
				'type' => 'video',
				'field' => 'm.video_id',				
				'search_tool' => array(
					'table_alias' => 'm',
					'search' => array(
						'action' => $sAction,
						'default_value' => Phpfox::getPhrase('video.search_videos'),
						'name' => 'search',
						'field' => 'm.title'
					),
					'sort' => array(
						'latest' => array('m.time_stamp', Phpfox::getPhrase('video.latest')),
						'most-viewed' => array('m.total_view', Phpfox::getPhrase('video.most_viewed')),
						'most-liked' => array('m.total_like', Phpfox::getPhrase('video.most_liked')),
						'most-talked' => array('m.total_comment', Phpfox::getPhrase('video.most_discussed'))
					),
					'show' => array(12, 15, 18, 21)
				)
			)
		);
		
		$aBrowseParams = array(
			'module_id' => 'video',
			'alias' => 'm',
			'field' => 'video_id',
			'table' => Phpfox::getT('video'),
			'hide_view' => array('pending', 'my')				
		);			
		
		$bRunPlugin = false;
		if ( ($sPlugin = Phpfox_Plugin::get('video.component_controller_index_switch_sview')) && ( eval($sPlugin) === false))
		{
			return false;
		}
		switch ($sView)
		{
			case 'pending':
				if (Phpfox::getUserParam('video.can_approve_videos'))
				{
					$this->search()->setCondition('AND m.view_id = 2');
				}
				break;
			case 'my':
				Phpfox::isUser(true);
				$this->search()->setCondition('AND m.user_id = ' . Phpfox::getUserId());
				break;
			default:
				if ($bRunPlugin)
				{
					(($sPlugin = Phpfox_Plugin::get('video.component_controller_index_switch')) ? eval($sPlugin) : false);			
				}
				elseif ($bIsUserProfile)
				{
					$this->search()->setCondition('AND m.in_process = 0 AND m.view_id ' . ($aUser['user_id'] == Phpfox::getUserId() ? 'IN(0,2)' : '= 0') . ' AND m.item_id = 0 AND m.privacy IN(' . (Phpfox::getParam('core.section_privacy_item_browsing') ? '%PRIVACY%' : Phpfox::getService('core')->getForBrowse($aUser)) . ') AND m.user_id = ' . (int) $aUser['user_id']);
				}
				else
				{			
					if (defined('PHPFOX_IS_PAGES_VIEW'))
					{
						$this->search()->setCondition('AND m.in_process = 0 AND m.view_id = 0 AND m.module_id = \'' . Phpfox::getLib('database')->escape($aParentModule['module_id']) . '\' AND m.item_id = ' . (int) $aParentModule['item_id'] . ' AND m.privacy IN(%PRIVACY%)');
					}
					else
					{
						$this->search()->setCondition('AND m.in_process = 0 AND m.view_id = 0 AND m.item_id = 0 AND m.privacy IN(%PRIVACY%)');
					}
				}
				break;
		}
		
		$sTagSearchValue = null;
		if ($this->request()->get('req2') == 'tag' && $this->request()->get('req3'))
		{
			$sCategory = null;
			$sCategoryUrl = '';
			$sTagSearchValue = $this->request()->get('req3');
		}		
		
		if ($this->request()->get('req2') == 'category')
		{
			$sCategory = $this->request()->getInt('req3');
			$this->search()->setCondition('AND mcd.category_id = ' . (int) $sCategory);
		}
		
		$this->setParam('sCategory', $sCategory);
		if ($this->request()->getInt('sponsor') == 1)
		{
		    $this->search()->setCondition('AND m.is_sponsor != 1');
		    Phpfox::addMessage(Phpfox::getPhrase('video.sponsor_help'));
		}
		
		if ($sView == 'featured')
		{
			$this->search()->setCondition('AND m.is_featured = 1');
		}
		
		$oServiceVideoBrowse->category($sCategory)->tag($sTagSearchValue);					
			
		$this->search()->browse()->params($aBrowseParams)->execute();
		
		$aFilterMenu = array();
		$bSetFilterMenu = (!defined('PHPFOX_IS_USER_PROFILE') && !defined('PHPFOX_IS_PAGES_VIEW') );
		if ($sPlugin = Phpfox_Plugin::get('video.component_controller_index_set_filter_menu_1')) 
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
				Phpfox::getPhrase('video.all_videos') => '',
				Phpfox::getPhrase('video.my_videos') => 'my'				
			);					
				
			if (Phpfox::isModule('friend') && !Phpfox::getParam('core.friends_only_community'))
			{
				$aFilterMenu[Phpfox::getPhrase('video.friends_videos')] = 'friend';	
			}			
			
			list($iTotalFeatured, $aFeatured) = Phpfox::getService('video')->getFeatured();
			if ($iTotalFeatured)
			{
				$aFilterMenu[Phpfox::getPhrase('video.featured_videos') . '<span class="pending">' . $iTotalFeatured . '</span>'] = 'featured';
			}			
			
			if (Phpfox::getUserParam('video.can_approve_videos'))
			{
				$iPendingTotal = Phpfox::getService('video')->getPendingTotal();
				
				if ($iPendingTotal)
				{
					$aFilterMenu[Phpfox::getPhrase('video.pending') . (Phpfox::getUserParam('video.can_approve_videos') ? '<span class="pending">' . $iPendingTotal . '</span>' : 0)] = 'pending';
				}
			}
		}					
		
		if (defined('PHPFOX_IS_USER_PROFILE'))
		{
			$this->template()->setMeta('description', Phpfox::getPhrase('video.full_name_s_videos_full_name_has_total_video_s' , array('full_name' => $aUser['full_name'], 'total' => $this->search()->browse()->getCount())));
		}
		
		$this->template()->setTitle(($bIsUserProfile ? Phpfox::getPhrase('video.full_name_s_videos', array('full_name' => $aUser['full_name'])) : Phpfox::getPhrase('video.videos')))
			->setBreadcrumb(Phpfox::getPhrase('video.videos'), (defined('PHPFOX_IS_USER_PROFILE') ? $this->url()->makeUrl($aUser['user_name'], 'video') : ($aCallback === false ? $this->url()->makeUrl('video') : $this->url()->makeUrl($aCallback['url_home'][0], array_merge($aCallback['url_home'][1], array('video'))))))
			->setMeta('keywords', Phpfox::getParam('video.video_meta_keywords'))
			->setMeta('description', Phpfox::getParam('video.video_meta_description'))
			->setHeader('cache', array(
					'pager.css' => 'style_css',
					'video.js' => 'module_video',
					'video.css' => 'module_video'
				)
			)
			->assign(array(
					'aVideos' => $this->search()->browse()->getRows(),
					'sLinkPendingVideos' => $this->url()->makeUrl('video.pending'),
					'sView' => $sView,
					'sPublicPhotoView' => $sView
				)
			);		
		
		$bSetFilterMenu = (!defined('PHPFOX_IS_USER_PROFILE') && !defined('PHPFOX_IS_PAGES_VIEW') );
		if ($sPlugin = Phpfox_Plugin::get('video.component_controller_index_set_filter_menu_2'))
		{
			eval($sPlugin);
			if (isset($mReturnFromPlugin))
			{
				return $mReturnFromPlugin;
			}
		}
		
		if ($bSetFilterMenu)
		{
			$this->template()->buildSectionMenu('video', $aFilterMenu);
		}
			
		if ($sCategory !== null)
		{
			$aCategories = Phpfox::getService('video.category')->getParentBreadcrumb($sCategory);
			$iCnt = 0;
			foreach ($aCategories as $aCategory)
			{
				$iCnt++;
				
				$this->template()->setTitle($aCategory[0]);					

				if ($aCallback !== false)
				{
					$sHomeUrl = '/' . $aCallback['url_home'][0] . '/' . implode('/', $aCallback['url_home'][1]) . '/video/';
					$aCategory[1] = preg_replace('/^http:\/\/(.*?)\/video\/(.*?)$/i', 'http://\\1' . $sHomeUrl . '\\2', $aCategory[1]);
				}

				$this->template()->setBreadcrumb($aCategory[0], $aCategory[1], ($iCnt === count($aCategories) ? true : false));
			}			
		}			
			
		if ($aCallback !== false)
		{
			$this->template()->rebuildMenu('video.index', $aCallback['url_home']);
		}
		
		foreach ((array) $this->search()->browse()->getRows() as $aVideo)
		{
			$this->template()->setMeta('keywords', $this->template()->getKeywords($aVideo['title']));
		}
		
		if (!empty($sTagSearchValue))
		{
			$this->template()->setBreadcrumb(Phpfox::getPhrase('video.topic') . ': ' . $sTagSearchValue, $this->url()->makeUrl('video.tag', $sTagSearchValue), true);
		}
		
		Phpfox::getLib('pager')->set(array('page' => $this->search()->getPage(), 'size' => $this->search()->getDisplay(), 'count' => $this->search()->browse()->getCount()));
		
		$this->setParam('global_moderation', array(
				'name' => 'video',
				'ajax' => 'video.moderation',
				'menu' => array(
					array(
						'phrase' => Phpfox::getPhrase('video.delete'),
						'action' => 'delete'
					),
					array(
						'phrase' => Phpfox::getPhrase('video.approve'),
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
		(($sPlugin = Phpfox_Plugin::get('video.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>