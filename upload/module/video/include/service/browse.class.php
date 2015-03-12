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
 * @version 		$Id: browse.class.php 414 2009-04-17 23:31:59Z Raymond_Benc $
 */
class Video_Service_Browse extends Phpfox_Service 
{	
	private $_sCategory = null;	
	
	private $_aCallback = false;
        
	private $_aConditions = array();
	
	private $_iPageSize = array();
	
	private $_iPage = 0;
	
	private $_iCnt = 0;
	
	private $_aVideos = array();
	
	private $_sOrder = null;
	
	private $_sTag = null;
	
	private $_bFull = false;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('video');
	}
	
	public function query()
	{
		
	}
	
	public function processRows(&$aRows)
	{
		foreach ($aRows as $iKey => $aRow)
		{				
			$aRows[$iKey]['link'] = ($this->_aCallback !== false ? Phpfox::getLib('url')->makeUrl($this->_aCallback['url'][0], array_merge($this->_aCallback['url'][1], array($aRow['title']))) : Phpfox::permalink('video', $aRow['video_id'], $aRow['title']));
		}
	}
	
	public function category($sCategory)
	{
		$this->_sCategory = $sCategory;
		
		return $this;
	}
	
	public function callback($aCallback)
	{
		$this->_aCallback = $aCallback;
		
		return $this;
	}	
	
	public function condition($aConditions)
	{
		$this->_aConditions = $aConditions;
		
		return $this;
	}
        
	public function size($iPageSize)
	{
		$this->_iPageSize = $iPageSize;
		
		return $this;
	}
        
	public function execute()
	{
		if ($this->_sCategory !== null)
		{
			$sCategories = Phpfox::getService('video.category')->getAllCategories($this->_sCategory);
		
			$this->database()->innerJoin(Phpfox::getT('video_category_data'), 'vcd', 'vcd.video_id = m.video_id');
			
			$this->_aConditions[] = ' AND vcd.category_id IN(' . $sCategories . ')';
		}
		
		$this->_iCnt = $this->database()->select(($this->_sCategory !== null ? 'COUNT(DISTINCT m.video_id)' : 'COUNT(*)'))
			->from($this->_sTable, 'm')
			->where($this->_aConditions)
			->execute('getSlaveField');
			
		if ($this->_iCnt)
		{
			if ($this->_sCategory !== null)
			{			
				$this->database()->innerJoin(Phpfox::getT('video_category_data'), 'vcd', 'vcd.video_id = m.video_id')->group('m.video_id');
			}
					
			$aVideos = $this->database()->select('m.*, ' . Phpfox::getUserField())
				->from($this->_sTable, 'm')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = m.user_id')
				->where($this->_aConditions)
				->order($this->_sOrder)
				->group('m.video_id')
				->limit($this->_iPage, $this->_iPageSize, $this->_iCnt)				
				->execute('getSlaveRows');
				
			foreach ($aVideos as $aVideo)
			{				
				$aVideo['breadcrumb'] = Phpfox::getService('video.category')->getCategoriesById($aVideo['video_id']);				
				$aVideo['link'] = Phpfox::permalink('video', $aVideo['video_id'], $aVideo['title']);
				
				$this->_aVideos[] = $aVideo;
			}
		}		
	}
        
    public function page($iPage)
	{
		$this->_iPage = $iPage;
		
		return $this;
	}
        
    public function get()
	{
		return $this->_aVideos;
	}
        
    public function getCount()
	{
		return $this->_iCnt;
	}
        
    public function order($sOrder)
	{		
		if ($sOrder != 'm.time_stamp DESC')
		{		
			$this->_sOrder = $sOrder;
		}
		return $this;
	}
        
	public function tag($sTag)
	{
		if (Phpfox::isModule('tag'))
		{
			$aTag = Phpfox::getService('tag')->getTagInfo('video', $sTag);
			
			if (!empty($aTag['tag_text']))
			{
				$this->_sTag = $aTag['tag_text'];
			}
		}
		
		return $this;
	}
	
	public function full($bFull)
	{
		$this->_bFull = $bFull;
		
		return $this;
	}
	
	public function getQueryJoins($bIsCount = false, $bNoQueryFriend = false)
	{
		if (!$bIsCount && Phpfox::getParam('video.vidly_support'))
		{
			$this->database()->select('vidly.vidly_url_id, ')->leftJoin(Phpfox::getT('vidly_url'), 'vidly', 'vidly.video_id = m.video_id');
		}

		if (Phpfox::isModule('friend') && Phpfox::getService('friend')->queryJoin($bNoQueryFriend))
		{
			$this->database()->join(Phpfox::getT('friend'), 'friends', 'friends.user_id = m.user_id AND friends.friend_user_id = ' . Phpfox::getUserId());	
		}		
		
		if ($this->_sTag != null)
		{
			$this->database()->innerJoin(Phpfox::getT('tag'), 'tag', 'tag.item_id = m.video_id AND tag.category_id = \''.(defined('PHPFOX_GROUP_VIEW') ? 'video_group' : 'video').'\' AND tag_text = "'. $this->_sTag.'"');
			if (!$bIsCount)
			{
				$this->database()->group('m.video_id');
			}			
		}

		if ($this->_sCategory !== null)
		{		
			$this->database()->innerJoin(Phpfox::getT('video_category_data'), 'mcd', 'mcd.video_id = m.video_id');
			if (!$bIsCount)
			{
				$this->database()->group('m.video_id');
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
		if ($sPlugin = Phpfox_Plugin::get('video.service_browse__call'))
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
