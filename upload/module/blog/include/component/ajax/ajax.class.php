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
 * @package  		Module_Blog
 * @version 		$Id: ajax.class.php 3642 2011-12-02 10:01:15Z Miguel_Espinoza $
 */
class Blog_Component_Ajax_Ajax extends Phpfox_Ajax
{	
	public function addCategory()
	{
		if (!Phpfox::getService('blog.category')->canAdd())
		{
			return $this->alert(Phpfox::getPhrase('blog.you_have_reached_your_limit'));
		}
		
		$aVals = $this->get('val');
		$oBlogCategoryProcess = Phpfox::getService('blog.category.process');
		$sCleanUrl = Phpfox::getLib('parse.input')->clean($aVals['add']);
		
		if (Phpfox::getService('blog.category')->isPrivateCategory($sCleanUrl, Phpfox::getUserId()))
		{
			$this->call('alert("' . Phpfox::getPhrase('blog.already_a_category') . '"); $("#js_add_category").val(""); $("#js_add_category").focus();');
			return false;
		}
		
		$aCategories = explode(',', $aVals['add']);
		$aRows = array();
		foreach ($aCategories as $sCategory)
		{
			$sCategory = trim($sCategory);
			$iId = $oBlogCategoryProcess->add($sCategory);
			$aRows[] = array(
				'category_id' => $iId,
				'name' => Phpfox::getLib('parse.input')->clean($sCategory, 255)
			);
		}
		
		rsort($aRows);
		
		foreach ($aRows as $aRow)
		{
			Phpfox::getLib('template')->assign(array(
			'aItem' => array(
				'category_id' => $aRow['category_id'],
				'name' => $aRow['name'],
				'user_id' => Phpfox::getUserId()
			)));
			Phpfox::getLib('template')->getTemplate('blog.block.category-form');			
		}		

		$this->call('$("#js_add_new_category").prepend("' . $this->getContent() . '").highlightFade(); $("#js_category_info").html("' . Phpfox::getPhrase('blog.added') . '").highlightFade().fadeOut(5000); $("#js_add_category").val(""); $Core.loadInit();');
	}
	
	public function displayCategories()
	{
		Phpfox::getBlock('blog.add-category-list', array('sType' => $this->get('sType')));		

		$this->call('$("#js_category_content").html("' . $this->getContent() . '");')->call('$Core.loadInit();');	
	}
	
	public function preview()
	{
		Phpfox::getBlock('blog.preview', array('sText' => $this->get('text')));
	}
	
	public function updateTitle()
	{
		if (Phpfox::getLib('parse.format')->isEmpty($this->get('quick_edit_input')))
		{
			$this->alert(Phpfox::getPhrase('blog.add_a_title'));
			
			return false;	
		}		
		
		if (Phpfox::getService('blog.process')->updateBlogTitle($this->get('blog_id'), $this->get('quick_edit_input')))
		{			
			$this->html('#' . $this->get('id'), '<a href="' . Phpfox::getLib('url')->makeUrl('blog', array($this->get('old_title'))) . '" id="js_blog_edit_inner_title' . $this->get('blog_id') . '">' . Phpfox::getLib('parse.output')->clean(Phpfox::getLib('parse.input')->clean($this->get('quick_edit_input'))) . '</a>', '.highlightFade()');
		}
	}
	
