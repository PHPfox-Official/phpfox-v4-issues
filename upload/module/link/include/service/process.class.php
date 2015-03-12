<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Service
 * @version 		$Id: process.class.php 6496 2013-08-23 11:34:09Z Fern $
 */
class Link_Service_Process extends Phpfox_Service 
{
	private $_iLinkId = 0;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('link');	
	}
	
	public function add($aVals, $bIsCustom = false, $aCallback = null)
	{
		if (!defined('PHPFOX_FORCE_IFRAME'))
		{
			define('PHPFOX_FORCE_IFRAME', true);
		}
		
		if (empty($aVals['privacy_comment']))
		{
			$aVals['privacy_comment'] = 0;
		}	

		if (empty($aVals['privacy']))
		{
			$aVals['privacy'] = 0;
		}			
		
		$iId = $this->database()->insert($this->_sTable, array(
				'user_id' => Phpfox::getUserId(),
				'is_custom' => ($bIsCustom ? '1' : '0'),
				'module_id' => ($aCallback === null ? null : $aCallback['module']),
				'item_id' => ($aCallback === null ? 0 : $aCallback['item_id']),
				'parent_user_id' => (isset($aVals['parent_user_id']) ? (int) $aVals['parent_user_id'] : 0),
				'link' => $this->preParse()->clean($aVals['link']['url'], 255),
				'image' => ((isset($aVals['link']['image_hide']) && $aVals['link']['image_hide'] == '1') || !isset($aVals['link']['image'])? null : $this->preParse()->clean($aVals['link']['image'], 255)),
				'title' => (isset($aVals['link']['title']) ?  $this->preParse()->clean($aVals['link']['title'], 255) : ''),
				'description' => isset($aVals['link']['description']) ? $this->preParse()->clean($aVals['link']['description'], 200) : '',
				'status_info' => (empty($aVals['status_info']) ? null : $this->preParse()->prepare($aVals['status_info'])),
				'privacy' => (int) $aVals['privacy'],
				'privacy_comment' => (int) $aVals['privacy_comment'],
				'time_stamp' => PHPFOX_TIME,
				'has_embed' => (empty($aVals['link']['embed_code']) ? '0' : '1')
			)
		);

		if (!empty($aVals['link']['embed_code']))
		{
			$this->database()->insert(Phpfox::getT('link_embed'), array(
					'link_id' => $iId,
					'embed_code' => $this->preParse()->prepare($aVals['link']['embed_code'])
				)
			);
		}
		
		if ($aCallback === null && isset($aVals['parent_user_id']) && $aVals['parent_user_id'] != Phpfox::getUserId())
		{
			$aUser = $this->database()->select('user_name')
				->from(Phpfox::getT('user'))
				->where('user_id = ' . (int) $aVals['parent_user_id'])
				->execute('getRow');			
			
			$sLink = Phpfox::getLib('url')->makeUrl($aUser['user_name'], array('plink-id' => $iId));
			
			Phpfox::getLib('mail')->to($aVals['parent_user_id'])
				->subject(array('link.full_name_posted_a_link_on_your_wall', array('full_name' => Phpfox::getUserBy('full_name'))))
				->message(array('link.full_name_posted_a_link_on_your_wall_message', array('full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink)))
				->notification('comment.add_new_comment')
				->send();
			
			if (Phpfox::isModule('notification'))
			{
				Phpfox::getService('notification.process')->add('feed_comment_link', $iId, $aVals['parent_user_id']);		
			}			
		}
		
		$this->_iLinkId = $iId;
		
		return ($bIsCustom ? $iId : Phpfox::getService('feed.process')->callback($aCallback)->add('link', $iId, $aVals['privacy'], $aVals['privacy_comment'], (isset($aVals['parent_user_id']) ? (int) $aVals['parent_user_id'] : 0)));
	}
	
	public function getInsertId()
	{
		return (int) $this->_iLinkId;
	}
	
	public function delete($iId)
	{
		$aLink = $this->database()->select('l.*, a.*')
			->from(Phpfox::getT('link'), 'l')
			->join(Phpfox::getT('attachment'), 'a', 'a.link_id = l.link_id')
			->where('l.link_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		if (!isset($aLink['link_id']))
		{
			return false;
		}
		
		if ((Phpfox::getUserParam('attachment.delete_own_attachment') && $aLink['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('attachment.delete_user_attachment'))
		{
			$this->database()->delete(Phpfox::getT('link'), 'link_id = ' . (int) $aLink['link_id']);
			Phpfox::getService('attachment.process')->updateItemCount($aLink['category_id'], $aLink['attachment_id'], '-');			
                        
                        if(!empty($aLink['attachment_id']))
                        {
                            $this->database()->delete(Phpfox::getT('attachment'), 'attachment_id = ' . (int) $aLink['attachment_id']);
                        }
		}
		
		return false;
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
		if ($sPlugin = Phpfox_Plugin::get('link.service_process__call'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>