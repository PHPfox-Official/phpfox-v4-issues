<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Service
 * @version 		$Id: api.class.php 5129 2013-01-14 12:38:16Z Raymond_Benc $
 */
class Like_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('like');
		$this->_oApi = Phpfox::getService('api');	
	}
	
	public function process()
	{
		/*
		@title
		@info Like/Unlike an item. Return <b>true</b> on success, <b>false</b> on failure.
		@method POST
		@extra module=#{Module name|string|yes}&id=#{ID# for the item.|int|yes}
		@return
		*/
				
		if ($this->_oApi->get('type') == 'add' && Phpfox::getService('like.process')->add($this->_oApi->get('module'), $this->_oApi->get('id')))
		{
			return true;
		}
		elseif ($this->_oApi->get('type') == 'remove' && Phpfox::getService('like.process')->delete($this->_oApi->get('module'), $this->_oApi->get('id')))
		{
			return true;
		}
			
		return false;
	}
}

?>
