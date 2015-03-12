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
 * @version 		$Id: filter.class.php 7021 2014-01-06 19:37:08Z Fern $
 */
class User_Component_Block_Filter extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		// http://www.phpfox.com/tracker/view/14683/
		$aSearch = $this->request()->getArray('search');
		if(is_array($aSearch) && !empty($aSearch))
		{
			$this->template()->assign(array(
					'sCountryISO' => isset($aSearch['country']) ? $aSearch['country'] : '',
					'sCountryChildId' => isset($aSearch['country_child_id']) ? $aSearch['country_child_id'] : ''
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
		(($sPlugin = Phpfox_Plugin::get('user.component_block_filter_clean')) ? eval($sPlugin) : false);
	}
}

?>
