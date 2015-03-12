<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');


/**
 * Viewing of comments on items such as blogs, images, profiles etc...
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Comment
 * @version 		$Id: view.class.php 2217 2010-11-29 12:33:01Z Raymond_Benc $
 */
class Comment_Component_Block_View extends Phpfox_Component 
{
	/**
	 * Store all comments into this array
	 *
	 * @var array
	 */
	private $_aComments = array();
	
	private $_aChildComments = array();
		
	/**
	 * Process page and display comments
	 *
	 * @return bool Only when in threaded mode we return false to not display the template
	 */
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		// Set page vars
		$oComment = Phpfox::getService('comment');
		$sType = $this->getParam('sType');
		$iItemId = $this->getParam('iItemId');		
		$iPage = $this->request()->get('page');
		$iOriginalCnt = $this->getParam('iTotal', 0);
		$iViewId = $this->getParam('iViewId', 0);
		$iPageSize = Phpfox::getParam('comment.comment_page_limit');
		$aRows = array();	
		$bCanPostOnItem = Phpfox::getUserParam(Phpfox::callback($sType . '.getAjaxCommentVar'));
		
		if ($sType == 'group' && !Phpfox::getService('group')->hasAccess($iItemId, 'can_use_comments'))
		{			
			$bCanPostOnItem = false;
		}
		
		if ($sType == 'group' && !Phpfox::getService('group')->hasAccess($iItemId, 'can_use_comments', true))
		{
			$bCanPostOnItem = false;
		}		
		
		if (PHPFOX_IS_AJAX)
		{
			$aRequests = $this->request()->getRequests();
			foreach ($aRequests as $sKey => $sValue)
			{
				if (!preg_match("/req[0-9]/", $sKey))
				{
					continue;
				}
				
				$this->url()->setParam($sKey, $sValue);
			}
		}		
		
		if (!$iOriginalCnt)
		{
			$iCnt = 0;
		}
		
		if ($iOriginalCnt || Phpfox::getUserParam('comment.can_moderate_comments'))
		{	
			if (Phpfox::getUserParam('comment.can_moderate_comments'))
			{				
				$aSql = array(
					(Phpfox::getParam('comment.comment_is_threaded') ? 'AND cmt.parent_id = 0' : ''),
					"AND cmt.type_id = '" . Phpfox::getLib('database')->escape($sType) . "'",
					'AND cmt.item_id = ' . (int) $iItemId							
				);				
			}
			else 
			{
				$aSql = array(
					(Phpfox::getParam('comment.comment_is_threaded') ? 'AND cmt.parent_id = 0' : ''),
					"AND cmt.type_id = '" . Phpfox::getLib('database')->escape($sType) . "'",
					'AND cmt.item_id = ' . (int) $iItemId,
					'AND cmt.view_id = ' . (int) $iViewId				
				);
			}
			
			if ($iCommentId = $this->request()->getInt('comment'))
			{
				if (count($aSql) && count($aSql) > 2)
				{
					unset($aSql[0]);
				}				
				$aSql[] = 'AND cmt.comment_id = ' . $iCommentId;
			}		
			
			// Get the comments for this page
			list($iCnt, $this->_aComments) = $oComment->get('cmt.*', $aSql, 'cmt.time_stamp DESC', $iPage, $iPageSize, ((Phpfox::getParam('comment.comment_is_threaded') || Phpfox::getUserParam('comment.can_moderate_comments')) ? null : $iOriginalCnt));			
		}
		
