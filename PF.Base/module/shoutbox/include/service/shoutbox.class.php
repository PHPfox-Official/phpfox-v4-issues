<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Main shoutbox service that we use to retrieve shoutouts.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Shoutbox
 * @version 		$Id: shoutbox.class.php 6277 2013-07-16 12:59:34Z Raymond_Benc $
 */
class Shoutbox_Service_Shoutbox extends Phpfox_Service 
{
	private $_aCallback = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('shoutbox');	
	}
	
	public function callback($aCallback)
	{
		$this->_aCallback = $aCallback;
		
		return $this;
	}
	
	/**
	 * Get the latest shoutouts.
	 *
	 * @param int $iLimit Define the limit so we don't return all the shoutouts.
	 * @return array Array of shoutouts.
	 */
	public function getMessages($iLimit = 5)
	{
		if (isset($this->_aCallback['module']))
		{
			if (Phpfox::hasCallback($this->_aCallback['module'], 'getShoutboxData'))
			{
				$aCallback = Phpfox::callback($this->_aCallback['module'] . '.getShoutboxData');		
				if (isset($aCallback['table']))
				{
					$this->_sTable = Phpfox::getT($aCallback['table']);
					
					$this->database()->where('item_id = ' . (int) $this->_aCallback['item']);
				}
			}
		}				
		
		$aMessages = $this->database()->select('s.shout_id, s.text, s.time_stamp, ' . Phpfox::getUserField())
			->from($this->_sTable, 's')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = s.user_id')
			->limit($iLimit)
			->order('s.time_stamp DESC')
			->execute('getSlaveRows');

		foreach ($aMessages as $iKey => $aMessage)
		{
			$aMessage['text'] = Phpfox::getLib('parse.output')->replaceHashTags(Phpfox::getLib('parse.output')->split(Phpfox::getLib('parse.output')->clean($aMessage['text']), Phpfox::getParam('shoutbox.shoutbox_wordwrap')));
				
			if (Phpfox::isModule('emoticon'))
			{
				$aMessages[$iKey]['text'] = Phpfox::getService('emoticon')->parse($aMessage['text']);
			}
			$aMessages[$iKey]['module'] = (isset($this->_aCallback['module']) ? $this->_aCallback['module'] : '');
		}
			
		return $aMessages;
	}
	
	public function getSqlTitleField()
	{
		return array(
			'table' => 'shoutbox',
			'field' => 'text'
		);
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
		if ($sPlugin = Phpfox_Plugin::get('shoutbox.service_shoutbox__call'))
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