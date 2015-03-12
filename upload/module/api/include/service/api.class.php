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
 * @version 		$Id: api.class.php 5382 2013-02-18 09:48:39Z Miguel_Espinoza $
 */
class Api_Service_Api extends Phpfox_Service 
{
	private $_aApi = array();
	private $_bError = false;
	private $_sFormat = 'xml';
	private $_aOutput = array();
	private $_iTotal = 0;
	private $_aOpenSSLConfig = array();
	private $_oService = null;
	private $_sMethod = '';
	private $_sModule = '';
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('app');	
		if ($this->get('format') != '')
		{
			$this->_sFormat = $this->get('format');	
		}
		if (!defined('OPENSSL_KEYTYPE_RSA'))
		{
			return false;
		}
		$this->_aOpenSSLConfig = array(
			'digest_alg' => 'md5',
			'x509_extensions' => 'v3_ca',
			'req_extensions'   => 'v3_req',
			'private_key_bits' => 666,
			'private_key_type' => OPENSSL_KEYTYPE_RSA,
			'encrypt_key' => false		
		);	
		
		if (Phpfox::getParam('apps.openssl_config_path') != '')
		{
			$this->_aOpenSSLConfig['config'] = Phpfox::getParam('apps.openssl_config_path');
		}
	}
	
	public function test()
	{
		if (!function_exists('openssl_pkey_new'))
		{
			return Phpfox_Error::set('OpenSSL does not seem to be installed on your server.');
		}
		
		$res = openssl_pkey_new($this->_aOpenSSLConfig);
		
		if (!$res)
		{
			return Phpfox_Error::set('Unable to create a new private key. Please check OpenSSL configuration.');
		}
		
		return true;
	}

	public function getAppName()
	{
		return $this->_aApi['app_title'];
	}
	
	public function createToken($sKey)
	{
		if (!Phpfox::getParam('apps.enable_api_support'))
		{
			$this->error('api.enable_api_support', 'API support for this community is currently disabled.');	
			
			return $this->_sendResponse();			
		}
		
		if (empty($sKey))
		{
			$this->error('api.unable_to_find_api_key', 'Unable to find API key.');	
			
			return $this->_sendResponse();
		}
		
		$aApp = $this->database()->select('a.*, ai.user_id AS installed_user_id')
			->from(Phpfox::getT('app_key'), 'ak')
			->join($this->_sTable, 'a', 'a.app_id = ak.app_id')			
			->join(Phpfox::getT('app_installed'), 'ai', 'ai.app_id = a.app_id AND ai.user_id = ak.user_id')
			->where('ak.key_check = \'' . $this->database()->escape($sKey) . '\'')
			->execute('getSlaveRow');	
		
		if (!isset($aApp['app_id']))
		{
			$this->error('api.unable_to_find_api_key', 'Unable to find API key.');	
			
			return $this->_sendResponse();
		}		
		
		$res = openssl_pkey_new($this->_aOpenSSLConfig);

		openssl_pkey_export($res, $privKey, $aApp['private_key'], $this->_aOpenSSLConfig);

		$pubKey = openssl_pkey_get_details($res);		
		
        if ($sPlugin = Phpfox_Plugin::get('api.service_api_createtoken_1')){eval($sPlugin);}
        
		$this->database()->delete(Phpfox::getT('app_access'), 'app_id = ' . $aApp['app_id'] . ' AND user_id = ' . $aApp['installed_user_id']);
		$this->database()->insert(Phpfox::getT('app_access'), array(
				'app_id' => $aApp['app_id'],
				'user_id' => $aApp['installed_user_id'],
				'token' => md5($pubKey['key']),
				'token_key' => $pubKey['key'],
				'token_private' => $privKey,
				'time_stamp' => PHPFOX_TIME
			)
		);
				
		return json_encode(array('token' => base64_encode($pubKey['key'])));
	}
	
	public function process()
	{		
		if (!Phpfox::getParam('apps.enable_api_support'))
		{
			$this->error('api.enable_api_support', 'API support for this community is currently disabled.');	
			
			return $this->_sendResponse();			
		}		
		
		$_SERVER['HTTP_USER_AGENT'] = 'phpfox';
		
		$this->_aApi = $this->database()->select('a.*, aa.token_key, aa.token_private, ai.user_id AS target_user_id, u.user_group_id')
			->from(Phpfox::getT('app_access'), 'aa')
			->join(Phpfox::getT('app'), 'a', 'a.app_id = aa.app_id')
			->join(Phpfox::getT('app_installed'), 'ai', 'ai.app_id = a.app_id AND ai.user_id = aa.user_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = ai.user_id')
			->where('aa.token = \'' . $this->database()->escape(md5(base64_decode($this->get('token')))) . '\'')
			->execute('getSlaveRow');
		
		if (!isset($this->_aApi['app_id']))
		{
			$this->error('api.unable_to_find_api_key', 'Unable to find API key.');	
			
			return $this->_sendResponse();
		}		
		
		if (!openssl_public_encrypt($this->_aApi['app_id'], $encrypted, $this->_aApi['token_key']))
		{
			$this->error('api.unable_to_encrypt', 'Unable to encrypt token.');	
			
			return $this->_sendResponse();
		}

		if (!openssl_private_decrypt($encrypted, $decrypted, $this->_aApi['token_private']))
		{
			$this->error('api.unable_to_decrypt', 'Unable to decrypt token.');	
			
			return $this->_sendResponse();
		}		

		if ($this->get('method') == '')
		{
			$this->error('api.method_not_defined', 'Method not defined.');
			return $this->_sendResponse();
		}
		
		$aParts = explode('.', $this->get('method'));
		
		if (!isset($aParts[1]))
		{
			$this->error('api.method_not_correctly_defined', 'Method not correctly defined.');
			
			return $this->_sendResponse();
		}		
					
		$sModule = $aParts[0];
		$sMethod = $aParts[1];
		$this->_sModule = $sModule;
		$this->_sMethod = $sMethod;

		if (!Phpfox::isModule($sModule))
		{
			$this->error('5', 'Module does not exist.');
			
			return $this->_sendResponse();
		}
	
		// Used to forge Phpfox::getUserId()			
		define('PHPFOX_APP_USER_ID', $this->_aApi['target_user_id']);
		define('PHPFOX_APP_USER_GROUP_ID', $this->_aApi['user_group_id']);
		
		// Used to skip passing params everywhere
		define('PHPFOX_APP_ID', $this->_aApi['app_id']);		
		
		$this->_oService = Phpfox::getService($sModule . '.api');
		if (!method_exists($this->_oService, $sMethod))
		{
			$this->error('api.method_not_valid_for_module', 'Method for this module does not exist.');
			return $this->_sendResponse();
		}
				
		$mOutput = $this->_oService->$sMethod();
		
		if ($this->isPassed())
		{
			$this->_aOutput = $mOutput;

			return $this->_sendResponse();
		}

		if (empty($this->_aOutput))
		{
			$this->_bError = true;
			$this->_aOutput = array('error_message' => implode('', Phpfox_Error::get()));
		}
		$this->_aOutput = array_merge(array('error' => $this->_bError), $this->_aOutput);			
		
		return $this->_sendResponse();
	}
	
	public function getUserId()
	{
		return (int) $this->_aApi['target_user_id'];
	}
	
	public function setTotal($iTotal)
	{
		$this->_iTotal = (int) $iTotal;
	}
	
	public function isAllowed($sVariable, $iUserId = null, $iAppId = null)
	{
		static $aPrivileges;
		
		if ($iAppId === null)
		{
			$iAppId = $this->_aApi['app_id'];
		}
		
		if ($iUserId === null)
		{
			$iUserId = $this->_aApi['target_user_id'];
		}
		
		if (!isset($aPrivileges[$iAppId]) && !isset($aPrivileges[$iAppId][$iUserId]))
		{
			$aRows = $this->database()->select('var_name')
					->from(Phpfox::getT('app_disallow'))
					->where('app_id = ' . (int)$iAppId . ' AND user_id = ' . (int)$iUserId . '')
					->execute('getSlaveRows');
			
			$aPrivileges[$iAppId][$iUserId] = array();
			foreach ($aRows as $aRow)
			{
				$aPrivileges[$iAppId][$iUserId][$aRow['var_name']] = true;
			}
		}
		
		return (isset($aPrivileges[$iAppId][$iUserId][$sVariable]) ? false : true);
	}
	
	public function get($sRequest)
	{
		return Phpfox::getLib('request')->get($sRequest);
	}	
	
	public function isPassed()
	{
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}
		
		return ($this->_bError ? false : true);
	}
	
	public function error($iErrorId, $sErrorMessage)
	{
		$this->_bError = true;	
		$this->_aOutput = array(
			'error_id' => $iErrorId,
			'error_message' => (empty($sErrorMessage) ? implode('', Phpfox_Error::get()) : $sErrorMessage)
		);
		
		return false;
	}	
	
	private function _sendResponse()
	{	
		$sOutput = json_encode(array(
				'api' => array(	
					'total' => $this->_iTotal,
					'current_page' => $this->get('page')
				),
				'output' => $this->_aOutput
			)
		);	
		if ($sPlugin = Phpfox_Plugin::get('api.service_api_sendresponse_1')){eval($sPlugin);}
		echo $sOutput;		
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
		if ($sPlugin = Phpfox_Plugin::get('api.service_api__call'))
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