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
 * @package  		Module_Forum
 * @version 		$Id: ajax.class.php 6864 2013-11-07 12:48:15Z Miguel_Espinoza $
 */
class Forum_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function addReply()
	{
		Phpfox::isUser(true);
		
		$aVals = $this->get('val');
		Phpfox::getService('ban')->checkAutomaticBan($aVals['text']);
		if (Phpfox::getLib('parse.format')->isEmpty($aVals['text']))
		{
			$this->alert(Phpfox::getPhrase('forum.provide_a_reply'));
			$this->call('$Core.processForm(\'#js_forum_submit_button\', true);');
			
			return false;
		}
		
		$aCallback = false;
		if (isset($aVals['module'])
			&& Phpfox::isModule($aVals['module']) 
			&& isset($aVals['item'])
			&& Phpfox::hasCallback($aVals['module'], 'addForum')
		)
		{
			$aCallback = Phpfox::callback($aVals['module'] . '.addForum', $aVals['item']);		
			
			if ($aCallback === false)
			{
				$this->alert(Phpfox::getPhrase('forum.only_members_can_add_a_reply_to_threads'));
				$this->call('$Core.processForm(\'#js_forum_submit_button\', true);');
				
				return false;
			}
		}		
		
		$bPassCaptcha = true;
		
		if (Phpfox::isModule('captcha') && Phpfox::getUserParam('forum.enable_captcha_on_posting') && !Phpfox::getService('captcha')->checkHash($aVals['image_verification']))
		{
			$bPassCaptcha = false;
			
			$this->call("$('#js_captcha_image').ajaxCall('captcha.reload', 'sId=js_captcha_image&sInput=image_verification'); $('#js_post_entry').message('" . Phpfox::getPhrase('captcha.captcha_failed_please_try_again', array('phpfox_squote' => true)) . "', 'error').slideDown('slow'); $('#js_quick_reply_form .button').attr('disabled', false).removeClass('disabled'); $('#js_quick_reply_form #text').attr('disabled', false).removeClass('disabled'); $('#js_reply_process').html('');");
		}		
		
		if (!$bPassCaptcha)
		{
			$this->call('$Core.processForm(\'#js_forum_submit_button\', true);');
			return false;
		}
		
		$aThread = Phpfox::getService('forum.thread')->getActualThread($aVals['thread_id'], $aCallback);
		
		if ($aThread['is_closed'])
		{
			$this->alert(Phpfox::getPhrase('forum.thread_is_closed_for_posting'));
			$this->call('$Core.processForm(\'#js_forum_submit_button\', true);');
			
			return false;
		}
		
		if ($aCallback === false && $aThread['is_announcement'])
		{
			$this->alert(Phpfox::getPhrase('forum.thread_is_closed_for_posting'));
			$this->call('$Core.processForm(\'#js_forum_submit_button\', true);');
			
			return false;			
		}
		
		if (!isset($aThread['thread_id']))
		{
			return false;
		}
		
		$bPass = false;		
		if ((Phpfox::getUserParam('forum.can_reply_to_own_thread') && $aThread['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_reply_on_other_threads') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'can_reply'))
		{
			$bPass = true;	
		}		
				
		if ($bPass === false)
		{
			$this->alert(Phpfox::getPhrase('forum.insufficient_permission_to_reply_to_this_thread'));
			$this->call('$Core.processForm(\'#js_forum_submit_button\', true);');
			
			return false;
		}		
		
		if (($iFlood = Phpfox::getUserParam('forum.forum_post_flood_control')) !== 0)
		{
			$aFlood = array(
				'action' => 'last_post', // The SPAM action
				'params' => array(
					'field' => 'time_stamp', // The time stamp field
					'table' => Phpfox::getT('forum_post'), // Database table we plan to check
					'condition' => 'user_id = ' . Phpfox::getUserId(), // Database WHERE query
					'time_stamp' => $iFlood * 60 // Seconds);	
				)
			);
				 			
			// actually check if flooding
			if (Phpfox::getLib('spam')->check($aFlood))
			{		
				$this->alert(Phpfox::getPhrase('forum.posting_a_new_thread_a_little_too_soon') . ' ' . Phpfox::getLib('spam')->getWaitTime());
				$this->call('$Core.processForm(\'#js_forum_submit_button\', true);');				
				 				
				return false;
			}											
		}			
		
		$aVals['forum_id'] = $aThread['forum_id'];
		
		Phpfox::getLib('parse.output')->setEmbedParser(array(
				'width' => 640,
				'height' => 360
			)
		);		
		
		if ($iId = Phpfox::getService('forum.post.process')->add($aVals, $aCallback))
		{
			$aPost = Phpfox::getService('forum.post')->getPost($iId);
			
			if ($aCallback === false && $aThread['forum_id'] > 0)
			{
				Phpfox::getService('forum.process')->updateTrack($aThread['forum_id']);			
			}
			
			Phpfox::getService('forum.thread.process')->updateTrack($aThread['thread_id']);			
			
			$aPost['count'] = ($aVals['total_post'] + 1);
			$this->template()->assign(array(
					'aPost' => $aPost,
					'aThread' => Phpfox::getService('forum.thread')->getActualThread($aPost['thread_id']),
					'aCallback' => $aCallback
				)
			)->getTemplate('forum.block.post');

			$this->append('#js_post_new_thread', $this->getContent(false))->call('$Core.forum.processReply(' . $aPost['post_id'] . ');');
		}
		else 
		{
			if (Phpfox::getUserParam('forum.approve_forum_post') && $aCallback === false)
			{
				$this->call('js_box_remove($(\'#js_forum_form\'));');
				$this->alert(Phpfox::getPhrase('forum.your_post_has_successfully_been_added_however_it_is_pending_an_admins_approval_before_it_can_be_displayed_publicly'));
				$this->call('$("#js_reply_process").hide();');			
			}
		}
		
		if (Phpfox::getParam('core.defer_loading_user_images'))
		{
			$this->call('$Core.loadInit();');
		}
	}
	
	public function deletePost()
	{
		Phpfox::isUser(true);
		
		$aPost = Phpfox::getService('forum.post')->getPost($this->get('id'));
		
		$bHasAccess = false;
		if ((int) $aPost['group_id'] > 0)
		{
			if (Phpfox::getService('pages')->isAdmin($aPost['group_id']))
			{
				$bHasAccess = true;
			}
		}
		else 
		{		
			if ((Phpfox::getService('forum.moderate')->hasAccess($aPost['forum_id'], 'delete_post') || Phpfox::getService('user.auth')->hasAccess('forum_post', 'post_id', $this->get('id'), 'forum.can_delete_own_post', 'forum.can_delete_other_posts')))
			{
				$bHasAccess = true;
			}
		}		
				
		if ($bHasAccess && Phpfox::getService('forum.post.process')->delete($this->get('id')))
		{
			
		}
	}
	
	public function getModerators()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		Phpfox::getUserParam('forum.can_manage_forum_moderators', true);
		
		Phpfox::getBlock('forum.admincp.moderator', array('id' => $this->get('id')));
		
		$this->html('#js_forum_edit_content', $this->getContent(false));
	}
	
	public function getModerator()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		Phpfox::getUserParam('forum.can_manage_forum_moderators', true);
		
		$mUserData = Phpfox::getService('forum.moderate')->getUserPerm($this->get('forum_id'), $this->get('user_id'));
		
		$this->call('$Core.forum.build(' . $mUserData . ');');
	}
	
	public function removeModerator()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		Phpfox::getUserParam('forum.can_manage_forum_moderators', true);
		
		Phpfox::getService('forum.moderate.process')->delete($this->get('id'));
	}
	
	public function updateModerator()
	{		
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		Phpfox::getUserParam('forum.can_manage_forum_moderators', true);
		
		$aVals = $this->get('val');
		if (empty($aVals['user_id']) && ((!isset($aVals['users'])) || (isset($aVals['users']) && !count($aVals['users']))))
		{
			$this->html('#js_update_mod', '')->alert(Phpfox::getPhrase('forum.select_moderators'));			
			
			return false;
		}
		
		if (Phpfox::getService('forum.moderate.process')->add($this->get('val')))
		{
			$this->html('#js_update_mod', Phpfox::getPhrase('forum.done'), '.fadeOut(5000)');
		}
	}
	
	public function getText()
	{
		Phpfox::isUser(true);
		
		$aPost = Phpfox::getService('forum.post')->getForEdit($this->get('post_id'));
		
		$bHasAccess = false;
		if ((int) $aPost['group_id'] > 0)
		{
			if ((Phpfox::getUserParam('forum.can_edit_own_post') && $aPost['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_edit_other_posts'))
			{
				$bHasAccess = true;
			}
		}
		else 
		{
			if ((Phpfox::getService('forum.moderate')->hasAccess($aPost['forum_id'], 'edit_post') || Phpfox::getService('user.auth')->hasAccess('forum_post', 'post_id', $this->get('post_id'), 'forum.can_edit_own_post', 'forum.can_edit_other_posts')))
			{
				$bHasAccess = true;
			}
		}		
		
		(($sPlugin = Phpfox_Plugin::get('forum.component_ajax_get_text')) ? eval($sPlugin) : false);
		
		if (!isset($bHasPluginCall))
		{		
			if ($bHasAccess)
			{
				$this->call("$('#js_quick_edit_id" . $this->get('id') . "').html('<div><div id=\"sJsEditorMenu\" class=\"editor_menu\" style=\"display:block;\">' + Editor.setId('js_quick_edit" . $this->get('id') . "').getEditor(true) + '</div><textarea style=\"width:98%;\" name=\"quick_edit_input\" cols=\"90\" rows=\"10\" id=\"js_quick_edit" . $this->get('id') . "\">" . Phpfox::getLib('parse.output')->ajax($aPost['text']) . "</textarea></div>');");
			}
		}
	}
	
	public function updateText()
	{
		Phpfox::isUser(true);
		
		$aVals = (array) $this->get('val');
		$sTxt = $aVals['text'];
		
		if (Phpfox::getLib('parse.format')->isEmpty($sTxt))
		{
			$this->alert(Phpfox::getPhrase('forum.add_some_text'));
			
			return false;	
		}		
		
		$aPost = Phpfox::getService('forum.post')->getPost($this->get('edit'));
		
		$bHasAccess = false;
		if ((int) $aPost['group_id'] > 0)
		{
			if ((Phpfox::getUserParam('forum.can_edit_own_post') && $aPost['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_edit_other_posts'))
			{
				$bHasAccess = true;
			}
		}
		else 
		{
			if ((Phpfox::getService('forum.moderate')->hasAccess($aPost['forum_id'], 'edit_post') || Phpfox::getService('user.auth')->hasAccess('forum_post', 'post_id', $this->get('edit'), 'forum.can_edit_own_post', 'forum.can_edit_other_posts')))
			{
				$bHasAccess = true;
			}
		}			
		
		if ($bHasAccess)
		{		
			if (Phpfox::getService('forum.post.process')->updateText($this->get('edit'), $sTxt, $aVals))
			{
				$aPost = Phpfox::getService('forum.post')->getPost($this->get('edit'));
				
				$this->html('#js_post_edit_text_' . $aPost['post_id'], Phpfox::getLib('parse.output')->split(Phpfox::getLib('parse.output')->parse($aPost['text']), 55));
				$this->call('tb_remove();');			
                
                if(isset($aPost['attachments']) && count($aPost['attachments']) > 0)
				{
					Phpfox::getBlock('attachment.list', array('sType' => 'forum', 'attachments' => $aPost['attachments']));
					$this->call("$('#post" . $aPost['post_id'] . "').find('.attachment_holder_view').remove();");
					$this->call("$('" . $this->getContent() . "').insertAfter('#js_post_edit_text_" . $aPost['post_id'] . "');");
				}
			}
		}
	}
	
	public function move()
	{
		Phpfox::isUser(true);
		
		if (!Phpfox::getUserParam('forum.can_move_forum_thread'))
		{
			$aThread = Phpfox::getService('forum.thread')->getActualThread($this->get('thread_id'));
			
			if (!Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'move_thread'))
			{
				$this->alert(Phpfox::getPhrase('forum.not_permitted_to_move_threads'));
				
				return false;
			}
		}
		
		Phpfox::getBlock('forum.move');
	}
	
	public function processMove()
	{
		Phpfox::isUser(true);
		
		if ((Phpfox::getUserParam('forum.can_move_forum_thread') || Phpfox::getService('forum.moderate')->hasAccess($this->get('forum_id'), 'move_thread')) && Phpfox::getService('forum.thread.process')->move($this->get('thread_id'), $this->get('forum_id')))
		{			
			$aForum = Phpfox::getService('forum')
				->id($this->get('forum_id'))
				->getForum();	
				
			$aThread = Phpfox::getService('forum.thread')->getActualThread($this->get('thread_id'));	
			
			/*
			$aForum = Phpfox::getService('forum')
				->id($this->get('forum_id'))
				->getForum();	
				
			$this->template()->setBreadcrumb('Forum', Phpfox::getLib('url')->makeUrl('forum'))
				->setBreadcrumb($aForum['breadcrumb'])
				->setBreadcrumb($aForum['name'], Phpfox::getLib('url')->makeUrl('forum', $aForum['name_url'] . '-' . $aForum['forum_id']));
				
			list($aBreadCrumbs, $aBreadCrumbTitle) = $this->template()->getBreadCrumb();
			$this->template()->assign(array(
					'aBreadCrumbs' => $aBreadCrumbs,
					'aBreadCrumbTitle' => $aBreadCrumbTitle
				)
			);
			$this->template()->getLayout('breadcrumb');			
			*/
			
			$sUrl = Phpfox::getLib('url')->makeUrl('forum', array($aForum['name_url'] . '-' . $aForum['forum_id'], $aThread['title_url']));
			
			Phpfox::addMessage(Phpfox::getPhrase('forum.thread_successfully_moved'));
			
			$this->call('window.location.href = \'' . $sUrl . '\';');
			
			/*
			$this->html('#js_moving_forum', '')
				->html('#content h1', preg_replace("/<h1>(.*?)<\/h1>/is", "\\1", $this->getContent(false)))->call('tb_remove();')
				->html('#js_thread_start', '<div class="valid_message" style="margin:0px;">' . Phpfox::getPhrase('forum.thread_successfully_moved') . '</div>', '.fadeOut(5000)');
			*/
		}
		else 
		{
			$this->alert(Phpfox::getPhrase('forum.you_are_not_permitted_to_move_this_thread_to_this_specific_forum'));
		}		
	}
	
	public function copy()
	{
		Phpfox::isUser(true);
		
		Phpfox::getBlock('forum.copy');
	}	
	
	public function processCopy()
	{
		Phpfox::isUser(true);	
		
		if ((Phpfox::getUserParam('forum.can_copy_forum_thread') || Phpfox::getService('forum.moderate')->hasAccess($this->get('forum_id'), 'copy_thread')) && Phpfox::getService('forum.thread.process')->copy($this->get('thread_id'), $this->get('forum_id'), $this->get('title')))
		{
			$aForum = Phpfox::getService('forum')
				->id($this->get('forum_id'))
				->getForum();			
			
			$sUrl = Phpfox::getLib('url')->makeUrl('forum', array($aForum['name_url'] . '-' . $aForum['forum_id'], Phpfox::getLib('parse.input')->prepareTitle('forum', $this->get('title'), 'title_url', null, Phpfox::getT('forum_thread'), true)));
			
			Phpfox::addMessage(Phpfox::getPhrase('forum.successfully_copied_the_thread'));
			
			$this->call('window.location.href= \'' . $sUrl . '\';');
		}
		else 
		{
			$this->alert(Phpfox::getPhrase('forum.you_are_not_permitted_to_copy_this_thread_to_this_specific_forum'));
		}
	}
	
	public function deleteThread()
	{
		Phpfox::isUser(true);
		
		$aThread = Phpfox::getService('forum.thread')->getActualThread($this->get('thread_id'));
		
		$bHasAccess = false;
		if ((int) $aThread['group_id'] > 0)
		{
			if ((Phpfox::getUserParam('forum.can_delete_own_post') && $aThread['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_delete_other_posts'))
			{
				$bHasAccess = true;
			}
		}
		else 
		{
			if ((Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'delete_post') || Phpfox::getService('user.auth')->hasAccess('forum_thread', 'thread_id', $this->get('thread_id'), 'forum.can_delete_own_post', 'forum.can_delete_other_posts')))
			{
				$bHasAccess = true;
			}
		}			
		
		if ($bHasAccess)
		{
			Phpfox::getService('forum.thread.process')->delete($this->get('thread_id'));		
						
			Phpfox::addMessage(Phpfox::getPhrase('forum.thread_successfully_deleted'));
			
			if ((int) $aThread['group_id'] > 0)
			{
				$aPage = Phpfox::getService('pages.callback')->addForum($aThread['group_id']);
				
				if (isset($aPage['url_home']))
				{
					$this->call('window.location.href = \'' . $aPage['url_home'] . 'forum/\';');	
				}
			}
			else 
			{
				$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('forum') . '\';');	
			}
		}
	}
	
	public function stickThread()
	{
		Phpfox::isUser(true);
		
		$aThread = Phpfox::getService('forum.thread')->getActualThread($this->get('thread_id'));
		
		$bHasAccess = false;
		if ((int) $aThread['group_id'] > 0)
		{
			if (Phpfox::isModule('pages') && Phpfox::getService('pages')->isAdmin($aThread['group_id']))
			{
				$bHasAccess = true;
			}
		}
		else 
		{
			if ((Phpfox::getUserParam('forum.can_stick_thread') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'post_sticky')))
			{
				$bHasAccess = true;
			}
		}			
		
		if ($bHasAccess)
		{
			if (Phpfox::getService('forum.thread.process')->stick($this->get('thread_id'), $this->get('type_id')))
			{
				if ($this->get('type_id') == 1)
				{
					$this->html('#js_stick_thread', '<li id="js_stick_thread"><a href="#" onclick="return $Core.forum.stickThread(\'' . $this->get('thread_id') . '\', 0);">' . Phpfox::getPhrase('forum.unstick_thread') . '</a></li>')->alert(Phpfox::getPhrase('forum.thread_successfully_stuck'));
				}
				else 
				{
					$this->html('#js_stick_thread', '<li id="js_stick_thread"><a href="#" onclick="return $Core.forum.stickThread(\'' . $this->get('thread_id') . '\', 1);">' . Phpfox::getPhrase('forum.stick_thread') . '</a></li>')->alert(Phpfox::getPhrase('forum.thread_successfully_unstuck'));
				}
			}
		}
	}
	
	public function closeThread()
	{
		Phpfox::isUser(true);
		
		$aThread = Phpfox::getService('forum.thread')->getActualThread($this->get('thread_id'));
		
		$bHasAccess = false;
		if ((int) $aThread['group_id'] > 0)
		{

		}
		else 
		{
			if ((Phpfox::getUserParam('forum.can_close_a_thread') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'close_thread')))
			{
				$bHasAccess = true;
			}
		}		
		
		if ($bHasAccess)
		{
			if (Phpfox::getService('forum.thread.process')->close($this->get('thread_id'), $this->get('type_id')))
			{
				if ($this->get('type_id') == 1)
				{
					$this->html('#js_close_thread', '<li id="js_close_thread"><a href="#" onclick="return $Core.forum.closeThread(\'' . $this->get('thread_id') . '\', 0);">' . Phpfox::getPhrase('forum.open_thread') . '</a></li>')->hide('#js_quick_reply')->alert(Phpfox::getPhrase('forum.thread_successfully_closed'));
				}
				else 
				{
					$this->html('#js_close_thread', '<li id="js_close_thread"><a href="#" onclick="return $Core.forum.closeThread(\'' . $this->get('thread_id') . '\', 1);">' . Phpfox::getPhrase('forum.close_thread') . '</a></li>')->show('#js_quick_reply')->alert(Phpfox::getPhrase('forum.thread_successfully_opened'));
				}
			}
		}
	}	
	
	public function merge()
	{
		Phpfox::isUser(true);
		
		Phpfox::getBlock('forum.merge');
	}
	
	public function processMerge()
	{
		Phpfox::isUser(true);
		$this->error(false);
		
		$aThread = Phpfox::getService('forum.thread')->getActualThread($this->get('thread_id'));
		
		$bHasAccess = false;
		$mReturn = false;
		if ((int) $aThread['group_id'] > 0)
		{
			$aPage = Phpfox::getService('pages')->getForView($aThread['group_id']);
			if (isset($aPage['is_admin']) && $aPage['is_admin'])
			{
				$bHasAccess = true;
			}
		}
		else 
		{
			if ((Phpfox::getUserParam('forum.can_merge_forum_threads') || Phpfox::getService('forum.moderate')->hasAccess($this->get('forum_id'), 'merge_thread')))
			{
				$bHasAccess = true;
			}
		}		
		
		if ($bHasAccess)
		{		
			$mReturn = Phpfox::getService('forum.thread.process')->merge($this->get('thread_id'), $this->get('forum_id'), $this->get('url'));
		}
		else 
		{
			Phpfox_Error::set(Phpfox::getPhrase('forum.not_allowed_to_merge_threads_from_this_specific_forum'));
		}
		
		if ($mReturn !== false)
		{
			Phpfox::addMessage(Phpfox::getPhrase('forum.threads_successfully_merged'));
			
			$this->call('window.location.href = \'' . $mReturn . '\';');	
		}
		else 
		{
			$aErrors = Phpfox_Error::get();
			$sErrors = '';
			foreach ($aErrors as $sError)
			{
				$sErrors .= '<div class="error_message">' . $sError . '</div>';
			}
			
			$this->html('#js_error_message', '' . $sErrors . '');
		}
	}
	
	public function subscribe()
	{
		if ($this->get('subscribe'))
		{
			Phpfox::getService('forum.subscribe.process')->add($this->get('thread_id'), Phpfox::getUserId());			
		}
		else 
		{
			Phpfox::getService('forum.subscribe.process')->delete($this->get('thread_id'), Phpfox::getUserId());
		}
	}

	/**
	 * Only meant ofr the ajax call available to admins and moderators, regular users should use the
	 * link to the ad.sponsor
	 * @param int type 1 = sponsor; 0|else = unsponsor
	 */
	public function sponsor()
	{
	    $iThreadId = (int)$this->get('thread_id');
	    $iType = (int)$this->get('type');

	    if (Phpfox::getService('forum.thread.process')->sponsor($iThreadId, $iType))
	    {
			// ajax call to change the hidden status for the spans
			if ($iType == '2')
			{
			    Phpfox::getService('ad.process')->addSponsor(array('module' => 'forum', 'section'=>'thread', 'item_id' => $iThreadId));
			    // making sponsored means hide sponsor and show unsponsor
			    $this->call('$("#js_sponsor_thread_'.$iThreadId.'").hide();');
			    $this->call('$("#js_unsponsor_thread_'.$iThreadId.'").show();');
			    $this->alert(Phpfox::getPhrase('forum.thread_successfully_sponsored'));
			}
			else
			{
			    Phpfox::getService('ad.process')->deleteAdminSponsor('forum-thread', $iThreadId);
			    $this->call('$("#js_sponsor_thread_'.$iThreadId.'").show();');
			    $this->call('$("#js_unsponsor_thread_'.$iThreadId.'").hide();');
			    $this->alert(Phpfox::getPhrase('forum.thread_successfully_unsponsored'));
			}
	    }
	    else
	    {
		// bad attempt

	    }
	}
	
	public function approvePost()
	{
		Phpfox::getUserParam('forum.can_approve_forum_post', true);
		if (Phpfox::getService('forum.post.process')->approve($this->get('post_id')))
		{
			$this->call('$(\'#post' . $this->get('post_id') . '\').find(\'.forum_content:first\').removeClass(\'row_moderate\');');
		}
	}
	
	public function thanks()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('forum.can_thank_on_forum_posts', true);
		if ($iThankId = Phpfox::getService('forum.post.process')->thank($this->get('post_id')))
		{
			$this->show('#js_thank_' . $this->get('post_id'));
			
			$sDeleteImage = '<a href="#" onclick="$(this).parents(\'span:first\').remove(); var iSpanCount = 0; $(\'#js_thank_' . $this->get('post_id') . '\').find(\'span\').each(function(){iSpanCount++;}); if (iSpanCount == 0) { $(\'#js_thank_' . $this->get('post_id') . '\').hide(); } $.ajaxCall(\'forum.removeThanks\', \'thank_id=' . $iThankId . '\'); return false;" title="' . Phpfox::getPhrase('forum.remove_this_thank_you') . '">' . Phpfox::getLib('image.helper')->display(array('theme' => 'misc/delete.gif', 'class' => 'v_middle')) . '</a>';
			
			if ($this->get('new'))
			{
				$this->html('#js_thank_body_' . $this->get('post_id'), '<span>' . $sDeleteImage. '<a href="' . Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')) . '">' . Phpfox::getUserBy('full_name') . '</a></span>');
			}
			else 
			{
				$this->append('#js_thank_body_' . $this->get('post_id'), '<span>, ' . $sDeleteImage . '<a href="' . Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name')) . '">' . Phpfox::getUserBy('full_name') . '</a></span>');
			}
		}
	}
	
	public function removeThanks()
	{
		Phpfox::isUser(true);
		Phpfox::getService('forum.post.process')->deleteThanks($this->get('thank_id'));
	}
	
	public function loadPermissions()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('forum.can_manage_forum_permissions', true);
		if ($this->get('user_group_id'))
		{
			$this->template()->assign('aPerms', Phpfox::getService('forum')->getUserGroupAccess($this->get('forum_id'), $this->get('user_group_id')))->getTemplate('forum.block.admincp.permission');
			$aUserGroup = Phpfox::getService('user.group')->getGroup($this->get('user_group_id'));			
			
			$this->slideDown('#js_display_perms')
				->show('#js_save_perms')
				->html('#js_form_perm_group', $aUserGroup['title'])
				->html('#js_display_list_perms', $this->getContent(false));
		}
	}
	
	public function savePerms()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('forum.can_manage_forum_permissions', true);
		if (Phpfox::getService('forum.process')->savePerms($this->get('val')))
		{
			$this->softNotice('Permissions Saved Successfully');
		}
	}
	
	public function permReset()
	{
		Phpfox::getService('forum.process')->resetPerms($this->get('forum_id'), $this->get('user_group_id'));
		$this->template()->assign('aPerms', Phpfox::getService('forum')->getUserGroupAccess($this->get('forum_id'), $this->get('user_group_id')))->getTemplate('forum.block.admincp.permission');
		$this->html('#js_display_list_perms', $this->getContent(false));
	}
	
	public function deletePoll()
	{
		if (Phpfox::getService('user.auth')->hasAccess('poll', 'poll_id', $this->get('poll_id'), 'poll.poll_can_delete_own_polls', 'poll.poll_can_delete_others_polls'))
		{
			Phpfox::getService('poll.process')->moderatePoll($this->get('poll_id'), 2);
			Phpfox::getLib('database')->update(Phpfox::getT('forum_thread'), array('poll_id' => '0'), 'thread_id = ' . (int) $this->get('thread_id'));
			$this->show('#js_attach_poll')->html('#js_attach_poll_question', '');
		}
	}
	
	public function reply()
	{	
		if (!$this->get('edit') && !$this->get('quote'))
		{
			$this->setTitle(Phpfox::getPhrase('forum.post_a_reply'));
		}
		Phpfox::getComponent('forum.post', array(), 'controller');	

		(($sPlugin = Phpfox_Plugin::get('forum.component_ajax_reply')) ? eval($sPlugin) : false);
		
		echo '<script type="text/javascript"> '. (Phpfox::getParam('core.wysiwyg') == 'default' ? 'Editor.getEditor();': '').'$Core.loadInit();</script>';
	}
	
	public function moderation()
	{
		Phpfox::isUser(true);
		
		switch ($this->get('action'))
		{
			case 'approve':
				Phpfox::getUserParam('forum.can_approve_forum_thread', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('forum.thread.process')->approve($iId);
					$this->remove('.js_selector_class_' . $iId);					
				}				
				$this->updateCount();
				$sMessage = Phpfox::getPhrase('forum.thread_s_successfully_approved');
				break;			
			case 'delete':
				Phpfox::getUserParam('forum.can_delete_other_posts', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('forum.thread.process')->delete($iId);
					$this->slideUp('.js_selector_class_' . $iId);
				}				
				$sMessage = Phpfox::getPhrase('forum.thread_s_successfully_deleted');
				break;
		}

		$this->alert($sMessage, 'Moderation', 300, 150, true);
		$this->hide('.moderation_process');
	}
	
	public function postModeration()
	{
		Phpfox::isUser(true);	
		
		switch ($this->get('action'))
		{
			case 'approve':
				Phpfox::getUserParam('forum.can_approve_forum_thread', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('forum.post.process')->approve($iId);
					$this->call('if ($(\'#post' . $iId . '\').find(\'.row_content\').hasClass(\'row_moderate\')) { $(\'#post' . $iId . '\').find(\'.row_content\').removeClass(\'row_moderate\'); } else { $(\'#post' . $iId . '\').remove(); }');		
				}				
				$this->updateCount();
				$sMessage = Phpfox::getPhrase('forum.post_s_successfully_approved');
				break;			
			case 'delete':
				Phpfox::getUserParam('forum.can_delete_other_posts', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('forum.post.process')->delete($iId);
					$this->slideUp('#post' . $iId);
				}				
				$sMessage = Phpfox::getPhrase('forum.post_s_successfully_deleted');
				break;
		}
		
		$this->alert($sMessage, 'Moderation', 300, 150, true);
		$this->hide('.moderation_process');			
	}	
}

?>
