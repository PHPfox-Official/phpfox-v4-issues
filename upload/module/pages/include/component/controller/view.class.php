<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

define('PHPFOX_IS_PAGES_VIEW', true);

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Pages_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('pages.can_view_browse_pages', true);
		
		$mId = $this->request()->getInt('req2');
		
		if (!($aPage = Phpfox::getService('pages')->getForView($mId)))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('pages.the_page_you_are_looking_for_cannot_be_found'));
		}
		if (($this->request()->get('req3')) != '')
		{
			$this->template()->assign(array(
				'bRefreshPhoto' => true
			));
		}
		if (Phpfox::getUserParam('pages.can_moderate_pages') || $aPage['is_admin'])
		{
			
		}
		else
		{
			if ($aPage['view_id'] != '0')
			{
				return Phpfox_Error::display(Phpfox::getPhrase('pages.the_page_you_are_looking_for_cannot_be_found'));
			}
		}
		
		if ($aPage['view_id'] == '2')
		{
			return Phpfox_Error::display(Phpfox::getPhrase('pages.the_page_you_are_looking_for_cannot_be_found'));
		}		
		
		if (Phpfox::isMobile())
		{
			$aPageMenus = Phpfox::getService('pages')->getMenu($aPage);
			
			$aFilterMenu = array();
			foreach ($aPageMenus as $aPageMenu)
			{
				$aFilterMenu[$aPageMenu['phrase']] = $aPageMenu['url'];
			}
			
			$this->template()->buildSectionMenu('pages', $aFilterMenu);
		}
		
		if (Phpfox::getUserBy('profile_page_id') <= 0 && Phpfox::isModule('privacy'))
		{
			Phpfox::getService('privacy')->check('pages', $aPage['page_id'], $aPage['user_id'], $aPage['privacy'], (isset($aPage['is_friend']) ? $aPage['is_friend'] : 0));		
		}		
		
		$bCanViewPage = true;
		// http://www.phpfox.com/tracker/view/15190/
		$sCurrentModule = Phpfox::getLib('url')->reverseRewrite($this->request()->get(($this->request()->get('req1') == 'pages' ? 'req3' : 'req2')));
		
		Phpfox::getService('pages')->buildWidgets($aPage['page_id']);				
		
		if ($aPage['designer_style_id'])
		{
			$this->template()->setStyle(array(
					'style_id' => $aPage['designer_style_id'],
					'style_folder_name' => $aPage['designer_style_folder'],
					'theme_folder_name' => $aPage['designer_theme_folder'],
					'theme_parent_id' => $aPage['theme_parent_id'],
					'total_column' => $aPage['total_column'],
					'l_width' => $aPage['l_width'],
					'c_width' => $aPage['c_width'],
					'r_width' => $aPage['r_width']				
				)
			);
		}		
		
		(($sPlugin = Phpfox_Plugin::get('pages.component_controller_view_build')) ? eval($sPlugin) : false);
		
		
		$this->setParam('aParentModule', array(			
				'module_id' => 'pages',
				'item_id' => $aPage['page_id'],
				'url' => Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'], $aPage['vanity_url'])
			)
		);
		
		if (isset($aPage['is_admin']) && $aPage['is_admin'])
		{
			define('PHPFOX_IS_PAGE_ADMIN', true);
		}
		
		$sModule = $sCurrentModule; // http://www.phpfox.com/tracker/view/15190/
		
		if (empty($sModule) && !empty($aPage['landing_page'])/* && $this->request()->getInt('comment-id') < 1*/)
		{
			$sModule = $aPage['landing_page'];
			$sCurrentModule = $aPage['landing_page'];
		}
		
		(($sPlugin = Phpfox_Plugin::get('pages.component_controller_view_assign')) ? eval($sPlugin) : false);
		
		if (isset($aPage['use_timeline']) && $aPage['use_timeline'])
		{
			$aPageMenus = Phpfox::getService('pages')->getMenu($aPage);
			if (!defined('PAGE_TIME_LINE'))
			{
				define('PAGE_TIME_LINE', true);
			}
			$aPage['user_name'] = $aPage['title'];

			$this->template()->setFullSite()
				->assign(array(
				    'aUser' => $aPage,
				    'aProfileLinks' => $aPageMenus))
				->setHeader(array(
					'<script type="text/javascript">oParams["keepContent4"] = false;</script>'
					));
		}
		
		$this->setParam('aPage', $aPage);
		
		$this->template()			
			->assign(array(
					'aPage' => $aPage,
					'sCurrentModule' => $sCurrentModule,
					'bCanViewPage' => $bCanViewPage,
					'iViewCommentId' => $this->request()->getInt('comment-id'),
					'bHasPermToViewPageFeed' => Phpfox::getService('pages')->hasPerm($aPage['page_id'], 'pages.view_browse_updates')
				)
			)
			->setHeader('cache', array(				
				'profile.css' => 'style_css',
				'pages.css' => 'style_css',
				'pages.js' => 'module_pages',
                'player/flowplayer/flowplayer.js' => 'static_script'
			)
		);
		
		if (Phpfox::isMobile())
		{
			$this->template()->setBreadcrumb($aPage['title'], Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'], $aPage['vanity_url']), true);
		}
		
		$this->setParam('aCallbackShoutbox', array(
				'module' => 'pages',
				'item' => $aPage['page_id']
			)
		);		
		
		if ($bCanViewPage && $sModule && Phpfox::isModule($sModule) && Phpfox::hasCallback($sModule, 'getPageSubMenu') && !$this->request()->getInt('comment-id'))
		{
			if (Phpfox::hasCallback($sModule, 'canViewPageSection') && !Phpfox::callback($sModule . '.canViewPageSection', $aPage['page_id']))
			{
				return Phpfox_Error::display(Phpfox::getPhrase('pages.unable_to_view_this_section_due_to_privacy_settings'));
			}
			
			$this->template()->assign('bIsPagesViewSection', true);
			$this->setParam('bIsPagesViewSection', true);
			$this->setParam('sCurrentPageModule', $sModule);
			
			Phpfox::getComponent($sModule . '.index', array('bNoTemplate' => true), 'controller');
		}
		elseif ($bCanViewPage && $sModule && Phpfox::getService('pages')->isWidget($sModule) && !$this->request()->getInt('comment-id'))
		{
			define('PHPFOX_IS_PAGES_WIDGET', true);
			$this->template()->assign(array(
					'aWidget' => Phpfox::getService('pages')->getWidget($sModule)
				)
			);
		}
		else
		{
			$bCanPostComment = true;
			if ($sCurrentModule == 'pending')
			{
				$this->template()->assign('aPendingUsers', Phpfox::getService('pages')->getPendingUsers($aPage['page_id']));
				$this->setParam('global_moderation', array(
						'name' => 'pages',
						'ajax' => 'pages.moderation',
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
			}
			
			if (Phpfox::getService('pages')->isAdmin($aPage))
			{
				define('PHPFOX_FEED_CAN_DELETE', true);
			}
			
			if (Phpfox::getUserId())
			{
				$bIsBlocked = Phpfox::getService('user.block')->isBlocked($aPage['user_id'], Phpfox::getUserId());
				if ($bIsBlocked)
				{
					$bCanPostComment = false;
				}
			}			
			
			// http://www.phpfox.com/tracker/view/15316/
			if($sCurrentModule != 'info')
			{
				define('PHPFOX_IS_PAGES_IS_INDEX', true);
			}

			$this->setParam('aFeedCallback', array(
					'module' => 'pages',
					'table_prefix' => 'pages_',
					'ajax_request' => 'pages.addFeedComment',
					'item_id' => $aPage['page_id'],
					'disable_share' => ($bCanPostComment ? false : true),
					'feed_comment' => 'pages_comment'				
				)
			);			
			if (isset($aPage['text']) && !empty($aPage['text']))
			{
				$this->template()->setMeta('description', $aPage['text']);
			}
			$this->template()->setTitle($aPage['title'])
				->setEditor()
				->setHeader('cache', array(
						'jquery/plugin/jquery.highlightFade.js' => 'static_script',	
						'jquery/plugin/jquery.scrollTo.js' => 'static_script',
						'quick_edit.js' => 'static_script',
						'comment.css' => 'style_css',
						'pager.css' => 'style_css',
						'index.css' => 'module_pages',
						'feed.js' => 'module_feed'						
					)
				);

			if (Phpfox::getParam('video.convert_servers_enable'))
			{
				$this->template()->setHeader('<script type="text/javascript">document.domain = "' . Phpfox::getParam('video.convert_js_parent') . '";</script>');
			}

			if ($sModule == 'designer' && $aPage['is_admin'])
			{
				Phpfox::getUserParam('pages.can_design_pages', true);
				define('PHPFOX_IN_DESIGN_MODE', true);
				define('PHPFOX_CAN_MOVE_BLOCKS', true);		
				
				if (($iTestStyle = $this->request()->get('test_style_id')))
				{
					if (Phpfox::getLib('template')->testStyle($iTestStyle))
					{
						
					}
				}
				
				$aDesigner = array(
					'current_style_id' => $aPage['designer_style_id'],
					'design_header' => 'Customize Page',
					'current_page' => Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'], $aPage['vanity_url']),
					'design_page' => Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'], $aPage['vanity_url']) . 'designer/',
					'block' => 'pages.view',				
					'item_id' => $aPage['page_id'],
					'type_id' => 'pages'
				);
				
				$this->setParam('aDesigner', $aDesigner);	
				
				$this->template()->setHeader('cache', array(
								'jquery/ui.js' => 'static_script',
								'sort.js' => 'module_theme',
								'style.css' => 'style_css',
								'select.js' => 'module_theme',
								'design.js' => 'module_theme'							
							)					
						)
						->setHeader(array(
							'<script type="text/javascript">$Behavior.pages_controller_view_designonuptade = function() { function designOnUpdate() { $Core.design.updateSorting(); } };</script>',		
							'<script type="text/javascript">$Behavior.pages_controller_view_design_init = function() { $Core.design.init({type_id: \'pages\', item_id: \'' . $aPage['page_id'] . '\'}); };</script>'
							)
						)
						->assign('sCustomDesignId', $aPage['page_id']
					);
			}				
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('pages.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>
