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
 * @version 		$Id: sponsored.class.php 3990 2012-03-09 15:28:08Z Raymond_Benc $
 */
class Event_Component_Block_Sponsored extends Phpfox_Component
{
	/**
	 * Class process method which is used to execute this component.
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
	    
	    $aSponsorEvents = Phpfox::getService('event')->getRandomSponsored();
	    
	    if (empty($aSponsorEvents))
	    {
			return false;
	    }
	    
	    Phpfox::getService('ad.process')->addSponsorViewsCount($aSponsorEvents['sponsor_id'], 'event');
		
	    $this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('event.sponsored_event'),
				'aSponsorEvents' => $aSponsorEvents,
				'aFooter' => array(Phpfox::getPhrase('event.encourage_sponsor') => $this->url()->makeUrl('profile.event', array('sponsor' => 1)))
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
		(($sPlugin = Phpfox_Plugin::get('event.component_block_sponsored_clean')) ? eval($sPlugin) : false);
	}
}

?>