	public function updatePermaLink()
	{
		if (Phpfox::getService('blog.process')->updatePermaLink($this->get('blog_id'), $this->get('quick_edit_input')))
		{
			// Send the user to their new blog
			$sTitle = Phpfox::getService('blog')->prepareTitle($this->get('quick_edit_input'));
			
			if (Phpfox::getParam('core.is_personal_site'))
			{
				$sPermalink = Phpfox::getLib('url')->makeUrl('blog', $sTitle);
			}
			else 
			{
				$sPermalink = Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name'), array('blog', $sTitle));
			}			
			$sPermalink = preg_replace("/\/{$sTitle}\//i", "/<a href=\"#?type=input&amp;id=js_blog_edit_title&amp;content=js_blog_edit_inner_title&amp;call=blog.updatePermaLink&amp;blog_id=" . $this->get('blog_id') . "\" class=\"quickEdit\" title=\"" . Phpfox::getPhrase('blog.click_edit_permalink') . "\">{$sTitle}</a>/", $sPermalink);
			
			$this->html('#' . $this->get('id'), $sPermalink, '.highlightFade()')
				->html('#js_blog_edit_inner_title', $sTitle)
				->call('$Core.loadInit();');
		}
	}
	
	public function addUrl()
	{
		$sTitle = Phpfox::getService('blog')->prepareTitle($this->get('title'));
		if (Phpfox::getParam('core.is_personal_site'))
		{
			$sPermalink = Phpfox::getLib('url')->makeUrl('blog', $sTitle);
		}
		else 
		{
			$sPermalink = Phpfox::getLib('url')->makeUrl(Phpfox::getUserBy('user_name'), array('blog', $sTitle));
		}		
		$this->call("$('#js_permalink').html('" . Phpfox::getPhrase('blog.permalink') . ": {$sPermalink}').show();");
	}
	
	public function updateText()
	{
		$sTxt = $this->get('quick_edit_input');
		
		if (Phpfox::getLib('parse.format')->isEmpty($sTxt))
		{
			$this->alert(Phpfox::getPhrase('blog.add_some_text'));
			
			return false;	
		}		
		
		if (Phpfox::getService('blog.process')->updateBlogText($this->get('blog_id'), $sTxt))
		{
			if (Phpfox::getParam('core.allow_html'))
			{				
				$sTxt = Phpfox::getLib('parse.output')->parse(Phpfox::getLib('parse.input')->prepare($sTxt));
			}
			else 
			{
				$sTxt = Phpfox::getLib('parse.output')->parse($sTxt);
			}
			
			$this->html('#' . $this->get('id'), $sTxt, '.highlightFade()');
		}
	}

	public function inlineDelete()
	{
		if (Phpfox::getService('blog.process')->deleteInline($this->get('item_id')))
		{
			$this->call("$('#js_blog_entry" . $this->get('item_id') . "').hide('slow'); $('#core_js_messages').message('" . Phpfox::getPhrase('blog.blog_deleted', array('phpfox_squote' => true)) . "', 'valid').fadeOut(5000);");
		}
	}
	
	public function addPassword()
	{
		if (Phpfox::getUserParam('blog.can_view_password_protected_blog'))
		{
			if (($mText = Phpfox::getService('blog')->verifyPassword($this->get('blog_id'), $this->get('blog_password'))))
			{
				$this->html('#js_blog_edit_text' . $this->get('blog_id'), $mText);
			}
			else 
			{
				$this->call("alert('" . Phpfox::getPhrase('blog.password_invalid', array('phpfox_squote' => true)) . "');");
			}
		}
		else 
		{
			$this->call("alert('" . Phpfox::getPhrase('blog.unable_view_password_protected_blogs', array('phpfox_squote' => true)) . "');");
		}
	}
	
	public function getText()
	{
		$aRow = Phpfox::getService('blog')->getBlogForEdit($this->get('blog_id'));
		
		(($sPlugin = Phpfox_Plugin::get('blog.component_ajax_get_text')) ? eval($sPlugin) : false);
		
		if (!isset($bHasPluginCall))
		{
			$this->call("$('#js_quick_edit_id" . $this->get('id') . "').html('<div><div id=\"sJsEditorMenu\" class=\"editor_menu\" style=\"display:block;\">' + Editor.setId('js_quick_edit" . $this->get('id') . "').getEditor(true) + '</div><textarea style=\"width:98%;\" name=\"quick_edit_input\" cols=\"90\" rows=\"10\" id=\"js_quick_edit" . $this->get('id') . "\">" . Phpfox::getLib('parse.output')->ajax($aRow['text']) . "</textarea></div>');");
		}
	}
	
