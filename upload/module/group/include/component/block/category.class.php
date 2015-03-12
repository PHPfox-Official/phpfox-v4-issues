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
 * @version 		$Id: category.class.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
class Group_Component_Block_Category extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$sCategory = $this->getParam('sCategory');
		
		$aCategories = Phpfox::getService('group.category')->getForBrowse($sCategory);
		
		if (!is_array($aCategories))
		{
			return false;
		}
		
		if (!count($aCategories))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => ($sCategory === null ? Phpfox::getPhrase('group.category') : Phpfox::getPhrase('group.sub_category')),
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
		(($sPlugin = Phpfox_Plugin::get('group.component_block_category_clean')) ? eval($sPlugin) : false);
	}
}

?>