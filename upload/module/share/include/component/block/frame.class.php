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
 * @package  		Module_Share
 * @version 		$Id: frame.class.php 5269 2013-01-30 09:00:11Z Raymond_Benc $
 */
class Share_Component_Block_Frame extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		static $aBookmarks = array();
		if (empty($aBookmarks))
		{
			$aBookmarks = Phpfox::getService('share')->getType();
		}
		if (!is_array($aBookmarks))
		{
			$aBookmarks = array();
		}
		
		$this->template()->assign(array(
				'sBookmarkType' => $this->getParam('type'),
				'sBookmarkUrl' => $this->getParam('url'),
				'sBookmarkTitle' => $this->getParam('title'),
				'bShowSocialBookmarks' => count($aBookmarks) > 0,
				'iFeedId' => ((Phpfox::hasCallback($this->request()->get('sharemodule'), 'canShareItemOnFeed')) ? $this->request()->getInt('feed_id') : 0),
				'sShareModule' => $this->request()->get('sharemodule')
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('share.component_block_frame_clean')) ? eval($sPlugin) : false);
	}
}

?>