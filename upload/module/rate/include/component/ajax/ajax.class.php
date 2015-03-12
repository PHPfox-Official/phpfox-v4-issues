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
 * @version 		$Id: ajax.class.php 100 2009-01-26 15:15:26Z Raymond_Benc $
 */
class Rate_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function process()
	{
		if (Phpfox::getService('rate.process')->add($this->get('rating')))
		{
			$this->call('$Core.rate.success();');
		}
	}
}

?>