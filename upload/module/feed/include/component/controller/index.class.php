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
 * @version 		$Id: index.class.php 6661 2013-09-19 11:19:22Z Fern $
 */
class Feed_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('feed.can_view_feed', true);
		$sFeedDisplay = 'feed.display';
		(($sPlugin = Phpfox_Plugin::get('feed.component_controller_index_feeddisplay')) ? eval($sPlugin) : false);
		/* Load the picup files if needed*/
		if (Phpfox::isMobile() && ( ($sBrowser = Phpfox::getLib('request')->getBrowser()) && strpos($sBrowser, 'Safari') !== false))
		{
			$sMethod = 'simple';
			$this->template()->setHeader(array(
				'<script type="text/javascript">
						var flash_user_id = '.Phpfox::getUserId() .';
						var sHash = "'.Phpfox::getService('core')->getHashForUpload().'";</script>',
				'mobile.js' => 'module_photo'
				))->assign(array('bRawFileInput' => true));
		}
		$this->template()->setEditor()->setHeader('cache', array(
				'feed.js' => 'module_feed',					
				'comment.css' => 'style_css',					
				'quick_edit.js' => 'static_script',
				'jquery/plugin/jquery.highlightFade.js' => 'static_script',
				'jquery/plugin/jquery.scrollTo.js' => 'static_script',
				'player/flowplayer/flowplayer.js' => 'static_script'								
			)					
		)
		->assign(array('sFeedDisplay' => $sFeedDisplay));			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('feed.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>
