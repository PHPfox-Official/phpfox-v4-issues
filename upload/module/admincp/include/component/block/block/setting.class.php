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
 * @version 		$Id: setting.class.php 2228 2010-12-02 21:02:59Z Raymond_Benc $
 */
class Admincp_Component_Block_Block_Setting extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aSubBlocks = Phpfox::getService('admincp.block')->get($this->request()->get('m_connection'), $this->request()->get('style_id', 0));	
		$aModules = array();
		foreach ($aSubBlocks as $iKey => $aRow)
		{
			$aModules[$aRow['location']][] = $aRow;
		}		
		
		$this->template()->assign(array(
				'aModules' => $aModules,
				'aStyles' => Phpfox::getService('theme.style')->get(),
				'sConnection' => $this->request()->get('m_connection'),
				'iStyleId' => $this->request()->get('style_id', 0)
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_block_block_setting_clean')) ? eval($sPlugin) : false);
	}
}

?>