<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display a photo stread based on the album the main photo belongs to.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: stream.class.php 1247 2009-11-03 16:08:56Z Raymond_Benc $
 */
class Photo_Component_Block_Stream extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{		

	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_stream_clean')) ? eval($sPlugin) : false);
		
		$this->template()->clean(array(
				'aStreams'
			)
		);
	}
}

?>