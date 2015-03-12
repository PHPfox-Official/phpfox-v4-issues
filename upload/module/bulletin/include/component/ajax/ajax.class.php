<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Bulletin
 * @version 		$Id: ajax.class.php 1599 2010-05-28 04:31:26Z Raymond_Benc $
 */
class Bulletin_Component_Ajax_Ajax extends Phpfox_Ajax
{
	/**
	 * Shows a simple preview of the currently editing bulletin
	 *
	 */
	public function preview()
	{
		Phpfox::getBlock('bulletin.preview', array('sText' => $this->get('text')));
	}
	
	/**
	 * Sends an internal mail to the author of the bulletin
	 *
	 */
	public function sendMessage()
	{
		$iBulletin = (int)$this->get('bId');
		$sUsername = Phpfox::getLib('parse.input')->prepare($this->get('username'));
		$sMessage = Phpfox::getLib('parse.input')->prepare($this->get('message'));
		
		$aVals = array(
			'to' => $sUsername,
			'subject' => Phpfox::getPhrase('bulletin.reply_to_bulletin') . ': ' . $sBulletinTitle,
			'message' => $sMessage			
		);
		Phpfox::getService('mail.process')->add($aVals);
		$this->call("$('#js_bulletin_process').html('" . Phpfox::getPhrase('bulletin.message_sent', array('phpfox_squote' => true)) . "');$('#reply_zone').fadeOut();");
	}
	
	/**
	 * Deletes a bulletin the ajax way
	 *
	 */
	public function delete()
	{
			// security checks
		// can the user delete this post
		$bCanDelete = (Phpfox::getUserParam('bulletin.bulletin_can_delete_own') && Phpfox::getUserId() == $this->get('user_id'));
		$bCanDelete = $bCanDelete || Phpfox::getUserParam('bulletin.bulletin_can_delete_others');
		
		if ($bCanDelete && Phpfox::getService('bulletin.process')->delete($this->get('id')))
		{			
			// message about the deletion
			$this->call('$("#bulletin_' . $this->get('id') . '").fadeOut(3000);');
			$this->call('$("#bulletin_header_' . $this->get('id') . '").html("Bulletin deleted").fadeOut(3000);');
			
			// fix the pager
			//$this->call('alert($("#js_display_to").html());')
			$this->call('if(parseInt($(".js_display_to").html()) > 1){$(".js_display_to").html(""+(parseInt($(".js_display_to").html())-1)+"");} else{$(".sJsPagerDisplayCount").html("");}');
			$this->call('$(".js_display_total").html(""+(parseInt($(".js_display_total").html())-1)+"");');
			
		}
		else
		{
			$this->call('$("delete_' . $this->get('id') . '").html("' . Phpfox::getPhrase('bulletin.you_are_not_allowed_to_delete_this_bulletin') . '");');
		}
	}
	
	public function approve()
	{
		Phpfox::getUserParam('bulletin.can_approve_bulletins', true);
		Phpfox::getService('bulletin.process')->approve($this->get('bulletin_id'));			
	}
}

?>