		// Threaded mode?
		if (Phpfox::getParam('comment.comment_is_threaded'))
		{			
			if (count($this->_aComments))
			{
				foreach ($this->_aComments as $iKey => $aComment)
				{
					unset($this->_aComments[$iKey]);
					
					$this->_aComments[$aComment['comment_id']] = $aComment;
				}
				
				$sComments = '';
				foreach ($this->_aComments as $aComment)
				{
					if ($aComment['child_total'])
					{
						$sComments .= $aComment['comment_id'] . ',';
					}
				}
				$sComments = rtrim($sComments, ',');
				
				if (!empty($sComments))
				{
					list($iChildCnt, $this->_aChildComments) = $oComment->get('cmt.*', array('cmt.parent_id IN(' . $sComments. ') AND cmt.view_id = ' . (int) $iViewId), 'cmt.time_stamp DESC');
					foreach ($this->_aChildComments as $aChildComment)
					{
						$this->_aComments[$aChildComment['parent_id']]['childrens'][] = $aChildComment;
					}
					
					unset($this->_aChildComments);
				}				
			}				

			// Set the pager
			Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'ajax' => 'comment.browse', 'aParams' => array(
						'sType' => $sType,
						'iItemId' => $iItemId,
						'iTotal' => $iCnt
					)
				)
			);		
			
			$this->template()->assign(array(
					'bCanPostOnItem' => $bCanPostOnItem,
					'sType' => $sType,
					'iTotalComments' => ($iOriginalCnt === null ? $iCnt : $iOriginalCnt),
					'aRows' => $this->_aComments,
					'sLoginLink' => $this->url()->makeUrl('user.login'),
					'sSignupLink' => $this->url()->makeUrl('user.register'),					
				)
			);	
			
			// Display the comments
			$sBlockViewTemplate = 'comment.block.view';
			
			(($sPlugin = Phpfox_Plugin::get('comment.component_block_view_process_template_load')) ? eval($sPlugin) : false);
			
			$this->template()->getTemplate('comment.block.view-top');
			if (count($this->_aComments))
			{
				$this->_displayComment($this->_aComments);
			}
			else 
			{
				$this->template()->getTemplate($sBlockViewTemplate);	
			}
			$this->template()->getTemplate('comment.block.view-bottom');
			
			// Plugin call
			(($sPlugin = Phpfox_Plugin::get('comment.component_block_view_process')) ? eval($sPlugin) : false);
			
			return false;		
		}		
		else 
		{
			// Set the pager
			Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'ajax' => 'comment.browse', 'aParams' => array(
						'sType' => $sType,
						'iItemId' => $iItemId,
						'iTotal' => $iCnt
					)
				)
			);
			
			// Assign template vars
			$this->template()->assign(array(
					'aRows' => $this->_aComments,
					'sLoginLink' => $this->url()->makeUrl('user.login'),
					'sSignupLink' => $this->url()->makeUrl('user.register'),
					'bCanPostOnItem' => $bCanPostOnItem,
					'iTotalComments' => ($iOriginalCnt === null ? $iCnt : $iOriginalCnt)
				)
			);		
			
			// Plugin call
			(($sPlugin = Phpfox_Plugin::get('comment.component_block_view_process')) ? eval($sPlugin) : false);
		}
	}
	
	/**
	 * Clean template vars
	 *
	 */
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('comment.component_block_view_clean')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Display threaded comments
	 *
	 * @param array $aRows is the array of comments we will display
	 */
	private function _displayComment(&$aRows, $bChild = false)
	{		
		Phpfox::getLib('parse.output')->setImageParser(array('width' => 500, 'height' => 500));
		foreach ($aRows as $aRow)
		{		
			// Assign template vars for this comment.			
			$this->template()->assign(array(
					'aRow' => $aRow,
					'bChild' => $bChild
				)
			);	
			
			// Display the comment	
			echo $this->template()->getTemplate('comment.block.entry', true);
			
			// Do we have any children for this comment?
			if (isset($aRow['childrens']) && count($aRow['childrens']) > 0)
			{
				// Display children a little to the right
				echo '<div style="margin-left:30px;">' . "\n";
				$this->_displayComment($aRow['childrens'], true) . "\n";
				echo '</div>' . "\n";
			}
		}
		Phpfox::getLib('parse.output')->setImageParser(array('clear' => true));
	}		
}

?>