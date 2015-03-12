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
 * @version 		$Id: view-album.class.php 6881 2013-11-12 15:08:13Z Fern $
 */
class Music_Component_Controller_View_Album extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('music.can_access_music', true);

		if (Phpfox::isUser() && Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->delete('comment_music_album', $this->request()->getInt('req3'), Phpfox::getUserId());
			Phpfox::getService('notification.process')->delete('music_song_album', $this->request()->getInt('req3'), Phpfox::getUserId());
			Phpfox::getService('notification.process')->delete('music_album_like', $this->request()->getInt('req3'), Phpfox::getUserId());
		}

		$aAlbum = Phpfox::getService('music.album')->getAlbum($this->request()->getInt('req3'));

		if (!isset($aAlbum['album_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('music.unable_to_find_the_album_you_are_looking_for'));
		}

		$aCallback = false;
		if (!empty($aAlbum['module_id']))
		{
			if ($aCallback = Phpfox::callback($aAlbum['module_id'] . '.getMusicDetails', $aAlbum))
			{
				$this->template()->setBreadcrumb($aCallback['breadcrumb_title'], $aCallback['breadcrumb_home']);
				$this->template()->setBreadcrumb($aCallback['title'], $aCallback['url_home']);
				if ($aAlbum['module_id'] == 'pages' && !Phpfox::getService('pages')->hasPerm($aCallback['item_id'], 'music.view_browse_music'))
				{
					return Phpfox_Error::display(Phpfox::getPhrase('music.unable_to_view_this_item_due_to_privacy_settings'));
				}
			}
		}

		Phpfox::getService('core.redirect')->check($aAlbum['name'], 'req4');
		if (Phpfox::isModule('privacy'))
		{
			Phpfox::getService('privacy')->check('music_album', $aAlbum['album_id'], $aAlbum['user_id'], $aAlbum['privacy'], $aAlbum['is_friend']);
		}

		$this->setParam('aAlbum', $aAlbum);
		$this->setParam('aRatingCallback', array(
				'type' => 'music_album',
				'total_rating' => Phpfox::getPhrase('music.total_rating_ratings', array('total_rating' => $aAlbum['total_rating'])),
				'default_rating' => $aAlbum['total_score'],
				'item_id' => $aAlbum['album_id'],
				'stars' => array(
					'2' => Phpfox::getPhrase('music.poor'),
					'4' => Phpfox::getPhrase('music.nothing_special'),
					'6' => Phpfox::getPhrase('music.worth_listening_too'),
					'8' => Phpfox::getPhrase('music.pretty_cool'),
					'10' => Phpfox::getPhrase('music.awesome')
				)
			)
		);

		$this->setParam('aFeed', array(
				'comment_type_id' => 'music_album',
				'privacy' => $aAlbum['privacy'],
				'comment_privacy' => $aAlbum['privacy_comment'],
				'like_type_id' => 'music_album',
				'feed_is_liked' => $aAlbum['is_liked'],
				'feed_is_friend' => $aAlbum['is_friend'],
				'item_id' => $aAlbum['album_id'],
				'user_id' => $aAlbum['user_id'],
				'total_comment' => $aAlbum['total_comment'],
				'total_like' => $aAlbum['total_like'],
				'feed_link' => $this->url()->permalink('music.album', $aAlbum['album_id'], $aAlbum['name']),
				'feed_title' => $aAlbum['name'],
				'feed_display' => 'view',
				'feed_total_like' => $aAlbum['total_like'],
				'report_module' => 'music_album',
				'report_phrase' => Phpfox::getPhrase('music.report_this_album')
			)
		);

		$this->setParam(array(
				'album_user_id' => $aAlbum['user_id'],
				'album_id' => $aAlbum['album_id']
			)
		);

		$this->template()->setBreadcrumb(Phpfox::getPhrase('music.music'), ($aCallback === false ? $this->url()->makeUrl('music') : $aCallback['url_home_photo']));

		if ($aCallback === false)
		{
			$this->template()->setBreadcrumb(Phpfox::getPhrase('music.albums'), $this->url()->makeUrl('music.browse.album'));
		}

		define('PHPFOX_IS_ALBUM_VIEW', true);

		if (Phpfox::isModule('rate'))
		{
			$this->template()->setPhrase(array(
				'rate.thanks_for_rating'
			))
				->setHeader('cache',array('rate.js' => 'module_rate',
					'<script type="text/javascript">$Behavior.rateMusicAlbum = function() { $Core.rate.init({module: \'music_album\', display: ' . ($aAlbum['has_rated'] ? 'false' : ($aAlbum['user_id'] == Phpfox::getUserId() ? 'false' : 'true')) . ', error_message: \'' . ($aAlbum['has_rated'] ? Phpfox::getPhrase('music.you_have_already_voted', array('phpfox_squote' => true)) : Phpfox::getPhrase('music.you_cannot_rate_your_own_album', array('phpfox_squote' => true))) . '\'}); }</script>'));
		}

		$this->template()->setTitle($aAlbum['name']);
		if (!empty($aAlbum['image_path']))
		{
			$this->template()->setMeta('og:image', Phpfox::getLib('image.helper')->display(array(
						'server_id' => $aAlbum['server_id'],
						'path' => 'music.url_image',
						'file' => $aAlbum['image_path'],
						'suffix' => '_200',
						'return_url' => true
					)
				)
			);
		}
		$this->template()->setBreadcrumb($aAlbum['name'], $this->url()->permalink('music.album', $aAlbum['album_id'], $aAlbum['name']), true)
			// http://www.phpfox.com/tracker/view/14673/
			->setMeta('description', $aAlbum['name'])
			->setHeader('cache', array(
					'jquery/plugin/star/jquery.rating.js' => 'static_script',
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',
					'jquery/plugin/jquery.scrollTo.js' => 'static_script',
					'jquery.rating.css' => 'style_css',
					'quick_edit.js' => 'static_script',
					'comment.css' => 'style_css',
					'pager.css' => 'style_css',
					'feed.js' => 'module_feed',
					'album.js' => 'module_music',
					'player/flowplayer/flowplayer.js' => 'static_script',
					'player/' . Phpfox::getParam('core.default_music_player') . '/core.js' => 'static_script'
				)
			)
			->setEditor(array(
					'load' => 'simple'
				)
			)
			->assign(array(
					'aAlbum' => $aAlbum
				)
			);
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_controller_view_album_clean')) ? eval($sPlugin) : false);
	}
}

?>
