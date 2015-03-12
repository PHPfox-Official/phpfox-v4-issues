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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 * @todo Update error display()
 */
class Forum_Component_Controller_Post extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		$bCanEditPersonalData = true;
		$aCallback = false;
		if ($this->request()->get('module'))
		{
		    $this->template()->assign(array('bIsGroup' => '1'));
		}

		if (($sModule = $this->request()->get('module')) 
			&& Phpfox::isModule($sModule) 
			&& ($iItemId = $this->request()->getInt('item'))
			&& Phpfox::hasCallback($sModule, 'addForum')
		)
		{
			$aCallback = Phpfox::callback($sModule . '.addForum', $iItemId);			

			$this->template()->setBreadcrumb(Phpfox::getPhrase('forum.pages'), $this->url()->makeUrl('pages'));
			$this->template()->setBreadcrumb($aCallback['title'], $aCallback['url_home']);
			$this->template()->setBreadcrumb(Phpfox::getPhrase('forum.discussions'), $aCallback['url_home'] . 'forum/');
			if ($sModule == 'pages' && !Phpfox::getService('pages')->hasPerm($iItemId, 'forum.share_forum'))
			{
				return Phpfox_Error::display(Phpfox::getPhrase('forum.unable_to_view_this_item_due_to_privacy_settings'));
			}			
		}
		else
		{
			$this->template()->setBreadcrumb(Phpfox::getPhrase('forum.forum'), $this->url()->makeUrl('forum'));
		}
		
		$iId = $this->request()->getInt('id');
		$aAccess = Phpfox::getService('forum')->getUserGroupAccess($iId, Phpfox::getUserBy('user_group_id'));
		if ($aAccess['can_view_thread_content']['value'] != true)
		{
			return Phpfox_Error::display(Phpfox::getPhrase('forum.unable_to_view_this_item_due_to_privacy_settings'));
		}

		if (Phpfox::isModule('poll'))
		{
			$this->template()->setHeader('cache', array(
					'poll.js' => 'module_poll',
					'<script type="text/javascript">$Behavior.loadSortableAnswers = function() {$(".sortable").sortable({placeholder: "placeholder", axis: "y"});}</script>'
				)
			);
		}
		
		if (Phpfox::isModule('video'))
		{
			$this->template()->setHeader('cache', array(
					'player/flowplayer/flowplayer.js' => 'static_script',
					'player/' . Phpfox::getParam('core.default_music_player') . '/core.js' => 'static_script'	
				)
			);
		}

		$this->template()->setEditor()
			->setTitle(Phpfox::getPhrase('forum.forum'))
			->setHeader('cache', array(
					'switch_legend.js' => 'static_script',
					'switch_menu.js' => 'static_script',
					'pager.css' => 'style_css',
					'forum.css' => 'style_css'
				)
			);			
		
		$bIsEdit = false;
		if ($this->request()->get('req3') == 'thread')
		{			
			if ($iEditId = $this->request()->getInt('edit'))
			{
				$aThread = Phpfox::getService('forum.thread')->getForEdit($iEditId);
				
				if (!isset($aThread['thread_id']))
				{
					return Phpfox_Error::display(Phpfox::getPhrase('forum.not_a_valid_thread'));
				}

				if ((Phpfox::getUserParam('forum.can_edit_own_post') && $aThread['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_edit_other_posts') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'edit_post'))
				{							
					$bIsEdit = true;
					if (Phpfox::getUserParam('forum.can_edit_other_posts') && Phpfox::getUserId() != $aThread['user_id'])
					{
						$bCanEditPersonalData = false;
					}					
					
					$iId = $aThread['forum_id'];

					if (Phpfox::isModule('tag'))
					{
					    $aThread['tag_list'] = Phpfox::getService('tag')->getForEdit('forum', $aThread['thread_id']);
					}
					
					$this->template()->assign(array(
							'aForms' => $aThread,
							'iEditId' => $aThread['thread_id']
						)
					);
				}
				else 
				{
					return Phpfox_Error::display(Phpfox::getPhrase('forum.insufficient_permission_to_edit_this_thread'));					
				}
			}
			
			if ($aCallback === false)
			{
				$aForum = Phpfox::getService('forum')
					->id($iId)
					->getForum();
				
				if (!isset($aForum['forum_id']))
				{
					return Phpfox_Error::display(Phpfox::getPhrase('forum.not_a_valid_forum'));
				}			
				
				if ($aForum['is_closed'])
				{
					return Phpfox_Error::display(Phpfox::getPhrase('forum.forum_is_closed'));
				}				
			}
			
			if (!$bIsEdit)
			{
				$bPass = false;		
				if (Phpfox::getUserParam('forum.can_add_new_thread') || Phpfox::getService('forum.moderate')->hasAccess($aForum['forum_id'], 'add_thread'))
				{
					$bPass = true;	
				}		
				
				if ($bPass === false)
				{
					return Phpfox_Error::display(Phpfox::getPhrase('forum.insufficient_permission_to_reply_to_this_thread'));
				}
			}			
			
			$aValidation = array(
				'title' => Phpfox::getPhrase('forum.provide_a_title_for_your_thread'),
				'text' => Phpfox::getPhrase('forum.provide_some_text')
			);
			
			if (Phpfox::isModule('captcha') && Phpfox::getUserParam('forum.enable_captcha_on_posting'))
			{
				$aValidation['image_verification'] = Phpfox::getPhrase('captcha.complete_captcha_challenge');
			}			
			
			$oValid = Phpfox::getLib('validator')->set(array(
					'sFormName' => 'js_form', 
					'aParams' => $aValidation
				)
			);				
			
			$bPosted = false;
			if ($aVals = $this->request()->getArray('val'))
			{				
				if (isset($aVals['type_id']) && $aVals['type_id'] == 'announcement')
				{
					$bPosted = true;
				}
				
				if ($oValid->isValid($aVals))
				{				
					if ($bIsEdit)
					{
						$aVals['post_id'] = $aThread['start_id'];
						$aVals['was_announcement'] = $aThread['is_announcement'];
						$aVals['forum_id'] = $aThread['forum_id'];
						
						if (Phpfox::getService('forum.thread.process')->update($aThread['thread_id'], $aThread['user_id'], $aVals))
						{
							$this->url()->permalink('forum.thread', $aThread['thread_id'], Phpfox::getLib('parse.input')->clean($aVals['title'], 255), true, Phpfox::getPhrase('forum.thread_successfully_updated'));
						}						
					}
					else 
					{
						if (($iFlood = Phpfox::getUserParam('forum.forum_thread_flood_control')) !== 0)
						{
							$aFlood = array(
								'action' => 'last_post', // The SPAM action
				 				'params' => array(
				 					'field' => 'time_stamp', // The time stamp field
				 					'table' => Phpfox::getT('forum_thread'), // Database table we plan to check
				 					'condition' => 'user_id = ' . Phpfox::getUserId(), // Database WHERE query
				 					'time_stamp' => $iFlood * 60 // Seconds);	
				 				)
				 			);
				 			
				 			// actually check if flooding
				 			if (Phpfox::getLib('spam')->check($aFlood))
				 			{		
				 				Phpfox_Error::set(Phpfox::getPhrase('forum.posting_a_new_thread_a_little_too_soon') . ' ' . Phpfox::getLib('spam')->getWaitTime());
				 			}											
						}
						
						if (Phpfox_Error::isPassed() && ($iId = Phpfox::getService('forum.thread.process')->add($aVals, $aCallback)))
						{
							$this->url()->permalink('forum.thread', $iId, Phpfox::getLib('parse.input')->clean($aVals['title'], 255), true);							
						}
					}
				}
			}
			
			if ($aCallback === false)
			{	
				$this->template()->setBreadcrumb($aForum['breadcrumb'])
					->setBreadcrumb($aForum['name'], $this->url()->permalink('forum', $aForum['forum_id'], $aForum['name']))
					->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('forum.editing_thread') . ': ' . $aThread['title'] : Phpfox::getPhrase('forum.post_new_thread')), $this->url()->makeUrl('forum.post.thread'), true);
			}
			else 
			{
				$this->template()					
					->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('forum.editing_thread') . ': ' . $aThread['title'] : Phpfox::getPhrase('forum.post_new_thread')), $this->url()->makeUrl('forum.post.thread'), true);	
			}
				
			$this->template()->assign(array(
						'iForumId' => $iId,
						'iActualForumId' => $iId,
						'sFormLink' => ($aCallback == false ? $this->url()->makeUrl('forum.post.thread', array('id' => $iId)) : $this->url()->makeUrl('forum.post.thread', array('module' => $sModule, 'item' => $iItemId))),
						'sCreateJs' => $oValid->createJS(),
						'sGetJsForm' => $oValid->getJsForm(),
						'sForumParents' => ($aCallback === false ? ((Phpfox::getUserParam('forum.can_post_announcement') || Phpfox::getService('forum.moderate')->hasAccess($aForum['forum_id'], 'post_announcement')) ? Phpfox::getService('forum')->active($aForum['forum_id'])->getJumpTool(true) : '') : ''),
						'bPosted' => $bPosted,
						'sReturnLink' => ($bIsEdit ? ($aCallback === false ? $this->url()->makeUrl('forum', array($aForum['name_url'] . '-' . $aForum['forum_id'], $aThread['title_url'])) : $this->url()->makeUrl($aCallback['url_home'] . '.forum', $aThread['title_url'])) : ''),						
						'bIsEdit' => $bIsEdit,
						'aCallback' => $aCallback
					)
				);
				
			if (Phpfox::getUserParam('forum.can_add_forum_attachments'))
			{
				$this->setParam('attachment_share', array(
						'type' => 'forum',
						'id' => 'js_forum_form'
					)
				);	
			}
		}
		else
		{
			if ($iEditId = $this->request()->getInt('edit'))
			{
				$aPost = Phpfox::getService('forum.post')->getForEdit($iEditId);
				
				if (!isset($aPost['post_id']))
				{
					return Phpfox_Error::display(Phpfox::getPhrase('forum.not_a_valid_post'));
				}
				
				$bCanEditPost = (Phpfox::getUserParam('forum.can_edit_own_post') && $aPost['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_edit_other_posts') || Phpfox::getService('forum.moderate')->hasAccess($aPost['forum_id'], 'edit_post');
				if ($bCanEditPost)
				{					
					$bIsEdit = true;
					if (Phpfox::getUserParam('forum.can_edit_other_posts') && Phpfox::getUserId() != $aPost['user_id'])
					{
						$bCanEditPersonalData = false;
					}					
					
					$iId = $aPost['thread_id'];					
					
					$this->template()->assign(array(
							'aForms' => $aPost,
							'iEditId' => $aPost['post_id']
						)
					);
					
					if (PHPFOX_IS_AJAX)
					{
						Phpfox::getLib('ajax')->setTitle(Phpfox::getPhrase('forum.editing_post') . ': ' . (empty($aPost['title']) ? '#' . $aPost['post_id'] : Phpfox::getLib('parse.output')->shorten($aPost['title'], 80, '...')));
					}
				}
				else 
				{
					return Phpfox_Error::display(Phpfox::getPhrase('forum.insufficient_permission_to_edit_this_thread'));	
				}
			}			
			
			$aThread = Phpfox::getService('forum.thread')->getActualThread($iId, $aCallback);

			if (!isset($aThread['thread_id']))
			{
				return Phpfox_Error::display(Phpfox::getPhrase('forum.not_a_valid_thread'));
			}
			
			if ($aThread['is_closed'] && ( (isset($bCanEditPost) && !$bCanEditPost) || !isset($bCanEditPost)))
			{
				return Phpfox_Error::display(Phpfox::getPhrase('forum.thread_is_closed'));
			}			
			
			if ($aCallback === false && $aThread['forum_is_closed'])
			{
				return Phpfox_Error::display(Phpfox::getPhrase('forum.forum_is_closed'));
			}			
			
			if (!$iEditId && $aThread['is_announcement'])
			{
				return Phpfox_Error::display(Phpfox::getPhrase('forum.thread_is_an_announcement_not_allowed_to_leave_a_reply'));
			}			
			
			if (!$bIsEdit)
			{
				$bPass = false;		
				if ((Phpfox::getUserParam('forum.can_reply_to_own_thread') && $aThread['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('forum.can_reply_on_other_threads') || Phpfox::getService('forum.moderate')->hasAccess($aThread['forum_id'], 'can_reply'))
				{
					$bPass = true;	
				}		
				
				if ($bPass === false)
				{
					return Phpfox_Error::display(Phpfox::getPhrase('forum.insufficient_permission_to_reply_to_this_thread'));
				}
			}			
			
			$sExtraText = '';
			
			if ($sSavedText = $this->request()->get('save_text'))
			{
				$sExtraText .= Phpfox::getLib('parse.output')->clean($sSavedText);
			}
			
			if (Phpfox::getUserParam('forum.can_multi_quote_forum') && (($iQuote = $this->request()->getInt('quote')) || (($sCookie = Phpfox::getCookie('forum_quote')) && !empty($sCookie))))
			{				
				$sCookie = Phpfox::getCookie('forum_quote');
				if (!empty($sCookie))
				{
					$iQuote = $sCookie . $iQuote;				
				}
				
				$sExtraText .= Phpfox::getService('forum.post')->getQuotes($aThread['thread_id'], $iQuote);		
			}			
			
			if (($iQuoteId = $this->request()->getInt('quote')) && ($aQuotePost = Phpfox::getService('forum.post')->getForEdit($iQuoteId)))
			{
				Phpfox::getLib('ajax')->setTitle(Phpfox::getPhrase('forum.replying_to_a_post_by_full_name', array('full_name' => Phpfox::getLib('parse.output')->shorten($aQuotePost['full_name'], 80, '...'))));				
			}
			
			$aSubForms = array();
			if (isset($aThread['is_subscribed']))
			{
				$aSubForms['is_subscribed'] = $aThread['is_subscribed'];
			}			
			
			if (!empty($sExtraText))
			{
				$aSubForms['text'] = $sExtraText;
			}
			
			if (isset($bCanEditPost) && $bCanEditPost)
			{
				$aSubForms = array_merge($aSubForms, $aPost);
			}
			
			$this->template()->assign('aForms', $aSubForms);
			
			$aValidation = array(
				'text' => Phpfox::getPhrase('forum.provide_some_text')
			);
			
			if (Phpfox::isModule('captcha') && Phpfox::getUserParam('forum.enable_captcha_on_posting'))
			{
				$aValidation['image_verification'] = Phpfox::getPhrase('captcha.complete_captcha_challenge');
			}				
			
			$oValid = Phpfox::getLib('validator')->set(array(
					'sFormName' => 'js_form', 
					'aParams' => $aValidation
				)
			);				
			
			$aForum = Phpfox::getService('forum')
				->id($aThread['forum_id'])
				->getForum();			
			
			if ($aVals = $this->request()->getArray('val'))
			{
				$aVals['forum_id'] = $aThread['forum_id'];
		
				if ($oValid->isValid($aVals))
				{
					Phpfox::setCookie('forum_quote', '', -1);
					
					if ($bIsEdit)
					{
						if (Phpfox::getService('forum.post.process')->update($aPost['post_id'], $aPost['user_id'], $aVals))
						{
							$this->url()->permalink('forum', $aThread['thread_id'], $aThread['title'], true, null, array('post' => $aPost['post_id']));						
						}						
					}
					else
					{
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
				 				Phpfox_Error::set(Phpfox::getPhrase('forum.posting_a_reply_a_little_too_soon') . ' ' . Phpfox::getLib('spam')->getWaitTime());
				 			}											
						}				
						
						if (Phpfox_Error::isPassed())
						{
							if (($iId = Phpfox::getService('forum.post.process')->add($aVals, $aCallback)))
							{
								$this->url()->permalink('forum', $aThread['thread_id'], $aThread['title'], true, null, array('post' => $iId));
							}
							else 
							{
								if (Phpfox::getUserParam('forum.approve_forum_post'))
								{
									$this->url()->permalink('forum', $aThread['thread_id'], $aThread['title'], true, Phpfox::getPhrase('forum.your_post_has_successfully_been_added_however_it_is_pending_an_admins_approval_before_it_can_be_displayed_publicly'), array('post' => $iId));
								}								
							}
						}			
					}
				}
			}	
			
			if ($aCallback === false)
			{
				$this->template()->setBreadcrumb($aForum['breadcrumb'])
					->setBreadcrumb($aForum['name'], $this->url()->makeUrl('forum', $aForum['name_url'] . '-' . $aForum['forum_id']));
			}
			else 
			{
				
			}
			
			$this->template()
				->setBreadcrumb($aThread['title'], ($aCallback === false ? $this->url()->makeUrl('forum', array($aForum['name_url'] . '-' . $aForum['forum_id'], $aThread['title_url'])) : $this->url()->makeUrl($aCallback['url_home'] . '.forum', $aThread['title_url'])))
				->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('forum.editing_post') . ': ' . (empty($aPost['title']) ? '#' . $aPost['post_id'] : $aPost['title']) : Phpfox::getPhrase('forum.post_new_reply')), ($bIsEdit ? ($aCallback === false ? $this->url()->makeUrl('forum', array($aThread['forum_url'] . '-' . $aThread['forum_id'], $aThread['title_url'], 'post_' . $aPost['post_id'])) : $this->url()->makeUrl($aCallback['url_home'] . '.forum', array($aThread['title_url'], 'post' => $aPost['post_id']))) : null), true)
				->assign(array(
					'iThreadId' => $iId,
					'iActualForumId' => $aForum['forum_id'],
					'sFormLink' => ($aCallback === false ? $this->url()->makeUrl('forum.post.reply', array('id' => $iId)) : $this->url()->makeUrl('forum.post.reply', array('id' => $iId, 'module' => $sModule, 'item' => $iItemId))),
					'sCreateJs' => $oValid->createJS(),
					'sGetJsForm' => $oValid->getJsForm((PHPFOX_IS_AJAX ? false : true)),
					'sReturnLink' => ($bIsEdit ? ($aCallback === false ? $this->url()->makeUrl('forum', array($aThread['forum_url'] . '-' . $aThread['forum_id'], $aThread['title_url'], 'post_' . $aPost['post_id'])) : $this->url()->makeUrl($aCallback['url_home'] . '.forum', $aThread['title_url'])) : ''),
					'sThreadReturnLink' => ($aCallback === false ? $this->url()->makeUrl('forum', array($aThread['forum_url'] . '-' . $aThread['forum_id'], $aThread['title_url'])) : $this->url()->makeUrl($aCallback['url_home'], array('forum', $aThread['title_url']))),
					'aPreviews' => Phpfox::getService('forum.post')->getPreview($aThread['thread_id']),
					'iTotalPosts' => $aThread['total_post'],
					'bIsEdit' => $bIsEdit,
					'aCallback' => $aCallback,
					'iTotalPostPreview' => Phpfox::getParam('forum.total_forum_post_preview')
				)
			);

			if (Phpfox::getUserParam('forum.can_add_forum_attachments'))
			{
				$this->setParam('attachment_share', array(
						'type' => 'forum',
						'inline' => (PHPFOX_IS_AJAX ? true : false),
						'id' => 'js_forum_form',
						'edit_id' => ($bIsEdit ? $aPost['post_id'] : '')
					)
				);			
			}
		}		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_controller_post_clean')) ? eval($sPlugin) : false);
	}
}

?>
