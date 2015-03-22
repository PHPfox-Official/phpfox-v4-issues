<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

require_once(PHPFOX_DIR_LIB . 'twitter' . PHPFOX_DS . 'EpiCurl.php');
require_once(PHPFOX_DIR_LIB . 'twitter' . PHPFOX_DS . 'EpiOAuth.php');
require_once(PHPFOX_DIR_LIB . 'twitter' . PHPFOX_DS . 'EpiTwitter.php');

/**
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: twitter.class.php 7049 2014-01-16 14:29:05Z Fern $
 */
class Phpfox_Twitter
{
	private $_oTwitter = null;
	private $_sToken = null;
	private $_sSecret = null;
	
	public function __construct()
	{
		$this->_oTwitter = new EpiTwitter(Phpfox::getParam('share.twitter_consumer_key'), Phpfox::getParam('share.twitter_consumer_secret'));
	}	
	
	public function post($sMessage)
	{
		$aTwitter = Phpfox::getService('share')->hasConnection('twitter');
		
		if (!empty($aTwitter['token']))
		{
			// http://www.phpfox.com/tracker/view/15012/
			$this->_oTwitter->useSSL(true);
			
			$this->_oTwitter->setToken($aTwitter['token'], $aTwitter['secret']);
			$update_status = $this->_oTwitter->post_statusesUpdate(array('status'  => $sMessage));
			$temp = $update_status->response;			
		}		
	}
	
	public function getToken()
	{
		return $this->_sToken;
	}
	
	public function getSecret()
	{
		return $this->_sSecret;
	}
	
	public function getUser($sToken)
	{
		$this->_oTwitter->setToken($sToken);
		$token = $this->_oTwitter->getAccessToken();
		$this->_oTwitter->setToken($token->oauth_token, $token->oauth_token_secret);	
		
		// http://www.phpfox.com/tracker/view/15012/
		$this->_oTwitter->useSSL(true);
		
		$mReturn = $this->_oTwitter->get_accountVerify_credentials();
		
		$this->_sToken = $token->oauth_token;
		$this->_sSecret = $token->oauth_token_secret;
		
		return (array) $mReturn->response;
	}
	
	public function getUrl()
	{
		Phpfox_Error::skip(true);
		$mReturn = $this->_oTwitter->getAuthorizationUrl();
		Phpfox_Error::skip(false);
		
		return $mReturn;
	}
}

?>
