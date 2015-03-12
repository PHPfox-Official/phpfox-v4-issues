<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Profile Block Header
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Profile
 * @version 		$Id: header.class.php 3143 2011-09-20 14:08:51Z Miguel_Espinoza $
 */
class Profile_Component_Block_Cover extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		
		if ( ($iPageId = $this->request()->get('page_id') ))
		{
			$this->template()->assign(array(
				'iPageId' => $iPageId
			));
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('profile.component_block_cover_clean')) ? eval($sPlugin) : false);
	}
}

?>