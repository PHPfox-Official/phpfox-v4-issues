<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Apps_Component_Block_Categories extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$aCategories = Phpfox::getService('apps')->getCategories();		
		
		if (!count($aCategories))
		{
			return false;
		}
		
		$iCurrentCategory = 0;
		if (is_int($this->request()->get('req3')))
		{
			$iCurrentCategory = $this->request()->get('req3');
		}
		$this->template()
			->assign(array(
				'sHeader' => Phpfox::getPhrase('apps.categories'),
				'aCategories' => $aCategories,
				'iCurrentCategory' => $iCurrentCategory
			));			
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('apps.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>