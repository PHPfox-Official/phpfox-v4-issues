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
	 * Controller
	 */
	public function process()
	{
	    if ($sPlugin = Phpfox_Plugin::get('core.component_controller_index_visitor_start'))
	    {
			eval($sPlugin);
	    }

		$photo = [];
		list($total, $featured) = Photo_Service_Photo::instance()->getFeatured();
		if (is_array($featured) && isset($featured[0])) {
			$photo = $featured[0];
		}

		$this->template()->setHeader('cache', array(
					'register.js' => 'module_user',
					'country.js' => 'module_core',
					'comment.css' => 'style_css'
				)
			)
			->setPhrase(array(
					'user.continue'
				)
			)->assign(array(
				'aSettings' => Phpfox::getService('custom')->getForEdit(array('user_main', 'user_panel', 'profile_panel'), null, null, true),
					'featured' => $photo
			)
		);	
	}
}

?>