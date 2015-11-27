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
 * @version 		$Id: photo-album.class.php 867 2009-08-17 13:58:08Z Raymond_Benc $
 */
class Music_Component_Block_Photo_Album extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		return false;
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_block_photo_album_clean')) ? eval($sPlugin) : false);
	}
}

?>