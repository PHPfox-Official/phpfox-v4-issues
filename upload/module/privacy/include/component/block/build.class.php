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
 * @version 		$Id: build.class.php 2621 2011-05-22 20:09:22Z Raymond_Benc $
 */
class Privacy_Component_Block_Build extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aPrivacySettings = Phpfox::getService('privacy')->get($this->getParam('privacy_module_id'), $this->getParam('privacy_item_id'));
		
		if (!count($aPrivacySettings))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'aPrivacySettings' => $aPrivacySettings,
				'sPrivacyArray' => $this->getParam('privacy_array', null)
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('privacy.component_block_build_clean')) ? eval($sPlugin) : false);
		
		
		$this->template()->clean(array(
				'sPrivacyArray'
			)
		);
		
		$this->clearParam('privacy_array');		
	}
}

?>