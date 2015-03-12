<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display the stats of the image we are voting on
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox_Component
 * @version 		$Id: stat.class.php 2632 2011-05-26 19:28:02Z Raymond_Benc $
 */
class Photo_Component_Block_Stat extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_stat_process')) ? eval($sPlugin) : false);
		
		$aPhoto = $this->getParam('aPhoto');
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('photo.average_rating'),
				'sPhotoAverageRating' => round($aPhoto['total_rating']),
				'sPhotoRatingPhrase' => Phpfox::getPhrase('photo.with_a_total_of_total_vote_votes', array('total_vote' => $aPhoto['total_vote']))
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
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_stat_clean')) ? eval($sPlugin) : false);
	}
}

?>