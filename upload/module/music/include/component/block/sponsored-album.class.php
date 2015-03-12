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
 * @version 		$Id: sponsored-album.class.php 1723 2010-08-16 08:18:35Z Raymond_Benc $
 */
class Music_Component_Block_Sponsored_Album extends Phpfox_Component
{
    /**
     * Class process method wnich is used to execute this component.
     */
    public function process()
    {
		if (!Phpfox::isModule('ad'))
		{
			return false;
		}    	
    	
		$aSponsorAlbum = Phpfox::getService('music')->getRandomSponsoredAlbum();
		if (empty($aSponsorAlbum))
		{
		    return false;
		}
	
		Phpfox::getService('ad.process')->addSponsorViewsCount($aSponsorAlbum['sponsor_id'], 'music', 'sponsorAlbum');
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('music.sponsored_music_album'),
				'aSponsorAlbum' => $aSponsorAlbum,
				'aFooter' => array(Phpfox::getPhrase('music.encourage_sponsor_album') => $this->url()->makeUrl('music.browse.album', array('view' => 'my', 'sponsor' => 1)))
			)
		);
		
		return 'block';
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
	(($sPlugin = Phpfox_Plugin::get('music.component_block_featured_clean')) ? eval($sPlugin) : false);
    }
}

?>