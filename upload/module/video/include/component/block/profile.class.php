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
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Video_Component_Block_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aUser = $this->getParam('aUser');
		
		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'video.display_on_profile'))
		{
			return false;
		}		
		
		$oServiceVideo = Phpfox::getService('video')->getForProfileBlock($aUser['user_id']);

		if (!$oServiceVideo->getCount() && !defined('PHPFOX_IN_DESIGN_MODE'))
		{
			return false;
		}

		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('video.videos'),
				'sBoxJsId' => 'profile_video',
				'aVideos' => $oServiceVideo->get()
			)
		);		
		
		if ($oServiceVideo->getCount() > 6)
		{
			$this->template()->assign('aFooter', array(
					Phpfox::getPhrase('video.view_more') => $this->url()->makeUrl($aUser['user_name'], array('video'))
				)
			);
		}		
		
		if (Phpfox::getUserId() == $aUser['user_id'])
		{
			$this->template()->assign('sDeleteBlock', 'profile');
		}		

		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_block_profile_clean')) ? eval($sPlugin) : false);
	}

	public function widget()
	{
		return true;
	}		
}

?>