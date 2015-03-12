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
 * @version 		$Id: preview.class.php 2294 2011-02-03 18:51:09Z Raymond_Benc $
 */
class Link_Component_Block_Preview extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!($aLink = Phpfox::getService('link')->getLink($this->request()->get('value'))))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'aLink' => $aLink	
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('link.component_block_preview_clean')) ? eval($sPlugin) : false);
	}
}

?>