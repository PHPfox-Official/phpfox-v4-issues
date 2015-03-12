<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel_Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: sponsored.class.php 4089 2012-04-10 12:54:26Z Miguel_Espinoza $
 */
class Video_Component_Block_Sponsored extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!Phpfox::isModule('ad'))
		{
			return false;
		}		
		
		if (defined('PHPFOX_IS_GROUP_VIEW'))
		{
		    return false;
		}
		
		$aSponsorVideo = Phpfox::getService('video')->getRandomSponsored();
		if (empty($aSponsorVideo))
		{
		    return false;
		}
		
		// update the views count
		Phpfox::getService('ad.process')->addSponsorViewsCount($aSponsorVideo['sponsor_id'], 'video');
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('video.sponsored_video'),
				'aSponsorVideo' => $aSponsorVideo,
				//'aFooter' => array(Phpfox::getPhrase('video.encourage_sponsor') => $this->url()->makeUrl('profile.video', array('sponsor' => 1)))
			)
		);
		
		if (!empty($aSponsorVideo['destination'])) // its an uploaded vid
		{
		    $sPath = (preg_match("/\{file\/videos\/(.*)\/(.*)\.flv\}/i", $aSponsorVideo['destination'], $aMatches) ? Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]) : Phpfox::getParam('video.url') . $aSponsorVideo['destination']);
		    $this->template()->assign(array(
					'sPath' => $sPath
				)
			);
		}
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_block_spotlight_clean')) ? eval($sPlugin) : false);
	}
}

?>