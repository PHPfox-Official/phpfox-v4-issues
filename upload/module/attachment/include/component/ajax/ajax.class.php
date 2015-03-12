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
 * @package  		Module_Attachment
 * @version 		$Id: ajax.class.php 6495 2013-08-23 09:52:29Z Fern $
 */
class Attachment_Component_Ajax_Ajax extends Phpfox_Ajax
{	
	public function upload()
	{
		Phpfox::getBlock('attachment.upload', array(
				'sCategoryId' => $this->get('category_id')
			)
		);
	
		$this->call('$("#js_attachment_content").html("' . $this->getContent() . '");');
		$this->call("$('#swfUploaderContainer').css('top',70).css('z-index',880);");
		$this->call('$Core.loadInit();');
	}
	
	public function add()
	{
		if ($this->get('attachment_custom') == 'photo')
		{
			$this->setTitle(Phpfox::getPhrase('attachment.attach_a_photo'));
		}
		elseif ($this->get('attachment_custom') == 'video')
		{
			$this->setTitle(Phpfox::getPhrase('attachment.attach_a_video'));
		}
		else 
		{
			$this->setTitle(Phpfox::getPhrase('attachment.attach_a_file'));
		}
				
				
		$aParams = array(
				'sAttachments' => $this->get('attachments'),
				'sCategoryId' => $this->get('category_id'),
				'iItemId' => $this->get('item_id'),
				'sAttachmentInput' => $this->get('input')
			);
			
		if ($this->get('input') == 'js_theme_url_body' && Phpfox::getParam('core.csrf_protection_level') == 'high')
		{
			$aParams['bFixToken'] = true;
		}		
		
		Phpfox::getBlock('attachment.add', $aParams);
		
		
	}
	
	public function browse()
	{
		Phpfox::getBlock('attachment.archive', array('sPage' => (int)$this->get('page')));
		// $this->call('swfu.destroy();');
		$this->call('$("#js_attachment_content").html("' . $this->getContent() . '");');
		$this->call("$('#swfUploaderContainer').css('top',0).css('z-index',0);");
		
	}
	
	public function updateDescription()
	{		
		if (($iUserId = Phpfox::getService('attachment')->hasAccess($this->get('iId'), 'delete_own_attachment', 'delete_user_attachment')) && Phpfox::getService('attachment.process')->updateDescription((int) $this->get('iId'), $iUserId, $this->get('info')))
		{
			$this->html('#js_description' . $this->get('iId'), Phpfox::getLib('parse.output')->clean(Phpfox::getLib('parse.input')->clean($this->get('info'))), '.highlightFade()');
		}
	}
	
	public function inline()
	{
		if (Phpfox::getService('attachment.process')->updateInline($this->get('id')))
		{
			
		}
	}
	
	public function inlineRemove()
	{
		if (Phpfox::getService('attachment.process')->updateInline($this->get('id'), true))
		{
			$sTxt = $this->get('text');
			$sTxt = preg_replace('/\[attachment="' . (int) $this->get('id') . ':(.*)"\](.*)\[\/attachment\]/is', '', $sTxt);
			$sTxt = preg_replace('/\[attachment="' . (int) $this->get('id') . '"\](.*)\[\/attachment\]/is', '', $sTxt);
			$sTxt = str_replace("'", "\\'", $sTxt);
			$this->call('Editor.setContent(\'' . $sTxt . '\');');	
		}		
	}

	public function delete()
	{		
		if (($iUserId = Phpfox::getService('attachment')->hasAccess($this->get('id'), 'delete_own_attachment', 'delete_user_attachment')) && is_numeric($iUserId) && Phpfox::getService('attachment.process')->delete($iUserId, $this->get('id')))
		{
			$this->call("$('#js_attachment_id_" . $this->get('id') . "').slideUp();");
                        $this->call("$('.extra_info').show();");
		}
	}
	
	public function updateActivity()
	{		
		if (Phpfox::getService('attachment.process')->updateActivity($this->get('id'), $this->get('active')))
		{
			
		}
	}

	public function addViaLink()
	{
		Phpfox::isUser(true);
		
		$aVals = $this->get('val');
		
		if (Phpfox::getService('link.process')->add($aVals, true))
		{
			$iId = Phpfox::getService('link.process')->getInsertId();
			
			$iAttachmentId = Phpfox::getService('attachment.process')->add(array(
					'category' => $aVals['category_id'],
					'link_id' => $iId
				)
			);			
			
			Phpfox::getBlock('link.display', array(
					'link_id' => $iId
				)
			);
			
			$this->call('var $oParent = $(\'#' . $aVals['attachment_obj_id'] . '\');');
			$this->call('$oParent.find(\'.js_attachment:first\').val($oParent.find(\'.js_attachment:first\').val() + \'' . $iAttachmentId . ',\'); $oParent.find(\'.js_attachment_list:first\').show(); $oParent.find(\'.js_attachment_list_holder:first\').prepend(\'<div class="attachment_row">' . $this->getContent() . '</div>\');');
			if (isset($aVals['attachment_inline']))
			{
				$this->call('$Core.clearInlineBox();');
			}
			else
			{
				$this->call('tb_remove();');
			}
                        
                        $this->call("$('.extra_info').hide();");
		}
	}
	
	public function playVideo()
	{
		$aAttachment = Phpfox::getService('attachment')->getForDownload($this->get('attachment_id'));
		
		$sVideoPath = Phpfox::getParam('core.url_attachment') . $aAttachment['destination'];
		if (Phpfox::getParam('core.allow_cdn') && !empty($aAttachment['server_id']))
		{
			$sVideoPath = Phpfox::getLib('cdn')->getUrl($sVideoPath, $aAttachment['server_id']);	
		}		
		
		$sDivId = 'js_tmp_avideo_player_' . $aAttachment['attachment_id'];
		$this->call('$Core.loadStaticFile(\'' . $this->template()->getStyle('static_script', 'player/' . Phpfox::getParam('core.default_music_player') . '/core.js') . '\');');
		$this->html('#js_attachment_id_' . $this->get('attachment_id') . '', '<div id="' . $sDivId . '" style="width:480px; height:295px;"></div>');
		$this->call('$Core.player.load({id: \'' . $sDivId . '\', auto: true, type: \'video\', play: \'' . $sVideoPath . '\'}); $Core.player.play(\'' . $sDivId . '\', \'' . $sVideoPath . '\');');		
	}
}

?>