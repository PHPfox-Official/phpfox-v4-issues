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
 * @version 		$Id: read.class.php 1603 2010-05-30 06:57:25Z Raymond_Benc $
 */
class Forum_Component_Controller_Read extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		if ($this->request()->getInt('forum'))
		{		
			$aForum = Phpfox::getService('forum')->id($this->request()->getInt('forum'))->getForum();
					
			if (!isset($aForum['forum_id']))
			{				
				return Phpfox_Error::display(Phpfox::getPhrase('forum.not_a_valid_forum'));
			}		
	
			if (Phpfox::getService('forum.thread.process')->markRead($aForum['forum_id']))
			{
				$this->url()->send('forum', array($aForum['name_url'] . '-' . $aForum['forum_id']), Phpfox::getPhrase('forum.forum_successfully_marked_as_read'));		
			}
		}
		elseif (($sModule = $this->request()->get('module')) && ($iItemId = $this->request()->getInt('item')))
		{
			$aCallback = Phpfox::callback($sModule . '.addForum', $iItemId);
			if (isset($aCallback['module']))
			{
				if (Phpfox::getService('forum.thread.process')->markRead(0, $aCallback['item']))
				{
					$this->url()->send($aCallback['url_home'], array('forum'), Phpfox::getPhrase('forum.forum_successfully_marked_as_read'));		
				}				
			}
		}
		else 
		{
			$aForums = Phpfox::getService('forum')->live()->getForums();
			foreach ($aForums as $aForum)
			{
				Phpfox::getService('forum.thread.process')->markRead($aForum['forum_id']);
				
				$aChildrens = Phpfox::getService('forum')->id($aForum['forum_id'])->getChildren();
				
				if (!is_array($aChildrens))
				{
					continue;
				}
				
				foreach ($aChildrens as $iForumid)
				{
					Phpfox::getService('forum.thread.process')->markRead($iForumid);
				}
			}
			
			$this->url()->send('forum', null, Phpfox::getPhrase('forum.forum_successfully_marked_as_read'));
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_controller_read_clean')) ? eval($sPlugin) : false);
	}
}

?>