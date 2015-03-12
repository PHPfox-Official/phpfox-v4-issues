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
 * @package  		Module_User
 * @version 		$Id: status.class.php 852 2009-08-10 18:05:32Z Raymond_Benc $
 */
class User_Component_Block_Status extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!Phpfox::isUser())
		{
			return false;
		}
		
		$sImage = Phpfox::getLib('image.helper')->display(array(
				'server_id' => Phpfox::getUserBy('server_id'),
				'title' => Phpfox::getUserBy('full_name'),
				'path' => 'core.url_user',
				'file' => Phpfox::getUserBy('user_image'),
				'suffix' => '_20_square',
				'max_width' => 20,
				'max_height' => 20,
				'no_default' => true,
				'style' => 'vertical-align:middle; padding-right:5px;'
			)
		);		
		
		$this->template()->assign(array(
				'sUserGlobalImage' => $sImage,
				'sUserCurrentStatus' => Phpfox::getUserBy('status'),
				'iCurrentUserId' => Phpfox::getUserId()
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>