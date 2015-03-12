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
 * @version 		$Id: song.class.php 2577 2011-04-29 08:48:05Z Raymond_Benc $
 */
class Music_Component_Block_Song extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$aUser = $this->getParam('aUser');

		$bIsMusician = false;
		if (!Phpfox::getUserGroupParam($aUser['user_group_id'], 'music.can_upload_music_public'))
		{
			return false;
		}		
		
		$aSongs = Phpfox::getService('music')->getSongs($aUser['user_id'], null, 10);
		
		if (!count($aSongs) && !defined('PHPFOX_IN_DESIGN_MODE'))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('music.latest_tracks'),
				'sBlockJsId' => 'profile_music_song',
				'aSongs' => $aSongs,
				'bIsMusician' => true,
				'sCustomPlayId' => 'js_my_block_track_player'
			)
		);
		
		if (Phpfox::getUserId() == $aUser['user_id'])
		{
			$this->template()->assign('sDeleteBlock', 'profile');
		}		
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_block_song_clean')) ? eval($sPlugin) : false);
		
		$this->template()->clean('sCustomPlayId');
	}		
}

?>