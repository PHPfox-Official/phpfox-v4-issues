<?php
defined('PHPFOX') or exit('No dice!');

class Core_Component_Block_DesignDND extends Phpfox_Component
{
	public function process()
	{
		
		if (!Phpfox::getUserParam('core.can_design_dnd'))
		{
			return false;
		}
		$this->template()->assign(array(
			'bEnabled' => PHPFOX_DESIGN_DND
			));
		
	}
}
?>
