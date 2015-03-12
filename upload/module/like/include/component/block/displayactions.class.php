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
 * @version 		$Id: browse.class.php 4205 2012-06-04 08:52:29Z Raymond_Benc $
 */
class Like_Component_Block_Displayactions extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!Phpfox::getParam('like.allow_dislike'))
		{
			return false;
		}
		
			/* Needed because in threaded comments it was taking the parent feed instead of the child comments */
		if ($this->getParam('aChildFeed') != null)
		{
			$aFeed = $this->getParam('aChildFeed');
		}
		else
		{
			$aFeed = $this->getParam('aFeed');
		}
		// d('---------------------------------------');		d($aFeed);
		if (empty($aFeed))
		{
			return false;
		}
		if (isset($aFeed['total_dislike']) && $aFeed['total_dislike'] < 1)
		{
			
			//return false;
		}
		
		
		if (!isset($aFeed['type_id']) && isset($aFeed['like_type_id']))
		{
			$aFeed['type_id'] = $aFeed['like_type_id'];
		}
		
		
		// Calls from the relationship changes are custom-relation, there should not be any type that is just custom.
		if ($aFeed['type_id'] == 'custom')
		{
		    return false;
		}
		
		if (isset($aFeed['dislike_phrase']))
		{			
			if (empty($aFeed['dislike_phrase']))
			{
				return false;
			}
			$aActions = array(array('phrase' => $aFeed['dislike_phrase']));
		}
		else
		{
			if ($aFeed['type_id'] == 'user_status' && isset($aFeed['comment_id']) && Phpfox::getParam('comment.comment_is_threaded'))
			{
				// this is a nested comment
				return false;
				$aCallback = Phpfox::callback('comment.getActions');
				if (!isset($aCallback['item_type_id']))
				{
					$aCallback['item_type_id'] = 'feed';
				}
				$aFeed['type_id'] = $aCallback['item_type_id'];
				$aFeed['item_id'] = $aFeed['comment_id'];
			}
			
			if ($aFeed['type_id'] == 'feed_comment')
			{
				$aFeed['type_id'] = 'feed-comment';
			}
			
			$aActions = Phpfox::getService('like')->getActionsFor($aFeed['type_id'], $aFeed['item_id']);
		}
		
		if (empty($aActions))
		{
			return false;
		}
		
		if (isset($aFeed['item_id']))
		{
			$aActions['like_item_id'] = $aFeed['item_id'];
		}
		else if (isset($aFeed['like_item_id']))
		{
			$aActions['like_item_id'] = $aFeed['like_item_id'];
		}
		
		
		
		if (Phpfox::getParam('like.show_user_photos'))
		{
			$this->template()->assign(array(
					'iCount' => $aActions[2]['total_votes_combined'],
					'sType' => $aFeed['type_id'],
					'iId' => $aActions['like_item_id']
				)
			);
		}
		else
		{
			$this->template()->assign(array(
					'aActions' => $aActions
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
		(($sPlugin = Phpfox_Plugin::get('like.component_block_browse_clean')) ? eval($sPlugin) : false);
	}
}

?>