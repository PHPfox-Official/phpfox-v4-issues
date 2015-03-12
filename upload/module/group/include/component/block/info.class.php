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
 * @version 		$Id: info.class.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
class Group_Component_Block_Info extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($this->getParam('bHideGroupBlocks'))
		{
			return false;
		}		
		
		$this->setParam('block_id', 3);
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('group.basic_info'),
				'sBlockJsId' => 'group_basic_info'
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
		(($sPlugin = Phpfox_Plugin::get('group.component_block_info_clean')) ? eval($sPlugin) : false);
	}	
}

?>