	public function deleteCategory()
	{
		if (Phpfox::getService('blog.category')->delete($this->get('id')))
		{
			$this->call('$("#js_category_label' . $this->get('id') . '").hide();');
		}
	}
	
	public function updateCategory()
	{
		$sCategory = Phpfox::getService('blog.category.process')->update($this->get('category_id'), $this->get('quick_edit_input'), $this->get('user_id'));
		
		$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('admincp.blog') . '\'');
	}
	
	public function getNew()
	{
		Phpfox::getBlock('blog.new');
		
		$this->html('#' . $this->get('id'), $this->getContent(false));
		$this->call('$(\'#' . $this->get('id') . '\').parents(\'.block:first\').find(\'.bottom li a\').attr(\'href\', \'' . Phpfox::getLib('url')->makeUrl('blog') . '\');');
	}

	public function quickSubmit()
	{
		$sId = $this->get('id');
		$sText = $this->get('sText');

		// get the id from the sId variable
		$iId = preg_replace('/[^0-9]/', '', $sId);

		// Only update if text is not empty
		Phpfox::getService('blog.process')->updateBlogText($iId, $sText);
		$this->call('window.location.href="' . $this->get('sUrl') . '";');
		
	}
	
	public function approve()
	{
		if (Phpfox::getService('blog.process')->approve($this->get('id')))
		{
			if ($this->get('inline'))
			{
				$this->alert(Phpfox::getPhrase('blog.blog_has_been_approved'), Phpfox::getPhrase('blog.blog_approved'), 300, 100, true);
				$this->hide('#js_item_bar_approve_image');
				$this->hide('.js_moderation_off'); 
				$this->show('.js_moderation_on');				
			}			
		}
	}
	
	public function viewMore()
	{
		Phpfox::getComponent('blog.index', array(), 'controller');
		
		$this->remove('.js_pager_view_more_link');
		$this->append('#js_pager_view_more_holder', $this->getContent(false));
		$this->call('$Core.loadInit();');
	}
	
	public function addViaStatusUpdate()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('blog.add_new_blog', true);
		
		$aVals = $this->get('val');
		$aVals['title'] = $aVals['blog_title'];
		$aVals['text'] = $aVals['status_info'];
		
		if (Phpfox::getLib('parse.format')->isEmpty($aVals['text']))
		{
			$this->call('$Core.resetActivityFeedError(\''.Phpfox::getPhrase('blog.please_provide_some_text_for_your_blog').'\');');
		}
		else
		{
			if (($iBlogId = Phpfox::getService('blog.process')->add($aVals)))
			{
				$iId = Phpfox::getService('feed.process')->getLastId();

				(($sPlugin = Phpfox_Plugin::get('blog.component_ajax_addviastatusupdate')) ? eval($sPlugin) : false);

				Phpfox::getService('feed')->processAjax($iId);
			}
		}
	}

	public function moderation()
	{
		Phpfox::isUser(true);
		
		switch ($this->get('action'))
		{
			case 'approve':
				Phpfox::getUserParam('blog.can_approve_blogs', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('blog.process')->approve($iId);
					$this->remove('#js_blog_entry' . $iId);					
				}				
				$this->updateCount();
				$sMessage = Phpfox::getPhrase('blog.blog_s_successfully_approved');
				break;			
			case 'delete':
				Phpfox::getUserParam('blog.delete_user_blog', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('blog.process')->delete($iId);
					$this->slideUp('#js_blog_entry' . $iId);
				}				
				$sMessage = Phpfox::getPhrase('blog.blog_s_successfully_deleted');
				break;
		}
		
		$this->alert($sMessage, 'Moderation', 300, 150, true);
		$this->hide('.moderation_process');			
	}
}

?>