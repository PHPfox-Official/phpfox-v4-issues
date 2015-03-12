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
 * @version 		$Id: translate-country.class.php 1329 2009-12-16 17:01:32Z Raymond_Benc $
 */
class Core_Component_Block_Translate_Country extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$this->template()->assign(array(
				'sCountryIso' => $this->request()->get('country_iso'),
				'sCountryVarName' => 'core.translate_country_iso_' . strtolower($this->request()->get('country_iso')),
				'sCountryName' => Phpfox::getService('core.country')->getCountry($this->request()->get('country_iso'))
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_translate_country_clean')) ? eval($sPlugin) : false);
	}
}

?>