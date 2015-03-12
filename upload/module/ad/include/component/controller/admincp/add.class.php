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
 * @version 		$Id: add.class.php 6456 2013-08-13 12:47:12Z Raymond_Benc $
 */
class Ad_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_admincp_add_process__start')) ? eval($sPlugin) : false);
		$bIsEdit = false;
		$aVals = $this->request()->getArray('val');
		$aAllCountries = Phpfox::getService('core.country')->getCountriesAndChildren();
		$this->template()->setHeader(array(
						'add.js' => 'module_ad',
						'<script type="text/javascript">$Behavior.loadAdJs = function() { $Core.Ad.isEdit = true; $Core.Ad.setCountries(\''. json_encode($aAllCountries) .'\'); }</script>'
					)
				)->assign(array('aAllCountries' => $aAllCountries));
				
		if (($iId = $this->request()->getInt('id')))
		{
			if (($aAd = Phpfox::getService('ad')->getForEdit($iId)))
			{
				$bIsEdit = true;
				if ($aAd['location'] == 50)
				{
					$aCustomAd = json_decode($aAd['html_code'], true);
					$aAd['c_ad_title'] = $aCustomAd['title'];
					$aAd['c_ad_body'] = $aCustomAd['body'];
				}
				
				$this->template()->assign('aForms', $aAd);
				$this->template()->assign('aAccess', $aAd['user_group']);
				
				if (isset($aAd['countries_list']) && !empty($aAd['countries_list']))
				{
					$sCountries = implode('_', $aAd['countries_list']);
					$aProvinces = array();
					if (isset($aAd['province']) && !empty($aAd['province']))
					{
						foreach ($aAd['province'] as $sProvince)
						{
							$aProvinces[$sProvince] = true;
						}
					}

					$this->template()->setHeader(array(
					'<script type="text/javascript"> $Behavior.toggleSelected = function(){$Core.Ad.toggleSelectedCountries("'.$sCountries.'");$Core.Ad.toggleSelectedProvinces('. json_encode($aProvinces) .');};  </script>'
					));
				}
				else
				{
					$this->template()->setHeader(array(
						'<script type="text/javascript"> $Behavior.toggleSelectedCountries = function(){ $("#country_iso option:eq(0)").attr("selected", "selected"); }; </script>'
					));
				}
				
			}
		}
		
		$aValidation = array(
			'type_id' => array(
				'title' => Phpfox::getPhrase('ad.select_a_banner_type'),
				'def' => 'int'
			),
			'name' => Phpfox::getPhrase('ad.provide_a_name_for_this_campaign')
		);
		
		if (is_array($aVals) && count($aVals) > 0)
		{
			if (isset($aVals['type_id']))
			{
				if ($aVals['type_id'] == 1)
				{
					$aValidation['url_link'] = Phpfox::getPhrase('ad.provide_a_link_for_your_banner');
				}
			}
		}
		
		$oValidator = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));	
		
		if (is_array($aVals) && count($aVals) > 0)
		{
			if ($aVals['type_id'] == 2 && empty($aVals['html_code']))
			{
				Phpfox_Error::set(Phpfox::getPhrase('ad.provide_html_for_your_banner'));	
			}

			if ($oValidator->isValid($aVals))
			{
				if ($bIsEdit)
				{
					if (Phpfox::getService('ad.process')->update($aAd['ad_id'], $aVals))
					{
						$this->url()->send('admincp.ad.add', array('id' => $aAd['ad_id']), Phpfox::getPhrase('ad.ad_successfully_updated'));
					}				
				}
				else 
				{
					if (Phpfox::getService('ad.process')->add($aVals))
					{
						$this->url()->send('admincp.ad.add', null, Phpfox::getPhrase('ad.ad_successfully_added'));
					}
				}
			}
			
			if (isset($aVals['user_group']))
			{
				$this->template()->assign('aAccess', $aVals['user_group']);
			}
			$this->template()->assign('aForms', $aVals);
		}
		
		$aAge = array();
		$iAgeEnd = date('Y')-Phpfox::getParam('user.date_of_birth_start');
		$iAgeStart = date('Y')-Phpfox::getParam('user.date_of_birth_end');
		for ($iAgeStart; $iAgeStart <= $iAgeEnd; $iAgeStart++)
		{
			$aAge[$iAgeStart] = $iAgeStart;
		}	
		
		$this->template()->setTitle(Phpfox::getPhrase('ad.create_new_campaign'))
			->setBreadcrumb(Phpfox::getPhrase('ad.create_new_campaign'))
			->setPhrase(array(
					'ad.min_age_cannot_be_higher_than_max_age'
				)
			)
			->setHeader('cache', array(
					'ad.js' => 'module_ad'
				)
			)
			->assign(array(
					'aUserGroups' => Phpfox::getService('user.group')->get(),
					'aAge' => $aAge,
					'bIsEdit' => $bIsEdit,
					'sCreateJs' => $oValidator->createJS(),
					'sGetJsForm' => $oValidator->getJsForm(),
					'aComponents' => Phpfox::getService('admincp.component')->get()
				)			
			);
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_admincp_add_process__end')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>