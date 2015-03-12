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
 * @package  		Module_Emoticon
 * @version 		$Id: preview.class.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
class Emoticon_Component_Block_Preview extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->template()->assign(array(
			'aRows' => Phpfox::getService('emoticon')->getPreview(),
			'sUrlEmoticon' => Phpfox::getParam('core.url_emoticon'),
			'sEditorId' => $this->getParam('editor_id')
		));
		
		(($sPlugin = Phpfox_Plugin::get('emoticon.component_block_preview_process')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('emoticon.component_block_preview_clean')) ? eval($sPlugin) : false);
	}
}

?>