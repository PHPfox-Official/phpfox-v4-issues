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
 * @version 		$Id: popular.class.php 1230 2009-10-28 12:26:46Z Raymond_Benc $
 */
class Group_Component_Block_Popular extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aGroups = Phpfox::getService('group')->getPopular();
		
		if (!count($aGroups) || !is_array($aGroups))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('group.popular_groups'),
				'aPopularGroups' => $aGroups
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
		(($sPlugin = Phpfox_Plugin::get('group.component_block_popular_clean')) ? eval($sPlugin) : false);
	}
}

?>