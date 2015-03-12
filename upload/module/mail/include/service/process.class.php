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
 * @package  		Module_Mail
 * @version 		$Id: process.class.php 7091 2014-02-05 15:10:47Z Fern $
 */
class Mail_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('mail');
	}
	
	public function add($aVals)
	{
		if (isset($aVals['copy_to_self']) && $aVals['copy_to_self'] == 1)
		{
			$aVals['to'][] = Phpfox::getUserId();
			unset($aVals['copy_to_self']);
			return $this->add($aVals);
		}		
		
		$bIsThreadReply = false;
		if (!isset($aVals['to']) && !empty($aVals['thread_id']) && Phpfox::getParam('mail.threaded_mail_conversation') && !isset($aVals['claim_page']))
		{
			$bIsThreadReply = true;
			$aPastThread = $this->database()->select('mt.*')
				->from(Phpfox::getT('mail_thread'), 'mt')
				->join(Phpfox::getT('mail_thread_user'), 'mtu', 'mtu.thread_id = mt.thread_id AND mtu.user_id = ' . Phpfox::getUserId())
				->where('mt.thread_id = ' . (int) $aVals['thread_id'])
				->execute('getSlaveRow');	
			
			if (!isset($aPastThread['thread_id']))
			{
				return Phpfox_Error::set('Unable to find this conversation');
			}
			
			$aThreadUsers = $this->database()->select('*')
				->from(Phpfox::getT('mail_thread_user'))
				->where('thread_id = ' . (int) $aPastThread['thread_id'])
				->execute('getSlaveRows');

			$aOriginal = array();
			foreach ($aThreadUsers as $aThreadUser)
			{
				if ($aThreadUser['user_id'] == Phpfox::getUserId())
				{
					continue;
				}
				$aOriginal[] = $aThreadUser['user_id'];
			}
		}

		$iSentTo = 0;
		if (isset($aVals['to']) && is_array($aVals['to']) && !Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			$aCache = array();			
			foreach ($aVals['to'] as $mTo)
			{				
				if ($mTo != Phpfox::getUserId())
				{
					++$iSentTo;
				}
				
				if (Phpfox::getUserParam('mail.send_message_to_max_users_each_time') > 0
					&& $iSentTo > Phpfox::getUserParam('mail.send_message_to_max_users_each_time'))
				{
					return Phpfox_Error::set(Phpfox::getPhrase('mail.too_many_users_this_message_was_sent_to_the_first_total_users', array('total' => Phpfox::getUserParam('mail.send_message_to_max_users_each_time'))));
				}
				
				if (strstr($mTo, ','))
				{
					$aParts = explode(',', $mTo);
					foreach ($aParts as $mUser)
					{					
						$aVals['to'] = trim($mUser);
						
						if (empty($aVals['to']))
						{
							continue;
						}
						
						// Make sure we found a user
						if (($iTemp = $this->add($aVals, true)) && is_numeric($iTemp))
						{
							$aCache[] = $iTemp;	
						}
					}
				}
				else 
				{
					$aVals['to'] = $mTo;
					
					if (empty($aVals['to']))
					{
						continue;
					}
					
					// Make sure we found a user
					if (($iTemp = $this->add($aVals, true)) && is_numeric($iTemp))
					{						
						$aCache[] = $iTemp;	
					}
				}
				
			}			
			
			if ((Phpfox::getUserParam('mail.can_add_attachment_on_mail') && !empty($aVals['attachment'])) && count($aCache))
			{
				$aLastCache = array_reverse($aCache);
				
				foreach ($aCache as $iMailId)
				{
					$this->database()->update($this->_sTable, array('mass_id' => $aLastCache[0]), 'mail_id = ' . (int) $iMailId);	
				}
			}

			if (empty($aCache))
			{
				return false;
			}
			
			return $aCache;	
		}		
		
			
		if (!$bIsThreadReply && Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			$aOriginal = $aVals['to'];
			$aVals['to'] = $aVals['to'][0];
		}		
		
		if (!$bIsThreadReply)
		{
			$aDetails = Phpfox::getService('user')->getUser($aVals['to'], Phpfox::getUserField() . ', u.email, u.language_id, u.user_group_id', (is_numeric($aVals['to']) ? false : true));
			if (!isset($aDetails['user_id']))
			{
				return false;
			}

			if (!isset($aVals['claim_page']) && !Phpfox::getService('user.privacy')->hasAccess($aDetails['user_id'], 'mail.send_message'))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('mail.unable_to_send_a_private_message_to_full_name_as_they_have_disabled_this_option_for_the_moment', array('full_name' => $aDetails['full_name'])));
			}		
			
			// Check if user is allowed to receive messages: http://forums.phpfox.com/project.php?issueid=2216
			if (Phpfox::getService('user.group.setting')->getGroupParam($aDetails['user_group_id'], 'mail.override_mail_box_limit') == false)
			{
				if (!Phpfox::getParam('mail.threaded_mail_conversation'))
				{
					$iMailBoxLimit = Phpfox::getService('user.group.setting')->getGroupParam($aDetails['user_group_id'], 'mail.mail_box_limit');			
					$iCurrentMessages = $this->database()
						->select('COUNT(viewer_user_id)')
						->from($this->_sTable)
						->where('viewer_user_id = ' . (int)$aVals['to'] . ' AND viewer_type_id != 3 AND viewer_type_id != 1')
						->execute('getSlaveField');
	
					if ($iCurrentMessages >= $iMailBoxLimit)
					{
						return Phpfox_Error::set(Phpfox::getPhrase('mail.user_has_reached_their_inbox_limit'));
					}
				}
			}

			if ($aVals['to'] == Phpfox::getUserId() && !Phpfox::getUserParam('mail.can_message_self'))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('mail.you_cannot_message_yourself'));
			}
			
			// check if user can send message to non friends: http://forums.phpfox.com/project.php?issueid=2216
			if (Phpfox::getUserParam('mail.restrict_message_to_friends') && !(Phpfox::getService('user.group.setting')->getGroupParam($aDetails['user_group_id'],'mail.override_restrict_message_to_friends')))
			{
				(($sPlugin = Phpfox_Plugin::get('mail.service_process_add_1')) ? eval($sPlugin) : false);
				if (isset($sPluginError))
				{
					return false;
				}
				if (!Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $aVals['to']))
				return Phpfox_Error::set(Phpfox::getPhrase('mail.you_can_only_message_your_friends'));
			}		
			
			$aVals = array_merge($aVals, $aDetails);
		}
		
		$oFilter = Phpfox::getLib('parse.input');
		$oParseOutput = Phpfox::getLib('parse.output');
		
		$bHasAttachments = (Phpfox::getUserParam('mail.can_add_attachment_on_mail') && !empty($aVals['attachment']));		
		
		if (isset($aVals['parent_id']))
		{
			$aMail = $this->database()->select('m.mail_id, m.owner_user_id, m.subject, u.email, u.language_id')
				->from($this->_sTable, 'm')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = m.owner_user_id')
				->where('m.mail_id = ' . (int) $aVals['parent_id'] . ' AND viewer_user_id = ' . Phpfox::getUserId())
				->execute('getSlaveRow');
				
			if (!isset($aMail['mail_id']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('mail.not_a_valid_message'));
			}
			
			$aVals['user_id'] = $aMail['owner_user_id'];
			$aVals['subject'] = $aMail['subject'];
			$aVals['email'] = $aMail['email'];
			$aVals['language_id'] = $aMail['language_id'];
		}
		Phpfox::getService('ban')->checkAutomaticBan((isset($aVals['subject']) ? $aVals['subject'] : '') . ' ' . $aVals['message']);
		$aVals['subject'] = (isset($aVals['subject']) ? $oFilter->clean($aVals['subject'], 255) : null);
		
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{			
			$aUserInsert = array_merge(array(Phpfox::getUserId()), $aOriginal);			

			sort($aUserInsert, SORT_NUMERIC);
			
			if (!$bIsThreadReply)
			{						
				$sHashId = md5(implode('', $aUserInsert));

				$aPastThread = $this->database()->select('*')
					->from(Phpfox::getT('mail_thread'))
					->where('hash_id = \'' . $this->database()->escape($sHashId) . '\'')
					->execute('getSlaveRow');
			}			
			
			$aThreadUsers = $this->database()->select(Phpfox::getUserField() . ', u.email, u.language_id, u.user_group_id')
				->from(Phpfox::getT('mail_thread_user'), 'mtu')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = mtu.user_id')
				->where('mtu.user_id IN(' . implode(', ', $aUserInsert) . ')')
				->group('u.user_id')
				->execute('getSlaveRows');	

			foreach ($aThreadUsers as $aThreadUser)
			{
				if ($aThreadUser['user_id'] != Phpfox::getUserId() && !Phpfox::getService('user.privacy')->hasAccess($aThreadUser['user_id'], 'mail.send_message'))
				{
					return Phpfox_Error::set(Phpfox::getPhrase('mail.unable_to_send_a_private_message_to_full_name_as_they_have_disabled_this_option_for_the_moment', array('full_name' => $aThreadUser['full_name'])));
				}
			}			
			
			if (isset($aPastThread['thread_id']))
			{
				$iId = $aPastThread['thread_id'];
				
				$this->database()->update(Phpfox::getT('mail_thread'), array(				
						'time_stamp' => PHPFOX_TIME
					), 'thread_id = ' . (int) $iId
				);	
				
				$this->database()->update(Phpfox::getT('mail_thread_user'), array('is_sent_update' => '0', 'is_read' => '0', 'is_archive' => '0'), 'thread_id = ' . (int) $iId);
				$this->database()->update(Phpfox::getT('mail_thread_user'), array('is_read' => '1'), 'thread_id = ' . (int) $iId . ' AND user_id = ' . Phpfox::getUserId());
			}
			else
			{
				$iId = $this->database()->insert(Phpfox::getT('mail_thread'), array(
						'hash_id' => $sHashId,
						'time_stamp' => PHPFOX_TIME
					)
				);

				foreach ($aUserInsert as $iUserId)
				{
					$this->database()->insert(Phpfox::getT('mail_thread_user'), array(
							'thread_id' => $iId,
							'is_read' => ($iUserId == Phpfox::getUserId() ? '1' : '0'),
							'is_sent' => ($iUserId == Phpfox::getUserId() ? '1' : '0'),
							'is_sent_update' => ($iUserId == Phpfox::getUserId() ? '1' : '0'),
							'user_id' => (int) $iUserId
						)
					);
				}			
			}
			
			$iTextId = $this->database()->insert(Phpfox::getT('mail_thread_text'), array(
					'thread_id' => $iId,
					'time_stamp' => PHPFOX_TIME,
					'user_id' => Phpfox::getUserId(),
					'text' => $oFilter->prepare($aVals['message']),
					'is_mobile' => (Phpfox::isMobile() ? '1' : '0')
				)
			);	
			
			$this->database()->update(Phpfox::getT('mail_thread'), array('last_id' => (int) $iTextId), 'thread_id = ' . (int) $iId);
			
			// Send the user an email
			$sLink = Phpfox::getLib('url')->makeUrl('mail.thread', array('id' => $iId));
			
			foreach ($aThreadUsers as $aThreadUser)
			{
				if ($aThreadUser['user_id'] == Phpfox::getUserId())
				{
					continue;
				}
				
				(($sPlugin = Phpfox_Plugin::get('mail.service_process_add_2')) ? eval($sPlugin) : false);	
				if (isset($bPluginSkip) && $bPluginSkip === true)
				{
					continue;
				}
				
				Phpfox::getLib('mail')->to($aThreadUser['user_id'])
					->subject(array('mail.full_name_sent_you_a_message_on_site_title', array('full_name' => Phpfox::getUserBy('full_name'), 'site_title' => Phpfox::getParam('core.site_title')), false, null, $aThreadUser['language_id']))
					->message(array('mail.full_name_sent_you_a_message_no_subject', array(
								'full_name' => Phpfox::getUserBy('full_name'),
								'message' => $oFilter->clean(strip_tags(Phpfox::getLib('parse.bbcode')->cleanCode(str_replace(array('&lt;', '&gt;'), array('<', '>'), $aVals['message'])))),
								'link' => $sLink
							)
						)
					)
					->notification('mail.new_message')
					->send();				
			}
			
			// If we uploaded any attachments make sure we update the 'item_id'
			if ($bHasAttachments)
			{
				Phpfox::getService('attachment.process')->updateItemId($aVals['attachment'], Phpfox::getUserId(), $iTextId);
				
				$this->database()->update(Phpfox::getT('mail_thread_text'), array('total_attachment' => Phpfox::getService('attachment')->getCountForItem($iTextId, 'mail')), 'message_id = ' . (int) $iTextId);
			}			
			
			if (isset($aVals['forward_thread_id']) && !empty($aVals['forwards']))
			{
				$bHasForward = false;
				$aForwards = explode(',', $aVals['forwards']);
				foreach ($aForwards as $iForward)
				{
					$iForward = (int) trim($iForward);
					if (empty($iForward))
					{
						continue;
					}
					
					$bHasForward = true;
					$this->database()->insert(Phpfox::getT('mail_thread_forward'), array(
							'message_id' => $iTextId,
							'copy_id' => $iForward
						)
					);
				}
				
				if ($bHasForward)
				{
					$this->database()->update(Phpfox::getT('mail_thread_text'), array('has_forward' => '1'), 'message_id = ' . (int) $iTextId);
				}
			}
		}
		else
		{
			$aInsert = array(
				'parent_id' => (isset($aVals['parent_id']) ? $aVals['parent_id'] : 0),
				'subject' => $aVals['subject'],
				'preview' => $oFilter->clean(strip_tags(Phpfox::getLib('parse.bbcode')->cleanCode(str_replace(array('&lt;', '&gt;'), array('<', '>'), $aVals['message']))), 255),
				'owner_user_id' => Phpfox::getUserId(),
				'viewer_user_id' => $aVals['user_id'],		
				'viewer_is_new' => 1,
				'time_stamp' => PHPFOX_TIME,
				'time_updated' => PHPFOX_TIME,
				'total_attachment' => ($bHasAttachments ? Phpfox::getService('attachment')->getCount($aVals['attachment']) : 0),
			);

			$iId = $this->database()->insert($this->_sTable, $aInsert);		

			$this->database()->insert(Phpfox::getT('mail_text'), array(
					'mail_id' => $iId,
					'text' => $oFilter->clean($aVals['message']),
					'text_parsed' => $oFilter->prepare($aVals['message'])
				)
			);
			
			// Send the user an email
			$sLink = Phpfox::getLib('url')->makeUrl('mail.view', array('id' => $iId));
			Phpfox::getLib('mail')->to($aVals['user_id'])
				->subject(array('mail.full_name_sent_you_a_message_on_site_title', array('full_name' => Phpfox::getUserBy('full_name'), 'site_title' => Phpfox::getParam('core.site_title')), false, null,$aVals['language_id']))
				->message(array('mail.full_name_sent_you_a_message_subject_subject', array(
							'full_name' => Phpfox::getUserBy('full_name'),
							'subject' => $aVals['subject'],
							'message' => $oFilter->clean(strip_tags(Phpfox::getLib('parse.bbcode')->cleanCode(str_replace(array('&lt;', '&gt;'), array('<', '>'), $aVals['message'])))),
							'link' => $sLink
						)
					)
				)
				->notification('mail.new_message')
				->send();			
			
			// If we uploaded any attachments make sure we update the 'item_id'
			if ($bHasAttachments)
			{
				Phpfox::getService('attachment.process')->updateItemId($aVals['attachment'], Phpfox::getUserId(), $iId);
			}			
		}			
		
		(($sPlugin = Phpfox_Plugin::get('mail.service_process_add')) ? eval($sPlugin) : false);	
		
		return $iId;
	}	
	
	/**
	 * This function is the cron job to delete old messages. It sends messages to the trash can.
	 * Old messages are settable in the admin panel in the setting mail.message_age_to_delete and this function
	 * is ran every mail.cron_delete_messages_delay, it can also be completely shut off with the setting enable_cron_delete_old_mail
	 */
	public function cronDeleteMessages()
	{
		
		// an extra check:
		if (!Phpfox::getParam('mail.enable_cron_delete_old_mail')) return false;
		(($sPlugin = Phpfox_Plugin::get('mail.service_process_cronDeleteMessages_start')) ? eval($sPlugin) : false);
		
		$iTime = (Phpfox::getTime() - (Phpfox::getParam('mail.message_age_to_delete') * CRON_ONE_DAY));
		
		// delete from trashcan the ones already deleted
		$this->database()->update($this->_sTable, array('viewer_type_id' => 3), 'time_updated < ' . $iTime . ' AND viewer_type_id = 1');
		$this->database()->update($this->_sTable, array('owner_type_id' => 3), 'time_updated < ' . $iTime. ' AND owner_type_id = 1');
		
		// delete from inbox the message that are old than the time above
		// Inbox
		$this->database()->update($this->_sTable, array('viewer_type_id' => 1), 'time_updated < ' . $iTime . ' AND viewer_type_id = 0');
		// Sentbox
		
		$this->database()->update($this->_sTable, array('owner_type_id' => 1), 'time_updated < ' . $iTime. ' AND owner_type_id = 0');		
		(($sPlugin = Phpfox_Plugin::get('mail.service_process_cronDeleteMessages_end')) ? eval($sPlugin) : false);		
	}
	
	public function toggleView($iId, $bRemove = false)
	{		
		$this->database()->update(Phpfox::getT('mail'), array('viewer_is_new' => ($bRemove ? 1 : 0)), 'mail_id = ' . (int) $iId .' AND viewer_user_id = ' . Phpfox::getUserId());			
		
		(($sPlugin = Phpfox_Plugin::get('mail.service_process_toggleview')) ? eval($sPlugin) : false);
		
		return true;
	}	
	
	public function delete($iId, $bSent = false)
	{
		$aMail = Phpfox::getService('mail')->getMail($iId);
		
		if ($aMail['viewer_user_id'] == $aMail['owner_user_id'])
		{
			$this->database()->update($this->_sTable, array(($bSent === false ? 'owner_type_id' : 'viewer_type_id') => 1), 'mail_id = ' . (int) $iId . ' AND ' . ($bSent === false ? 'viewer_user_id' : 'owner_user_id') . ' = ' . Phpfox::getUserId());
		}
				
		$this->database()->update($this->_sTable, array(($bSent === false ? 'viewer_type_id' : 'owner_type_id') => 1), 'mail_id = ' . (int) $iId . ' AND ' . ($bSent === false ? 'viewer_user_id' : 'owner_user_id') . ' = ' . Phpfox::getUserId());		

		(($sPlugin = Phpfox_Plugin::get('mail.service_process_delete')) ? eval($sPlugin) : false);
		
		return true;
	}

	/**
	 * Delicate function, physically deletes a message from the mail and mail_text tables
	 * @param int $iId
	 * @return true
	 */
	public function adminDelete($iId)
	{
		Phpfox::getUserParam('admincp.has_admin_access', true);
		Phpfox::getUserParam('mail.can_read_private_messages', true); // they need to see it in order to delete it
		Phpfox::getUserParam('mail.can_delete_others_messages', true);
		
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			$aMail = $this->database()->select('thread_id')
				->from(Phpfox::getT('mail_thread'))
				->where('thread_id = ' . (int) $iId)
				->execute('getSlaveRow');
			
			if (!isset($aMail['thread_id']))
			{
				return false;
			}			
			
			$this->database()->delete(Phpfox::getT('mail_thread'), 'thread_id = ' . (int)$iId);
			$this->database()->delete(Phpfox::getT('mail_thread_text'), 'thread_id = ' . (int)$iId);
			$this->database()->delete(Phpfox::getT('mail_thread_user'), 'thread_id = ' . (int)$iId);
		}
		else
		{
			$aMail = $this->database()->select('mail_id, viewer_user_id')
				->from(Phpfox::getT('mail'))
				->where('mail_id = ' . (int) $iId)
				->execute('getSlaveRow');
				
			if (!isset($aMail['mail_id']))
			{
				return false;
			}
	
			// do some logging before deleting?
			$this->database()->delete($this->_sTable, 'mail_id = ' . (int)$iId);
			$this->database()->delete(Phpfox::getT('mail_text'), 'mail_id = ' . (int)$iId);
		}		
		
		return true;
	}
	
	public function deleteTrash($iId)
	{		
		$this->database()->update($this->_sTable, array('viewer_type_id' => 3), 'mail_id = ' . (int) $iId . ' AND viewer_user_id = ' . Phpfox::getUserId() . ' AND viewer_type_id = 1');
		$this->database()->update($this->_sTable, array('owner_type_id' => 3), 'mail_id = ' . (int) $iId . ' AND owner_user_id = ' . Phpfox::getUserId() . ' AND owner_type_id = 1');		
		
		(($sPlugin = Phpfox_Plugin::get('mail.service_process_deletetrash')) ? eval($sPlugin) : false);
		
		return true;
	}	
	
	public function undelete($iId)
	{	
		$this->database()->update($this->_sTable, array('viewer_type_id' => 0), 'mail_id = ' . (int) $iId . ' AND viewer_user_id = ' . Phpfox::getUserId() . ' AND viewer_type_id = 1');
		$this->database()->update($this->_sTable, array('owner_type_id' => 0), 'mail_id = ' . (int) $iId . ' AND owner_user_id = ' . Phpfox::getUserId() . ' AND owner_type_id = 1');
		
		(($sPlugin = Phpfox_Plugin::get('mail.service_process_undelete')) ? eval($sPlugin) : false);
		
		return true;
	}
	
	public function toggleRead($iId)
	{
		$aMail = $this->database()->select('*')
			->from(Phpfox::getT('mail'))
			->where('mail_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		if (!isset($aMail['mail_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('mail.unable_to_find_the_message_you_are_trying_to_mark_as_read_unread'));
		}
		
		if ($aMail['viewer_user_id'] != Phpfox::getUserId())
		{
			return Phpfox_Error::set(Phpfox::getPhrase('mail.unable_to_find_the_message_you_are_trying_to_mark_as_read_unread'));
		}
		
		if ($aMail['viewer_is_new'])
		{
			$this->database()->update(Phpfox::getT('mail'), array('viewer_is_new' => '0'), 'mail_id = ' . $aMail['mail_id']);
		}
		else
		{
			$this->database()->update(Phpfox::getT('mail'), array('viewer_is_new' => '1'), 'mail_id = ' . $aMail['mail_id']);
		}
		
		return true;
	}
	
	public function threadIsRead($iThreadId)
	{
		 $this->database()->update(Phpfox::getT('mail_thread_user'), array('is_read' => '1'), 'thread_id = ' . (int) $iThreadId . ' AND user_id = ' . Phpfox::getUserId());		
	}
	
	public function toggleThreadIsRead($iThreadId)
	{
		$aMail = $this->database()->select('*')
			->from(Phpfox::getT('mail_thread_user'))
			->where('thread_id = ' . (int) $iThreadId . ' AND user_id = ' . Phpfox::getUserId())
			->execute('getSlaveRow');
		
		if (!isset($aMail['thread_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('mail.unable_to_find_the_message_you_are_trying_to_mark_as_read_unread'));
		}		
		
		$this->database()->update(Phpfox::getT('mail_thread_user'), array('is_read' => ($aMail['is_read'] ? '0' : '1')), 'thread_id = '. (int) $aMail['thread_id'] . ' AND user_id = ' . Phpfox::getUserId());
	}	
	
	public function archiveThread($iThreadId, $iArchive = 1)
	{		 
		 $this->database()->update(Phpfox::getT('mail_thread_user'), array('is_read' => '1', 'is_archive' => (int) $iArchive), 'thread_id = ' . (int) $iThreadId . ' AND user_id = ' . Phpfox::getUserId());
	}	

	
	public function markAllRead()
	{
		$aMessages = $this->database()->select('mail_id')
			->from(Phpfox::getT('mail'))
			->where('viewer_user_id = ' . Phpfox::getUserId())
			->execute('getSlaveRows');
		
		$aMailId = array();
		foreach ($aMessages as $aMessage)
		{
			$aMailId[] = $aMessage['mail_id'];
		}
		
		$this->database()->update(Phpfox::getT('mail'), array('viewer_is_new' => '0'), 'mail_id IN (' . implode(',', $aMailId) . ')');
		
		
		$aMessages = $this->database()->select('thread_id')
			->from(Phpfox::getT('mail_thread_user'))
			->where('user_id = ' . Phpfox::getUserId())
			->execute('getSlaveRows');
		$aMailId = array();
		foreach ($aMessages as $aMessage)
		{
			$aMailId[] = $aMessage['thread_id'];
		}
		$this->database()->update(Phpfox::getT('mail_thread_user'), array('is_read' => '1'), 'thread_id IN (' . implode(',', $aMailId) . ')');
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
		if ($sPlugin = Phpfox_Plugin::get('mail.service_process__call'))
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
