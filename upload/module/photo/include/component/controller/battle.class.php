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
 * @version 		$Id: battle.class.php 3626 2011-12-01 06:07:55Z Raymond_Benc $
 */
class Photo_Component_Controller_Battle extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('photo.can_view_photos', true);	
		Phpfox::getParam('photo.enable_photo_battle', true);
		
		if (($iWinner = $this->request()->getInt('w')) && ($iLoser = $this->request()->getInt('l')))
		{
			Phpfox::getService('photo.battle.process')->add($iWinner, $iLoser);
		}
		
		$sCategory = null;		
		if ($this->request()->get('req3') == 'category')
		{
			$sCategory = $this->request()->getInt('req4');
		}	
		
		$bFullMode = ($this->request()->get('mode') == 'full' ? true : false);
		$this->setParam('sPhotoCategorySubSystem', 'battle');
		$this->setParam('sCurrentCategory', $sCategory);
		
		$aPhotos = Phpfox::getService('photo.battle')->get($sCategory);
		
		Phpfox::getService('photo')->buildMenu();
		
		$this->template()->setTitle(Phpfox::getPhrase('photo.photo_battle'))
			->setBreadcrumb(Phpfox::getPhrase('photo.photos'), $this->url()->makeUrl('photo'))			
			->assign(array(
					'aPhotos' => $aPhotos,
					'bFullMode' => $bFullMode,
					'sImageHeight' => ($bFullMode ? '500' : '240'),
					'sMaxImageHeight' => ($bFullMode ? '400' : '240'),
					'aCallback' => null
				)
			)
			->setHeader('cache', array(
					'battle.css' => 'module_photo'
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_battle_clean')) ? eval($sPlugin) : false);
	}
}

?>