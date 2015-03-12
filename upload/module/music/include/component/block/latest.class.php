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
 * @version 		$Id: latest.class.php 1259 2009-11-17 21:40:32Z Raymond_Benc $
 */
class Music_Component_Block_Latest extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!defined('PHPFOX_MUSIC_INDEX') && !PHPFOX_IS_AJAX)
		{
			return false;
		}
		
		$this->template()->assign(array(
				'aLatestSongs' => Phpfox::getService('music')->getLatestSongs()		
			)
		);
		
		if (!PHPFOX_IS_AJAX)
		{
			$this->template()->assign(array(
					'sHeader' => Phpfox::getPhrase('music.latest'),
					'aMenu' => array(
						Phpfox::getPhrase('music.songs') => '#music.latestSongs',
						Phpfox::getPhrase('music.albums') => '#music.latestAlbums'
					)
				)
			);	
			
			return 'block';
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{	
		(($sPlugin = Phpfox_Plugin::get('music.component_block_latest_clean')) ? eval($sPlugin) : false);
	}
}

?>