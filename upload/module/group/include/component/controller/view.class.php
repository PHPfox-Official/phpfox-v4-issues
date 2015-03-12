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
 * @package 		Phpfox_Component
 * @version 		$Id: view.class.php 2739 2011-07-15 11:19:17Z Miguel_Espinoza $
 */
class Group_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('group.can_access_groups', true);
		
		define('PHPFOX_IS_GROUP_VIEW', true);
		
		$iGroup = $this->request()->get('req2');
		
		if (!($aGroup = Phpfox::getService('group')->getGroup($iGroup)))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('group.the_group_you_are_looking_for_does_not_exist_or_has_been_removed'));
		}
		
		if ($this->request()->get('approve') && Phpfox::getPhrase('group.pending_approval'))
		{
			if (Phpfox::getService('group.process')->approve($aGroup['group_id']))
			{
				$this->url()->send('group', $aGroup['title_url'], Phpfox::getPhrase('group.group_successfully_approved'));
			}
		}
		
		if ($aGroup['is_public'] == '1')
		{
			if (Phpfox::getUserId() != $aGroup['user_id'])
			{
				if (!Phpfox::getUserParam('group.can_approve_groups'))
				{
					return Phpfox_Error::display(Phpfox::getPhrase('group.the_group_you_are_looking_for_does_not_exist_or_has_been_removed'));
				}
			}
		}
		
		if ($this->request()->get('req3') == 'join')
		{
			if (Phpfox::getService('group.process')->joinGroup($aGroup['group_id'], Phpfox::getUserId()))
			{
				$this->url()->send('group', array($aGroup['title_url']), (($aGroup['view_id'] == '1' && $aGroup['auto_approve'] == '0') ? Phpfox::getPhrase('group.thank_you_for_your_request_to_join_our_group_your_membership_will_first_have_to_be_approved') : Phpfox::getPhrase('group.you_have_successfully_joined_this_group')));
			}
		}
		elseif ($this->request()->get('req3') == 'leave')
		{
			if (Phpfox::getService('group.process')->leaveGroup($aGroup['group_id'], Phpfox::getUserId()))
			{
				$this->url()->send('group', array($aGroup['title_url']), Phpfox::getPhrase('group.you_have_successfully_left_this_group'));
			}
		}
		
		Phpfox::getLib('module')->setCacheBlockData(array(
				'table' => 'group_design_order',
				'field' => 'group_id',
				'item_id' => $aGroup['group_id'],
				'controller' => 'group.view'
			)
		);
		
		$this->setParam('aGroup', $aGroup);
		
		if ($aGroup['designer_style_id'])
		{
			$this->template()->setStyle(array(
					'style_id' => $aGroup['designer_style_id'],
					'style_folder_name' => $aGroup['designer_style_folder'],
					'theme_folder_name' => $aGroup['designer_theme_folder']
				)
			);
		}		
		
		$sModule = 'group';
		$aMenus1['group'] = array(
			Phpfox::getPhrase('group.home') => array(
				'active' => 'group', 
				'url' => $this->url()->makeUrl('group', $aGroup['title_url'])
			)
		);		
		$aMenus2 = Phpfox::massCallback('groupMenu', $aGroup['title_url'], $aGroup['group_id']);	
		$aMenus = array_merge($aMenus1, $aMenus2);		
		$aSubMenus = array();
		foreach ($aMenus as $sModule => $aMenu)
		{			
			if ($aMenu === false)
			{
				continue;
			}
			
			$aKey = array_keys($aMenu);
			$aValue = array_values($aMenu);
			$aSubMenus[$aKey[0]] = $aValue[0];			
		}		
		
		$this->template()->setTitle($aGroup['title'])
				->setHeader('cache', array(
						'profile.css' => 'module_group'
					)
				)
				->assign(array(
					'aGroup' => $aGroup,
					'aGroupMenus' => $aSubMenus,
					'sGroupMenuActive' => 'group'
				)
			);	
			
		Phpfox::getLib('module')->addModuleBlock('group.header', 7);
		
		if ($aGroup['view_id'] == '2' && (!$aGroup['invite_id'] || ($aGroup['invite_id'] && $aGroup['member_id'] == '0')) && !Phpfox::getUserParam('group.can_view_secret_group'))
		{
			return Phpfox::getLib('module')->setController('group.secret');
		}				
			
		if (($sModule = $this->request()->get('req3')) && Phpfox::isModule($this->url()->reverseRewrite($sModule)))
		{
			if ($aGroup['view_id'] == '1' && !Phpfox::getUserParam('group.can_view_secret_group') && (!$aGroup['invite_id'] || ($aGroup['invite_id'] && $aGroup['member_id'] == '2')))
			{
				return Phpfox_Error::display(Phpfox::getPhrase('group.this_group_is_open_only_to_its_members'));
			}		
			
			if ($aGroup['is_public'] == '1')
			{		
				return Phpfox_Error::display(Phpfox::getPhrase('group.this_group_is_still_pending_an_admins_approval_and_this_feature_cannot_be_used_yet'));	
			}
			
			$this->setParam('bHideGroupBlocks', true);
			
			$this->template()->assign(array(
					'sGroupMenuActive' => $this->url()->reverseRewrite($sModule)
				)
			);

			return Phpfox::getLib('module')->setController($this->url()->reverseRewrite($sModule) . '.group');
		}		
				
		define('PHPFOX_CAN_MOVE_BLOCKS', true);

		if ($this->request()->get('req3') == 'designer')
		{
			if (($aGroup['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('group.can_edit_own_group')) || Phpfox::getUserParam('group.can_edit_other_group') || Phpfox::getService('group')->isAdmin($aGroup['group_id']))
			{		
				define('PHPFOX_IN_DESIGN_MODE', true);

				if (($iTestStyle = $this->request()->get('test_style_id')))
				{
					if (Phpfox::getLib('template')->testStyle($iTestStyle))
					{
						
					}
				}
				
				$aDesigner = array(
					'current_style_id' => $aGroup['designer_style_id'],
					'design_header' => Phpfox::getPhrase('group.customize_group'),
					'current_page' => $this->url()->makeUrl('group', array($aGroup['title_url'])),
					'design_page' => $this->url()->makeUrl('group', array($aGroup['title_url'], 'designer')),
					'block' => 'group.view',				
					'item_id' => $aGroup['group_id'],
					'type_id' => 'group'
				);
				
				$this->setParam('aDesigner', $aDesigner);	
				
				$this->template()->setHeader('cache', array(
								'jquery/ui.js' => 'static_script',
								'sort.js' => 'module_theme',
								'style.css' => 'style_css',
								'select.js' => 'module_theme',
								'design.js' => 'module_theme'							
							)					
						)
						->setHeader(array(
							'<script type="text/javascript">function designOnUpdate() { $Core.design.updateSorting(); }</script>',		
							'<script type="text/javascript">$Core.design.init({type_id: \'group\', item_id: \'' . $aGroup['group_id'] . '\'});</script>'
						)						
					);			
			}	
		}
		elseif ($this->request()->get('req3') == 'member')
		{
			$this->setParam('aCallback', array(
					'module' => 'group',
					'item' => $aGroup['group_id'],
					'query' => true,
					'url_home' => 'group.' . $aGroup['title_url'] . '.member',
					'url' => array(
						'group',
						array(
							$aGroup['title_url'],
							'member'						
						)
					),
					'no_member_message' => Phpfox::getPhrase('group.no_users_have_joined_this_group')
				)
			);
			
			$this->template()->assign(array(
					'sGroupMenuActive' => 'member'
				)
			);			
			
			return Phpfox::getLib('module')->setController('user.browse');	
		}
		else 
		{
			if (($aGroup['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('group.can_edit_own_group')) || Phpfox::getUserParam('group.can_edit_other_group') || Phpfox::getService('group')->isAdmin($aGroup['group_id']))
			{
				$this->template()->setHeader('cache', array(
							'jquery/ui.js' => 'static_script',
							'sort.js' => 'module_theme',
							'select.js' => 'module_theme',
							'design.js' => 'module_theme'							
						)					
					)
					->setHeader(array(
							'<script type="text/javascript">function designOnUpdate() { $Core.design.updateSorting(); }</script>',		
							'<script type="text/javascript">$Core.design.init({type_id: \'group\', item_id: \'' . $aGroup['group_id'] . '\'});</script>'
						)						
				);			
			}
		}
		
		$this->setParam('aEventParent', array(
				'module' => 'group',
				'item' => $aGroup['group_id'],
				'url' => array(
					'group',
					array(
						$aGroup['title_url'],
						'event'						
					)
				)				
			)
		);
		
		$this->setParam('aCallbackVideo', array(
				'module' => 'group',
				'item' => $aGroup['group_id'],
				'url' => array(
					'group',
					array(
						$aGroup['title_url'],
						'video'						
					)
				)
			)
		);		
		
		$this->setParam('aCallbackShoutbox', array(
				'module' => 'group',
				'item' => $aGroup['group_id']
			)
		);
		
		$this->setParam(array(
				'iItemId' => $aGroup['group_id'],
				'iTotal' => $aGroup['total_comment'],
				'sType' => 'group'
			)
		);
		
		define('PHPFOX_IS_GROUP_INDEX', true);
		
		if (Phpfox::isModule('notification') && $aGroup['user_id'] == Phpfox::getUserId())
		{
			Phpfox::getService('notification.process')->delete('group_notifyLike', $aGroup['group_id'], Phpfox::getUserId());
		}				
		
		Phpfox::getService('feed')->setTable(Phpfox::getT('group_feed'));
		
		$this->template()->assign(array(
					'bFeedIsParentItem' => true,
					'sFeedIsParentItemModule' => 'group'
				)
			)
			->setPhrase(array(
					'theme.are_you_sure'
				)
			)
                        ->setBreadCrumb(Phpfox::getPhrase('group.group_name'), $this->url()->makeUrl('group'))			
		 	->setBreadCrumb($aGroup['title'], $this->url()->permalink('group', $aGroup['group_id'], $aGroup['title']), true)
			->setMeta('description', $aGroup['description'])
			->setMeta('keywords', $this->template()->getKeywords($aGroup['title']))
			->setHeader('cache', array(
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',	
					'jquery/plugin/jquery.scrollTo.js' => 'static_script',
					'quick_edit.js' => 'static_script',
					'comment.css' => 'style_css',
					'pager.css' => 'style_css',
					'switch_legend.js' => 'static_script',
					'switch_menu.js' => 'static_script',
					'feed.js' => 'module_feed'
				)
			)			
			->setHeader(array(
					'<script type="text/javascript">$(function(){$(\'.js_mp_fix_width\').each(function(){$(this).parents(\'.js_mp_fix_holder:first\').width(this.width);});});</script>'
				)
			)
			->setEditor(array(
					'load' => 'simple'
				)
			);			
			
		if ($this->request()->get('update'))
		{
			$this->template()->setHeader('<script type="text/javascript">window.parent.tb_remove();</script>');
		}			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('group.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>