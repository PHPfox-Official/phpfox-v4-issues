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
 * @version 		$Id: ajax.class.php 892 2009-08-24 13:23:36Z Raymond_Benc $
 */
class Ban_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function ip()
	{		
		if ($this->get('active'))
		{
			Phpfox::getService('ban.process')->add(array(
					'type_id' => 'ip',
					'find_value' => $this->get('ip')
				)
			);
		}
		else 
		{
			Phpfox::getService('ban.process')->deleteByValue('ip', $this->get('ip'));
		}
	}
}

?>