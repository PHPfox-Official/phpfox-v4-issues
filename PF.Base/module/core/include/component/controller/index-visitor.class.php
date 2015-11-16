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

		$image = [];
		list($total, $featured) = Photo_Service_Photo::instance()->getFeatured();
		if (is_array($featured) && isset($featured[0])) {
			$photo = $featured[0];
			$url = Phpfox_Image_Helper::instance()->display([
				'server_id' => $photo['server_id'],
				'path' => 'photo.url_photo',
				'file' => $photo['destination'],
				'suffix' => '_1024',
				'return_url' => true
			]);
			$image = [
				'image' => $url,
				'info' => strip_tags($photo['title']) . ' by ' . $photo['full_name']
			];
		}

		if (!$image) {
			$images = [
				'create-a-community-for-musicians.jpg' => 'Creating communities for Musicians',
				'create-a-community-for-athletes.jpg' => 'Creating communities for Athletes',
				'create-a-community-for-photographers.jpg' => 'Creating communities for Photographers',
				'create-a-social-network-for-fine-cooking.jpg' => 'Creating communities for Fine Cooking'
			];
			$total = rand(1, (count($images)));
			$image = [];
			$cnt = 0;
			foreach ($images as $image => $info) {
				$cnt++;
				$image = [
					'image' => 'http://bg.m9.io/' . $image,
					'info' => $info
				];
				if ($cnt === $total) {
					break;
				}
			}
		}

		$this->template()->setHeader('cache', array(
					'register.js' => 'module_user',
					'country.js' => 'module_core',
				)
			)
			->setBreadCrumb(Phpfox::getParam('core.site_title'))
			->setPhrase(array(
					'user.continue'
				)
			)->assign(array(
				'aSettings' => Phpfox::getService('custom')->getForEdit(array('user_main', 'user_panel', 'profile_panel'), null, null, true),
				// 'featured' => $photo,
					'image' => $image
			)
		);	
	}
}

?>