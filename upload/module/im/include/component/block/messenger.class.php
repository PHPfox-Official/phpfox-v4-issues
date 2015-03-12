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
 * @version 		$Id: messenger.class.php 738 2009-07-06 15:04:47Z Raymond_Benc $
 */
class Im_Component_Block_Messenger extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bBackOnline = false;
		if (Phpfox::getUserBy('im_hide') == '1')
		{
			Phpfox::getService('im.process')->goOnline();
			$bBackOnline = true;
		}		
					
		$this->template()->assign(array(
				'aStatuses' => Phpfox::getService('im')->getStatuses(),
				'bBackOnline' => $bBackOnline
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('im.component_block_messenger_clean')) ? eval($sPlugin) : false);
	}
}

?>