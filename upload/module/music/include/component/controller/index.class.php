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
 * @package  		Module_Music
 * @version 		$Id: index.class.php 7230 2014-03-26 21:14:12Z Fern $
 */
class Music_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (defined('PHPFOX_IS_USER_PROFILE') && ($sLegacyTitle = $this->request()->get('req4')) && !empty($sLegacyTitle))
		{			
			Phpfox::getService('core')->getLegacyItem(array(
					'field' => array('song_id', 'title'),
					'table' => 'music_song',		
					'redirect' => 'music',
					'title' => $sLegacyTitle
				)
			);
		}	
		
		if (defined('PHPFOX_IS_USER_PROFILE') && ($sLegacyTitle = $this->request()->get('req3')) && !empty($sLegacyTitle))
		{			
			Phpfox::getService('core')->getLegacyItem(array(
					'field' => array('album_id', 'name'),
					'table' => 'music_album',		
					'redirect' => 'music.album',
					'search' => 'name_url',
					'title' => $sLegacyTitle
				)
			);
		}		
		
		Phpfox::getUserParam('music.can_access_music', true);
		
		$aParentModule = $this->getParam('aParentModule');	
		
		if ($this->request()->get('req2') == 'delete' && ($iDeleteId = $this->request()->getInt('id')) && ($mDeleteReturn = Phpfox::getService('music.process')->delete($iDeleteId)))
		{
			if (is_bool($mDeleteReturn))
			{
				$this->url()->send('music', null, Phpfox::getPhrase('music.song_successfully_deleted'));
			}
			else
			{
				$this->url()->forward($mDeleteReturn, Phpfox::getPhrase('music.song_successfully_deleted'));
			}
		}
		
		$oServiceSongBrowse = Phpfox::getService('music.song.browse');
		$sView = $this->request()->get('view');
		
		if (($sRedirect = $this->request()->getInt('redirect')) && ($aSong = Phpfox::getService('music')->getSong(Phpfox::getUserId(), $sRedirect, true)))
		{
			$this->url()->send($aSong['user_name'], array('music', ($aSong['album_id'] ? $aSong['album_url'] : 'view'), $aSong['title_url']));
		}
		
		if ($aParentModule === null && $this->request()->getInt('req2'))
		{
			return Phpfox::getLib('module')->setController('music.view');
		}
		
		$bIsProfile = false;
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

		$this->template()->setTitle(($bIsProfile ? Phpfox::getPhrase('music.fullname_s_songs', array('full_name' => $aUser['full_name'])) : Phpfox::getPhrase('music.music')))->setBreadcrumb(Phpfox::getPhrase('music.music'), ($bIsProfile ? $this->url()->makeUrl($aUser['user_name'], 'music') : $this->url()->makeUrl('music')));
		
		if ($aParentModule === null)
		{
			Phpfox::getService('music')->getSectionMenu();	
		}		
		
		$this->search()->set(array(
				'type' => 'music_song',
				'field' => 'm.song_id',				
				'search_tool' => array(
					'table_alias' => 'm',
					'search' => array(
						'action' => (defined('PHPFOX_IS_PAGES_VIEW') ? $aParentModule['url'] . 'music/' : ($bIsProfile === true ? $this->url()->makeUrl($aUser['user_name'], array('music', 'view' => $this->request()->get('view'))) : $this->url()->makeUrl('music', array('view' => $this->request()->get('view'))))),
						'default_value' => Phpfox::getPhrase('music.search_songs'),
						'name' => 'search',
						'field' => 'm.title'
					),
					'sort' => array(
						'latest' => array('m.time_stamp', Phpfox::getPhrase('music.latest')),
						'most-viewed' => array('m.total_play', Phpfox::getPhrase('music.most_viewed')),
						'most-liked' => array('m.total_like', Phpfox::getPhrase('music.most_liked')),
						'most-talked' => array('m.total_comment', Phpfox::getPhrase('music.most_discussed'))
					),
					'show' => array(10, 20, 30)
				)
			)
		);				
		
		$aBrowseParams = array(
			'module_id' => 'music.song',
			'alias' => 'm',
			'field' => 'song_id',
			'table' => Phpfox::getT('music_song'),
			'hide_view' => array('pending', 'my')				
		);
		
		$iGenre = $this->request()->getInt('req3');		
		
		switch ($sView)
		{
			case 'my':
				Phpfox::isUser(true);
				$this->search()->setCondition('AND m.user_id = ' . Phpfox::getUserId());
				break;
			case 'pending':
				Phpfox::isUser(true);
				Phpfox::getUserParam('music.can_approve_songs', true);
				$this->search()->setCondition('AND m.view_id = 1');
				$this->template()->assign('bIsInPendingMode', true);
				break;
			default:
				if ($bIsProfile === true)
				{
					$this->search()->setCondition("AND m.view_id IN(" . ($aUser['user_id'] == Phpfox::getUserId() ? '0,1' : '0') . ") AND m.privacy IN(" . (Phpfox::getParam('core.section_privacy_item_browsing') ? '%PRIVACY%' : Phpfox::getService('core')->getForBrowse($aUser)) . ") AND m.user_id = " . $aUser['user_id'] . "");	
				}
				else
				{				
					$this->search()->setCondition("AND m.view_id = 0 AND m.privacy IN(%PRIVACY%)");	
					if ($sView == 'featured')
					{
						$this->search()->setCondition('AND m.is_featured = 1');
					}
				}
				break;
		}
		
		if ($iGenre && ($aGenre = Phpfox::getService('music.genre')->getGenre($iGenre)))
		{
			$this->search()->setCondition('AND m.genre_id = ' . (int) $iGenre);	
			$this->template()->setBreadcrumb($aGenre['name'], $this->url()->permalink('browse.song.genre', $aGenre['genre_id'], $aGenre['name']), true);
		}		
		
		if ($aParentModule !== null)
		{
			$this->search()->setCondition("AND m.module_id = '" . Phpfox::getLib('database')->escape($aParentModule['module_id']) . "' AND m.item_id = " . (int) $aParentModule['item_id']);
		}
		else
		{
			$this->search()->setCondition('AND m.item_id = 0');
		}
		
		$this->search()->browse()->params($aBrowseParams)->execute();
		
		$aSongs = $this->search()->browse()->getRows();
		
		Phpfox::getLib('pager')->set(array('page' => $this->search()->getPage(), 'size' => $this->search()->getDisplay(), 'count' => $this->search()->browse()->getCount()));		
		
		if ($sPlugin = Phpfox_Plugin::get('music.component_controller_music_index')){ eval($sPlugin); }
		
		$this->template()->setHeader('cache', array(
					'pager.css' => 'style_css',
					'comment.css' => 'style_css',
					'feed.js' => 'module_feed',
					'browse.css' => 'module_music',
					'player/flowplayer/flowplayer.js' => 'static_script',
					'player/' . Phpfox::getParam('core.default_music_player') . '/core.js' => 'static_script'	
				)
			)			
			->assign(array(
				'aSongs' => $aSongs,
				'sMusicView' => $sView
			)
		);
		
		$this->setParam('global_moderation', array(
				'name' => 'musicsong',
				'ajax' => 'music.moderation',
				'menu' => array(
					array(
						'phrase' => Phpfox::getPhrase('music.delete'),
						'action' => 'delete'
					),
					array(
						'phrase' => Phpfox::getPhrase('music.approve'),
						'action' => 'approve'
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
		(($sPlugin = Phpfox_Plugin::get('music.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>
