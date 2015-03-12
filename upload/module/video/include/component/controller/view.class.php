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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Video_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		Phpfox::getUserParam('video.can_access_videos', true);

		$aCallback = $this->getParam('aCallback', false);
		
		if ($sPlugin = Phpfox_Plugin::get('video.component_controller_view_1')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
		$iVideo = $this->request()->getInt(($aCallback !== false ? $aCallback['request'] : 'req2'));
		
		if (Phpfox::isUser() && Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->delete('comment_video', $this->request()->getInt('req2'), Phpfox::getUserId());
			Phpfox::getService('notification.process')->delete('video_like', $this->request()->getInt('req2'), Phpfox::getUserId());
		}		
		
		if ($sPlugin = Phpfox_Plugin::get('video.component_controller_view_2')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
		if (!($aVideo = Phpfox::getService('video')->callback($aCallback)->getVideo($iVideo)))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('video.the_video_you_are_looking_for_does_not_exist_or_has_been_removed'), 404);
		}	
			
		if (Phpfox::getUserId() == $aVideo['user_id'] && Phpfox::isModule('notification'))
		{
			Phpfox::getService('notification.process')->delete('video_approved', $this->request()->getInt('req2'), Phpfox::getUserId());
		}		
		
		if ($sPlugin = Phpfox_Plugin::get('video.component_controller_view_3')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
		if (Phpfox::isModule('track') && !$aVideo['video_is_viewed'])
		{
			Phpfox::getService('track.process')->add('video', $aVideo['video_id']);
		}		
		
		Phpfox::getService('core.redirect')->check($aVideo['title']);
		if (Phpfox::isModule('privacy'))
		{
			Phpfox::getService('privacy')->check('video', $aVideo['video_id'], $aVideo['user_id'], $aVideo['privacy'], $aVideo['is_friend']);		
		}
		
		
		$this->setParam('aVideo', $aVideo);
		$this->setParam('sGroup', ($this->request()->get('req1') == 'group') ? $this->request()->get('req2') : '');
		$this->setParam('aRatingCallback', array(
				'type' => 'video',
				'total_rating' => Phpfox::getPhrase('video.total_rating_ratings', array('total_rating' => $aVideo['total_rating'])),//$aVideo['total_rating'] . ' Ratings',
				'default_rating' => $aVideo['total_score'],
				'item_id' => $aVideo['video_id'],
				'stars' => array(
					'2' => Phpfox::getPhrase('video.poor'),
					'4' => Phpfox::getPhrase('video.nothing_special'),
					'6' => Phpfox::getPhrase('video.worth_watching'),
					'8' => Phpfox::getPhrase('video.pretty_cool'),
					'10' => Phpfox::getPhrase('video.awesome')
				)
			)
		);		
		
		$this->setParam('aFeed', array(				
				'comment_type_id' => 'video',
				'privacy' => $aVideo['privacy'],
				'comment_privacy' => $aVideo['privacy_comment'],
				'like_type_id' => 'video',
				'feed_is_liked' => (isset($aVideo['is_liked']) ? $aVideo['is_liked'] : false),
				'feed_is_friend' => $aVideo['is_friend'],
				'item_id' => $aVideo['video_id'],
				'user_id' => $aVideo['user_id'],
				'total_comment' => $aVideo['total_comment'],
				'total_like' => $aVideo['total_like'],
				'feed_link' => Phpfox::permalink('video', $aVideo['video_id'], $aVideo['title']),
				'feed_title' => $aVideo['title'],
				'feed_display' => 'view',
				'feed_total_like' => $aVideo['total_like'],
				'report_module' => 'video',
				'report_phrase' => Phpfox::getPhrase('video.report_this_video')
			)
		);	
		
		if (!empty($aVideo['module_id']) && $aVideo['module_id'] != 'video')
		{			
			if ($aCallback = Phpfox::callback($aVideo['module_id'] . '.getVideoDetails', $aVideo))
			{
				$this->template()->setBreadcrumb($aCallback['breadcrumb_title'], $aCallback['breadcrumb_home']);
				$this->template()->setBreadcrumb($aCallback['title'], $aCallback['url_home']);
				if ($aVideo['module_id'] == 'pages' && !Phpfox::getService('pages')->hasPerm($aCallback['item_id'], 'video.view_browse_videos'))
				{
					return Phpfox_Error::display(Phpfox::getPhrase('video.unable_to_view_this_item_due_to_privacy_settings'));
				}		
			}
		}		
		if (Phpfox::isModule('rate'))
		{
			$this->template()->setPhrase(array(
					'rate.thanks_for_rating'			
				)
			);
		}
		
		$bCanDeleteVideo = ($aVideo['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('video.can_delete_own_video')) || Phpfox::getUserParam('video.can_delete_other_video');
		$bCanEditVideo = ($aVideo['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('video.can_edit_own_video')) || Phpfox::getUserParam('video.can_edit_other_video');

		if (Phpfox::getParam('video.upload_for_html5') && !$aVideo['in_process'])
		{
			$aVideo['embed'] = htmlspecialchars('<iframe src="' . Phpfox::getLib('url')->makeUrl('video.play', array($aVideo['video_id'])) . '" width="640" height="390" frameborder="0"></iframe>');
		}

		$this->template()->setTitle($aVideo['title'])
			->setTitle(Phpfox::getPhrase('video.videos'))
			->setBreadcrumb(Phpfox::getPhrase('video.videos'), ($aCallback === false ? $this->url()->makeUrl('video') : $aCallback['url_home_photo']))
			->setBreadcrumb($aVideo['title'], $this->url()->permalink('video', $aVideo['video_id'], $aVideo['title']), true)
			->setMeta('description', $aVideo['title'] . '.' . (!empty($aVideo['text']) ? $aVideo['text'] : ''))
			->setMeta('keywords', $this->template()->getKeywords($aVideo['title']))			
			->setHeader('cache', array(
					'video.js' => 'module_video',
					'jquery.rating.css' => 'style_css',
					'jquery/plugin/star/jquery.rating.js' => 'static_script',
					'jquery/plugin/jquery.highlightFade.js' => 'static_script',
					'rate.js' => 'module_rate',
					'jquery/plugin/jquery.scrollTo.js' => 'static_script',
					'quick_edit.js' => 'static_script',
					'comment.css' => 'style_css',
					'pager.css' => 'style_css',
					'switch_legend.js' => 'static_script',
					'switch_menu.js' => 'static_script',
					'video.css' => 'module_video',
					'view.css' => 'module_video',
					'feed.js' => 'module_feed'
				)
			)
			->setEditor(array(
					'load' => 'simple'
				)
			)
			->assign(array(
					'aVideo' => $aVideo,
					'bCanDeleteVideo' => $bCanDeleteVideo,
					'bCanEditVideo' => $bCanEditVideo,
					'sMicroPropType' => 'VideoObject',
					'sVideoUrlAuth' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http')
				)
			);
			
			(($sPlugin = Phpfox_Plugin::get('video.component_controller_view_end')) ? eval($sPlugin) : false);
			
			if (isset($sImagePath))
			{
				$this->template()->assign('sImageProp', $sImagePath);
			}
			
			if (Phpfox::isModule('rate'))
			{
				$this->template()->setHeader(array(
						'<script type="text/javascript">$Behavior.rateVideo = function() { $Core.rate.init({module: \'video\', display: ' . ($aVideo['has_rated'] ? 'false' : ($aVideo['user_id'] == Phpfox::getUserId() ? 'false' : 'true')) . ', error_message: \'' . ($aVideo['has_rated'] ? Phpfox::getPhrase('video.you_have_already_voted', array('phpfox_squote' => true)) : Phpfox::getPhrase('video.you_cannot_rate_your_own_video', array('phpfox_squote' => true))) . '\'}); }</script>'						
					)
				);			
			}			
			
			if (!$aVideo['is_stream'])
			{
				$sVideoPath = (preg_match("/\{file\/videos\/(.*)\/(.*)\.flv\}/i", $aVideo['destination'], $aMatches) ? Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]) : Phpfox::getParam('video.url') . $aVideo['destination']);
				if (Phpfox::getParam('core.allow_cdn') && !empty($aVideo['server_id']))
				{
					//$sVideoPath = Phpfox::getLib('cdn')->getUrl($sVideoPath);
					$sTempVideoPath = Phpfox::getLib('cdn')->getUrl($sVideoPath, $aVideo['server_id']);
					if (!empty($sTempVideoPath))
					{
						$sVideoPath = $sTempVideoPath; 
						if (Phpfox::getParam('core.enable_amazon_expire_urls') && Phpfox::getParam('core.amazon_s3_expire_url_timeout') > 0)
						{ 
						    $sVideoPath = preg_replace('/?.+/', '', $sVideoPath); 
						} 
					}
				}

				if (Phpfox::getParam('video.upload_for_html5'))
				{
					$bIsOldVideo = false;
					$sVideoDirPath = Phpfox::getParam('video.dir') . str_replace('.flv', '.mp4', $aVideo['destination']);
					if (Phpfox::getParam('core.allow_cdn') && !empty($aVideo['server_id']))
					{

					}
					else
					{
						if (!file_exists($sVideoDirPath) && !$aVideo['custom_v_id'])
						{
							$bIsOldVideo = true;
						}
					}

					if ($bIsOldVideo)
					{
						$this->template()->setHeader('<script type="text/javascript">oParams[\'bUseHTML5Video\'] = false;</script>');
					}
				}

				(($sPlugin = Phpfox_Plugin::get('video.component_controller_view_video_path')) ? eval($sPlugin) : false);

				if ($aVideo['custom_v_id'] && !$aVideo['in_process'])
				{
					preg_match('/\{([0-9]+)\}(.*)/i', $sVideoPath, $aMatches);
					$iCnt = 0;
					$sCustomUrl = '';
					foreach (Phpfox::getParam('video.convert_servers') as $sServer)
					{
						$iCnt++;
						if ($iCnt === (int) $aMatches[1])
						{
							$sCustomUrl = $sServer;
							break;	
						}
					}
					
					$sVideoPath = $sCustomUrl . 'view/' . $aMatches[2] . '.flv';
				}
								
				$sJsMobile = '';
				if (Phpfox::isMobile())
				{
					
                                        if (Phpfox::getParam('video.upload_for_html5'))
                                        {
                                            $sJsMobile = "
                                                    var iVideoPageWidth = $('#js_video_outer_body').width();
                                                    $('video').width(iVideoPageWidth).height(iVideoPageWidth/2);
                                                    $('#js_video_player').width(iVideoPageWidth).height(iVideoPageWidth/2);
                                            ";
                                        }
                                        else
                                        {
                                            $sJsMobile = "
                                                    var iVideoPageWidth = $('#js_video_outer_body').width();
                                                    $('#js_video_player').width(iVideoPageWidth).height(iVideoPageWidth/2);
                                            ";
                                        }
				}
				
				$this->template()->setHeader(array(
						'player/flowplayer/flowplayer.js' => 'static_script',
						'player/' . Phpfox::getParam('core.default_music_player') . '/core.js' => 'static_script',
						'<script type="text/javascript">var iPlayVideo' . $aVideo['video_id'] . ' = false; $Behavior.playVideo = function() { if (iPlayVideo' . $aVideo['video_id'] . ') { return; } iPlayVideo' . $aVideo['video_id'] . ' = true; $Core.player.load({id: \'js_video_player\', auto: true, type: \'video\', play: \'' . $sVideoPath . '\'}); ' . $sJsMobile . ' }</script>'
					)
				);
			}
			
			// Youtube iframe is too big for some devices. This fixes it.
			$sJsMobile = '';
			if (Phpfox::isMobile())
			{
				if($aVideo['is_stream'] && isset($aVideo['youtube_video_url']))
				{
					$sJsMobile = "var iVideoPageWidth = $('#js_video_outer_body').width();
							$('#js_video_outer_body .t_center iframe').width(iVideoPageWidth).height(iVideoPageWidth/2);
					";

					$this->template()->setHeader(array(
							'<script type="text/javascript">$Behavior.playVideo = function() { ' . $sJsMobile . ' };</script>'
						)
					);
				}
			}
			
			if (isset($aVideo['breadcrumb']) && is_array($aVideo['breadcrumb']))
			{
				foreach ($aVideo['breadcrumb'] as $aParentCategory)
				{
					if (isset($aParentCategory[0]))
					{
						$this->template()->setMeta('description', $aParentCategory[0]);
						$this->template()->setMeta('keywords', $this->template()->getKeywords($aParentCategory[0]));
					}
				}
			}	

			if ((Phpfox::getParam('video.vidly_support') || Phpfox::getParam('video.convert_servers_enable')) && $aVideo['in_process'] == '1')
			{
				$this->template()->setHeader('<script type="text/javascript">$Behavior.checkOnVideoDone = function(){setInterval("$.ajaxCall(\'video.checkOnVideoDone\', \'video_id=' . $aVideo['video_id'] . '\', \'GET\');", 5000);}</script>');
			}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>
