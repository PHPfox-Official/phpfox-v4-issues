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
 * @package 		Phpfox_Component
 * @version 		$Id: index.class.php 3002 2011-09-04 16:55:01Z Raymond_Benc $
 */
class Link_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($aLink = Phpfox::getService('link')->getLinkById($this->request()->getInt('req2'))))
		{
			$this->url()->send($aLink['user_name'], array('link-id' => $aLink['link_id']));
		}		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('link.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>