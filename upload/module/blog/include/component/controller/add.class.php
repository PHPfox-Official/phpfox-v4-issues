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
 * @version 		$Id: add.class.php 6313 2013-07-19 07:12:03Z Raymond_Benc $
 */
class Blog_Component_Controller_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		$bIsEdit = false;
		$bCanEditPersonalData = true;
		
		$sModule = $this->request()->get('module');
		$iItemId = $this->request()->getInt('item');
		if (($aVals = $this->request()->getArray('val')) && !empty($aVals['module_id']) && !empty($aVals['item_id']))
		{
			$sModule = $aVals['module_id'];
			$iItemId = $aVals['item_id'];
		}
		if (!empty($sModule) && !empty($iItemId))
		{
			$this->template()->assign(array(
				'sModule' => $sModule,
				'iItem' => $iItemId
			));
		}
		
		if (($iEditId = $this->request()->getInt('id')))
		{	
			$oBlog = Phpfox::getService('blog');
			
			$aRow = $oBlog->getBlogForEdit($iEditId);
			
			if ($aRow['is_approved'] != '1' && 
				($aRow['user_id'] != Phpfox::getUserId() && !Phpfox::getUserParam('blog.edit_user_blog')) )
			{
				return Phpfox_Error::display(Phpfox::getPhrase('blog.unable_to_edit_this_blog'));
			}
			
			if (Phpfox::isModule('tag'))
			{
				$aTags = Phpfox::getService('tag')->getTagsById('blog', $aRow['blog_id']);
				if (isset($aTags[$aRow['blog_id']]))
				{
					$aRow['tag_list'] = '';					
					foreach ($aTags[$aRow['blog_id']] as $aTag)
					{
						$aRow['tag_list'] .= ' ' . $aTag['tag_text'] . ',';	
					}
					$aRow['tag_list'] = trim(trim($aRow['tag_list'], ','));
				}
			}

			(Phpfox::getUserId() == $aRow['user_id'] ? Phpfox::getUserParam('blog.edit_own_blog', true) : Phpfox::getUserParam('blog.edit_user_blog', true));
			if (Phpfox::getUserParam('blog.edit_user_blog') && Phpfox::getUserId() != $aRow['user_id'])
			{
				$bCanEditPersonalData = false;
			}
			
			$aCategories = Phpfox::getService('blog.category')->getCategoriesById($aRow['blog_id']);
			$sCategories = '';
			if (isset($aCategories[$aRow['blog_id']]))
			{
				foreach ($aCategories[$aRow['blog_id']] as $aCategory)
				{
					$sCategories .= $aCategory['category_id'] . ',';	
				}
			}			
			$aRow['selected_categories'] = $sCategories;							
					
			$bIsEdit = true;			
			$this->template()->assign(array(
					'aForms' => $aRow					
				)
			);
			
			if (!empty($aRow['module_id']))
			{
				$sModule = $aRow['module_id'];
				$iItemId = $aRow['item_id'];
			}

			(($sPlugin = Phpfox_Plugin::get('blog.component_controller_add_process_edit')) ? eval($sPlugin) : false);
		}
		else 
		{
			Phpfox::getUserParam('blog.add_new_blog', true);
		}
		
		$aValidation = array(
			'title' => array(
				'def' => 'required',
				'title' => Phpfox::getPhrase('blog.fill_title_for_blog')
			),
			'text' => array(
				'def' => 'required',
				'title' => Phpfox::getPhrase('blog.add_content_to_blog')
			)		
		);
		
		if (Phpfox::isModule('captcha') && Phpfox::getUserParam('captcha.captcha_on_blog_add'))
		{
			$aValidation['image_verification'] = Phpfox::getPhrase('captcha.complete_captcha_challenge');
		}		
		
		(($sPlugin = Phpfox_Plugin::get('blog.component_controller_add_process_validation')) ? eval($sPlugin) : false);

		$oValid = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'core_js_blog_form', 
				'aParams' => $aValidation
			)
		);

		if (!empty($sModule) && Phpfox::hasCallback($sModule, 'getItem'))
		{
			$aCallback = Phpfox::callback($sModule . '.getItem' , $iItemId);
			$sUrl = $sCrumb = '';
				
			if ($bIsEdit)
			{
				$sUrl = $this->url()->makeUrl('blog', array('add', 'id' => $iEditId));
				$sCrumb = Phpfox::getPhrase('blog.editing_blog') . ': ' . Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getService('core')->getEditTitleSize(), '...');
			}
			else
			{
				$sUrl = $this->url()->makeUrl('blog', array('add', 'module' => $aCallback['module'], 'item' => $iItemId));
				$sCrumb = Phpfox::getPhrase('blog.adding_a_new_blog');
			}
			
			$this->template()
			->setBreadcrumb(Phpfox::getPhrase($sModule .'.'.$sModule), $this->url()->makeUrl($sModule))
			->setBreadCrumb($aCallback['title'], Phpfox::permalink($sModule, $iItemId))
			->setBreadCrumb(Phpfox::getPhrase('blog.blogs'), $this->url()->makeUrl('pages', array($iItemId, 'blog')))
			->setBreadcrumb($sCrumb, $sUrl, true)
			;
		}
		else
		{
			$this->template()
			->setBreadcrumb(Phpfox::getPhrase('blog.blogs'), $this->url()->makeUrl('blog'))
			->setBreadcrumb((!empty($iEditId) ? Phpfox::getPhrase('blog.editing_blog') . ': ' . Phpfox::getLib('parse.output')->shorten($aRow['title'], Phpfox::getService('core')->getEditTitleSize(), '...') : Phpfox::getPhrase('blog.adding_a_new_blog')), ($iEditId > 0 ? $this->url()->makeUrl('blog', array('add', 'id' => $iEditId)) : $this->url()->makeUrl('blog', array('add'))), true);
		
		}		

		if ($aVals = $this->request()->getArray('val'))
		{		
			if ($oValid->isValid($aVals))
			{					
				// Add the new blog
				if (isset($aVals['publish']) || isset($aVals['draft']))
				{
					if (isset($aVals['draft']))
					{
						$aVals['post_status'] = 2;
						$sMessage = Phpfox::getPhrase('blog.blog_successfully_saved');
					}
					else 
					{
						$sMessage = Phpfox::getPhrase('blog.your_blog_has_been_added');
					}
					
					if (($iFlood = Phpfox::getUserParam('blog.flood_control_blog')) !== 0)
					{
						$aFlood = array(
							'action' => 'last_post', // The SPAM action
							'params' => array(
								'field' => 'time_stamp', // The time stamp field
								'table' => Phpfox::getT('blog'), // Database table we plan to check
								'condition' => 'user_id = ' . Phpfox::getUserId(), // Database WHERE query
								'time_stamp' => $iFlood * 60 // Seconds);	
							)
						);
							 			
						// actually check if flooding
						if (Phpfox::getLib('spam')->check($aFlood))
						{
							Phpfox_Error::set(Phpfox::getPhrase('blog.your_are_posting_a_little_too_soon') . ' ' . Phpfox::getLib('spam')->getWaitTime());	
						}
					}					
					
					if (Phpfox_Error::isPassed())
					{
						$iId = Phpfox::getService('blog.process')->add($aVals);										
					}
				}
				
				// Update a blog
				if ((isset($aVals['update']) || isset($aVals['draft_update']) || isset($aVals['draft_publish'])) && isset($aRow['blog_id']) && $bIsEdit)
				{
					if (isset($aVals['draft_publish']))
					{
						$aVals['post_status'] = 1;	
					}
					
					// Update the blog
					$iId = Phpfox::getService('blog.process')->update($aRow['blog_id'], $aRow['user_id'], $aVals, $aRow);										
					$sMessage = Phpfox::getPhrase('blog.blog_updated');													
				}				
				
				if (isset($iId) && $iId)
				{		
					Phpfox::permalink('blog', $iId, $aVals['title'], true, $sMessage);
				}
			}
		}
		
		$this->template()
			->setTitle((!empty($iEditId) ? Phpfox::getPhrase('blog.editing_blog') . ': ' . $aRow['title'] : Phpfox::getPhrase('blog.adding_a_new_blog')))			
			->setFullSite()	
			->assign(array(
					'sCreateJs' => $oValid->createJS(),
					'sGetJsForm' => $oValid->getJsForm(),
					'bIsEdit' => $bIsEdit,
					'bCanEditPersonalData' => $bCanEditPersonalData
				)
			)
			->setEditor(array('wysiwyg' => Phpfox::getUserParam('blog.can_use_editor_on_blog')))
			->setHeader('cache', array(
				'jquery/plugin/jquery.highlightFade.js' => 'static_script',
				'switch_legend.js' => 'static_script',
				'switch_menu.js' => 'static_script',
				'quick_edit.js' => 'static_script',
				'pager.css' => 'style_css'
			)
		);	
		
		if (Phpfox::isModule('attachment') && Phpfox::getUserParam('attachment.can_attach_on_blog'))
		{
			$this->setParam('attachment_share', array(
					'type' => 'blog',
					'id' => 'core_js_blog_form',
					'edit_id' => ($bIsEdit ? $iEditId : 0)
				)
			);
		}
			
		(($sPlugin = Phpfox_Plugin::get('blog.component_controller_add_process')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_controller_add_clean')) ? eval($sPlugin) : false);
	}
}

?>
