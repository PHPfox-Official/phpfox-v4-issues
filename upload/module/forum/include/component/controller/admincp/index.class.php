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
 * @version 		$Id: index.class.php 6081 2013-06-17 14:34:34Z Raymond_Benc $
 */
class Forum_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($aOrder = $this->request()->getArray('order')) && Phpfox::getService('forum.process')->updateOrder($aOrder))
		{
			$this->url()->send('admincp.forum', null, Phpfox::getPhrase('forum.forum_order_successfully_updated'));
		}
		
		if ($iDeleteId = $this->request()->getInt('delete'))
		{
			Phpfox::getUserParam('forum.can_delete_forum', true);
			
			if (Phpfox::getService('forum.process')->delete($iDeleteId))
			{
				$this->url()->send('admincp.forum', null, Phpfox::getPhrase('forum.forum_successfully_deleted'));
			}
		}
		
		if ($iId = $this->request()->getInt('view'))
		{
			if ($sUrl = Phpfox::getService('forum')->getForumUrl($iId))
			{
				$this->url()->send('forum', $sUrl . '-' . $iId);
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('forum.manage_forums'))
			->setBreadCrumb(Phpfox::getPhrase('forum.manage_forums'), $this->url()->makeUrl('admincp.forum'))
			->setPhrase(array(
					'forum.are_you_sure_notice_this_will_delete_all_child_forums_and_any_threads_posts_announcements',
					'forum.global_moderator_permissions',
					'forum.moderator_permissions',
					'forum.cancel'
				)
			)
			->setHeader(array(										
					'admin.js' => 'module_forum',
					'jquery/ui.js' => 'static_script',
					'<script type="text/javascript">$Behavior.postLoadForm = function() { $Core.forum.init({url: \'' . $this->url()->makeUrl('admincp.forum') . '\'}); }</script>'
				)
			)
			->assign(array(			
				'sForumList' => Phpfox::getService('forum')->getAdminCpList()				
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>