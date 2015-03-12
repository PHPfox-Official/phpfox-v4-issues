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
 * @package  		Module_Rss
 * @version 		$Id: index.class.php 1537 2010-03-30 11:55:12Z Raymond_Benc $
 */
class Rss_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($iId = $this->request()->getInt('id')))
		{
			if (($sContent = Phpfox::getService('rss')->getFeed($iId)))
			{			
				ob_clean();
				header('Content-type: text/xml; charset=utf-8');
				echo $sContent;
				exit;
			}
		}
		
		$aFeeds = Phpfox::getService('rss')->getFeeds();		
				
		$this->template()->setTitle(Phpfox::getPhrase('rss.rss_feeds'))
			->setBreadcrumb(Phpfox::getPhrase('rss.rss_feeds'), $this->url()->makeUrl('rss'))
			->assign(array(
				'aGroupFeeds' => $aFeeds
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('rss.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>