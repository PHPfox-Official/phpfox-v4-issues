<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

define('PHPFOX_IS_POPUP', true);

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox_Component
 * @version 		$Id: player.class.php 5538 2013-03-25 13:20:22Z Miguel_Espinoza $
 */
class Music_Component_Controller_Player extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('music.can_access_music', true);
		
		define('PHPFOX_SKIP_IM', true);
		
		$aAlbum = Phpfox::getService('music.album')->getForPlayer($this->request()->getInt('album'));
		$bPlayAll = $this->request()->getInt('play') == 1 ? true : false;
		
		if (!isset($aAlbum['album_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('music.album_you_are_looking_for_cannot_be_found'));
		}		
		
		$aTracks = Phpfox::getService('music.album')->getTracks($aAlbum['user_id'], $aAlbum['album_id']);		
		$sPlaylist = '{';
		$sNextSong = '{';
		foreach ($aTracks as $iKey => $aTrack)
		{
			//$sPlaylist .= '{sPath : "' . $aTrack['song_path'] . '", iId : ' . $aTrack['song_id'] . '},';
		    $sPlaylist .= ''.$aTrack['song_id'] . ' : "' . $aTrack['song_path'].'",';
		    if ($iKey > 0)
		    {
			// adding this song's id to the previous song's index
			$sNextSong .= ' ' . $aTracks[$iKey-1]['song_id'] . ' : ' . $aTracks[$iKey]['song_id'] .','; 
		    }
		}
		// add the first song to the last song
		$sNextSong .= ' ' . $aTracks[$iKey]['song_id'] . ' : ' . $aTracks[0]['song_id'];
		$sNextSong .= '}';
		$sPlaylist = rtrim($sPlaylist, ',') . '}';
		
		
		$this->template()->setTitle($aAlbum['name'])			
			->assign(array(
					'aAlbum' => $aAlbum,
					'bPlayAll' => true
				)
			)
			->setHeader(array(
					'blank.css' => 'style_css',
					'player/' . Phpfox::getParam('core.default_music_player') . '/core.js' => 'static_script',
					'<script type="text/javascript">$Behavior.music_player_load_player = function() { $Core.player.load({id: \'js_music_player'. ($bPlayAll ? '_all' : '') . '\', type: \'music\', playlist: '.$sPlaylist.', aNextSong: '.$sNextSong.'}); };</script>'
				)
			)
			->setTemplate('blank');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_controller_player_clean')) ? eval($sPlugin) : false);
	}
}

?>