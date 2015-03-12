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
class Pages_Component_Block_Photo extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!defined('PHPFOX_IS_PAGES_VIEW'))
		{
			return false;
		}
		
		$aPage = $this->getParam('aPage');
		if (empty($aPage))
        {
            return false;
        }
		$this->template()->assign(array(
				'aPageLinks' => Phpfox::getService('pages')->getMenu($aPage)
			)
		);
		
		if (defined("PHPFOX_IN_DESIGN_MODE") || Phpfox::getService('theme')->isInDndMode())
		{
			return 'block';
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('pages.component_block_photo_clean')) ? eval($sPlugin) : false);
	}
}

?>