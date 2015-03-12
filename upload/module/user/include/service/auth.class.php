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
 * @package  		Module_User
 * @version 		$Id: auth.class.php 7272 2014-04-15 13:25:27Z Fern $
 */
class User_Service_Auth extends Phpfox_Service
{
	private $_aUser = array();
	
	private $_iOverrideUserId = null;

	private $_sNameCookieUserId = 'user_id';
	private $_sNameCookieHash = 'user_hash';

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		if (Phpfox::getParam('core.use_custom_cookie_names'))
		{
			$this->_sNameCookieUserId = md5(Phpfox::getParam('core.custom_cookie_names_hash') . $this->_sNameCookieUserId);
			$this->_sNameCookieHash = md5(Phpfox::getParam('core.custom_cookie_names_hash') . $this->_sNameCookieHash);
		}

		$this->_sTable = Phpfox::getT('user');
		$iUserId = (int) Phpfox::getCookie($this->_sNameCookieUserId);
		$sPasswordHash = Phpfox::getCookie($this->_sNameCookieHash);

		if (isset($_POST['flash_user_id']) && isset($_POST['sHash']))
		{
			/*
			$hFile = fopen(PHPFOX_DIR_FILE . 'upload.log', 'a+');
			fwrite($hFile, 'user_id = ' . $iUserId . ' AND hash = "' . Phpfox::getLib('parse.input')->clean($_POST['sHash']).'"' . "\n");
			fclose($hFile);
			*/		
			
			$iUserId = (int)$_POST['flash_user_id'];
			$aRow = $this->database()->select('*')
					->from(Phpfox::getT('upload_track'))
					->where('user_id = ' . $iUserId . ' AND hash = "' . Phpfox::getLib('parse.input')->clean($_POST['sHash']).'"')
					->execute('getSlaveRow');
			$sPasswordHash = $aRow['user_hash'];
			$sIpAddress = $aRow['ip_address'];
			
			if ($sIpAddress != Phpfox::getLib('request')->getServer('REMOTE_ADDR')) // $_SERVER['REMOTE_ADDR'])
			{
				$iUserId = 0;
				$this->_setDefault();
				$this->logout();
			}
			else
			{
				$sCacheId = Phpfox::getLib('cache')->set(array('uagent', $aRow['hash']));
				$sUserAgent = Phpfox::getLib('cache')->get($sCacheId);
				if (!empty($sUserAgent))
				{
					$_SERVER['HTTP_USER_AGENT'] = $sUserAgent;
					define('PHPFOX_IS_FLASH_UPLOADER', true);
				}
				else
				{
					$iUserId = 0;
					$this->_setDefault();
					$this->logout();
				}
				// Phpfox::getLib('cache')->remove($sCacheId);
			}
		}

