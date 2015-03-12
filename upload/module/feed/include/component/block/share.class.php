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
 * @package  		Module_Feed
 * @version 		$Id: share.class.php 4545 2012-07-20 10:40:35Z Raymond_Benc $
 */
class Feed_Component_Block_Share extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iFeedId = $this->request()->getInt('feed_id');
		$sShareModule = $this->request()->get('sharemodule');
		$aShareModule = explode('_', $sShareModule);
		if (!Phpfox::isModule($aShareModule[0]))
		{
			return false;
		}
		/*
		if ($this->request()->getInt('is_feed_view'))
		{
			if (($aFeed = Phpfox::getService('feed')->getForItem($this->request()->get('sharemodule'), $iFeedId)))
			{
				$iFeedId = $aFeed['feed_id'];
			}
			else
			{
				
			}
		}
		*/
		$this->template()->assign(array(
				'iFeedId' => $iFeedId,
				'sShareModule' => $sShareModule
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('comment.component_block_share_clean')) ? eval($sPlugin) : false);
	}		
}

?>