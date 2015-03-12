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
 * @package  		Module_Group
 * @version 		$Id: index.class.php 3469 2011-11-07 16:51:48Z Raymond_Benc $
 */
class Group_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($sLegacyTitle = $this->request()->get('req2')) && !empty($sLegacyTitle))
		{			
			Phpfox::getService('core')->getLegacyItem(array(
					'field' => array('group_id', 'title'),
					'table' => 'group',		
					'redirect' => 'pages',
					'title' => $sLegacyTitle
				)
			);
		}		
		
		$this->url()->send('pages', array(), null, 301);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('group.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>