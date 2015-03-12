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
 * @version 		$Id: profile.class.php 1388 2010-01-11 20:17:18Z Raymond_Benc $
 */
class Music_Component_Block_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aUser = $this->getParam('aUser');
		
		if (!$aUser['total_profile_song'] && !defined('PHPFOX_IN_DESIGN_MODE'))
		{
			return false;
		}
		
		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'music.display_on_profile'))
		{
			return false;
		}
		
		$aSongs = Phpfox::getService('music')->getForProfile($aUser['user_id'], Phpfox::getUserParam('music.total_song_on_profile'));
		
		if (!count($aSongs) && !defined('PHPFOX_IN_DESIGN_MODE'))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('music.favorite_songs'),
				'sBlockJsId' => 'profile_music_favorite_song',
				'aSongs' => $aSongs,
				'bIsMusician' => false
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
		(($sPlugin = Phpfox_Plugin::get('music.component_block_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>