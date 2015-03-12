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
 * @version 		$Id: ajax.class.php 7288 2014-04-28 18:08:00Z Fern $
 */
class Custom_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function edit()
	{	
		if (($sContent = Phpfox::getService('custom')->getFieldForEdit($this->get('field_id'), $this->get('item_id'), $this->get('edit_user_id'))))
		{		
			$this->call('$(\'#js_custom_field_' . $this->get('field_id') . '\').html(\'' . str_replace(array("'", '<br />'), array("\'", "\n"), $sContent) . '\');')
				->show('#js_custom_field_' . $this->get('field_id'));
				// ->hide('#js_custom_loader_' . $this->get('field_id'))
				// ->show('#js_custom_link_' . $this->get('field_id'));

			(($sPlugin = Phpfox_Plugin::get('custom.component_ajax_edit')) ? eval($sPlugin) : false);
		}
	}
	
	public function update()
	{
		if (($sContent = Phpfox::getService('custom.process')->updateField($this->get('field_id'), $this->get('item_id'), $this->get('edit_user_id'), $this->get('custom_field_value'))))
		{
			$this->hide('#js_custom_field_' . $this->get('field_id'))
				->html('#js_custom_content_' . $this->get('field_id'), $sContent)
				->show('#js_custom_content_' . $this->get('field_id'));			
		}
		else 
		{
			$this->call('$(\'#js_custom_field_' . $this->get('field_id') . '\').parents(\'.block:first\').remove();');			
		}
	}
	
	public function addGroup()
	{
		if (($iId = Phpfox::getService('custom.group.process')->add($this->get('val'))) && ($aGroup = Phpfox::getService('custom.group')->getGroup($iId)))
		{			
			$this->append('#js_group_listing', '<option value="' . $aGroup['group_id'] . '" selected="selected">' . Phpfox::getPhrase($aGroup['phrase_var_name']) . '</option>')
				->hide('#js_group_holder')
				->show('#js_field_holder');
		}
	}
	
	public function toggleActiveGroup()
	{
		if (Phpfox::getService('custom.group.process')->toggleActivity($this->get('id')))
		{
			$this->call('$Core.custom.toggleGroupActivity(' . $this->get('id') . ')');
		}		
	}
	
	public function toggleActiveField()
	{
		if (Phpfox::getService('custom.process')->toggleActivity($this->get('id')))
		{
			$this->call('$Core.custom.toggleFieldActivity(' . $this->get('id') . ')');
		}
	}
	
	public function deleteField()
	{
		if (Phpfox::getService('custom.process')->delete($this->get('id')))
		{
			$this->call('$(\'#js_field_' . $this->get('id') . '\').parents(\'li:first\').remove();');
		}
	}
	
	public function deleteOption()
	{
		if (Phpfox::getService('custom.process')->deleteOption($this->get('id')))
		{
			$this->call('$(\'#js_current_value_' . $this->get('id') . '\').remove();');
		}
		else
		{
		    $this->alert(Phpfox::getPhrase('custom.could_not_delete'));
		}
	}
	
	public function updateFields()
	{
		$aVals = $this->get('custom');
		if (empty($aVals))
		{
			$aVals = $this->get('val');
		}
		if (!(empty($aVals)))
		{
			$aCustomFields = Phpfox::getService('custom')->getForEdit(array('user_main', 'user_panel', 'profile_panel'), Phpfox::getUserId(), Phpfox::getUserBy('user_group_id'), false, Phpfox::getUserId());
			foreach ($aCustomFields as $aCustomField)
			{				
				if (empty($aVals[$aCustomField['field_id']]) && $aCustomField['is_required'])
				{
					Phpfox_Error::set(Phpfox::getPhrase('user.the_field_field_is_required', array('field' => Phpfox::getPhrase($aCustomField['phrase_var_name']))));
				}
				else if ((!isset($aVals[$aCustomField['field_id']]) || empty($aVals[$aCustomField['field_id']])) && !$aCustomField['is_required'])
				{
					Phpfox::getService('custom.process')->updateField($aCustomField, Phpfox::getUserId(), Phpfox::getUserId(),'');
				}
			}			
			
            if ($sPlugin = Phpfox_Plugin::get('custom.component_ajax_updatefields__1')){eval($sPlugin);if (isset($aPluginReturn)){return $aPluginReturn;}}
			if (Phpfox_Error::isPassed())
			{
				$bReturnCustom = Phpfox::getService('custom.process')->updateFields(Phpfox::getUserId(), Phpfox::getUserId(), $aVals);
				$aUser = $this->get('val');
				$aUser['language_id'] = Phpfox::getUserBy('language_id');
				define('PHPFOX_IS_CUSTOM_FIELD_UPDATE', true);
				
				// http://www.phpfox.com/tracker/view/15441/
				$aUserFieldsRequired = 
					array(
						'location' => array('user.location' => $aUser['country_iso']),
						'gender' => array('user.gender' => $aUser['gender']),
						'day' => array('user.date_of_birth' => $aUser['day']),
						'month' => array('user.date_of_birth' => $aUser['month']),
						'year' => array('user.date_of_birth' => $aUser['year'])
					);
					
				foreach($aUserFieldsRequired as $aFieldRequired)
				{
					foreach($aFieldRequired as $sLangId => $mValue)
					{
						if(empty($mValue))
						{
							Phpfox_Error::set(Phpfox::getPhrase('user.the_field_field_is_required', array('field' => Phpfox::getPhrase($sLangId))) . " ");
						}
					}
				}
				
				$bReturnUser = false;
				if(Phpfox_Error::isPassed())
				{
					$bReturnUser = Phpfox::getService('user.process')->update(Phpfox::getUserId(), $aUser);
				}
				// END!
				
				if ($bReturnCustom && $bReturnUser)
				{
					$this->call('$(\'#js_custom_submit_button\').attr(\'disabled\', false).removeClass(\'disabled\'); $(\'#js_custom_update_info\').html(\''.str_replace("'", "\\'", Phpfox::getPhrase('user.done')).'\').fadeOut(5000);')
					->slideDown('#js_custom_public_message');
					return true;
				}
			}
			
			$this->call('$(\'#js_custom_submit_button\').attr(\'disabled\', false).removeClass(\'disabled\'); $(\'#js_custom_update_info\').hide();');			
			
		}		
	}
	
	public function processRelationship()
	{
		Phpfox::isUser(true);
		
		$aRelationship = Phpfox::getService('custom.relation')->getDataById($this->get('relation_data_id'));
		
		if (isset($aRelationship['with_user_id']) && $aRelationship['with_user_id'] == Phpfox::getUserId())
		{
			if ($this->get('type') == 'accept')
			{
				Phpfox::getService('custom.relation.process')->updateRelationship(0, $aRelationship['user_id'], $aRelationship['with_user_id']);
				
				$this->addClass('.js_friend_request_' . $this->get('request_id'), 'row_moderate');
				$this->call('$(\'.js_friend_request_' . $this->get('request_id') . '\').find(\'.js_drop_data_add\').hide();');
				$this->call('$(\'.js_friend_request_' . $this->get('request_id') . '\').find(\'.js_drop_data_button\').hide();');
				$this->call('$(\'.js_friend_request_' . $this->get('request_id') . '\').find(\'.extra_info_middot\').show();');					
			}
			else
			{
				Phpfox::getService('custom.relation.process')->denyStatus($this->get('relation_data_id'), $aRelationship['with_user_id']);
				Phpfox::getService('friend.request.process')->delete($this->get('request_id'), $aRelationship['user_id']);
				$this->remove('.js_friend_request_' . $this->get('request_id'));	
			}
		}
		else if (empty($aRelationship))
		{
			Phpfox::getService('custom.relation.process')->checkRequest($this->get('relation_data_id'));
			$this->remove('.js_friend_request_' . $this->get('request_id'));
		}
	}
}

?>
