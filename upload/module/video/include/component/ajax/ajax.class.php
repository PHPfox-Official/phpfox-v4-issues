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
 * @package  		Module_Video
 * @version 		$Id: ajax.class.php 7072 2014-01-27 18:45:30Z Fern $
 */
class Video_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function newUploadComplete()
	{			
		Phpfox::isUser(true);
		
		$bCanAddVideo = false;
		$aServer = $this->get('_v');
		$aVideoServers = Phpfox::getParam('video.convert_servers');
		foreach ($aVideoServers as $sServer)
		{
			if (md5($sServer) == $aServer['url'])
			{
				$mReturn = json_decode(Phpfox::getLib('request')->send($sServer, array('action' => 'check', '_v_id' => $aServer['id'], '_v_secret' => Phpfox::getParam('video.convert_servers_secret'))));
				if (!$mReturn->error)
				{
					$bCanAddVideo = true;
					break;
				}
			}
		}
		
		if ($bCanAddVideo)
		{
			$aVals = $this->get('val');
			$aVideo = $this->get('video');
			if (($iId = Phpfox::getService('video.process')->add($aVals, $aVideo)) !== false)
			{
				$aVideo = Phpfox::getService('video')->getForEdit($iId, true);
				
				Phpfox::getLib('database')->update(Phpfox::getT('video'), array('custom_v_id' => $aServer['id']), 'video_id = ' . (int) $aVideo['video_id']);
				
				$this->call('window.location.href = \'' . Phpfox::permalink('video', $aVideo['video_id'], $aVideo['title']) . '\';');
			}
		}
	}
	
	public function checkOnVideoDone()
	{
		if (($aVideo = Phpfox::getService('video')->isNewVideoDone($this->get('video_id'))))
		{
			$this->call('window.location.href = \'' . Phpfox::permalink('video', $aVideo['video_id'], $aVideo['title']) . '\';');
		}
	}
	
	public function checkOnVideo()
	{		
		/*
		if (($aVidlyVideo = Phpfox::getService('video')->isVidlyDone()))
		{
			$iId = Phpfox::getService('video.process')->add($_POST['val'], $aVidlyVideo);
			
			$aVideo = Phpfox::getService('video')->getVideo($iId, true);
			
			Phpfox::getService('video.process')->vidlyAdd($aVideo, $aVidlyVideo);
			
			$this->call('window.location.href = \'' . Phpfox::permalink('video', $aVideo['video_id'], $aVideo['title']) . '\'');
		}
		 * 
		 */
	}
	
	public function addShare()
	{
		$this->errorSet('#js_video_error');
		
		if (($aVals = $this->get('val')))
		{
			if (Phpfox::getService('video.grab')->get($aVals['url']))
			{			
				if ($iId = Phpfox::getService('video.process')->addShareVideo($aVals, true))
				{
					$this->call('Editor.insert({type: \'video\', id: \'' . (int) $iId . '\', editor_id: \'' . $this->get('editor_id') . '\'});');
					$this->setMessage(Phpfox::getPhrase('video.video_successfully_added'));
					
					return;
				}
			}
		}
	}
	
	public function deleteImage()
	{
		Phpfox::isUser(true);
		
		if (Phpfox::getService('video.process')->deleteImage($this->get('id')))
		{
			
		}
	}

	public function process()
	{
		exit();
		
		$this->errorSet('#js_video_upload_message');
		$sModule = $this->get('module', null);
		$iItem = $this->get('item', null);

		$sMethod = Phpfox::getParam('video.video_enable_mass_uploader') && ($this->get('method','default') == 'massuploader');
		
		if ($iId = Phpfox::getService('video.process')->process($this->get('video_id'), $sModule, $iItem))
		{
			$aVideo = Phpfox::getService('video')->getVideo($this->get('video_id'), true);
			
			$this->call('window.location.href = \'' . Phpfox::permalink('video', $aVideo['video_id'], $aVideo['title']) . '\';');
		}
		else 
		{
			$this->show('#js_video_upload_error');
		}
	}
	
	public function update()
	{
		$aVals = $this->get('val');
		
		if (!isset($aVals['video_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('video.unable_to_edit_this_video_as_there_is_no_video_id'));
		}		

		Phpfox::getService('ban')->checkAutomaticBan($aVals['title'] . ' ' . $aVals['text'] . ' ' . $aVals['tag_list']);
		if ($mReturn = Phpfox::getService('video.process')->update($aVals['video_id'], $aVals))
		{			
			if (!is_bool($mReturn))
			{
				$aVideo = Phpfox::getService('video')->getVideo($aVals['video_id'], true);
				
				$this->attr('#js_view_video_link', 'href', ($aVideo['module_id'] != 'video' ? Phpfox::getLib('url')->makeUrl('video', array('redirect' => $aVideo['video_id'])) : Phpfox::getService('video')->makeUrl(Phpfox::getUserBy('user_name'), $mReturn)));
			}
			
			$this->show('#js_save_video')->html('#js_save_video', '<span class="valid_message">'.Phpfox::getPhrase('video.done').'</span>', '.fadeOut(5000)');
		}
		else 
		{
			$this->html('#js_save_video', '');
		}
		
		$this->attr('#js_save_button', 'disabled', false)
			->removeClass('#js_save_button', 'disabled');
	}
	
	public function edit()
	{
		Phpfox::isUser(true);
		
		if (Phpfox::getService('user.auth')->hasAccess('video', 'video_id', $this->get('video_id'), 'video.can_edit_own_video', 'video.can_edit_other_video'))
		{		
			$aVideo = Phpfox::getService('video')->getForEdit($this->get('video_id'));

			echo '<div><input type="hidden" name="val[video_id]" value="' . $aVideo['video_id'] . '" /></div>';
			echo '<div><input type="hidden" name="val[user_name]" value="' . $aVideo['user_name'] . '" /></div>';
			$this->template()->assign(array(
						'aForms' => $aVideo,
						'sCategories' => Phpfox::getService('video.category')->get(),
						'sModule' => isset($aVideo['module_id']) ? $aVideo['module_id'] : ''
					)
				)		
				->getTemplate('video.block.form');

			$this->html('#js_video_edit_form', $this->getContent(false))
				->show('#js_video_edit_form_outer')
				->attr('#js_video_go_advanced', 'href', Phpfox::getLib('url')->makeUrl('video.edit', array('id' => $aVideo['video_id'])))
				->hide('#js_video_outer_body')
				->call('$Core.loadInit();')
				->call('var aCategories = explode(\',\', \'' . $aVideo['categories'] . '\'); for (i in aCategories) { $(\'#js_mp_holder_\' + aCategories[i]).show(); $(\'#js_mp_category_item_\' + aCategories[i]).attr(\'selected\', true); }');
		}
	}
	
	public function viewUpdate()
	{
		$aVals = $this->get('val');
		
		if (!isset($aVals['video_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('video.unable_to_edit_this_video_as_there_is_no_video_id'));
		}		
		
		if ($mReturn = Phpfox::getService('video.process')->update($aVals['video_id'], $aVals))
		{
			$oParseInput = Phpfox::getLib('parse.input');
			$oParseOutput = Phpfox::getLib('parse.output');
			
			if (isset($aVals['is_inline']))
			{
				$aVideo = Phpfox::getService('video')->getForEdit($aVals['video_id']);
				
				$this->call('window.location.href = \'' . $aVideo['video_url'] . '\';');
				
				return;
			}
			
			if (!is_bool($mReturn))
			{
				$this->attr('.js_video_title_' . $aVals['video_id'], 'href', Phpfox::getService('video')->makeUrl($aVals['user_name'], $mReturn));
			}			
			
			$this->hide('#js_video_edit_form_outer')
				->html('#js_video_title_' . $aVals['video_id'], $oParseOutput->clean($oParseInput->clean($aVals['title'])))
				->html('#js_video_text_' . $aVals['video_id'], (empty($aVals['text']) ? '' : $oParseOutput->parse($oParseInput->prepare($aVals['text']))))
				->show('#js_video_outer_body');
		}					
	}
	
	public function delete()
	{
		if (Phpfox::getService('video.process')->delete($this->get('video_id')))
		{
			$this->remove('#js_video_id_' . $this->get('video_id'));	
		}
	}
	
	public function add()
	{
		$aParam = array();
		if ($this->get('bIsGroup'))
		{
			$aParam['bIsGroup'] = true;
		}
		if (!Phpfox::getParam('video.allow_video_uploading') || !Phpfox::getUserParam('video.can_upload_videos'))
		{
			Phpfox::getComponent('video.share', $aParam, 'controller');
		}
		else 
		{
			Phpfox::getComponent('video.upload', $aParam, 'controller');
		}
		
		echo $this->template()->getHeader();
		
		echo '<script type="text/javascript">$Core.loadInit();</script>';
	}
	
	public function upload()
	{		
		Phpfox::getComponent('video.upload', array('bHideSwitchMenu' => true), 'controller');	
		
		echo $this->template()->getHeader();
		
		echo '<script type="text/javascript">$Core.loadInit();</script>';	
		
		$this->html('#js_video_content', $this->getContent(false));
	}
	
	public function share()
	{
		Phpfox::getComponent('video.share', array(), 'controller');		
		
		echo $this->template()->getHeader();
		
		echo '<script type="text/javascript">$Core.loadInit();</script>';	
		
		$this->html('#js_video_content', $this->getContent(false));
	}
	
	public function getNew()
	{
		Phpfox::getBlock('video.new');
		
		$this->html('#' . $this->get('id'), $this->getContent(false));
		$this->call('$(\'#' . $this->get('id') . '\').parents(\'.block:first\').find(\'.bottom li a\').attr(\'href\', \'' . Phpfox::getLib('url')->makeUrl('video') . '\');');
	}
	
	public function feature()
	{
		if (Phpfox::getService('video.process')->feature($this->get('video_id'), $this->get('type')))
		{
			
		}
	}
	
	public function spotlight()
	{
		if (Phpfox::getService('video.process')->spotlight($this->get('video_id'), $this->get('type')))
		{
			
		}		
	}

	public function sponsor()
	{
	    Phpfox::getUserParam('video.can_sponsor_video', true);
	    if (Phpfox::getService('video.process')->sponsor($this->get('video_id'), $this->get('type')))
	    {
		if ($this->get('type') == '1')
		{
		    Phpfox::getService('ad.process')->addSponsor(array('module' => 'video', 'section' => '', 'item_id' => $this->get('video_id')));
		    // image was sponsored
		    $sHtml = '<a href="#" title="' . Phpfox::getPhrase('video.unsponsor_this_video') . '" onclick="$.ajaxCall(\'video.sponsor\', \'video_id=' . $this->get('video_id') . '&amp;type=0\'); return false;">' . Phpfox::getPhrase('video.un_sponsor') . '</a>';
		}
		else
		{
		    Phpfox::getService('ad.process')->deleteAdminSponsor('video', $this->get('video_id'));
		    $sHtml = '<a href="#" title="' . Phpfox::getPhrase('video.sponsor_this_video') . '" onclick="$.ajaxCall(\'video.sponsor\', \'video_id=' . $this->get('video_id') . '&amp;type=1\'); return false;">' . Phpfox::getPhrase('video.sponsor') . '</a>';
		}
		$this->html('#js_video_sponsor_' . $this->get('video_id'), $sHtml)
			->alert($this->get('type') == '1' ? Phpfox::getPhrase('video.video_successfully_sponsored') : Phpfox::getPhrase('video.video_successfully_un_sponsored'));
		if($this->get('type') == '1')
		{
		    $this->addClass('#js_video_id_' . $this->get('video_id'), 'row_sponsored_image');
			$this->call("$('#js_video_id_" . $this->get('video_id') . "').find('.row_sponsored_link:first').show();");
		}
		else
		{
			$this->call("$('#js_video_id_" . $this->get('video_id') . "').find('.row_sponsored_link:first').hide();");
		    $this->removeClass('#js_video_id_' . $this->get('video_id'), 'row_sponsored_image');
		}
	    }
	}
	
	public function approve()
	{
		if (Phpfox::getService('video.process')->approve($this->get('video_id')))
		{
			if ($this->get('inline'))
			{
				$this->alert(Phpfox::getPhrase('video.video_has_been_approved'), Phpfox::getPhrase('video.video_approved'), 300, 100, true);
				$this->hide('#js_item_bar_approve_image');
				$this->hide('.js_moderation_off'); 
				$this->show('.js_moderation_on');				
			}
		}
	}
	
	public function convert()
	{
		Phpfox::isUser(true);
		
		if (Phpfox::getService('video.convert')->process($this->get('attachment_id'), (($this->get('full') || $this->get('inline'))? false : true)))
		{
			if ($this->get('full'))
			{
				$aVideo = Phpfox::getService('video')->getVideo($this->get('attachment_id'), true);
				
				$this->call('window.location.href = \'' . Phpfox::permalink('video', $aVideo['video_id'], $aVideo['title']) . '\';');				
			}
			elseif ($this->get('inline'))
			{
				$iFeedId = Phpfox::getService('feed.process')->getLastId();
				
				(($sPlugin = Phpfox_Plugin::get('video.component_ajax_convert_feed')) ? eval($sPlugin) : false);
				
		    	$this->call('window.parent.$.ajaxCall(\'video.displayFeed\', \'id=' . $iFeedId . '&video_id=' . $this->get('attachment_id') . '&custom_pages_post_as_page=' . $this->get('custom_pages_post_as_page') . '\', \'GET\');');				
			}
			else 
			{
				$aVideo = Phpfox::getService('video.convert')->getDetails();		
				Phpfox::getService('attachment.process')->update(array(
						'destination' => $aVideo['destination'],
						'extension' => $aVideo['extension'],
						'is_video' => '1',
						'video_duration' => $aVideo['duration']
					), $this->get('attachment_id')
				);						
				/*				
				$aVideo = Phpfox::getService('video.convert')->getDetails();
				Phpfox::getService('attachment.process')->update(array(
						'destination' => $aVideo['destination'],
						'extension' => $aVideo['extension'],
						'is_video' => '1',
						'video_duration' => $aVideo['duration']
					), $this->get('attachment_id')
				);
				
				Phpfox::getBlock('attachment.list', array('sIds' => $this->get('attachment_id'), 'bCanUseInline' => true, 'attachment_no_header' => true, 'attachment_edit' => true));
	
				$this->call('var $oParent = window.parent.$(\'#' . $this->get('attachment_obj_id') . '\');')
					->call('$oParent.find(\'.js_attachment:first\').val($oParent.find(\'.js_attachment:first\').val() + \'' . $this->get('attachment_id') . ',\');')
					->call('$oParent.find(\'.js_attachment_list:first\').show();')
					->call('$oParent.find(\'.js_attachment_list_holder:first\').prepend(\'' . $this->getContent() . '\');')				
					->call('$Core.loadInit();');	

				// $this->call('Editor.insert({is_image: true, name: \'\', id: \'' . $aVideo['video_id'] . '\', type: \'video\'});');
				*/
				$this->call('Editor.insert({id: \'' . $aVideo['video_id'] . '\', type: \'attachment\', name: \'\'});');
				
				if ($this->get('attachment_inline'))
				{
					$this->call('$Core.clearInlineBox();');
				}
				else
				{
					$this->call('tb_remove();');
				}			
			}
		}
		else 
		{
			$this->alert(implode('<br />', Phpfox_Error::get()));
		}
	}
	
	public function play()
	{
		$aVideo = Phpfox::getService('video')->getVideo($this->get('id'));
		
		if ($aVideo['is_stream'])
		{
			$sEmbedCode = $aVideo['embed_code'];
			if ($this->get('popup'))
			{
				$this->setTitle($aVideo['title']);
				echo '<div class="t_center">';
				echo $sEmbedCode;
				echo '</div>';
			}
			elseif ($this->get('feed_id'))
			{
				$this->call('$(\'#js_item_feed_' . $this->get('feed_id') . '\').find(\'.activity_feed_content_link:first\').html(\'' . str_replace("'", "\\'", $sEmbedCode) . '\');');
			}
			else 
			{
				$this->html('#js_global_link_id_' . $this->get('id'), str_replace("'", "\\'", $sEmbedCode));
			}				
		}
		else
		{
			$sVideoPath = (preg_match("/\{file\/videos\/(.*)\/(.*)\.flv\}/i", $aVideo['destination'], $aMatches) ? Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]) : Phpfox::getParam('video.url') . $aVideo['destination']);
			if (Phpfox::getParam('core.allow_cdn') && !empty($aVideo['server_id']))
			{
				$sVideoPath = Phpfox::getLib('cdn')->getUrl($sVideoPath, $aVideo['server_id']);	
			}

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

			$sDivId = 'js_tmp_video_player_' . $aVideo['video_id'];
			if ($this->get('popup'))
			{
				$this->setTitle($aVideo['title']);
				if (Phpfox::getParam('video.vidly_support') && !empty($aVideo['vidly_url_id']))
				{
					echo '<iframe frameborder="0" width="640" height="390" name="vidly-frame" src="http://s.vid.ly/embeded.html?link=' . $aVideo['vidly_url_id'] . '&amp;width=640&amp;height=390&autoplay=false"></iframe>';
				}
				else
				{
					$this->call('<script type="text/javascript">$Core.loadStaticFile(\'' . $this->template()->getStyle('static_script', 'player/' . Phpfox::getParam('core.default_music_player') . '/core.js') . '\');</script>');
					echo '<div class="t_center">';
					echo '<div id="' . $sDivId . '" style="width:640px; height:390px; margin:auto;"></div>';
					echo '</div>';
					$this->call('<script type="text/javascript">$Core.player.load({id: \'' . $sDivId . '\', auto: true, type: \'video\', play: \'' . $sVideoPath . '\'});</script>');
				}
			}
			else
			{
				$this->call('$Core.loadStaticFile(\'' . $this->template()->getStyle('static_script', 'player/' . Phpfox::getParam('core.default_music_player') . '/core.js') . '\');');
				$this->call('$(\'#js_item_feed_' . $this->get('feed_id') . '\').find(\'.activity_feed_content_link:first\').html(\'<div id="' . $sDivId . '" style="width:425px; height:349px;"></div>\');');
				$this->call('$Core.player.load({id: \'' . $sDivId . '\', auto: true, type: \'video\', play: \'' . $sVideoPath . '\'});');
			}
		}
	}
	
	public function getUserVideos()
	{
		Phpfox::getBlock('video.user');
		
		$this->html('.video_user_bar', $this->getContent(false));
		$this->call('$Core.loadInit();');
	}
	
	public function getMoreRelated()
	{		
		Phpfox::getBlock('video.related');
		
		$sContent = $this->getContent(false);
		
		if (Phpfox::getLib('parse.format')->isEmpty($sContent))
		{
			$this->remove('#js_block_bottom_link_1')->html('#js_block_bottom_1', Phpfox::getPhrase('video.span_no_more_suggestions_found_span'));	
		}
		else
		{
			$this->val('#js_video_related_page_number', ((int) $this->get('page_number') + 1));
			$this->append('#js_video_related_load_more', $sContent);
		}
		
		$this->call('$(\'#js_block_bottom_1\').find(\'.ajax_image\').hide();');
	}
	
	public function moderation()
	{
		Phpfox::isUser(true);	
		
		switch ($this->get('action'))
		{
			case 'approve':
				Phpfox::getUserParam('video.can_approve_videos', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('video.process')->approve($iId);
					$this->call('$(\'#js_video_id_' . $iId . '\').remove();');					
				}				
				$this->updateCount();
				$sMessage = Phpfox::getPhrase('video.video_s_successfully_approved');
				break;			
			case 'delete':
				Phpfox::getUserParam('video.can_delete_other_video', true);
				foreach ((array) $this->get('item_moderate') as $iId)
				{
					Phpfox::getService('video.process')->delete($iId);
					$this->slideUp('#js_video_id_' . $iId);
				}				
				$sMessage = Phpfox::getPhrase('video.video_s_successfully_deleted');
				break;
		}
		
		$this->alert($sMessage, 'Moderation', 300, 150, true);
		$this->hide('.moderation_process');			
	}

	public function displayFeed()
	{
 		$aVideo = Phpfox::getService('video')->getForEdit($this->get('video_id'), true);
		
		$aCallback = null;
		if ($aVideo['module_id'] != 'video' && Phpfox::hasCallback($aVideo['module_id'], 'convertVideo'))
		{
			$aCallback = Phpfox::callback($aVideo['module_id'] . '.convertVideo', $aVideo);	
		}	 		

		Phpfox::getService('feed')->callback($aCallback)->processAjax($this->get('id'));
	}
	
	public function supportedSites()
	{
		$this->setTitle(Phpfox::getPhrase('video.supported_sites'));
		Phpfox::getBlock('video.supported');
	}
}

?>
