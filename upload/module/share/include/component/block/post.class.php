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
 * @version 		$Id: post.class.php 853 2009-08-10 21:24:22Z Raymond_Benc $
 */
class Share_Component_Block_Post extends Phpfox_Component
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
			$aBookmarks = Phpfox::getService('share')->getType('post');
		}
		
		foreach ($aBookmarks as $iKey => $aBookmark)
		{
			$aBookmarks[$iKey]['url'] = str_replace(array(
				'{URL}',
				'{TITLE}'
			),
			array(
				urlencode($this->getParam('url')),
				urlencode($this->getParam('title'))
			), $aBookmark['url']);
		}

		$this->template()->assign(array(
				'sType' => $sType,
				'aBookmarks' => $aBookmarks,
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
		(($sPlugin = Phpfox_Plugin::get('share.component_block_post_clean')) ? eval($sPlugin) : false);
	}
}

?>