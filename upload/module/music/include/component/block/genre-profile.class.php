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
 * @version 		$Id: genre-profile.class.php 477 2009-05-03 10:37:09Z Raymond_Benc $
 */
class Music_Component_Block_Genre_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aUser = (PHPFOX_IS_AJAX ? array('user_group_id' => Phpfox::getUserBy('user_group_id'), 'user_id' => Phpfox::getUserId()) : $this->getParam('aUser'));
		
		if (!Phpfox::getUserGroupParam($aUser['user_group_id'], 'music.can_upload_music_public'))
		{
			return false;
		}	
		
		$aUserGenres = Phpfox::getService('music.genre')->getUserGenre($aUser['user_id']);
		
		if (!count($aUserGenres))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'aUserGenres' => $aUserGenres
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		$this->template()->clean(array(
				'aUserGenres'
			)
		);
	
		(($sPlugin = Phpfox_Plugin::get('music.component_block_genre_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>