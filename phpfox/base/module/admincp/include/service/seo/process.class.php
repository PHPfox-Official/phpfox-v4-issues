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
 * @version 		$Id: process.class.php 5844 2013-05-09 08:00:59Z Raymond_Benc $
 */
class Admincp_Service_Seo_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function deleteMeta($iId)
	{
		$this->database()->delete(Phpfox::getT('seo_meta'), 'meta_id = ' . (int) $iId);
		$this->cache()->remove('seo_meta');
		$this->cache()->remove('seo_meta_build');
	}	
	
	public function addMeta($aVals)
	{
		if (empty($aVals['url']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.provide_a_url'));
		}		
		
		$iId = $this->database()->insert(Phpfox::getT('seo_meta'), array(
				'type_id' => (int) $aVals['type_id'],
				'url' => Phpfox::getService('admincp.seo')->getUrl($aVals['url']),
				'content' => $aVals['content'],
				'time_stamp' => PHPFOX_TIME
			)
		);
		
		$this->cache()->remove('seo_meta');
		$this->cache()->remove('seo_meta_build');
		
		return $iId;		
	}
	
	public function addNoFollow($aVals)
	{
		if (empty($aVals['url']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.provide_a_url'));
		}
		
		$iId = $this->database()->insert(Phpfox::getT('seo_nofollow'), array(
				'url' => Phpfox::getService('admincp.seo')->getUrl($aVals['url']),
				'time_stamp' => PHPFOX_TIME
			)
		);
		
		$this->cache()->remove('seo_nofollow');
		$this->cache()->remove('seo_nofollow_build');
		
		return $iId;
	}
	
	public function deleteNoFollow($iId)
	{
		$this->database()->delete(Phpfox::getT('seo_nofollow'), 'nofollow_id = ' . (int) $iId);

		$this->cache()->remove('seo_nofollow');
		$this->cache()->remove('seo_nofollow_build');
	}
}

?>