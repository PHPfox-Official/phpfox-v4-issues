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
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Page_Component_Block_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aPage = Phpfox::getService('page')->getPage($this->request()->get('title'), true);	
		
		if (!isset($aPage['page_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('page.unable_to_find_the_page_you_are_looking_for'));
		}
		
		$this->template()->assign('aPage', $aPage);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('page.component_block_view_clean')) ? eval($sPlugin) : false);
	}
}

?>