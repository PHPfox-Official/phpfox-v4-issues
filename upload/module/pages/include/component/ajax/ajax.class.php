<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 7075 2014-01-28 16:04:34Z Fern $
 */
class Pages_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function removeLogo()
	{
		if (($aPage = Phpfox::getService('pages.process')->removeLogo($this->get('page_id'))) !== false)
		{
			$this->call('window.location.href = \'' . $aPage['link'] . '\';');
		}
	}	
	
	public function deleteWidget()
	{
		if (Phpfox::getService('pages.process')->deleteWidget($this->get('widget_id')))
		{
			$this->slideUp('#js_pages_widget_' . $this->get('widget_id'));
		}
	}
	
	public function addWidget()
	{
		$this->error(false);		
		if (($this->get('widget_id') ? Phpfox::getService('pages.process')->updateWidget($this->get('widget_id'), $this->get('val')) : Phpfox::getService('pages.process')->addWidget($this->get('val'))))
		{
			$aVals = $this->get('val');
			$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('pages.add.widget', array('id' => $aVals['page_id'])) . '\';');			
		}
		else
		{
			$this->call('$Core.processForm(\'#js_pages_widget_submit_button\', true);');
			$this->html('#js_pages_widget_error', '<div class="error_message">' . implode('', Phpfox_Error::get()) . '</div>');
			$this->show('#js_pages_widget_error');
		}
	}
	
	public function widget()
	{
		$this->setTitle(Phpfox::getPhrase('pages.widgets'));
		Phpfox::getComponent('pages.widget', array(), 'controller');			
		
		(($sPlugin = Phpfox_Plugin::get('pages.component_ajax_widget')) ? eval($sPlugin) : false);
		
		echo '<script type="text/javascript">$Core.loadInit();</script>';
	}
	
	public function add()
	{
		Phpfox::isUser(true);
		if (($iId = Phpfox::getService('pages.process')->add($this->get('val'))))
		{
			$aPage = Phpfox::getService('pages')->getPage($iId);
			
			$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('pages.add', array('id' => $aPage['page_id'], 'new' => '1')) . '\';');
		}
		else
		{
			$sError = Phpfox_Error::get();
			$sError = implode('<br />', $sError);
			$this->alert($sError);
			$this->call('$Core.processForm(\'#js_pages_add_submit_button\', true);');
		}
	}
	
	public function addFeedComment()
	{
		Phpfox::isUser(true);
				
		$aVals = (array) $this->get('val');	
		
		if (!defined('PAGE_TIME_LINE'))
		{
		    // Check if this item is a page and is using time line
		    if (isset($aVals['callback_module']) && $aVals['callback_module'] == 'pages' && isset($aVals['callback_item_id']) && Phpfox::getService('pages')->timelineEnabled($aVals['callback_item_id']))
		    {
			define('PAGE_TIME_LINE', true);			
		    }
			
		}
		
		if (Phpfox::getLib('parse.format')->isEmpty($aVals['user_status']))
		{
			$this->alert(Phpfox::getPhrase('user.add_some_text_to_share'));
			$this->call('$Core.activityFeedProcess(false);');
			return;			
		}
		
		$aPage = Phpfox::getService('pages')->getPage($aVals['callback_item_id']);

		if (!isset($aPage['page_id']))
		{
			$this->alert(Phpfox::getPhrase('pages.unable_to_find_the_page_you_are_trying_to_comment_on'));
			$this->call('$Core.activityFeedProcess(false);');
			return;
		}
		
		$sLink = Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'], $aPage['vanity_url']);
		$aCallback = array(
			'module' => 'pages',
			'table_prefix' => 'pages_',
			'link' => $sLink,
			'email_user_id' => $aPage['user_id'],
			'subject' => Phpfox::getPhrase('pages.full_name_wrote_a_comment_on_your_page_title', array('full_name' => Phpfox::getUserBy('full_name'), 'title' => $aPage['title'])),
			'message' => Phpfox::getPhrase('pages.full_name_wrote_a_comment_link', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink, 'title' => $aPage['title'])),
			'notification' => ($this->get('custom_pages_post_as_page') ? null : 'pages_comment'),
			'feed_id' => 'pages_comment',
			'item_id' => $aPage['page_id']
		);
		
		$aVals['parent_user_id'] = $aVals['callback_item_id'];
		
		if (isset($aVals['user_status']) && ($iId = Phpfox::getService('feed.process')->callback($aCallback)->addComment($aVals)))
		{
			Phpfox::getLib('database')->updateCounter('pages', 'total_comment', 'page_id', $aPage['page_id']);		
			
			Phpfox::getService('feed')->callback($aCallback)->processAjax($iId);
		}
		else 
		{
			$this->call('$Core.activityFeedProcess(false);');
		}		
	}	
	
	public function changeUrl()
	{
		Phpfox::isUser(true);
		
		if (($aPage = Phpfox::getService('pages')->getForEdit($this->get('id'))))
		{
			$aVals = $this->get('val');
			
			$sNewTitle = Phpfox::getLib('parse.input')->cleanTitle($aVals['vanity_url']);
			
			if (Phpfox::getLib('parse.input')->allowTitle($sNewTitle, Phpfox::getPhrase('pages.page_name_not_allowed_please_select_another_name')))
			{
				if (Phpfox::getService('pages.process')->updateTitle($this->get('id'), $sNewTitle))
				{
					$this->alert(Phpfox::getPhrase('pages.successfully_updated_your_pages_url'), Phpfox::getPhrase('pages.url_updated'), 300, 150, true);
				}
			}		
		}
		
		$this->call('$Core.processForm(\'#js_pages_vanity_url_button\', true);');
	}
	
	public function signup()
	{
		Phpfox::isUser(true);
		if (Phpfox::getService('pages.process')->register($this->get('page_id')))
		{
			$this->alert(Phpfox::getPhrase('pages.successfully_registered_for_this_page'));
		}
	}
	
	public function moderation()
	{
		Phpfox::isUser(true);
		if (Phpfox::getService('pages.process')->moderation($this->get('item_moderate'), $this->get('action')))
		{
			foreach ((array) $this->get('item_moderate') as $iId)
			{
				$this->remove('#js_pages_user_entry_' . $iId);	
			}
			
			$this->updateCount();
			
			$this->alert(Phpfox::getPhrase('pages.successfully_moderated_user_s'), Phpfox::getPhrase('pages.moderation'), 300, 150, true);
		}		
		
		$this->hide('.moderation_process');			
	}	
	
	public function logBackUser()
	{
		$this->error(false);
		Phpfox::isUser(true);
		$aUser = Phpfox::getService('pages')->getLastLogin();
		list ($bPass, $aReturn) = Phpfox::getService('user.auth')->login($aUser['email'], $this->get('password'), true, $sType = 'email');
		if ($bPass)			
		{
			Phpfox::getService('pages.process')->clearLogin($aUser['user_id']);
			
			$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('') . '\';');
		}
		else
		{
			$this->html('#js_error_pages_login_user', '<div class="error_message">' . implode('<br />', Phpfox_Error::get()) . '</div>');
		}		
	}
	
	public function logBackIn()
	{
		// Phpfox::isUser(true);
		
		if (($aUser = Phpfox::getService('pages')->getLastLogin()))
		{		
			if (isset($aUser['fb_user_id']) && $aUser['fb_user_id'])
			{
				$bPass = true;
				Phpfox::getService('pages.process')->clearLogin($aUser['user_id']);
				Phpfox::getService('user.auth')->logout();
			}
			else
			{
				if (Phpfox::getParam('core.auth_user_via_session'))
				{
					Phpfox::getLib('database')->delete(Phpfox::getT('session'), 'user_id = ' . (int) Phpfox::getUserId());
				}
				list ($bPass, $aReturn) = Phpfox::getService('user.auth')->login($aUser['email'], $aUser['password'], true, 'email', true);
				if ($bPass)			
				{
					Phpfox::getService('pages.process')->clearLogin($aUser['user_id']);
				}
			}			
		}
		
		$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('') . '\';');
		// $this->setTitle('Login');
		// Phpfox::getBlock('pages.login-user');		
	}
	
	public function login()
	{
		Phpfox::isUser(true);
		$this->setTitle(Phpfox::getPhrase('pages.login_as_a_page'));
		Phpfox::getBlock('pages.login');
	}
	
	public function loginSearch()
	{
        // Parameters to be sent to the block
        $aParams = array(
            'page' => $this->get('page'),
        );
		
		// Call the block and send the parameters
		Phpfox::getBlock('pages.login', $aParams);
		
		// Display the block into the TB box
        $this->call('$(\'.js_box_content\').html(\'' . $this->getContent() . '\');');
 
	}
	
	public function processLogin()
	{
		if (Phpfox::getService('pages.process')->login($this->get('page_id')))
		{
			$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('') . '\';');
		}
	}
	
	public function pageModeration()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('pages.can_moderate_pages', true);
		
		switch ($this->get('action'))
		{
			case 'approve':
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('pages.process')->approve($iId);
					$this->remove('#js_pages_' . $iId);					
				}								
				$sMessage = Phpfox::getPhrase('pages.pages_s_successfully_approved');
				break;			
			case 'delete':
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('pages.process')->delete($iId);
					$this->slideUp('#js_pages_' . $iId);
				}				
				$sMessage = Phpfox::getPhrase('pages.pages_s_successfully_deleted');
				break;
		}
		
		$this->updateCount();
		
		$this->alert($sMessage, Phpfox::getPhrase('pages.moderation'), 300, 150, true);
		$this->hide('.moderation_process');					
	}
	
	public function approve()
	{
		if (Phpfox::getService('pages.process')->approve($this->get('page_id')))
		{
			$this->alert(Phpfox::getPhrase('pages.page_has_been_approved'), Phpfox::getPhrase('pages.page_approved'), 300, 100, true);
			$this->hide('#js_item_bar_approve_image');
			$this->hide('.js_moderation_off'); 
			$this->show('.js_moderation_on');
		}
	}	
	
	public function updateActivity()
	{
		if (Phpfox::getService('pages.process')->updateActivity($this->get('id'), $this->get('active'), $this->get('sub')))
		{

		}
	}	
	
	public function categoryOrdering()
	{
		$aVals = $this->get('val');
		Phpfox::getService('core.process')->updateOrdering(array(
				'table' => 'pages_type',
				'key' => 'type_id',
				'values' => $aVals['ordering']
			)
		);		
		
		Phpfox::getLib('cache')->remove('pages', 'substr');
	}	
	
	public function categorySubOrdering()
	{
		$aVals = $this->get('val');
		Phpfox::getService('core.process')->updateOrdering(array(
				'table' => 'pages_category',
				'key' => 'category_id',
				'values' => $aVals['ordering']
			)
		);		
		
		Phpfox::getLib('cache')->remove('pages', 'substr');
	}	

	public function approveClaim()
	{
		if (Phpfox::getService('pages.process')->approveClaim($this->get('claim_id')))
		{
			$this->hide('#claim_' . $this->get('claim_id'));
		}
		else
		{
			$this->alert('An error occured');
		}
	}
	
	public function denyClaim()
	{
		if (Phpfox::getService('pages.process')->denyClaim($this->get('claim_id')))
		{
			$this->hide('#claim_' . $this->get('claim_id'));
		}
		else
		{
			$this->alert('An error occured');
		}
	}
	
	public function setCoverPhoto()
	{
		$iPageId = $this->get('page_id');
		$iPhotoId = $this->get('photo_id');
		
		if (Phpfox::getService('pages.process')->setCoverPhoto($iPageId , $iPhotoId))
		{
			$this->call('window.location.href = "' . Phpfox::permalink('pages', $this->get('page_id'), '') . 'coverupdate_1";');
			
		}
		else
		{
			$aErr = Phpfox_Error::get();
			$sErr = implode($aErr);
		}
	}
	
	public function updateCoverPosition()
	{
		if (Phpfox::getService('pages.process')->updateCoverPosition($this->get('page_id'), $this->get('position')))
		{
			$this->call('window.location.href = "' . Phpfox::permalink('pages', $this->get('page_id'), '') . '";');
			//$this->call('location.reload();');
			Phpfox::addMessage(Phpfox::getPhrase('pages.position_set_correctly'));
		}
		else
		{
			$aErr = Phpfox_Error::get();
			$sErr = implode($aErr);
		}
	}
	
	public function removeCoverPhoto()
	{
		if (Phpfox::getService('pages.process')->removeCoverPhoto($this->get('page_id')))
		{
			$this->call('window.location.href=window.location.href;');
		}
		else
		{
			$aErr = Phpfox_Error::get();
			$sErr = implode($aErr);
		}
	}
}

?>
