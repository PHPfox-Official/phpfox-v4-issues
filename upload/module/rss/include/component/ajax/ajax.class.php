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
 * @package  		Module_Rss
 * @version 		$Id: ajax.class.php 704 2009-06-21 18:50:42Z Raymond_Benc $
 */
class Rss_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function updateFeedActivity()
	{		
		if (Phpfox::getService('rss.process')->updateActivity($this->get('id'), $this->get('active')))
		{
			
		}
	}	
	
	public function updateSiteWide()
	{		
		if (Phpfox::getService('rss.process')->updateSiteWide($this->get('id'), $this->get('active')))
		{
			
		}
	}		
	
	public function ordering()
	{
		if (Phpfox::getService('rss.process')->updateOrder($this->get('val')))
		{
			
		}		
	}	
	
	public function groupOrdering()
	{
		if (Phpfox::getService('rss.group.process')->updateOrder($this->get('val')))
		{
			
		}		
	}

	public function log()
	{
		Phpfox::isUser(true);
		Phpfox::getBlock('rss.log', array(
				'rss' => array(
					'table' => 'rss_log_user',
					'field' => 'user_id',
					'key' => Phpfox::getUserId()
				)
			)
		);
	}
}

?>