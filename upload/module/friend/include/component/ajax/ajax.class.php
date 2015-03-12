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
 * @package  		Module_Friend
 * @version 		$Id: ajax.class.php 7314 2014-05-09 13:41:44Z Fern $
 */
class Friend_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function getOnlineFriends()
	{
		Phpfox::getBlock('friend.mini');
		
		$this->call('$(\'#js_block_border_friend_mini\').find(\'.content:first\').html(\'' . $this->getContent() . '\');');
		if(!Phpfox::getParam('core.site_wide_ajax_browsing'))
		{
			$this->call('$Core.loadInit();');
		}
	}
	
	/**
	 * Shows the congratulate box for a birthday congratulation
	 */
	public function congratulate()
	{
		Phpfox::isUser(true);
		$iUser = (int)$this->get('iUser');
		Phpfox::getBlock('friend.congratulate', array('iUser' => $iUser));
	}

	/**
	 * Actually manages the sending of the message
	 */
	public function sendCongrats()
	{
		$aVal = $this->getAll('val');

		$iUser = (int) $aVal['val']['iUser'];
		$sMessage = $aVal['val']['message'];
		/* id for the egift*/
		$iEgift = $fCost = 0;
		if (isset($aVal['val']['egift_id']))
		{
			$iEgift = ((int) $aVal['val']['egift_id']);
			$fCost = Phpfox::getService('egift')->getCost($iEgift);
		}
		
		
		/* Add it to the database, but if its not free then hide it and dont send the notification */
		$mSent = Phpfox::getService('friend.process')->sendCongrats($iUser, $sMessage, $iEgift, $fCost);	
		/* $mSent is the invoice_id from egift_invoice*/
		if ($mSent > 0 && !is_bool($mSent))
		{
			Phpfox::getBlock('api.gateway.form',
							array('gateway_data' => array(
									'item_number' => 'egift|' . $mSent, 
									'currency_code' => Phpfox::getService('core.currency')->getDefault(),
									'amount' => $fCost,
									'item_name' => 'egift card with message: ' . $sMessage . '',
									'return' => Phpfox::getLib('url')->makeUrl('friend.invoice'),
									'recurring' => 0,
									'recurring_cost' => '',
									'alternative_cost' => 0,
									'alternative_recurring_cost' => 0
							)));
			$this->html('#TB_ajaxContent', $this->getContent(false));
		}
		else
		{
			$this->error(false);
			if ($mSent)
			{
				$this->height('#TB_ajaxContent', '30px')->html('#TB_ajaxContent', '<div class="valid_message">' . Phpfox::getPhrase('friend.your_message_has_been_sent') . '</div>')->call('setTimeout("tb_remove();", 1000);');
				$this->call('$("#js_congratulate_' . $iUser . '").hide("slow");');
				$this->hide('#js_form_congratulate');
				$this->alert(Phpfox::getPhrase('friend.your_message_has_been_sent'));
			}
			else
			{
				$sErrors = implode(',', Phpfox_Error::get());
				$this->call('$("#TB_ajaxContent").find(".error_message").remove();');
				$this->append('#TB_ajaxContent', '<div class="error_message">' . $sErrors . '</div>');
			}
		}
	}
	
	public function request()
	{
		Phpfox::isUser(true);	
		Phpfox::getUserParam('friend.can_add_friends', true);		
		
		$this->setTitle(Phpfox::getPhrase('friend.add_to_friends'));
		
		Phpfox::getBlock('friend.request', array('user_id' => $this->get('user_id')));			
		
		echo $this->template()->getHeader();
	}
	
	public function processRequest()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('friend.can_add_friends', true);
		
		if (Phpfox::getService('friend')->isFriend($this->get('user_id'), Phpfox::getUserId()))
		{
			Phpfox::getService('friend.request.process')->delete($this->get('request_id'), $this->get('user_id'));
			$this->call(' $("#js_new_friend_request_' . $this->get('request_id') . '").remove();');
			return false;
		}
		
		$aVal = $this->get('val');
		if ($this->get('type') == 'yes')
		{
			if (Phpfox::getService('friend.process')->add(Phpfox::getUserId(), $this->get('user_id'), (isset($aVal['list_id']) ? (int) $aVal['list_id'] : 0)))
			{
				$this->html('#drop_down_' . $this->get('request_id'), Phpfox::getPhrase('friend.confirmed'));
			}
		}
		else 
		{
			if (Phpfox::getService('friend.process')->deny(Phpfox::getUserId(), $this->get('user_id')))
			{
				$this->html('#drop_down_' . $this->get('request_id'), Phpfox::getPhrase('friend.denied'));
			}			
		}
		
		if ($this->get('inline'))
		{
			$aUser = Phpfox::getService('user')->getUser($this->get('user_id'));
			$this->call('$(\'.js_friend_request_' . $this->get('request_id') . '\').find(\'.js_drop_data_add\').hide();');
			if ($this->get('type') == 'yes')
			{	
				$this->addClass('.js_friend_request_' . $this->get('request_id'), 'row_moderate');
				
				$this->call('$(\'.js_friend_request_' . $this->get('request_id') . '\').find(\'.extra_info_middot\').show();');				
			}
			else 
			{
				//$this->remove('.js_friend_request_' . $this->get('request_id'));
			}		
		}
		else 
		{
			$this->call("tb_remove();");
		}
		
		if (isset($aVal['suggestion']))
		{
			// $this->loadSuggestion();
		}		
		
		// $this->call('$Core.loadInit();');
		$this->remove('.js_profile_online_friend_request');
	}
	
	public function addRequest()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('friend.can_add_friends', true);
		
		$aVals = $this->get('val');		
		$aUser = Phpfox::getService('user')->getUser($aVals['user_id'], 'u.user_id, u.user_name, u.user_image, u.server_id');
		
		if (Phpfox::getUserId() === $aUser['user_id'])
		{
			return false;
		}
		elseif (Phpfox::getService('friend.request')->isRequested(Phpfox::getUserId(), $aUser['user_id']))
		{	
			Phpfox_Error::set('You were already requested to be friends');
			//return false;
		}		
		elseif (Phpfox::getService('friend.request')->isRequested($aUser['user_id'], Phpfox::getUserId()))
		{
			Phpfox_Error::set('You already requested to be friends');
			//return false;
		}
		elseif (Phpfox::getService('friend')->isFriend($aUser['user_id'], Phpfox::getUserId()))
		{	
			Phpfox_Error::set('You are already friends with this user');
			//return false;
		}
		else if (Phpfox::getService('user.block')->isBlocked($aUser['user_id'], Phpfox::getUserId()) /* is user blocked*/
			&& (Phpfox::isModule('friend') && Phpfox::getParam('friend.allow_blocked_user_to_friend_request') == false)
				)
		{
			$this->call('tb_remove();');
			return Phpfox_Error::set(Phpfox::getPhrase('friend.unable_to_send_a_friend_request_to_this_user_at_this_moment'));
		}
		if (Phpfox_Error::isPassed() != true)
		{
			$this->call('tb_remove();');
			return false;
		}
		if (Phpfox::getService('friend.request.process')->add(Phpfox::getUserId(), $aVals['user_id'], (isset($aVals['list_id']) ? $aVals['list_id'] : 0), $aVals['text']))
		{
			if (isset($aVals['invite']))
			{
				$this->call('tb_remove();')->html('#js_invite_user_' . $aVals['user_id'], '' . Phpfox::getPhrase('friend.friend_request_successfully_sent') . '');	
			}			
			else 
			{
				$this->call('tb_remove(); $("#core_js_messages").html(""); $("#core_js_messages").message("' . Phpfox::getPhrase('friend.friend_request_successfully_sent') . '", "valid").slideDown("slow").fadeOut(5000);');
				$this->remove('#js_add_friend_on_profile');
			}

			$this->call('$(\'#js_parent_user_' . $aVals['user_id'] . '\').find(\'.user_browse_add_friend:first\').hide();');
			
			if (isset($aVals['suggestion']))
			{				
				$this->loadSuggestion(false);
			}
			
			if (isset($aVals['page_suggestion']))
			{
				$this->hide('#js_suggestion_parent_' . $aVals['user_id']);
			}
		}		
	}
	
	public function addList()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('friend.can_add_folders', true);
		
		$sName = $this->get('name');

		if (Phpfox::getLib('parse.format')->isEmpty($sName))
		{
			$this->html('#js_friend_list_add_error', Phpfox::getPhrase('friend.provide_a_name_for_your_list'), '.show()');
			$this->call('$Core.processForm(\'#js_friend_list_add_submit\', true);');
		}
		elseif (Phpfox::getService('friend.list')->reachedLimit()) // Did they reach their limit?
		{
			$this->html('#js_friend_list_add_error', Phpfox::getPhrase('friend.you_have_reached_your_limit'), '.show()');
			$this->call('$Core.processForm(\'#js_friend_list_add_submit\', true);');
		}			
		elseif (Phpfox::getService('friend.list')->isFolder($sName))
		{
			$this->html('#js_friend_list_add_error', Phpfox::getPhrase('mail.folder_already_use'), '.show()');
			$this->call('$Core.processForm(\'#js_friend_list_add_submit\', true);');
		}
		else 
		{
			if ($iId = Phpfox::getService('friend.list.process')->add($sName))
			{
				if ($this->get('custom'))
				{
					$this->hide('#js_create_custom_friend_list')->show('#js_add_friends_to_list')->val('#js_custom_friend_list_id', $iId);
				}
				else 
				{
					$this->call('js_box_remove($(\'#js_friend_list_add_error\'));');
					$this->alert(Phpfox::getPhrase('friend.list_successfully_created'), Phpfox::getPhrase('friend.create_new_list'), 400, 150, true);
					$this->call('$Core.friend.addNewList(' . (int) $iId . ', \'' . str_replace("'", "\\'", Phpfox::getLib('parse.input')->clean($sName)) . '\');');
					$this->append('.sub_section_menu ul', '<li><a href="' . Phpfox::getLib('url')->makeUrl('friend', array('view' => 'list', 'id' => $iId)) . '">' . str_replace("'", "\\'", Phpfox::getLib('parse.input')->clean($sName)) . '</a></li>');
				}
				$this->call('$Core.loadInit()');
			}
		}
	}

	public function addNewList()
	{
		$this->setTitle(Phpfox::getPhrase('friend.create_new_list'));
		
		Phpfox::getBlock('friend.list.add');
	}
	
	public function buildCache()
	{
		$this->call('$Cache.friends = ' . json_encode(Phpfox::getService('friend')->getFromCache($this->get('allow_custom'))) . ';');
	}
	
	public function getLiveSearch()
	{
		// This function is called from friend.static.search.js::getFriends in response to a keyup event when is_mail is passed as true in building the template
		// parent_id we have to find the class "js_temp_friend_search_form" from its parents
		// search_for 
		$aUsers = Phpfox::getService('friend')->getFromCache(false,$this->get('search_for'));
		
		if (empty($aUsers))
		{
			return false;
		}
		// The next block is copied and modified from friend.static.search.js::getFriends
		$sHtml = '';
		$iFound = 0;
		$sStoreUser = '';
		foreach ($aUsers as $aUser)
		{
			$iFound++;
			$sHtml .= '<li><a rel="' . $aUser['user_id'] . '" class="js_friend_search_link ' . (($iFound == 1) ? 'js_temp_friend_search_form_holder_focus' : '') . '" href="#" onclick="return $Core.searchFriendsInput.processClick(this, \'' . $aUser['user_id'] . '\');"><img src="' . $aUser['user_image'] . '" alt="" style="width:25px; height:25px;" />' . $aUser['full_name'] . '<div class="clear"></div></a></li>';			
			$sStoreUser .= '$Core.searchFriendsInput.storeUser('.$aUser['user_id'].', JSON.parse('. json_encode(json_encode($aUser)) .'));';
			
			if ($iFound > $this->get('total_search'))
			{
				break;
			}
		}
		// find('.js_temp_friend_search_form')
		$sHtml = '<div class="js_temp_friend_search_form_holder" style="width:' . $this->get('width') . ';"><ul>' . $sHtml . '</ul></div>';
		$this->call($sStoreUser);
		$this->call('$("#'.$this->get('parent_id') . '").parent().find(".js_temp_friend_search_form").html(\''. str_replace("'", "\\'",$sHtml) .'\').show();');
	}
	public function updateOrder()
	{
		Phpfox::isUser(true);
		
		Phpfox::getService('friend.process')->updateOrder($this->get('user'));
		
		Phpfox::getBlock('friend.top', array(
				'bIsAjax' => true
			)
		);
				
		$this->call("$('#sJsBlockBorder_TopFriends').find('.block_content').html('" . $this->getContent() . "');");
		$this->call("$('#sJsBlockBorder_TopFriends').find('h3').html('" . Phpfox::getPhrase('friend.top_friends', array('phpfox_squote' => true)) . "');");
	}
	
	public function addTop()
	{
		Phpfox::isUser(true);
		
		Phpfox::getService('friend.process')->toggleTop($this->get('id'));		
		Phpfox::getBlock('friend.top', array(
				'bIsAjax' => true
			)
		);
		
		$sPath = Phpfox::getLib('template')->getStyle('image', 'misc/favorite.png');
		$sLink = '<a href="#" onclick="$.ajaxCall(\'friend.deleteTop\', \'id=' . $this->get('id') . '\'); return false;" title="' . Phpfox::getPhrase('friend.remove_from_your_top_friends_list') . '"><img src="' . $sPath . '" style="vertical-align:middle;" /></a>';
				
		$this->call("$('#js_block_border_friend_top').find('.content').html('" . $this->getContent() . "'); $('#js_add_top_fav_link_" . $this->get('id') . "').html('" . str_replace("'", "\'", $sLink) . "'); $Behavior.orderTopFriends();");		
	}
	
	public function deleteTop()
	{
		Phpfox::isUser(true);
		
		Phpfox::getService('friend.process')->toggleTop($this->get('id'), true);
		Phpfox::getBlock('friend.top', array(
			'bIsAjax' => true
		));
		
		$sPath = Phpfox::getLib('template')->getStyle('image', 'misc/favorite_add.png');
		$sLink = '<a href="#"" onclick="$.ajaxCall(\'friend.addTop\', \'id=' . $this->get('id') . '\'); return false;" title="' . Phpfox::getPhrase('friend.add_to_your_top_friends_list') . '"><img src="' . $sPath . '" style="vertical-align:middle;" /></a>';		
				
		$this->call("$('#js_block_border_friend_top').find('.content').html('" . $this->getContent() . "'); $('#js_add_top_fav_link_" . $this->get('id') . "').html('" . str_replace("'", "\'", $sLink) . "'); $Behavior.orderTopFriends();");			
	}
	
	public function editLists()
	{
		Phpfox::getBlock('friend.list.edit');
		$this->call("$('#js_friend_box_lists').hide();");			
		$this->html('#js_edit_lists', $this->getContent(false));	
		$this->call('$Core.loadInit();');		
	}
	
	public function updateList()
	{
		if (Phpfox::getService('friend.list.process')->update($this->get('list_id'), $this->get('name')))
		{
			$this->call('$Core.friend.updateListTitle(\'' . str_replace("'", "\\'", Phpfox::getLib('parse.input')->clean($this->get('name'), 255)) . '\');');	
		}		
	}
	
	public function deleteList()
	{
		if (Phpfox::getService('friend.list.process')->delete($this->get('id')))
		{
			$this->call("$('#js_edit_input_list_" . $this->get('id') . "').hide();");
			$this->call("$('.sJsList_" . $this->get('id') . "').hide(); $Core.loadInit();");
		}
	}

	public function move()
	{
		Phpfox::isUser(true);
		
		$aVals = $this->get('val');
		if (Phpfox::getService('friend.list.process')->move($this->get('list'), $aVals['id']))
		{
			Phpfox::addMessage(Phpfox::getPhrase('friend.friends_successfully_moved'));
			
			$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('friend', array('view' => 'list', 'id' => $this->get('list'))) . '\';');	
		}		
	}
	
	public function delete()
	{
		$bDeleted = $this->get('id') ? Phpfox::getService('friend.process')->delete($this->get('id')) : Phpfox::getService('friend.process')->delete($this->get('friend_user_id'), false);
		
		if ($bDeleted)
		{
			if ($this->get('reload'))
			{				
				$this->call('window.location.href=window.location.href');
				return;
			}
			$this->call('$("#js_friend_' . $this->get('id') . '").remove();');
			$this->alert(Phpfox::getPhrase('friend.friend_successfully_removed'), Phpfox::getPhrase('friend.remove_friend'), 300, 150, true);
		}
	}
	
	public function search()
	{
		Phpfox::getBlock('friend.search', array('input' => $this->get('input'), 'friend_module_id' => $this->get('friend_module_id'), 'friend_item_id' => $this->get('friend_item_id'), 'type' => $this->get('type')));
		if ($this->get('type') == 'mail')
		{
			$this->call('<script type="text/javascript">$(\'#TB_ajaxWindowTitle\').html(\'' . Phpfox::getPhrase('friend.search_for_members', array('phpfox_squote' => true)) . '\');</script>');
		}
		else 
		{			
			$this->call('<script type="text/javascript">$(\'#TB_ajaxWindowTitle\').html(\'' . Phpfox::getPhrase('friend.search_for_your_friends', array('phpfox_squote' => true)) . '\');</script>');
		}
	}
	
	public function searchAjax()
	{		
		Phpfox::getBlock('friend.search', array('search' => true, 'friend_module_id' => $this->get('friend_module_id'), 'friend_item_id' => $this->get('friend_item_id'), 'page' => $this->get('page'), 'find' => $this->get('find'), 'letter' => $this->get('letter'), 'input' => $this->get('input'), 'view' => $this->get('view'), 'type' => $this->get('type')));
		
		$this->call('$(\'#js_friend_search_content\').html(\'' . $this->getContent() . '\'); updateFriendsList();');		
	}
	
	public function searchDropDown()
	{
		Phpfox::isUser(true);
		$oDb = Phpfox::getLib('database');
		$sFind = $this->get('search');
		if (empty($sFind))
		{
			$iCnt = 0;
		}
		else 
		{
			list($iCnt, $aFriends) = Phpfox::getService('friend')->get('friend.is_page = 0 AND friend.user_id = ' . Phpfox::getUserId() . ' AND (u.full_name LIKE \'%' . Phpfox::getLib('parse.input')->convert($oDb->escape($sFind)) . '%\' OR (u.email LIKE \'%' . $oDb->escape($sFind) . '@%\' OR u.email = \'' . $oDb->escape($sFind) . '\'))', 'friend.time_stamp DESC', 0, 10, true, true);
		}
		
		if ($iCnt)
		{
			$sHtml = '';
			foreach ($aFriends as $aFriend)
			{
				$sHtml .= '<li><a href="#" onclick="$(\'#' . $this->get('div_id') . '\').parent().hide(); $(\'#' . $this->get('input_id') . '\').val(\'' . $aFriend['user_id'] . '\'); $(\'#' . $this->get('text_id') . '\').val(\'' . addslashes(str_replace("O&#039;", "'", $aFriend['full_name'])) . '\'); return false;">' . Phpfox::getLib('parse.output')->shorten(Phpfox::getLib('parse.output')->clean($aFriend['full_name']), 40, '...') . '</a></li>';
			}
			$this->html('#' . $this->get('div_id'), '<ul>' . $sHtml . '</ul>');
			$this->call('$(\'#' . $this->get('div_id') . '\').parent().show();');
		}
		else 
		{
			$this->html('#' . $this->get('div_id'), '');
			$this->call('$(\'#' . $this->get('div_id') . '\').parent().hide();');
		}
	}
	
	public function getEditBar()
	{
		Phpfox::getBlock('friend.setting');
		$this->html('#js_edit_block_' . $this->get('block_id'), $this->getContent(false))->slideDown('#js_edit_block_' . $this->get('block_id'));
	}	
	
	public function loadSuggestion($bLoadTemplate = true)
	{		
		Phpfox::getBlock('friend.suggestion', 'reload=true');
		
		if ($bLoadTemplate === true)
		{
			Phpfox::getLib('template')->getTemplate('friend.block.suggestion');
		}
		
		$this->slideUp('#js_friend_suggestion_loader')->html('#js_friend_suggestion', $this->getContent(false))->slideDown('#js_friend_suggestion');	
		$this->call('$Core.loadInit();');	
	}
	
	public function removeSuggestion()
	{		
		if (Phpfox::getService('friend.suggestion')->remove($this->get('user_id')))
		{
			if ($this->get('load'))
			{
				$this->loadSuggestion(false);	
			}			
		}
	}
	
	public function addFriendsToList()
	{
		if (Phpfox::getService('friend.list.process')->addFriendsToList((int) $this->get('list_id'), (array) $this->get('friends')))
		{
			Phpfox::getBlock('privacy.friend', array('bNoCustomDiv' => true, 'list_id' => (int) $this->get('list_id')));					
			
			$this->html('#js_custom_friend_list', $this->getContent(false));				
		}
	}
	
	public function manageList()
	{
		Phpfox::isUser(true);
		
		if ($this->get('type') == 'add')
		{
			Phpfox::getService('friend.list.process')->addFriendsTolist($this->get('list_id'), $this->get('friend_id'));			
		}
		else
		{
			Phpfox::getService('friend.list.process')->removeFriendsFromlist($this->get('list_id'), $this->get('friend_id'));
		}
	}
	
	public function setProfileList()
	{
		Phpfox::isUser(true);
		
		if ($this->get('type') == 'add')
		{
			if (Phpfox::getService('friend.list.process')->addListToProfile($this->get('list_id')))
			{
				$this->call('$(\'.friend_list_display_profile\').parent().hide();');
				$this->call('$(\'.friend_list_remove_profile\').parent().show();');
				$this->alert(Phpfox::getPhrase('friend.successfully_added_this_list_to_your_profile'), Phpfox::getPhrase('friend.profile_friend_lists'), 300, 150, true);								
			}
		}
		else
		{
			if (Phpfox::getService('friend.list.process')->removeListFromProfile($this->get('list_id')))
			{
				$this->call('$(\'.friend_list_display_profile\').parent().show();');
				$this->call('$(\'.friend_list_remove_profile\').parent().hide();');
			}
		}
	}
	
	public function updateListOrder()
	{
		Phpfox::isUser(true);

		if (Phpfox::getService('friend.list.process')->updateListOrder($this->get('list_id'), $this->get('friend_id')))
		{
			$this->alert(Phpfox::getPhrase('friend.order_successfully_saved'), Phpfox::getPhrase('friend.list_order'), 400, 150, true);
			$this->call('$Core.processForm(\'#js_friend_list_order_form\', true);');
		}
	}
	
	public function viewMoreFriends()
	{
		Phpfox::getComponent('friend.index', array(), 'controller');
		
		// $this->remove('.js_friend_edit_order_submit');
		$this->remove('.js_pager_view_more_link');
		$this->append('#js_view_more_friends', $this->getContent(false));
		$this->call('$Core.loadInit();');		
	}
	
	public function getRequests()
	{
		if (!Phpfox::isUser())
		{
			$this->call('<script type="text/javascript">window.location.href = \'' . Phpfox::getLib('url')->makeUrl('user.login') . '\';</script>');
		}
		else
		{
			Phpfox::getBlock('friend.accept');		
		}
	}
	
	public function getMutualFriends()
	{
		Phpfox::isUser(true);
		if ((int) $this->get('page') == 0)
		{
			$this->setTitle(Phpfox::getPhrase('friend.mutual_friends'));
		}
		Phpfox::getBlock('friend.mutual-browse');	
		
		if ((int) $this->get('page') > 0)
		{
			$this->remove('#js_friend_mutual_browse_append_pager');
			$this->append('#js_friend_mutual_browse_append', $this->getContent(false));
		}
	}
	
	public function moderation()
	{
		Phpfox::isUser(true);
				
		switch ($this->get('action'))
		{
			case 'accept':
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					if (($aRequest = Phpfox::getService('friend.request')->getRequest($iId)) === false)
					{
						continue;
					}
					
					Phpfox::getService('friend.process')->add(Phpfox::getUserId(), $aRequest['friend_user_id']);
					
					$this->remove('.js_friend_request_' . $iId);					
				}				
				$this->updateCount();
				$sMessage = 'Friend Request(s) successfully confirmed.';
				break;			
			case 'deny':
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					if (($aRequest = Phpfox::getService('friend.request')->getRequest($iId)) === false)
					{
						continue;
					}				
					
					Phpfox::getService('friend.process')->deny(Phpfox::getUserId(), $aRequest['friend_user_id']);
					
					$this->remove('.js_friend_request_' . $iId);
				}				
				$sMessage = 'Friend Request(s) successfully denied.';
				break;
		}
		
		// $this->alert($sMessage, 'Moderation', 300, 150, true);
		$this->hide('.moderation_process');			
	}	
}

?>
