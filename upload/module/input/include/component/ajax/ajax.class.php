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
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 4315 2012-06-21 13:22:06Z Miguel_Espinoza $
 */
class Input_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function blockOrdering()
	{
		if ($aVals = $this->get('val'))
		{			
			if (Phpfox::getService('input.process')->updateOrder($aVals['ordering']))
			{

			}			
		}	
	}

	public function optionsOrdering()
	{
		if ($aVals = $this->get('val'))
		{			
			if (Phpfox::getService('input.process')->updateOptionsOrder($aVals['ordering']))
			{

			}			
		}
	}
	
	public function popUpFilters()
	{
		Phpfox::getBlock('input.add', array('module' => $this->get('module'), 'bAjaxSearch' => true));
	}
}

?>
