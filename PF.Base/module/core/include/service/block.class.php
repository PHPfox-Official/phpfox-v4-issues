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
 * @version 		$Id: block.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Core_Service_Block extends Phpfox_Service 
{
	private $_bPassedWhatsNewBlock = false;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function whatsNewBlocks()
	{
		return $this->_bPassedWhatsNewBlock;
	}
	
	public function prepareWhatsNewBlocks($aVals)
	{
		if (!isset($aVals['display']))
		{
			return false;
		}
		
		$this->_bPassedWhatsNewBlock = true;
		
		return serialize(array(
				'm' => $aVals['display']
			)
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
		if ($sPlugin = Phpfox_Plugin::get('core.service_block__call'))
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