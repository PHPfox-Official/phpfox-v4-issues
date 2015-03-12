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
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 679 2009-06-15 19:45:45Z Raymond_Benc $
 */
class Log_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function getUserLoginEditBar()
	{
		Phpfox::getBlock('log.setting');
		
		$this->html('#js_edit_block_' . $this->get('block_id'), $this->getContent(false))->slideDown('#js_edit_block_' . $this->get('block_id'));
	}	
}

?>