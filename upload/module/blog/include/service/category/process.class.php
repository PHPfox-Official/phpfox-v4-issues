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
 * @package  		Module_Blog
 * @version 		$Id: process.class.php 3072 2011-09-12 13:23:50Z Raymond_Benc $
 */
class Blog_Service_Category_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('blog_category');
	}
	
	public function update($iId, $sCategory, $iUserId)
	{
		$sNew = Phpfox::getLib('parse.input')->clean($sCategory, 255);
		
		$iId = $this->database()->update($this->_sTable, array(
			'name' => $sNew			
		), 'category_id = ' . (int) $iId);		
		
		return $sNew;
	}
	
	public function add($sCategory, $iUserId = null)
	{
		$iId = $this->database()->insert(Phpfox::getT('blog_category'), array(
				'name' => Phpfox::getLib('parse.input')->clean($sCategory, 255),
				'user_id' => ($iUserId === null ? Phpfox::getUserId() : $iUserId),
				'added' => PHPFOX_TIME
			)
		);
		
		return $iId;
	}	
	
	public function deleteMultiple($aIds)
	{
		foreach ($aIds as $iId)
		{
			$this->database()->delete($this->_sTable, 'category_id = ' . (int) $iId);
			$this->database()->delete(Phpfox::getT('blog_category_data'), 'category_id = ' . (int) $iId);			
		}
		return true;
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
		if ($sPlugin = Phpfox_Plugin::get('blog.service_category_process__call'))
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