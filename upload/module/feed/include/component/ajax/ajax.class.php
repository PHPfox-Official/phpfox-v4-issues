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
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 7092 2014-02-05 21:42:42Z Fern $
 */
class Feed_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function hashtag()
	{
		$this->setTitle('#' . strip_tags($this->get('hashtagsearch')));
		Phpfox::getBlock('feed.display');
		$this->call('<script type="text/javascript">$Core.loadInit();</script>');
	}

	public function loadDelayedComments()
	{		
		Phpfox::getBlock('feed.comment', array('aFeed' => json_decode($this->get('feed'), true)));
		$this->html('#js_load_delayed_comments', $this->getContent(false));
		$this->call('$Core.loadInit();');
		$this->call('if (function_exists(\'customPhotoTagImage\')){ customPhotoTagImage(); }');
	}
	
	public function loadDropDates()
	{
		Phpfox::getBlock('feed.loaddates');
		
		$sContent = $this->getContent(false);
		$sContent = str_replace(array("\n", "\t"), '', $sContent);
		
		$this->html('.timeline_date_holder_share', $sContent);
	}
	
	public function share()
	{
		$aPost = $this->get('val');		
		
		if ($aPost['post_type'] == '2')
		{
			if (!isset($aPost['friends']) || (isset($aPost['friends']) && !count($aPost['friends'])))
			{
				Phpfox_Error::set('Select a friend to share this with.');
			}
			else
			{
				$iCnt = 0;
				foreach ($aPost['friends'] as $iFriendId)
				{
					$aVals = array(
						'user_status' => $aPost['post_content'],
						'parent_user_id' => $iFriendId,
						'parent_feed_id' => $aPost['parent_feed_id'],
						'parent_module_id' => $aPost['parent_module_id']
					);
					
					if (Phpfox::getService('user.privacy')->hasAccess($iFriendId, 'feed.share_on_wall') && Phpfox::getUserParam('profile.can_post_comment_on_profile'))
					{	
						$iCnt++;
						
						Phpfox::getService('feed.process')->addComment($aVals);
					}				
				}			

				$sMessage = '<div class="message">' . str_replace("'", "\\'", Phpfox::getPhrase('feed.successfully_shared_this_item_on_your_friends_wall')) . '</div>';
				if (!$iCnt)
				{
					$sMessage = '<div class="error_message">' . str_replace("'", "\\'", Phpfox::getPhrase('user.unable_to_share_this_post_due_to_privacy_settings')) . '</div>';
				}
				$this->call('$(\'#\' + tb_get_active()).find(\'.js_box_content:first\').html(\'' . $sMessage . '\');');
				if ($iCnt)
				{
					$this->call('setTimeout(\'tb_remove();\', 2000);');
				}
			}
			
			return;
		}
		
		$aVals = array(
			'user_status' => $aPost['post_content'],
			'privacy' => '0',
			'privacy_comment' => '0',
			'parent_feed_id' => $aPost['parent_feed_id'],
			'parent_module_id' => $aPost['parent_module_id']
		);		
		
		if (($iId = Phpfox::getService('user.process')->updateStatus($aVals)))
		{
			$this->call('$(\'#\' + tb_get_active()).find(\'.js_box_content:first\').html(\'<div class="message">' . str_replace("'", "\\'", Phpfox::getPhrase('feed.successfully_shared_this_item')) . '</div>\'); setTimeout(\'tb_remove();\', 2000);');
		}
	}
	
	public function getEditBar()
	{
		Phpfox::getBlock('feed.setting');
		
		$this->html('#js_edit_block_' . $this->get('block_id'), $this->getContent(false))->slideDown('#js_edit_block_' . $this->get('block_id'));
	}
	
	public function addComment()
	{
		Phpfox::isUser(true);
		
		$aVals = (array) $this->get('val');		
		
		if (Phpfox::getLib('parse.format')->isEmpty($aVals['user_status']))
		{
			$this->alert(Phpfox::getPhrase('user.add_some_text_to_share'));
			$this->call('$Core.activityFeedProcess(false);');
			return;
		}		
		
		/* Check if user chose an egift */
		if (Phpfox::isModule('egift') && isset($aVals['egift_id']) && !empty($aVals['egift_id']))
		{
			/* is this gift a free one? */
			$aGift = Phpfox::getService('egift')->getEgift($aVals['egift_id']);
			if (!empty($aGift))
			{
				$bIsFree = true;
				foreach ($aGift['price'] as $sCurrency => $fVal)
				{
					if ($fVal > 0)
					{
						$bIsFree = false;
					}
				}	
				/* This is an important change, in v2 birthday_id was the mail_id, in v3
				 * birthday_id is the feed_id
				*/
				$aVals['feed_type'] = 'feed_egift';
				$iId = Phpfox::getService('feed.process')->addComment($aVals);
				// Always make an invoice, so the feed can check on the state
				$iInvoice = Phpfox::getService('egift.process')->addInvoice($iId, $aVals['parent_user_id'], $aGift);
				
				if (!$bIsFree)
				{
					Phpfox::getBlock('api.gateway.form',
							array('gateway_data' => array(
									'item_number' => 'egift|' . $iInvoice, 
									'currency_code' => Phpfox::getService('user')->getCurrency(),//Phpfox::getService('core.currency')->getDefault(),
									'amount' => $aGift['price'][Phpfox::getService('user')->getCurrency()],
									'item_name' => 'egift card with message: ' . $aVals['user_status'] . '',
									'return' => Phpfox::getLib('url')->makeUrl('friend.invoice'),
									'recurring' => 0,
									'recurring_cost' => '',
									'alternative_cost' => 0,
									'alternative_recurring_cost' => 0
							)));
					$this->call('$("#js_activity_feed_form").hide().after("' . $this->getContent(true) . '");');
				}
				else
				{
					// egift is free
					Phpfox::getService('feed')->processAjax($iId);
				}
			}
			
		}
		else
		{			
			if (isset($aVals['user_status']) && ($iId = Phpfox::getService('feed.process')->addComment($aVals)))
			{
				Phpfox::getService('feed')->processAjax($iId);		
			}
			else 
			{
				$this->call('$Core.activityFeedProcess(false);');
			}	
		}
		
	}
	
	public function viewMore()
	{
		if ($this->get('callback_module_id') == 'pages' && Phpfox::getService('pages')->isTimelinePage($this->get('callback_item_id')))
		{
			define('PAGE_TIME_LINE', true);
		}
		
		Phpfox::getBlock('feed.display');		
		
		$sYear = $this->get('year');
		
		$this->remove('#feed_view_more');
		if (!$this->get('forceview') && !$this->get('resettimeline'))
		{
			$this->append('#js_feed_content', $this->getContent(false));
		}
		else
		{
			// $this->html('#js_timeline_year_holder_' . $sYear . '', $this->getContent(false));
			$this->call('$.scrollTo(\'.timeline_left\', 800);');
			$this->html('#js_feed_content', $this->getContent(false));
		}
		$this->call('$Core.loadInit();');
	}
	
	public function rate()
	{		
		Phpfox::isUser(true);
		
		list($sRating, $iLastVote) = Phpfox::getService('feed.process')->rate($this->get('id'), $this->get('type'));
		Phpfox::getBlock('feed.rating', array(
				'sRating' => (int) $sRating,
				'iFeedId' => $this->get('id'),
				'bHasRating' => true,
				'iLastVote' => $iLastVote
			)
		);
		$this->html('#js_feed_rating' . $this->get('id'), $this->getContent(false));		
	}

	public function delete()
	{
		if (Phpfox::getService('feed.process')->deleteFeed($this->get('id'), $this->get('module'), $this->get('item')))
		{
			$this->slideUp('#js_item_feed_' . $this->get('id'));
			
			// http://www.phpfox.com/tracker/view/14864/
			if(Phpfox::getParam('feed.refresh_activity_feed') > 0)
			{
				$aRows = Phpfox::getService('feed')->get(null, null, 0);
				$aFeed = array_pop($aRows);
				
				$this->template()->assign(array(
						'aFeed' => $aFeed	
					)
				);
				
				$this->template()->getTemplate('feed.block.entry');
				$sId = 'js_item_feed_' . $aFeed['feed_id'];			
				$sHtml = '<div class="js_feed_view_more_entry_holder">' . $this->getContent(true) . '</div>';

				$this->call("$('#feed_view_more').before('" . $sHtml . "');");
			}
			// END
			
			$this->alert(Phpfox::getPhrase('feed.feed_successfully_deleted'), Phpfox::getPhrase('feed.feed_deletion'), 300, 150, true);
		}
		else
		{
			$this->alert(Phpfox::getPhrase('feed.unable_to_delete_this_entry'));
		}
	}
	
	public function getCommentText()
	{
		$aRow = Phpfox::getService('feed')->getFeed($this->get('feed_id'));	

		(($sPlugin = Phpfox_Plugin::get('feed.component_ajax_getcommenttext')) ? eval($sPlugin) : false);
		
		if (!isset($bHasPluginCall))
		{			
			$this->call("$('#js_quick_edit_id" . $this->get('id') . "').html('<textarea style=\"width:95%; height:80px;\" name=\"quick_edit_input\" cols=\"90\" rows=\"10\" id=\"js_quick_edit" . $this->get('id') . "\">" . str_replace("'", "\'", Phpfox::getLib('parse.output')->ajax($aRow['content'])) . "</textarea>');");		
		}
	}	
	
	public function updateFeedText()
	{
		$sTxt = $this->get('quick_edit_input');
		
		if (Phpfox::getLib('parse.format')->isEmpty($sTxt))
		{
			$this->alert(Phpfox::getPhrase('comment.add_some_text_to_your_comment'));
			
			return false;	
		}

		if (Phpfox::getService('feed.process')->updateCommentText($this->get('feed_id'), $sTxt))
		{
			Phpfox::getLib('parse.output')->setImageParser(array('width' => 200, 'height' => 200));
			if (Phpfox::getParam('core.allow_html'))
			{
				$sTxt = Phpfox::getLib('parse.output')->parse(Phpfox::getLib('parse.input')->prepare($sTxt));
			}
			else 
			{
				$sTxt = Phpfox::getLib('parse.output')->parse($sTxt);
			}
			Phpfox::getLib('parse.output')->setImageParser(array('clear' => true));

			$this->html('#' . $this->get('id'), $sTxt, '.highlightFade()');			
		}
	}
	
	public function like()
	{
		if (Phpfox::getService('feed.process')->like($this->get('feed_id'), $this->get('type_id')))
		{
			list($aLikesCount, $aLikes) = Phpfox::getService('feed')->getLikeForFeed($this->get('feed_id'));
			
			if (count($aLikes))
			{
				$this->template()->assign(array(
						'aFeed' => array(
							'feed_id' => $this->get('feed_id'),
							'like_rows' => $aLikes[$this->get('feed_id')],
							'like_count' => ($aLikesCount[$this->get('feed_id')] - count($aLikes[$this->get('feed_id')]))
						)
					)
				);
				
				$this->template()->getTemplate('feed.block.like');
				
				$this->html('#js_feed_like_holder_' . $this->get('feed_id'), $this->getContent(false));
				$this->call('$(\'#js_feed_like_holder_' . $this->get('feed_id') . '\').parents(\'.comment_mini_content_holder:first\').show();');
			}
			else 
			{
				$this->html('#js_feed_like_holder_' . $this->get('feed_id'), '');	
				$this->call('$(\'#js_feed_like_holder_' . $this->get('feed_id') . '\').parents(\'.comment_mini_content_holder:first\').hide();');
			}
		}
	}
	
	public function likeList()
	{
		Phpfox::getBlock('feed.like-list');
	}
	
	public function reloadActivityFeed()
	{
        $aParts = explode(',', $this->get('reload-ids'));
		$aRows = Phpfox::getService('feed')->get(null, null, 0);
		
		$iNewCnt = 0;
		$sLoadIds = '';
		$aIds = array();
		foreach ($aParts as $sPart)
		{
			$iPart = (int) trim($sPart);
			
			$aIds[$iPart] = $iPart;
		}

		
		foreach ($aRows as $aRow)
		{
			if (!in_array($aRow['feed_id'], $aIds))
			{
				$iNewCnt++;
	
				$sLoadIds .= $aRow['feed_id'] . ',';								
			}
		}
	
		$this->call('$Core.rebuildActivityFeedCount(' . (int) $iNewCnt . ', \'' . $sLoadIds . '\');');
		$this->call('setTimeout("$.ajaxCall(\'feed.reloadActivityFeed\', \'reload-ids=\' + $Core.getCurrentFeedIds(), \'GET\');", ' . (Phpfox::getParam('feed.refresh_activity_feed') * 1000) . ');');
	}
	
	public function approveComment()
	{
        Phpfox::isUser(true);
		Phpfox::getUserParam('comment.can_moderate_comments', true);
		Phpfox::getService('feed.process')->approve($this->get('feed_id'));		
	}
    
    public function appendMore()
    {	
		$aRows = Phpfox::getService('feed')->get();
		
		$sCustomIds = '';
		foreach ($aRows as $aRow)
		{
			$sCustomIds .= $aRow['feed_id'];
			$this->template()->assign(array(				
					'aFeed' => $aRow					
				)
			);
			$this->template()->getTemplate('feed.block.entry');
		}
		
		$sIds = 'js_feed_' . md5($sCustomIds);
		
		$this->call('$(\'.js_parent_feed_entry\').each(function(){$(this).removeClass(\'row_first\');});');
		$this->prepend('#js_new_feed_update', '<div id="' . $sIds . '" style="display:none;">' . $this->getContent(false) . '</div>');
		$this->hide('#activity_feed_updates_link_holder');
		$this->slideDown('#' . $sIds);		
		$this->call('$Core.loadInit();');        
    }
    
    /* Loads Pages and results from Google Places Autocomplete given a latitude and longitude
     * This function populates $Core.Feed.aPlaces with new items by passing parameters in jSon format */
     
    public function loadEstablishments()
    {
		$aPages = array();
		if (Phpfox::isModule('pages'))
		{
			$aPages = Phpfox::getService('pages')->getPagesByLocation( $this->get('latitude'), $this->get('longitude') );
		}
		
		if (count($aPages))
		{
			foreach ($aPages as $iKey => $aPage)
			{
				$aPages[$iKey]['geometry'] = array('latitude' => $aPage['location_latitude'], 'longitude' => $aPage['location_longitude']);
				$aPages[$iKey]['name'] = $aPage['title'];
				unset($aPages[$iKey]['location_latitude']);
				unset($aPages[$iKey]['location_longitude']);	
			}
		}
		
		if (!empty($aPages))
		{
			$jPages = json_encode($aPages);
			$this->call('$Core.Feed.storePlaces(\'' . $jPages .'\');');
		}		
	}
}

?>
