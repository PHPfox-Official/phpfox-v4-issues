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
 * @version 		$Id: sponsored-song.class.php 1723 2010-08-16 08:18:35Z Raymond_Benc $
 */
class Music_Component_Block_Sponsored_Song extends Phpfox_Component
{
    /**
     * Class process method which is used to execute this component.
     */
    public function process()
    {	
		if (!Phpfox::isModule('ad'))
		{
			return false;
		}    	
    	
		$aSponsorSong = Phpfox::getService('music')->getRandomSponsoredSongs();
		
		if (empty($aSponsorSong))
		{
		    return false;
		}
	
		foreach ($aSponsorSong as $aSong)
		{
		    Phpfox::getService('ad.process')->addSponsorViewsCount($aSong['sponsor_id'], 'music', 'sponsorSong');
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('music.sponsored_music_songs'),
				'aSponsorSong' => $aSponsorSong,
				'aFooter' => array(Phpfox::getPhrase('music.encourage_sponsor_song') => $this->url()->makeUrl('music.browse.song', array('view' => 'my', 'sponsor' => 1)))
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