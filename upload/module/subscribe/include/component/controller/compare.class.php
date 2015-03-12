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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Subscribe_Component_Controller_Compare extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{			
		$aForCompare = Phpfox::getService('subscribe')->getPackagesForCompare();
		
		foreach ($aForCompare['packages'] as $iKey => $aPackage)
		{
			$iMatch = preg_match("/\{phrase var='(.*)'/i", $aPackage['description'], $aMatch);
			if ($iMatch)
			{
				$aForCompare['packages'][$iKey]['description'] = Phpfox::getPhrase($aMatch[1]);
			}			
		}
		
		$this->template()
			->setHeader(array(
					'compare.css' => 'module_subscribe'
				)
			)
			->assign(array(
					'aPackages' => $aForCompare,
					'bIsDisplay' => true,
				)
			)
			->setFullSite()
			->setBreadCrumb(Phpfox::getPhrase('subscribe.membership_packages'), $this->url()->makeUrl('subscribe'))
			->setTitle(Phpfox::getPhrase('subscribe.compare_subscription_packages'));		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('subscribe.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>