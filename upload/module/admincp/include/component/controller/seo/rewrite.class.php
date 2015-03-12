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
class Admincp_Component_Controller_Seo_Rewrite extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 * @todo Complete the update routine...
	 */	
	public function process()
	{
		$aRewrites = Phpfox::getService('core.redirect')->getRewrites();
		$jRewrites = json_encode($aRewrites);
		$this->template()->setTitle(Phpfox::getPhrase('admincp.rewrite_url'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.rewrite_url'), $this->url()->makeUrl('admincp.seo.rewrite'))
			->setHeader(array(
				'rewrite.js' => 'module_admincp',
				'rewrite.css' => 'module_admincp'				
			))
			->setPhrase(array(
				'core.original_url',
				'core.replacement_url'				
			))
			->assign(array(
					'jRewrites' => $jRewrites
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