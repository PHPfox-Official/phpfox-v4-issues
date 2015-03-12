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
 * @version 		$Id: group.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Rss_Service_Group_Group extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('rss_group');	
	}
	
	public function getForEdit($iId)
	{
		$aGroup = $this->database()->select('rg.*')
			->from($this->_sTable, 'rg')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = rg.module_id AND m.is_active = 1')
			->join(Phpfox::getT('product'), 'p', 'p.product_id = rg.product_id AND p.is_active = 1')
			->where('rg.group_id = ' . (int) $iId)
			->execute('getRow');	
			
		if (!isset($aGroup['group_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('rss.unable_to_find_the_group_you_are_planning_to_edit'));
		}
		
		return $aGroup;
	}	
	
	public function get()
	{
		return $this->database()->select('rg.*')
			->from($this->_sTable, 'rg')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = rg.module_id AND m.is_active = 1')
			->join(Phpfox::getT('product'), 'p', 'p.product_id = rg.product_id AND p.is_active = 1')
			->order('rg.ordering ASC')
			->execute('getRows');		
	}
	
	public function getDropDown()
	{
		return $this->database()->select('rg.group_id, rg.name_var')
			->from($this->_sTable, 'rg')
			->join(Phpfox::getT('module'), 'm', 'm.module_id = rg.module_id AND m.is_active = 1')
			->join(Phpfox::getT('product'), 'p', 'p.product_id = rg.product_id AND p.is_active = 1')
			->where('rg.is_active = 1')
			->order('rg.ordering ASC')
			->execute('getRows');
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
		if ($sPlugin = Phpfox_Plugin::get('rss.service_group_group__call'))
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