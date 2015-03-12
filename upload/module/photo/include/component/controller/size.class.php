<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display all the sizes for a users photo.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: size.class.php 6106 2013-06-21 11:31:52Z Raymond_Benc $
 */
class Photo_Component_Controller_Size extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('photo.can_view_photos', true);
		
		// Make sure this user group can view all photo sizes
		Phpfox::getUserParam('photo.can_view_all_photo_sizes', true);
		
		$aCallback = $this->getParam('aCallback', null);	
		
		$aPhoto = Phpfox::getService('photo')->getPhoto((PHPFOX_IS_AJAX ? $this->request()->getInt('id') : $this->request()->get('req2')));
		
		$iDefaultSize = 500;
		$bIsSet = false;
		$iViewSize = $this->request()->get('size', $iDefaultSize);
		
		$aSizes = array();
		$aCache = array();
		// Loop thru all the photo sizes
		foreach (Phpfox::getParam('photo.photo_pic_sizes') as $iPhotoSize)
		{
			$sPath = Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['original_destination'], '_' . $iPhotoSize);
			// Make sure the photo exists
			if (file_exists($sPath) || defined('PHPFOX_IS_HOSTED_SCRIPT') || ($aPhoto['server_id'] > 0 && Phpfox::getParam('core.allow_cdn')))
			{
				if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
				{
					$sPath = str_replace(PHPFOX_DIR, rtrim(Phpfox::getParam('core.rackspace_url'), '/') . '/', $sPath);
				}

				if ($aPhoto['server_id'] > 0 && Phpfox::getParam('core.allow_cdn'))
				{
					$sPath = Phpfox::getLib('image.helper')->display(array(
							'server_id' => $aPhoto['server_id'],
							'path' => 'photo.url_photo',
							'file' => $aPhoto['destination'],
							'suffix' => '_' . $iPhotoSize,
							'return_url' => true
						)
					);
				}
				
				// Match the int values to make sure we know what image we are viewing
				if ((int) $iViewSize === (int) $iPhotoSize)
				{
					$iDefaultSize = $iPhotoSize;
					$bIsSet = true;
				}
				
				// Get the image width and height
				list($iWidth, $iHeight) = getimagesize($sPath);
				
				if ($iWidth < $iPhotoSize && $iHeight < $iPhotoSize)
				{					
					continue;
				}
				
				// Add the image to the size array
				$aSizes[] = array(
					'width' => $iWidth,
					'height' => $iHeight,
					'actual' => $iPhotoSize
				);
				
				$aCache[$iWidth][$iHeight] = true;				
			}
		}
		unset($iHeight);
		unset($iWidth);
		// Get the width and height of the original image
		if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$sImagePath = Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['original_destination'], '');
			$sImagePath = str_replace(PHPFOX_DIR, rtrim(Phpfox::getParam('core.rackspace_url'), '/') . '/', $sImagePath);
			
			list($iWidth, $iHeight) = getimagesize($sImagePath);
		}
		else if (preg_match("/\{file\/pic\/(.*)\/(.*)\.jpg\}/i", $aPhoto['destination'], $aMatches))
		{
			list($iWidth, $iHeight) = getimagesize(PHPFOX_DIR . str_replace(array('{', '}'), '', $aMatches[0]));
		}
		else if (file_exists(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['original_destination'], '')))
		{
			list($iWidth, $iHeight) = getimagesize(Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['original_destination'], ''));
		}
				
		if (isset($iWidth) && isset($iHeight) && !isset($aCache[$iWidth][$iHeight]))
		{
			// Add the original image details to the size array
			$aSizes[] = array(
				'width' => $iWidth,
				'height' => $iHeight,
				'actual' => 'full'
			);		
		}		
		// If no matches were found lets display the full image
		if ($bIsSet === false)
		{
			$iDefaultSize = 'full';
		}
		
		// Clear the size param from the URL
		$this->url()->clearParam('size');
		
		// Assign the template vars
		$this->template()
			// ->setTemplate('blank')
			->setHeader('cache', array('all.css' => 'module_photo'))
			->setBreadcrumb(Phpfox::getPhrase('photo.photo'), ($aCallback === null ? $this->url()->makeUrl('photo') : $this->url()->makeUrl($aCallback['url_home_photo'])))
			->setBreadcrumb($aPhoto['title'], $this->url()->permalink('photo', $aPhoto['photo_id'], $aPhoto['title']), true)			
			->setFullSite()
			->assign(array(
				'aSizes' => $aSizes,
				'iDefaultSize' => $iDefaultSize,
				'aPhoto' => $aPhoto,
				'sUrlPath' => Phpfox::getParam('photo.url_photo') . sprintf($aPhoto['destination'], ($bIsSet ? '_' . $iDefaultSize : '')), // Get the image we need to display with the current size
				'aCallback' => $aCallback,
				'bReplace' => ($this->request()->get('replace') ? false : true)
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_size_clean')) ? eval($sPlugin) : false);
	}
}

?>