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
class Poll_Component_Block_Votes extends Phpfox_Component
{

	public function process()
	{
		(($sPlugin = Phpfox_Plugin::get('poll.component_block_votes_start')) ? eval($sPlugin) : false);

		if ( ($iPollId = $this->request()->get('req2') ) )
		{
			$aVotes = Phpfox::getService('poll')->getVotes($this->request()->get('req2'));
		}
		else
		{
			$aVotes = Phpfox::getService('poll')->getVotes($this->request()->get('poll_id'));
		}

		$this->template()->assign(array(
				'aVotes' => $aVotes				
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('poll.component_block_votes_end')) ? eval($sPlugin) : false);		
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
