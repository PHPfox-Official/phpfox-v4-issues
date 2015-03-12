<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: edit-album.class.php 4699 2012-09-20 10:30:04Z Raymond_Benc $
 */
class Photo_Component_Controller_Edit_Album extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		if (Phpfox::getUserBy('profile_page_id'))
		{
			Phpfox::getService('pages')->setIsInPage();
		}
		
		if (!($aAlbum = Phpfox::getService('photo.album')->getForEdit($this->request()->getInt('id'))))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('photo.photo_album_not_found'));
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($this->request()->get('req3') == 'photo')
			{
				if (Phpfox::getService('photo.process')->massProcess($aAlbum, $aVals))
				{
					$this->url()->send('photo.edit-album.photo', array('id' => $aAlbum['album_id']), Phpfox::getPhrase('photo.photo_s_successfully_updated'));
				}
			}
			else 
			{
				if (Phpfox::getService('photo.album.process')->update($aAlbum['album_id'], $aVals))
				{
					$this->url()->permalink('photo.album', $aAlbum['album_id'], $aAlbum['name'], true, Phpfox::getPhrase('photo.album_successfully_updated'));
				}
			}
		}
		
		$aMenus = array(
			'detail' => Phpfox::getPhrase('photo.album_info'),
			'photo' => Phpfox::getPhrase('photo.photos')
		);
		
		$this->template()->buildPageMenu('js_photo_block', 
			$aMenus,
			array(
				'link' => $this->url()->permalink('photo.album', $aAlbum['album_id'], $aAlbum['name']),
				'phrase' => Phpfox::getPhrase('photo.view_this_album_uppercase')
			)
		);	
		
		list($iCnt, $aPhotos) = Phpfox::getService('photo')->get('p.album_id = ' . (int) $aAlbum['album_id']);
		list($iAlbumCnt, $aAlbums) = Phpfox::getService('photo.album')->get('pa.user_id = ' . Phpfox::getUserId());
		
		$this->template()->setTitle(Phpfox::getPhrase('photo.editing_album') . ': ' . $aAlbum['name'])
			->setFullSite()
			->setBreadcrumb(Phpfox::getPhrase('photo.photo'), $this->url()->makeUrl('photo'))
			->setBreadcrumb(Phpfox::getPhrase('photo.editing_album') . ': ' . $aAlbum['name'], $this->url()->makeUrl('photo.edit-album', array('id' => $aAlbum['album_id'])), true)
			->setHeader(array(
					'edit.css' => 'module_photo',
					'photo.js' => 'module_photo'
				)
			)
			->assign(array(
					'aForms' => $aAlbum,
					'aPhotos' => $aPhotos,
					'aAlbums' => $aAlbums
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_edit_album_clean')) ? eval($sPlugin) : false);
	}
}

?>