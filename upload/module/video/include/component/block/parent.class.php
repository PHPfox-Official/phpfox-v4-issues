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
 * @version 		$Id: parent.class.php 1126 2009-10-03 12:05:33Z Miguel_Espinoza $
 */
class Video_Component_Block_Parent extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aVideoParent = $this->getParam('aCallbackVideo');
		
		$oServiceVideo = Phpfox::getService('video')->getForParentBlock($aVideoParent['module'], $aVideoParent['item'], $aVideoParent);

		if (!$oServiceVideo->getCount() && !defined('PHPFOX_IN_DESIGN_MODE'))
		{
			return false;
		}
		
		if (!Phpfox::getService('group')->hasAccess($aVideoParent['item'], 'can_use_video'))
		{
			return false;
		}			
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('video.videos'),
				'sBoxJsId' => 'parent_video',
				'aVideos' => $oServiceVideo->get(),
				'aVideoParent' => $aVideoParent,
				'sAddNewVideoLink' => $this->url()->makeUrl('video.upload', array('module'=> $aVideoParent['module'], 'item'=>$aVideoParent['item']))
			)
		);
		
		if ($oServiceVideo->getCount() > 6)
		{
			$this->template()->assign('aFooter', array(
					Phpfox::getPhrase('video.view_more') => $this->url()->makeUrl($aVideoParent['url'][0], $aVideoParent['url'][1])
				)
			);
		}
		
		return 'block';		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_block_parent_clean')) ? eval($sPlugin) : false);
	}		
}

?>