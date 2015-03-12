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
 * @version 		$Id: seo.class.php 7052 2014-01-20 13:45:52Z Fern $
 */
class Admincp_Service_Seo_Seo extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function setHeaders()
	{
		$sCacheId = $this->cache()->set('seo_nofollow_build');
		if (!($aNoFollows = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('*')
				->from(Phpfox::getT('seo_nofollow'))
				->execute('getSlaveRows');
			$aNoFollows = array();
			foreach ($aRows as $aRow)
			{
				$aNoFollows[$aRow['url']] = true;
			}

			$this->cache()->save($sCacheId, $aNoFollows);
		}
		
		if (count($aNoFollows))
		{
			$sUrl = trim(Phpfox::getLib('url')->getFullUrl(true), '/');
			if (isset($aNoFollows[$sUrl]))
			{
				Phpfox::getLib('template')->setHeader('<meta name="robots" content="nofollow" />');
			}
		}
		
		$sCacheId = $this->cache()->set('seo_meta_build');
		if (!($aMetas = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('*')
				->from(Phpfox::getT('seo_meta'))
				->execute('getSlaveRows');

			$aMetas = array();
			foreach ($aRows as $aRow)
			{
				if (!isset($aMetas[$aRow['url']]))
				{
					$aMetas[$aRow['url']] = array();
				}
				$aMetas[$aRow['url']][] = $aRow;
			}

			$this->cache()->save($sCacheId, $aMetas);
		}		

		if (count($aMetas))
		{
			$sUrl = trim(Phpfox::getLib('url')->getFullUrl(true), '/');

			if (isset($aMetas[$sUrl]))
			{
				foreach ($aMetas[$sUrl] as $aMeta)
				{
					if ($aMeta['type_id'] == '2')
					{
						Phpfox::getLib('template')->setTitle(Phpfox::getLib('locale')->convert($aMeta['content']));
						
						continue;
					}
					Phpfox::getLib('template')->setMeta((!$aMeta['type_id'] ? 'keywords' : 'description'), $aMeta['content']);
				}
			}
		}
	}
	
	public function getUrl($sUrl)
	{
		$sUrl = str_replace(Phpfox::getParam('core.path'), '', $sUrl);
		$sUrl = str_replace('index.php?' . PHPFOX_GET_METHOD . '=', '', $sUrl);
		$sUrl = trim($sUrl, '/');
		
		return $sUrl;
	}
	
	public function getNoFollows()
	{
		$sCacheId = $this->cache()->set('seo_nofollow');
		if (!($aRows = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('*')
				->from(Phpfox::getT('seo_nofollow'))
				->order('time_stamp')			
				->execute('getSlaveRows');
			$this->cache()->save($sCacheId, $aRows);
		}		
		return $aRows;
	}
	
	public function getSiteMetas()
	{
		$sCacheId = $this->cache()->set('seo_meta');
		if (!($aRows = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('*')
				->from(Phpfox::getT('seo_meta'))
				->order('time_stamp')
				->execute('getSlaveRows');

			$this->cache()->save($sCacheId, $aRows);
		}	
		return $aRows;		
	}
}

?>
