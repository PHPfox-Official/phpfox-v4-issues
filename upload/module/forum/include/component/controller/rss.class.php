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
 * @version 		$Id: rss.class.php 3990 2012-03-09 15:28:08Z Raymond_Benc $
 */
class Forum_Component_Controller_Rss extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($this->request()->getInt('forum'))
		{
			if (!Phpfox::getParam('forum.rss_feed_on_each_forum'))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('forum.rss_feeds_are_disabled_for_threads'));
			}		
			
			if (!Phpfox::getService('forum')->hasAccess($this->request()->getInt('forum'), 'can_view_forum'))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('forum.rss_feeds_are_disabled_for_threads'));	
			}
			
			$aRss = Phpfox::getService('forum')->getForRss($this->request()->getInt('forum'));
		}
		elseif ($this->request()->getInt('thread'))
		{
			if (!Phpfox::getParam('forum.enable_rss_on_threads'))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('forum.rss_feeds_are_disabled_for_threads'));
			}		
			
			if (!Phpfox::getService('forum')->hasAccess($this->request()->getInt('thread'), 'can_view_thread_content'))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('forum.rss_feeds_are_disabled_for_threads'));	
			}			
			
			$aRss = Phpfox::getService('forum.post')->getForRss($this->request()->getInt('thread'));	
			
			if (isset($aRss['items']) && is_array($aRss['items']) && count($aRss['items']))	
			{
				if (!Phpfox::getService('forum')->hasAccess($aRss['items'][0]['forum_id'], 'can_view_forum'))
				{
					return Phpfox_Error::set(Phpfox::getPhrase('forum.rss_feeds_are_disabled_for_threads'));	
				}
			}
		}
		elseif ($this->request()->getInt('pages'))
		{
			if (!Phpfox::getParam('forum.rss_feed_on_each_forum'))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('forum.rss_feeds_are_disabled_for_threads'));
			}		
			
			$aGroup = Phpfox::getService('pages')->getPage($this->request()->getInt('pages'), true);
			
			if (!isset($aGroup['page_id']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('forum.not_a_valid_group'));
			}

			$aItems = Phpfox::getService('forum.thread')->getForRss(Phpfox::getParam('rss.total_rss_display'), null, $aGroup['page_id']);
			
			$aRss = array(
				'href' => '', // Phpfox::getLib('url')->makeUrl('forum', array($aGroup['title_url'])),
				'title' => Phpfox::getPhrase('forum.latest_threads_in_group_forum') . ': ' . $aGroup['title'],
				'description' => Phpfox::getPhrase('forum.latest_threads_on') . ': ' . $aGroup['title'],
				'items' => $aItems
			);	
		}
		
		Phpfox::getService('rss')->output($aRss);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_controller_rss_clean')) ? eval($sPlugin) : false);
	}
}

?>