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
 * @version 		$Id: ajax.class.php 5422 2013-02-25 13:13:56Z Raymond_Benc $
 */
class Music_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function deleteImage()
	{
		if (Phpfox::getService('music.album.process')->deleteImage($this->get('id')))
		{
			
		}
	}
	
	public function deleteTrack()
	{
		if (Phpfox::getService('music.process')->delete($this->get('id')))
		{
			
		}
	}
	
	public function play()
	{
		Phpfox::getService('music.process')->play($this->get('id'));
		
		$this->removeClass('.js_music_track', 'isSelected')
			->addClass('#js_music_track_' . $this->get('id'), 'isSelected');
	}
	
	public function playInFeed()
	{
		$aSong = Phpfox::getService('music')->getSong($this->get('id'));
		
		if (!isset($aSong['song_id']))
		{
			$this->alert(Phpfox::getPhrase('music.unable_to_find_the_song_you_are_trying_to_play'));
			
			return false;
		}
		
		Phpfox::getService('music.process')->play($aSong['song_id']);
		
		$sSongPath = $aSong['song_path'];
		
		$sWidth = '425px';
		if ($this->get('track'))
		{
			$sWidth = '100%';
		}
		
		if ($this->get('is_player'))
		{
			$sDivId = 'js_music_player_all';
		}
		else
		{
			$sDivId = 'js_tmp_music_player_' . $aSong['song_id'];
			$this->call('$Core.loadStaticFile(\'' . $this->template()->getStyle('static_script', 'player/' . Phpfox::getParam('core.default_music_player') . '/core.js') . '\');');
			if ($this->get('feed_id') && $this->get('id'))
			{
				$this->call('$(\'#js_play_music_song_' . $this->get('feed_id') . $aSong['song_id'] . '\').find(\'.activity_feed_content_link:first\').html(\'<div id="' . $sDivId . '" style="width:425px; height:30px;"></div>\');');
			}
			elseif ($this->get('feed_id'))
			{
				$this->call('$(\'#js_item_feed_' . $this->get('feed_id') . '\').find(\'.activity_feed_content_link:first\').html(\'<div id="' . $sDivId . '" style="width:425px; height:30px;"></div>\');');
			}
			else 
			{
				$this->call('$(\'#' . ($this->get('track') ? $this->get('track') : 'js_controller_music_play_' . $this->get('id') . '') . '\').html(\'<div id="' . $sDivId . '" style="width:' . $sWidth . '; height:30px;"></div>\');');
			}
		}
		// $this->call('$Core.player.load({id: \'' . $sDivId . '\', auto: true, type: \'music\', play: \'' . $sSongPath . '\'});');		
		// Fixes http://www.phpfox.com/tracker/view/7262/
		$this->call('var iWait = 250;if (typeof $Core.player == "undefined"){iWait = 2000;}setTimeout(function(){$Core.player.load({id: \'' . $sDivId . '\', auto: true, type: \'music\', play: \'' . $sSongPath . '\'});$("#'. $sDivId .'").css({height: "50px", width: "100%"});}, iWait);');		
	}
	
	public function updateGenre()
	{
		Phpfox::getUserParam('admincp.has_admin_access', true);
		
		if (Phpfox::getLib('parse.format')->isEmpty($this->get('quick_edit_input')))
		{
			$this->alert(Phpfox::getPhrase('music.add_a_genre'));
			
			return false;	
		}			
		
		if (Phpfox::getService('music.genre.process')->update($this->get('category_id'), $this->get('quick_edit_input')))		
		{
			$this->html('#' . $this->get('id'), '<a href="#?type=input&amp;id=js_blog_edit_title' . $this->get('category_id')  . '&amp;content=js_category' . $this->get('category_id')  . '&amp;call=music.updateGenre&amp;category_id=' . $this->get('category_id')  . '" class="quickEdit" id="js_category' . $this->get('category_id')  . '">' . Phpfox::getLib('parse.input')->clean($this->get('quick_edit_input')) . '</a>')
				->call('$Core.loadInit();');
		}
	}
	
	public function updateUserGenre()
	{
		Phpfox::isUser(true);
		$aCustom = $this->get('custom');		
		if (Phpfox::getService('music.genre.process')->updateUser(Phpfox::getUserId(), Phpfox::getUserId(), $aCustom['music_genre']))
		{
			$this->hide('#js_genre_update_form')->show('#js_actual_upload_form');
		}
	}
	
	public function userProfile()
	{
		if (Phpfox::getService('music.process')->addForProfile($this->get('id'), $this->get('type')))
		{
			if ($this->get('type'))
			{
				$this->show('#js_music_profile_remove_' . $this->get('id'))->hide('#js_music_profile_add_' . $this->get('id'))->alert(Phpfox::getPhrase('music.this_song_has_been_added_to_your_profile'));
			}
			else 
			{
				if ($this->get('remove'))
				{
					$this->remove('#js_music_track_' . $this->get('id'));
				}
				
				$this->show('#js_music_profile_add_' . $this->get('id'))->hide('#js_music_profile_remove_' . $this->get('id'))->alert(Phpfox::getPhrase('music.this_song_has_been_removed_from_your_profile'));
			}
		}
	}
	
	public function nextSong()
	{
		if (($aSong = Phpfox::getService('music.album')->getNextSong($this->get('album_id'), $this->get('song_id'))))
		{
			Phpfox::getService('music.process')->play($aSong['song_id']);	
			
			$this->call('$Core.player.play(\'js_music_player\', \'' . sprintf($aSong['song_path'], '') . '\');')
				->html('#js_music_cache_id', $aSong['song_id'])
				->removeClass('.js_music_track', 'isSelected')
				->addClass('#js_music_track_' . $aSong['song_id'], 'isSelected');
		}
	}
	
	public function latestAlbums()
	{
		Phpfox::getBlock('music.latest-album');
		
		$this->html('#js_music_latest_songs', $this->getContent(false));		
	}
	
	public function latestSongs()
	{
		Phpfox::getBlock('music.latest');
		
		$this->html('#js_music_latest_songs', $this->getContent(false));
	}
	
	public function featureSong()
	{
		if (Phpfox::getService('music.process')->feature($this->get('song_id'), $this->get('type')))
		{
			if ($this->get('type'))
			{
				$this->addClass('#js_controller_music_track_' . $this->get('song_id'), 'row_featured');
				$this->alert(Phpfox::getPhrase('music.song_successfully_featured'), Phpfox::getPhrase('music.feature'), 300, 150, true);
			}
			else 
			{
				$this->removeClass('#js_controller_music_track_' . $this->get('song_id'), 'row_featured');
				$this->alert(Phpfox::getPhrase('music.song_successfully_un_featured'), Phpfox::getPhrase('music.un_feature'), 300, 150, true);
			}				
		}
	}	
	
	public function featureAlbum()
	{
		if (Phpfox::getService('music.album.process')->feature($this->get('album_id'), $this->get('type')))
		{
			if ($this->get('type'))
			{
				$this->addClass('#js_album_' . $this->get('album_id'), 'row_featured');
				$this->alert(Phpfox::getPhrase('music.album_successfully_featured'), Phpfox::getPhrase('music.feature'), 300, 150, true);
			}
			else 
			{
				$this->removeClass('#js_album_' . $this->get('album_id'), 'row_featured');
				$this->alert(Phpfox::getPhrase('music.album_successfully_un_featured'), Phpfox::getPhrase('music.un_feature'), 300, 150, true);
			}			
		}
	}
	
	public function sponsorSong()
	{
	    Phpfox::isUser(true);
	    if (Phpfox::getService('music.process')->sponsorSong($this->get('song_id'), $this->get('type')))
	    {
		if ($this->get('type') == '1')
		{
		    // image was sponsored
		    $sHtml = '<a href="#" title="' . Phpfox::getPhrase('music.unsponsor_this_song') . '" onclick="$.ajaxCall(\'music.sponsorSong\', \'song_id=' . $this->get('song_id') . '&amp;type=0\'); return false;"><img src="' . $this->template()->getStyle('image', 'misc/medal_gold_delete.png') . '" class="v_middle" alt="'.Phpfox::getPhrase('music.unsponsor_this_song').'" width="16" height="16" /></a>';
		}
		else
		{
		    $sHtml = '<a href="#" title="' . Phpfox::getPhrase('music.sponsor_this_song') . '" onclick="$.ajaxCall(\'music.sponsorSong\', \'song_id=' . $this->get('song_id') . '&amp;type=1\'); return false;"><img src="' . $this->template()->getStyle('image', 'misc/medal_gold_add.png') . '" class="v_middle" alt="'.Phpfox::getPhrase('music.sponsor_this_song').'" width="16" height="16" /></a>';
		}
		$this->html('#js_song_sponsor_' . $this->get('song_id'), $sHtml)
			->alert($this->get('type') == '1' ? Phpfox::getPhrase('music.song_successfully_sponsored') : Phpfox::getPhrase('music.song_successfully_un_sponsored'));
		if($this->get('type') == '1')
		{
		    $this->call('$("#js_controller_music_track_'.$this->get('song_id').'").addClass("row_sponsored");');
		}
		else
		{
		    $this->call('$("#js_controller_music_track_'.$this->get('song_id').'").removeClass("row_sponsored");');
		}
	    }

	}

	public function sponsorAlbum()
	{
	    Phpfox::isUser(true);
	    
	    if (true == Phpfox::getService('music.process')->sponsorAlbum($this->get('album_id'), $this->get('type')))
	    {
		
		if ($this->get('type') == '1')
		{
		    Phpfox::getService('ad.process')->addSponsor(array('module' => 'music', 'section' => 'album', 'item_id' => $this->get('album_id')));
		    //item was sponsored
		    $sHtml = '<a href="#" title="' . Phpfox::getPhrase('music.unsponsor_this_album') . '" onclick="$.ajaxCall(\'music.sponsorAlbum\', \'album_id=' . $this->get('album_id') . '&amp;type=0\'); return false;">'.Phpfox::getPhrase('music.unsponsor_this_album').'</a>';
		}
		else
		{
		    Phpfox::getService('ad.process')->deleteAdminSponsor('music-album', $this->get('album_id'));
		    $sHtml = '<a href="#" title="' . Phpfox::getPhrase('music.sponsor_this_album') . '" onclick="$.ajaxCall(\'music.sponsorAlbum\', \'album_id=' . $this->get('album_id') . '&amp;type=1\'); return false;">'.Phpfox::getPhrase('music.sponsor_this_album').'</a>';
		}
		$this->html('#js_sponsor_album_' . $this->get('album_id'), $sHtml)
			->alert($this->get('type') == '1' ? Phpfox::getPhrase('music.album_successfully_sponsored') : Phpfox::getPhrase('music.album_successfully_un_sponsored'));
		if($this->get('type') == '1')
		{
		    $this->addClass('#js_album_' . $this->get('album_id'), 'row_sponsored');
		}
		else
		{
		    $this->removeClass('#js_album_' . $this->get('album_id'), 'row_sponsored');
		}
	    }
	    //
	}

	public function approveSong()
	{
		if (Phpfox::getService('music.process')->approve($this->get('id')))
		{
			$this->alert(Phpfox::getPhrase('music.song_has_been_approved'), Phpfox::getPhrase('music.song_approved'), 300, 100, true);
			$this->hide('#js_item_bar_approve_image');
			$this->hide('.js_moderation_off'); 
			$this->show('.js_moderation_on');				
		}
	}

	public function featuredAlbums()
	{
		Phpfox::getBlock('music.featured-album');
		
		$this->html('#js_music_featured_content', $this->getContent(false));		
	}
	
	public function featuredSongs()
	{
		Phpfox::getBlock('music.featured');
		
		$this->html('#js_music_featured_content', $this->getContent(false));
	}

	public function setName()
	{
		$sName = $this->get('sTitle');
		$iSong = (int)$this->get('iSong');
		$sTitle = Phpfox::getService('music.song.process')->setName($iSong, $sName, true, true);
		if (!empty($sTitle))
		{			
			Phpfox::addMessage(Phpfox::getPhrase('music.your_song_was_named_successfully'));			
			$this->call('location.href = "'.Phpfox::getLib('url')->makeUrl('profile.music.view.' . $sTitle).'";');
		}
	}
	
	public function moderation()
	{
		Phpfox::isUser(true);	
		
		switch ($this->get('action'))
		{
			case 'approve':
				Phpfox::getUserParam('music.can_approve_songs', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('music.process')->approve($iId);
					$this->remove('#js_controller_music_track_' . $iId);					
				}				
				$this->updateCount();
				$sMessage = Phpfox::getPhrase('music.songs_s_successfully_approved');
				break;			
			case 'delete':
				Phpfox::getUserParam('music.can_delete_other_tracks', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('music.process')->delete($iId);
					$this->slideUp('#js_controller_music_track_' . $iId);
				}				
				$sMessage = Phpfox::getPhrase('music.songs_s_successfully_deleted');
				break;
			case 'feature':
				Phpfox::getUserParam('music.can_feature_songs', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('music.process')->feature($iId, 1);
					$this->addClass('#js_controller_music_track_' . $iId, 'row_featured');
				}				
				$sMessage = Phpfox::getPhrase('music.songs_s_successfully_featured');
				break;
			case 'un-feature':
				Phpfox::getUserParam('music.can_feature_songs', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('music.process')->feature($iId, 0);					
					$this->removeClass('#js_controller_music_track_' . $iId, 'row_featured');
				}				
				$sMessage = Phpfox::getPhrase('music.songs_s_successfully_un_featured');
				break;
		}
		
		$this->alert($sMessage, 'Moderation', 300, 150, true);
		$this->hide('.moderation_process');			
	}	
	
	public function moderationAlbum()
	{
		Phpfox::isUser(true);	
		
		switch ($this->get('action'))
		{		
			case 'delete':
				Phpfox::getUserParam('music.can_delete_other_music_albums', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('music.album.process')->delete($iId);
					$this->slideUp('#js_album_' . $iId);
				}				
				$sMessage = Phpfox::getPhrase('music.albums_s_successfully_deleted');
				break;
			case 'feature':
				Phpfox::getUserParam('music.can_feature_music_albums', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('music.album.process')->feature($iId, 1);
					$this->addClass('#js_album_' . $iId, 'row_featured');
				}				
				$sMessage = Phpfox::getPhrase('music.albums_s_successfully_featured');
				break;
			case 'un-feature':
				Phpfox::getUserParam('music.can_feature_music_albums', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('music.album.process')->feature($iId, 0);					
					$this->removeClass('#js_album_' . $iId, 'row_featured');
				}				
				$sMessage = Phpfox::getPhrase('music.albums_s_successfully_un_featured');
				break;
		}
		
		$this->alert($sMessage, 'Moderation', 300, 150, true);
		$this->hide('.moderation_process');			
	}		
	
	public function displayFeed()
	{
 		$aVideo = Phpfox::getService('music')->getForEdit($this->get('song_id'), true);	 		

		Phpfox::getService('feed')->processAjax($this->get('id'));
	}	
}

?>