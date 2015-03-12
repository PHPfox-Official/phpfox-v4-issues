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
 * @package  		Module_Blog
 * @version 		$Id: preview.class.php 852 2009-08-10 18:05:32Z Raymond_Benc $
 */
class Blog_Component_Block_Preview extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$this->template()->assign(array(
				'sText' => Phpfox::getLib('parse.input')->prepare($this->getParam('sText'))
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('blog.component_block_preview_process')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_block_preview_clean')) ? eval($sPlugin) : false);
	}
}

?>