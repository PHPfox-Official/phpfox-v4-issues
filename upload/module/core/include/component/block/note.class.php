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
 * @version 		$Id: note.class.php 982 2009-09-16 08:11:36Z Raymond_Benc $
 */
class Core_Component_Block_Note extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('admincp.admincp_notes'),
				'sAdminNote' => Phpfox::getService('core.admincp')->getNote()
			)
		);
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_note_clean')) ? eval($sPlugin) : false);
	}
}

?>