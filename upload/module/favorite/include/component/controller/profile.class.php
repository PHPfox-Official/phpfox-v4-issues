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
 * @version 		$Id: profile.class.php 1245 2009-11-02 16:10:29Z Raymond_Benc $
 */
class Favorite_Component_Controller_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aUser = $this->getParam('aUser');
		
		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'favorite.view_favorite'))
		{
			return Phpfox_Error::display('<div class="extra_info">' . Phpfox::getPhrase('favorite.full_name_has_closed_their_favorites_section', array('user_link' => $this->url()->makeUrl($aUser['user_name']), 'full_name' => Phpfox::getLib('parse.output')->clean($aUser['full_name']))) . '</div>');
		}		
		
		list($iOwnerUserId, $aFavorites) = Phpfox::getService('favorite')->get($aUser['user_id']);
		
		$this->template()->setHeader('cache', array(
					'favorite.js' => 'module_favorite'
				)
			)
			->setTitle(Phpfox::getPhrase('favorite.full_name_s_favorites', array('full_name' => $aUser['full_name'])))
			->setBreadcrumb(Phpfox::getPhrase('favorite.full_name_s_favorites', array('full_name' => $aUser['full_name'])), $this->url()->makeUrl($aUser['user_name'], 'favorite'))
			->assign(array(
				'aFavorites' => $aFavorites,
				'iFavoriteUserId' => $iOwnerUserId
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('favorite.component_controller_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>