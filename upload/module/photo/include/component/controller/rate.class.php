<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Rate public photos controller.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox_Component
 * @version 		$Id: rate.class.php 2633 2011-05-30 13:57:44Z Raymond_Benc $
 */
class Photo_Component_Controller_Rate extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('photo.can_view_photos', true);
		
		if (!Phpfox::getParam('photo.can_rate_on_photos'))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('photo.photo_rating_is_disabled'));
		}
		
		Phpfox::getUserParam('photo.can_rate_on_photos', true);
		
		if (($iPhotoId = $this->request()->getInt('photo-id')))
		{
			Phpfox::getService('photo.rate.process')->add($this->request()->getInt('photo-id'), $this->request()->getInt('rating'));			
		}
		
		$sCategory = null;		
		if ($this->request()->get('req3') == 'category')
		{
			$sCategory = $this->request()->getInt('req4');
		}
		
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_rate_process_start')) ? eval($sPlugin) : false);
		
		$aPhoto = Phpfox::getService('photo.rate')->getForRating($sCategory, $this->request()->get('id', null));		
	
		$sBar = '';
		for ($i = 1; $i <= 10; $i++)
		{			
			$sBar .= '<li><a href="' . ($sCategory === null ? $this->url()->makeUrl('photo.rate', array('photo-id' => $aPhoto['photo_id'], 'rating' => $i)) : $this->url()->permalink('photo.rate.category', $this->request()->getInt('req4'), $this->request()->get('req5'), false, null, array('photo-id' => $aPhoto['photo_id'], 'rating' => $i))) . '" class="js_rating_bar">' . $i . '</a></li>';
		}
		$sBar .= '<li><a href="' . ($sCategory === null ? $this->url()->makeUrl('photo.rate') : $this->url()->permalink('photo.rate.category', $this->request()->getInt('req4'), $this->request()->get('req5'))) . '">' . Phpfox::getPhrase('photo.skip') . '</a></li>';
		
		$this->setParam('sPhotoCategorySubSystem', 'rate');
		$this->setParam('aPhoto', $aPhoto);
		$this->setParam('sCurrentCategory', $sCategory);
		
		Phpfox::getService('photo')->buildMenu();
		
		$this->template()->setTitle(Phpfox::getPhrase('photo.rate_photos'))
				->setBreadcrumb(Phpfox::getPhrase('photo.photos'), $this->url()->makeUrl('photo'))
				// ->setBreadcrumb(Phpfox::getPhrase('photo.rate'), $this->url()->makeUrl('photo.rate'), true)			
				->setHeader('cache', array(		
						'rate_bar.css' => 'style_css'											
					)
			)			
			->assign(array(
				'sRatingBar' => $sBar,
				'aPhoto' => $aPhoto,
				'aCallback' => null
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_rate_process_end')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_rate_clean')) ? eval($sPlugin) : false);
	}
}

?>