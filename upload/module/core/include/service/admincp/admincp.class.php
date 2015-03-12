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
 * @version 		$Id: admincp.class.php 6668 2013-09-24 13:05:06Z Fern $
 */
class Core_Service_Admincp_Admincp extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function getNote()
	{
		$sCacheId = $this->cache()->set('admincp_note');
		if (!($sNote = $this->cache()->get($sCacheId)))
		{
			$sNote = $this->database()->select('value_actual')
				->from(Phpfox::getT('setting'))
				->where('module_id = \'core\' AND var_name = \'global_admincp_note\'')
				->execute('getField');
				
			$this->cache()->save($sCacheId, $sNote);
		}
		
		if ($sNote == 'Save your notes here...')
		{
			$sNote = Phpfox::getPhrase('admincp.save_your_notes_here');
		}
		
		return $sNote;
	}
	
	public function getActiveAdmins()
	{
		$iActiveAdminCp = (PHPFOX_TIME - (Phpfox::getParam('core.admincp_timeout') * 60));	
		
		$aUsers = array();
			
		if(Phpfox::getParam('core.store_only_users_in_session'))
		{
			$aUsers = $this->database()->select('uf.in_admincp, u.last_ip_address as ip_address, ' . Phpfox::getUserField())
				->from(Phpfox::getT('user_field'), 'uf')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = uf.user_id')
				->join(Phpfox::getT('session'), 'ls', 'ls.user_id = u.user_id')
				->where('uf.in_admincp > \'' . $iActiveAdminCp . '\'')
				->group('u.user_id')
				->execute('getRows');
		}
		else
		{
			$aUsers = $this->database()->select('uf.in_admincp, ls.location, ls.ip_address, ' . Phpfox::getUserField())
				->from(Phpfox::getT('user_field'), 'uf')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = uf.user_id')
				->join(Phpfox::getT('log_session'), 'ls', 'ls.user_id = u.user_id')
				->where('uf.in_admincp > \'' . $iActiveAdminCp . '\'')
				->group('u.user_id')
				->execute('getRows');
		}
			
		foreach ($aUsers as $iKey => $aUser)
		{
			if(!isset($aUser['location']))
			{
				if($aUser['user_id'] == Phpfox::getUserId())
				{
					$aUser['location'] = 'admincp';
				}
				else
				{
					$aUser['location'] = '';
				}
			}
				
			$aUsers[$iKey]['location'] = Phpfox::getService('log.session')->getActiveLocation($aUser['location']);	
				
		}
			
		return $aUsers;
	}
	
	public function getNews()
	{
		$sCacheId = $this->cache()->set('phpfox_news');
		
		if (!($aCache = $this->cache()->get($sCacheId, 60)))
		{
			$aNews = Phpfox::getLib('xml.parser')->parse(Phpfox::getLib('request')->send('http://feeds.feedburner.com/phpfox', array(), 'GET'));
			$aCache = array();
			$iCnt = 0;
			if (!is_array($aNews))
			{
				$aNews = array();
			}
			else
			{
				if (isset($aNews['channel']) && isset($aNews['channel']['item']))
				{
					foreach ($aNews['channel']['item'] as $aItem)
					{
						$iCnt++;
						$aCache[] = array(
							'title' => $aItem['title'],
							'link' => $aItem['link'],
							'creator' => $aItem['dc:creator'],
							'time_stamp' => strtotime($aItem['pubDate'])
						);

						if ($iCnt === 5)
						{
							break;
						}
					}
				}
			}	
						
			$this->cache()->save($sCacheId, $aCache);
		}
		if (!is_array($aCache))
		{
			$aCache = array();
		}
		foreach ($aCache as $iKey => $aRow)
		{
			$aCache[$iKey]['posted_on'] = Phpfox::getPhrase('admincp.posted_on_time_stamp_by_creator', array(
					'creator' => $aRow['creator'],
					'time_stamp' => Phpfox::getTime(Phpfox::getParam('core.global_update_time'), $aRow['time_stamp'])
				)
			);
		}
		
		return $aCache;
	}
	
	public function getTweets()
	{
		$sCacheId = $this->cache()->set('phpfox_twitter');
		
		if (!($aCache = $this->cache()->get($sCacheId, 60)))
		{
			$sHtml = Phpfox::getLib('request')->send('http://twitter.com/statuses/user_timeline/16987205.rss', array(), 'GET');
			
			if (preg_match('/<html(.*?)>/i', $sHtml))
			{
				return false;
			}
			
			$aTweets = Phpfox::getLib('xml.parser')->parse($sHtml);
			$aCache = array();
			$iCnt = 0;
			
			if (!isset($aTweets['channel']['item']))
			{
				return false;
			}
			
			foreach ($aTweets['channel']['item'] as $aItem)
			{
				$iCnt++;
				$aCache[] = array(
					'title' => str_replace('phpFox: ', '', $aItem['title']),
					'link' => $aItem['link'],
					'time_stamp' => strtotime($aItem['pubDate'])
				);
				
				if ($iCnt === 5)
				{
					break;
				}
			}
			
			$this->cache()->save($sCacheId, $aCache);
		}
		
		foreach ($aCache as $iKey => $aRow)
		{
			$aCache[$iKey]['posted_on'] = Phpfox::getPhrase('admincp.posted_on_time_stamp', array(
					'time_stamp' => Phpfox::getTime(Phpfox::getParam('core.global_update_time'), $aRow['time_stamp'])
				)
			);
		}		
		
		return $aCache;
	}	
	
	public function getLastAdminLogins()
	{
		$aUsers = $this->database()->select('al.login_id, al.time_stamp, al.ip_address, al.is_failed, ' . Phpfox::getUserField())
			->from(Phpfox::getT('admincp_login'), 'al')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = al.user_id')
			->order('al.time_stamp DESC')
			->limit(5)
			->execute('getSlaveRows');
				
		foreach ($aUsers as $iKey => $aItem)
		{
			$aUsers[$iKey]['attempt'] = $this->_getAdminLoginAttempt($aItem['is_failed']);
		}			
			
		return $aUsers;
	}
	
	public function getAdminLogins($aConds, $sSort = '', $iPage = '', $iLimit = '')
	{		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('admincp_login'), 'al')			
			->where($aConds)
			->order($sSort)
			->execute('getSlaveField');	
			
		$aItems = array();
		if ($iCnt)
		{		
			$aItems = $this->database()->select('al.*, ' . Phpfox::getUserFIeld())
				->from(Phpfox::getT('admincp_login'), 'al')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = al.user_id')
				->where($aConds)
				->order($sSort)
				->limit($iPage, $iLimit, $iCnt)
				->execute('getSlaveRows');			
				
			foreach ($aItems as $iKey => $aItem)
			{
				$aItems[$iKey]['attempt'] = $this->_getAdminLoginAttempt($aItem['is_failed']);
			}
		}
							
		return array($iCnt, $aItems);
	}
	
	public function getAdminLoginLog($iId)
	{
		$aLog = $this->database()->select('al.*, ' . Phpfox::getUserField())
			->from(Phpfox::getT('admincp_login'), 'al')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = al.user_id')		
			->where('al.login_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aLog['login_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.not_a_valid_login_log'));
		}
		
		$aLog['attempt'] = $this->_getAdminLoginAttempt($aLog['is_failed']);
		$aLog['cache_data'] = unserialize($aLog['cache_data']);
		$aLog['cache_data']['request'] = unserialize($aLog['cache_data']['request']);
		$aLog['cache_data']['token'] = (isset($aLog['cache_data']['request']['phpfox']['security_token']) ? $aLog['cache_data']['request']['phpfox']['security_token'] : $aLog['cache_data']['request'][Phpfox::getTokenName()]['security_token']);
		$aLog['cache_data']['email'] = $aLog['cache_data']['request']['val']['email'];		
			
		return $aLog;
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
		if ($sPlugin = Phpfox_Plugin::get('core.service_admincp_admincp__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
	
	private function _getAdminLoginAttempt($sAttempt)
	{
		$iAttempt = (int) $sAttempt;
		switch ($iAttempt)
		{
			case 1:
				$sAttempt = Phpfox::getPhrase('admincp.not_a_valid_account');
				break;
			case 2:
				$sAttempt = Phpfox::getPhrase('admincp.email_failure');
				break;
			case 3:
				$sAttempt = Phpfox::getPhrase('admincp.password_failure');
				break;				
			default:
				$sAttempt = Phpfox::getPhrase('admincp.success');
				break;
		}
		
		return $sAttempt;
	}
}

?>
