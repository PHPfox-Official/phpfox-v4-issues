<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Creates the sub menu for photos when we are viewing them.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: menu.class.php 2536 2011-04-14 19:37:29Z Raymond_Benc $
 */
class Photo_Component_Block_Menu extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		// Not a valid image lets get out of here
		$aPhoto = $this->getParam('aPhoto');

		if (empty($aPhoto))
		{
			return false;
		}
		
		$aUser = $this->getParam('aUser');
		
		// Assign the template vars
		$this->template()->assign(array(
				'sPhotoUrl' => '',
				'sAlbumUrl' => (empty($aPhoto['album_url']) ? 'view' : $aPhoto['album_url']),
				'iAlbumId' => $aPhoto['album_id'],
				'sUserName' => $aUser['user_name'],
				'sPhotoTitle' => $aPhoto['title'],
				'sBookmarkUrl' => $aPhoto['bookmark_url']
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_menu_clean')) ? eval($sPlugin) : false);
		
		$this->template()->assign(array(
				'sPhotoUrl',
				'sAlbumUrl',
				'iAlbumId',
				'sUserName',
				'sPhotoTitle',
				'sBookmarkUrl'
			)
		);		
	}
}

?>