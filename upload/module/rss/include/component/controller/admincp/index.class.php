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
 * @version 		$Id: index.class.php 6113 2013-06-21 13:58:40Z Raymond_Benc $
 */
class Rss_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($iDeleteId = $this->request()->get('delete')))
		{
			if (Phpfox::getService('rss.process')->delete($iDeleteId))
			{
				$this->url()->send('admincp.rss', null, Phpfox::getPhrase('rss.feed_successfully_deleted'));
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('rss.manage_feeds'))
			->setBreadcrumb(Phpfox::getPhrase('rss.manage_feeds'), $this->url()->makeUrl('admincp.rss'))	
			->setHeader('cache', array(
					'drag.js' => 'static_script',
					'<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'rss.ordering\'}); }</script>'
				)
			)
			->assign(array(
					'aFeeds' => Phpfox::getService('rss')->get()
				)
			);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('rss.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>