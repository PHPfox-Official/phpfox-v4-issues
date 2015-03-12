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
class Rss_Component_Controller_Log extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		$this->setParam(array(
				'rss' => array(
					'table' => 'rss_log_user',
					'field' => 'user_id',
					'key' => Phpfox::getUserId()
				)
			)
		);	
			
		$this->template()->setTitle(Phpfox::getPhrase('rss.rss_logs'))
			->setBreadcrumb(Phpfox::getPhrase('rss.rss_feeds'), $this->url()->makeUrl('rss'))
			->setBreadcrumb(Phpfox::getPhrase('rss.log'), null, true);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('rss.component_controller_log_clean')) ? eval($sPlugin) : false);
	}
}

?>