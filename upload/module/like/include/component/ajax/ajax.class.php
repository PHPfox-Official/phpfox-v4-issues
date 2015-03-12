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
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 6409 2013-08-01 14:54:51Z Raymond_Benc $
 */
class Like_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function add()
	{
		Phpfox::isUser(true);
        if (Phpfox::getService('like')->hasBeenMarked(2, $this->get('type_id'), $this->get('item_id')))
        {
			
            $this->removeAction();
        }
		if (Phpfox::getService('like.process')->add($this->get('type_id'), $this->get('item_id')))
		{
			if ($this->get('type_id') == 'feed_mini' && $this->get('custom_inline'))
			{
				$this->_loadCommentLikes();
			}
			else
			{
				/* When clicking "Like" from the Feed */
				$this->_loadLikes(true);
				if (!$this->get('counterholder'))
				{
				 //   $this->call('$("#js_like_body_'. $this->get('item_id') . '").parents().map( function() { $(this).show(); });');
				}
			}
			if (!$this->get('counterholder'))
			{
			    $this->call('$Core.loadInit();');
			}
		}
	}
	
	public function delete()
	{
		Phpfox::isUser(true);
		
		if (Phpfox::getService('like.process')->delete($this->get('type_id'), $this->get('item_id'), (int) $this->get('force_user_id')))
		{
			if ($this->get('type_id') == 'pages' && (int) $this->get('force_user_id') > 0)
			{
				$this->remove('#js_row_like_' . (int) $this->get('force_user_id'));
			}
			else
			{
				if ($this->get('type_id') == 'feed_mini' && $this->get('custom_inline'))
				{
					$this->_loadCommentLikes();	
				}
				else
				{
					$this->_loadLikes(false);
				}
			}
		}
	}

	public function browse()
	{				
		$this->error(false);
		Phpfox::getBlock('like.browse');
		$sTitle = (($this->get('type_id') == 'pages' && $this->get('force_like') == '') ? Phpfox::getPhrase('like.members') : Phpfox::getPhrase('like.people_who_like_this'));
		if ($this->get('dislike') == 1)
		{
			$sTitle = Phpfox::getPhrase('like.people_who_disliked_this');
		}
		
		$this->setTitle($sTitle);
	}
	
	private function _loadCommentLikes($bIsDislike = false)
	{
		if ($bIsDislike == true)
		{
			// get the total dislikes
			// $iDislikes = Phpfox::getService('like')->getDislikes($this->get('item_type_id'), $this->get('item_type_id'), true);
			$aComment = Phpfox::getService('comment')->getComment($this->get('item_id'));
			$iDislikes = $aComment['total_dislike'];
			$sCall = '$("#js_comment_' . $this->get('item_id') . '").find(".comment_mini_action:first").find(".js_dislike_link_holder").show();';
			
			if ($iDislikes > 1)
			{
				$sPhrase = Phpfox::getPhrase('like.total_people', array('total' => $iDislikes));				
			}
			else if ($iDislikes > 0)
			{
				$sPhrase = Phpfox::getPhrase('like.1_person');				
			}
			else
			{
				$sCall = '$(\'#js_comment_' . $this->get('item_id') . '\').find(\'.comment_mini_action:first\').find(\'.js_dislike_link_holder\').hide();';
				$sPhrase = '0';
			}
			$sCall .= '$("#js_dislike_mini_a_'. $this->get('item_id') .'").html("'. $sPhrase .'");';
			$this->call($sCall);
		}
		else
		{
			$aComment = Phpfox::getService('comment')->getComment($this->get('item_id'));
			if ($this->get('counterholder'))
			{
				$this->call('$("#' . $this->get('counterholder') . '_counter_' . $this->get('item_id') . '").html(' . $aComment['total_like'] . ');');
				return;
			}
			if ($aComment['total_like'] > 0)
			{
				$sPhrase = Phpfox::getPhrase('like.1_person');
				if ($aComment['total_like'] > 1)
				{
					$sPhrase = Phpfox::getPhrase('like.total_people', array('total' => $aComment['total_like']));
				}
				$this->call('$(\'#js_comment_' . $this->get('item_id') . '\').find(\'.comment_mini_action:first\').find(\'.js_like_link_holder\').show();');
				$this->call('$(\'#js_comment_' . $this->get('item_id') . '\').find(\'.comment_mini_action:first\').find(\'.js_like_link_holder_info\').html(\'' . $sPhrase . '\');');
			}
			else 
			{
				$this->call('$(\'#js_comment_' . $this->get('item_id') . '\').find(\'.comment_mini_action:first\').find(\'.js_like_link_holder\').hide();');
			}
		}
	}
	
	private function _loadLikes($bIsLiked)
	{
		$sType = $this->get('type_id');
		if (empty($sType))
		{
			$sType = $this->get('item_type_id');
		}
		
		if (Phpfox::getParam('like.show_user_photos'))
		{
			// The block like.block.display works very different if this setting is enabled
			$aLikes = Phpfox::getService('like')->getLikesForFeed($sType, $this->get('item_id'), false, Phpfox::getParam('feed.total_likes_to_display'), true);
			
			// The dislikes are fetched and displayed from the template
			$aFeed = array(
				'like_type_id' => $sType,
				'item_id' => $this->get('item_id'),
				'likes' => $aLikes,
				'feed_total_like' => Phpfox::getService('like')->getTotalLikeCount(),
				'call_displayactions' => true,
				'feed_id' => $this->get('parent_id')
			);			
		}
		else
		{

			// We get the dislikes and likes and the template only displays them
			$aFeed = Phpfox::getService('like')->getAll( $sType, $this->get('item_id') );
			
			// Fix for likes
			$aFeed['feed_like_phrase'] = $aFeed['likes']['phrase'];
			$aFeed['feed_id'] = $this->get('parent_id');
			
			// Fix for dislikes
			$aFeed['call_displayactions'] = true;
			$aFeed['type_id'] = $this->get('type_id');
			$aFeed['dislike_phrase'] = $aFeed['dislikes']['phrase'];		
		}
		
		$this->template()->assign(array('aFeed' => $aFeed));
		$this->template()->getTemplate('like.block.display');
		$sId = $this->get('item_id');
		$sParentId = str_replace('js_feed_like_holder','', $this->get('parent_id'));
		
		$sContent = $this->getContent(false);
		$sContent = str_replace("'", "\'", $sContent);

		$sType = str_replace('-', '_', $sType);		
		
		$sCall = ' $("#js_feed_like_holder_' . $sType . '_' . $sId . '").find(\'.js_comment_like_holder:first\').html(\'' . $sContent . '\');';
		$this->call($sCall);
				
		$this->call('$("#js_feed_like_holder_' . $sType . '_' . $sId . '").show();');
		
		if (Phpfox::getParam('photo.show_info_on_mouseover') && $this->get('item_type_id') == 'photo' && $this->get('item_id') > 0)
		{
			$iTotal = 0;
			if (isset($aFeed['feed_total_like']))
			{
				$iTotal = $aFeed['feed_total_like'];
			}
			else if (isset($aFeed['likes']['total']))
			{
				$iTotal = $aFeed['likes']['total'];
			}
			$this->call('$("#js_like_counter_' . $this->get('item_id') . '").html('. $iTotal .');');
		}
	}

	/* This is called when visitor clicks on "Dislike" */
	public function doAction()
	{
		$sTypeId = str_replace('-', '_', $this->get('item_type_id'));
		$this->set(array('type_id' => $sTypeId));		
		
		if (Phpfox::getService('like.process')->doAction($this->get('action_type_id'), $this->get('item_type_id'), $this->get('item_id'), $this->get('module_name') ))
		{
			if ($this->get('type_id') == 'feed_mini')// && $this->get('custom_inline'))
			{
				$this->_loadCommentLikes(true);
			}
			else
			{
				$bIsLiked = Phpfox::getService('like')->didILike($sTypeId, $this->get('item_id'));
				$this->_loadLikes($bIsLiked);
			}
		}
	}
	
	public function removeAction()
	{
	    $sTypeId = $this->get('type_id');
	    $sModuleId = $this->get('module_name');
	    // $sDeleteAction = $this->get('action_type_id');// for now dislike is the only available and = 2
	    
	    if (empty($sTypeId))
	    {
			$sTypeId = $this->get('like_type_id');
		}
	    
	    if (empty($sModuleId) && !empty($sTypeId))
	    {
            $this->set('module_name', $sTypeId);
            $sModuleId = $sTypeId;
	    }
	    if (empty($sTypeId) && $this->get('item_type_id') != '')
	    {
			$this->set('type_id', $this->get('item_type_id'));
			$sTypeId = $this->get('item_type_id');
		}
		
		// its not decrementing the total_dislike column
		
	    if (Phpfox::getService('like.process')->removeAction( 2, $sTypeId, $this->get('item_id'), $sModuleId ))
	    {
			if ($this->get('type_id') == 'feed_mini' || $this->get('item_type_id') == 'feed_mini')// && $this->get('custom_inline'))
			{
				$this->_loadCommentLikes(true);
			}
			else
			{
				$bIsLiked = Phpfox::getService('like')->didILike($sTypeId, $this->get('item_id'));
				$this->_loadLikes($bIsLiked);
			}
        }
    }
}

?>