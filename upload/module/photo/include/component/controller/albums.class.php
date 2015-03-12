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
 * @version 		$Id: albums.class.php 7255 2014-04-07 17:39:00Z Fern $
 */
class Photo_Component_Controller_Albums extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('photo.can_view_photos', true);
		if (defined('PHPFOX_IS_USER_PROFILE') || defined('PHPFOX_IS_PAGES_VIEW'))/*&& Phpfox::getParam('profile.display_submenu_for_photo') != true)*/
		{
			$aTplParam = array('bSpecialMenu' => true);
			if(defined('PHPFOX_IS_PAGES_VIEW'))
			{
				$aTplParam['bShowPhotos'] = false;
			}
		    $this->template()->assign($aTplParam);
		}
		else
		{		    
		    $this->template()->assign(array('bSpecialMenu' => false));
		}
		$aParentModule = $this->getParam('aParentModule');	
		
		if ($iDeleteId = $this->request()->getInt('delete'))
		{
			if (Phpfox::getService('photo.album.process')->delete($iDeleteId))
			{
				$this->url()->send('photo.albums', null, Phpfox::getPhrase('photo.photo_album_successfully_deleted'));
			}
		}		
		
		$bIsUserProfile = false;
		if (defined('PHPFOX_IS_AJAX_CONTROLLER'))
		{
			$bIsUserProfile = true;
			$aUser = Phpfox::getService('user')->get($this->request()->get('profile_id'));
			$this->setParam('aUser', $aUser);
		}		
		
		if (defined('PHPFOX_IS_USER_PROFILE'))
		{
			$bIsUserProfile = true;
			$aUser = $this->getParam('aUser');
		}
		
		$sPhotoUrl = ($bIsUserProfile ? $this->url()->makeUrl($aUser['user_name']. '.photo.albums') : ($aParentModule === null ? $this->url()->makeUrl('photo.albums') : $aParentModule['url'] . 'albums/photo/'));
		
		$aBrowseParams = array(
			'module_id' => 'photo.album',
			'alias' => 'pa',
			'field' => 'album_id',
			'table' => Phpfox::getT('photo_album'),
			'hide_view' => array('pending', 'myalbums')
		);		
		
		$this->search()->set(array(
				'type' => 'photo.album',
				'field' => 'pa.album_id',				
				'search_tool' => array(
					'table_alias' => 'pa',
					'search' => array(
						'action' => $sPhotoUrl,
						'default_value' => Phpfox::getPhrase('photo.search_photo_albums'),
						'name' => 'search',
						'field' => 'pa.name'
					),
					'sort' => array(
						'latest' => array('pa.time_stamp', Phpfox::getPhrase('photo.latest')),
						'most-talked' => array('pa.total_comment', Phpfox::getPhrase('photo.most_discussed'))
					),
					'show' => array(9, 12, 15)
				)
			)
		);			
		
		if ($bIsUserProfile)
		{
			$this->search()->setCondition('AND pa.view_id ' . ($aUser['user_id'] == Phpfox::getUserId() ? 'IN(0,2)' : '= 0') . ' AND pa.group_id = 0 AND pa.privacy IN(' . (Phpfox::getParam('core.section_privacy_item_browsing') ? '%PRIVACY%' : Phpfox::getService('core')->getForBrowse($aUser)) . ') AND pa.user_id = ' . (int) $aUser['user_id']);
		}
		else
		{	
			if ($this->request()->get('view') == 'myalbums')
			{
				Phpfox::isUser(true);
				
				$this->search()->setCondition('AND pa.user_id = ' . Phpfox::getUserId() . ' AND pa.profile_id = 0');
			}
			else
			{
				$this->search()->setCondition('AND pa.view_id = 0 AND pa.privacy IN(%PRIVACY%) AND pa.total_photo > 0 AND pa.profile_id = 0');
			}
		}	
		
		if ($aParentModule !== null && !empty($aParentModule['item_id']))
		{
			$this->search()->setCondition('AND pa.module_id = \'' . $aParentModule['module_id']. '\' AND pa.group_id = ' . (int) $aParentModule['item_id']);
		}
		else
		{
			$this->search()->setCondition("AND (pa.module_id IS NULL OR pa.module_id = '')");
		}
		
		$this->search()->browse()->params($aBrowseParams)->execute();
		
		$aAlbums = $this->search()->browse()->getRows();
		$iCnt = $this->search()->browse()->getCount();		
		
		if (defined('PHPFOX_IS_USER_PROFILE'))
		{
			$bIsUserProfile = true;
			$aUser = $this->getParam('aUser');
			if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'photo.display_on_profile'))
			{
				$aAlbums = array();
				$iCnt = 0;
			}
		}			
		
		$aPager = array(
			'page' => $this->search()->getPage(), 
			'size' => $this->search()->getDisplay(), 
			'count' => $this->search()->browse()->getCount()
		);
		
		if ($aPager['size'] > Phpfox::getUserParam('photo.max_photo_display_limit'))
		{
			$aPager['size'] = Phpfox::getUserParam('photo.max_photo_display_limit');
		}
		Phpfox::getLib('pager')->set($aPager);
		
		if (Phpfox::getParam('photo.show_info_on_mouseover') && isset($aUser['use_timeline']) && $aUser['use_timeline'])
		{
		    $this->template()->setFullSite();
		}
		// http://www.phpfox.com/tracker/view/14733/
		elseif (Phpfox::getParam('photo.show_info_on_mouseover'))
		{
			$this->template()
				->setHeader(array(
						'index.css' => 'module_photo',
						'index.js' => 'module_photo',
					)
			);
		}
		// END
		
		$this->template()->setTitle(Phpfox::getPhrase('photo.photo_albums'))
			->setHeader(array(
					'pager.css' => 'style_css',
					'albums.css' => 'module_photo'
				)
			)
			->setBreadcrumb(Phpfox::getPhrase('photo.photos'), $this->url()->makeUrl('photo'))
			->assign(array(
				'aAlbums' => $aAlbums
			)
		);	
		
		if ($aParentModule === null)
		{
			Phpfox::getService('photo')->buildMenu();
		}			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_albums_clean')) ? eval($sPlugin) : false);
	}
}

?>
