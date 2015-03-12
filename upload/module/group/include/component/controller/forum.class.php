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
 * @version 		$Id: forum.class.php 1339 2009-12-19 00:37:55Z Raymond_Benc $
 */
class Group_Component_Controller_Forum extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($aGroup = Phpfox::getService('group')->getGroup($this->request()->getInt('id'), true)))
		{
			$this->url()->send('group.' . $aGroup['title_url'] . '.forum', array($this->request()->get('req3'), 'post' => $this->request()->getInt('post'), 'view' => $this->request()->get('view')));
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('group.component_controller_forum_clean')) ? eval($sPlugin) : false);
	}
}

?>