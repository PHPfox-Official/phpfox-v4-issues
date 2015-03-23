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
 * @package  		Module_Attachment
 * @version 		$Id: type.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Attachment_Service_Type extends Phpfox_Service 
{
	private $_aTypes = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('attachment_type');
		
		$sCacheId = $this->cache()->set('attachment_type');
		if (!($this->_aTypes = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('extension')
				->from($this->_sTable)
				->where('is_active = 1')
				->order('extension')
				->execute('getRows');
			
			foreach ($aRows as $aRow)
			{
				$this->_aTypes[] = $aRow['extension'];
			}
		
			(($sPlugin = Phpfox_Plugin::get('attachment.service_type___construct')) ? eval($sPlugin) : false);
				
			$this->cache()->save($sCacheId, $this->_aTypes);
		}			
	}
	
	public function get()
	{
		$aRows = $this->database()->select('*')
			->from($this->_sTable)
			->execute('getRows');
			
		return $aRows;
	}
	
	public function getForEdit($sExt)
	{
		return $this->database()->select('*')
			->from($this->_sTable)
			->where('extension = \'' . $this->database()->escape($sExt) . '\'')
			->execute('getRow');	
	}
	
	public function getTypes()
	{		
		return $this->_aTypes;
	}
	
	public function isValid($sExt)
	{
		return (in_array($sExt, $this->_aTypes) ? true : false);
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
		if ($sPlugin = Phpfox_Plugin::get('attachment.service_type__call'))
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