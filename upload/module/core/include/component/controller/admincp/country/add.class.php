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
 * @version 		$Id: add.class.php 982 2009-09-16 08:11:36Z Raymond_Benc $
 */
class Core_Component_Controller_Admincp_Country_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		if (($sIso = $this->request()->get('id')) && ($aCountry = Phpfox::getService('core.country')->getForEdit($sIso)))
		{
			$bIsEdit = true;
			$this->template()->assign(array(
					'aForms' => $aCountry
				)
			);
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('core.country.process')->update($aCountry['country_iso'], $aVals))
				{
					$this->url()->send('admincp.core.country.add', array('id' => $aCountry['country_iso']), Phpfox::getPhrase('admincp.country_successfully_updated'));
				}
			}
			else 
			{
				if (Phpfox::getService('core.country.process')->add($aVals))
				{
					$this->url()->send('admincp.core.country.add', null, Phpfox::getPhrase('admincp.country_successfully_added'));
				}				
			}
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('admincp.editing_country') . ': ' : Phpfox::getPhrase('admincp.add_a_country')))
			->setBreadcrumb(Phpfox::getPhrase('admincp.country_manager'), $this->url()->makeUrl('admincp.core.country'))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('admincp.editing_country') . ': ' : Phpfox::getPhrase('admincp.add_a_country')), null, true)
			->assign(array(
					'bIsEdit' => $bIsEdit
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_admincp_country_add_clean')) ? eval($sPlugin) : false);
	}
}

?>