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
	 * Controller
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

		if (Phpfox::getUserBy('profile_page_id') <= 0 && Phpfox::isModule('privacy'))
		{
			Privacy_Service_Privacy::instance()->check('pages', $aPage['page_id'], $aPage['user_id'], $aPage['privacy'], (isset($aPage['is_friend']) ? $aPage['is_friend'] : 0));
		}		
		
		$bCanViewPage = true;
		// http://www.phpfox.com/tracker/view/15190/
		$sCurrentModule = Phpfox_Url::instance()->reverseRewrite($this->request()->get(($this->request()->get('req1') == 'pages' ? 'req3' : 'req2')));
		
		Phpfox::getService('pages')->buildWidgets($aPage['page_id']);				

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

		/*
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
		*/
		
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
				'pages.js' => 'module_pages'
			)
		);
		
		if (Phpfox::isMobile())
		{
			$this->template()->setBreadcrumb($aPage['title'], Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'], $aPage['vanity_url']), true);
		}

		/*
		$this->setParam('aCallbackShoutbox', array(
				'module' => 'pages',
				'item' => $aPage['page_id']
			)
		);
		*/
		
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

			Phpfox_Module::instance()->resetBlocks();
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
				$this->template()->assign('aPendingUsers', Pages_Service_Pages::instance()->getPendingUsers($aPage['page_id']));
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
