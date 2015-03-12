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
class Notification_Component_Ajax_Ajax extends Phpfox_Ajax
{	
	public function update()
	{
		Phpfox::massCallback('getGlobalNotifications');
        
        if ($sPlugin = Phpfox_Plugin::get('notification.component_ajax_update_1')){eval($sPlugin);}
        
		$this->call('$Core.notification.setTitle();');
	}
	
	public function updateSeen()
	{
		Phpfox::isUser(true);
		$sIds = $this->get('id');
		if (!empty($sIds) && Phpfox::getLib('parse.format')->isSerialized($sIds))
		{
			foreach (unserialize($sIds) as $iId)
			{
				Phpfox::getService('notification.process')->updateSeen($iId);
			}		
		}
	}

	public function getAll()
	{
		if (!Phpfox::isUser())
		{
			$this->call('<script type="text/javascript">window.location.href = \'' . Phpfox::getLib('url')->makeUrl('user.login') . '\';</script>');
		}
		else
		{
			// This function caches into a static so it shouldn't be an extra load
			/*
			$aNotifications = Phpfox::getService('notification')->get();
			if (count($aNotifications) < 1)
			{
				$this->call('<script type="text/javascript">$("#js_total_new_notifications").hide();</script>');
			}
			*/
			Phpfox::getBlock('notification.link');
		}
	}
	
	public function delete()
	{
		Phpfox::isUser(true);
		
		if (Phpfox::getService('notification.process')->deleteById($this->get('id')))
		{
			$this->slideUp('#js_notification_' . $this->get('id'));
		}
	}
	
	public function removeAll()
	{
		Phpfox::isUser(true);
		
		if (Phpfox::getService('notification.process')->deleteAll())
		{
			$this->hide('#js_notification_holder');
			$this->show('#js_no_notifications');
		}
		
		$this->hide('.table_clear_ajax');
	}
}

?>