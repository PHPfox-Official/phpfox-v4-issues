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
 * @version 		$Id: country-child.class.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
class Core_Component_Block_Country_Child extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$sCountryChildValue = $this->getParam('country_child_value');
		$mCountryChildFilter = $this->getParam('country_child_filter', $this->request()->get('country_child_filter', null));
		$sCountryChildType = $this->getParam('country_child_type', null);
		$sCountryChildId = null;
		
		if (empty($sCountryChildValue) && Phpfox::isUser() && $mCountryChildFilter === null && !$this->getParam('country_not_user'))
		{
			$sCountryChildValue = Phpfox::getUserBy('country_iso');
		}
		
		$iSearchId = 0;
		if ($mCountryChildFilter !== null)
		{
			$iSearchId = $this->request()->get('search-id');
			if (!empty($iSearchId) && isset($_SESSION[Phpfox::getParam('core.session_prefix')]['search'][$sCountryChildType][$iSearchId]['country']))
			{
				$sCountryChildValue = $_SESSION[Phpfox::getParam('core.session_prefix')]['search'][$sCountryChildType][$iSearchId]['country'];				
			}

			if (isset($_SESSION[Phpfox::getParam('core.session_prefix')]['search'][$sCountryChildType][$iSearchId]['country_child_id']))
			{
				$sCountryChildId = $_SESSION[Phpfox::getParam('core.session_prefix')]['search'][$sCountryChildType][$iSearchId]['country_child_id'];
			}
		}
		/* Last resort, get is a little heavy but controller didnt provide a child country*/
		if ($sCountryChildId == null && $this->getParam('country_child_id') == null)
		{
			$aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);			
			$sCountryChildId = $aUser['country_child_id'];			
		}
		$this->template()->assign(array(
				'aCountryChildren' => Phpfox::getService('core.country')->getChildren($sCountryChildValue),
				'iCountryChildId' => (int) $this->getParam('country_child_id', $sCountryChildId),
				'bForceDiv' => $this->getParam('country_force_div', false),
				'mCountryChildFilter' => $mCountryChildFilter				
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_country_child_clean')) ? eval($sPlugin) : false);
	}
}

?>