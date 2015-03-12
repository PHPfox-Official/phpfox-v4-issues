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
 * @version 		$Id: api.class.php 5112 2013-01-11 06:56:25Z Raymond_Benc $
 */
class Link_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('link');
		$this->_oApi = Phpfox::getService('api');	
	}
	
	public function add()
	{
		/*
		@title
		@info Post a link with a status update. On success it will return information about the link.
		@method POST
		@extra user_id=#{Pass a user_id if you want to return links from a specific user.|int|no}&id=#{Pass a link ID to get a specific link.|int|no}
		*/		
		$aLink = Phpfox::getService('link')->getLink($this->_oApi->get('url'));
		if (!$aLink)
		{
			return false;
		}
		
		$aLink['url'] = $this->_oApi->get('url');
		$aLink['image'] = $aLink['default_image'];
		
		$aInsert = array(
				'link' => $aLink,
				'status_info' => $this->_oApi->get('status_info')
				);
		Phpfox::getService('link.process')->add($aInsert);
		
		if (Phpfox::getService('link.process')->getInsertId())
		{
			$aLink = $this->get(Phpfox::getService('link.process')->getInsertId());		
			
			return $aLink[0];
		}
		
		return false;
	}	
	
	public function get($iLinkId = 0)
	{
		/*
		@title
		@info Get all public links. If a user ID# is passed it will return just the links for that user. If a link ID# is passed it will return just that link.
		@method GET
		@extra user_id=#{Pass a user_id if you want to return links from a specific user.|int|no}&id=#{Pass a link ID to get a specific link.|int|no}
		*/		
		if ((int) $this->_oApi->get('user_id') !== 0)
		{
			$iUserId = $this->_oApi->get('user_id');
		}
		
		if ((int) $this->_oApi->get('id') !== 0)
		{
			$iLinkId = $this->_oApi->get('id');
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable, 'p')
			->where(($iLinkId > 0 ? 'p.link_id = ' . (int) $iLinkId : (isset($iUserId) ? 'p.user_id = ' . (int) $iUserId . ' AND ' : '') . ' p.privacy = 0'))
			->execute('getSlaveField');
		
		$this->_oApi->setTotal($iCnt);
		
		$aRows = $this->database()->select('p.*, le.embed_code, ' . Phpfox::getUserField())
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->leftJoin(Phpfox::getT('link_embed'), 'le', 'le.link_id = p.link_id')
			->where(($iLinkId > 0 ? 'p.link_id = ' . (int) $iLinkId : (isset($iUserId) ? 'p.user_id = ' . (int) $iUserId . ' AND ' : '') . ' p.privacy = 0'))
			->limit($this->_oApi->get('page'), 10, $iCnt)
			->execute('getSlaveRows');	

		$aLinks = array();
		foreach ($aRows as $aRow)
		{
			$aLinks[] = array(
					'id' => $aRow['link_id'],
					'link' => $aRow['link'],
					'image' => $aRow['image'],
					'title' => $aRow['title'],
					'description' => $aRow['description'],
					'status_info' => $aRow['status_info'],
					'likes' => $aRow['total_like'],
					'embed_code' => $aRow['embed_code'],
					'permalink' => Phpfox::getLib('url')->makeUrl($aRow['user_name'], array('link-id' => $aRow['link_id'])) 
					);
		}
		
		return $aLinks;
	}
}

?>