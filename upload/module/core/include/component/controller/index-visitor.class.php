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
 * @version 		$Id: index-visitor.class.php 6754 2013-10-09 10:17:09Z Miguel_Espinoza $
 */
class Core_Component_Controller_Index_Visitor extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
	    if ($sPlugin = Phpfox_Plugin::get('core.component_controller_index_visitor_start'))
	    {
			eval($sPlugin);
	    }		
		
		$this->template()->setHeader('cache', array(
					'jquery/plugin/jquery.bt.js' => 'static_script',
					'register.js' => 'module_user',
					'country.js' => 'module_core',
					'comment.css' => 'style_css'
				)
			)
			->setPhrase(array(
					'user.continue'
				)
			)			
			->setHeader('head',array(				
				"<!--[if IE ]>\n\t\t\t<script type=\"text/javascript\" src=\"" . Phpfox::getParam('core.url_static_script') . "jquery/plugin/excanvas.js\"></script>\n\t<![endif]-->",				
			)
		)->assign(array(
				'aSettings' => Phpfox::getService('custom')->getForEdit(array('user_main', 'user_panel', 'profile_panel'), null, null, true)
			)
		);	
	}
}

?>