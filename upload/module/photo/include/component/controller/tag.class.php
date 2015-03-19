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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Photo_Component_Controller_Tag extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		Phpfox::getUserParam('photo.can_view_photos', true);
		
		if ($sTag = $this->request()->get('req3'))
		{			
			return Phpfox_Module::instance()->setController('photo.index');
		}		
		
		$this->template()->setTitle(Phpfox::getPhrase('photo.photo_tags'))
			->setBreadcrumb(Phpfox::getPhrase('photo.photo'), $this->url()->makeUrl('photo'))
			->setBreadcrumb(Phpfox::getPhrase('photo.tags'), $this->url()->makeUrl('photo.tag'), true);		
		
		$this->setParam('iTagDisplayLimit', 75);
		$this->setParam('bNoTagBlock', true);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_tag_clean')) ? eval($sPlugin) : false);
	}
}

?>