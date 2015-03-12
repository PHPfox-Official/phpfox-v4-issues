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
 * @version 		$Id: menu-album.class.php 2600 2011-05-11 19:54:09Z Raymond_Benc $
 */
class Photo_Component_Block_Menu_Album extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aUser = $this->getParam('aUser');
		
		$aAlbum = $this->getParam('aAlbum');
		
		$this->template()->assign(array(
				'sBookmarkUrl' => $this->url()->permalink('photo.album', $aAlbum['album_id'], $aAlbum['name']),
				'aAlbum' => $aAlbum
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_menu_album_clean')) ? eval($sPlugin) : false);
	}
}

?>