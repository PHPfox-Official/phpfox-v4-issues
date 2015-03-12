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
 * @version 		$Id: user.class.php 2322 2011-03-02 11:00:01Z Raymond_Benc $
 */
class Video_Component_Block_User extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		list($iCnt, $aVideos) = Phpfox::getService('video')->getUserVideos($this->request()->getInt('user_id'));
		
		$this->template()->assign(array(
				'iUserTotalVideos' => $iCnt,
				'aMyVideos' => $aVideos
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_block_user_clean')) ? eval($sPlugin) : false);
	}
}

?>