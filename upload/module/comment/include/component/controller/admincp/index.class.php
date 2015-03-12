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
 * @version 		$Id: index.class.php 3826 2011-12-16 12:30:19Z Raymond_Benc $
 */
class Comment_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('comment.can_moderate_comments', true);
		
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
				'alias' => 'cmt'
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
				'type' => 'comments',
				'filters' => $aFilters,
				'search' => 'search'
			)
		);		
		
		if ($this->request()->get('view') == 'approval')
		{
			$oSearch->setCondition('AND cmt.view_id = 1');
		}
		else 
		{
			$oSearch->setCondition('AND cmt.view_id = 9');
		}

		list($iCnt, $aComments) = Phpfox::getService('comment')->get('cmt.*', $oSearch->getConditions(), $oSearch->getSort(), $oSearch->getPage(), $oSearch->getDisplay(), null, true);
		
		foreach ($aComments as $iKey => $aComment)
		{
			if (Phpfox::hasCallback($aComment['type_id'], 'getItemName'))
			{
				$aComments[$iKey]['item_name'] = Phpfox::callback($aComment['type_id'] . '.getItemName', $aComment['comment_id'], $aComment['owner_full_name']);
			}
		}
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $oSearch->getDisplay(), 'count' => $oSearch->getSearchTotal($iCnt)));		
		
		$this->template()->setTitle(Phpfox::getPhrase('comment.comment_title'))
			->setBreadcrumb(Phpfox::getPhrase('comment.comment_title'), $this->url()->makeUrl('admincp.comment'))
			->setHeader('cache', array(
					'comment.css' => 'style_css',
					'pager.css' => 'style_css',
				)
			)
			->assign(array(
					'aComments' => $aComments,
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
		(($sPlugin = Phpfox_Plugin::get('comment.component_controller_admincp_spam_clean')) ? eval($sPlugin) : false);
	}
}

?>