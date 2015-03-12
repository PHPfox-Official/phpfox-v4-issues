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
 * @version 		$Id: log.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Rss_Service_Log_Log extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function getFeed($iId)
	{
		$aFeed = $this->database()->select('r.*')
			->from(Phpfox::getT('rss'), 'r')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = r.module_id AND m.is_active = 1')
			->join(Phpfox::getT('product'), 'p', 'p.product_id = r.product_id AND p.is_active = 1')
			->where('r.feed_id = ' . (int) $iId)
			->execute('getRow');	
			
		if (!isset($aFeed['feed_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('rss.unable_to_find_the_feed_you_are_looking_for'));
		}
		
		return $aFeed;
	}	
	
	public function get($aParams)
	{
		$aLogs = $this->database()->select('p.user_agent, COUNT(user_agent) AS total_agent_count')
			->from(Phpfox::getT($aParams['table']), 'p')
			->where('' . $aParams['field'] . ' = ' . (int) $aParams['key'])
			->group('p.user_agent')
			->order('total_agent_count DESC')
			->execute('getSlaveRows');		
			
		foreach ($aLogs as $iKey => $aLog)
		{			
			$aLogs[$iKey]['user_agent_chart'] = substr($aLog['user_agent'], 0, 15) . (strlen($aLog['user_agent']) > 15 ? '...' : '');
		}
		
		return $aLogs;
	}
	
	public function getUsers($aParams, $iPage = 0, $iLimit)
	{
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT($aParams['table']), 'p')
			->where('' . $aParams['field'] . ' = ' . (int) $aParams['key'])			
			->execute('getSlaveField');	
		
		$aLogs = $this->database()->select('p.*')
			->from(Phpfox::getT($aParams['table']), 'p')
			->where('' . $aParams['field'] . ' = ' . (int) $aParams['key'])			
			->order('p.time_stamp DESC')
			->limit($iPage, $iLimit, $iCnt)
			->execute('getSlaveRows');		
		
		return array($iCnt, $aLogs);
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
		if ($sPlugin = Phpfox_Plugin::get('rss.service_log_log__call'))
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