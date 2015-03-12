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
 * @package 		Phpfox_Service
 * @version 		$Id: browse.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Event_Service_Browse extends Phpfox_Service 
{	
	private $_aListings = array();
	
	private $_sCategory = null;
	
	private $_iAttending = null;
	
	private $_aCallback = false;
	
	private $_bFull = false;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('event');
	}

	public function category($sCategory)
	{
		$this->_sCategory = $sCategory;
		
		return $this;
	}
	
	public function attending($iAttending)
	{
		$this->_iAttending = $iAttending;
		
		return $this;
	}
	
	public function callback($aCallback)
	{
		$this->_aCallback = $aCallback;
		
		return $this;
	}
	
	public function full($bFull)
	{
		$this->_bFull = $bFull;
		
		return $this;
	}
	
	public function query()
	{
		if ($this->_iAttending !== null)
		{
			$this->database()->group('m.event_id');
		}
		
		if (Phpfox::isUser() && Phpfox::isModule('like'))
		{
			$this->database()->select('lik.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'lik', 'lik.type_id = \'event\' AND lik.item_id = m.event_id AND lik.user_id = ' . Phpfox::getUserId());
		}			
	}	
	
	public function processRows(&$aRows)
	{		
		$aNewRows = $aRows;	
		
		$aRows = array();
		foreach ($aNewRows as $aListing)
		{
			$aEvent['start_time'] = Phpfox::getLib('date')->convertFromGmt($aListing['start_time'], $aListing['start_gmt_offset']);			
			
			$iDate = Phpfox::getTime('dmy', $aListing['start_time']);		
				
			if ($iDate == Phpfox::getTime('dmy', PHPFOX_TIME))
			{
				$iDate = Phpfox::getPhrase('event.today');
			}
			elseif ($iDate == Phpfox::getTime('dmy', (PHPFOX_TIME + 86400)))
			{
				$iDate = Phpfox::getPhrase('event.tomorrow');
			}
			else 
			{
				 $iDate = Phpfox::getTime(Phpfox::getParam('event.event_browse_time_stamp'), $aListing['start_time']);
			}
				
			$aListing['start_time_phrase'] = Phpfox::getTime(Phpfox::getParam('event.event_browse_time_stamp'), $aListing['start_time']);
			$aListing['start_time_phrase_stamp'] = Phpfox::getTime(Phpfox::getParam('event.event_basic_information_time_short'), $aListing['start_time']);
			$aListing['start_time_micro'] = Phpfox::getTime('Y-m-d', $aEvent['start_time']);
				
			$aListing['aFeed'] = array(			
				'feed_display' => 'mini',	
				'comment_type_id' => 'event',
				'privacy' => $aListing['privacy'],
				'comment_privacy' => $aListing['privacy_comment'],
				'like_type_id' => 'event',				
				'feed_is_liked' => (isset($aListing['is_liked']) ? $aListing['is_liked'] : false),
				'feed_is_friend' => (isset($aListing['is_friend']) ? $aListing['is_friend'] : false),
				'item_id' => $aListing['event_id'],
				'user_id' => $aListing['user_id'],
				'total_comment' => $aListing['total_comment'],
				'feed_total_like' => $aListing['total_like'],
				'total_like' => $aListing['total_like'],
				'feed_link' => Phpfox::getLib('url')->permalink('event', $aListing['event_id'], $aListing['title']),
				'feed_title' => $aListing['title'],
				'type_id' => 'event'
			);				
				
			$aListing['url'] = Phpfox::getLib('url')->permalink('event', $aListing['event_id'], $aListing['title']);
			
			$aRows[$iDate][] = $aListing;
		}
	}
	
	public function getQueryJoins($bIsCount = false, $bNoQueryFriend = false)
	{
		if (Phpfox::isModule('friend') && Phpfox::getService('friend')->queryJoin($bNoQueryFriend))
		{
			$this->database()->join(Phpfox::getT('friend'), 'friends', 'friends.user_id = m.user_id AND friends.friend_user_id = ' . Phpfox::getUserId());	
		}				

		if ($this->_sCategory !== null)
		{		
			$this->database()->innerJoin(Phpfox::getT('event_category_data'), 'mcd', 'mcd.event_id = m.event_id');
			
			if (!$bIsCount)
			{
				$this->database()->group('m.event_id');
			}
		}					
		
		if ($this->_iAttending !== null)
		{
			$this->database()->innerJoin(Phpfox::getT('event_invite'), 'ei', 'ei.event_id = m.event_id AND ei.rsvp_id = ' . (int) $this->_iAttending . ' AND ei.invited_user_id = ' . Phpfox::getUserId());
			
			if (!$bIsCount)
			{
				$this->database()->select('ei.rsvp_id, ');
				$this->database()->group('m.event_id');
			}			
		}
		else 
		{
			if (Phpfox::isUser())
			{
				$this->database()->leftJoin(Phpfox::getT('event_invite'), 'ei', 'ei.event_id = m.event_id AND ei.invited_user_id = ' . Phpfox::getUserId());
				
				if (!$bIsCount)
				{
					$this->database()->select('ei.rsvp_id, ');
					$this->database()->group('m.event_id');
				}					
			}
		}
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
		if ($sPlugin = Phpfox_Plugin::get('event.service_browse__call'))
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
