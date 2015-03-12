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
 * @version 		$Id: featured-album.class.php 3542 2011-11-22 11:33:05Z Raymond_Benc $
 */
class Music_Component_Block_Featured_Album extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aAlbums = (array) Phpfox::getService('music.album')->getFeaturedAlbums();
		
		if (!count($aAlbums))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('music.featured_albums'),
				'aFeaturedAlbums' => $aAlbums
			)
		);		

		if (count($aAlbums) == 5)
		{
			$this->template()->assign(array(
					'aFooter' => array(
						Phpfox::getPhrase('music.view_more') => $this->url()->makeUrl('music.browse.album', array('view' => 'featured'))
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
		(($sPlugin = Phpfox_Plugin::get('music.component_block_featured_album_clean')) ? eval($sPlugin) : false);
	}
}

?>