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
 * @package  		Module_Comment
 * @version 		$Id: process.class.php 7165 2014-03-03 15:23:19Z Fern $
 */
class Comment_Service_Process extends Phpfox_Service
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('comment');
	}

	public function add($aVals, $iUserId = null, $sUserName = null)
	{
		$iUserId = ($iUserId === null ? Phpfox::getUserId() : (int) $iUserId);
		$sUserName = ($sUserName === null ? Phpfox::getUserBy('full_name') : $sUserName);

		// http://www.phpfox.com/tracker/view/15205/
		// check if user can comment on this item
		if(Phpfox::isModule('feed') && isset($aVals['is_via_feed']) && !empty($aVals['is_via_feed']))
		{
			$aFeed = $this->database()->select('privacy, privacy_comment, user_id')
				->from(Phpfox::getT('feed'))
				->where('item_id = ' . (int)$aVals['item_id'] . ' AND type_id = "' . Phpfox::getLib('parse.input')->clean($aVals['type']) . '"')
				->execute('getSlaveRow');
						
			if (!empty($aFeed) && !Phpfox::getUserParam('privacy.can_comment_on_all_items'))
			{
				if(isset($aFeed['privacy_comment']) && !empty($aFeed['privacy']) && !empty($aFeed['user_id']) && $aFeed['user_id'] != $iUserId)
				{
					if ($aFeed['privacy_comment'] == 1 && Phpfox::getService('friend')->isFriend($iUserId, $aFeed['user_id']) != true)
					{
						return Phpfox_Error::display(Phpfox::getPhrase('feed.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
					}
					else if ($aFeed['privacy_comment'] == 2 && Phpfox::getService('friend')->isFriendOfFriend($iUserId) != true)
					{
						return Phpfox_Error::display(Phpfox::getPhrase('feed.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
					}
					else if ($aFeed['privacy_comment'] == 3 && ($aFeed['user_id'] != Phpfox::getUserId()))
					{
						return Phpfox_Error::display(Phpfox::getPhrase('feed.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
					}
					else if ($aFeed['privacy_comment'] == 4 && ( $bCheck = Phpfox::getService('privacy')->check($aVals['type'], $aVals['item_id'], $aFeed['user_id'], $aFeed['privacy_comment'], null, true)) != true)
					{
						return Phpfox_Error::display(Phpfox::getPhrase('feed.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
					}
				}
				
				// Fallback: if the item is private and it cannot be accessed by the one trying to comment, then, the user should not be able to.
				if(isset($aFeed['privacy']) && !empty($aFeed['privacy']) && !empty($aFeed['user_id']) && $aFeed['user_id'] != $iUserId)
				{
					if ($aFeed['privacy'] == 1 && Phpfox::getService('friend')->isFriend($iUserId, $aFeed['user_id']) != true)
					{
						return Phpfox_Error::display(Phpfox::getPhrase('feed.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
					}
					else if ($aFeed['privacy'] == 2 && Phpfox::getService('friend')->isFriendOfFriend($iUserId) != true)
					{
						return Phpfox_Error::display(Phpfox::getPhrase('feed.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
					}
					else if ($aFeed['privacy'] == 3 && ($aFeed['user_id'] != Phpfox::getUserId()))
					{
						return Phpfox_Error::display(Phpfox::getPhrase('feed.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
					}
					else if ($aFeed['privacy'] == 4 && ( $bCheck = Phpfox::getService('privacy')->check($aVals['type'], $aVals['item_id'], $aFeed['user_id'], $aFeed['privacy'], null, true)) != true)
					{
						return Phpfox_Error::display(Phpfox::getPhrase('feed.unable_to_post_a_comment_on_this_item_due_to_privacy_settings'));
					}
				}
			}
		}
		// END

		if (isset($aVals['parent_group_id']) && isset($aVals['group_view_id']) && $aVals['group_view_id'] > 0)
		{
			define('PHPFOX_SKIP_FEED', true);
		}

		if (Phpfox::getParam('comment.comment_hash_check'))
		{
			if (Phpfox::getLib('spam.hash', array(
						'table' => 'comment_hash',
						'total' => Phpfox::getParam('comment.comments_to_check'),
						'time' => Phpfox::getParam('comment.total_minutes_to_wait_for_comments'),
						'content' => $aVals['text']
					)				
				)->isSpam())
			{
				return false;							
			}
		}
		
		$aItem = Phpfox::callback($aVals['type'] . '.getCommentItem', $aVals['item_id']);
		
		if (!isset($aItem['comment_item_id']))
		{
			return false;
		}
		
		$bIsBlocked = Phpfox::getService('user.block')->isBlocked($aItem['comment_user_id'], Phpfox::getUserId());
		if ($bIsBlocked)
		{
			Phpfox_Error::set('Unable to leave a comment at this time.');
			return false;
		}
		
		$aVals = array_merge($aItem, $aVals);
		
		$bCheck = Phpfox::getService('ban')->checkAutomaticBan($aVals['text']);
		if ($bCheck == false)
		{
			return false;
		}
		$aInsert = array(
			'parent_id' => $aVals['parent_id'],
			'type_id' => $aVals['type'],
			'item_id' => $aVals['item_id'],
			'user_id' => $iUserId,
			'owner_user_id' => $aItem['comment_user_id'],
			'time_stamp' => PHPFOX_TIME,
			'ip_address' => Phpfox::getLib('request')->getServer('REMOTE_ADDR'),
			'view_id' => (($aItem['comment_view_id'] == 2 && $aItem['comment_user_id'] != $iUserId) ? '1' : '0'),
			'author' => (!empty($aVals['is_via_feed']) ? (int)$aVals['is_via_feed'] : '')
		);

		if (!$iUserId)
		{
			$aInsert['author'] = substr($aVals['author'], 0, 255);
			$aInsert['author_email'] = $aVals['author_email'];
			if (!empty($aVals['author_url']) && Phpfox::getLib('validator')->verify('url', $aVals['author_url']))
			{
				$aInsert['author_url'] = $aVals['author_url'];
			}
		}
		
		$bIsSpam = false;
		if (Phpfox::getParam('comment.spam_check_comments'))
		{
			if (Phpfox::getLib('spam')->check(array(
						'action' => 'isSpam',										
						'params' => array(
							'module' => 'comment',
							'content' => Phpfox::getLib('parse.input')->prepare($aVals['text'])
						)
					)
				)
			)
			{
				$aInsert['view_id'] = '9';
				$bIsSpam = true;
				Phpfox_Error::set(Phpfox::getPhrase('comment.your_comment_has_been_marked_as_spam_it_will_have_to_be_approved_by_an_admin'));
			}
		}
		
		if (Phpfox::getUserParam('comment.approve_all_comments'))
		{
			$aInsert['view_id'] = '1';
			$bIsSpam = true;
			Phpfox::getLib('ajax')->sPopupMessage = Phpfox::getPhrase('core.notice');
			Phpfox_Error::set(Phpfox::getPhrase('comment.your_comment_has_successfully_been_added_however_it_is_pending_an_admins_approval'));
		}

		(($sPlugin = Phpfox_Plugin::get('comment.service_process_add')) ? eval($sPlugin) : false);		

		$iId = $this->database()->insert($this->_sTable, $aInsert);		
		
		Phpfox::getLib('parse.bbcode')->useVideoImage(($aVals['type'] == 'feed' ? true : false));
		
		$aVals['text_parsed'] = Phpfox::getLib('parse.input')->prepare($aVals['text']);

		$this->database()->insert(Phpfox::getT('comment_text'), array(
				'comment_id' => $iId,
				'text' => Phpfox::getLib('parse.input')->clean($aVals['text']),
				'text_parsed' => $aVals['text_parsed']
			)
		);
		
		// http://www.phpfox.com/tracker/view/14660/
		$sComment = Phpfox::getLib('parse.input')->clean($aVals['text']);
		if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support'))
		{
			Phpfox::getService('tag.process')->add($aInsert['type_id'], $aInsert['item_id'], Phpfox::getUserId(), $sComment, true);
		}
		
		$aVals['comment_id'] = $iId;
		
		if (!empty($aVals['parent_id']))
		{
			$this->database()->updateCounter('comment', 'child_total', 'comment_id', (int) $aVals['parent_id']);
		}
		
		if ($bIsSpam === true)
		{			
			return false;
		}		
		
		Phpfox::getService('user.process')->notifyTagged($aVals['text'], $iId, $aVals['type']);
		
		// Callback this action to other modules
		Phpfox::callback($aVals['type'] . '.addComment', $aVals, $iUserId, $sUserName);
		
		if (($aItem['comment_view_id'] == 2 && $aItem['comment_user_id'] != $iUserId))
		{
			(Phpfox::isModule('request') ? Phpfox::getService('request.process')->add('comment_pending', $iId, $aItem['comment_user_id']) : false);
			
			return 'pending_moderation';
		}		
		
		// Update user activity
		Phpfox::getService('user.activity')->update(Phpfox::getUserId(), 'comment');
		
		$sFeedPrefix = '';
		$sNewTypeId = $aVals['type'];
		if (!empty($aItem['parent_module_id']) && ($aItem['parent_module_id'] == 'pages' || $aItem['parent_module_id'] == 'event'))
		{
			$sFeedPrefix = $aItem['parent_module_id'] . '_';
			if ($sNewTypeId == 'pages')
			{
				$sNewTypeId = 'pages_comment';
			}
			
			if ($sNewTypeId == 'event')
			{
				$sNewTypeId = 'event_comment';
			}			
		}
		
		/*
		p($sFeedPrefix);
		p('type_id = \'' . $this->database()->escape($aVals['type']) . '\' AND item_id = ' . (int) $aVals['item_id']);
		exit;
		*/
		
		Phpfox::getService('feed.process')->clearCache($aVals['type'], $aVals['item_id']);
		
		$this->database()->update(Phpfox::getT($sFeedPrefix . 'feed'), array('time_update' => PHPFOX_TIME), 'type_id = \'' . $this->database()->escape($sNewTypeId) . '\' AND item_id = ' . (int) $aVals['item_id']);
		
		(($sPlugin = Phpfox_Plugin::get('comment.service_process_add_end')) ? eval($sPlugin) : false);

		return $iId;
	}

	public function updateText($iId, $sText)
	{
		if (Phpfox::getService('comment')->hasAccess($iId, 'edit_own_comment', 'edit_user_comment'))
		{
			$oFilter = Phpfox::getLib('parse.input');
			Phpfox::getService('ban')->checkAutomaticBan($sText);
			if (Phpfox::getParam('comment.spam_check_comments'))
			{
				if (Phpfox::getLib('spam')->check(array(
							'action' => 'isSpam',										
							'params' => array(
								'module' => 'comment',
								'content' => Phpfox::getLib('parse.input')->prepare($sText)
							)
						)
					)
				)
				{
					$this->database()->update(Phpfox::getT('comment'), array('view_id' => '9'), "comment_id = " . (int) $iId);					
					
					Phpfox_Error::set(Phpfox::getPhrase('comment.your_comment_has_been_marked_as_spam_it_will_have_to_be_approved_by_an_admin'));
				}
			}		
			
			$aVals = $this->database()->select('cmt.*')
				->from($this->_sTable, 'cmt')
				->where('cmt.comment_id = ' . (int) $iId)
				->execute('getSlaveRow');			
			
			Phpfox::getLib('parse.bbcode')->useVideoImage(($aVals['type_id'] == 'feed' ? true : false));	

			$this->database()->update(Phpfox::getT('comment'), array('update_time' => PHPFOX_TIME, "update_user" => Phpfox::getUserBy("full_name")), "comment_id = " . (int) $iId);
			$this->database()->update(Phpfox::getT('comment_text'), array('text' => $oFilter->clean($sText), "text_parsed" => $oFilter->prepare($sText)), "comment_id = " . (int) $iId);		
			
			if (Phpfox::hasCallback($aVals['type_id'], 'updateCommentText'))
			{
				Phpfox::callback($aVals['type_id'] . '.updateCommentText', $aVals, $oFilter->prepare($sText));
			}

			return true;
		}

		return false;
	}

	/**
	 * @todo Fix this, not working anymore
	 *
	 * @param unknown_type $iId
	 * @param unknown_type $iTypeId
	 * @param unknown_type $iItemId
	 * @return unknown
	 */
	public function deleteInline($iId, $iTypeId, $bForce = false)
	{
		$bCanDeleteOnProfile = false;
		$aCore = Phpfox::getLib('request')->get('core');
		if (isset($aCore['is_user_profile']) && $aCore['is_user_profile'])
		{			
			if ($iTypeId == 'feed')
			{
				$this->database()->join(Phpfox::getT('feed_comment'), 'fc', 'fc.feed_comment_id = c1.item_id');
			}
			else
			{
				$this->database()->join(Phpfox::getT('feed'), 'fc', 'c1.type_id = fc.type_id AND c1.item_id = fc.item_id');
			}
			$aParent = $this->database()->select('fc.parent_user_id, c1.owner_user_id')
				->from(Phpfox::getT('comment'), 'c1')				
				->where('c1.comment_id = ' . (int) $iId)
				->execute('getSlaveRow');

			$bCanDeleteComment = false;
			if (isset($aParent['parent_user_id']) && $aParent['parent_user_id'] == Phpfox::getUserId())
			{
				$bCanDeleteComment = true;
			}
			elseif (isset($aParent['owner_user_id']) && $aParent['owner_user_id'] == Phpfox::getUserId())
			{
				$bCanDeleteComment = true;
			}
	
			$bCanDeleteOnProfile = ($bCanDeleteComment && Phpfox::getUserParam('comment.can_delete_comments_posted_on_own_profile'));			
		}		
		
		
		if (Phpfox::isModule('pages') && Phpfox::getLib('request')->get('type_id') == 'pages')
		{
			$aPagesParent = $this->database()->select('c1.*, pf.parent_user_id')
				->from(Phpfox::getT('comment'), 'c1')
				->join(Phpfox::getT('pages_feed'), 'pf', 'pf.item_id = c1.item_id')
				->where('c1.comment_id = ' . (int) $iId)
				->execute('getSlaveRow');

			if (isset($aPagesParent['comment_id']) && Phpfox::getService('pages')->isAdmin($aPagesParent['parent_user_id']))
			{
				$bCanDeleteOnProfile = true;
			}
		}
		
		if ($bForce === true)
		{
			$bCanDeleteOnProfile = true;
		}

		if ((($iUserId = Phpfox::getService('comment')->hasAccess($iId, 'delete_own_comment', 'delete_user_comment')) !== false) || $bCanDeleteOnProfile == true)
		{
			$aCommentRow = $this->database()->select('*')
				->from($this->_sTable)
				->where('comment_id = ' . (int) $iId)
				->execute('getRow');				
			
			$this->delete($iId);
			
			if (empty($aCommentRow['parent_id']))
			{
				Phpfox::callback($iTypeId . '.deleteComment', $aCommentRow['item_id']);
			}		

			// Update user activity
			Phpfox::getService('user.activity')->update($iUserId, 'comment', '-');

			(($sPlugin = Phpfox_Plugin::get('comment.service_process_deleteinline')) ? eval($sPlugin) : false);

			if (Phpfox::getParam('feed.cache_each_feed_entry'))
			{
				Phpfox::getService('feed.process')->clearCache($iTypeId, $iId);	
			}
			
			return true;
		}

		return false;
	}

	/**
	 * Deletes a comment given its comment id
	 *
	 * @param int $iId
	 */
	public function delete($iId)
	{		
	    // delete the feed as well
		$sType = $this->database()->select('type_id')
		    ->from(Phpfox::getT('comment'))
		    ->where('comment_id = ' . (int)$iId)
		    ->execute('getSlaveField');
		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete($sType, (int) $iId) : null);
		
		$this->database()->delete(Phpfox::getT('comment'), "comment_id = " . (int) $iId);
		$this->database()->delete(Phpfox::getT('comment_text'), "comment_id = " . (int) $iId);
		$this->database()->delete(Phpfox::getT('comment_rating'), 'comment_id = ' . (int) $iId);
		(($sPlugin = Phpfox_Plugin::get('comment.service_process_delete')) ? eval($sPlugin) : false);
	}

	public function deleteForItem($iUserId, $iItemId, $sCategory)
	{
		$aRows = $this->database()->select('user_id')
			->from($this->_sTable)
			->where("item_id = " . $iItemId . " AND type_id = '" . $this->database()->escape($sCategory) . "'")
			->execute('getRows');
		
		if (!count($aRows))
		{
			return false;
		}		
		
		$this->database()->delete($this->_sTable, "item_id = " . (int) $iItemId . " AND type_id = '" . $this->database()->escape($sCategory) . "'");

		foreach ($aRows as $aRow)
		{
			// Update user activity
			Phpfox::getService('user.activity')->update($aRow['user_id'], 'comment', '-');
		}
	}

	public function rate($iId, $sType, $iUserId = null)
	{
		$iUserId = ($iUserId === null ? Phpfox::getUserId() : (int) $iUserId);

		$aRow = $this->database()->select('comment_id, rating')
			->from(Phpfox::getT('comment_rating'))
			->where('comment_id = ' . (int) $iId . ' AND user_id = ' . $iUserId)
			->execute('getRow');

		$bAllowRating = true;
		if ($sType == 'up')
		{
			if (isset($aRow['comment_id']))
			{
				if ($aRow['rating'] == '+1')
				{
					$sNewRating = '+1';
					$bAllowRating = false;
				}
				elseif ($aRow['rating'] == '-1')
				{
					$sNewRating = '0';
				}
				else
				{
					$sNewRating = '+1';
				}
			}
			else
			{
				$sNewRating = '+1';
			}
		}
		else
		{
			if (isset($aRow['comment_id']))
			{
				if ($aRow['rating'] == '+1')
				{
					$sNewRating = '0';
				}
				elseif ($aRow['rating'] == '-1')
				{
					$sNewRating = '-1';
					$bAllowRating = false;
				}
				else
				{
					$sNewRating = '-1';
				}
			}
			else
			{
				$sNewRating = '-1';
			}
		}

		if (isset($aRow['comment_id']))
		{
			$this->database()->update(Phpfox::getT('comment_rating'), array(
				'rating' => $sNewRating
			), 'comment_id = ' . (int) $iId . ' AND user_id = ' . $iUserId);
		}
		else
		{
			$this->database()->insert(Phpfox::getT('comment_rating'), array(
				'comment_id' => (int) $iId,
				'user_id' => $iUserId,
				'rating' => $sNewRating,
				'time_stamp' => PHPFOX_TIME,
				'ip_address' => Phpfox::getLib('request')->getServer('REMOTE_ADDR')
			));
		}

		$sRating = $this->database()->select('rating')
			->from($this->_sTable)
			->where('comment_id = ' . (int) $iId)
			->execute('getField');

		if ($bAllowRating)
		{
			if (is_null($sRating) || $sRating == 0)
			{
				if ($sType == 'up')
				{
					$sRating = '+1';
				}
				else
				{
					$sRating = '-1';
				}
			}
			else
			{
				if (substr($sRating, 0, 1) == '+')
				{
					if ($sType == 'up')
					{
						$sRating = '+' . ((int) substr_replace($sRating, '', 0, 1) + 1);
					}
					else
					{
						$iCnt = (int) substr_replace($sRating, '', 0, 1);

						if ($iCnt == 1)
						{
							$sRating = 0;
						}
						else
						{
							$sRating = '+' . ($iCnt - 1);
						}
					}
				}
				else
				{
					if ($sType == 'up')
					{
						$iCnt = (int) substr_replace($sRating, '', 0, 1);

						if ($iCnt == 1)
						{
							$sRating = 0;
						}
						else
						{
							$sRating = '-' . ((int) substr_replace($sRating, '', 0, 1) - 1);
						}
					}
					else
					{
						$sRating = '-' . ((int) substr_replace($sRating, '', 0, 1) + 1);
					}
				}
			}

			// +1 is counted as a numeric value when using is_numeric() so we don't escape this query
			$this->database()->update($this->_sTable, array('rating' => "'{$sRating}'"), 'comment_id = ' . $iId, false);
		}

		return array($sRating, $sNewRating);
	}
	
	public function moderate($iId, $sAction, $bIsAdmin = false)
	{
		$aComment = $this->database()->select('c.comment_id, c.user_id, c.type_id, c.item_id, c.parent_id, ct.text, ct.text_parsed, c.type_id AS type, u.full_name')
			->from($this->_sTable, 'c')
			->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = c.user_id')
			->where('c.comment_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aComment['comment_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('comment.not_a_valid_comment'));
		}
		
		$aItem = Phpfox::callback($aComment['type_id'] . '.getCommentItem', $aComment['item_id']);
	
		$aVals = array_merge($aItem, $aComment);
		
		if (!Phpfox::getUserParam('comment.can_moderate_comments'))
		{
			// Make sure this user can actually moderate this comment
			if ($aItem['comment_user_id'] != Phpfox::getUserId())
			{
				return Phpfox_Error::set(Phpfox::getPhrase('comment.unable_to_moderate_this_comment'));
			}
		}
		
		if ($sAction == 'approve')
		{
			$this->database()->update($this->_sTable, array('view_id' => (($bIsAdmin && $aVals['comment_view_id'] == 2) ? '1' : '0')), 'comment_id = ' . $aComment['comment_id']);

			// Update user activity
			if (($bIsAdmin && $aVals['comment_view_id'] == 2))
			{
				
			}			
			else 
			{
				Phpfox::getService('user.activity')->update($aComment['user_id'], 'comment');
				Phpfox::getLib('mail')->to($aComment['user_id'])
					->subject(array('comment.comment_approved_on_site_title', array('site_title' => Phpfox::getParam('core.site_title'))))
					->message(array('comment.one_of_your_comments_on_site_title', array(
								'site_title' => Phpfox::getParam('core.site_title'),
								'link' => Phpfox::getLib('url')->makeUrl('comment.view', array('id' => $aComment['comment_id']))
							)
						)
					)					
					->send();					
			}

			if ($bIsAdmin)
			{
				$this->database()->updateCounter('user', 'total_spam', 'user_id', $aComment['user_id'], true);
				
				define('FEED_FORCE_USER_ID', $aComment['user_id']);
				
				// Callback this action to other modules
				Phpfox::callback($aVals['type'] . '.addComment', $aVals, $aComment['user_id'], $aComment['full_name']);
			}
		}
		else 
		{
			$this->delete($aComment['comment_id']);
		}	
		
		if (isset($aVals['comment_view_id']) && $aVals['comment_view_id'] == 2)
		{
			if ($bIsAdmin)
			{
				(Phpfox::isModule('request') ? Phpfox::getService('request.process')->add('comment_pending', $aComment['comment_id'], $aItem['comment_user_id']) : false);	
			}
			else 
			{
				// Remove the initial request
				(Phpfox::isModule('request') ? Phpfox::getService('request.process')->delete('comment_pending', $aComment['comment_id'], $aItem['comment_user_id']) : false);
				
				// Process this action with other modules
				Phpfox::callback($aComment['type_id'] . '.processCommentModeration', $sAction, $aComment['item_id']);			
			}
		}
		
		return true;
	}
	
	public function notify($aParams)
	{		
		Phpfox::getLib('mail')->to($aParams['user_id'])
			->subject($aParams['owner_subject'])
			->message($aParams['owner_message'])
			->notification($aParams['owner_notification'])
			->send();			
			
		if (Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->add($aParams['notify_id'], $aParams['item_id'], $aParams['user_id']);
		}
		
		Phpfox::getService('comment')->massMail($aParams['mass_id'], $aParams['item_id'], $aParams['user_id'], array(
				'subject' => $aParams['mass_subject'],
				'message' => $aParams['mass_message']
			)
		);		
		if ($sPlugin = Phpfox_Plugin::get('comment.service_process_notify_1')){eval($sPlugin);}
	}

	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('comment.service_process___call'))
		{
			return eval($sPlugin);
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
}

?>
