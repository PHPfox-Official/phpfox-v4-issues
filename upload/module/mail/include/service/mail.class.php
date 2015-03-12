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
 * @version 		$Id: mail.class.php 7047 2014-01-16 13:28:17Z Fern $
 */
class Mail_Service_Mail extends Phpfox_Service
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('mail');
	}

	/**
	 * This function validates the permission to send a PM to another user, it 
	 * takes into account the user group setting: mail.can_compose_message
	 * the privacy setting by the receiving user: mail.send_message
	 * and if the receiving user is blocked by the sender user or viceversa
	 * Also checks on other user group based restrictions
	 * @param int $iUser The user id of the member trying to send a message
	 * @return boolean true if its ok to send the message, false otherwise
	 */
	public function canMessageUser($iUser)
	{
		(($sPlugin = Phpfox_Plugin::get('mail.service_mail_canmessageuser_1')) ? eval($sPlugin) : false);
		if (isset($bCanOverrideChecks))
		{
			return true;
		}
		// 1. user group setting:
		if (!Phpfox::getUserParam('mail.can_compose_message'))
		{			
			return false;
		}
		// 2. Privacy setting check
		$iPrivacy = $this->database()->select('user_value')
				->from(Phpfox::getT('user_privacy'))
				->where('user_id = ' . (int)$iUser . ' AND user_privacy = "mail.send_message"')
				->execute('getSlaveField');

		if (!empty($iPrivacy) && !Phpfox::isAdmin())
		{
			if ($iPrivacy == 4) // No one
			{				
				return false;
			}			
			else if($iPrivacy == 1 && !Phpfox::isUser()) // trivial case
			{				
				return false;
			}
			else if ($iPrivacy == 2 && !Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $iUser, false)) // friends only
			{				
				return false;
			}
		}

		// 3. Blocked users		
		if (!Phpfox::isAdmin() && (Phpfox::getService('user.block')->isBlocked(Phpfox::getUserId(), $iUser) > 0 || Phpfox::getService('user.block')->isBlocked($iUser, Phpfox::getUserId()) > 0))
		{			
			return false;
		}

		// 4. Sending message to oneself vs the setting mail.can_message_self
		if ($iUser == Phpfox::getUserId() && !Phpfox::getUserParam('mail.can_message_self'))
		{			
			return false;
		}

		// 5. User group setting (different from check 2 since that is user specific)		
		if ((Phpfox::getUserParam('mail.restrict_message_to_friends') == true)
			&& (Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $iUser, false) == false)
			&& (Phpfox::getUserParam('mail.override_restrict_message_to_friends') == false))
		{
			return false;
		}
		// then its ok
		return true;
	}
	
	public function get($aConds = array(), $sSort = 'm.time_updated DESC', $iPage = '', $iLimit = '', $bIsSentbox = false, $bIsTrash = false)
	{
		$aRows = array();
		$aInputs = array(
			'unread',
			'read'
		);
		
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			$iArchiveId = ($bIsTrash ? 1 : 0);
		}
		
		$bIsTextSearch = false;
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			if (!defined('PHPFOX_IS_PRIVATE_MAIL'))
			{
				$this->database()->select('COUNT(*)');
				if ($bIsSentbox)
				{
					$this->database()->where('th.user_id = ' . (int) Phpfox::getUserId() . ' AND th.is_archive = 0 AND th.is_sent = 1');
				}
				else
				{					
					$this->database()->where('th.user_id = ' . (int) Phpfox::getUserId() . ' AND th.is_archive = ' . (int) $iArchiveId . '');
				}				
			}
			else 
			{				
				$this->database()->select('COUNT(DISTINCT t.thread_id)');				
				$aNewCond = array();
				if (count($aConds))
				{
					foreach ($aConds as $sCond)
					{
						if (preg_match('/AND mt.text LIKE \'%(.*)%\'/i', $sCond, $aTextMatch))
						{
							$bIsTextSearch = true;
							$aNewCond[] = $sCond;
						}
					}				
				}
			}
			
			if ($bIsTextSearch)
			{
				$iCnt = $this->database()->from(Phpfox::getT('mail_thread_text'), 'mt')	
					->join(Phpfox::getT('mail_thread'), 't', 't.thread_id = mt.thread_id')
					->where($aNewCond)
					->execute('getSlaveField');			
			}
			else
			{
				$iCnt = $this->database()->from(Phpfox::getT('mail_thread_user'), 'th')	
					->join(Phpfox::getT('mail_thread'), 't', 't.thread_id = th.thread_id')				
					->execute('getSlaveField');
			}
		}
		else
		{
			$iCnt = $this->database()->select('COUNT(*)')
				->from($this->_sTable, 'm')
				->join(Phpfox::getT('mail_text'), 'mt', 'mt.mail_id = m.mail_id')
				->leftjoin(Phpfox::getT('user'), 'u', 'u.user_id ' . (!$bIsSentbox ? '= m.owner_user_id' : '= m.viewer_user_id'))
				->where($aConds)
				->execute('getSlaveField');
		}

		if ($iCnt)
		{
			(($sPlugin = Phpfox_Plugin::get('mail.service_mail_get')) ? eval($sPlugin) : false);

			if (Phpfox::getParam('mail.threaded_mail_conversation'))
			{	
				if (!defined('PHPFOX_IS_PRIVATE_MAIL'))
				{
					if ($bIsSentbox)
					{
						$this->database()->where('th.user_id = ' . (int) Phpfox::getUserId() . ' AND th.is_archive = 0 AND th.is_sent = 1');
					}
					else
					{					
						$this->database()->where('th.user_id = ' . (int) Phpfox::getUserId() . ' AND th.is_archive = ' . (int) $iArchiveId . '');
					}
				}
				else 
				{
					$this->database()->where($aConds);
					$this->database()->group('th.thread_id');
				}
				
				if ($bIsTextSearch)
				{
					$aRows = $this->database()->select('th.*, mt.text AS preview, mt.time_stamp, mt.user_id AS last_user_id')
						->from(Phpfox::getT('mail_thread_text'), 'mt')
						->join(Phpfox::getT('mail_thread_user'), 'th', 'th.user_id = mt.user_id')	
						->join(Phpfox::getT('mail_thread'), 't', 't.thread_id = mt.thread_id')
						->join(Phpfox::getT('user'), 'u', 'u.user_id = mt.user_id')
						// ->join(Phpfox::getT('mail_thread_text'), 'tt', 'tt.message_id = t.last_id')					
						->limit($iPage, $iLimit, $iCnt)
						->order('t.time_stamp DESC')
						->execute('getSlaveRows');					
				}
				else
				{
					$aRows = $this->database()->select('th.*, tt.text AS preview, tt.time_stamp, tt.user_id AS last_user_id')
						->from(Phpfox::getT('mail_thread_user'), 'th')	
						->join(Phpfox::getT('mail_thread'), 't', 't.thread_id = th.thread_id')
						->join(Phpfox::getT('mail_thread_text'), 'tt', 'tt.message_id = t.last_id')
						->join(Phpfox::getT('user'), 'u', 'u.user_id = tt.user_id')
						->limit($iPage, $iLimit, $iCnt)
						->order('t.time_stamp DESC')
						->execute('getSlaveRows');
				}
				
				$aFields = Phpfox::getService('user')->getUserFields();
				
				foreach ($aRows as $iKey => $aRow)
				{
					if (Phpfox::getParam('mail.threaded_mail_conversation'))
					{
						$aRows[$iKey]['preview'] = strip_tags($aRow['preview']);
					}
					
					$aRows[$iKey]['viewer_is_new'] = ($aRow['is_read'] ? false : true);
					$aRows[$iKey]['users'] = $this->database()->select('th.is_read, ' . Phpfox::getUserField())
						->from(Phpfox::getT('mail_thread_user'), 'th')
						->join(Phpfox::getT('user'), 'u', 'u.user_id = th.user_id')						
						->where('th.thread_id = ' . (int) $aRow['thread_id'])
						->execute('getSlaveRows');

					$iUserCnt = 0;
					foreach ($aRows[$iKey]['users'] as $iUserKey => $aUser)
					{
						if (!defined('PHPFOX_IS_PRIVATE_MAIL') && $aUser['user_id'] == Phpfox::getUserId())
						{
							unset($aRows[$iKey]['users'][$iUserKey]);
							
							continue;
						}
						
						$iUserCnt++;
						
						if ($iUserCnt == 1)
						{
							foreach ($aFields as $sField)
							{
								if ($sField == 'server_id')
								{
									$sField = 'user_server_id';
								}
								$aRows[$iKey][$sField] = $aUser[$sField];
							}
						}

						if (!isset($aRows[$iKey]['users_is_read']))
						{
							$aRows[$iKey]['users_is_read'] = array();
						}						
						
						if ($aUser['is_read'])
						{
							$aRows[$iKey]['users_is_read'][] = $aUser;
						}
					}

					if (!$iUserCnt)
					{
						unset($aRows[$iKey]);
					}
				}
			}
			else
			{
				if ($bIsTrash)
				{
					$this->database()
						->select(Phpfox::getUserField('u2', 'other_') . ', ')
						->join(Phpfox::getT('user'), 'u2', 'u2.user_id = m.viewer_user_id');
				}				
				
				$aRows = $this->database()->select('m.*, ' . Phpfox::getUserField())
					->from($this->_sTable, 'm')
					->join(Phpfox::getT('mail_text'), 'mt', 'mt.mail_id = m.mail_id')
					->leftjoin(Phpfox::getT('user'), 'u', 'u.user_id ' . (!$bIsSentbox ? '= m.owner_user_id' : '= m.viewer_user_id'))
					->where($aConds)
					->limit($iPage, $iLimit, $iCnt)
					->order($sSort)
					->execute('getSlaveRows');

				if (!$bIsSentbox)
				{
					foreach ($aRows as $iKey => $aRow)
					{
						if ($aRow['viewer_is_new'])
						{
							$aInputs['unread'][] = $aRow['mail_id'];
						}
						else
						{
							$aInputs['read'][] = $aRow['mail_id'];
						}
					}
				}				
			}
		}

		return array($iCnt, $aRows, $aInputs);
	}

	/**
	 * Gets the percentage used of the mailbox
	 * @param int $iUser
	 * @return int
	 */
	public function getSpaceUsed($iUser)
	{
		$iUsed = $this->database()->select('COUNT(viewer_user_id)')
			->from($this->_sTable)
			->where('viewer_user_id = ' . (int)$iUser . ' AND viewer_type_id != 1 AND viewer_type_id != 3')
			->execute('getSlaveField');
		$iAllowed = Phpfox::getUserParam('mail.mail_box_limit');
		// http://www.phpfox.com/tracker/view/15014/
		if(empty($iAllowed))
		{
			$iPercent = 0;
		}
		else
		{
			$iPercent = ceil(($iUsed / $iAllowed) * 100);
		}
		return $iPercent;
	}

	/**
	 * Gets all the mail_id for a specific user in a specific folder.
	 * @param <type> $iUser
	 * @param <type> $iFolder
	 * @param <type> $bIsSentbox
	 * @return <type>
	 */
	public function getAllMailFromFolder($iUser, $iFolder, $bIsSentbox, $bIsTrash)
	{
		$sWhere = ''; 
		if ($bIsSentbox) 
		{ 
			$sWhere .= (int)$iUser . ' = m.owner_user_id' . ' AND ' . (int)$iFolder. ' = m.owner_folder_id AND m.owner_type_id != 3' ;
		} 
		elseif ($bIsTrash) 
		{ 
			$sWhere .= '(m.viewer_user_id = '.(int)$iUser.' AND m.viewer_type_id = 1) OR (m.owner_user_id = '.(int)$iUser.' AND m.owner_type_id = 1)'; 
		} 
		else 
		{ 
			$sWhere .= (int)$iUser . ' = m.viewer_user_id AND ' . (int)$iFolder . ' = m.viewer_folder_id AND m.viewer_type_id != 3' ;
		} 
		
		$aMails = $this->database()->select('m.mail_id')
			->from($this->_sTable, 'm')
			->where($sWhere)
			->execute('getSlaveRows');
		
		$aOut = array();
		
		foreach ($aMails as $aMail) $aOut[] = $aMail['mail_id'];
		
		return $aOut; 
	}
	
	public function getMail($iId, $bForce = false)
	{
		if (Phpfox::getParam('mail.threaded_mail_conversation') && !$bForce)
		{
			list($aThread, $aMessages) = $this->getThreadedMail($iId);

			return $aMessages;
		}
		
		(($sPlugin = Phpfox_Plugin::get('mail.service_mail_getmail')) ? eval($sPlugin) : false);

		$aMail = $this->database()->select('m.*, ' . (Phpfox::getParam('core.allow_html') ? "mreply.text_parsed" : "mreply.text") . ' AS text_reply, ' . (Phpfox::getParam('core.allow_html') ? "mt.text_parsed" : "mt.text") . ' AS text, ' . Phpfox::getUserField('u', 'owner_') . ', ' . Phpfox::getUserField('u2', 'viewer_'))
			->from($this->_sTable, 'm')
			->join(Phpfox::getT('mail_text'), 'mt', 'mt.mail_id = m.mail_id')
			->leftjoin(Phpfox::getT('user'), 'u', 'u.user_id = m.owner_user_id')
			->join(Phpfox::getT('user'), 'u2', 'u2.user_id = m.viewer_user_id')
			->leftJoin(Phpfox::getT('mail_text'), 'mreply', 'mreply.mail_id = m.parent_id') /** @TODO PUREFAN changed this */
			->where('m.mail_id = ' . (int) $iId . '')
			->execute('getSlaveRow');
		if (empty($aMail))
		{
			return $aMail;
		}
		
		if ($aMail['viewer_folder_id'] > 0)
		{
			$aMail['folder_name'] = Phpfox::getService('mail.folder')->getFolder($aMail['viewer_folder_id']);
		}		
		
		return $aMail;
	}

	public function getPrev($iTime, $bIsSentbox = false, $bIsTrash = false)
	{
		return $this->database()->select('m.mail_id')
			->from($this->_sTable, 'm')
			->where(($bIsSentbox ? 'm.owner_user_id = ' . Phpfox::getUserId() . ' AND m.time_updated > ' . (int) $iTime . ' AND m.owner_type_id = ' . ($bIsTrash ? 1 : 0) . '' : 'm.viewer_user_id = ' . Phpfox::getUserId() . ' AND m.viewer_type_id = ' . ($bIsTrash ? 1 : 0) . ' AND m.time_updated > ' . (int) $iTime . ''))
			->order('m.time_updated ASC')
			->execute('getSlaveField');
	}

	public function getNext($iTime, $bIsSentbox = false, $bIsTrash = false)
	{
		return $this->database()->select('m.mail_id')
			->from($this->_sTable, 'm')
			->where(($bIsSentbox ? 'm.owner_user_id = ' . Phpfox::getUserId() . ' AND m.time_updated < ' . (int) $iTime . ' AND m.owner_type_id = ' . ($bIsTrash ? 1 : 0) . '' : 'm.viewer_user_id = ' . Phpfox::getUserId() . ' AND m.viewer_type_id = ' . ($bIsTrash ? 1 : 0) . ' AND m.time_updated < ' . (int) $iTime . ''))
			->order('m.time_updated DESC')
			->execute('getSlaveField');
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
		if ($sPlugin = Phpfox_Plugin::get('mail.service_mail__call'))
		{
			return eval($sPlugin);
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}

	public function getDefaultFoldersCount($iUserId)
	{
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			$iCountInbox = (int) $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('mail_thread_user'), 'm')
				->where('m.user_id = ' . Phpfox::getUserId() . ' AND m.is_archive = 0 AND m.is_sent = 0')
				->execute('getSlaveField');		
			
			$iCountSentbox = (int) $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('mail_thread_user'), 'm')
				->where('m.user_id = ' . Phpfox::getUserId() . ' AND m.is_archive = 0 AND m.is_sent = 1')
				->execute('getSlaveField');			
			
			$iCountDeleted = (int) $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('mail_thread_user'), 'm')
				->where('m.user_id = ' . Phpfox::getUserId() . ' AND m.is_archive = 1')
				->execute('getSlaveField');				
		}
		else
		{
			// count how many messages are in the inbox folder
			$iCountInbox = $this->database()->select("COUNT(*)")
				->from($this->_sTable, 'm')
				->where('viewer_user_id = ' . $iUserId . ' AND viewer_folder_id = 0 AND viewer_type_id = 0')
				->execute('getSlaveField');

			// how many messages are in the sent folder
			$iCountSentbox = $this->database()->select("COUNT(*)")
				->from($this->_sTable, 'm')
				->where('owner_user_id = ' . $iUserId . ' AND owner_folder_id = 0 AND owner_type_id = 0')
				->execute('getSlaveField');

			// How many messages are in the deleted folder
			$iCountDeleted = $this->database()->select("COUNT(*)")
				->from($this->_sTable, 'm')
				->where('(owner_user_id = ' . $iUserId . ' AND owner_folder_id = 0 AND owner_type_id = 1) OR (viewer_user_id = ' . $iUserId . ' AND viewer_folder_id = 0 AND viewer_type_id = 1)')
				->execute('getSlaveField');
		}

		return array(
			'iCountInbox' => $iCountInbox,
			'iCountSentbox' => $iCountSentbox,
			'iCountDeleted' => $iCountDeleted);
	}
	
	public function getLatest()
	{
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{			
			$aFields = Phpfox::getService('user')->getUserFields();
			
			$aRows = $this->database()->select('th.*, tt.text AS preview, tt.time_stamp, tt.user_id AS last_user_id')
				->from(Phpfox::getT('mail_thread_user'), 'th')	
				->join(Phpfox::getT('mail_thread'), 't', 't.thread_id = th.thread_id')
				->join(Phpfox::getT('mail_thread_text'), 'tt', 'tt.message_id = t.last_id')					
				->join(Phpfox::getT('user'), 'u', 'u.user_id = tt.user_id')
				->where('th.user_id = ' . (int) Phpfox::getUserId() . ' AND th.is_archive = 0 AND th.is_sent_update = 0')
				->limit(5)
				->order('t.time_stamp DESC')
				->execute('getSlaveRows');
		
			foreach ($aRows as $iKey => $aRow)
			{
				$aRows[$iKey]['viewer_is_new'] = ($aRow['is_read'] ? false : true);
					$aRows[$iKey]['users'] = $this->database()->select('th.is_read, ' . Phpfox::getUserField())
						->from(Phpfox::getT('mail_thread_user'), 'th')
						->join(Phpfox::getT('user'), 'u', 'u.user_id = th.user_id')						
						->where('th.thread_id = ' . (int) $aRow['thread_id'])
						->execute('getSlaveRows');
					
					$iUserCnt = 0;
					foreach ($aRows[$iKey]['users'] as $iUserKey => $aUser)
					{
						if ($aUser['user_id'] == Phpfox::getUserId())
						{
							unset($aRows[$iKey]['users'][$iUserKey]);
							
							continue;
						}
						
						$iUserCnt++;
						
						if ($iUserCnt == 1)
						{
							foreach ($aFields as $sField)
							{
								if ($sField == 'server_id')
								{
									$sField = 'user_server_id';
								}
								$aRows[$iKey][$sField] = $aUser[$sField];
							}
						}			
					}				
			}
				
			return $aRows;
		}
		
		$aRows = $this->database()->select('m.*, ' . Phpfox::getUserField())
			->from($this->_sTable, 'm')
			->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = m.owner_user_id')
			->where('m.viewer_folder_id = 0 AND m.viewer_user_id = ' . Phpfox::getUserId() . ' AND m.viewer_type_id = 0')
			->order('m.time_stamp DESC')
			->limit(5)
			->execute('getSlaveRows');
			
		$sIds = '';
		foreach ($aRows as $aRow)
		{
			$sIds .= $aRow['mail_id'] . ',';
		}
		$sIds = rtrim($sIds, ',');
		
		if (!empty($sIds) && Phpfox::getParam('mail.update_message_notification_preview'))
		{
			$this->database()->update($this->_sTable, array('viewer_is_new' => '0'), 'mail_id IN(' . $sIds . ')');
		}
			
		return $aRows;
	}

	/**
	 * We needed a different join so instead of adding another param or loading extra the $this->get() function
	 * its more practical to create a new function with stepping
	 */
	public function getPrivate($aConds, $iLimit,  $sSort, $iPage = 0)
	{
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			list($iCnt, $aMail, $aInputs) = $this->get($aConds, $sSort, $iPage, $iLimit);	
			
			return array($aMail, $iCnt);
		}
		
		$bFeatured = false;
		$bText = false;
		$bJoinSender = false;
		foreach ($aConds as $iKey => $sCond)
		{
			if ($sCond == 'FEATURED_2')
			{
				$aConds[] = 'AND uf.user_id > 0';
				$bFeatured = true;
				unset($aConds[$iKey]);
			}
			elseif($sCond == 'FEATURED_1')
			{
				unset($aConds[$iKey]);
			}
			elseif(strpos($sCond, 'mt.text') !== false)
			{
				$bText = true;
			}
			if (strpos($sCond, 'SENDER=') !== false)
			{				
				$bJoinSender = true;
				$aConds[$iKey] = 'AND sender.user_name = "' . Phpfox::getLib('parse.input')->clean(str_replace(array('SENDER=', "'"),'',$sCond)) . '"';
			}
			if (strpos($sCond, 'RECEIVER=') !== false)
			{				
				$aConds[$iKey] = 'AND receiver.user_name = "' . Phpfox::getLib('parse.input')->clean(str_replace(array('RECEIVER=', "'"),'',$sCond)) . '"';
				$this->database()->join(Phpfox::getT('user'), 'receiver', 'receiver.user_id = m.viewer_user_id');
			}
		}
		
		$aConds = array_merge(array('m.owner_user_id != 0'), $aConds);
		
		if ($bJoinSender)
		{
			$this->database()->join(Phpfox::getT('user'), 'sender', 'sender.user_id = m.owner_user_id');
		}
		else
		{
			$this->database()->leftjoin(Phpfox::getT('user'), 'sender', 'sender.user_id = m.owner_user_id');
		}
		$this->database()
			->select('COUNT(m.mail_id)')
			->from($this->_sTable, 'm')
			//->leftjoin(Phpfox::getT('user'), 'sender', 'sender.user_id = m.owner_user_id')
			->order($sSort)
			->where($aConds);
		
		if ($bFeatured)
		{			
			$this->database()->join(Phpfox::getT('user_featured'), 'uf', 'uf.user_id = sender.user_id');
		}
		if ($bText)
		{
			$this->database()->leftjoin(Phpfox::getT('mail_text'), 'mt', 'mt.mail_id = m.mail_id');
		}
		
		$iCnt = $this->database()->execute('getSlaveField');

		
		if ($iCnt > 0)
		{
			if (is_int($iLimit) && $iLimit > 0 )
			{
				$this->database()->limit($iPage, $iLimit, $iCnt);
			}
			
			$this->database()
				->select('m.subject, m.mail_id, m.time_stamp, ' . Phpfox::getUserField('sender', 'sender_') . ', ' . Phpfox::getUserField('receiver', 'receiver_'))
				->from($this->_sTable, 'm')
				->join(Phpfox::getT('user'), 'sender', 'sender.user_id = m.owner_user_id')
				->join(Phpfox::getT('user'), 'receiver', 'receiver.user_id = m.viewer_user_id')
				->order($sSort)
				->where($aConds);
				
			if ($bFeatured)
			{				
				$this->database()->join(Phpfox::getT('user_featured'), 'uf', 'uf.user_id = sender.user_id');
			}
			if ($bText)
			{
				$this->database()->leftjoin(Phpfox::getT('mail_text'), 'mt', 'mt.mail_id = m.mail_id');
			}
			$aMail = $this->database()->execute('getSlaveRows');

			return array($aMail, $iCnt);
		}

		return array(array(), 0);
	}

	public function isDeleted($iMail)
	{
		$iValue = $this->database()->select('mail_id')
			->from($this->_sTable)
			->where('(viewer_user_id = '.Phpfox::getUserId().' AND viewer_type_id = 1) OR (owner_user_id = '.Phpfox::getUserId().' AND owner_type_id = 1)')
			->execute('getSlaveField');
		return ($iValue == $iMail);
		//(m.viewer_user_id = 2 AND m.viewer_type_id = 1) OR (m.owner_user_id = 2 AND m.owner_type_id = 1)
	}

	public function isSent($iMail)
	{
		$iValue = $this->database()->select('mail_id')
			->from($this->_sTable)
			->where('mail_id = ' . (int)$iMail . ' AND owner_user_id = ' . Phpfox::getUserId())
			->execute('getSlaveField');
		return ($iValue == $iMail);
	}
	
	public function getLegacyCount()
	{			
		$iCnt = (int) $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('mail'), 'm')
			->where('m.viewer_folder_id = 0 AND m.viewer_user_id = ' . Phpfox::getUserId() . ' AND m.viewer_type_id = 0')
			->execute('getSlaveField');
			
		return $iCnt;
	}
	
	public function getUnseenTotal()
	{
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			$iCnt = (int) $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('mail_thread_user'), 'm')
				->where('m.user_id = ' . Phpfox::getUserId() . ' AND m.is_read = 0')
				->execute('getSlaveField');		
			
			return $iCnt;
		}
		
		$iCnt = (int) $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('mail'), 'm')
			->where('m.viewer_folder_id = 0 AND m.viewer_user_id = ' . Phpfox::getUserId() . ' AND m.viewer_type_id = 0 AND m.viewer_is_new = 1')
			->execute('getSlaveField');
			
		return $iCnt;
	}
	
	public function buildMenu()
	{
		// Add a hook with return here
		if (Phpfox::getParam('mail.show_core_mail_folders_item_count') && Phpfox::getUserParam('mail.show_core_mail_folders_item_count'))
		{
			$aCountFolders = Phpfox::getService('mail')->getDefaultFoldersCount(Phpfox::getUserId());
		}

		$aFilterMenu = array(
			Phpfox::getPhrase('mail.inbox') . (isset($aCountFolders['iCountInbox']) ? ' (' . $aCountFolders['iCountInbox'] . ')' : '') => '',
			Phpfox::getPhrase('mail.sent_messages') . (isset($aCountFolders['iCountSentbox']) ? ' (' . $aCountFolders['iCountSentbox'] . ')' : '') => 'sent',
			(Phpfox::getParam('mail.threaded_mail_conversation') ? Phpfox::getPhrase('mail.archive') : Phpfox::getPhrase('mail.trash')) . (isset($aCountFolders['iCountDeleted']) ? ' (' . $aCountFolders['iCountDeleted'] . ')' : '') => 'trash'			
		);		
		
		if (!Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			$aFilterMenu[] = true;		
			$aFolders = Phpfox::getService('mail.folder')->get();
			foreach ($aFolders as $aFolder)
			{
				$aFilterMenu[$aFolder['name']] = 'mail.view_box.id_' . $aFolder['folder_id'];
			}
		}
		
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			$iLegacyCount = Phpfox::getService('mail')->getLegacyCount();
			$aFilterMenu[] = true;
			$aFilterMenu[Phpfox::getPhrase('mail.legacy_inbox') . ' <span class="invited">' . $iLegacyCount . '</span>'] = 'mail.legacy_1';
		}		
		
		Phpfox::getLib('template')->buildSectionMenu('mail', $aFilterMenu);	
	}
	
	public function getThreadedMail($iThreadId, $iPage = 0)
	{		
		$aThread = $this->database()->select('mt.*, mtu.is_archive AS user_is_archive')
			->from(Phpfox::getT('mail_thread'), 'mt')
			->join(Phpfox::getT('mail_thread_user'), 'mtu', 'mtu.thread_id = mt.thread_id')
			->where('mt.thread_id = ' . (int) $iThreadId)
			->execute('getSlaveRow');

		if (!isset($aThread['thread_id']))
		{
			return array(false, false);
		}
		
		$aThread['users'] =  $this->database()->select(Phpfox::getUserField())
			->from(Phpfox::getT('mail_thread_user'), 'th')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = th.user_id')
			->where('th.thread_id = ' . (int) $aThread['thread_id'])
			->execute('getSlaveRows');

		$iLimit = 10;
		$iOffset = ($iPage * $iLimit);	

		$aMessages = $this->database()->select('mtt.*, ' . Phpfox::getUserField())
			->from(Phpfox::getT('mail_thread_text'), 'mtt')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = mtt.user_id')
			->where('mtt.thread_id = ' . (int) $iThreadId)
			->order('mtt.time_stamp DESC')
			->limit($iOffset, $iLimit)
			->execute('getSlaveRows');		
		
		$aMessages = array_reverse($aMessages);
		
		foreach ($aMessages as $iKey => $aMail)
		{
			if ($aMail['total_attachment'] > 0)
			{
				list($iCnt, $aAttachments) = Phpfox::getService('attachment')->get(array('AND attachment.item_id = ' . $aMail['message_id'] . ' AND attachment.category_id = \'mail\' AND is_inline = 0'), 'attachment.attachment_id DESC', '', '', false);

				$aMessages[$iKey]['attachments'] = $aAttachments;
			}
			
			$aMessages[$iKey]['forwards'] = array();
			if ($aMail['has_forward'])
			{
				$aMessages[$iKey]['forwards'] = $this->database()->select('mtt.*, ' . Phpfox::getUserField())
					->from(Phpfox::getT('mail_thread_forward'), 'mtf')
					->join(Phpfox::getT('mail_thread_text'), 'mtt', 'mtt.message_id = mtf.copy_id')
					->join(Phpfox::getT('user'), 'u', 'u.user_id = mtt.user_id')
					->where('mtf.message_id = ' . $aMail['message_id'])
					->execute('getSlaveRows');
			}
		}
				
		return array($aThread, $aMessages);
	}
	
	public function getThreadsForExport($aThreads)
	{
		define('PHPFOX_XML_SKIP_STAMP', true);
		
		$sThreads = implode(',', $aThreads);
		
		if (empty($sThreads))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('mail.unable_to_export_your_messages'));
		}
		
		$aThreads = $this->database()->select('mt.*') 
			->from(Phpfox::getT('mail_thread'), 'mt')
			->join(Phpfox::getT('mail_thread_user'), 'mtu', 'mtu.thread_id = mt.thread_id AND mtu.user_id = ' . Phpfox::getUserId())
			->where('mt.thread_id IN(' . $sThreads . ')')
			->execute('getSlaveRows');
		
		if (!count($aThreads))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('mail.unable_to_export_your_messages'));
		}
		
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('threads');			
		
		foreach ($aThreads as $iKey => $aThread)
		{			
			$aMessages = $this->database()->select('mtt.*, ' . Phpfox::getUserField())
				->from(Phpfox::getT('mail_thread_text'), 'mtt')
				->join(Phpfox::getT('user'), 'u', 'mtt.user_id = u.user_id')
				->where('thread_id = ' . (int) $aThread['thread_id'])
				->execute('getSlaveRows');
			
			$aUsers = $this->database()->select('th.is_read, ' . Phpfox::getUserField())
				->from(Phpfox::getT('mail_thread_user'), 'th')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = th.user_id')						
				->where('th.thread_id = ' . (int) $aThread['thread_id'])
				->execute('getSlaveRows');		
			
			$oXmlBuilder->addGroup('thread', array(
					'id' => $aThread['thread_id']
				)
			);		
			
			$iCnt = 0;
			$sUsers = '';
			foreach ($aUsers as $aUser)
			{
				$iCnt++;
				if ($iCnt != 1)
				{
					$sUsers .= ',';
				}
				$sUsers .= $aUser['full_name'];
			}
			
			$oXmlBuilder->addTag('conversation', $sUsers);
			$oXmlBuilder->addTag('url', Phpfox::getLib('url')->makeUrl('mail.thread', array('id' => $aThread['thread_id'])));
			
			$oXmlBuilder->addGroup('messages');			
			foreach ($aMessages as $aMessage)
			{
				$oXmlBuilder->addGroup('message', array(
						'id' => $aMessage['message_id']
					)
				);				
				
				$oXmlBuilder->addTag('time', $aMessage['time_stamp']);
				$oXmlBuilder->addTag('user', $aMessage['full_name']);
				$oXmlBuilder->addTag('content', Phpfox::getLib('parse.output')->parse($aMessage['text']));
				$oXmlBuilder->closeGroup();
			}
			$oXmlBuilder->closeGroup();
			
			$oXmlBuilder->closeGroup();
		}
		
		$oXmlBuilder->closeGroup();
		
		$sFile = md5(Phpfox::getUserId() . uniqid()) . '.xml';
		
		Phpfox::getLib('file')->writeToCache($sFile, $oXmlBuilder->output());
		
		return PHPFOX_DIR_CACHE . $sFile;
	}
}

?>
