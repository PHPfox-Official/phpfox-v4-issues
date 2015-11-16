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
 * @version 		$Id: view.class.php 7230 2014-03-26 21:14:12Z Fern $
 */
class Music_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (($playId = $this->request()->get('play'))) {
			Music_Service_Process::instance()->play($this->request()->get('play'));

			return [
				'played' => true
			];
		}

		Phpfox::getUserParam('music.can_access_music', true);
		
		if (Phpfox::isUser() && Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->delete('comment_music_song', $this->request()->getInt('req2'), Phpfox::getUserId());
			Phpfox::getService('notification.process')->delete('music_song_like', $this->request()->getInt('req2'), Phpfox::getUserId());
		}			
		
		if (!($aSong = Phpfox::getService('music')->getSong($this->request()->get('req2'))))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('music.the_song_you_are_looking_for_cannot_be_found'));
		}
		
		if (Phpfox::isModule('notification') && $aSong['user_id'] == Phpfox::getUserId())
		{
			Phpfox::getService('notification.process')->delete('music_songapproved', $aSong['song_id'], Phpfox::getUserId());
		}	
		
		$aCallback = false;
		if (!empty($aSong['module_id']))
		{			
			if ($aCallback = Phpfox::callback($aSong['module_id'] . '.getMusicDetails', $aSong))
			{
				$this->template()->setBreadcrumb($aCallback['breadcrumb_title'], $aCallback['breadcrumb_home']);
				$this->template()->setBreadcrumb($aCallback['title'], $aCallback['url_home']);
				if ($aSong['module_id'] == 'pages' && !Phpfox::getService('pages')->hasPerm($aCallback['item_id'], 'music.view_browse_music'))
				{
					return Phpfox_Error::display(Phpfox::getPhrase('music.unable_to_view_this_item_due_to_privacy_settings'));
				}		
			}
		}		

		Phpfox::getService('core.redirect')->check($aSong['title']);
		if (Phpfox::isModule('privacy'))
		{
			Privacy_Service_Privacy::instance()->check('music_song', $aSong['song_id'], $aSong['user_id'], $aSong['privacy'], $aSong['is_friend']);
		}
		
		
		$this->setParam('aSong', $aSong);
		$this->setParam('aRatingCallback', array(
				'type' => 'music_song',
				'total_rating' => Phpfox::getPhrase('music.total_rating_ratings', array('total_rating' => $aSong['total_rating'])),
				'default_rating' => $aSong['total_score'],
				'item_id' => $aSong['song_id'],
				'stars' => array(
					'2' => Phpfox::getPhrase('music.poor'),
					'4' => Phpfox::getPhrase('music.nothing_special'),
					'6' => Phpfox::getPhrase('music.worth_listening_too'),
					'8' => Phpfox::getPhrase('music.pretty_cool'),
					'10' => Phpfox::getPhrase('music.awesome')
				)
			)
		);
		
		$this->template()->setBreadcrumb(Phpfox::getPhrase('music.music'), ($aCallback === false ? $this->url()->makeUrl('music') : $aCallback['url_home_photo']));
		if (!empty($aSong['album_url']))
		{
			$this->template()->setBreadcrumb($aSong['album_url'], $this->url()->permalink('music.album', $aSong['album_id'], $aSong['album_url']));
		}
		$this->template()->setBreadcrumb($aSong['title'], $this->url()->permalink('music', $aSong['song_id'], $aSong['title']), true);		
		
		$this->setParam('aFeed', array(				
				'comment_type_id' => 'music_song',
				'privacy' => $aSong['privacy'],
				'comment_privacy' => $aSong['privacy_comment'],
				'like_type_id' => 'music_song',
				'feed_is_liked' => $aSong['is_liked'],
				'feed_is_friend' => $aSong['is_friend'],
				'item_id' => $aSong['song_id'],
				'user_id' => $aSong['user_id'],
				'total_comment' => $aSong['song_total_comment'],
				'total_like' => $aSong['total_like'],
				'feed_link' => $this->url()->permalink('music', $aSong['song_id'], $aSong['title']),
				'feed_title' => $aSong['title'],
				'feed_display' => 'view',
				'feed_total_like' => $aSong['total_like'],
				'report_module' => 'music_song',
				'report_phrase' => Phpfox::getPhrase('music.report_this_song_lowercase')
			)
		);		
		if (Phpfox::isModule('rate'))
		{
			$this->template()->setPhrase(array(
					'rate.thanks_for_rating'			
				)
			)
			->setHeader('cache', array(
					'rate.js' => 'module_rate'))
			->setHeader(array('<script type="text/javascript">$Behavior.rateSong = function() {  $Core.rate.init({module: \'music_song\', display: ' . ($aSong['has_rated'] ? 'false' : ($aSong['user_id'] == Phpfox::getUserId() ? 'false' : 'true')) . ', error_message: \'' . ($aSong['has_rated'] ? Phpfox::getPhrase('music.you_have_already_voted', array('phpfox_squote' => true)) : Phpfox::getPhrase('music.you_cannot_rate_your_own_song', array('phpfox_squote' => true))) . '\'}); }</script>'));
		}
		
		$this->template()->setTitle($aSong['title'])	
			->setMeta('og:image', Phpfox::getLib('image.helper')->display(array(
					'user' => $aSong,
					'suffix' => '_50',
					'return_url' => true
					)
				)
			)
			// http://www.phpfox.com/tracker/view/14673/
			->setMeta('description', $aSong['title'])
			->setHeader('cache', array(
					'jquery/plugin/star/jquery.rating.js' => 'static_script',
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',
					'jquery/plugin/jquery.scrollTo.js' => 'static_script',
					'quick_edit.js' => 'static_script',
					// 'jquery.rating.css' => 'style_css',				
					// 'pager.css' => 'style_css',
					'feed.js' => 'module_feed',
					'view.css' => 'module_music'
				)
			)
			->setHeader(array(
					'<script type="text/javascript">var bLoadedMusicSong = false; $Behavior.playSongOnView = function() { bLoadedMusicSong = false; if ($(\'#js_music_player\').length > 0) { $Core.player.load({on_start: function() { if (!bLoadedMusicSong) {  bLoadedMusicSong = true; $.ajaxCall(\'music.play\', \'id=' . $aSong['song_id'] . '\', \'GET\'); } }, id: \'js_music_player\', type: \'music\', auto: true, play: \'' . $aSong['song_path'] . '\'}); } $Behavior.playSongOnView = function() {}; }</script>',
					
				)
			)
			->setEditor(array(
					'load' => 'simple'
				)
			)		
			->assign(array(
				'aSong' => $aSong
			)
		);
		
		if ($sPlugin = Phpfox_Plugin::get('music.component_controller_music_view')){ eval($sPlugin); }
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>
