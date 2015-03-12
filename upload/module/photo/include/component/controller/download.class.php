<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Controller used to download a users photo.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox_Component
 * @version 		$Id: download.class.php 2610 2011-05-19 18:43:08Z Raymond_Benc $
 */
class Photo_Component_Controller_Download extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('photo.can_view_photos', true);
		
		// Make sure the user group can download this photo
		Phpfox::getUserParam('photo.can_download_user_photos', true);
		
		// Check if we want to download a specific photo size
		$iDownloadSize = $this->request()->get('size');
		
		// Get photo array
		$aPhoto = $this->getParam('aPhoto');
		
		if (!$aPhoto['allow_download'])
		{
			return Phpfox_Error::display(Phpfox::getPhrase('photo.not_allowed_to_download_this_image'));
		}
		
		// Prepare the image path
		$sPath = Phpfox::getParam('photo.dir_photo') . sprintf($aPhoto['original_destination'], (is_numeric($iDownloadSize) ? '_' . $iDownloadSize : ''));
		
		// Increment the download counter
		Phpfox::getService('photo.process')->updateCounter($aPhoto['photo_id'], 'total_download');
		
		// Download the photo
		Phpfox::getLib('file')->forceDownload($sPath, $aPhoto['file_name'], $aPhoto['mime_type'], $aPhoto['file_size'], $aPhoto['server_id']);
		
		// We are done, lets get out of here
		exit;
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_download_clean')) ? eval($sPlugin) : false);
	}
}

?>