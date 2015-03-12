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
 * @version 		$Id: file.class.php 4901 2012-10-17 06:29:50Z Raymond_Benc $
 */
class Video_Component_Block_File extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$this->template()->assign(array(
				'iUploadLimit' => Phpfox::getLib('file')->getLimit(Phpfox::getUserParam('video.video_file_size_limit')),
				'sFileExt' => Phpfox::getService('video')->getFileExt(true),
				'sCategories' => Phpfox::getService('video.category')->get(),
				'sEditorId' => $this->request()->get('editor_id')	
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_block_file_clean')) ? eval($sPlugin) : false);
	}
}

?>