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
 * @package 		Phpfox_Component
 * @version 		$Id: redirect.class.php 829 2009-08-02 18:45:42Z Raymond_Benc $
 */
class Group_Component_Controller_Redirect extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($iId = $this->request()->getInt('id')) && ($aGroup = Phpfox::getService('group')->getGroup(Phpfox::getService('group')->getGroupIdFromInviteId($iId), true)))
		{
			$this->url()->send('group', $aGroup['title_url']);
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('group.component_controller_redirect_clean')) ? eval($sPlugin) : false);
	}
}

?>