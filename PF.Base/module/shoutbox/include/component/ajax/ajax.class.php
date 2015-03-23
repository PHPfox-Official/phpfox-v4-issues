<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * AJAX class for the shoutbox module. Used to add and get shoutouts.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Shoutbox
 * @version 		$Id: ajax.class.php 6909 2013-11-20 14:01:14Z Miguel_Espinoza $
 */
class Shoutbox_Component_Ajax_Ajax extends Phpfox_Ajax
{
	/**
	 * Add a new shoutout
	 *
	 * @return boolean Return false if we ran into an error.
	 */
	public function add()
	{
		// Only members allowed to add a shoutout
		Phpfox::isUser(true);
		// Make sure the user group adding a shoutout is allowed to do so
		Phpfox::getUserParam('shoutbox.can_add_shoutout', true);
		
		// Run last_post SPAM check
		if (Phpfox::getLib('spam')->check(array(
					'action' => 'last_post',
					'params' => array(
						'field' => 'time_stamp',
						'table' => Phpfox::getT('shoutbox'),
						'condition' => 'user_id = ' . Phpfox::getUserId(),
						'time_stamp' => Phpfox::getParam('shoutbox.shoutbox_flood_limit')
					)
				)
			)
		)
		{		
			// Reset the shoutbox form
			$this->show('#js_shoutbox_form')
				->hide('#js_shoutbox_message')
				->focus('#js_shoutbox_input');			
			
			// Send them a message that they failed the flood control
			$this->alert(Phpfox::getPhrase('shoutbox.please_wait_limit_seconds_before_adding_a_new_shoutout', array('limit' => Phpfox::getParam('shoutbox.shoutbox_flood_limit'))));
			
			return false;
		}		
				
		if (Phpfox::getLib('parse.format')->isEmpty($this->get('shoutout')))
		{
			$this->show('#js_shoutbox_form')
				->hide('#js_shoutbox_message')
				->val('#js_shoutbox_input', '')
				->focus('#js_shoutbox_input')
				->alert(Phpfox::getPhrase('shoutbox.enter_a_shoutout'));
			
			return false;
		}
		
		if ($this->get('module') == 'group' && (!Phpfox::getService('group')->hasAccess($this->get('item'), 'can_use_shoutbox', true)))
		{
			$this->show('#js_shoutbox_form')
				->hide('#js_shoutbox_message')
				->val('#js_shoutbox_input', '')
				->focus('#js_shoutbox_input')			
				->alert(Phpfox::getPhrase('shoutbox.only_members_of_this_group_can_leave_a_message'));
			
			return false;
		}
		
		// Add the shoutout
		if ($iId = Phpfox::getService('shoutbox.process')->add(Phpfox::getUserId(), $this->get('shoutout'), $this->get('module', null), $this->get('item', null)))
		{
			// Get all the default user fields we use
			$sFields = Phpfox::getUserField();
			// Create an array of the string fields
			$aFields = explode(',', $sFields);
			
			$aParams = array();
			foreach ($aFields as $sField)
			{
				// Replace database alias
				$sField = trim(str_replace('u.', '', $sField));
				// Cache the fields and get the current users actual value
				$aParams[$sField] = Phpfox::getUserBy($sField);
			}
				
			// Shorten the text
			// Clean the text, we don't allow HTML
			$sText = Phpfox::getLib('parse.output')->replaceHashTags(Phpfox::getLib('parse.output')->split(Phpfox::getLib('parse.output')->clean(Phpfox::getLib('parse.input')->clean($this->get('shoutout'), 255)), Phpfox::getParam('shoutbox.shoutbox_wordwrap')));
			
			// Parse emoticons
			$sText = Phpfox::getService('emoticon')->parse($sText);			
			
			// Create the needed template variables not defined with $aParams
			$aShoutout = array(
				'module' => $this->get('module'),
				'shout_id' => $iId,
				'time_stamp' => PHPFOX_TIME,
				'text' => $sText
			);
		
			// Assign the variables for the template and get the template
			$this->template()->assign(array(
					'bShoutboxAjax' => true,
					'aShoutout' => array_merge($aShoutout, $aParams), // Merge the arrays to create on variable
					'iShoutoutWordWrap' => Phpfox::getParam('shoutbox.shoutbox_wordwrap')
				)
			)->getTemplate('shoutbox.block.entry');
			
			// Add the message to the shoutbox and reset the shoutbox form
			$this->call('$(\'.js_shoutbox_messages\').removeClass(\'row_first\');')
				->prepend('#js_shoutbox_messages', $this->getContent(false))
				->show('#js_shoutbox_form')
				->hide('#js_shoutbox_message')
				->val('#js_shoutbox_input', '')
				->focus('#js_shoutbox_input');
		}
	}
	
	public function delete()
	{
		if (Phpfox::getService('shoutbox.process')->delete($this->get('id'), $this->get('module')))
		{
			
		}
	}
	
	/**
	 * Get the latest shoutbox messages.
	 *
	 */
	public function getMessages()
	{
		// Lets make sure this user group can actually view the shoutbox
		Phpfox::getUserParam('shoutbox.can_view_shoutbox', true);
		
		$iItem = $this->get('item', null);
		$sModule = $this->get('module', null);
		$aCallback = array();
		
		if ($iItem !== null && $sModule !== null)
		{
			$aCallback = array(
				'module' => $sModule,
				'item' => $iItem
			);
		}
		
		// Connect to our service and get the latest messages.
		$aShoutouts = Phpfox::getService('shoutbox')->callback($aCallback)->getMessages(Phpfox::getParam('shoutbox.shoutbox_display_limit'));
		// Run the for loop
		foreach ($aShoutouts as $iKey => $aShoutout)
		{
			// Assign the needed variables for each shoutout
			$this->template()->assign(array(
					'iShoutCount' => $iKey,
					'aShoutout' => $aShoutout,
					'iShoutoutWordWrap' => Phpfox::getParam('shoutbox.shoutbox_wordwrap')
				)
			)->getTemplate('shoutbox.block.entry');			
		}
		
		// Update the sites shoutout with the latest shoutouts
		$this->html('#js_shoutbox_messages', $this->getContent(false));
		
		// Should we refresh the data?
		if (Phpfox::getParam('shoutbox.shoutbox_is_live'))
		{
			// Add a refresh timeout()			
			$this->call('setTimeout("$.ajaxCall(\'shoutbox.getMessages\', (typeof $Core.Shoutbox != \'undefined\' && typeof $Core.Shoutbox.sParams != \'undefined\') ? $Core.Shoutbox.sParams : ' . (isset($aCallback['module']) ?  '\'module=' . $aCallback['module'] . '&item=' . $aCallback['item'] . '\'' : '\'\'') . ', \'GET\');", ' . (Phpfox::getParam('shoutbox.shoutbox_refresh') * 1000) . ');');
			
		}
		
		if (Phpfox::getParam('core.defer_loading_user_images'))
		{
			// http://www.phpfox.com/tracker/view/14632/
			$this->call('$Behavior.defer_images();');
			//$this->call('$Core.loadInit();');
		}
	}
}

?>
