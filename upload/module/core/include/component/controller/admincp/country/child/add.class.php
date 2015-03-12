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
class Core_Component_Controller_Admincp_Country_Child_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		$sIso = '';
		$mCountry = '';
		if (($sIso = $this->request()->get('iso')))
		{
			$mCountry = Phpfox::getService('core.country')->getCountry($sIso);
			
			if ($mCountry === false)
			{
				return Phpfox_Error::display(Phpfox::getPhrase('admincp.not_a_valid_country'));
			}
		}
		elseif (($iChild = $this->request()->getInt('id')))
		{
			if (($aChild = Phpfox::getService('core.country')->getChildEdit($iChild)))
			{
				$bIsEdit = true;
				$this->template()->assign(array(
						'aForms' => $aChild
					)
				);
			}
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('core.country.child.process')->update($aChild['child_id'], $aVals))
				{					
					$this->url()->send('admincp.core.country.child', array('id' => $aChild['country_iso']), Phpfox::getPhrase('admincp.state_province_successfully_updated'));					
				}				
			}
			else 
			{
				if (Phpfox::getService('core.country.child.process')->add($aVals))
				{					
					$this->url()->send('admincp.core.country.child', array('id' => $aVals['country_iso']), Phpfox::getPhrase('admincp.state_province_successfully_added'));					
				}
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.country_manager'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.country_manager'), $this->url()->makeUrl('admincp.core.country'))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('admincp.editing_state_province') . ': ' : Phpfox::getPhrase('admincp.adding_state_province') . ': ' . $mCountry), null, true)		
			->assign(array(
					'bIsEdit' => $bIsEdit,
					'sIso' => $sIso
				)
			);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_admincp_country_child_add_clean')) ? eval($sPlugin) : false);
	}
}

?>