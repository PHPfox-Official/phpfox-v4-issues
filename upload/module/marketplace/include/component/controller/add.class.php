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
 * @version 		$Id: add.class.php 4921 2012-10-22 13:47:30Z Miguel_Espinoza $
 */
class Marketplace_Component_Controller_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('marketplace.can_create_listing', true);
		
		$bIsEdit = false;
		$bIsSetup = ($this->request()->get('req4') == 'setup' ? true : false);
		$sAction = $this->request()->get('req3');	
		
		if ($iEditId = $this->request()->get('id'))
		{
			if (($aListing = Phpfox::getService('marketplace')->getForEdit($iEditId)))
			{
				$bIsEdit = true;
				$this->setParam('aListing', $aListing);
				$this->setParam(array(
						'country_child_value' => $aListing['country_iso'],
						'country_child_id' => $aListing['country_child_id']
					)
				);				
				$this->template()->setHeader(array(
							'<script type="text/javascript">$Behavior.marketplaceEditCategory = function(){ var aCategories = explode(\',\', \'' . $aListing['categories'] . '\'); for (i in aCategories) { $(\'#js_mp_holder_\' + aCategories[i]).show(); $(\'#js_mp_category_item_\' + aCategories[i]).attr(\'selected\', true); } }</script>'
						)
					)
					->assign(array(
						'aForms' => $aListing
					)
				);
			}
		}
		else 
		{
			$this->template()->assign('aForms', array('price' => '0.00'));
		}
		
		$aValidation = array(
			'title' => Phpfox::getPhrase('marketplace.provide_a_name_for_this_listing'),
			'country_iso' => Phpfox::getPhrase('marketplace.provide_a_location_for_this_listing'),
			'price' => array(
				'def' => 'money'
			)
		);
		
		$oValidator = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_marketplace_form',
				'aParams' => $aValidation
			)
		);
		
		// With this we implement support for Input validation here (which at this point only means required fields)
		if (Phpfox::isModule('input'))
		{
			$oValidator->setAction('marketplace.add-listing');
		}
		
		if ($aVals = $this->request()->get('val'))
		{
			if ($oValidator->isValid($aVals))
			{				
				if ($bIsEdit)
				{
					if (Phpfox::getService('marketplace.process')->update($aListing['listing_id'], $aVals))
					{
						(($sPlugin = Phpfox_Plugin::get('marketplace.component_controller_add_process_update_complete')) ? eval($sPlugin) : false);

						if ($bIsSetup)
						{
							switch ($sAction)
							{
								case 'customize':							
									$this->url()->send('marketplace.add.invite.setup', array('id' => $aListing['listing_id']), Phpfox::getPhrase('marketplace.successfully_uploaded_images_for_this_listing'));	
									break;
								case 'invite':							
									$this->url()->permalink('marketplace', $aListing['listing_id'], $aListing['title'], true, Phpfox::getPhrase('marketplace.successfully_invited_users_for_this_listing'));	
									break;		
							}
							
						}
						else 
						{
							switch ($this->request()->get('page_section_menu'))
							{
								case 'js_mp_block_customize':
									$this->url()->send('marketplace.add.customize', array('id' => $aListing['listing_id']), Phpfox::getPhrase('marketplace.successfully_uploaded_images'));	
									break;
								case 'js_mp_block_invite':
									$this->url()->send('marketplace.add.invite', array('id' => $aListing['listing_id']), Phpfox::getPhrase('marketplace.successfully_invited_users'));	
									break;										
								default:
									$this->url()->send('marketplace.add', array('id' => $aListing['listing_id']), Phpfox::getPhrase('marketplace.listing_successfully_updated'));	
									break;	
							}								
						}
					}
				}
				else 
				{
					if (($iFlood = Phpfox::getUserParam('marketplace.flood_control_marketplace')) !== 0)
					{
						$aFlood = array(
							'action' => 'last_post', // The SPAM action
							'params' => array(
								'field' => 'time_stamp', // The time stamp field
								'table' => Phpfox::getT('marketplace'), // Database table we plan to check
								'condition' => 'user_id = ' . Phpfox::getUserId(), // Database WHERE query
								'time_stamp' => $iFlood * 60 // Seconds);	
							)
						);
							 			
						// actually check if flooding
						if (Phpfox::getLib('spam')->check($aFlood))
						{
							Phpfox_Error::set(Phpfox::getPhrase('marketplace.you_are_creating_a_listing_a_little_too_soon') . ' ' . Phpfox::getLib('spam')->getWaitTime());	
						}
					}					
					
					if (Phpfox_Error::isPassed())
					{				
						if ($iId = Phpfox::getService('marketplace.process')->add($aVals))
						{							
							$this->url()->send('marketplace.add.customize.setup', array('id' => $iId), Phpfox::getPhrase('marketplace.listing_successfully_added'));
						}
					}
				}
			}			
		}	
		
		$aCurrencies = Phpfox::getService('core.currency')->get();
		foreach ($aCurrencies as $iKey => $aCurrency)
		{
			$aCurrencies[$iKey]['is_default'] = '0';
			
			if (Phpfox::getService('core.currency')->getDefault() == $iKey)	
			{
				$aCurrencies[$iKey]['is_default'] = '1';	
			}
		}		
		
		if ($bIsEdit)
		{
			$aMenus = array(
				'detail' => Phpfox::getPhrase('marketplace.listing_details'),
				'customize' => Phpfox::getPhrase('marketplace.photos'),
				'invite' => Phpfox::getPhrase('marketplace.invite')
			);
			
			if (!$bIsSetup)
			{
				$aMenus['manage'] = Phpfox::getPhrase('marketplace.manage_invites');
			}
			
			$this->template()->buildPageMenu('js_mp_block', 
				$aMenus,
				array(
					'link' => $this->url()->permalink('marketplace', $aListing['listing_id'], $aListing['title']),
					'phrase' => Phpfox::getPhrase('marketplace.view_this_listing')
				)				
			);		
		}		
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('marketplace.editing_listing') . ': ' . $aListing['title'] : Phpfox::getPhrase('marketplace.create_a_marketplace_listing')))
			->setBreadcrumb(Phpfox::getPhrase('marketplace.marketplace'), $this->url()->makeUrl('marketplace'))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('marketplace.editing_listing') . ': ' . $aListing['title'] : Phpfox::getPhrase('marketplace.create_a_listing')), $this->url()->makeUrl('marketplace.add'), true)
			->setEditor()
			->setFullSite()			
			->setPhrase(array(
					'core.select_a_file_to_upload'
				)
			)				
			->setHeader(array(
					'add.js' => 'module_marketplace',
					'progress.js' => 'static_script',
					'<script type="text/javascript">$Behavior.marketplaceProgressBarSettings = function(){ if ($Core.exists(\'#js_marketplace_form_holder\')) { oProgressBar = {holder: \'#js_marketplace_form_holder\', progress_id: \'#js_progress_bar\', uploader: \'#js_progress_uploader\', add_more: true, max_upload: ' . (int) Phpfox::getUserParam('marketplace.total_photo_upload_limit') . ', total: 1, frame_id: \'js_upload_frame\', file_id: \'image[]\'}; $Core.progressBarInit(); } }</script>',
					'pager.css' => 'style_css',
					'country.js' => 'module_core'
				)
			)
			->assign(array(
					'sMyEmail' => Phpfox::getUserBy('email'),
					'sCreateJs' => $oValidator->createJS(),
					'sGetJsForm' => $oValidator->getJsForm(false),
					'bIsEdit' => $bIsEdit,
					'sCategories' => Phpfox::getService('marketplace.category')->get(),
					'iMaxFileSize' => (Phpfox::getUserParam('marketplace.max_upload_size_listing') === 0 ? null : ((Phpfox::getUserParam('marketplace.max_upload_size_listing') / 1024) * 1048576)),
					'aCurrencies' => $aCurrencies,
					'sUserSettingLink' => $this->url()->makeUrl('user.setting')
				)
			);
			
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_controller_add_process')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_controller_add_clean')) ? eval($sPlugin) : false);
	}
}

?>