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
 * @version 		$Id: genre.class.php 1352 2009-12-22 19:33:07Z Raymond_Benc $
 */
class Music_Component_Block_Genre extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aUser = $this->getParam('aUser');		
		
		if (!Phpfox::getUserGroupParam((isset($aUser['user_group_id']) ? $aUser['user_group_id'] : Phpfox::getUserBy('user_group_id')), 'music.can_upload_music_public'))
		{			
			return false;
		}			
		
		$aUserGenres = array();
		$aGetUserGenres = Phpfox::getService('music.genre')->getUserGenre((isset($aUser['user_id']) ? $aUser['user_id'] : Phpfox::getUserId()));
		
		if (count($aGetUserGenres))
		{
			foreach ($aGetUserGenres as $aUserGenre)
			{
				$aUserGenres[$aUserGenre['order_id']] = $aUserGenre;
			}
		}		
		
		$this->template()->assign(array(
				'iCustomGroupId' => Phpfox::getService('custom.group')->getId('music.custom_group_basics'),
				'aGenres' => Phpfox::getService('music.genre')->getList(),
				'aUserGenres' => $aUserGenres,
				'iGenerCount' => 3,
				'bIsGlobalEdit' => (isset($aUser['user_id']) ? true : false)
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_block_genre_clean')) ? eval($sPlugin) : false);
	}
}

?>