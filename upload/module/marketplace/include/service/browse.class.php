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
class Marketplace_Service_Browse extends Phpfox_Service 
{
	
	private $_sCategory = null;
	
	private $_bIsSeen = false;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('marketplace');
	}	
	
	public function seen()
	{
		$this->_bIsSeen = true;
		
		return $this;
	}
		
	public function category($sCategory)
	{
		$this->_sCategory = $sCategory;
		
		return $this;
	}
		
	public function execute__()
	{
		if ($this->_sCategory !== null)
		{
			$sCategories = Phpfox::getService('marketplace.category')->getAllCategories($this->_sCategory);
		
			$this->database()->innerJoin(Phpfox::getT('marketplace_category_data'), 'mcd', 'mcd.listing_id = m.listing_id');
			
			$this->_aConditions[] = ' AND mcd.category_id IN(' . $sCategories . ')';
		}
		
		if ($this->_bIsSeen !== false)
		{
			$this->database()->join(Phpfox::getT('marketplace_invite'), 'mi', 'mi.listing_id = m.listing_id AND mi.visited_id = 0 AND mi.invited_user_id = ' . Phpfox::getUserId());
		}
		
		if (Phpfox::getLib('request')->get('view') == 'purchased')
		{
			$this->database()->join(Phpfox::getT('marketplace_invoice'), 'minvoice', 'minvoice.listing_id = m.listing_id AND minvoice.user_id = ' . Phpfox::getUserId() . ' AND minvoice.status = \'completed\'');
		}
		
		if (Phpfox::getLib('request')->get('view') == 'sold')
		{
			$this->database()->join(Phpfox::getT('marketplace_invoice'), 'minvoice', 'minvoice.listing_id = m.listing_id AND minvoice.status = \'completed\'');			
		}
		
		(($sPlugin = Phpfox_Plugin::get('marketplace.service_browse_execute_query')) ? eval($sPlugin) : false);
		
		$this->_iCnt = $this->database()->select((($this->_sCategory !== null || (Phpfox::getLib('request')->get('view') == 'sold' || Phpfox::getLib('request')->get('view') == 'purchased')) ? 'COUNT(DISTINCT m.listing_id)' : 'COUNT(*)'))
			->from($this->_sTable, 'm')
			->where($this->_aConditions)
			->execute('getSlaveField');
			
		if ($this->_iCnt)
		{
			if ($this->_sCategory !== null)
			{			
				$this->database()->innerJoin(Phpfox::getT('marketplace_category_data'), 'mcd', 'mcd.listing_id = m.listing_id')->group('m.listing_id');
			}
			
			if ($this->_bIsSeen !== false)
			{
				$this->database()->join(Phpfox::getT('marketplace_invite'), 'mi', 'mi.listing_id = m.listing_id AND mi.visited_id = 0 AND mi.invited_user_id = ' . Phpfox::getUserId());
			}			
			
			if (Phpfox::getLib('request')->get('view') == 'purchased')
			{
				$this->database()->join(Phpfox::getT('marketplace_invoice'), 'minvoice', 'minvoice.listing_id = m.listing_id AND minvoice.user_id = ' . Phpfox::getUserId() . ' AND minvoice.status = \'completed\'');	
			}			
			
			if (Phpfox::getLib('request')->get('view') == 'sold')
			{
				$this->database()->join(Phpfox::getT('marketplace_invoice'), 'minvoice', 'minvoice.listing_id = m.listing_id AND minvoice.status = \'completed\'')->group('m.listing_id');			
			}			
			
			(($sPlugin = Phpfox_Plugin::get('marketplace.service_browse_execute')) ? eval($sPlugin) : false);
			
			$this->_aListings = $this->database()->select('m.*, ' . Phpfox::getUserField())
				->from($this->_sTable, 'm')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = m.user_id')
				->where($this->_aConditions)
				->order($this->_sOrder)
				->limit($this->_iPage, $this->_iPageSize, $this->_iCnt)
				->execute('getSlaveRows');
				
			if (Phpfox::getLib('request')->get('view') == 'sold')
			{
				foreach ($this->_aListings as $iKey => $aListing)
				{
					list($iSoldCount, $aSoldItems) = Phpfox::getService('marketplace')->getInvoices('mi.listing_id = ' . $aListing['listing_id'] . ' AND mi.status = \'completed\'', true);
					
					$this->_aListings[$iKey]['invoices'] = $aSoldItems;
				}				
			}
		}
	}
	
	public function processRows(&$aRows)
	{		
		foreach ($aRows as $iKey => $aListing)
		{				
			$aRows[$iKey]['aFeed'] = array(			
				'feed_display' => 'mini',	
				'comment_type_id' => 'marketplace',
				'privacy' => $aListing['privacy'],
				'comment_privacy' => $aListing['privacy_comment'],
				'like_type_id' => 'marketplace',				
				'feed_is_liked' => (isset($aListing['is_liked']) ? $aListing['is_liked'] : false),
				'feed_is_friend' => (isset($aListing['is_friend']) ? $aListing['is_friend'] : false),
				'item_id' => $aListing['listing_id'],
				'user_id' => $aListing['user_id'],
				'total_comment' => $aListing['total_comment'],
				'feed_total_like' => $aListing['total_like'],
				'total_like' => $aListing['total_like'],
				'feed_link' => Phpfox::getLib('url')->permalink('marketplace', $aListing['listing_id'], $aListing['title']),
				'feed_title' => $aListing['title'],
				'type_id' => 'marketplace'
			);				
			// Mark expired items here so its easier to display them in the template
			if ( (Phpfox::getParam('marketplace.days_to_expire_listing') > 0) && ( $aListing['time_stamp'] < (PHPFOX_TIME - (Phpfox::getParam('marketplace.days_to_expire_listing') * 86400)) ) )
			{
				$aRows[$iKey]['is_expired'] = true;
			}
			$aRows[$iKey]['url'] = Phpfox::getLib('url')->permalink('marketplace', $aListing['listing_id'], $aListing['title']);			
		}
	}	
	
	public function query()
	{
		$this->database()->select('mt.description_parsed AS description, ')->join(Phpfox::getT('marketplace_text'), 'mt', 'mt.listing_id = l.listing_id');
		if (Phpfox::isUser() && Phpfox::isModule('like'))
		{
			$this->database()->select('lik.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'lik', 'lik.type_id = \'marketplace\' AND lik.item_id = l.listing_id AND lik.user_id = ' . Phpfox::getUserId());
		}	
	}	
	
	public function getQueryJoins($bIsCount = false, $bNoQueryFriend = false)
	{
		if (Phpfox::getLib('search')->isSearch() && $bIsCount)
		{
			$this->database()->leftJoin(Phpfox::getT('marketplace_text'), 'mt', 'mt.listing_id = l.listing_id');
		}
		
		if (Phpfox::isModule('friend') && Phpfox::getService('friend')->queryJoin($bNoQueryFriend))
		{
			$this->database()->join(Phpfox::getT('friend'), 'friends', 'friends.user_id = l.user_id AND friends.friend_user_id = ' . Phpfox::getUserId());	
		}				

		if ($this->_sCategory !== null)
		{		
			$this->database()->innerJoin(Phpfox::getT('marketplace_category_data'), 'mcd', 'mcd.listing_id = l.listing_id');
			
			if (!$bIsCount)
			{
				$this->database()->group('l.listing_id');
			}
		}	

		if ($this->_bIsSeen !== false)
		{
			$this->database()->join(Phpfox::getT('marketplace_invite'), 'mi', 'mi.listing_id = l.listing_id AND mi.visited_id = 0 AND mi.invited_user_id = ' . Phpfox::getUserId());
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
		if ($sPlugin = Phpfox_Plugin::get('marketplace.service_browse__call'))
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
