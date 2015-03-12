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
 * @package  		Module_Group
 * @version 		$Id: process.class.php 4786 2012-09-27 10:40:14Z Miguel_Espinoza $
 */
class Group_Service_Process extends Phpfox_Service 
{
	private $_bHasImage = false;
	
	private $_aInvited = array();
	
	private $_aCategories = array();	
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('group');
	}
	
	public function add($aVals)
	{		
		if (!$this->_verify($aVals))
		{
			return false;
		}
		
		$oParseInput = Phpfox::getLib('parse.input');		

		$bIApproveGroup = (Phpfox::getUserParam('group.approve_groups') ? true : false);
		$sCheck = '';
		foreach ($aVals as $aVal)
		{
			if (is_array($aVal))
			{
				$sCheck .= implode(' ', $aVal);
			}
			else
			{
				$sCheck .= ' ' . $aVal;
			}
		}
		
		Phpfox::getService('ban')->checkAutomaticBan($sCheck);
		$sUrlTitle = $oParseInput->prepareTitle('group', $aVals['title'], 'title_url', null, $this->_sTable);				
		$aSql = array(
			'is_public' => ($bIApproveGroup ? '1' : '0'),
			'view_id' => (int) $aVals['view_id'],
			'user_id' => Phpfox::getUserId(),
			'title' => $oParseInput->clean($aVals['title'], 255),
			'title_url' => $sUrlTitle,
			'short_description' => (empty($aVals['short_description']) ? null : $oParseInput->clean($aVals['short_description'], 255)),
			'country_iso' => $aVals['country_iso'],
			'country_child_id' => (isset($aVals['country_child_id']) ? (int) $aVals['country_child_id'] : 0),
			'postal_code' => (empty($aVals['postal_code']) ? null : Phpfox::getLib('parse.input')->clean($aVals['postal_code'], 20)),
			'city' => (empty($aVals['city']) ? null : $oParseInput->clean($aVals['city'], 255)),
			'time_stamp' => PHPFOX_TIME,
			'auto_approve' => (int)$aVals['auto_approve']
		);
		
		$iId = $this->database()->insert($this->_sTable, $aSql);
		
		if (!$iId)
		{
			return false;
		}
		
		$this->database()->insert(Phpfox::getT('group_text'), array(
				'group_id' => $iId,
				'description' => (empty($aVals['description']) ? null : $oParseInput->clean($aVals['description'])),
				'description_parsed' => (empty($aVals['description']) ? null : $oParseInput->prepare($aVals['description']))
			)
		);		
		
		$this->updateAccess($iId, $aVals);
		
		foreach ($this->_aCategories as $iCategoryId)
		{
			$this->database()->insert(Phpfox::getT('group_category_data'), array('group_id' => $iId, 'category_id' => $iCategoryId));
		}		
		
		if ($aVals['view_id'] != '2' && !$bIApproveGroup)
		{
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('group', $iId) : null);
		}
		
		$this->joinGroup($iId, Phpfox::getUserId(), true);
                
		// Plugin call
		if ($sPlugin = Phpfox_Plugin::get('group.service_process_add__end')){eval($sPlugin);}
                
		return $iId;
	}	
	
	public function approve($iGroupId)
	{
		$aGroup = $this->database()->select('*')
			->from(Phpfox::getT('group'))
			->where('group_id = ' . (int) $iGroupId)
			->execute('getSlaveRow');
			
		if (!isset($aGroup['group_id']))
		{
			return false;
		}
		
		$this->database()->update(Phpfox::getT('group'), array('is_public' => '0'), 'group_id = ' . (int) $iGroupId);
		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('group', $aGroup['group_id']) : null);
		
		$sCurrentUrl = Phpfox::getLib('url')->makeUrl('group', $aGroup['title_url']);
		Phpfox::getLib('mail')->to($aGroup['user_id'])
			->subject(array('group.group_approved_on_site_title', array('site_title' => Phpfox::getParam('core.site_title'))))
			->message(array('group.your_group_group_title_on_site_title', array('group_title' => $aGroup['title'], 'site_title' => Phpfox::getParam('core.site_title'), 'link' => $sCurrentUrl)))
			->send();		
		
		return true;
	}
	
	public function update($iId, $aVals, $aGroupPost = null)
	{
		if (!$this->_verify($aVals))
		{
			return false;
		}
		Phpfox::getService('ban')->checkAutomaticBan($aVals['title'] . ' ' . $aVals['description']);
		$oParseInput = Phpfox::getLib('parse.input');
		
		$aSql = array(
			'view_id' => (int) $aVals['view_id'],
			'title' => $oParseInput->clean($aVals['title'], 255),
			'short_description' => (empty($aVals['short_description']) ? null : $oParseInput->clean($aVals['short_description'], 255)),
			'country_iso' => $aVals['country_iso'],
			'country_child_id' => (isset($aVals['country_child_id']) ? (int) $aVals['country_child_id'] : 0),
			'postal_code' => (empty($aVals['postal_code']) ? null : Phpfox::getLib('parse.input')->clean($aVals['postal_code'], 20)),
			'city' => (empty($aVals['city']) ? null : $oParseInput->clean($aVals['city'], 255)),			
		);			
		
		if ($this->_bHasImage)
		{			
			$oImage = Phpfox::getLib('image');
			
			$sFileName = Phpfox::getLib('file')->upload('image', Phpfox::getParam('group.dir_image'), $iId);
			$iFileSizes = filesize(Phpfox::getParam('group.dir_image') . sprintf($sFileName, ''));			
			
			$aSql['image_path'] = $sFileName;
			$aSql['server_id'] = Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID');
			
			$iSize = 50;			
			$oImage->createThumbnail(Phpfox::getParam('group.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('group.dir_image') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);			
			$iFileSizes += filesize(Phpfox::getParam('group.dir_image') . sprintf($sFileName, '_' . $iSize));			
			
			$iSize = 120;			
			$oImage->createThumbnail(Phpfox::getParam('group.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('group.dir_image') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);			
			$iFileSizes += filesize(Phpfox::getParam('group.dir_image') . sprintf($sFileName, '_' . $iSize));

			$iSize = 200;			
			$oImage->createThumbnail(Phpfox::getParam('group.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('group.dir_image') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);			
			$iFileSizes += filesize(Phpfox::getParam('group.dir_image') . sprintf($sFileName, '_' . $iSize));
			
			// Update user space usage
			Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'group', $iFileSizes);
		}	
		
		$this->database()->update($this->_sTable, $aSql, 'group_id = ' . (int) $iId);	
		
		$this->database()->update(Phpfox::getT('group_text'), array(				
				'description' => (empty($aVals['description']) ? null : $oParseInput->clean($aVals['description'])),
				'description_parsed' => (empty($aVals['description']) ? null : $oParseInput->prepare($aVals['description']))
			), 'group_id = ' . (int) $iId
		);		
		
		$this->updateAccess($iId, $aVals);
		
		if (isset($aVals['emails']) || isset($aVals['invite']))
		{
			$aGroup = $this->database()->select('title_url')
				->from($this->_sTable)
				->where('group_id = ' . (int) $iId)
				->execute('getSlaveRow');
				
			$aInvites = $this->database()->select('invited_user_id, invited_email')
				->from(Phpfox::getT('group_invite'))
				->where('group_id = ' . (int) $iId)
				->execute('getRows');
			$aInvited = array();
			foreach ($aInvites as $aInvite)
			{
				$aInvited[(empty($aInvite['invited_email']) ? 'user' : 'email')][(empty($aInvite['invited_email']) ? $aInvite['invited_user_id'] : $aInvite['invited_email'])] = true;
			}			
		}		
		
		if (isset($aVals['emails']))
		{
			// if (strpos($aVals['emails'], ','))
			{
				$aEmails = explode(',', $aVals['emails']);
				$aCachedEmails = array();
				foreach ($aEmails as $sEmail)
				{
					$sEmail = trim($sEmail);
					if (!Phpfox::getLib('mail')->checkEmail($sEmail))
					{
						continue;
					}
					
					if (isset($aInvited['email'][$sEmail]))
					{
						continue;
					}					
					
					$sLink = Phpfox::getLib('url')->makeUrl('group', $aGroup['title_url']);
					$sMessage = Phpfox::getPhrase('group.full_name_invited_you_to_title', array(
							'full_name' => Phpfox::getUserBy('full_name'),
							'title' => $oParseInput->clean($aVals['title'], 255),
							'link' => $sLink
						)
					);
					if (!empty($aVals['personal_message']))
					{
						$sMessage .= "\n\n" . Phpfox::getPhrase('group.full_name_added_the_following_personal_message', array('full_name' => Phpfox::getUserBy('full_name'))) . ":\n";
						$sMessage .= $aVals['personal_message'];
					}					
					$bSent = Phpfox::getLib('mail')->to($sEmail)						
						->subject(array('group.full_name_invited_you_to_the_group_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $oParseInput->clean($aVals['title'], 255))))
						->message($sMessage)
						->send();
						
					$bSent = true;
					if ($bSent)
					{
						$this->_aInvited[] = array('email' => $sEmail);
						
						$aCachedEmails[$sEmail] = true;
						
						$this->database()->insert(Phpfox::getT('group_invite'), array(
								'group_id' => $iId,								
								'user_id' => Phpfox::getUserId(),
								'invited_email' => $sEmail,
								'time_stamp' => PHPFOX_TIME
							)
						);
					}
				}
			}
		}
		
		if (isset($aVals['invite']) && is_array($aVals['invite']))
		{
			$sUserIds = '';
			foreach ($aVals['invite'] as $iUserId)
			{
				if (!is_numeric($iUserId))
				{
					continue;
				}
				$sUserIds .= $iUserId . ',';
			}
			$sUserIds = rtrim($sUserIds, ',');
			
			$aUsers = $this->database()->select('user_id, email, language_id, full_name')
				->from(Phpfox::getT('user'))
				->where('user_id IN(' . $sUserIds . ')')
				->execute('getSlaveRows');
				
			foreach ($aUsers as $aUser)
			{
				if (isset($aCachedEmails[$aUser['email']]))
				{
					continue;
				}	
				
				if (isset($aInvited['user'][$aUser['user_id']]))
				{
					continue;
				}											
				
				$sLink = Phpfox::getLib('url')->makeUrl('group', $aGroup['title_url']);
				$sMessage = Phpfox::getPhrase('group.full_name_invited_you_to_title', array(
						'full_name' => Phpfox::getUserBy('full_name'),
						'title' => $oParseInput->clean($aVals['title'], 255),
						'link' => $sLink
					), false, null, $aUser['language_id']
				);
				if (!empty($aVals['personal_message']))
				{
					$sMessage .= "\n\n" . Phpfox::getPhrase('group.full_name_added_the_following_personal_message', array('full_name' => Phpfox::getUserBy('full_name')), false, null, $aUser['language_id']) . ":\n";
					$sMessage .= $aVals['personal_message'];
				}
				$bSent = Phpfox::getLib('mail')->to($aUser['user_id'])						
					->subject(array('group.full_name_invited_you_to_the_group_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $oParseInput->clean($aVals['title'], 255))))
					->message($sMessage)
					->notification('group.new_invite')
					->send();

				$bSent = true;
				if ($bSent)
				{
					$this->_aInvited[] = array('user' => $aUser['full_name']);	
					
					$iInviteId = $this->database()->insert(Phpfox::getT('group_invite'), array(
							'group_id' => $iId,								
							'user_id' => Phpfox::getUserId(),
							'invited_user_id' => $aUser['user_id'],
							'time_stamp' => PHPFOX_TIME
						)
					);
					
					(Phpfox::isModule('request') ? Phpfox::getService('request.process')->add('group_invite', $iInviteId, $aUser['user_id']) : null);
				}
			}
		}				
		
		$this->database()->delete(Phpfox::getT('group_category_data'), 'group_id = ' . (int) $iId);
		foreach ($this->_aCategories as $iCategoryId)
		{
			$this->database()->insert(Phpfox::getT('group_category_data'), array('group_id' => $iId, 'category_id' => $iCategoryId));
		}
		
		if ($aVals['view_id'] == '2')
		{
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('group', $iId) : null);	
		}
		else 
		{
			if (isset($aGroupPost['view_id']) && $aGroupPost['view_id'] == '2')
			{
				(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('group', $iId) : null);
			}
			else 
			{
				(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->update('group', $iId) : null);
			}
		}
		
		return true;
	}	
	
	public function updateAccess($iGroup, &$aVals)
	{		
		$this->database()->delete(Phpfox::getT('group_access'), 'group_id = ' . (int) $iGroup);
		if (isset($aVals['access']))
		{
			foreach ($aVals['access'] as $sParam => $iValue)
			{
				$iValue = (int) $iValue;
				
				if ($iValue == 1)
				{
					continue;
				}
				
				$this->database()->insert(Phpfox::getT('group_access'), array(
						'group_id' => $iGroup,
						'var_name' => $sParam,
						'access_value' => $iValue
					)
				);
			}
		}
		
		return true;
	}
	
	public function invite($iGroup, $iUserId)
	{
		$aGroup = $this->database()->select('g.group_id, g.view_id, g.title, g.title_url, gi.invite_id')	
			->from(Phpfox::getT('group'), 'g')
			->join(Phpfox::getT('group_invite'), 'gi', 'gi.group_id = g.group_id AND gi.member_id = 1 AND gi.invited_user_id = ' . (int) Phpfox::getUserId())
			->where('g.group_id = ' . (int) $iGroup)
			->execute('getSlaveRow');
			
		if (!isset($aGroup['group_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('group.unable_to_invite_to_this_group'));
		}
		
		$iInviteId = $this->database()->insert(Phpfox::getT('group_invite'), array(
					'group_id' => (int) $iGroup,								
					'user_id' => Phpfox::getUserId(),
					'invited_user_id' => (int) $iUserId,
					'time_stamp' => PHPFOX_TIME
				)
			);	
			
		$sLink = Phpfox::getLib('url')->makeUrl('group', $aGroup['title_url']);
		Phpfox::getLib('mail')->to($iUserId)						
			->subject(array('group.full_name_invited_you_to_the_group_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $aGroup['title'])))
			->message(array('group.full_name_invited_you_to_title_to_check_out_this_group', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $aGroup['title'], 'link' => $sLink)))
			->notification('group.new_invite')
			->send();			
			
		(Phpfox::isModule('request') ? Phpfox::getService('request.process')->add('group_invite', $iInviteId, $iUserId) : null);	
			
		return true;
	}

	public function joinGroup($iGroup, $iUserId, $bIsAdmin = false)
	{
		Phpfox::isUser(true);
		
		$aGroup = $this->database()->select('group_id, view_id, title, title_url, auto_approve')
			->from($this->_sTable)
			->where('group_id = ' . (int) $iGroup)
			->execute('getRow');		
			
		if (!isset($aGroup['group_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('group.the_group_you_are_looking_for_does_not_exist'));
		}		
		
		$aInvite = $this->database()->select('invite_id, member_id')
			->from(Phpfox::getT('group_invite'))
			->where('group_id = ' . (int) $iGroup . ' AND invited_user_id = ' . (int) $iUserId)
			->execute('getRow');			
		
		if (isset($aInvite['invite_id']))
		{			
			if ($aGroup['view_id'] == '1')
			{
				if ($aInvite['member_id'] == '2')
				{
					if (!Phpfox::getService('group')->isAdmin($aGroup['group_id']))
					{
						return Phpfox_Error::set(Phpfox::getPhrase('group.you_are_not_allowed_to_approve_members_for_this_group'));
					}
				}				
			}			
			
			if ($aGroup['view_id'] == '1')
			{
				$sLink = Phpfox::getLib('url')->makeUrl('group', $aGroup['title_url']);			
				Phpfox::getLib('mail')->to($iUserId)						
					->subject(array('group.group_membership_approved_title', array('title' => $aGroup['title'])))
					->message(array('group.your_membership_for_the_group_title_has_been_approved', array('title' => $aGroup['title'], 'link' => $sLink)))
					->notification('group.membership_approved')
					->send();									
			}
			
			(Phpfox::isModule('request') ? Phpfox::getService('request.process')->delete('group_invite', $aInvite['invite_id'], $iUserId) : false);			
			
			$this->database()->update(Phpfox::getT('group_invite'), array(
					'member_id' => 1
				), 'invite_id = ' . $aInvite['invite_id']
			);		
			
			$this->database()->updateCount('group_invite', 'group_id = ' . (int) $aGroup['group_id'] . ' AND member_id = 1', 'total_member', 'group', 'group_id = ' . (int) $aGroup['group_id']);
		}		
		else
		{
			$this->database()->insert(Phpfox::getT('group_invite'), array(
					'group_id' => $iGroup,
					'is_admin' => ($bIsAdmin === true ? '1' : '0'),
					'member_id' => (($aGroup['view_id'] == '1' && $bIsAdmin === false) ? '2' : '1'),
					'user_id' => $iUserId,
					'invited_user_id' => $iUserId,
					'time_stamp' => PHPFOX_TIME
				)
			);			
			
			if (($aGroup['view_id'] == '1' && $bIsAdmin === false))
			{
				$sLink = Phpfox::getLib('url')->makeUrl('group.add.manage', array('id' => $aGroup['group_id']));				
				foreach (Phpfox::getService('group')->getAdmins($aGroup['group_id']) as $aAdmin)
				{
					Phpfox::getLib('mail')->to($aAdmin['user_id'])						
						->subject(array('group.title_has_a_new_member_pending_approval', array('title' => $aGroup['title'])))
						->message(array('group.full_name_has_joined_the_group_title_which_you_are_administrating', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $aGroup['title'], 'link' => $sLink)))
						->notification('group.member_pending_approval')
						->send();
				}
			}
			
			if ($aGroup['view_id'] == '0')
			{
				$sLink = Phpfox::getLib('url')->makeUrl('group', $aGroup['title_url']);				
				foreach (Phpfox::getService('group')->getAdmins($aGroup['group_id']) as $aAdmin)
				{
					Phpfox::getLib('mail')->to($aAdmin['user_id'])						
						->subject(array('group.title_has_a_new_member', array('title' => $aGroup['title'])))
						->message(array('group.full_name_has_joined_the_group_title_which_you_are_administrating', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $aGroup['title'], 'link' => $sLink)))
						->notification('group.on_new_member')
						->send();
				}				
				
				$this->database()->updateCount('group_invite', 'group_id = ' . (int) $aGroup['group_id'] . ' AND member_id = 1', 'total_member', 'group', 'group_id = ' . (int) $aGroup['group_id']);
			}		
		}		
		
		return (($aGroup['view_id'] == '1' && !isset($aInvite['invite_id'])) ? '1' : $aGroup);
	}	
	
	public function leaveGroup($iGroup, $iUserId)
	{
		Phpfox::isUser(true);	
		
		$aGroup = $this->database()->select('g.group_id, gi.invite_id, g.user_id')
			->from(Phpfox::getT('group_invite'), 'gi')
			->join(Phpfox::getT('group'), 'g', 'g.group_id = gi.group_id')
			->where('gi.group_id = ' . (int) $iGroup . ' AND gi.invited_user_id = ' . (int) $iUserId)
			->execute('getRow');
			
		if (!isset($aGroup['group_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('group.unable_to_leave_this_group_as_you_are_not_a_member'));
		}
		if ($aGroup['user_id'] == Phpfox::getUserId())
		{
			return Phpfox_Error::set(Phpfox::getPhrase('group.cant_leave_group_only_delete'));
		}
		
		$this->database()->delete(Phpfox::getT('group_invite'), 'group_id = ' . (int) $iGroup . ' AND invited_user_id = ' . (int) $iUserId);
		
		$this->database()->updateCount('group_invite', 'group_id = ' . (int) $iGroup . ' AND member_id = 1', 'total_member', 'group', 'group_id = ' . (int) $iGroup);
		
		(Phpfox::isModule('request') ? Phpfox::getService('request.process')->delete('group_invite', $aGroup['invite_id'], $iUserId) : false);
		
		return true;
	}

	public function updateDesign($aVals)
	{
		Phpfox::isUser(true);
		
		if (!($aGroup = Phpfox::getService('group')->getForEdit($aVals['designer_item_id'])))
		{
			return false;	
		}		
		
		if (isset($aVals['order']))
		{
			$this->database()->delete(Phpfox::getT('group_design_order'), 'group_id = ' . (int) $aGroup['group_id'] . ' AND is_hidden = 0');
			foreach ($aVals['order'] as $sCacheId => $aOrder)
			{				
				$aKey = array_keys($aOrder);
				$aValue = array_values($aOrder);				
				$this->database()->insert(Phpfox::getT('group_design_order'), array('group_id' => $aGroup['group_id'], 'cache_id' => $sCacheId, 'block_id' => $aKey[0], 'ordering' => $aValue[0]));
			}
		}			
		
		if (isset($aVals['cache_id']))
		{
			$this->hideBlock($aGroup['group_id'], $aVals['cache_id'], ($aVals['is_installed'] ? 1 : 0));
		}		
		
		if (isset($aVals['style_id']))
		{
			$this->database()->update($this->_sTable, array('designer_style_id' => (int) $aVals['style_id']), 'group_id = ' . $aGroup['group_id']);
		}
		
		return true;
	}	
	
	public function hideBlock($iGroupId, $sBlockId, $iHidden = 1)
	{		
		$iHasEntry = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('group_design_order'))
			->where('group_id = ' . $iGroupId . ' AND cache_id = \'js_block_border_' . $this->database()->escape($sBlockId) . '\'')
			->execute('getSlaveField');
			
		if ($iHasEntry)
		{
			$this->database()->update(Phpfox::getT('group_design_order'), array('is_hidden' => $iHidden), 'group_id = ' . $iGroupId . ' AND cache_id = \'js_block_border_' . $this->database()->escape($sBlockId) . '\'');
		}
		else 
		{
			$this->database()->insert(Phpfox::getT('group_design_order'), array('group_id' => $iGroupId, 'cache_id' => 'js_block_border_' . $sBlockId, 'block_id' => null, 'ordering' => 0, 'is_hidden' => $iHidden));
		}
	}		
	
	public function deleteImage($iId)
	{
		$aGroup = $this->database()->select('user_id, image_path')
			->from($this->_sTable)
			->where('group_id = ' . (int) $iId)
			->execute('getRow');		
			
		if (!isset($aGroup['user_id']))
		{
			return Phpfox_Error::set('Unable to find the group.');
		}
			
		if (!Phpfox::getService('user.auth')->hasAccess('group', 'group_id', $iId, 'group.can_edit_own_group', 'group.can_edit_other_group', $aGroup['user_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('group.you_do_not_have_sufficient_permission_to_modify_this_group'));
		}			
		
		if (!empty($aGroup['image_path']))
		{
			$aImages = array(
				Phpfox::getParam('group.dir_image') . sprintf($aGroup['image_path'], ''),
				Phpfox::getParam('group.dir_image') . sprintf($aGroup['image_path'], '_50'),
				Phpfox::getParam('group.dir_image') . sprintf($aGroup['image_path'], '_120'),
				Phpfox::getParam('group.dir_image') . sprintf($aGroup['image_path'], '_200')
			);			
			
			$iFileSizes = 0;
			foreach ($aImages as $sImage)
			{
				if (file_exists($sImage))
				{
					$iFileSizes += filesize($sImage);
					
					Phpfox::getLib('file')->unlink($sImage);
				}
			}
			
			if ($iFileSizes > 0)
			{
				Phpfox::getService('user.space')->update($aGroup['user_id'], 'group', $iFileSizes, '-');
			}
		}

		$this->database()->update($this->_sTable, array('image_path' => null), 'group_id = ' . (int) $iId);	
		
		return true;
	}	
	
	public function delete($iId, &$aGroup = null)
	{
		if ($aGroup === null)
		{
			$aGroup = $this->database()->select('user_id, image_path, is_sponsor')
				->from($this->_sTable)
				->where('group_id = ' . (int) $iId)
				->execute('getRow');
				
			if (!isset($aGroup['user_id']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('group.unable_to_find_the_group_you_want_to_delete'));
			}
			
			if (!Phpfox::getService('user.auth')->hasAccess('group', 'group_id', $iId, 'group.can_delete_own_group', 'group.can_delete_other_group', $aGroup['user_id']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('group.you_do_not_have_sufficient_permission_to_delete_this_listing'));
			}
		}

		
		if (!empty($aGroup['image_path']))
		{
			$aImages = array(
				Phpfox::getParam('group.dir_image') . sprintf($aGroup['image_path'], ''),
				Phpfox::getParam('group.dir_image') . sprintf($aGroup['image_path'], '_50'),
				Phpfox::getParam('group.dir_image') . sprintf($aGroup['image_path'], '_120'),
				Phpfox::getParam('group.dir_image') . sprintf($aGroup['image_path'], '_200')
			);			
			
			$iFileSizes = 0;
			foreach ($aImages as $sImage)
			{
				if (file_exists($sImage))
				{
					$iFileSizes += filesize($sImage);
					
					Phpfox::getLib('file')->unlink($sImage);
				}
			}
			
			if ($iFileSizes > 0)
			{
				Phpfox::getService('user.space')->update($aGroup['user_id'], 'group', $iFileSizes, '-');
			}
		}
		
		// (Phpfox::isModule('comment') ? Phpfox::getService('comment.process')->deleteForItem(null, $iId, 'group') : null);		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('group', $iId) : null);
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('comment_group', $iId) : null);
		
		Phpfox::massCallback('deleteGroup', $iId);		
		
		/*
		$aInvites = $this->database()->select('invite_id, invited_user_id')
			->from(Phpfox::getT('group_invite'))
			->where('group_id = ' . (int) $iId)
			->execute('getSlaveRows');
		foreach ($aInvites as $aInvite)
		{
			(Phpfox::isModule('request') ? Phpfox::getService('request.process')->delete('group_invite', $aInvite['invite_id'], $aInvite['invited_user_id']) : false);
		}
		*/
		
		$this->database()->delete($this->_sTable, 'group_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('group_access'), 'group_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('group_text'), 'group_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('group_category_data'), 'group_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('group_invite'), 'group_id = ' . (int) $iId);
		$this->database()->delete(Phpfox::getT('group_design_order'), 'group_id = ' . (int) $iId);
		// $this->database()->delete(Phpfox::getT('group_shoutbox'), 'item_id = ' . (int) $iId);		
		if ($aGroup['is_sponsor'] == 1)
		{
			$this->cache()->remove('group_sponsored');
		}
		return true;
	}		
	
	public function deleteMember($iInviteId)
	{		
		$aGroup = $this->database()->select('e.group_id, e.user_id, ei.invited_user_id, ei.member_id')
			->from(Phpfox::getT('group_invite'), 'ei')
			->join($this->_sTable, 'e', 'e.group_id = ei.group_id')
			->where('ei.invite_id = ' . (int) $iInviteId)
			->execute('getRow');
			
		if (!isset($aGroup['user_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('group.unable_to_find_the_group'));
		}
			
		if ($aGroup['user_id'] == $aGroup['invited_user_id'] && !Phpfox::getService('user.auth')->hasAccess('group', 'group_id', $aGroup['group_id'], 'group.can_edit_own_group', 'group.can_edit_other_group', $aGroup['user_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('group.you_do_not_have_sufficient_permission_to_modify_this_group'));
		}
		
		$this->database()->delete(Phpfox::getT('group_invite'), 'invite_id = ' . (int) $iInviteId);	
		
		if ($aGroup['member_id'])
		{
			$this->database()->updateCount('group_invite', 'group_id = ' . (int) $aGroup['group_id'] . ' AND member_id = 1', 'total_member', 'group', 'group_id = ' . (int) $aGroup['group_id']);
		}
		
		(Phpfox::isModule('request') ? Phpfox::getService('request.process')->delete('group_invite', $iInviteId, $aGroup['invited_user_id']) : false);
			
		return true;
	}

	public function feature($iGroup, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('group.can_feature_groups', true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		
		$this->database()->update($this->_sTable, array('is_featured' => ((int) $iType == 1 ? '1' : '0')), 'group_id = ' . (int) $iGroup);
		
		return true;
	}

	/**
	 * Enables and disables sponsor of an item
	 * @param int $iGroup
	 * @param int $iType
	 * @return bool
	 */
	public function sponsor($iGroup, $iType)
	{
		if (!Phpfox::getUserParam('group.can_sponsor_group') && !Phpfox::getUserParam('group.can_purchase_sponsor') && !defined('PHPFOX_API_CALLBACK'))
		{
			return Phpfox_Error::set('Hack attempt?');
		}

		$iType = (int)$iType;
		if ($iType != 0 && $iType != 1)
		{
			return false;
		}
		$this->database()->update($this->_sTable, array('is_featured' => 0, 'is_sponsor' => $iType), 'group_id = ' . (int)$iGroup);

		$this->cache()->remove('group_sponsored');
		if ($sPlugin = Phpfox_Plugin::get('group.service_process_sponsor__end'))
		{
			return eval($sPlugin);
		}
		return true;
	}

	public function processAdmin($iInviteId, $iType)
	{
		$aGroup = $this->database()->select('g.group_id')
			->from(Phpfox::getT('group_invite'), 'gi')
			->join(Phpfox::getT('group'), 'g', 'g.group_id = gi.group_id')
			->where('gi.invite_id = ' . (int) $iInviteId)
			->execute('getSlaveRow');
			
		if (!isset($aGroup['group_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('group.group_is_not_valid'));
		}
		
		if (!Phpfox::getService('group')->isAdmin($aGroup['group_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('group.unable_to_add_the_user_as_an_admin'));
		}
		
		$this->database()->update(Phpfox::getT('group_invite'), array('is_admin' => ((int) $iType == 1 ? '1' : '0')), 'invite_id = ' . (int) $iInviteId);
		
		return true;
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
		if ($sPlugin = Phpfox_Plugin::get('group.service_process__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
	
	private function _verify(&$aVals)
	{				
		if (!isset($aVals['category']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('group.provide_a_category_this_group_will_belong_to'));
		}
		
		foreach ($aVals['category'] as $iCategory)
		{		
			if (empty($iCategory))
			{
				continue;
			}
			
			if (!is_numeric($iCategory))
			{
				continue;
			}			
			
			$this->_aCategories[] = $iCategory;
		}
		
		if (!count($this->_aCategories))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('group.provide_a_category_this_group_will_belong_to'));
		}		
		
		if (isset($_FILES['image']['name']) && ($_FILES['image']['name'] != ''))
		{
			$aImage = Phpfox::getLib('file')->load('image', array(
					'jpg',
					'gif',
					'png'
				), (Phpfox::getUserParam('group.max_upload_size_group') === 0 ? null : (Phpfox::getUserParam('group.max_upload_size_group') / 1024))
			);
			
			if ($aImage === false)
			{
				return false;
			}
			
			$this->_bHasImage = true;
		}	

		return true;	
	}	
}

?>