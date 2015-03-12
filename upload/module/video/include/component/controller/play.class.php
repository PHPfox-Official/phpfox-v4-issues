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
 * @version 		$Id: play.class.php 5982 2013-05-29 13:07:53Z Raymond_Benc $
 */
class Video_Component_Controller_Play extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!($aVideo = Phpfox::getService('video')->getVideo($this->request()->get('req3'))))
		{
			exit(Phpfox::getPhrase('video.the_video_you_are_looking_for_does_not_exist_or_has_been_removed'));
		}

		$sVideoPath = (preg_match("/\{file\/videos\/(.*)\/(.*)\.flv\}/i", $aVideo['destination'], $aMatches) ? Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]) : Phpfox::getParam('video.url') . $aVideo['destination']);
		if ($aVideo['custom_v_id'])
		{
			preg_match('/\{([0-9]+)\}(.*)/i', $sVideoPath, $aMatches);
			$iCnt = 0;
			$sCustomUrl = '';
			foreach (Phpfox::getParam('video.convert_servers') as $sServer)
			{
				$iCnt++;
				if ($iCnt === (int) $aMatches[1])
				{
					$sCustomUrl = $sServer;
					break;
				}
			}

			$sVideoPath = $sCustomUrl . 'view/' . $aMatches[2] . '.flv';
		}

		$sVersion = $this->template()->getStaticVersion();
		echo '<!DOCTYPE html>
		<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
		<head>
		<style type="text/css">body{padding:0px;margin:0px;}</style>
		<script type="text/javascript">var $Behavior = {};</script>
		<script type="text/javascript" src="' . Phpfox::getParam('core.path') . 'static/jscript/player/flowplayer/flowplayer.js?v=' . $sVersion . '"></script>
		<script type="text/javascript" src="' . Phpfox::getParam('core.path') . 'static/jscript/player/flowplayer/play.js?v=' . $sVersion . '"></script>
		</head>
		<body>
			<div id="iframe_player" style="width:600px; height:366px;"></div>
			<script type="text/javascript">
				 $Behavior.TheFlowPlayerinit2();
				IframePlayer.load({play: \'' . $sVideoPath . '\', url: \'' . Phpfox::getParam('core.url_static') . '\'});
			</script>
		</body>
		</html>
		';
		exit;
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_controller_play_clean')) ? eval($sPlugin) : false);
	}
}

?>