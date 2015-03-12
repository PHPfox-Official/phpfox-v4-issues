<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 100 2009-01-26 15:15:26Z Raymond_Benc $
 */
class Apps_Component_Ajax_Ajax extends Phpfox_Ajax
{

	/**
	 * Called from a setInterval 60s to keep the token that grants permissions to the app alive
	 */
	public function alive()
	{
		Phpfox::getService('apps.process')->alive($this->get('appid'));
	}
	public function appsModeration()
	{
		$bSuccess = false;
		// get the array of app ids
		$aApps = $this->get('item_moderate');
		
		switch($this->get('action'))
		{
			case 'delete':								
				$bSuccess = Phpfox::getService('apps.process')->deleteApp($aApps);
				break;
			case 'approve':
				$bSuccess = Phpfox::getService('apps.process')->approveApp($aApps);
				break;
		}
		if ($bSuccess == true)
		{
			$this->softNotice(Phpfox::getPhrase('apps.operation_carried_out_successfully'));
			$this->call("$('.moderation_process').hide();");
                        foreach ($aApps as $iApp)
                        {
                            $this->call('$("#js_apps_' . $iApp .'").remove();');
                        }
                        
		}
		
	}
	
	public function deleteCategory()
	{
		if (Phpfox::getService('apps.category.process')->deleteCategory($this->get('categoryid')))
		{
			$this->call('$("#tr'. $this->get('categoryid') .'").remove();');
			$this->softNotice(Phpfox::getPhrase('apps.category_deleted_successfully'));
		}
		else
		{
			$this->alert(Phpfox::getPhrase('apps.an_error_occurred_and_the_category_has_not_been_deleted'));
		}
	}
	/* Triggered when a user allows/installs an application
	 */
	public function install()
	{
		$aFunctions = explode(',', $this->get('disallow'));
		
		if (Phpfox::getService('apps.process')->install($this->get('iId'), $aFunctions))
		{
			$aApp = Phpfox::getService('apps')->getAppById($this->get('iId'));			

			if (!empty($aApp['return_url']))
			{
				$sKey = Phpfox::getService('apps')->getKey($aApp['app_id']);
				$this->call('window.location.href = \'' . Phpfox::getService('apps')->buildUrl($aApp['return_url'], $sKey) . '\';');				
				return;
			}
			$this->call('window.location.href = \'' . Phpfox::getLib('url')->permalink('apps', $aApp['app_id'], $aApp['app_title']) . '\';');
		}
		else
		{
			$this->alert(Phpfox::getPhrase('apps.an_error_occurred_and_your_confirmation_could_not_be_saved'));
		}
	}
	
	/* Triggered from a button in the apps.index controller when displaying all the 
	 * categories*/
	public function filterByCategories()
	{
		/* We can get the apps by category */
		$aCategories = explode(',', $this->get('cats'));
		$aApps = Phpfox::getService('apps')->getAppsByCategories($aCategories);
	}
	
	/**
	 * This function is called from the AdminCP.Apps.Categories controller
	 */
	public function updateCategory()
	{
		if (Phpfox::getService('apps.category.process')->updateCategory($this->get('categoryid'),$this->get('name')))
		{
			$this->softNotice(Phpfox::getPhrase('apps.category_renamed'));
			$this->call('$("#catName'. $this->get('categoryid') .'").html(" '. $this->get('name') .'");');
			$this->call('$("#txtName'. $this->get('categoryid') .'").val(" '. $this->get('name') .'");');
			$this->call('showEdit('. $this->get('categoryid').');');
		}
		else
		{
			// Not even using a different css class (2nd param) because it should not happen
			$this->softNotice(Phpfox::getPhrase('apps.an_error_occurred')); 
		}
	}
	
	
	/**
	 * This function loads a block so the user can set the permissions allowed to that app 
	 * on the spot.
	 */
	public function showSetPermissions()
	{
		Phpfox::getBlock('apps.setpermissions', array('id' => $this->get('id') ));
	}
	
	public function setPermissions()
	{
		$sDisallow = $this->get('sDisallow');
		$aDisallow = explode(',',$sDisallow);
		
		Phpfox::getService('apps.process')->updatePermissions($this->get('iAppId'), $aDisallow);
		
		$this->softNotice(Phpfox::getPhrase('apps.permissions_updated_successfully'));
	}
}

?>