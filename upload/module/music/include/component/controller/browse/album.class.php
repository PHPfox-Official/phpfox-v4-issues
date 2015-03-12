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
 * @version 		$Id: album.class.php 3642 2011-12-02 10:01:15Z Miguel_Espinoza $
 */
class Music_Component_Controller_Browse_Album extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('music.can_access_music', true);
		
		if (($iDeleteAlbum = $this->request()->getInt('id')) && Phpfox::getService('music.album.process')->delete($iDeleteAlbum))
		{
			$this->url()->send('music.browse.album', null, Phpfox::getPhrase('music.album_successfully_deleted'));
		}		
		
		$oServiceSongBrowse = Phpfox::getService('music.album.browse');
		$sView = $this->request()->get('view');

		$this->template()->setTitle(Phpfox::getPhrase('music.music_albums'))
			->setBreadcrumb(Phpfox::getPhrase('music.music'), $this->url()->makeUrl('music'))
			->setBreadcrumb(Phpfox::getPhrase('music.albums'), $this->url()->makeUrl('music.browse.album'), true);		
		
		Phpfox::getService('music')->getSectionMenu();
	
		if (defined('PHPFOX_IS_AJAX_CONTROLLER'))
		{
			$bIsProfile = true;
			$aUser = Phpfox::getService('user')->get($this->request()->get('profile_id'));
			$this->setParam('aUser', $aUser);
		}
		else 
		{		
			$bIsProfile = $this->getParam('bIsProfile');	
			if ($bIsProfile === true)
			{
				$aUser = $this->getParam('aUser');
			}
		}			
		
		$this->search()->set(array(
				'type' => 'music_album',
				'field' => 'm.album_id',				
				'search_tool' => array(
					'table_alias' => 'm',
					'search' => array(
						'action' => ($bIsProfile === true ? $this->url()->makeUrl($aUser['user_name'], array('music.album', 'view' => $this->request()->get('view'))) : $this->url()->makeUrl('music.browse.album', array('view' => $this->request()->get('view')))),
						'default_value' => Phpfox::getPhrase('music.search_albums'),
						'name' => 'search',
						'field' => 'm.name'
					),
					'sort' => array(
						'latest' => array('m.time_stamp', Phpfox::getPhrase('music.latest')),
						'most-viewed' => array('m.total_view', Phpfox::getPhrase('music.most_viewed')),
						'most-liked' => array('m.total_like', Phpfox::getPhrase('music.most_liked')),
						'most-talked' => array('m.total_comment', Phpfox::getPhrase('music.most_discussed'))
					),
					'show' => array(10, 20, 30)
				)
			)
		);				
		
		$aBrowseParams = array(
			'module_id' => 'music.album',
			'alias' => 'm',
			'field' => 'album_id',
			'table' => Phpfox::getT('music_album'),
			'hide_view' => array('pending', 'my', 'my-album')				
		);		
		
		switch ($sView)
		{
			case 'my-album':
				Phpfox::isUser(true);
				$this->search()->setCondition('AND m.user_id = ' . Phpfox::getUserId());
				break;
			default:
				$this->search()->setCondition("AND m.view_id = 0 AND m.privacy IN(%PRIVACY%)");	
				if ($sView == 'featured')
				{
					$this->search()->setCondition('AND m.is_featured = 1');
				}				
				break;
		}		
	
		
		$this->search()->browse()->params($aBrowseParams)->execute();		
		
		Phpfox::getLib('pager')->set(array('page' => $this->search()->getPage(), 'size' => $this->search()->getDisplay(), 'count' => $this->search()->browse()->getCount()));				
		
		$this->template()->setHeader('cache', array(
					'pager.css' => 'style_css',
					'comment.css' => 'style_css',
					'feed.js' => 'module_feed',
					'browse.css' => 'module_music'											
				)
			)			
			->assign(array(
				'aAlbums' => $this->search()->browse()->getRows()			
			)
		);		
		
		$this->setParam('global_moderation', array(
				'name' => 'musicalbum',
				'ajax' => 'music.moderationAlbum',
				'menu' => array(
					array(
						'phrase' => Phpfox::getPhrase('music.delete'),
						'action' => 'delete'
					),
					array(
						'phrase' => Phpfox::getPhrase('music.feature'),
						'action' => 'feature'
					),
					array(
						'phrase' => Phpfox::getPhrase('music.un_feature'),
						'action' => 'un-feature'
					)						
				)
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_controller_browse_album_clean')) ? eval($sPlugin) : false);
	}
}

?>