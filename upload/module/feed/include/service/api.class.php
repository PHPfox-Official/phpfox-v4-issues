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
 * @version 		$Id: api.class.php 5165 2013-01-21 10:13:25Z Raymond_Benc $
 */
class Feed_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('feed');
		$this->_oApi = Phpfox::getService('api');
	}
	
	public function get()
	{
		/*
		@title Get Feeds
		@info Get an activity feed for a specific user.
		@method GET
		@extra user_id=#{User ID#|int|yes}
		@return id=#{Item ID#|int}&title=#{Title of the item|string}&description=#{Description of the item|string}&likes=#{Total number of likes|int}&permalink=#{Link to the item|string}&content=#{Additional text some feeds might have|string}&image=#{Some feeds include an image|string}
		*/		
		define('PHPFOX_SKIP_LOOP_MAX_COUNT', true);
		
		$aFeeds = array();
		$aFeedRows = Phpfox::getService('feed')->get($this->_oApi->get('user_id'), null, $this->_oApi->get('page'));
		foreach ($aFeedRows as $iKey => $aFeedRow)
		{
			foreach ($aFeedRow as $sKey => $mValue)
			{
				if (substr($sKey, 0, 5) == 'feed_')
				{
					if (in_array($sKey, array('feed_reference', 'feed_time_stamp', 'feed_icon', 'feed_month_year', 'feed_image_onclick', 'feed_is_liked')))
					{
						continue;
					}
					
					$sKey = str_replace('feed_', '', $sKey);
					
					switch ($sKey)
					{
						case 'total_like':
							$sKey = 'likes';
							break;
						case 'info':
							$mValue = '<a href="' . Phpfox::getLib('url')->makeUrl($aFeedRow['user_name']) . '">' . $aFeedRow['full_name'] . '</a> ' . $mValue;
							break;
					}
					$aFeeds[$iKey][$sKey] = $mValue;
				}
			}
		}

		return $aFeeds;
	}	
}

?>