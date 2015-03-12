<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: connect.class.php 2792 2011-08-03 17:11:30Z Raymond_Benc $
 */
class Share_Component_Block_Connect extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($this->request()->get('connect-id') == 'facebook')
		{
			$sConnectUrl = 'https://www.facebook.com/dialog/oauth?client_id=' . Phpfox::getParam('facebook.facebook_app_id') . '&amp;redirect_uri=' . urlencode(Phpfox::getParam('core.path') . '?share-connect=1&connect-id=facebook') . '&amp;scope=publish_stream';
		}
		else
		{
			$sConnectUrl = Phpfox::getLib('twitter')->getUrl();
		}
		
		$this->template()->assign(array(
				'sConnectUrl' => $sConnectUrl
			)
		);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('share.component_block_connect_clean')) ? eval($sPlugin) : false);
	}
}

?>