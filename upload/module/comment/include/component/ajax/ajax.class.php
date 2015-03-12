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
 * @version 		$Id: ajax.class.php 7271 2014-04-14 18:46:05Z Fern $
 */
class Comment_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function add()
	{		
		$aVals = $this->get('val');		
		$bPassCaptcha = true;		
		$sVar = Phpfox::callback($aVals['type'] . '.getAjaxCommentVar');	
		if ($sVar !== null)
		{
			Phpfox::getUserParam($sVar, true);
		}
		
		if (!Phpfox::getUserParam('comment.can_post_comments'))
		{
			$this->html('#js_comment_process', '');
			$this->call("$('#js_comment_submit').removeAttr('disabled');");
			$this->hide('.js_feed_comment_process_form');
			$this->alert('Your user group is not allowed to add comments.');			
			
			return false;
		}
		
		(($sPlugin = Phpfox_Plugin::get('comment.component_ajax_ajax_add_start')) ? eval($sPlugin) : false);		
		
		if (isset($bNoCaptcha) && $bCaptchaFailed === true)
		{			
			$this->html('#js_comment_process', '');
			$this->call("$('#js_comment_submit').removeAttr('disabled');");					
			$this->alert(Phpfox::getPhrase('captcha.captcha_failed_please_try_again'));
			if (Phpfox::getParam('captcha.recaptcha') && $aVals['type'] != 'feed' && Phpfox::isModule('captcha') && Phpfox::getUserParam('captcha.captcha_on_comment'))
			{
				$this->call('Recaptcha.reload();');
			}
			
			return false;
		}		
		
		if ($aVals['type'] == 'profile' && !Phpfox::getService('user.privacy')->hasAccess($aVals['item_id'], 'comment.add_comment'))
		{
			$this->html('#js_comment_process', '');
			$this->call("$('#js_comment_submit').removeAttr('disabled');");								
			$this->alert(Phpfox::getPhrase('bulletin.you_do_not_have_permission_to_add_a_comment_on_this_persons_profile'));
			
			return false;
		}		
		
		if ($aVals['type'] == 'group' && (!Phpfox::getService('group')->hasAccess($aVals['item_id'], 'can_use_comments', true)))
		{
			$this->html('#js_comment_process', '');
			$this->call("$('#js_comment_submit').removeAttr('disabled');");					
			$this->alert(Phpfox::getPhrase('bulletin.only_members_of_this_group_can_leave_a_comment'));			
			
			return false;			
		}
		
		if (!Phpfox::getUserParam('comment.can_comment_on_own_profile') && $aVals['type'] == 'profile' && $aVals['item_id'] == Phpfox::getUserId() && empty($aVals['parent_id']))
		{
			$this->html('#js_comment_process', '');
			$this->call("$('#js_comment_submit').removeAttr('disabled');");					
			$this->alert(Phpfox::getPhrase('comment.you_cannot_write_a_comment_on_your_own_profile'));
			
			return false;
		}
		
		if (($iFlood = Phpfox::getUserParam('comment.comment_post_flood_control')) !== 0)
		{
			$aFlood = array(
				'action' => 'last_post', // The SPAM action
				'params' => array(
					'field' => 'time_stamp', // The time stamp field
					'table' => Phpfox::getT('comment'), // Database table we plan to check
					'condition' => 'type_id = \'' . Phpfox::getLib('database')->escape($aVals['type']) . '\' AND user_id = ' . Phpfox::getUserId(), // Database WHERE query
					'time_stamp' => $iFlood * 60 // Seconds);	
				)
			);
				 			
			// actually check if flooding
			if (Phpfox::getLib('spam')->check($aFlood))
			{	
				if (isset($aVals['is_via_feed']))
				{		
					$this->call('$(\'#js_feed_comment_form_' . $aVals['is_via_feed'] . '\').find(\'.js_feed_add_comment_button:first\').show();');
					$this->call('$(\'#js_feed_comment_form_' . $aVals['is_via_feed'] . '\').find(\'.js_feed_comment_process_form:first\').hide();');
				}
				else 
				{				
					$this->html('#js_comment_process', '');
					$this->call("$('#js_comment_submit').removeAttr('disabled');");
				}
				
				$this->alert(Phpfox::getPhrase('comment.posting_a_comment_a_little_too_soon_total_time', array('total_time' => Phpfox::getLib('spam')->getWaitTime())));
			 				
				return false;
			}		
		}
		
		if (Phpfox::getLib('parse.format')->isEmpty($aVals['text'])
			|| (isset($aVals['default_feed_value']) && $aVals['default_feed_value'] == $aVals['text']))
		{			
			if (isset($aVals['is_via_feed']))
			{		
				$this->call('$(\'#js_feed_comment_form_' . $aVals['is_via_feed'] . '\').find(\'.js_feed_add_comment_button:first\').show();');
				$this->call('$(\'#js_feed_comment_form_' . $aVals['is_via_feed'] . '\').find(\'.js_feed_comment_process_form:first\').hide();');
			}
			else 
			{				
				$this->html('#js_comment_process', '');
				$this->call("$('#js_comment_submit').removeAttr('disabled');");
			}			
			
			$this->alert(Phpfox::getPhrase('comment.add_some_text_to_your_comment'));
			$this->hide('.js_feed_comment_process_form');
			
			return false;
		}
		
		if (Phpfox::isModule('captcha') && !isset($bNoCaptcha) && Phpfox::getUserParam('captcha.captcha_on_comment') && !Phpfox::getService('captcha')->checkHash($aVals['image_verification']))
		{
			$bPassCaptcha = false;
			$this->call("$('#js_captcha_image').ajaxCall('captcha.reload', 'sId=js_captcha_image&sInput=image_verification');");			
			$this->alert(Phpfox::getPhrase('captcha.captcha_failed_please_try_again'), Phpfox::getPhrase('core.error'));
			if (Phpfox::getParam('core.wysiwyg') == 'tinymce' && Phpfox::getParam('core.allow_html'))
			{
				$this->call("tinyMCE.execCommand('mceSetContent',false, '" . str_replace("'", "\'", $aVals['text']) . "');");
			}
		}

		if ($bPassCaptcha)
		{
			if (($mId = Phpfox::getService('comment.process')->add($aVals)) === false)
			{				
				$this->html('#js_comment_process', '');
				$this->call("$('#js_comment_submit').removeAttr('disabled');");
				$this->hide('.js_feed_comment_process_form');
				$this->val('.js_comment_feed_textarea', '');
				// $this->alert(Phpfox::getPhrase('comment.cannot_comment_on_this_item_as_it_does_not_exist_any_longer'));		

				if (isset($aVals['is_via_feed']))
				{
					$this->hide('#js_feed_comment_form_' . $aVals['item_id'])->show('#js_feed_comment_form_mini_' . $aVals['item_id']);
				}
				
				return false;
			}

			$this->hide('#js_captcha_load_for_check');
			
			// Comment requires moderation
			if ($mId == 'pending_moderation')
			{
				$this->call("$('#js_comment_form')[0].reset();");
				$this->alert(Phpfox::getPhrase('comment.your_comment_was_successfully_added_moderated'));
			}
			else 
			{	
				$this->call('if (typeof(document.getElementById("js_no_comments")) != "undefined") { $("#js_no_comments").hide(); }');
				
				$aRow = Phpfox::getService('comment')->getComment($mId);	
				
				$iNewTotalPoints = (int) Phpfox::getUserParam('comment.points_comment');
				$this->call('if ($Core.exists(\'#js_global_total_activity_points\')){ var iTotalActivityPoints = parseInt($(\'#js_global_total_activity_points\').html().replace(\'(\', \'\').replace(\')\', \'\')); $(\'#js_global_total_activity_points\').html(iTotalActivityPoints + ' . $iNewTotalPoints . '); }');
				
				if (isset($aVals['is_via_feed']))
				{
					Phpfox::getLib('parse.output')->setImageParser(array('width' => 200, 'height' => 200));
					Phpfox::getLib('template')->assign(array('aComment' => $aRow, 'bForceNoReply' => true))->getTemplate('comment.block.mini');
					Phpfox::getLib('parse.output')->setImageParser(array('clear' => true));					
					
					$sId = 'js_tmp_comment_' . md5('comment_' . uniqid() . Phpfox::getUserId()) . '';
					
					if (isset($aVals['parent_id']) && $aVals['parent_id'] > 0)
					{
						$this->html('#js_comment_form_holder_' . $aVals['parent_id'], '');
						$this->append('#js_comment_children_holder_' . $aVals['parent_id'], '<div id="' . $sId . '">' . $this->getContent(false) . '</div>');
						
						if (Phpfox::getParam('core.wysiwyg') == 'tiny_mce')
						{
							if (isset($aVals['is_in_view']))
							{
								$this->call('Editor.setContent(\'\');');
							}
							else
							{
								$this->call('$(\'#js_feed_comment_form_textarea_' . $aVals['is_via_feed'] .'\').val($(\'.js_comment_feed_value\').html()).addClass(\'js_comment_feed_textarea_focus\').removeAttr(\'style\');');					
							}	
							
							$this->call('$(\'#js_feed_comment_form_textarea_' . $aVals['is_via_feed'] .'\').parent().find(\'.js_feed_comment_process_form:first\').hide();');							
						}
					}					
					else
					{
						if (isset($aVals['is_in_view']))
						{
							$this->call('Editor.setContent(\'\');');
						}
						else
						{
							$this->call('$(\'#js_feed_comment_form_textarea_' . $aVals['is_via_feed'] .'\').val($(\'.js_comment_feed_value\').html()).addClass(\'js_comment_feed_textarea_focus\').removeAttr(\'style\');');					
						}
						
						$this->call('$(\'#js_feed_comment_form_textarea_' . $aVals['is_via_feed'] .'\').parent().find(\'.js_feed_comment_process_form:first\').hide();');						
						$this->append('#js_feed_comment_post_' . $aVals['is_via_feed'], '<div id="' . $sId . '">' . $this->getContent(false) . '</div>');
					}
					
					$this->call('$(\'#' . $sId . '\').highlightFade();');					
				}
				else 
				{
					Phpfox::getLib('parse.output')->setImageParser(array('width' => 500, 'height' => 500));
					Phpfox::getLib('template')->assign(array('aRow' => $aRow, 'bCanPostOnItem' => false))->getTemplate('comment.block.entry');				
					Phpfox::getLib('parse.output')->setImageParser(array('clear' => true));
					
					if (isset($aVals['parent_id']) && $aVals['parent_id'] > 0)
					{
						$this->call("$('#js_comment_form_{$aVals['parent_id']}').slideUp(); $('#js_comment_form_form_{$aVals['parent_id']}').html(''); $('#js_comment_parent{$aVals['parent_id']}').html('<div style=\"margin-left:30px;\">" . $this->getContent() . "</div>' + $('#js_comment_parent{$aVals['parent_id']}').html()).slideDown(); $('#js_comment_form')[0].reset();");
					}
					else 
					{
						$this->call("$('#js_new_comment').html('" . $this->getContent() . "' + $('#js_new_comment').html()).slideDown(); $.scrollTo('#js_new_comment', 800); $('#js_comment_form')[0].reset();");
					}
					
					$this->call('$(\'#js_comment' . $aRow['comment_id'] . '\').find(\'.valid_message:first\').show().fadeOut(5000);');	
				}
			}

			if (!isset($aVals['is_via_feed']) && Phpfox::isModule('captcha') && Phpfox::getUserParam('captcha.captcha_on_comment') && !isset($bNoCaptcha))
			{
				$this->call("$('#js_captcha_image').ajaxCall('captcha.reload', 'sId=js_captcha_image&sInput=image_verification');");
			}			
			(($sPlugin = Phpfox_Plugin::get('comment.component_ajax_ajax_add_passed')) ? eval($sPlugin) : false);			
		}
		
		if (isset($aVals['is_via_feed']))
		{		
			
		}
		else 
		{	
			$this->html('#js_comment_process', '');
			$this->call("$('#js_comment_submit').removeAttr('disabled'); $('#js_reply_comment').val('0'); $('#js_reply_comment_info').html('');");
		}
		
		if (Phpfox::isModule('captcha') && !isset($bNoCaptcha) && Phpfox::getUserParam('captcha.captcha_on_comment'))
		{
			$this->call("$('#js_captcha_image').ajaxCall('captcha.reload', 'sId=js_captcha_image&sInput=image_verification');");
		}
		
		if ($aVals['type'] == 'photo')
		{
			$this->call("if (\$Core.exists('.js_feed_comment_view_more_holder')) { $('.js_feed_comment_view_more_holder')[0].scrollTop = $('.js_feed_comment_view_more_holder')[0].scrollHeight; }");
		}
		
		// http://www.phpfox.com/tracker/view/15074/
		// get the onclick atrribute
		$sCall = "sOnClick = $('#js_feed_comment_view_more_link_" . $aVals['is_via_feed'] . " .comment_mini_link .no_ajax_link').attr('onclick');";
		// if there is "view all comments" link
		$sCall .= "if (typeof sOnClick != 'undefined') {";
		// regex to get the params for the ajax call in this onlclick
		$sCall .= "sPattern = new RegExp('(comment_)?type_id=([a-z]+_?[a-z]*)&(amp;)?item_id=[0-9]+&(amp;)?feed_id=[0-9]+', 'i');";
		// save the current ajax params
		$sCall .= "sOnClickParam = sPattern.exec(sOnClick);";
		// replace the params, adding the new "added" variable
		$sCall .= "sNewOnClick = sOnClick.replace(sOnClickParam[0], sOnClickParam[0]+'&added=1');";
		// replace the onclick attribute
		$sCall .= "$('#js_feed_comment_view_more_link_" . $aVals['is_via_feed'] . " .comment_mini_link .no_ajax_link').attr('onclick', sNewOnClick);";
		// if there is "view all comments" link
		$sCall .= "}";
		// call this JS code
		$this->call($sCall);
		
		$this->call('$Core.loadInit();');
	}
	
	public function browse()
	{		
		Phpfox::getBlock('comment.view', array('iTotal' => $this->get('iTotal'), 'sType' => $this->get('sType'), 'iItemId' => $this->get('iItemId'), 'iPage' => $this->get('page')));		
		
		(($sPlugin = Phpfox_Plugin::get('comment.component_ajax_browse')) ? eval($sPlugin) : false);	
		
		$this->html('#js_comment_listing', $this->getContent(false));
		$this->call('$Core.loadInit(); $.scrollTo("#js_comment_listing", 340);');		
	}
	
	public function getQuote()
	{		
		$aRow = Phpfox::getService('comment')->getQuote($this->get('id'));
		if (isset($aRow['user_id']))
		{			
			$sText = Phpfox::getLib('parse.output')->ajax(str_replace("'", "\'", $aRow['text']));	
		
			(($sPlugin = Phpfox_Plugin::get('comment.component_ajax_get_quote')) ? eval($sPlugin) : false);
			
			if (!isset($bHasPluginCall))
			{				
				if (Phpfox::getParam('comment.wysiwyg_comments') && Phpfox::getUserParam('comment.wysiwyg_on_comments'))
				{
					$this->call("if (typeof(tinyMCE) != 'undefined') { tinyMCE.execCommand('mceInsertContent', false, \"\\n\" + '[quote=" . $aRow['user_id'] . "]" . $sText . "[/quote]' + \"\\n\\n\"); } else { $('#text').val($('#text').val() + \"\\n\" + '[quote=" . $aRow['user_id'] . "]" . $sText . "[/quote]' + \"\\n\\n\"); } $.scrollTo('#add-comment', 340); $('#text').focus();");
				}
				else 
				{
					$this->call("$('#text').val($('#text').val() + \"\\n\" + '[quote=" . $aRow['user_id'] . "]" . $sText . "[/quote]' + \"\\n\\n\"); $.scrollTo('#add-comment', 340); $('#text').focus();");
				}
			}
		}
	}
	
	public function updateText()
	{
		$sTxt = $this->get('quick_edit_input');
		
		if (Phpfox::getLib('parse.format')->isEmpty($sTxt))
		{
			$this->alert(Phpfox::getPhrase('comment.add_some_text_to_your_comment'));
			
			return false;	
		}
		
		if (Phpfox::getService('comment.process')->updateText($this->get('comment_id'), $sTxt))
		{
			Phpfox::getLib('parse.output')->setImageParser(array('width' => 500, 'height' => 500));
			if (Phpfox::getParam('core.allow_html'))
			{
				$sTxt = Phpfox::getLib('parse.output')->parse(Phpfox::getLib('parse.input')->prepare($sTxt));
			}
			else 
			{
				$sTxt = Phpfox::getLib('parse.output')->parse($sTxt);
			}
			Phpfox::getLib('parse.output')->setImageParser(array('clear' => true));

			// http://www.phpfox.com/tracker/view/15398/
			$sTxt = Phpfox::getLib('parse.output')->replaceUserTag($sTxt);

			$this->html('#' . $this->get('id'), $sTxt, '.highlightFade()');
			
			$this->html('#js_update_text_comment_'.$this->get('comment_id'),'<i>' . Phpfox::getPhrase('comment.last_update_on_time_stamp_by_full_name', array('time_stamp' => Phpfox::getTime(Phpfox::getParam('comment.comment_time_stamp'), PHPFOX_TIME), 'full_name' => Phpfox::getUserBy("full_name"))) . '</i>');
		}				
	}
	
	public function getText()
	{
		$aRow = Phpfox::getService('comment')->getCommentForEdit($this->get('comment_id'));
		
		(($sPlugin = Phpfox_Plugin::get('comment.component_ajax_get_text')) ? eval($sPlugin) : false);
		
		if (!isset($bHasPluginCall))
		{
			if ($this->get('simple'))
			{
				$this->call("$('#js_quick_edit_id" . $this->get('id') . "').html('<textarea style=\"width:95%; height:80px;\" name=\"quick_edit_input\" cols=\"90\" rows=\"10\" id=\"js_quick_edit" . $this->get('id') . "\">" . Phpfox::getLib('parse.output')->ajax($aRow['text']) . "</textarea>');");
			}
			else 
			{
				$this->call("$('#js_quick_edit_id" . $this->get('id') . "').html('<div id=\"sJsEditorMenu\" class=\"editor_menu\" style=\"display:block;\">' + Editor.setId('js_quick_edit" . $this->get('id') . "').getEditor(true) + '</div><textarea style=\"width:98%;\" name=\"quick_edit_input\" cols=\"90\" rows=\"10\" id=\"js_quick_edit" . $this->get('id') . "\">" . Phpfox::getLib('parse.output')->ajax($aRow['text']) . "</textarea>');");
			}
			
			if (Phpfox::getUserParam('comment.wysiwyg_on_comments') && Phpfox::getParam('core.wysiwyg') == 'tiny_mce')
			{			
				$this->call('customTinyMCE_init(\'js_quick_edit' . $this->get('id') . '\', \'comment\'); function js_quick_edit_callback(){$(\'#js_quick_edit' . $this->get('id') . '\').val(Editor.getContent());}');
			}
		}
	}
	
	public function deleteOnOwner()
	{
		
	}

	public function inlineDelete()
	{
		if (Phpfox::getService('comment.process')->deleteInline($this->get('comment_id'), $this->get('type_id')))
		{
			$this->slideUp('#js_comment_' . $this->get('comment_id'));
			if (!$this->get('photo_theater'))
			{
				// $this->alert(Phpfox::getPhrase('comment.comment_successfully_deleted'));
			}
			/*
			if ($this->get('type_id') == 'feed')
			{
				$this->html('#js_comment_' . $this->get('comment_id'), Phpfox::getPhrase('comment.comment_successfully_deleted'), '.fadeOut(5000)');
			}
			else 
			{
				$this->html('#js_comment' . $this->get('comment_id'), '<div class="comment_box">' . Phpfox::getPhrase('comment.comment_successfully_deleted') . '</div>', '.fadeOut(5000)')				
					->call("$('#js_pager_total').html(parseInt($('#js_pager_total').html()) - 1);")
					->call("$('#js_pager_to').html(parseInt($('#js_pager_to').html()) - 1);");
			}
			*/		
		} 
	}
	
	public function rate()
	{		
		Phpfox::isUser(true);
		Phpfox::getUserParam('comment.can_vote_on_comments', true);		
		
		list($sRating, $iLastVote) = Phpfox::getService('comment.process')->rate($this->get('id'), $this->get('type'));
		Phpfox::getBlock('comment.rating', array(
			'sRating' => (int) $sRating,
			'iCommentId' => $this->get('id'),
			'bHasRating' => true,
			'iLastVote' => $iLastVote
		));
		$this->html('#js_comment_rating' . $this->get('id'), $this->getContent(false));		
	}
	
	public function moderateSpam()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('comment.can_moderate_comments', true);
		
		if (Phpfox::getService('comment.process')->moderate($this->get('id'), $this->get('action'), true))
		{
			if ($this->get('inacp') || $this->get('action') == 'deny')
			{
				$this->hide('#js_comment' . $this->get('id'));					
			}
			
			$this->call('if ($(\'#js_request_comment_count_total\').length > 0) { var iTotalCommentRequest = parseInt($(\'#js_request_comment_count_total\').html()); $(\'#js_request_comment_count_total\').html(\'\' + parseInt((iTotalCommentRequest - 1)) + \'\'); if ((iTotalCommentRequest - 1) == 0) { $(\'#js_request_comment_holder\').remove(); } requestCheckData(); }');
		}		
	}
	
	public function moderate()
	{
		if (Phpfox::getService('comment.process')->moderate($this->get('id'), $this->get('action')))
		{
			if ($this->get('action') == 'approve')
			{
				$this->hide('#js_comment_' . $this->get('id'))->call('$(\'#js_comment_message_' . $this->get('id') . '\').show(\'slow\').fadeOut(5000);');
			}
			else 
			{
				$this->hide('#js_comment_' . $this->get('id'));
			}			
			
			$this->call('if ($(\'#js_request_comment_count_total\').length > 0) { var iTotalCommentRequest = parseInt($(\'#js_request_comment_count_total\').html()); $(\'#js_request_comment_count_total\').html(\'\' + parseInt((iTotalCommentRequest - 1)) + \'\'); if ((iTotalCommentRequest - 1) == 0) { $(\'#js_request_comment_holder\').remove(); } requestCheckData(); }');
		}
	}	
	
	public function viewAllComments()
	{
		$aComments = Phpfox::getService('comment')->getCommentsForFeed($this->get('comment_type_id'), $this->get('item_id'), 500, null, $this->get('comment_id'));
		
		foreach ($aComments as $aComment)
		{
			if (isset($aComment['children']))
			{
				foreach ($aComment['children']['comments'] as $aMini)
				{
					$this->template()->assign(array('aComment' => $aMini, 'aFeed' => array('feed_id' => $this->get('item_id'))))->getTemplate('comment.block.mini');
				}
			}
		}
		
		$this->html('#js_comment_children_holder_' . $this->get('comment_id'), $this->getContent(false));
		$this->remove('#comment_mini_child_view_holder_' . $this->get('comment_id'));
		$this->call('$Core.loadInit();');
	}
	
	public function viewMoreFeed()
	{		
		$aComments = Phpfox::getService('comment')->getCommentsForFeed($this->get('comment_type_id'), $this->get('item_id'), Phpfox::getParam('comment.comment_page_limit'), ($this->get('total') ? (int) $this->get('total') : null));		
		
		if (!count($aComments))
		{
			Phpfox_Error::set('No comments found.');
			
			return false;
		}
		
		// http://www.phpfox.com/tracker/view/15074/
		// if the added parameter is 1
		if($this->get('added') == 1)
		{
			// remove the last object, or it will be displayed as duplicate
			array_pop($aComments);
		}
		
		foreach ($aComments as $aComment)
		{
			$this->template()->assign(array('aComment' => $aComment, 'aFeed' => array('feed_id' => $this->get('item_id'))))->getTemplate('comment.block.mini');
		}
		
		if ($this->get('append'))
		{			
			$this->prepend('#js_feed_comment_view_more_' . ($this->get('feed_id') ? $this->get('feed_id') : $this->get('item_id')), $this->getContent(false));
			
			Phpfox::getLib('pager')->set(array(
					'ajax' => 'comment.viewMoreFeed', 
					'page' => Phpfox::getLib('request')->getInt('page'), 
					'size' => $this->get('pagelimit'), 
					'count' => $this->get('total'),
					'phrase' => 'View previous comments',
					'icon' => 'misc/comment.png',
					'aParams' => array(
						'comment_type_id' => $this->get('comment_type_id'),
						'item_id' => $this->get('item_id'),
						'append' => true,
						'pagelimit' => $this->get('pagelimit'),
						'total' => $this->get('total')
					)
				)
			);	
			
			$this->template()->getLayout('pager');		
			
			$this->html('#js_feed_comment_pager_' . ($this->get('feed_id') ? $this->get('feed_id') : $this->get('item_id')), $this->getContent(false));
		}
		else 
		{
			$this->hide('#js_feed_comment_view_more_link_' . ($this->get('feed_id') ? $this->get('feed_id') : $this->get('item_id')));
			$this->html('#js_feed_comment_view_more_' . ($this->get('feed_id') ? $this->get('feed_id') : $this->get('item_id')), $this->getContent(false));
		}
		
		$this->call('$Core.loadInit();');
	}	
	
	public function getChildren()
	{	
		$this->template()->assign(array(
					'bCanPostOnItem' => Phpfox::getUserParam(Phpfox::callback($this->get('type') . '.getAjaxCommentVar'))
			)
		);
		$this->_getChildren($this->get('comment_id'));
		
		$this->html('#js_comment_parent_view_' . $this->get('comment_id'), '<div style="margin-left:30px;">' . $this->getContent(false) . '</div>');
	}
	
	private function _getChildren($iId)
	{
		static $iCacheCnt = 0;
		
		$iCacheCnt++;
		
		list($iCnt, $aComments) = Phpfox::getService('comment')->get('cmt.*', array('cmt.parent_id = ' . $iId . ''), 'cmt.time_stamp DESC');
		foreach ($aComments as $iKey => $aComment)
		{
			// Assign template vars for this comment.	
			$this->template()->assign(array(
					'aRow' => $aComment,
					'bCanPostOnItem' => ($iCacheCnt >= Phpfox::getParam('comment.total_child_comments') ? false : true)
				)	
			);	
			
			// Display the comment	
			$this->template()->getTemplate('comment.block.entry');
			
			if ($aComment['child_total'] > 0)
			{
				echo '<div style="margin-left:30px;">' . "\n";
				$this->_getChildren($aComment['comment_id']);
				echo '</div>' . "\n";	
			}			
		}	
	}
}

?>
