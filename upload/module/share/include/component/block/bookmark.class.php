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
 * @version 		$Id: bookmark.class.php 4154 2012-05-07 14:32:57Z Raymond_Benc $
 */
class Share_Component_Block_Bookmark extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		static $aBookmarks = array();
		
		if (!($sType = $this->getParam('type')))
		{
			
		}
		
		if (!$aBookmarks)
		{
			$aBookmarks = Phpfox::getService('share')->getType('bookmark');
		}
		if (!is_array($aBookmarks))
		{
			$aBookmarks = array();
		}
		$sTitle = html_entity_decode($this->getParam('title'), null, 'UTF-8');
		
		foreach ($aBookmarks as $iKey => $aBookmark)
		{
			$aBookmarks[$iKey]['url'] = str_replace(array(
				'{URL}',
				'{TITLE}'
			),
			array(
				urlencode($this->getParam('url')),
				urlencode($sTitle)
			), $aBookmark['url']);
		}
		
		$aPostBookmarks = Phpfox::getService('share')->getType('post');
		
		foreach ($aPostBookmarks as $iKey => $aBookmark)
		{
			$aPostBookmarks[$iKey]['url'] = str_replace(array(
				'{URL}',
				'{TITLE}'
			),
			array(
				urlencode($this->getParam('url')),
				urlencode($sTitle)
			), $aBookmark['url']);
		}		

		$this->template()->assign(array(
				'sType' => $sType,
				'aBookmarks' => $aBookmarks,
				'aPostBookmarks' => $aPostBookmarks,
				'sUrlStaticImage' => Phpfox::getParam('share.url_image')
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('share.component_block_bookmark_clean')) ? eval($sPlugin) : false);
	}
}

?>