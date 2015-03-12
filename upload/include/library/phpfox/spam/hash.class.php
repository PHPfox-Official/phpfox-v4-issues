<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * SPAM Hash Check
 * Checks content being added to the site and looks over if it has been
 * added in the past.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: hash.class.php 1668 2010-07-12 08:54:32Z Raymond_Benc $
 */
class Phpfox_Spam_Hash
{
	/**
	 * Params we pass on how the SPAM check should behave.
	 *
	 * @var array
	 */
	private $_aParams = array();
	
	/**
	 * Class constructor. Load all the params on how the SPAM check 
	 * should behave.
	 *
	 * @param array $aParams ARRAY of settings.
	 */
	public function __construct($aParams = array())
	{
		$this->_aParams = $aParams;
		$this->_oDb = Phpfox::getLib('database');
	}
	
	/**
	 * Checks to see if the content being passed is considered as SPAM.
	 *
	 * @return bool TRUE if it is spam, FALSE if it isn't spam.
	 */
	public function isSpam()
	{		
		if (empty($this->_aParams['content']))
		{
			Phpfox_Error::set(Phpfox::getPhrase('core.content_is_empty'));
			
			return true;
		}
		
		$this->_aParams['content'] = md5(str_replace(array("\n", "\r", "\t", " ", "\o", "\xOB"), '', $this->_aParams['content']));	
		
		$sCount = $this->_oDb->select('COUNT(*)')
			->from(Phpfox::getT($this->_aParams['table']))
			->where('user_id = ' . Phpfox::getUserId() . ' AND item_hash = \'' . $this->_oDb->escape($this->_aParams['content']) . '\' AND time_stamp >= \'' . (PHPFOX_TIME - ($this->_aParams['time'] * 60)) . '\'')
			->limit($this->_aParams['total'])
			->order('time_stamp DESC')
			->execute('getSlaveField');
			
		if ((int) $sCount > 0)
		{
			Phpfox::getLib('database')->updateCounter('user', 'total_spam', 'user_id', Phpfox::getUserId());
			
			Phpfox_Error::set(Phpfox::getPhrase('core.the_content_of_this_item_is_identical_to_something_you_have_added_before_please_try_again'));
			
			return true;
		}
		
		$this->_oDb->insert(Phpfox::getT($this->_aParams['table']), array(
				'user_id' => Phpfox::getUserId(),
				'item_hash' => $this->_aParams['content'],
				'time_stamp' => PHPFOX_TIME
			)
		);
		
		return false;
	}
}

?>