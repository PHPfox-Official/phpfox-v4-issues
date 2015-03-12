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
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Forum_Component_Controller_Search extends Phpfox_Component
{	
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		Phpfox::getUserParam('forum.can_view_forum', true);
		
		$sView = $this->request()->get('view');
		
		$aCallback = false;
		if ($this->request()->get('item'))
		{		
			$aGroup = Phpfox::getService('pages')->getPage($this->request()->get('item'), true);
				
			if (isset($aGroup['page_id']))
			{
				$aCallback = array(
						'group_id' => $aGroup['page_id'],
						'url_home' => Phpfox::getService('pages')->getUrl($aGroup['page_id'], $aGroup['title'], $aGroup['vanity_url']),
						'title' => $aGroup['title']						
					);
				
				$this->setParam('aCallback',$aCallback);	
			}		
		}

		if ($aCallback === false)
		{
			Phpfox::getService('forum')->buildMenu();
		}
		
		if ($this->request()->getArray('search') || $this->request()->get('search-id') || !empty($sView))
		{
			$this->template()->setFullSite();
			$this->setParam('bIsSearchQuery', true);
			
			return Phpfox::getLib('module')->setController('forum.forum');
		}
		
		Phpfox::getService('forum')->getSearchFilter();
		
		if (is_array($aCallback))
		{
			$this->template()
				->setBreadcrumb('Pages', $this->url()->makeUrl('pages'))
				->setBreadcrumb($aCallback['title'], $aCallback['url_home'])
				->setBreadcrumb(Phpfox::getPhrase('forum.search'), $this->url()->makeUrl('forum.search', array('module' => 'pages', 'item' => $aCallback['group_id'])), true);
		}
		else 
		{
			$this->template()->setTitle(Phpfox::getPhrase('forum.search'))
				->setBreadcrumb(Phpfox::getPhrase('forum.forum'), $this->url()->makeUrl('forum'))
				->setBreadcrumb(Phpfox::getPhrase('forum.search'), $this->url()->makeUrl('forum.search'));
		}
		
		$this->template()
				->setHeader('cache', array(
						'pager.css' => 'style_css'
					)
				)
				->assign(array(
					'sForumList' => ($aCallback === false ? Phpfox::getService('forum')->active($this->request()->get('id'))->getJumpTool(true) : ''),
					'iSearchId' => $this->request()->get('id'),
					'aCallback' => $aCallback
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_controller_search_clean')) ? eval($sPlugin) : false);
	}
}

?>