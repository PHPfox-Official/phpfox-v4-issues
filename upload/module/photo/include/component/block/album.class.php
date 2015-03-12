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
 * @package  		Module_Photo
 * @version 		$Id: album.class.php 2724 2011-07-13 13:25:44Z Raymond_Benc $
 */
class Photo_Component_Block_Album extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);

		$sModule = $this->request()->get('module', false);
		$iItem =  $this->request()->getInt('item', false);			
		
		// Get the total number of albums this user has
		$iTotalAlbums = Phpfox::getService('photo.album')->getAlbumCount(Phpfox::getUserId());
		// Check if they are allowed to create new albums
		$bAllowedAlbums = (Phpfox::getUserParam('photo.max_number_of_albums') == 'null' ? true : (!Phpfox::getUserParam('photo.max_number_of_albums') ? false : (Phpfox::getUserParam('photo.max_number_of_albums') <= $iTotalAlbums ? false : true)));
		// Check if we have set a session storage for the form.
		if ($aSessionVals = Phpfox::getLib('session')->get('photo_album_form'))
		{
			// We have stored the form in a session, lets destroy it now.
			Phpfox::getLib('session')->remove('photo_album_form');
			// Lets assign the past form data so we can reuse it.
			$this->template()->assign(array(
					'aForms' => $aSessionVals
				)
			);
		}
		
		$aValidation = array(
			'name' => Phpfox::getPhrase('photo.provide_a_name_for_your_album'),
			'privacy' => Phpfox::getPhrase('photo.select_a_privacy_setting_for_your_album')
		);				

		$oValid = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_create_new_album', 
				'aParams' => $aValidation
			)
		);			
		
		$this->template()->assign(array(
				'bAllowedAlbums' => $bAllowedAlbums,
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(false),
				'sModule' => $sModule,
				'iItem' => $iItem
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_album_clean')) ? eval($sPlugin) : false);
	}
}

?>