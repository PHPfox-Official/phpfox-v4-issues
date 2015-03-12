<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * SPAM/Flood Control Class
 * Handles global SPAM & Flood control checks with support for plugins.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: spam.class.php 1668 2010-07-12 08:54:32Z Raymond_Benc $
 */
class Phpfox_Spam
{
	/**
	 * Database object
	 *
	 * @var object
	 */
	private $_oDb = null;
	
	/**
	 * Params passed via the check() method
	 *
	 * @var array
	 */
	private $_aParams = array();	
	
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_oDb = Phpfox::getLib('database');
	}
	
	/**
	 * Method used to call other private methods which control the spam/flood methods.
	 *
	 * @param array $aParams Array of params used with spam/flood methods provided.
	 * @return mixed Returns data based on the spam/flood method.
	 */
	public function check($aParams = array())
	{
		// Make sure we have an action
		if (!isset($aParams['action']))
		{
			return Phpfox_Error::trigger('SPAM action not defined.', E_USER_ERROR);
		}
		
		// Fix the action so we can call a private method
		$sMethod = '_' . str_replace('_', '', $aParams['action']);
		
		// Store the params in a private var so we can use within other private methods.
		$this->_aParams = $aParams['params'];
		
		$this->_aParams['is_spam'] = false;
		
		// Make sure this action is valid
		if (!method_exists($this, $sMethod))
		{
			return Phpfox_Error::trigger('Not a valid SPAM action.', E_USER_ERROR);
		}
		
		// Return the data our methods provide
		return call_user_func(array($this, $sMethod));
	}	
	
	/**
	 * Gets the time phrase of how long a user must wait before they can repost on the same section.
	 *
	 * @return string
	 */
	public function getWaitTime()
	{
		$iTime = round(((($this->_aParams['last_time_stamp'] + $this->_aParams['time_stamp']) - PHPFOX_TIME) / 60));		
		
		if ($iTime <= 1)
		{
			if (str_replace('-', '', (PHPFOX_TIME - ($this->_aParams['last_time_stamp'] + $this->_aParams['time_stamp']))) == '1')
			{
				$iTime = Phpfox::getPhrase('core.try_again_in_1_second');
			}
			else 
			{
				$sTime = Phpfox::getPhrase('core.try_again_in_time_seconds', array('time' => str_replace('-', '', (PHPFOX_TIME - ($this->_aParams['last_time_stamp'] + $this->_aParams['time_stamp'])))));
			}
		}
		else 
		{
			$sTime = Phpfox::getPhrase('core.try_again_in_time_minutes', array('time' => $iTime));
		}
		
		return $sTime;
	}
		
	/**
	 * SPAM control that checks the last time a user posted an item.
	 *
	 * Inline Example:
	 * <code>
	 * Phpfox::getLib('spam')->check(array(
	 *				'action' => 'last_post', // The SPAM action
	 *				'params' => array(
	 *					'field' => 'time_stamp', // The time stamp field
	 *					'table' => Phpfox::getT('shoutbox'), // Database table we plan to check
	 *					'condition' => 'user_id = ' . Phpfox::getUserId(), // Database WHERE query
	 *					'time_stamp' => Phpfox::getParam('shoutbox.shoutbox_flood_limit') // Seconds
	 *				)
	 *			)
	 *		);
	 * </code>
	 *
	 * @return boolean Returns TRUE if user has posted an item within X seconds, FALSE if they have nothing new posted.
	 */
	private function _lastPost()
	{
		$iTimeStamp = $this->_oDb->select($this->_aParams['field'])
			->from($this->_aParams['table'])
			->where($this->_aParams['condition'])
			->order($this->_aParams['field'] . ' DESC')
			->limit('1')
			->execute('getField');			
			
		$this->_aParams['last_time_stamp'] = $iTimeStamp;
						
		return (((PHPFOX_TIME - $iTimeStamp) < $this->_aParams['time_stamp']) ? true : false);		
	}
	
	/**
	 * Check to see if the content being passed is considered as SPAM.
	 *
	 * @return bool TRUE is spam, FALSE if it isn't.
	 */
	private function _isSpam()
	{
		if (Phpfox::getUserParam('core.is_spam_free'))
		{
			return false;
		}
		
		if (!Phpfox::getParam('core.enable_spam_check'))
		{
			return false;
		}
		
		if (Phpfox::isUser() && Phpfox::getUserBy('total_spam') > Phpfox::getParam('core.auto_deny_items'))
		{
			$this->_aParams['is_spam'] = true;
			
			return true;
		}
		
		$sUrl = Phpfox::getParam('core.akismet_url');
		$sPassword = Phpfox::getParam('core.akismet_password');
		
		if (empty($sUrl) || empty($sPassword))
		{
			return false;
		}
		
		$sAkismet = PHPFOX_DIR_LIB . 'akismet' . PHPFOX_DS . 'Akismet.class.php';
		if (file_exists($sAkismet))
		{
			require_once($sAkismet);
	
			$oAkismet = new Akismet($sUrl, $sPassword);
	
			if (Phpfox::isUser())
			{
				$oAkismet->setCommentAuthor(Phpfox::getUserBy('full_name'));
				$oAkismet->setCommentAuthorEmail(Phpfox::getUserBy('email'));
			}
			else 
			{
				if (isset($this->_aParams['user']))
				{
					$oAkismet->setCommentAuthor($this->_aParams['user']);
				}
				
				if (isset($this->_aParams['email']))
				{
					$oAkismet->setCommentAuthorEmail($this->_aParams['email']);
				}
			}
			
			if (isset($this->_aParams['url']))
			{
				$oAkismet->setCommentAuthorURL($this->_aParams['url']);
			}
			
			if (isset($this->_aParams['link']))
			{
				$oAkismet->setPermalink($this->_aParams['link']);
			}
			
			if (isset($this->_aParams['content']))
			{
				$oAkismet->setCommentContent($this->_aParams['content']);
			}		
	
			if (($this->_aParams['is_spam'] = $oAkismet->isCommentSpam()) === true)
			{
				Phpfox::getLib('database')->updateCounter('user', 'total_spam', 'user_id', Phpfox::getUserId());				
			}
				
			return $this->_aParams['is_spam'];
		}
		
		return false;
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
		if (($sPlugin = Phpfox_Plugin::get('spam_methods')) !== false)
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>