		if (defined('PHPFOX_INSTALLER'))
		{
			$this->_setDefault();
		}
		else
		{	
			if ($iUserId > 0)
			{
				$sSelect = '';
				$sJoin = '';

				(($sPlugin = Phpfox_Plugin::get('user.service_auth___construct_start')) ? eval($sPlugin) : false);

				$oSession = Phpfox::getLib('session');
				$oRequest = Phpfox::getLib('request');
				$bLoadUserField = false;
				$sUserFieldSelect = '';

				(($sPlugin = Phpfox_Plugin::get('user.service_auth___construct_query')) ? eval($sPlugin) : false);

				if (Phpfox::getParam('core.store_only_users_in_session'))
				{
					if (Phpfox::getParam('core.auth_user_via_session'))
					{
						$this->database()->select('ls.user_id AS session_hash, ls.id_hash, ')->join(Phpfox::getT('session'), 'ls', "ls.user_id = u.user_id");
					}
					else
					{
						$this->database()->select('ls.user_id AS session_hash, ')->leftJoin(Phpfox::getT('session'), 'ls', "ls.user_id = u.user_id");
					}
				}
				else
				{
					if ($oSession->get('session'))
					{
						$this->database()->select('ls.session_hash, ls.id_hash, ls.captcha_hash, ls.user_id, ls.im_status, ')->leftJoin(Phpfox::getT('log_session'), 'ls', "ls.session_hash = '" . $this->database()->escape($oSession->get('session')) . "' AND ls.id_hash = '" . $this->database()->escape($oRequest->getIdHash()) . "'");
					}
				}

				if ((Phpfox::getLib('request')->get('req1') == ''
						|| Phpfox::getLib('request')->get('req1') == 'request'
						|| (Phpfox::getLib('request')->get('req1') == 'theme' && Phpfox::getLib('request')->get('req2') == 'select'))
					|| (Phpfox::isModule('mail') && Phpfox::getParam('mail.display_total_mail_count')))
				{
					$this->database()->select('uc.*, ')->join(Phpfox::getT('user_count'), 'uc', 'uc.user_id = u.user_id');
				}

				if ((Phpfox::getLib('request')->get('req1') == '') || (Phpfox::getLib('request')->get('req1') == 'core'))
				{
					$bLoadUserField = true;
					$sUserFieldSelect .= 'uf.total_view, u.last_login, uf.location_latlng, ';
				}
					
				if (strtolower(Phpfox::getLib('request')->get('req1')) == Phpfox::getParam('admincp.admin_cp'))
				{
					$bLoadUserField = true;
					$sUserFieldSelect .= 'uf.in_admincp, ';						
				}
				
				if (Phpfox::isModule('ad') && Phpfox::getParam('ad.advanced_ad_filters'))
				{
					$bLoadUserField = true;
					$sUserFieldSelect .= 'uf.postal_code, uf.city_location, uf.country_child_id, ';
				}
				if ($bLoadUserField === true)
				{
					$this->database()->select($sUserFieldSelect)->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = u.user_id');
				}

                /* Hook for http://www.phpfox.com/tracker/view/13054/  */
				if ( (Phpfox::getParam('user.check_promotion_system') || $bLoadUserField === true) && (!isset($bDoActivityPoints) || (isset($bDoActivityPoints) && $bDoActivityPoints == true)))
				{
					$this->database()->select('uactivity.activity_points, uactivity.user_id AS activity_user_id, ')->leftJoin(Phpfox::getT('user_activity'), 'uactivity', 'uactivity.user_id = u.user_id');
				}

				$this->_aUser = $this->database()->select('u.profile_page_id, u.status_id, u.view_id, u.user_id, u.server_id, u.user_group_id, u.user_name, u.email, u.gender, u.style_id, u.language_id, u.birthday, u.full_name, u.user_image, u.password, u.password_salt, u.joined, u.hide_tip, u.status, u.footer_bar, u.country_iso, u.time_zone, u.dst_check, u.last_activity, u.im_beep, u.im_hide, u.is_invisible, u.total_spam, u.feed_sort ' . $sSelect)
					->from($this->_sTable, 'u')
					->where("u.user_id = '" . $this->database()->escape($iUserId) . "'")
					->execute('getRow');	
				
				if (!isset($this->_aUser['user_id']))
				{
					$this->_setDefault();
					$this->logout();
				}
				
				if (empty($this->_aUser['activity_user_id']) && (Phpfox::getParam('user.check_promotion_system') || $bLoadUserField === true))
				{
					$this->database()->delete(Phpfox::getT('user_activity'), 'user_id = ' . $this->_aUser['user_id']);
					$this->database()->insert(Phpfox::getT('user_activity'), array('user_id' => $this->_aUser['user_id']));
				}				

				if (isset($this->_aUser['password']) && isset($this->_aUser['password_salt']) && !Phpfox::getLib('hash')->getRandomHash(Phpfox::getLib('hash')->setHash($this->_aUser['password'], $this->_aUser['password_salt']), $sPasswordHash))
				{
					$this->_setDefault();
					$this->logout();
				}			

				if (isset($this->_aUser['user_id']))
				{
					$this->_aUser['age'] = Phpfox::getService('user')->age(isset($this->_aUser['birthday']) ? $this->_aUser['birthday'] : '');
					$this->_aUser['im_hide'] = ((isset($this->_aUser['is_invisible']) && $this->_aUser['is_invisible']) ? 1 : (isset($this->_aUser['im_hide']) ? $this->_aUser['im_hide'] : 1));

					if (Phpfox::getParam('core.auth_user_via_session'))
					{
						if (empty($this->_aUser['id_hash']))
						{
							$this->_setDefault();
							$this->logout();
						}

						if (isset($this->_aUser['id_hash']) && $oRequest->getIdHash() != $this->_aUser['id_hash'])
						{
							$this->_setDefault();
							$this->logout();
						}
					}
				}

				(($sPlugin = Phpfox_Plugin::get('user.service_auth___construct_end')) ? eval($sPlugin) : false);
				
				unset($this->_aUser['password'], $this->_aUser['password_salt']);
				
				if (isset($this->_aUser['fb_user_id']) && $this->_aUser['fb_user_id'] > 0 && $this->_aUser['fb_is_unlinked'])
				{
					$this->_aUser['fb_user_id'] = 0;	
				}
			}
			else
			{
				$this->_setDefault();
			}
		}		
	}

	public function getCookieNames()
	{
		return array($this->_sNameCookieUserId, $this->_sNameCookieHash);
	}

	public function getUserSession()
	{
		return $this->_aUser;
	}

	public function getUserBy($sVar = null)
	{
		if ($sVar === null && isset($this->_aUser['user_id']) && $this->_aUser['user_id'] > 0)
		{
			return $this->_aUser;
		}		

		if (isset($this->_aUser[$sVar]))
		{
			return $this->_aUser[$sVar];
		}
		return false;
	}
	
	public function setUserId($iUserId)
	{
		$this->_iOverrideUserId = $iUserId;
	}

	public function getUserId()
	{
		if ($this->_iOverrideUserId !== null)
		{
			return $this->_iOverrideUserId;
		}
		
		return (int) $this->_aUser['user_id'];
	}

	public function isUser()
	{
		return (($this->_aUser['user_id'] && Phpfox::getUserParam('user.can_stay_logged_in')) ? true : false);
	}
	
	public function isActiveAdminSession()
	{		
		if (!Phpfox::getParam('core.admincp_do_timeout'))
		{
			if (Phpfox::isAdminPanel())
			{
				$this->database()->update(Phpfox::getT('user_field'), array('in_admincp' => PHPFOX_TIME), 'user_id = ' . Phpfox::getUserId());
			}
			
			return true;
		}
		
		if (Phpfox::getUserBy('fb_user_id') > 0)
		{
			return true;				
		}
		
		$iLastLoggedIn = (int) Phpfox::getUserBy('in_admincp');
		
		if ($iLastLoggedIn < (PHPFOX_TIME - (Phpfox::getParam('core.admincp_timeout') * 60)))
		{
			return false;
		}
		
		$this->database()->update(Phpfox::getT('user_field'), array('in_admincp' => PHPFOX_TIME), 'user_id = ' . Phpfox::getUserId());
		
		return true;
	}
	
	public function setUser($aUser)
	{
		$this->_aUser = $aUser;
	}
	
	public function loginAdmin($sEmail, $sPassword)
	{		
		$aRow = $this->database()->select('user_id, user_name, password, password_salt, status_id')
			->from($this->_sTable)
			->where("email = '" . $this->database()->escape($sEmail) . "'")
			->execute('getRow');		
			
		if (!isset($aRow['user_name']))
		{
			$this->_logAdmin(1);
			
			return Phpfox_Error::set('Not a valid account.');
		}	
				
		if  ($sEmail != Phpfox::getUserBy('email'))
		{
			$this->_logAdmin(2);
			
			return Phpfox_Error::set(Phpfox::getPhrase('user.email_does_not_match_the_one_that_is_currently_in_use'));
		}
		
		if (Phpfox::getLib('hash')->setHash($sPassword, $aRow['password_salt']) != $aRow['password'])
		{
			$this->_logAdmin(3);
			
			return Phpfox_Error::set(Phpfox::getPhrase('user.invalid_password'));
		}
		
		$this->database()->update(Phpfox::getT('user_field'), array('in_admincp' => PHPFOX_TIME), 'user_id = ' . $aRow['user_id']);
		
		$this->_logAdmin();
		
		return true;
	}
	
	public function logoutAdmin()
	{
		$this->database()->update(Phpfox::getT('user_field'), array('in_admincp' => 0), 'user_id = ' . Phpfox::getUserId());
	}

	public function login($sLogin, $sPassword, $bRemember = false, $sType = 'email', $bNoPasswordCheck = false)
	{
		$sSelect = 'user_id, email, user_name, password, password_salt, status_id';
		/* Used to control the return in case we detect a brute force attack */
		$bReturn = false;

        $sLogin = $this->database()->escape($sLogin);
        
		if ($sPlugin = Phpfox_Plugin::get('user.service_auth_login__start')){eval($sPlugin);if (isset($mReturn)) return $mReturn;}
        
		$aRow = $this->database()->select($sSelect)
			->from($this->_sTable)
			->where(($sType == 'both' ? "email = '" . $sLogin . "' OR user_name = '" . $sLogin . "'" : ($sType == 'email' ? "email" : "user_name") . " = '" . $sLogin . "'"))
			->execute('getRow');
			
		if ($sPlugin = Phpfox_Plugin::get('user.service_auth_login_skip_email_verification')){eval($sPlugin);}

		if (!defined('PHPFOX_INSTALLER') && isset($aRow['status_id']) && $aRow['status_id'] == 1 && !isset($bEmailVerification)) // 0 good status; 1 => need to verify
		{
			Phpfox::getLib('session')->set('cache_user_id', $aRow['user_id']);
			
			if (defined('PHPFOX_MUST_PAY_FIRST'))
			{
				Phpfox::getLib('url')->send('subscribe.register', array('id' => PHPFOX_MUST_PAY_FIRST, 'login' => '1'));
			}
			
			Phpfox::getLib('url')->send('user.verify', null, Phpfox::getPhrase('user.you_need_to_verify_your_email_address_before_logging_in', array('email' => $aRow['email'])));
		}
				
		if (!isset($aRow['user_name']))
		{
			switch (Phpfox::getParam('user.login_type'))
			{
				case 'user_name':
					$sMessage = Phpfox::getPhrase('user.invalid_user_name');
					break;
				case 'email':
					$sMessage = Phpfox::getPhrase('user.invalid_email');
					break;
				default:
					$sMessage = Phpfox::getPhrase('user.invalid_login_id');
			}
	
				Phpfox_Error::set($sMessage);
				if ($sPlugin = Phpfox_Plugin::get('user.service_auth_login__no_user_name')){eval($sPlugin);}
				//return array(false, $aRow);
				$bReturn = true;
		}
		else
		{
			$bDoPhpfoxLoginCheck = true;
			if ($sPlugin = Phpfox_Plugin::get('user.service_auth_login__password')){eval($sPlugin);}

			if (!$bNoPasswordCheck && $bDoPhpfoxLoginCheck && (Phpfox::getLib('hash')->setHash($sPassword, $aRow['password_salt']) != $aRow['password']))
			{
				Phpfox_Error::set(Phpfox::getPhrase('user.invalid_password'));				
				//return array(false, $aRow);
				$bReturn = true;
			}
		}

		/* Add the check for the brute force here */
		if (!empty($aRow) && !defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.brute_force_time_check') > 0)
		{
			/* Check if the account is already locked */
			$iLocked = $this->database()->select('brute_force_locked_at')
							->from(Phpfox::getT('user_field'))
							->where('user_id = ' . $aRow['user_id'])
							->execute('getSlaveField');

			
						
			$iUnlockTimeOut = $iLocked + (Phpfox::getParam('user.brute_force_cool_down') * 60);
			$iRemaining = $iUnlockTimeOut - PHPFOX_TIME;
			$iTimeFrom = PHPFOX_TIME - (60 * Phpfox::getParam('user.brute_force_time_check'));
			$iAttempts = $this->database()->select('COUNT(*)')
							->from(Phpfox::getT('user_ip'))
							->where('user_id = ' . $aRow['user_id'] . ' AND type_id = "login_failed" AND time_stamp > ' . $iTimeFrom)
							->execute('getSlaveField');
			
			$aReplace = array(
					'iCoolDown' => Phpfox::getParam('user.brute_force_cool_down'),
					'sForgotLink' => Phpfox::getLib('url')->makeUrl('user.password.request'),
					'iUnlockTimeOut' => ceil($iRemaining / 60)
			);
			
			if ($iRemaining > 0)
			{
				Phpfox_Error::reset();
				Phpfox_Error::set(Phpfox::getPhrase('user.brute_force_account_locked', $aReplace));
				return array(false, $aRow);
			}			

			if ($iAttempts >= Phpfox::getParam('user.brute_force_attempts_count'))
			{
				$this->database()->update(Phpfox::getT('user_field'), array('brute_force_locked_at' => PHPFOX_TIME), 'user_id = ' . $aRow['user_id']);				

				Phpfox_Error::reset();				
				/* adjust new remaining time*/
				$aReplace['iUnlockTimeOut'] = Phpfox::getParam('user.brute_force_cool_down');
				Phpfox_Error::set(Phpfox::getPhrase('user.brute_force_account_locked', $aReplace));
				$bReturn = true;
			}
		}
		
		if ($bReturn == true)
		{			
			/* Log the attempt */
			$this->database()->insert(Phpfox::getT('user_ip'), array(
					'user_id' => isset($aRow['user_id']) ? $aRow['user_id'] : '0',
					'type_id' => 'login_failed',
					'ip_address' => Phpfox::getIp(),
					'time_stamp' => PHPFOX_TIME
				)
			);
			return array(false, $aRow);
		}
		// ban check
		$oBan = Phpfox::getService('ban');
		if (!$oBan->check('email', $aRow['email']))
		{
			Phpfox_Error::set(Phpfox::getPhrase('ban.global_ban_message'));
		}
		if (!$oBan->check('ip', Phpfox::getLib('request')->getIp()))
		{
			// this is a new phrase, text: "Your IP address is not allowed"
			Phpfox_Error::set(Phpfox::getPhrase('ban.not_allowed_ip_address'));
		}

		$aBanned = Phpfox::getService('ban')->isUserBanned($aRow);
		
		if ( $aBanned['is_banned'])
		{
			if (isset($aBanned['reason']) && !empty($aBanned['reason']))
			{
				$aBanned['reason'] = str_replace('&#039;', "'", Phpfox::getLib('parse.output')->parse($aBanned['reason']));
				$sReason = preg_replace('/\{phrase var=\'(.*)\'\}/ise', "'' . Phpfox::getPhrase('\\1',array(), false, null, '" . Phpfox::getUserBy('language_id') . "') . ''", $aBanned['reason']);
				Phpfox_Error::set($sReason);
			}
			else
			{
				Phpfox_Error::set(Phpfox::getPhrase('ban.global_ban_message'));
			}
		}
		
		if (Phpfox_Error::isPassed())
		{			
			if ($sPlugin = Phpfox_Plugin::get('user.service_auth_login__cookie_start')){eval($sPlugin);}
			$sPasswordHash = Phpfox::getLib('hash')->setRandomHash(Phpfox::getLib('hash')->setHash($aRow['password'], $aRow['password_salt']));

			// Set cookie (yummy)
			$iTime = ($bRemember ? (PHPFOX_TIME + 3600 * 24 * 365) : 0);
			Phpfox::setCookie($this->_sNameCookieUserId, $aRow['user_id'], $iTime, (Phpfox::getParam('core.force_secure_site') ? true : false));
			Phpfox::setCookie($this->_sNameCookieHash, $sPasswordHash, $iTime, (Phpfox::getParam('core.force_secure_site') ? true : false));
			if (!defined('PHPFOX_INSTALLER'))
			{
				Phpfox::getLib('session')->remove(Phpfox::getParam('core.theme_session_prefix') . 'theme');
			}
				
			$this->database()->update($this->_sTable, array('last_login' => PHPFOX_TIME), 'user_id = ' . $aRow['user_id']);	
			$this->database()->insert(Phpfox::getT('user_ip'), array(
					'user_id' => $aRow['user_id'],
					'type_id' => 'login',
					'ip_address' => Phpfox::getIp(),
					'time_stamp' => PHPFOX_TIME
				)
			);

			if (Phpfox::getParam('core.auth_user_via_session'))
			{
				$this->database()->delete(Phpfox::getT('session'), 'user_id = ' . (int) $aRow['user_id']);
				$this->database()->insert(Phpfox::getT('session'), array(
						'user_id' => $aRow['user_id'],
						'last_activity' => PHPFOX_TIME,
						'id_hash' => Phpfox::getLib('request')->getIdHash()
					)
				);
			}

			if ($sPlugin = Phpfox_Plugin::get('user.service_auth_login__cookie_end')){eval($sPlugin);}
			return array(true, $aRow);
		}
		if ($sPlugin = Phpfox_Plugin::get('user.service_auth_login__end')){eval($sPlugin);}
		return array(false, $aRow);
	}

	public function logout()
	{
		if ($sPlugin = Phpfox_Plugin::get('user.service_auth_logout__start')){eval($sPlugin);}
		if (isset($this->_aUser['user_id']))
		{
			$this->database()->insert(Phpfox::getT('user_ip'), array(
					'user_id' => $this->_aUser['user_id'],
					'type_id' => 'logout',
					'ip_address' => Phpfox::getIp(),
					'time_stamp' => PHPFOX_TIME
				)
			);

			if (Phpfox::getParam('core.auth_user_via_session') || Phpfox::getParam('core.store_only_users_in_session'))
			{
				$this->database()->delete(Phpfox::getT('session'), 'user_id = ' . (int) $this->_aUser['user_id']);
			}
		}

		Phpfox::setCookie($this->_sNameCookieUserId, '', -1);
		Phpfox::setCookie($this->_sNameCookieHash, '', -1);
		Phpfox::getLib('session')->remove(Phpfox::getParam('core.theme_session_prefix') . 'theme');
		// http://www.phpfox.com/tracker/view/14880/
		 Phpfox::getLib('session')->remove('language_id');
		if ($sPlugin = Phpfox_Plugin::get('user.service_auth_logout__end')){eval($sPlugin);}
	}

	public function hasAccess($sTable, $sField, $iId, $sUserPerm, $sGlobalPerm, $iUserId = null)
	{
		$bAccess = false;

		if (Phpfox::isUser())
		{
			if ($iUserId === null)
			{
				$iUserId = $this->database()->select('u.user_id')
				->from(Phpfox::getT($sTable), 'a')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = a.user_id')
				->where('a.' . $sField . ' = ' . (int) $iId)
				->execute('getSlaveField');

				if (!$iUserId)
				{
					$bAccess = false;
				}
			}

			if ($iUserId && Phpfox::getUserId() == $iUserId && Phpfox::getUserParam($sUserPerm))
			{
				$bAccess = $iUserId;
			}

			if ($iUserId && Phpfox::getUserParam($sGlobalPerm))
			{
				$bAccess = $iUserId;
			}
		}

		if ($bAccess === false && PHPFOX_IS_AJAX)
		{
			echo 'alert(\'' . Phpfox::getPhrase('user.you_do_not_have_permission_to_modify_this_item') . '\');';

			return false;
		}

		return $bAccess;
	}

	/**
	* Handles actions depending on the current status_id
	* @param tinyInt $iExpectedValue The expected value to match `user`.`status_id`
	* @param string $sAction What to do if `status_id` is anything else
	* @example _handleStatus(0,'deny') will return false if status_id == 0, and case to deny if !=
	* @return false if they match, | true if sAction was triggered
	* 
	*/
	public function handleStatus()
	{
		if (defined('PHPFOX_INSTALLER'))
		{
			return;
		}

		if (Phpfox::getParam('core.site_is_offline') && !Phpfox::getUserParam('core.can_view_site_offline'))
		{
			$this->_setDefault();
			$this->logout();
		}

		if (!Phpfox::getUserParam('core.is_spam_free') 
			&& Phpfox::getParam('core.enable_spam_check') 
			&& Phpfox::getParam('core.auto_ban_spammer') > 0 
			&& Phpfox::getUserBy('total_spam') > Phpfox::getParam('core.auto_ban_spammer')
		)
		{
			$this->_setDefault();
			$this->logout();
			
			Phpfox::getLib('url')->send('ban.spam');
		}

		if (Phpfox::getUserParam('core.user_is_banned'))
		{			
			// work the magic here: check if user's ban expired
			// reply: magic did not work. it created a magical bug instead.
			$aBanned = Phpfox::getService('ban')->isUserBanned();
			
			if (isset($aBanned['ban_data_id']))
			{
				if (isset($aBanned['is_expired']) && $aBanned['is_expired'] == 0
						&& isset($aBanned['end_time_stamp']) && ($aBanned['end_time_stamp'] == 0 || $aBanned['end_time_stamp'] >= PHPFOX_TIME))
				{
					$this->_setDefault();
					$this->logout();
					if (isset($aBanned['reason']) && !empty($aBanned['reason']))
					{
						$aBanned['reason'] = str_replace('&#039;', "'", Phpfox::getLib('parse.output')->parse($aBanned['reason']));
						$sReason = preg_replace('/\{phrase var=\'(.*)\'\}/ise', "'' . Phpfox::getPhrase('\\1',array(), false, null, '" . Phpfox::getUserBy('language_id') . "') . ''", $aBanned['reason']);					
						Phpfox::getLib('url')->send('',null,$sReason);
					}
					Phpfox::getLib('url')->send('ban.message');
				}
				else
				{
					// update user group here
					if (isset($aBanned['return_user_group']) && !empty($aBanned['returned_user_group']))
					{
						$this->database()->update(Phpfox::getT('user'),array('user_group_id' => $aBanned['return_user_group']), 'user_id = ' . Phpfox::getUserId());
					}
					else
					{
						$this->database()->update(Phpfox::getT('user'),array('user_group_id' => NORMAL_USER_ID), 'user_id = ' . Phpfox::getUserId());
					}
					$this->database()->update(Phpfox::getT('ban_data'),array('is_expired' => '1'),'user_id = ' . Phpfox::getUserId());
				}
			}
			else
			{
				$this->_setDefault();
				$this->logout();				
			}
		}

		// user is in good status
		if (Phpfox::isUser() && Phpfox::getUserBy('status_id') === 0) 
		{
			return;
		}
		
		if ($sPlugin = Phpfox_Plugin::get('user.service_auth_handlestatus'))
		{
			eval($sPlugin);
		}		

		// user needs to verify their email address
		if (Phpfox::isUser() && Phpfox::getUserBy('status_id') == 1 && Phpfox::getParam('user.logout_after_change_email_if_verify') && !isset($bEmailVerification))
		{			
			$this->_setDefault();
			$this->logout();
			
			if (Phpfox::getLib('request')->get('req1') != 'user' && Phpfox::getLib('request')->get('req2') != 'verify')
			{						
				Phpfox::getLib('url')->send('user.verify');
			}
		}
		
		// user needs to be approved first
		if (Phpfox::isUser() && Phpfox::getUserBy('view_id') == '1')
		{			
			$this->_setDefault();
			$this->logout();			
			
			if (Phpfox::getLib('request')->get('req1') != 'user' && Phpfox::getLib('request')->get('req2') != 'pending')
			{
				Phpfox::getLib('url')->send('user.pending');
			}
		}		
		
		if (Phpfox::isUser() && Phpfox::getParam('user.check_promotion_system'))
		{
			Phpfox::getService('user.promotion')->check();
		}
			
		return;
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_auth__call'))
		{
			return eval($sPlugin);
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
	
	private function _setDefault()
	{		
		$this->_aUser = array(
			'user_id' => 0,
			'user_group_id' => GUEST_USER_ID,
			'language_id' => Phpfox::getParam('core.default_lang_id'),
			'style_folder' => Phpfox::getParam('core.default_style_name'),
			'theme_folder' => Phpfox::getParam('core.default_theme_name')
		);
	}	
	
	private function _logAdmin($iStatus = 0)
	{
		$this->database()->insert(Phpfox::getT('admincp_login'), array(
				'user_id' => Phpfox::getUserId(),		
				'is_failed' => $iStatus,		
				'ip_address' => Phpfox::getIp(),
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

	/**
	 * This function allows a user to log in as another user.
	 * @param array $aUser
	 * @return boolean
	 */
	public function snoop($aUser)
	{
		Phpfox::isUser(true);
		if (!Phpfox::getUserParam('user.can_member_snoop'))
		{
			return Phpfox_Error::set('Admin lacks permissions');
		}
		$sPasswordHash = Phpfox::getLib('hash')->setRandomHash(Phpfox::getLib('hash')->setHash($aUser['password'], $aUser['password_salt']));

		// Set cookie (yummy)
		$iTime = 0;
		$this->database()->insert(Phpfox::getT('user_snoop'), array(
			'time_stamp' => PHPFOX_TIME,
			'user_id' => Phpfox::getUserId(),
			'logging_in_as' => $aUser['user_id']
		));

		Phpfox::setCookie($this->_sNameCookieUserId, $aUser['user_id'], $iTime);
		Phpfox::setCookie($this->_sNameCookieHash, $sPasswordHash, $iTime);
		if (!defined('PHPFOX_INSTALLER'))
		{
			Phpfox::getLib('session')->remove(Phpfox::getParam('core.theme_session_prefix') . 'theme');
		}

		$this->database()->update($this->_sTable, array('last_login' => PHPFOX_TIME), 'user_id = ' . $aUser['user_id']);
		$this->database()->insert(Phpfox::getT('user_ip'), array(
			'user_id' => $aUser['user_id'],
			'type_id' => 'login',
			'ip_address' => Phpfox::getIp(),
			'time_stamp' => PHPFOX_TIME
				)
		);
		return true;
	}

}

?>
