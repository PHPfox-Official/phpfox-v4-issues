<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: new-album.class.php 3346 2011-10-24 15:20:05Z Raymond_Benc $
 */
class Music_Component_Block_New_Album extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aParentModule = $this->getParam('aParentModule');	
		
		$aAlbums = Phpfox::getService('music.album')->getLatestAlbums($aParentModule);
		
		if (!count($aAlbums))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('music.new_albums'),
				'aNewAlbums' => $aAlbums
			)
		);
		
		if (count($aAlbums) == 5)
		{
			$this->template()->assign(array(
					'aFooter' => array(
						Phpfox::getPhrase('music.view_more') => $this->url()->makeUrl('music.browse.album')
					)
				)
			);
		}
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_block_new_album_clean')) ? eval($sPlugin) : false);
	}
}

?>