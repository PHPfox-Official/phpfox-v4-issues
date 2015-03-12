<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display the image details when viewing an image.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: detail.class.php 254 2009-02-23 12:36:20Z Raymond_Benc $
 */
class Poll_Component_Block_Vote extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 * Lods the results of a single poll
	 */
	public function process()
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_block_vote_start')) ? eval($sPlugin) : false);
		
		Phpfox::isUser(true);
		
		if (!$this->getParam('iPoll'))
		{
			return false;
		}
		
		$aPoll = Phpfox::getService('poll')->getPollByUrl($this->getParam('iPoll'));
		
		$this->template()->assign(array(
				'aPoll' => $aPoll
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('poll.component_block_vote_end')) ? eval($sPlugin) : false);
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_detail_clean')) ? eval($sPlugin) : false);			
	}
}

?>