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
 * @package  		Module_Log
 * @version 		$Id: session.class.php 7244 2014-03-31 17:41:12Z Fern $
 */
class Log_Service_Session extends Phpfox_Service
{
 	private $_aSession = array();
 	private $_sSecurityToken;
 	
 	/**
	 * Class constructor
	 */	
	public function __construct()
 	{
 		$this->_sTable = Phpfox::getT('log_session');	
 	}
	
	public function getSessionId()
	{
		return (isset($this->_aSession['session_hash']) ? $this->_aSession['session_hash'] : 0);
	}
	
	public function get($sName, $mDef = '')
	{		
		return (isset($this->_aSession[$sName]) ? $this->_aSession[$sName] : $mDef);
	}
	
	public function verifyToken()
	{
	    $aCheck = array('/video/frame/', '/subscribe/complete/', '/ad/complete/', '/music/upload/');
	    
	    if ($sPlugin = Phpfox_Plugin::get('log.service_session___verifyToken_start'))
	    {
			eval($sPlugin);
	    }
	    
	    if (defined('PHPFOX_SKIP_POST_PROTECTION'))
	    {
	    	return;
	    }
	    
		if (isset($_GET[PHPFOX_GET_METHOD])
			&& (in_array($_GET[PHPFOX_GET_METHOD], 
					$aCheck
				) || (preg_match('/\/api\/gateway\/callback\/(.*?)\//', $_GET[PHPFOX_GET_METHOD], $aMatches))
			)	
		)
		{
			return;
		}

		// CSRF
		if (Phpfox::getParam('core.csrf_protection_level') != 'low' && isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post')
		{
			if (!isset($_POST[Phpfox::getTokenName()]['security_token']))
			{
				$this->_log(Phpfox::getPhrase('error.csrf_token_set'));
			}
			
			if (Phpfox::getParam('core.csrf_protection_level') == 'high')
			{
				$sToken = Phpfox::getLib('session')->get('security_token');
				
				if (!$sToken)
				{
					$this->_log(Phpfox::getPhrase('error.csrf_session_token'));
				}
			}
			else 
			{
				$sToken = $this->getToken();
			}

			if ($sToken != $_POST[Phpfox::getTokenName()]['security_token'])
			{			
				$this->_log(Phpfox::getPhrase('error.csrf_detected'));
			}
			
			/*
			if (((60 * 3) + substr($sToken, -10)) < PHPFOX_TIME)
			{
				define('PHPFOX_CSRF_TIME_LIMIT', true);
			}		
			*/
		}		
	}
		
	public function getToken()
	{
		if (defined('PHPFOX_INSTALLER'))
		{
			return false;
		}
		
		static $sToken;
		
		if ($sToken)
		{
			return $sToken;
		}
		
		$sToken = (md5((Phpfox::getParam('core.csrf_protection_level') == 'high' ? uniqid(rand(), true) : '') . Phpfox::getLib('request')->getIdHash() . md5(Phpfox::getParam('core.salt'))));		
				
		if (Phpfox::getParam('core.csrf_protection_level') == 'high')
		{
			Phpfox::getLib('session')->set('security_token', $sToken);				
		}
		
		return $sToken;
	}
	
	public function getActiveTime()
	{
		return (PHPFOX_TIME - (Phpfox::getParam('log.active_session') * 60));
	}
	
	public function setUserSession()
	{		
		$oSession = Phpfox::getLib('session');
		$oRequest = Phpfox::getLib('request');
		
		$sSessionHash = $oSession->get('session');		

		if (Phpfox::getParam('core.store_only_users_in_session'))
		{
			$this->_aSession = Phpfox::getService('user.auth')->getUserSession();
		}
		else
		{
			if ($sSessionHash)
			{
				$this->_aSession = Phpfox::getService('user.auth')->getUserSession();
				
				if (!isset($this->_aSession['session_hash']) && !Phpfox::getParam('core.store_only_users_in_session'))
				{				
					$this->database()->where("s.session_hash = '" . $this->database()->escape($oSession->get('session')) . "' AND s.id_hash = '" . $this->database()->escape($oRequest->getIdHash()) . "'");
					
					$this->_aSession = $this->database()->select('s.session_hash, s.id_hash, s.captcha_hash, s.user_id')
						->from($this->_sTable, 's')					
						->execute('getRow');			
				}
			}		
		}
		
		$sLocation = $oRequest->get(PHPFOX_GET_METHOD);
		$sLocation = substr($sLocation, 0, 244);
		$sBrowser = substr(Phpfox::getLib('request')->getBrowser(), 0, 99);	
		$sIp = Phpfox::getLib('request')->getIp();			

		if (Phpfox::getParam('core.log_site_activity'))
		{
			// Unsure why this is here. Causes http://www.phpfox.com/tracker/view/15330/
			// Perhaps instead of the database delete, the log is only for logged in users?
			// I cannot find a reason why the script should log guests activity.
			// Besides, guest activity may increase the number of inserts into this table very largely
            /*if(Phpfox::getUserId() > 0) 
			{
				$this->database()->delete($this->_sTable, 'user_id = ' . Phpfox::getUserId());
			}*/
			// Like this:
			if(Phpfox::getUserId() > 0)
			{
				$this->database()->insert(Phpfox::getT('log_view'), array(
						'user_id' => Phpfox::getUserId(),				
						'ip_address' => $sIp,				
						'protocal' => $_SERVER['REQUEST_METHOD'],				
						'cache_data' => serialize(array(
								'location' => $_SERVER['REQUEST_URI'],
								'referrer' => (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null),
								'user_agent' => $_SERVER['HTTP_USER_AGENT'],
								'request' => (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ? serialize($_POST) : serialize($_GET))
							)
						),
						'time_stamp' => PHPFOX_TIME
					)
				);
			}
		}

		/**
		 * @todo Needs to be added into the 'setting' db table
		 */
		$aDisAllow = array(
			'captcha/image'
		);
		
		// Don't log a session into the DB if we disallow it
		if (Phpfox::getLib('url')->isUrl($aDisAllow))
		{
			return;
		}	
		
		$bIsForum = (strstr($sLocation, Phpfox::getParam('core.module_forum')) ? true : false);
		$iForumId = 0;
		if ($bIsForum)
		{
			$aForumIds = explode('-', $oRequest->get('req2'));
			if (isset($aForumIds[(count($aForumIds) - 1)]))
			{
				$iForumId = (int) $aForumIds[(count($aForumIds) - 1)];				
			}			
		}
		
		$iIsHidden = 0;
		if (Phpfox::isUser())
		{
			if (Phpfox::getUserBy('im_hide'))
			{
				$iIsHidden = 1;	
			}			
		}
		
		if (Phpfox::getParam('core.store_only_users_in_session'))
		{
			if (Phpfox::isUser())
			{
				if (!isset($this->_aSession['session_hash']))
				{
					if(Phpfox::getUserId() > 0)
					{
						$this->database()->delete(Phpfox::getT('session'), 'user_id = ' . Phpfox::getUserId());
					}
					$this->database()->insert(Phpfox::getT('session'), array(
							'user_id' => Phpfox::getUserId(),
							'last_activity' => PHPFOX_TIME
						)
					);
				}
				else
				{
					$this->database()->update(Phpfox::getT('session'), array(
							'last_activity' => PHPFOX_TIME							
					), 'user_id = ' . (int) Phpfox::getUserId());
				}	
			}		
		}
		else
		{		
			if (!isset($this->_aSession['session_hash']))
			{
				$sSessionHash = $oRequest->getSessionHash();
				if(Phpfox::getUserId() > 0) 
				{
					$this->database()->delete($this->_sTable, 'user_id = ' . Phpfox::getUserId());
				}
				$this->database()->insert($this->_sTable, array(
						'session_hash' => $sSessionHash,
						'id_hash' => $oRequest->getIdHash(),
						'user_id' => Phpfox::getUserId(),
						'last_activity' => PHPFOX_TIME,
						'location' => $sLocation,
						'is_forum' => ($bIsForum ? '1' : '0'),
						'forum_id' => $iForumId,
						'im_hide' => $iIsHidden,
						'ip_address' => $sIp,
						'user_agent' => $sBrowser
					)
				);
				$oSession->set('session', $sSessionHash);
			}
			else if (isset($this->_aSession['session_hash']))
			{
				$this->database()->update($this->_sTable, array(
					'last_activity' => PHPFOX_TIME, 
					'user_id' => Phpfox::getUserId(),
					"location" => $sLocation,
					"is_forum" => ($bIsForum ? "1" : "0"),
					"forum_id" => $iForumId,
					'im_hide' => $iIsHidden,
					"ip_address" => $sIp,
					"user_agent" => $sBrowser
				), "session_hash = '" . $this->_aSession["session_hash"] . "'");	
			}	
		}			
			
		if (!Phpfox::getCookie('visit'))
		{
			Phpfox::setCookie('visit', PHPFOX_TIME);			
		}		
		
		if (Phpfox::isUser())
		{
			if (!Phpfox::getCookie('last_login'))
			{			
				Phpfox::setCookie('last_login', PHPFOX_TIME, (PHPFOX_TIME + (Phpfox::getParam('log.active_session') * 60)));
				if (Phpfox::getUserBy('last_activity') < (PHPFOX_TIME + (Phpfox::getParam('log.active_session') * 60)))
				{
					$this->database()->update(Phpfox::getT('user'), array('last_login' => PHPFOX_TIME), 'user_id = ' . Phpfox::getUserId());
					$this->database()->insert(Phpfox::getT('user_ip'), array(
							'user_id' => Phpfox::getUserId(),
							'type_id' => 'session_login',
							'ip_address' => Phpfox::getIp(),
							'time_stamp' => PHPFOX_TIME
						)
					);	
				}
			}		
			
			if (!Phpfox::getParam('user.disable_store_last_user'))
			{
				$this->database()->update(Phpfox::getT('user'), array('last_activity' => PHPFOX_TIME, 'last_ip_address' => Phpfox::getIp()), 'user_id = ' . Phpfox::getUserId());
			}
		}
	}
	
	public function getActiveUsers($aCond)
	{
		$aCond[] = 'AND s.last_activity > \'' . $this->getActiveTime() . '\'';		
		
		$iCnt = (int) $this->database()->select('COUNT(DISTINCT u.user_id)')
			->from(Phpfox::getT('log_session'), 's')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = s.user_id')
			->where($aCond)
			->execute('getSlaveField');
		
		$aRows = $this->database()->select(Phpfox::getUserField())
			->from(Phpfox::getT('log_session'), 's')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = s.user_id')
			->where($aCond)
			->order('s.last_activity')
			->group('u.user_id')
			->limit(20)
			->execute('getSlaveRows');

		return array($iCnt, $aRows);
	}
	
	public function getActiveLocation($sLocation)
	{
		$sLocation = trim($sLocation, '/');
		
		switch ($sLocation)
		{
			case 'admincp':
				if ($sLocation == 'admincp')
				{
					$sLocation = Phpfox::getPhrase('log.admincp_dashboard');
				}
				break;
			default:
				$sLocation = Phpfox::getPhrase('log.site_index');
				break;
		}
		
		return $sLocation;
	}
	
	public function getOnlineStats()
	{
		$sOnlineMembers = $this->database()->select('COUNT(DISTINCT user_id)')
			->from((Phpfox::getParam('core.store_only_users_in_session') ? Phpfox::getT('session') : Phpfox::getT('log_session')))
			->where('user_id > 0 AND last_activity > ' . (PHPFOX_TIME - (Phpfox::getParam('log.active_session')*60)))
			->execute('getSlaveField');
			
        if (Phpfox::getParam('core.log_site_activity'))
		{
            $sOnlineGuests = $this->database()->select('COUNT(DISTINCT ip_address)')
				->from(Phpfox::getT('log_session'))
				->where('user_id = 0 AND last_activity > '  . (PHPFOX_TIME - (Phpfox::getParam('log.active_session')*60)))
				->execute('getSlaveField');			
        }
        else
        {
            $sOnlineGuests = 0;
        }
        
		return array(
			'members' => (int) $sOnlineMembers,
			'guests' => (int) $sOnlineGuests
		);
	}
	
	public function getOnlineMembers()
	{
		static $iTotal = null;
		
		if ($iTotal === null)
		{
			$iTotal = $this->database()->select('COUNT(DISTINCT user_id)')
				->from(Phpfox::getT('log_session'))
				->where('user_id > 0 AND last_activity > ' . (PHPFOX_TIME - (Phpfox::getParam('log.active_session')*60)))
				->execute('getSlaveField');		
		}
		
		return $iTotal;
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
		if ($sPlugin = Phpfox_Plugin::get('log.service_session___call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
	
	private function _log($sMessage)
	{
		if (PHPFOX_DEBUG)
		{
			Phpfox_Error::trigger($sMessage, E_USER_ERROR);
		}
		exit($sMessage);
	}
}

?>
