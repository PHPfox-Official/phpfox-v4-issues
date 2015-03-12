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
 * @package  		Module_Mail
 * @version 		$Id: edit.class.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
class Mail_Component_Block_Box_Edit extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$this->template()->assign(array(
			'aFolders' => Phpfox::getService('mail.folder')->get()
		));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('mail.component_block_box_edit_clean')) ? eval($sPlugin) : false);
	}
}

?>