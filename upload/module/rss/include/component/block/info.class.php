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
 * @version 		$Id: info.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class Rss_Component_Block_Info extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!Phpfox::isUser())
		{
			return false;
		}
		
		$aUser = Phpfox::getService('user')->get(Phpfox::getUserId());		
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('rss.subscribers'),
				'iRssCount' => $aUser['rss_count']
			)
		);
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('rss.component_block_info_clean')) ? eval($sPlugin) : false);
	}
}

?>