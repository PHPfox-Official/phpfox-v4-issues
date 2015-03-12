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
 * @package  		Module_Rss
 * @version 		$Id: rss.class.php 7306 2014-05-08 13:19:17Z Fern $
 */
class Rss_Service_Rss extends Phpfox_Service 
{	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('rss');	
	}
	
	public function output($aParam)
	{
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->setXml(array(
				'version' => '1.0',
				'encoding' => 'UTF-8'
			)
		);
		$oXmlBuilder->addGroup('rss', array(
				'version' => '2.0',
				'xmlns:dc' => 'http://purl.org/dc/elements/1.1/',
				'xmlns:content' => 'http://purl.org/rss/1.0/modules/content/',
				'xmlns:atom' => 'http://www.w3.org/2005/Atom'
			)
		);
		if (isset($aParam['title']))
		{
		    $aParam['title'] = html_entity_decode($aParam['title'], null, 'UTF-8');
		    $aParam['title'] = str_replace('&quot;','"', $aParam['title']);
		}
		
		
		$oXmlBuilder->addGroup('channel');
		$oXmlBuilder->addTag('atom:link', '', array(
					'href' =>  $aParam['href'],
					'rel' => 'self',
					'type' => 'application/rss+xml'
				)
			)
			->addTag('title', $aParam['title'])
			->addTag('link', (isset($aParams['link']) ? $aParam['link'] : Phpfox::getLib('url')->makeUrl('current')))
			->addTag('description', $aParam['description']);	
		

		foreach ($aParam['items'] as $aItem)
		{
			$aItem['title'] = html_entity_decode($aItem['title'], null, 'UTF-8');
			$aItem['title'] = str_replace('&quot;', '"', $aItem['title']);

			$aItem['description'] = preg_replace_callback('/\[PHPFOX_PHRASE\](.*?)\[\/PHPFOX_PHRASE\]/i', array($this, '_getPhrase'), $aItem['description']);
			
			$oXmlBuilder->addGroup('item');
			$oXmlBuilder->addTag('title', $aItem['title']);
			$oXmlBuilder->addTag('link', $aItem['link']);
			$oXmlBuilder->addTag('description', $aItem['description']);
			$oXmlBuilder->addTag('guid', $aItem['link']);
			$oXmlBuilder->addTag('pubDate', date('r', $aItem['time_stamp']));
			$oXmlBuilder->addTag('dc:creator', $aItem['creator']);
			$oXmlBuilder->closeGroup('item'); // item
		}			
		
		$oXmlBuilder->closeGroup(); // channel
		$oXmlBuilder->closeGroup(); // rss			
		
		header('Content-type: text/xml; charset=utf-8');
		echo $oXmlBuilder->output();		
		exit;		
	}
	
	public function get()
	{
		return $this->database()->select('r.*')
			->from($this->_sTable, 'r')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = r.module_id AND m.is_active = 1')
			->join(Phpfox::getT('product'), 'p', 'p.product_id = r.product_id AND p.is_active = 1')
			->order('r.ordering ASC')
			->execute('getRows');		
	}	
	
	public function getForEdit($iId)
	{
		$aFeed = $this->database()->select('r.*')
			->from($this->_sTable, 'r')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = r.module_id AND m.is_active = 1')
			->join(Phpfox::getT('product'), 'p', 'p.product_id = r.product_id AND p.is_active = 1')
			->where('r.feed_id = ' . (int) $iId)
			->execute('getRow');	
			
		if (!isset($aFeed['feed_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('rss.unable_to_find_the_feed_you_are_planning_to_edit'));
		}
		
		return $aFeed;
	}
	
	public function getUserFeed(&$aUser)
	{
		$aFeeds = Phpfox::getService('feed')->get($aUser['user_id']);

		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->setXml(array(
				'version' => '1.0',
				'encoding' => 'UTF-8'
			)
		);
		$oXmlBuilder->addGroup('rss', array(
				'version' => '2.0',
				'xmlns:dc' => 'http://purl.org/dc/elements/1.1/',
				'xmlns:content' => 'http://purl.org/rss/1.0/modules/content/',
				'xmlns:atom' => 'http://www.w3.org/2005/Atom'
			)
		);
		$oXmlBuilder->addGroup('channel');
		$oXmlBuilder->addTag('atom:link', '', array(
					'href' =>  Phpfox::getLib('url')->makeUrl($aUser['user_name'], 'rss'),
					'rel' => 'self',
					'type' => 'application/rss+xml'
				)
			)
			->addTag('title', Phpfox::getLib('parse.output')->clean($aUser['full_name']))
			->addTag('link', Phpfox::getLib('url')->makeUrl($aUser['user_name']))
			->addTag('description', Phpfox::getPhrase('rss.latest_updates_from_full_name', array('full_name' => Phpfox::getLib('parse.output')->clean($aUser['full_name']))));
			
		$iLog = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('rss_log_user'))
			->where('user_id = ' . $aUser['user_id'] . ' AND id_hash = \'' . Phpfox::getLib('request')->getIdHash() . '\'')
			->execute('getSlaveField');
		if (!$iLog)
		{
			$this->database()->insert(Phpfox::getT('rss_log_user'), array(
					'user_id' => $aUser['user_id'],
					'id_hash' => Phpfox::getLib('request')->getIdHash(),
					'ip_address' => Phpfox::getIp(),
					'user_agent' => substr(Phpfox::getLib('request')->getBrowser(), 0, 100),
					'time_stamp' => PHPFOX_TIME
				)
			);
			
			$this->database()->updateCounter('user_field', 'rss_count', 'user_id', $aUser['user_id']);
		}			
	
		if (is_array($aFeeds) && count($aFeeds))
		{
			foreach ($aFeeds as $aItem)
			{
				$oXmlBuilder->addGroup('item');
				$oXmlBuilder->addTag('title', Phpfox::getLib('parse.output')->clean($aItem['full_name']) . ' ' . strip_tags(!empty($aItem['feed_info']) ? $aItem['feed_info'] : (!empty($aItem['feed_content']) ? $aItem['feed_content'] : '')));
				$oXmlBuilder->addTag('link', $aItem['feed_link']);
				$oXmlBuilder->addTag('description', (!empty($aItem['feed_content']) ? $aItem['feed_content'] : ''));
				$oXmlBuilder->addTag('guid', $aItem['feed_link']);
				$oXmlBuilder->addTag('pubDate', date('r', $aItem['time_stamp']));
				$oXmlBuilder->addTag('dc:creator', Phpfox::getLib('parse.output')->clean($aItem['full_name']));
				$oXmlBuilder->closeGroup('item'); // item
			}
		}
			
		$oXmlBuilder->closeGroup(); // channel
		$oXmlBuilder->closeGroup(); // rss
		
		return $oXmlBuilder->output();			
	}
	
	public function getFeed($iId)
	{
		$sCacheId = $this->cache()->set('rss_feed_' . $iId);
		
		if (!($aFeed = $this->cache()->get($sCacheId)))
		{
			$aFeed = $this->database()->select('r.*')
				->from($this->_sTable, 'r')
				->where('r.feed_id = ' . (int) $iId . ' AND r.is_active = 1')
				->order('r.ordering ASC')
				->execute('getSlaveRow');	
						
			if (!isset($aFeed['feed_id']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('rss.unable_to_find_rss_feed'));
			}
			
			$this->cache()->save($sCacheId, $aFeed);
		}
		
		$sDescription = Phpfox::getPhrase($aFeed['description_var']);
		
		eval($aFeed['php_view_code']);
		
		if (!isset($aRows) || (isset($aRows) && !is_array($aRows)))
		{
			return Phpfox_Error::trigger(Phpfox::getPhrase('rss.not_a_valid_rss_feed_php_code_failed'), E_USER_ERROR);
		}		
		
		$iLog = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('rss_log'))
			->where('feed_id = ' . $aFeed['feed_id'] . ' AND id_hash = \'' . Phpfox::getLib('request')->getIdHash() . '\'')
			->execute('getSlaveField');
		if (!$iLog)
		{
			$this->database()->insert(Phpfox::getT('rss_log'), array(
					'feed_id' => $aFeed['feed_id'],
					'id_hash' => Phpfox::getLib('request')->getIdHash(),
					'ip_address' => Phpfox::getIp(),
					'user_agent' => Phpfox::getLib('request')->getBrowser(),
					'time_stamp' => PHPFOX_TIME
				)
			);
			
			$this->database()->updateCounter('rss', 'total_subscribed', 'feed_id', $aFeed['feed_id']);
		}
					
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->setXml(array(
				'version' => '1.0',
				'encoding' => 'UTF-8'
			)
		);
		$oXmlBuilder->addGroup('rss', array(
				'version' => '2.0',
				'xmlns:dc' => 'http://purl.org/dc/elements/1.1/',
				'xmlns:content' => 'http://purl.org/rss/1.0/modules/content/',
				'xmlns:atom' => 'http://www.w3.org/2005/Atom'
			)
		);
		$oXmlBuilder->addGroup('channel');
		$oXmlBuilder->addTag('atom:link', '', array(
					'href' =>  Phpfox::getLib('url')->makeUrl('rss', array('id' => $aFeed['feed_id'])),
					'rel' => 'self',
					'type' => 'application/rss+xml'
				)
			)
			->addTag('title', html_entity_decode(Phpfox::getPhrase($aFeed['title_var']), null, 'UTF-8'))
			->addTag('link', Phpfox::getLib('url')->makeUrl($aFeed['feed_link']))
			->addTag('description', html_entity_decode($sDescription, null, 'UTF-8'));
			
		foreach ($aRows as $aItem)
		{
			$aItem['title'] = html_entity_decode($aItem['title'], null, 'UTF-8');
			$aItem['title'] = str_replace('&quot;', '"', $aItem['title']);
			
			$oXmlBuilder->addGroup('item');
			$oXmlBuilder->addTag('title', $aItem['title']);
			$oXmlBuilder->addTag('link', $aItem['link']);
			$oXmlBuilder->addTag('description', Phpfox::getLib('parse.output')->shorten($aItem['description'], 150, '...'));
			$oXmlBuilder->addTag('content:encoded', $aItem['description']);
			$oXmlBuilder->addTag('guid', $aItem['link']);
			$oXmlBuilder->addTag('pubDate', date('r', $aItem['time_stamp']));
			$oXmlBuilder->addTag('dc:creator', Phpfox::getLib('parse.output')->clean($aItem['creator']));
			$oXmlBuilder->closeGroup('item'); // item
		}
		
		$oXmlBuilder->closeGroup(); // channel
		$oXmlBuilder->closeGroup(); // rss
		
		return $oXmlBuilder->output();
	}
	
	public function getLinks()
	{	
		$aFeeds = array();
		$sCacheId = $this->cache()->set('rss_link_' . Phpfox::getLib('locale')->getLangId());
		
		if (!($aFeeds = $this->cache()->get($sCacheId)))
		{		
			$aRows = $this->database()->select('r.feed_id, r.title_var, r.php_group_code')
				->from($this->_sTable, 'r')
				->join(Phpfox::getT('module'), 'm', 'm.module_id = r.module_id AND m.is_active = 1')
				->join(Phpfox::getT('product'), 'p', 'p.product_id = r.product_id AND p.is_active = 1')				
				->where('r.is_active = 1 AND r.is_site_wide = 1')
				->order('r.ordering ASC')
				->execute('getRows');			
			
			foreach ($aRows as $aRow)
			{
				if (!empty($aRow['php_group_code']))
				{
					eval($aRow['php_group_code']);
				}								
						
				if (isset($aRow['child']))
				{
					foreach ($aRow['child'] as $sLink => $sPhrase)
					{
						$aFeeds[$sLink] = $sPhrase;
					}
				}
				else 
				{
					$aFeeds[Phpfox::getLib('url')->makeUrl('rss', array('id' => $aRow['feed_id']))] = Phpfox::getPhrase($aRow['title_var']);
				}
			}		
			
			$this->cache()->save($sCacheId, $aFeeds);		
		}
				
		return $aFeeds;
	}
	
	public function getFeeds()
	{
		$aFeeds = array();
		$sCacheId = $this->cache()->set('rss');
		
		if (!($aFeeds = $this->cache()->get($sCacheId)))
		{
			$aGroupRows = $this->database()->select('rg.group_id, rg.name_var')
				->from(Phpfox::getT('rss_group'), 'rg')
				->join(Phpfox::getT('module'), 'm', 'm.module_id = rg.module_id AND m.is_active = 1')
				->join(Phpfox::getT('product'), 'p', 'p.product_id = rg.product_id AND p.is_active = 1')
				->where('rg.is_active = 1')
				->order('rg.ordering ASC')
				->execute('getRows');
				
			foreach ($aGroupRows as $aGroupRow)
			{
				$aRows = $this->database()->select('r.feed_id, r.title_var, r.php_group_code')
					->from($this->_sTable, 'r')
					->join(Phpfox::getT('module'), 'm', 'm.module_id = r.module_id AND m.is_active = 1')
					->join(Phpfox::getT('product'), 'p', 'p.product_id = r.product_id AND p.is_active = 1')
					->where('r.group_id = ' . $aGroupRow['group_id'] . ' AND r.is_active = 1')
					->order('r.ordering ASC')
					->execute('getRows');			
				
				foreach ($aRows as $aRow)
				{
					if (!empty($aRow['php_group_code']))
					{
						eval($aRow['php_group_code']);
					}
					
					$aFeeds[$aGroupRow['name_var']][] = $aRow;
				}
			}		
			
			$this->cache()->save($sCacheId, $aFeeds);
		}
		
		return $aFeeds;
	}
	
    private function _getPhrase($aMatches)
    {
    	return (isset($aMatches[1]) ? Phpfox::getPhrase($aMatches[1]) : $aMatches[0]);
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
		if ($sPlugin = Phpfox_Plugin::get('rss.service_rss__call'))
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
