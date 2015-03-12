<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Displays a users photo and album gallery on their profile.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: profile.class.php 5143 2013-01-15 14:16:21Z Miguel_Espinoza $
 */
class Photo_Component_Controller_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->setParam('bIsProfile', true);
		if ($sPlugin = Phpfox_Plugin::get('photo.component_controller_profile_1')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
		//if (Phpfox::getParam('profile.display_submenu_for_photo') != true)
		{
		    
		    $aUser = $this->getParam('aUser');
		    $aInfo = array(
			'total_albums' => Phpfox::getService('photo.album')->getAlbumCount($aUser['user_id']),
			'total_photos' => $aUser['total_photo']
		    );
		    
		    $bShowPhotos = $this->request()->get('req3') != 'albums';
		    
		    if ($this->request()->get('req3') == '')
		    {
			$bShowPhotos = Phpfox::getParam('photo.in_main_photo_section_show') != 'albums';
		    }
		    
		    
		    $this->template()->setHeader(array(
			'profile.css' => 'module_photo'			
			))
			    ->assign(array(
				'aInfo' => $aInfo,
				'bShowPhotos' => $bShowPhotos,
				'sLinkPhotos' => $this->url()->makeUrl($aUser['user_name'] . '.photo.photos'),
				'sLinkAlbums' => $this->url()->makeUrl($aUser['user_name'] . '.photo.albums'),
			    ));
		}
		
		if ($this->request()->get('req3') == 'albums')
		{
			$this->template()->assign('sReq3', 'albums');
			Phpfox::getComponent('photo.albums', array('bNoTemplate' => true), 'controller');			
		}
		else 
		{
			$this->template()->assign('sReq3', 'photo');
			Phpfox::getComponent('photo.index', array('bNoTemplate' => true), 'controller');
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>