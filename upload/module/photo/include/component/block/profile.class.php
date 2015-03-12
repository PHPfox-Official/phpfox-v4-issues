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
 * @version 		$Id: profile.class.php 1251 2009-11-09 21:02:59Z Raymond_Benc $
 */
class Photo_Component_Block_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aUser = $this->getParam('aUser');
		$aPhotos = Phpfox::getService('photo')->getForProfile($aUser['user_id']);
		
		if (!count($aPhotos) && !defined('PHPFOX_IN_DESIGN_MODE'))
		{
			return false;
		}
		
		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'photo.display_on_profile'))
		{
			return false;
		}		
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('photo.photos'),
				'aPhotos' => $aPhotos
			)
		);
		
		if (count($aPhotos) == 3)
		{
			$this->template()->assign(array(
					'aFooter' => array(
						Phpfox::getPhrase('photo.view_more_photos') => $this->url()->makeUrl($aUser['user_name'], 'photo')
					)
				)
			);
		}
		
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
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>