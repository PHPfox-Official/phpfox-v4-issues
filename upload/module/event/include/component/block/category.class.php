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
 * @version 		$Id: category.class.php 2592 2011-05-05 18:51:50Z Raymond_Benc $
 */
class Event_Component_Block_Category extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$sCategory = $this->getParam('sCategory');
		
		$aCategories = Phpfox::getService('event.category')->getForBrowse($sCategory);
		
		if (!is_array($aCategories))
		{
			return false;
		}
		
		if (!count($aCategories))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => ($sCategory === null ? Phpfox::getPhrase('event.categories') : Phpfox::getPhrase('event.sub_categories')),
				'aCategories' => $aCategories,
				'sCategory' => $sCategory
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
		(($sPlugin = Phpfox_Plugin::get('event.component_block_category_clean')) ? eval($sPlugin) : false);
	}
}

?>