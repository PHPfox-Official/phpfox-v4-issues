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
 * @version 		$Id: public-album.class.php 1388 2010-01-11 20:17:18Z Raymond_Benc $
 */
class Photo_Component_Controller_Public_Album extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('photo.can_view_photos', true);
		
		$aCond = array();
		if (!Phpfox::getUserParam('photo.can_view_private_photos'))
		{
			$aCond[] = 'AND pa.view_id = 0 AND  pa.group_id = 0 AND pa.privacy = 0';
		}
		$aCond[] = 'AND pa.total_photo > 0';
		
		$iPage = $this->request()->getInt('page');
		$iPageSize = 8;
		
		list($iCnt, $aAlbums) = Phpfox::getService('photo.album')->get($aCond, 'pa.time_stamp DESC', $iPage, $iPageSize);
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
		
		$this->template()->setTitle(Phpfox::getPhrase('photo.photo_albums'))
			->setHeader(array(
					'pager.css' => 'style_css'
				)
			)
			->setBreadcrumb(Phpfox::getPhrase('photo.photos'), $this->url()->makeUrl('photo'))
			->setBreadcrumb(Phpfox::getPhrase('photo.albums'), null, true)
			->assign(array(
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
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_public_album_clean')) ? eval($sPlugin) : false);
	}
}

?>