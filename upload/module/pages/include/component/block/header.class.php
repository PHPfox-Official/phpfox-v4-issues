<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Pages_Component_Block_Header extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aPage = $this->getParam('aPage');
		
		if (!isset($aPage['page_id']))
		{
			return false;
		}
		
		if (isset($aPage['use_timeline']) && $aPage['use_timeline'])
		{
			return false;
		}
		
		if ($this->getParam('bIsPagesViewSection'))
		{
			$aMenus = Phpfox::callback($this->getParam('sCurrentPageModule') . '.getPageSubMenu', $aPage);			
			$this->template()->assign(array(
					'aSubPageMenus' => $aMenus
				)
			);
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('pages.component_block_header_clean')) ? eval($sPlugin) : false);
	}
}

?>