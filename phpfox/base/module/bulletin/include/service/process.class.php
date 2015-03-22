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
 * @version 		$Id: process.class.php 2307 2011-02-21 10:41:43Z Miguel_Espinoza $
 */
class Bulletin_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('bulletin');
	}	
	
	/**
	 * Adds a bulletin
	 *
	 * @param unknown_type $aVals
	 * @return boolean for success
	 */
	public function add($iUserid, $aVals)
	{		
		// Clean the input
		$oFilter = Phpfox::getLib('parse.input');
		// clean the title of the message
		$sTitle = $oFilter->clean($aVals['title'], 255);
		
		$bApprove = (Phpfox::getUserParam('bulletin.approve_bulletins') ? true : false);
		Phpfox::getService('ban')->checkAutomaticBan($aVals['title'] . ' ' . $aVals['text']);
		
		$aInsert = array(
			'view_id' => ($bApprove ? '1' : '0'),
			'user_id' => $iUserid,
			'title' => $sTitle,
			'time_stamp' => PHPFOX_TIME,
			'allow_comment' => 0
		);	
		
		if (isset($aVals['allow_comment']) && Phpfox::isModule('comment') && Phpfox::getParam('bulletin.can_post_comments_on_bulletin') && Phpfox::getUserParam('bulletin.can_control_comments_on_bulletins'))
		{
			$aInsert['allow_comment'] = $aVals['allow_comment'];
		}
		
		// Add the attachments count only if there are any 
		if (isset($aVals['attachment']) && strpos($aVals['attachment'], ','))
		{
			$iAttachmentCount = count(explode(',', rtrim($aVals['attachment'], ',')));
			if ($iAttachmentCount > 0)
			{
				$aInsert['total_attachment'] = $iAttachmentCount;
			}
		}
		
		// Run any plugin prior to the insert
		(($sPlugin = Phpfox_Plugin::get('bulletin.service_process_add_start')) ? eval($sPlugin) : false);

		// do the insert
		$iId = $this->database()->insert(Phpfox::getT('bulletin'), $aInsert);		
		
		// Run any plugin after the insert
		(($sPlugin = Phpfox_Plugin::get('bulletin.service_process_add_end')) ? eval($sPlugin) : false);
		
		// Insert the text in the DB
		$this->database()->insert(Phpfox::getT('bulletin_text'), array(
				'bulletin_id' => $iId,
				'text' => $oFilter->clean($aVals['text']),
				'text_parsed' => $oFilter->prepare($aVals['text'])
			)
		);		
				
		// If we uploaded any attachments make sure we update the 'item_id'
		if (isset($aVals['attachment']) && !empty($aVals['attachment']))
		{
			Phpfox::getService('attachment.process')->updateItemId($aVals['attachment'], $iUserid, $iId);
		}
		
		if (!$bApprove)
		{
			// Update user activity
			Phpfox::getService('user.activity')->update($iUserid, 'bulletin');
			
			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('bulletin', $iId, $sTitle) : null);
		}
		
		// Return the bulletin ID#
		return $iId;
	}
	
	public function approve($iBulletin)
	{
		$aBulletin = $this->database()->select('*')
			->from(Phpfox::getT('bulletin'))
			->where('bulletin_id = ' . (int) $iBulletin)
			->execute('getSlaveRow');
			
		if (!isset($aBulletin['bulletin_id']))
		{
			return false;
		}
		
		Phpfox::getService('user.activity')->update($aBulletin['user_id'], 'bulletin');
			
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('bulletin', $aBulletin['bulletin_id'], $aBulletin['title'], $aBulletin['user_id']) : null);		
	
		$this->database()->update(Phpfox::getT('bulletin'), array('view_id' => '0'), 'bulletin_id = ' . $aBulletin['bulletin_id']);
		
		return true;
	}
	
	/**
	 * Deletes a bulletin
	 *
	 * @param integer $iId the id of the bulletin
	 */
	public function delete($iId, $iUserId)
	{
		$this->database()->delete(Phpfox::getT('bulletin'), "bulletin_id = " . (int) $iId);		
		$this->database()->delete(Phpfox::getT('bulletin_text'), "bulletin_id = " . (int) $iId);
		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('bulletin', $iId) : null);
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('comment_bulletin', $iId) : null);
		(Phpfox::isModule('attachment') ? Phpfox::getService('attachment.process')->deleteForItem($iUserId, $iId, 'bulletin') : null);
		(Phpfox::isModule('comment') ? Phpfox::getService('comment.process')->deleteForItem($iUserId, $iId, 'bulletin') : null);				
		
		// Update user activity
		Phpfox::getService('user.activity')->update($iUserId, 'bulletin', '-');				
		
		(($sPlugin = Phpfox_Plugin::get('bulletin.service_process_delete')) ? eval($sPlugin) : false);
		
		return true;
	}	
	
	public function update($iId, $iUserId, $aBulletin)
	{
		$bHasAttachments = (!empty($aVals['attachment']) && Phpfox::getUserParam('attachment.can_attach_on_blog') && $iUserId == Phpfox::getUserId());
		
		if ($bHasAttachments)
		{
			Phpfox::getService('attachment.process')->updateItemId($aVals['attachment'], $iUserId, $iId);
		}		
		Phpfox::getService('ban')->checkAutomaticBan($aBulletin['title'] . ' ' . $aBulletin['text']);
		$aToUpdateBulletin = array(
			'title' => Phpfox::getLib('parse.input')->clean($aBulletin['title'], 255),
			'total_attachment' => (Phpfox::isModule('attachment') ? Phpfox::getService('attachment')->getCountForItem($iId, 'bulletin') : 0)
		);
		
		$aToUpdateBulletinText = array(
			'text' => Phpfox::getLib('parse.input')->clean($aBulletin['text']),
			'text_parsed' => Phpfox::getLib('parse.input')->prepare($aBulletin['text'])
		);		
		
		$this->database()->update($this->_sTable, $aToUpdateBulletin, 'bulletin_id = ' . (int) $iId);
		$this->database()->update(Phpfox::getT('bulletin_text'), $aToUpdateBulletinText, 'bulletin_id = ' . (int) $iId);
		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->update('bulletin', $iId, Phpfox::getLib('parse.input')->clean($aBulletin['title'], 255)) : null);
		
		return true;
	}
	
	public function updateCounter($iId, $sCounter, $bMinus = false)
	{		
		$this->database()->update($this->_sTable, array(
				$sCounter => array('= ' . $sCounter . ' ' . ($bMinus ? '-' : '+'), 1)
			), 'bulletin_id = ' . (int) $iId
		);
	}	
	
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing 
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('bulletin.service_process__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>