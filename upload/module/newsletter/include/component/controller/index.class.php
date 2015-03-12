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
 * @package 		Phpfox_Component
 * @version 		$Id: index.class.php 1168 2009-10-09 14:20:37Z Raymond_Benc $
 */
class Newsletter_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aNewsletters = Phpfox::getService('newsletter')->get();
		$this->template()->assign(array(
				'aNewsletters' => $aNewsletters
			)
		);

		//$this->template()->setTemplate('blank');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('notification.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>