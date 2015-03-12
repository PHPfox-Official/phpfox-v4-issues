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
 * @package  		Module_Core
 * @version 		$Id: index-member.class.php 5908 2013-05-13 07:28:31Z Raymond_Benc $
 */
class Core_Component_Controller_Index_Member extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		
		if ($sPlugin = Phpfox_Plugin::get('core.component_controller_index_member_start'))
		{
		    eval($sPlugin);
		}
		Phpfox::isUser(true);
		
		if ($this->request()->get('req3') == 'customize')
		{				
				define('PHPFOX_IN_DESIGN_MODE', true);
				define('PHPFOX_CAN_MOVE_BLOCKS', true);	
				
				if (($iTestStyle = $this->request()->get('test_style_id')))
				{
					if (Phpfox::getLib('template')->testStyle($iTestStyle))
					{
						
					}
				}
				
				$aDesigner = array(
					'current_style_id' => Phpfox::getUserBy('style_id'),
					'design_header' => Phpfox::getPhrase('core.customize_dashboard'),
					'current_page' => $this->url()->makeUrl(''),
					'design_page' => $this->url()->makeUrl('core.index-member', 'customize'),
					'block' => 'core.index-member',				
					'item_id' => Phpfox::getUserId(),
					'type_id' => 'user'
				);
				
				$this->setParam('aDesigner', $aDesigner);	
				
				$this->template()->setPhrase(array(
								'theme.are_you_sure'
							)
						)
						->setHeader('cache', array(
								'style.css' => 'style_css',
								'video.css' => 'module_video',
								'design.js' => 'module_theme',
								'select.js' => 'module_theme'
							)
						);				
				
				if (Phpfox::getParam('profile.can_drag_drop_blocks_on_profile'))
				{
					$this->template()							
							->setHeader('cache', array(
									'jquery/ui.js' => 'static_script',
									'sort.js' => 'module_theme'																
								)
							)
							->setHeader(array(												
								'<script type="text/javascript">$Behavior.core_controller_member_designonupdate = function() { function designOnUpdate() { $Core.design.updateSorting(); } };</script>',
								'<script type="text/javascript">$Behavior.core_controller_init = function() { $Core.design.init({type_id: \'user\'}); };</script>'
							)					
					);						
				}
		}
		else 
		{
			// $this->template()->setHeader('jquery/ui.js', 'static_script');
			$this->template()->setHeader('cache', array(						
						'sort.js' => 'module_theme',
						'design.js' => 'module_theme',
						'video.css' => 'module_video'
					)
				)
				->setHeader(array(	
					// '<script type="text/javascript">function designOnUpdate() { $Core.design.updateSorting(); }</script>',
					// '<script type="text/javascript">$Core.design.init({type_id: \'user\'});</script>'
				)
			);
		}

		if (Phpfox::getParam('video.convert_servers_enable'))
		{
			$this->template()->setHeader('<script type="text/javascript">document.domain = "' . Phpfox::getParam('video.convert_js_parent') . '";</script>');
		}
		
		Phpfox::getLib('module')->setCacheBlockData(array(
				'table' => 'user_dashboard',
				'field' => 'user_id',
				'item_id' => Phpfox::getUserId(),
				'controller' => 'core.index-member'
			)
		);
		
		$this->template()->setHeader('cache', array(
					'feed.js' => 'module_feed',
					'welcome.css' => 'style_css',
					'announcement.css' => 'style_css',
					'comment.css' => 'style_css',
					'quick_edit.js' => 'static_script',
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',
					'jquery/plugin/jquery.scrollTo.js' => 'static_script',
                    'player/flowplayer/flowplayer.js' => 'static_script'
				)
			)
			->setEditor(array(
					'load' => 'simple'					
			)
		);	
	}
}

?>