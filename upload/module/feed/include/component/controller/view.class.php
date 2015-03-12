<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Redirect to a item based on the ID#
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: view.class.php 1124 2009-10-02 14:07:30Z Raymond_Benc $
 */
class Feed_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		// Make sure we have an (int) ID#
		if (!($iId = $this->request()->getInt('id')))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('feed.missing_feed_id'));
		}
		
		// Get the feed Link
		$mLink = Phpfox::getService('feed')->getRedirect($iId);
		
		// Is this an actual feed or not?
		if ($mLink === false)
		{
			return Phpfox_Error::display(Phpfox::getPhrase('feed.invalid_feed_id'));
		}
		
		// Send them to the correct item
		$this->url()->forward($mLink);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('feed.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>