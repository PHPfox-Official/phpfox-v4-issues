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
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Video_Component_Block_Detail extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aVideo = $this->getParam('aVideo');
		$sGroup = $this->getParam('sGroup', '');		
		
		$aItems = array(
			Phpfox::getPhrase('video.added') => Phpfox::getTime(Phpfox::getParam('video.video_time_stamp'), $aVideo['time_stamp'])		
		);
		
		if (Phpfox::isModule('comment'))
		{
			$aItems[Phpfox::getPhrase('video.comments')] = $aVideo['total_comment'];
		}
		
		$this->template()->assign(array(
				'aVideoDetails' => $aItems,
				'sGroup' => $sGroup
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_block_detail_clean')) ? eval($sPlugin) : false);
	}
}

?>