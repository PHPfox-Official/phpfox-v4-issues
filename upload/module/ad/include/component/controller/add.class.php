<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: add.class.php 6304 2013-07-19 06:13:17Z Miguel_Espinoza $
 */
class Ad_Component_Controller_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('ad.can_create_ad_campaigns', true);
		// $aAllCountries = Phpfox::getService('core.country')->get();
		$aAllCountries = Phpfox::getService('core.country')->getCountriesAndChildren();
		
		
		$bIsEdit = false;
		$bCompleted = ($this->request()->get('req3') == 'completed' ? true : false);		
		if (($iId = $this->request()->getInt('id')) && ($aAd = Phpfox::getService('ad')->getForEdit($iId)))
		{
			if ($aAd['user_id'] != Phpfox::getUserId())
			{
				return Phpfox_Error::display(Phpfox::getPhrase('ad.unable_to_edit_purchase_this_ad'));
			}
			
			if (!$bCompleted)
			{
				$bIsEdit = true;
			}
			$aAd['country_iso_custom'] = $aAd['country_iso'];
			
			$this->template()
				->assign(array(
					'aForms' => $aAd,
					'aAllCountries' => $aAllCountries
				)
			);
			$this->template()->setHeader(array(
						'add.js' => 'module_ad',
						'<script type="text/javascript">$Behavior.loadAdJs = function() { $Core.Ad.isEdit = true; $Core.Ad.setCountries(\''. json_encode($aAllCountries) .'\'); }</script>'
					)
				);
		}

		if ($bIsEdit)
		{
			$aValidation = array();
		}
		else 
		{
			$aValidation = array(
				'url_link' => array(
					'def' => 'url'
				)
			);				
		}
		
		$aValidation['name'] = Phpfox::getPhrase('ad.provide_a_campaign_name');
		if (!$bIsEdit)
		{
			$aValidation['total_view'] = Phpfox::getPhrase('ad.define_how_many_impressions_for_this_ad');
		}
		
		$oValidator = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));			
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($oValidator->isValid($aVals))
			{
				if (isset($aVals['location']))
				{
					if (Phpfox::getParam('ad.multi_ad'))
					{
						$aPlan = Phpfox::getService('ad')->getPlan( 50 , true );
					}
					else
					{
						$aPlan = Phpfox::getService('ad')->getPlan($aVals['block_id'], false);
					}

					$aVals = array_merge($aPlan, $aVals);
				}
				if ($bIsEdit)
				{					
					if (($iId = Phpfox::getService('ad.process')->updateCustom($aAd['ad_id'], $aVals)))
					{
						$this->url()->send('ad.manage', null, Phpfox::getPhrase('ad.ad_successfully_updated'));
					}					
				}
				else 
				{
					if (($iId = Phpfox::getService('ad.process')->addCustom($aVals)))
					{
						$this->url()->send('ad.add.completed', array('id' => $iId));
					}
				}
			}
		}
		
		$aAge = array();
		$iAgeEnd = date('Y')-Phpfox::getParam('user.date_of_birth_start');
		$iAgeStart = date('Y')-Phpfox::getParam('user.date_of_birth_end');
		for ($iAgeStart; $iAgeStart <= $iAgeEnd; $iAgeStart++)
		{
			$aAge[$iAgeStart] = $iAgeStart;
		}	
		
		$iPlacementCount = count((array) Phpfox::getService('ad')->getPlacements());
		
		if (!$bCompleted && !$bIsEdit)
		{
			if ($iPlacementCount)
			{
				$this->template()->setHeader(array(
						'add.js' => 'module_ad',
						'<script type="text/javascript">$Behavior.loadAdJs = function() { $Core.Ad.setCountries(\''. json_encode($aAllCountries) .'\'); };</script>'
					)
				);
			}		
		}
		else 
		{			
			$aPlan = Phpfox::getService('ad')->getPlan($aAd['location'], true);

			if (!isset($aPlan['plan_id']))
			{
				return Phpfox_Error::display(Phpfox::getPhrase('ad.not_a_valid_ad_plan'));	
			}
			// is it free?
			$aCosts = unserialize($aPlan['cost']);
			$bIsFree = true;
			foreach ($aCosts as $sCurrency => $fCost)
			{
				if ($fCost > 0)
				{
					$bIsFree = false;
					break;
				}
			}
			$this->template()->assign(array('bIsFree' => $bIsFree));
			$this->setParam('gateway_data', array(
					'item_number' => 'ad|' . $aAd['ad_id'],
					'currency_code' => $aPlan['default_currency_id'],					
					'amount' => $aPlan['is_cpm']? (($aPlan['default_cost'] * $aAd['total_view']) / 1000) : (($aPlan['default_cost'] * $aAd['total_view'])), 
					'item_name' => $aPlan['title'],
					'return' => $this->url()->makeUrl('ad.manage', array('view' => 'pending', 'payment' => 'done')),
					'recurring' => '',
					'recurring_cost' => '',
					'alternative_cost' => '',
					'alternative_recurring_cost' => ''
				)
			);			
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('ad.updating_an_ad') : Phpfox::getPhrase('ad.creating_an_ad')))	
			->setBreadcrumb(Phpfox::getPhrase('ad.advertise'), $this->url()->makeUrl('ad'))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('ad.updating_an_ad') : Phpfox::getPhrase('ad.creating_an_ad')), $this->url()->makeUrl('ad.add'), true)
			->setPhrase(array(
					'ad.select_an_ad_placement',
					'ad.there_is_minimum_of_1000_impressions'
				)
			)
			->assign(array(
					'aAge' => $aAge,
					'bIsEdit' => $bIsEdit,
					'sCreateJs' => $oValidator->createJS(),
					'sGetJsForm' => $oValidator->getJsForm(),
					'bCompleted' => $bCompleted,
					'bIsEdit' => $bIsEdit,
					'iPlacementCount' => $iPlacementCount,
					'aAllCountries' => $aAllCountries
				)
			)
			->setPhrase(array(
					'core.you_cannot_write_more_then_limit_characters',
					'core.you_have_limit_character_s_left',
					'ad.amount_currency_per_1000_impressions',
					'ad.amount_currency_per_click'
				)
			)
			->setHeader('cache', array(					
					'jquery/plugin/jquery.limitTextarea.js' => 'static_script',
					'colorpicker.js' => 'static_script',
					'colorpicker.css' => 'style_css',
					'colorpicker/js/colorpicker.js' => 'static_script',
					'add.css' => 'module_ad',
					'<script type="text/javascript">$Behavior.setMulti = function(){ oParams[\'ad.multi_ad\'] = ' . (Phpfox::getParam('ad.multi_ad') ? 'true': 'false'). ';};</script>'
				)
			)
			->setFullSite();		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_add_clean')) ? eval($sPlugin) : false);
	}
}

?>