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
 * @package  		Module_Emoticon
 * @version 		$Id: ajax.class.php 3335 2011-10-20 17:26:57Z Raymond_Benc $
 */
class Emoticon_Component_Ajax_Ajax extends Phpfox_Ajax
{		
	public function preview()
	{
		$this->setTitle(Phpfox::getPhrase('emoticon.emoticons'));
		
		Phpfox::getBlock('emoticon.preview', array('editor_id' => $this->get('editor_id')));
	}

	/**
	 * Clone of updateStatActivity, activates/deactivates a package
	 */
	public function updatePackageActivity()
	{
		if (Phpfox::getService('emoticon.process')->updateActivity($this->get('id'), $this->get('active')))
		{

		}
	}

	/**
	 * Changes the order of the emoticons
	 */
	public function setEmoticonOrder()
	{
		if (Phpfox::getService('emoticon.process')->updateOrder($this->get('val')))
		{

		}
	}
}

?>