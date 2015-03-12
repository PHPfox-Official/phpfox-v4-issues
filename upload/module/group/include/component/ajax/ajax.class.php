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
 * @version 		$Id: ajax.class.php 2197 2010-11-22 15:26:08Z Raymond_Benc $
 */
class Group_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function joinGroup()
	{
		if ($mReturn = Phpfox::getService('group.process')->joinGroup($this->get('id'), ($this->get('approve') ? $this->get('approve') : Phpfox::getUserId())))
		{
			if ($this->get('is_invite'))
			{
				$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('group', array('view' => 'invite')) . '\';');
				return;
			}
			
			if ($this->get('approve'))
			{
				
			}
			else 
			{
				if ($this->get('parent'))
				{
					$this->hide('#js_group_join_' . $this->get('id'). '')->show('#js_group_leave_' . $this->get('id'). '');
					$this->call('$(\'#js_group_member_count_' . $this->get('id'). '\').html(parseInt($(\'#js_group_member_count_' . $this->get('id'). '\').html()) + 1);');				
				}
				else 
				{
					$this->hide('#js_group_join')->show('#js_group_leave');
					$this->call('$.ajaxCall(\'group.listMembers\', \'&id=' . $this->get('id') . '\');');
					$this->call('$(\'#js_group_member_count\').html(parseInt($(\'#js_group_member_count\').html()) + 1);');
				}
				
				if ($mReturn === '1')
				{
					$this->alert(Phpfox::getPhrase('group.thank_you_for_your_request_to_join_our_group_your_membership_will_first_have_to_be_approved'));
				}
			}
		}
	}
	
	public function leaveGroup()
	{
		if (Phpfox::getService('group.process')->leaveGroup($this->get('id'), Phpfox::getUserId()))
		{
			if ($this->get('is_invite'))
			{
				$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('group', array('view' => 'invite')) . '\';');
				return;
			}			
			
			if ($this->get('parent'))
			{
				$this->hide('#js_group_leave_' . $this->get('id'). '')->show('#js_group_join_' . $this->get('id'). '');
				$this->call('var iGroupMemCount = (parseInt($(\'#js_group_member_count_' . $this->get('id'). '\').html()) - 1); $(\'#js_group_member_count_' . $this->get('id'). '\').html((iGroupMemCount ? iGroupMemCount : \'0\'));');
			}
			else 
			{			
				$this->hide('#js_group_leave')->show('#js_group_join');
				$this->call('$.ajaxCall(\'group.listMembers\', \'&id=' . $this->get('id') . '\');');
				$this->call('var iGroupMemCount = (parseInt($(\'#js_group_member_count\').html()) - 1); $(\'#js_group_member_count\').html((iGroupMemCount ? iGroupMemCount : \'0\'));');
			}
		}
	}	
	
	public function listMembers()
	{
		Phpfox::getBlock('group.list');
		
		$this->html('#js_group_item_holder', $this->getContent(false));
		$this->call('$Behavior.imageHoverHolder();');
	}	
	
	public function updateDesign()
	{
		$aVals = $this->get('val');
		
		if (Phpfox::getService('group.process')->updateDesign($aVals))
		{			
			if (isset($aVals['iframe']))
			{
				$this->call('$(\'#js_theme_select_iframe\').attr(\'src\', \'' . $aVals['iframe'] . 'update_true/\');');	
			}
		}
	}
	
	public function deleteImage()
	{
		Phpfox::isUser(true);
		
		if (Phpfox::getService('group.process')->deleteImage($this->get('id')))
		{
			
		}
	}	
	
	public function deleteMember()
	{
		if (Phpfox::getService('group.process')->deleteMember($this->get('id')))
		{
			
		}
	}

	public function delete()
	{
		if (Phpfox::getService('group.process')->delete($this->get('id')))
		{
			$this->call('$(\'#js_group_' . $this->get('id') . '\').html(\'<div class="message" style="margin:0px;">' . Phpfox::getPhrase('group.successfully_deleted_the_group') . '</div>\').fadeOut(5000);');			
		}
	}	
	
	public function feature()
	{
		if (Phpfox::getService('group.process')->feature($this->get('id'), $this->get('type')))
		{
			
		}
	}

	public function sponsor()
	{
	    if (Phpfox::getService('group.process')->sponsor($this->get('group_id'), $this->get('type')))
	    {
		if ($this->get('type') == '1')
		{
		    Phpfox::getService('ad.process')->addSponsor(array('module' => 'group', 'item_id' => $this->get('group_id')));
		    $sHtml = '<a href="#" onclick="$.ajaxCall(\'group.sponsor\',\'group_id='.$this->get('group_id').'&amp;type=0\');return false;">'
			    .Phpfox::getPhrase('group.unsponsor')
			    .'</a>';
		    $this->call('$("#js_sponsor_'.$this->get('group_id').'").parents(".js_group_inline:first").addClass("row_sponsored");');		    
		}
		else
		{
		    Phpfox::getService('ad.process')->deleteAdminSponsor('group', $this->get('group_id'));
		    $sHtml = '<a href="#" onclick="$.ajaxCall(\'group.sponsor\',\'group_id='.$this->get('group_id').'&amp;type=1\');return false;">'
			    .Phpfox::getPhrase('group.sponsor')
			    .'</a>';		    
		    $this->call('$("#js_sponsor_'.$this->get('group_id').'").parents(".js_group_inline:first").removeClass("row_sponsored");');
		}
		$this->html('#js_sponsor_' . $this->get('group_id'), $sHtml)->alert($this->get('type') == '1' ? Phpfox::getPhrase('group.group_successfully_sponsored') : Phpfox::getPhrase('group.group_successfully_un_sponsored'));
	    }
	}
	
	public function invite()
	{
		Phpfox::isUser(true);
		Phpfox::getBlock('group.invite');
	}
	
	public function processInvite()
	{
		$aVals = $this->get('val');
		if (Phpfox::getService('group.process')->invite($aVals['group_id'], $aVals['user_id']))
		{
			$this->setMessage(Phpfox::getPhrase('group.group_invitation_successfully_sent'));	
		}
	}
	
	public function processUserInvite()
	{		
		if ($this->get('accept'))
		{
			if (($aGroup = Phpfox::getService('group.process')->joinGroup($this->get('group_id'), Phpfox::getUserId())))
			{
				$this->html('#js_group_invite_' . $this->get('group_id'), '<div class="message">' . Phpfox::getPhrase('group.you_have_successfully_joined_the_group_title', array('link' => Phpfox::getLib('url')->makeUrl('group', $aGroup['title_url']), 'title' => Phpfox::getLib('parse.output')->shorten($aGroup['title'], 20, '...'))) . '</div>');		
			}
		}
		else 
		{
			if (Phpfox::getService('group.process')->leaveGroup($this->get('group_id'), Phpfox::getUserId()))
			{
				$this->html('#js_group_invite_' . $this->get('group_id'), '<div class="message">' . Phpfox::getPhrase('group.successfully_denied_the_group_invitation') . '</div>', '.fadeOut(5000)');	
			}
		}
	}
	
	public function processAdmin()
	{
		if (Phpfox::getService('group.process')->processAdmin($this->get('id'), $this->get('type')))
		{
			
		}
	}
	
	public function approve()
	{
		Phpfox::getUserParam('group.can_approve_groups', true);
		Phpfox::getService('group.process')->approve($this->get('group_id'));		
	}
}

?>