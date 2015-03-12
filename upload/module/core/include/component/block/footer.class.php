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
 * @version 		$Id: footer.class.php 2832 2011-08-15 17:36:44Z Raymond_Benc $
 */
class Core_Component_Block_Footer extends Phpfox_Component
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
		
		if ($this->template()->bIsSample === true)
		{
			return false;
		}
		
		if (Phpfox::isUser() 
			&& Phpfox::isModule('subscribe')
			&& Phpfox::getParam('subscribe.subscribe_is_required_on_sign_up')			  
			&& Phpfox::getUserBy('user_group_id') == '2' 
			&& (int) Phpfox::getUserBy('subscribe_id') > 0
		)
		{
			return false;
		}
		
		if (defined('PHPFOX_IN_DESIGN_MODE'))
		{
			return false;
		}
		
		$sImage = Phpfox::getLib('image.helper')->display(array(
				'server_id' => Phpfox::getUserBy('server_id'),
				'title' => Phpfox::getUserBy('full_name'),
				'path' => 'core.url_user',
				'file' => Phpfox::getUserBy('user_image'),
				'suffix' => '_50',
				'max_width' => 50,
				'max_height' => 50,
				'no_default' => true,
				'style' => 'vertical-align:middle; padding-right:5px;',
				'user' => array('gender'=>Phpfox::getUserBy('gender'), 'user_image' => Phpfox::getUserBy('user_image'), 'full_name' => Phpfox::getUserBy('full_name'), 'user_name' => Phpfox::getUserBy('user_name'))
			)
		);	
		
		$this->template()->assign(array(
				'sGlobalUserImage' => $sImage,
				'sGlobalUserFullname' => Phpfox::getUserBy('full_name'),
				'sGlobalUserStatus' => Phpfox::getUserBy('status'),
				'iGlobalUserId' => Phpfox::getUserId(),
				'sGlobalTimeStamp' => Phpfox::getTime(Phpfox::getParam('core.footer_bar_tool_tip_time_stamp'), PHPFOX_TIME),
				'sGlobalTimeStampMini' => Phpfox::getTime(Phpfox::getParam('core.footer_watch_time_stamp'), PHPFOX_TIME),
				'aDashboards' => Phpfox::isModule('core') ? Phpfox::getService('core')->getDashboardLinks() : array()
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_footer_clean')) ? eval($sPlugin) : false);
	}
}

?>