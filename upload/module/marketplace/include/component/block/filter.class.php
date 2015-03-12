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
 * @version 		$Id: filter.class.php 1784 2010-08-31 18:31:24Z Raymond_Benc $
 */
class Marketplace_Component_Block_Filter extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$sUserLinkProfile = '';
		if (defined('PHPFOX_IS_USER_PROFILE'))
		{
			$aUser = $this->getParam('aUser');
			$sUserLinkProfile = $aUser['user_name'] . '.';
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('marketplace.browse_filter'),
				'sUserLinkProfile' => $sUserLinkProfile
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
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_block_filter_clean')) ? eval($sPlugin) : false);
	}
}

?>