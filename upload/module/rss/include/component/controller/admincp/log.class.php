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
 * @version 		$Id: log.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class Rss_Component_Controller_Admincp_Log extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!($aFeed = Phpfox::getService('rss.log')->getFeed($this->request()->getInt('id'))))
		{
			$this->url()->send('admincp.rss', null, Phpfox::getPhrase('rss.unable_to_find_rss_log'));
		}
				
		$this->setParam(array(
				'rss' => array(
					'table' => 'rss_log',
					'field' => 'feed_id',
					'key' => $aFeed['feed_id'],
					'users' => true
				)
			)
		);
		
		$this->template()->setTitle(Phpfox::getPhrase('rss.viewing_rss_feed_log'))
			->setBreadcrumb(Phpfox::getPhrase('rss.manage_feeds'), $this->url()->makeUrl('admincp.rss'))
			->setBreadcrumb(Phpfox::getPhrase('rss.rss_feed_log') . ': ', null, true)
			->assign(array(
					'bRssIsAdminCp' => true
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('rss.component_controller_admincp_log_clean')) ? eval($sPlugin) : false);
	}
}

?>