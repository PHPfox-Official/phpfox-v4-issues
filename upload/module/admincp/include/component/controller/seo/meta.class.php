<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Add a new setting from the Admin CP
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: meta.class.php 5936 2013-05-15 08:16:34Z Raymond_Benc $
 */
class Admincp_Component_Controller_Seo_Meta extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 * @todo Complete the update routine...
	 */	
	public function process()
	{
		$aMetas = Phpfox::getService('admincp.seo')->getSiteMetas();
		if (is_bool($aMetas))
		{
			$aMetas = array();
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.custom_elements'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.custom_elements'), $this->url()->makeUrl('admincp.seo.meta'))
			->assign(array(
					'aMetas' => $aMetas
			)
		);
	}	
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_seo_meta_clean')) ? eval($sPlugin) : false);
	}	
}

?>