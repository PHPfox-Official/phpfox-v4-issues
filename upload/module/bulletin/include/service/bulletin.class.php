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
 * @package  		Module_Bulletin
 * @version 		$Id: bulletin.class.php 1724 2010-08-16 11:14:54Z Miguel_Espinoza $
 */
class Bulletin_Service_Bulletin extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('bulletin');
	}
	
	/**
	 * Gets one bulletin having its id
	 *
	 * @param int $iBul buletin id as defined in bulletin.bulletin_id
	 * @return array
	 */
	public function getBulletin($iBul, $bIsEdit = false)
	{		
		$aRow = $this->database()->select('b.bulletin_id, b.view_id, b.title, b.allow_comment, b.time_stamp, b.total_comment, b.total_attachment, ' . (($bIsEdit === false && Phpfox::getParam('core.allow_html')) ? "bt.text_parsed" : "bt.text") . ' AS text, ' . Phpfox::getUserField())
			->from($this->_sTable,'b')
			->join(Phpfox::getT('bulletin_text'), 'bt', 'bt.bulletin_id = ' . $iBul)
			->join(Phpfox::getT('user'),'u', 'u.user_id = b.user_id')
			->where('b.bulletin_id = ' . (int) $iBul)
			->execute('getSlaveRow');
		
		if (!isset($aRow['bulletin_id']))
		{
			return false;
		}
			
		if ($aRow['user_id'] == Phpfox::getUserId())
		{
			$aRow['posted_on'] = Phpfox::getPhrase('bulletin.you_wrote_on_item_time_stamp', array(
					'link' => Phpfox::getLib('url')->makeUrl('profile'),
					'item_time_stamp' => Phpfox::getTime(Phpfox::getParam('bulletin.bulletin_view_timestamp'), $aRow['time_stamp'])
				)
			);
		}
		else 
		{
			$aRow['posted_on'] = Phpfox::getPhrase('bulletin.user_link_wrote_on_item_time_stamp', array(
					'item_time_stamp' => Phpfox::getTime(Phpfox::getParam('bulletin.bulletin_view_timestamp'), $aRow['time_stamp']),
					'user' => $aRow			
				)
			);
		}
			
		return $aRow;
	}
	
	/**
	 * This function gets All the bulletins from one single user (the ones that (s)he has written)
	 * Ordered by the newest first
	 *
	 * @param integer $iId the user id
	 * @return array the (cached?) bulletins by $iId
	 */
	public function get($aCond = array(), $iPage = '', $iPageSize = '')
	{
		$aRows = array();			
		
		if (!Phpfox::getParam('bulletin.is_bulletin_public') && !Phpfox::isAdmin())
		{
			$this->database()->join(Phpfox::getT('friend'), 'f', '(f.friend_user_id = ' . Phpfox::getUserId() . ' AND f.user_id = b.user_id) OR b.user_id = ' . Phpfox::getUserId());
		}
		
		$iCnt = $this->database()->select('COUNT(DISTINCT b.bulletin_id)')
			->from($this->_sTable, 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where($aCond)
			->execute('getSlaveField');

		if ($iCnt)
		{				
			if (!Phpfox::getParam('bulletin.is_bulletin_public') && !Phpfox::isAdmin())
			{
				$this->database()->join(Phpfox::getT('friend'), 'f', '(f.friend_user_id = ' . Phpfox::getUserId() . ' AND f.user_id = b.user_id) OR b.user_id = ' . Phpfox::getUserId())
					->group('b.bulletin_id');
			}			
			
			$aRows = $this->database()->select('b.bulletin_id, b.view_id, b.title, b.total_comment, b.total_attachment, b.time_stamp, ' . Phpfox::getUserField())
				->from($this->_sTable, 'b')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
				->where($aCond)
				->limit($iPage, $iPageSize, $iCnt)
				->order('b.time_stamp DESC')
				->execute('getSlaveRows');				
				
			foreach ($aRows as $iKey => $aRow)
			{
				$aRows[$iKey]['posted_on'] = Phpfox::getPhrase('bulletin.posted_on_time_stamp_by_user_link', array(
						'item_time_stamp' => Phpfox::getTime(Phpfox::getParam('bulletin.bulletin_view_timestamp'), $aRow['time_stamp']),
						'user' => $aRow
					)
				);
			}
		}		
		
		return array($iCnt, $aRows);		
	}
	
	/**
	 * Gets the bulletins to show in the entry block, this complies with the admin panel settings for
	 * how many to show in front page and if the bulletins are private or not, also with the cache time out
	 * Private bulletins are never cached or it would lead to too many cache files.
	 * @param $iId integer User id for which we filter, we check if this user has permission to see every message or we filter out
	 * @return array
	 */
	public function getBulletins($iId)
	{
		// we need to show all the bulletins that this user can see
		// we need to know if the admin has set it so only friends can view bulletins		
		if (Phpfox::getParam('bulletin.is_bulletin_public') || Phpfox::isAdmin())
		{
			// check the cache first
			// we do a simple get
			if (Phpfox::getParam('bulletin.bulletin_do_cache'))
			{
				$sCacheId = $this->cache()->set('bulletin');	
				if (!($aRows = $this->cache()->get($sCacheId, Phpfox::getParam('bulletin.cache_time_out'))))
				{
					$aRows = $this->database()->select('b.bulletin_id, b.view_id, b.title, b.time_stamp, b.total_comment, b.total_attachment, ' . Phpfox::getUserField())
						->from($this->_sTable, 'b')
						->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
						->order('b.time_stamp DESC')
						->where('b.view_id = 0')
						->limit(Phpfox::getParam('bulletin.how_many_show_in_front_page'))
						->execute('getSlaveRows');	
				
					if (!empty($aRows))
					{
						foreach ($aRows as $iKey => $aRow)
						{
							$aRows[$iKey]['posted_on'] = Phpfox::getPhrase('bulletin.posted_on_time_stamp_by_user_link', array(
									'item_time_stamp' => Phpfox::getTime(Phpfox::getParam('bulletin.bulletin_view_timestamp'), $aRow['time_stamp']),
									'user' => $aRow
								)
							);
						}						
						
						$this->cache()->save($sCacheId, $aRows);
					}					
				}				
				return $aRows;
			}			
			
			$aRows = $this->database()->select('b.bulletin_id, b.title, b.view_id, b.time_stamp, b.total_comment, b.total_attachment, ' . Phpfox::getUserField())
						->from($this->_sTable, 'b')
						->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
						->order('b.time_stamp DESC')
						->limit(Phpfox::getParam('bulletin.how_many_show_in_front_page'))
						->execute('getSlaveRows');
						
			foreach ($aRows as $iKey => $aRow)
			{
				$aRows[$iKey]['posted_on'] = Phpfox::getPhrase('bulletin.posted_on_time_stamp_by_user_link', array(
						'item_time_stamp' => Phpfox::getTime(Phpfox::getParam('bulletin.bulletin_view_timestamp'), $aRow['time_stamp']),
						'user' => $aRow
					)
				);
			}

			return $aRows;		
		}
		
		// Private bulletins, cache the ones this oner can see		
		$aRows = $this->database()->select('DISTINCT b.bulletin_id, b.title, b.view_id, b.time_stamp, b.total_comment, b.total_attachment, ' . Phpfox::getUserField())
			->from($this->_sTable, 'b')
			->join(Phpfox::getT('friend'), 'f', '(f.friend_user_id = ' . (int) $iId . ' AND f.user_id = b.user_id) OR b.user_id = ' . (int) $iId)
			->join(Phpfox::getT('user'), 'u', 'b.user_id = u.user_id')
			->order('b.time_stamp DESC')
			->limit(Phpfox::getParam('bulletin.how_many_show_in_front_page'))
			->execute('getSlaveRows');
			
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['posted_on'] = Phpfox::getPhrase('bulletin.posted_on_time_stamp_by_user_link', array(
					'item_time_stamp' => Phpfox::getTime(Phpfox::getParam('bulletin.bulletin_view_timestamp'), $aRow['time_stamp']),
					'user' => $aRow
				)
			);
		}			
		
		return $aRows;
		
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
		if ($sPlugin = Phpfox_Plugin::get('bulletin.service_bulletin__call'))
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