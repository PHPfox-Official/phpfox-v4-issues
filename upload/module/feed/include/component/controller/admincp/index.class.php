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
 * @version 		$Id: index.class.php 3731 2011-12-08 11:15:54Z Miguel_Espinoza $
 */
class Feed_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		return Phpfox_Error::display('This section has been depreciated');
		Phpfox::getUserParam('comment.can_moderate_comments', true);
		
		if (($aIds = $this->request()->getArray('id')))
		{
			if ($this->request()->get('approve'))
			{
				foreach ($aIds as $iId)
				{
					Phpfox::getService('feed.process')->approve($iId);	
				}
				
				$this->url()->send('admincp.feed', array('view' => 'approval'), Phpfox::getPhrase('feed.profile_comment_s_successfully_approved'));
			}
			else 
			{
				foreach ($aIds as $iId)
				{
					Phpfox::getService('feed.process')->deleteFeed($iId);	
				}
				
				$this->url()->send('admincp.feed', array('view' => 'approval'), Phpfox::getPhrase('feed.profile_comment_s_successfully_deleted'));
			}
		}
		
		$iPage = $this->request()->getInt('page');
		
		$aPages = array(20, 30, 40, 50);
		$aDisplays = array();
		foreach ($aPages as $iPageCnt)
		{
			$aDisplays[$iPageCnt] = Phpfox::getPhrase('core.per_page', array('total' => $iPageCnt));
		}
				
		$aFilters = array(
			'search' => array(
				'type' => 'input:text',
				'search' => "AND ls.name LIKE '%[VALUE]%'"
			),						
			'display' => array(
				'type' => 'select',
				'options' => $aDisplays,
				'default' => '20'
			),
			'sort' => array(
				'type' => 'select',
				'options' => array(
					'time_stamp' => Phpfox::getPhrase('comment.last_activity'),
					'rating ' => Phpfox::getPhrase('comment.rating')
				),
				'default' => 'time_stamp',
				'alias' => 'feed'
			),
			'sort_by' => array(
				'type' => 'select',
				'options' => array(
					'DESC' => Phpfox::getPhrase('core.descending'),
					'ASC' => Phpfox::getPhrase('core.ascending')
				),
				'default' => 'DESC'
			)
		);		
		
		$oSearch = Phpfox::getLib('search')->set(array(
				'type' => 'feeds',
				'filters' => $aFilters,
				'search' => 'search'
			)
		);		
		
		$oSearch->setCondition('AND feed.view_id = 1');

		list($iCnt, $aFeeds) = Phpfox::getService('feed')->getForBrowse($oSearch->getConditions(), $oSearch->getSort(), $oSearch->getPage(), $oSearch->getDisplay());		
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $oSearch->getDisplay(), 'count' => $oSearch->getSearchTotal($iCnt)));		
		
		$this->template()->setTitle(Phpfox::getPhrase('comment.comment_title'))
			->setBreadcrumb(Phpfox::getPhrase('comment.comment_title'), $this->url()->makeUrl('admincp.comment'))
			->setHeader('cache', array(				
					'comment.css' => 'style_css',	
					'pager.css' => 'style_css'
				)
			)
			->assign(array(
					'aFeeds' => $aFeeds,
					'bIsCommentAdminPanel' => true					
				)
			);					
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('feed.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>