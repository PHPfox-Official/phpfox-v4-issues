<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Block that displays a shoutbox anywhere on the site depending on 
 * where it is placed.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Shoutbox
 * @version 		$Id: display.class.php 5534 2013-03-25 12:44:57Z Raymond_Benc $
 */
class Shoutbox_Component_Block_Display extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		// Make sure the user group viewing this block is actually allowed to view it		
		if (!Phpfox::getUserParam('shoutbox.can_view_shoutbox'))
		{
			return false;
		}		
	
		$aCallback = $this->getParam('aCallbackShoutbox', array());

		if (isset($aCallback['module']) && $aCallback['module'] == 'pages' && !Phpfox::getService('pages')->hasPerm($aCallback['item'], 'shoutbox.view_post_shoutbox'))
		{
			return false;
		}
		
		$aMessages = array();
		if (Phpfox::getParam('shoutbox.load_content_ajax') && !PHPFOX_IS_AJAX)
		{
				
		}
		else
		{
			$aMessages = Phpfox::getService('shoutbox')->callback($aCallback)->getMessages(Phpfox::getParam('shoutbox.shoutbox_display_limit'));
		}
		
		// Assign the vars to the template
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('shoutbox.shoutbox'),
				'aShoutouts' => $aMessages,
				'iShoutboxRefresh' => (Phpfox::getParam('shoutbox.shoutbox_refresh') * 1000),
				'iShoutoutWordWrap' => Phpfox::getParam('shoutbox.shoutbox_wordwrap'),				
				'aCallbackShoutbox' => $aCallback
			)
		);
		
		// $this->template()->assign('sDeleteBlock', 'dashboard');

		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('shoutbox.component_controller_index_clean')) ? eval($sPlugin) : false);
		
		// Remove template vars from memory
		$this->template()->clean(array(
				'aShoutouts',
				'iShoutboxRefresh',
				'iShoutoutWordWrap'
			)
		);
	}	
}

?>