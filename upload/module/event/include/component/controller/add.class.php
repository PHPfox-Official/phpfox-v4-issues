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
 * @version 		$Id: add.class.php 5481 2013-03-11 08:02:19Z Raymond_Benc $
 */
class Event_Component_Controller_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('event.can_create_event', true);
		
		$bIsEdit = false;
		$bIsSetup = ($this->request()->get('req4') == 'setup' ? true : false);
		$sAction = $this->request()->get('req3');
		$aCallback = false;		
		$sModule = $this->request()->get('module', false);
		$iItem =  $this->request()->getInt('item', false);
		
		if ($iEditId = $this->request()->get('id'))
		{
			if (($aEvent = Phpfox::getService('event')->getForEdit($iEditId)))
			{
				$bIsEdit = true;
				$this->setParam('aEvent', $aEvent);
				$this->setParam(array(
						'country_child_value' => $aEvent['country_iso'],
						'country_child_id' => $aEvent['country_child_id']
					)
				);				
				$this->template()->setHeader(array(
							'<script type="text/javascript">$Behavior.eventEditCategory = function(){  var aCategories = explode(\',\', \'' . $aEvent['categories'] . '\'); for (i in aCategories) { $(\'#js_mp_holder_\' + aCategories[i]).show(); $(\'#js_mp_category_item_\' + aCategories[i]).attr(\'selected\', true); } }</script>'
						)
					)
					->assign(array(
						'aForms' => $aEvent,
						'aEvent' => $aEvent
					)
				);
				
				if ($aEvent['module_id'] != 'event')
				{
					$sModule = $aEvent['module_id'];
					$iItem = $aEvent['item_id'];	
				}
			}
		}		
		
		if ($sModule && $iItem && Phpfox::hasCallback($sModule, 'viewEvent'))
		{
			$aCallback = Phpfox::callback($sModule . '.viewEvent', $iItem);		
			$this->template()->setBreadcrumb($aCallback['breadcrumb_title'], $aCallback['breadcrumb_home']);
			$this->template()->setBreadcrumb($aCallback['title'], $aCallback['url_home']);		
			if ($sModule == 'pages' && !Phpfox::getService('pages')->hasPerm($iItem, 'event.share_events'))
			{
				return Phpfox_Error::display(Phpfox::getPhrase('event.unable_to_view_this_item_due_to_privacy_settings'));
			}				
		}		
		
		$aValidation = array(
			'title' => Phpfox::getPhrase('event.provide_a_name_for_this_event'),
			// 'country_iso' => Phpfox::getPhrase('event.provide_a_country_location_for_this_event'),			
			'location' => Phpfox::getPhrase('event.provide_a_location_for_this_event')
		);
		
		$oValidator = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_event_form',
				'aParams' => $aValidation
			)
		);		
		
		if ($aVals = $this->request()->get('val'))
		{
			if ($oValidator->isValid($aVals))
			{				
				if ($bIsEdit)
				{
					if (Phpfox::getService('event.process')->update($aEvent['event_id'], $aVals, $aEvent))
					{
						switch ($sAction)
						{
							case 'customize':
								$this->url()->send('event.add.invite.setup', array('id' => $aEvent['event_id']), Phpfox::getPhrase('event.successfully_added_a_photo_to_your_event'));	
								break;
							default:
								$this->url()->permalink('event', $aEvent['event_id'], $aEvent['title'], true, Phpfox::getPhrase('event.successfully_invited_guests_to_this_event'));
								break;							
						}	
					}
					else
					{
						$aVals['event_id'] = $aEvent['event_id'];
						$this->template()->assign(array('aForms' => $aVals, 'aEvent' => $aVals));
					}
				}
				else 
				{
					if (($iFlood = Phpfox::getUserParam('event.flood_control_events')) !== 0)
					{
						$aFlood = array(
							'action' => 'last_post', // The SPAM action
							'params' => array(
								'field' => 'time_stamp', // The time stamp field
								'table' => Phpfox::getT('event'), // Database table we plan to check
								'condition' => 'user_id = ' . Phpfox::getUserId(), // Database WHERE query
								'time_stamp' => $iFlood * 60 // Seconds);	
							)
						);
							 			
						// actually check if flooding
						if (Phpfox::getLib('spam')->check($aFlood))
						{
							Phpfox_Error::set(Phpfox::getPhrase('event.you_are_creating_an_event_a_little_too_soon') . ' ' . Phpfox::getLib('spam')->getWaitTime());	
						}
					}					
					
					if (Phpfox_Error::isPassed())
					{	
						if ($iId = Phpfox::getService('event.process')->add($aVals, ($aCallback !== false ? $sModule : 'event'), ($aCallback !== false ? $iItem : 0)))
						{
							$aEvent = Phpfox::getService('event')->getForEdit($iId);
							$this->url()->permalink('event', $aEvent['event_id'], $aEvent['title'], true, Phpfox::getPhrase('event.event_successfully_added'));
						}
					}
				}
			}
			
			$sStep = (isset($aVals['step']) ? $aVals['step'] : '');
			$sAction = (isset($aVals['action']) ? $aVals['action'] : '');	
			$this->template()->assign('aForms', $aVals);		
		}		
		
		if ($bIsEdit)
		{
			$aMenus = array(
				'detail' => Phpfox::getPhrase('event.event_details'),
				'customize' => Phpfox::getPhrase('event.photo'),
				'invite' => Phpfox::getPhrase('event.invite_guests')
			);
			// Dont show the photo upload for iOS
			if ($this->request()->isIOS())
			{
				//unset($aMenus['customize']);
			}
			if (!$bIsSetup)
			{
				$aMenus['manage'] = Phpfox::getPhrase('event.manage_guest_list');
				$aMenus['email'] = Phpfox::getPhrase('event.mass_email');
			}
			
			$this->template()->buildPageMenu('js_event_block', 
				$aMenus,
				array(
					'link' => $this->url()->permalink('event', $aEvent['event_id'], $aEvent['title']),
					'phrase' => Phpfox::getPhrase('event.view_this_event')
				)				
			);		
		}
		
		$this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('event.managing_event') . ': ' . $aEvent['title'] : Phpfox::getPhrase('event.create_an_event')))
			->setFullSite()			
			->setBreadcrumb(Phpfox::getPhrase('event.events'), ($aCallback === false ? $this->url()->makeUrl('event') : $this->url()->makeUrl($aCallback['url_home_pages'])))
			->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('event.managing_event') . ': ' . $aEvent['title'] : Phpfox::getPhrase('event.create_new_event')), ($bIsEdit ? $this->url()->makeUrl('event.add', array('id' => $aEvent['event_id'])) : $this->url()->makeUrl('event.add')), true)
			->setEditor()
			->setPhrase(array(
					'core.select_a_file_to_upload'
				)
			)				
			->setHeader('cache', array(	
					'add.js' => 'module_event',
					'pager.css' => 'style_css',
					'progress.js' => 'static_script',					
					'country.js' => 'module_core'					
				)
			)			
			->setHeader(array(
					'<script type="text/javascript">$Behavior.eventProgressBarSettings = function(){ if ($Core.exists(\'#js_event_block_customize_holder\')) { oProgressBar = {holder: \'#js_event_block_customize_holder\', progress_id: \'#js_progress_bar\', uploader: \'#js_progress_uploader\', add_more: false, max_upload: 1, total: 1, frame_id: \'js_upload_frame\', file_id: \'image\'}; $Core.progressBarInit(); } }</script>'
				)
			)
			->assign(array(
					'sCreateJs' => $oValidator->createJS(),
					'sGetJsForm' => $oValidator->getJsForm(false),
					'bIsEdit' => $bIsEdit,
					'bIsSetup' => $bIsSetup,
					'sCategories' => Phpfox::getService('event.category')->get(),
					'sModule' => ($aCallback !== false ? $sModule : ''),
					'iItem' => ($aCallback !== false ? $iItem : ''),
					'aCallback' => $aCallback,
					'iMaxFileSize' => (Phpfox::getUserParam('event.max_upload_size_event') === 0 ? null : Phpfox::getLib('phpfox.file')->filesize((Phpfox::getUserParam('event.max_upload_size_event') / 1024) * 1048576)),
					'bCanSendEmails' => ($bIsEdit ? Phpfox::getService('event')->canSendEmails($aEvent['event_id']) : false),
					'iCanSendEmailsTime' => ($bIsEdit ? Phpfox::getService('event')->getTimeLeft($aEvent['event_id']) : false),
					'sJsEventAddCommand' => (isset($aEvent['event_id']) ? "if (confirm('" . Phpfox::getPhrase('event.are_you_sure', array('phpfox_squote' => true)) . "')) { $('#js_submit_upload_image').show(); $('#js_event_upload_image').show(); $('#js_event_current_image').remove(); $.ajaxCall('event.deleteImage', 'id={$aEvent['event_id']}'); } return false;" : ''),
					'sTimeSeparator' => Phpfox::getPhrase('event.time_separator')
				)
			);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('event.component_controller_add_clean')) ? eval($sPlugin) : false);
	}
}

?>