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
 * @package  		Module_User
 * @version 		$Id: ajax.class.php 6792 2013-10-16 10:19:49Z Fern $
 */
class User_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function processPurchasePoints()
	{
		Phpfox::getBlock('user.processpoints');
		
		$this->html('#js_purchase_points', $this->getContent(false));
	}
	
	public function purchasePoints()
	{
		$this->setTitle(Phpfox::getPhrase('user.purchase_activity_points'));
		Phpfox::getBlock('user.purchasepoints');
	}
	
	public function updateFeedSort()
	{
		if (Phpfox::getService('user.process')->updateFeedSort($this->get('order')))
		{
			$this->call('window.location.href = \'\';');
		}
	}
	
	public function confirmEmail()
	{
		$aVals = $this->get('val');
		
		$bFailed = false;
		if (empty($aVals['email']) || empty($aVals['confirm_email']))
		{
			$bFailed = true;
		}
		else
		{
			if ($aVals['email'] != $aVals['confirm_email'])
			{
				$bFailed = true;
			}
		}
		
		if ($bFailed)
		{
			$this->show('#js_confirm_email_error');
		}
		else
		{
			$this->hide('#js_confirm_email_error');
		}
	}
	
	public function setCoverPhoto()
	{
		Phpfox::getService('user.process')->updateCoverPhoto($this->get('photo_id'));
		$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('profile', array('coverupdate' => '1')) . '\';');
	}	
	
	public function removeLogo()
	{
		Phpfox::getService('user.process')->removeLogo();
		$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('profile', array('newcoverphoto' => '1')) . '\';');
	}	
	
	public function updateCoverPosition()
	{
		Phpfox::getService('user.process')->updateCoverPosition($this->get('position'));
		$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('profile', array('newcoverphoto' => '1')) . '\';');
	}
	
	public function lostPassword($aArgs)
	{
		$this->call('$("#emailProcess").html(""); $("#jsLostPasswordForm_msg").message("' . Phpfox::getPhrase('user.your_password_has_been_sent_to_your_email') . '", "valid").slideDown("slow");');
	}

	public function login()
	{
		Phpfox::getBlock('user.login-ajax');
	}

	public function search()
	{
		$sId = $this->get('id');
		$aValue = $this->get('val');
		if (!isset($aValue[$sId]))
		{
			return false;
		}
		$sValue = $aValue[$sId][0];
		$sOld = $this->get('old');

		if (strpos($sValue, ','))
		{
			$aValues = explode(',', $sValue);
			$iCnt = (count($aValues) - 1);
			$sValue = trim($aValues[$iCnt]);
		}

		if (trim($sValue) == '')
		{
			$this->call("oInlineSearch.close('" . $this->get('id') . "');");
			return false;
		}

		$aRows = Phpfox::getService('user')->getInlineSearch($sValue, $sOld);

		if (count($aRows))
		{
			Phpfox::getLib('template')->assign(array(
					'aRows' => $aRows,
					'sJsId' => $this->get('id'),
					'sSearch' => $this->get('value'),
					'bIsUser' => true
				)
			)->getLayout('inline-search');

			$this->call("oInlineSearch.display('" . $this->get('id') . "', '" . $this->getContent() . "');");
		}
	}
	
	public function showUserName()
	{
		Phpfox_Ajax::error(false);
		
		$aVal = $this->get('val');		
		
		$aVal['user_name'] = str_replace(' ', '_', $aVal['user_name']);
		
		if (Phpfox::getLib('validator')->verify('username', $aVal['user_name']))
		{
			Phpfox::getService('user.validate')->user($aVal['user_name']);

			if (Phpfox_Error::isPassed())
			{
				$this->call('$(\'#js_signup_user_name\').html(\'<span style="color:green; font-weight:bold;">' . htmlentities(addslashes($aVal['user_name'])) . '</span>\');');

				return true;
			}
		}		

		$aErrors = Phpfox_Error::get();

		$this->call('$(\'#js_signup_user_name\').html(\'<span style="color:red; font-weight:bold;">' . htmlentities(addslashes($aVal['user_name'])) . '</span>\');');
	}

	public function searchUserName($aVal = null)
	{
		Phpfox_Ajax::error(false);
		
		if ($aVal === null)
		$aVal = $this->get('val');		
		
		$aVal['user_name'] = str_replace(' ', '_', $aVal['user_name']);
	
		if (Phpfox::getLib('validator')->verify('username', $aVal['user_name']))
		{
			Phpfox::getService('user.validate')->user($aVal['user_name']);

			if (Phpfox_Error::isPassed())
			{
				$this->call('$(\'#js_user_url_name\').html(\'<span style="color:green; font-weight:bold;">' . htmlentities(addslashes($aVal['user_name'])) . '</span>\');');
				$this->html('#js_user_name_error_message', '');

				return true;
			}
		}		

		$aErrors = Phpfox_Error::get();

		$this->call('$(\'#js_user_url_name\').html(\'<span style="color:red; font-weight:bold;">' . htmlentities(addslashes($aVal['user_name'])) . '</span>\');');

		return false;
	}
	
	public function clearStatus()
	{
		Phpfox::getService('user.process')->clearStatus(Phpfox::getUserId());
		
		$this->call('var sParsed = $("<div/>").html(\'' . Phpfox::getPhrase('core.what_is_on_your_mind') . '\').text();$("#js_global_status_input").val(sParsed);$("#js_status_input").val(sParsed);');
		$this->hide('#js_update_user_status_button')
			->show('#js_current_user_status')
			->hide('.user_status_update_ajax')
			->html('.js_actual_user_status_' . Phpfox::getUserId(), '')
			->html('.js_actual_user_status_bar_' . Phpfox::getUserId(), '');
	}
	
	public function updateStatus()
	{
		Phpfox::isUser(true);
		
		$aVals = (array) $this->get('val');		
		
		if (isset($aVals['user_status']) && ($iId = Phpfox::getService('user.process')->updateStatus($aVals)))
		{
			(($sPlugin = Phpfox_Plugin::get('user.component_ajax_updatestatus')) ? eval($sPlugin) : false);
			
			Phpfox::getService('feed')->processAjax($iId);		
		}
		else 
		{
			$this->call('$Core.activityFeedProcess(false);');
		}
	}
	
	public function mainBrowse()
	{
		Phpfox::getComponent('user.browse', array(), 'controller');
		
		$this->remove('.js_pager_view_more_link');
		$this->call("if($('#js_view_more_users').length == 0) { $('#delayed_block').append('<div id=\"js_view_more_users\"></div>'); } ");
		$this->append('#js_view_more_users', $this->getContent(false));
		$this->call('$Core.loadInit();');				
	}
	
	public function browse()
	{
		Phpfox::getBlock('user.browse', array('input' => $this->get('input')));
		$this->call('<script type="text/javascript">$(\'#TB_ajaxWindowTitle\').html(\'' . Phpfox::getPhrase('user.search_for_members', array('phpfox_squote' => true)) . '\');</script>');	
	}
	
	public function browseAjax()
	{		
		Phpfox::getBlock('user.browse', array('page' => $this->get('page'), 'find' => $this->get('find'), 'input' => $this->get('input'), 'is_search' => true));
		
		$this->call('$(\'#js_user_search_content\').html(\'' . $this->getContent() . '\'); updateCheckBoxes();');
	}

	/**
	 * Shows the deleteUser block, does not perform  the actual delete
	 */
	public function deleteUser()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		Phpfox::getUserParam('user.can_delete_others_account', true);
		$iUser = (int)$this->get('iUser');
		Phpfox::getBlock('user.admincp.deleteUser', array('iUser' => $iUser));
	}

	/**
	 * Deletes a feedback from the admin panel
	 */
	public function deleteFeedback()
	{
		Phpfox::isUser(true);
		$iFeedback = (int)$this->get('iFeedback');
		if (Phpfox::getService('user.cancellations.process')->deleteFeedback($iFeedback))
		{
			$this->call('$("#js_feedback_'.$iFeedback.'").remove();');
		}
		else
		{
			$this->alert(Phpfox::getPhrase('user.we_found_a_problem_with_your_request_please_try_again'));
		}
	}

	public function confirmedDelete()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		$iUser = (int)$this->get('iUser');
		
		if (!Phpfox::getService('user')->isAdminUser($iUser))
		{		
			Phpfox::getService('user.auth')->setUserId($iUser);
			Phpfox::massCallback('onDeleteUser', $iUser);
			Phpfox::getService('user.auth')->setUserId(null);
			$this->call('$("#js_user_'.$iUser.'").remove();');
			$this->setMessage('User ' . $iUser . ' deleted.');
		}
		else 
		{
			Phpfox_Error::set(Phpfox::getPhrase('user.you_are_unable_to_delete_a_site_administrator'));
		}
	}
	
	public function getRegistrationStep()
	{		
		$this->error(false);
		
		$aVals = $this->get('val');		
				
		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => Phpfox::getService('user.register')->getValidation($this->get('step'))));		
		
		if ($this->get('step') == '1')
		{
			if (!Phpfox::getParam('user.profile_use_id') && !Phpfox::getParam('user.disable_username_on_sign_up'))
			{
				$aVals['user_name'] = str_replace(' ', '_', $aVals['user_name']);
				Phpfox::getService('user.validate')->user($aVals['user_name']);
			}		
			
			Phpfox::getService('user.validate')->email($aVals['email']);
		}
		
		if ($oValid->isValid($aVals))
		{		
			if ($this->get('last'))
			{
				$this->call('$(\'#js_form\').submit();');
			}
			else 
			{
				(($sPlugin = Phpfox_Plugin::get('user.component_ajax_getregistrationstep_pass')) ? eval($sPlugin) : false);
				
				if (!isset($bSkipAjaxProcess))
				{
					$this->template()->assign(array(
							'aTimeZones' => Phpfox::getService('core')->getTimeZones(),
							'aPackages' => Phpfox::isModule('subscribe') ? Phpfox::getService('subscribe')->getPackages(true) : null, // two tickets with this problem
							'aSettings' => Phpfox::getService('custom')->getForEdit(array('user_main', 'user_panel', 'profile_panel'), null, null, true),
							'sDobStart' => Phpfox::getParam('user.date_of_birth_start'),
							'sDobEnd' => Phpfox::getParam('user.date_of_birth_end'),
							'bIsBlockSignUp' => (isset($aVals['block_signup']) ? true : false)
						)
					)->getTemplate('user.block.register.step' . ($this->get('step') + 1));
				
					$this->val('#js_registration_submit', html_entity_decode(Phpfox::getPhrase('user.continue'), null, 'UTF-8'));
					$this->call('$Core.registration.updateForm(\'' . $this->getContent() . '\');');
					if ($this->get('next'))
					{
						$this->call('$Core.registration.showCaptcha();');
					}
				}
			}
		}
		else 
		{
			$sErrors = '';
			foreach (Phpfox_Error::get() as $sError)
			{
				$sErrors .= '<div class="error_message">' . $sError . '</div>';
			}
			
			if ($this->get('step') == '1')
			{
				$this->call('$(\'#js_register_accept\').show();');
			}
			
			$this->call('$(\'#js_registration_process\').hide();$(\'#js_registration_holder\').show();')->html('#js_signup_error_message', $sErrors);
		}
		
		$this->call('$Core.loadInit();');
	}
	
	public function getNew()
	{
		Phpfox::getBlock('user.new');
		
		$this->html('#' . $this->get('id'), $this->getContent(false));
		$this->call('$(\'#' . $this->get('id') . '\').parents(\'.block:first\').find(\'.bottom li a\').attr(\'href\', \'' . Phpfox::getLib('url')->makeUrl('user.browse', array('sort' => 'joined')) . '\');');
	}	
	
	public function getAccountSettings()
	{
		Phpfox::getBlock('user.setting');
		
		$this->hide('#js_basic_info_data')
			->hide('#js_user_basic_info')
			->show('#js_user_basic_edit_link')
			->html('#js_basic_info_form', $this->getContent(false))
			->show('#js_basic_info_form');
	}
	
	public function updateAccountSettings()
	{		
		$aValidation = array(					
			'country_iso' => Phpfox::getPhrase('user.select_current_location')					
		);	

		if (Phpfox::getUserParam('user.can_edit_gender_setting'))
		{
			$aValidation['gender'] = Phpfox::getPhrase('user.select_your_gender');
		}
		
		if (Phpfox::getUserParam('user.can_edit_dob'))
		{
			$aValidation['month'] = Phpfox::getPhrase('user.select_month_of_birth');
			$aValidation['day'] = Phpfox::getPhrase('user.select_day_of_birth');
			$aValidation['year'] = Phpfox::getPhrase('user.select_year_of_birth');
		}	
		
		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));
		
		if (!$oValid->isValid($this->get('val')))
		{
			$this->hide('#js_updating_basic_info_load')->show('#js_updating_basic_info');
			
			return false;				
		}
		
		if (Phpfox::getService('user.process')->updateSimple(Phpfox::getUserId(), $this->get('val')))
		{
					
		}		
		
		if (Phpfox::getService('custom.process')->updateFields(Phpfox::getUserId(), Phpfox::getUserId(), $this->get('custom')))
		{
			
		}
		
		Phpfox::getBlock('profile.info');
		
		$this->hide('#js_updating_basic_info_load')->show('#js_updating_basic_info');
		$this->hide('#js_basic_info_form')
			->html('#js_basic_info_data', $this->getContent(false))
			->show('#js_basic_info_data')
			->call('$Core.rate.init({display: false, error_message: \'' . Phpfox::getPhrase('user.you_cannot_rate_your_own_profile', array('phpfox_squote' => true)) . '\'});');
	}
	
	public function updateFooterBar()
	{
		Phpfox::isUser(true);
		Phpfox::getService('user.process')->updateFooterBar(Phpfox::getUserId(), $this->get('type_id'));		
	}
	
	public function hideBlock()
	{
		Phpfox::getService('user.process')->hideBlock($this->get('block_id'));
	}

	public function verifyUsername()
	{
        if (!Phpfox::getParam('user.suggest_usernames_on_registration'))
		{
        	return false;
		}
                
		$aUser = array('user_name' => $this->get('user_name'));
		
		$aUser['user_name'] = str_replace(' ', '_', $aUser['user_name']);
		
		Phpfox::getLib('validator')->verify('username', $aUser['user_name']);		
		
		if (!Phpfox_Error::isPassed())
		{			
			return false;
		}		
		
		if ($this->searchUserName($aUser))
		{
			// this username is valid
			$this->html('#js_verify_username', '<div class="valid_message">' . Phpfox::getPhrase('user.this_username_is_available') . '</div>')->show('#js_verify_username');
		}
		else
		{		
			// get X suggestions as usernames and check them			
			$iFailedTries = 0;
			$aValidNames = array();			
			// filter the username so it only allows a-z, A-Z, numbers, dash (-) and underscore (_)
			$sValidUsername = '';
			if (strlen($aUser['user_name']) > 0)
			{
				for($i = 0; $i < strlen($aUser['user_name']); $i++)
				{
					if(preg_match('/[-a-zA-Z0-9_]/i', $aUser['user_name'][$i]) !== false)
					{
						$sValidUsername .= $aUser['user_name'][$i];
					}
				}
			}
			$aSuggestedNames = Phpfox::getParam('user.usernames_to_suggest');
			$aSuggestedNames[] = $sValidUsername;
			
			// check user.validate --> eregi("[a-zA-Z] use this to get the valid part of the username and generate the new usernames
			$iRand = rand(100, 999);
			while ( count($aValidNames) < Phpfox::getParam('user.how_many_usernames_to_suggest'))
			{
				$sTry = $aSuggestedNames[array_rand($aSuggestedNames)] . $iRand;
				if (Phpfox::getLib('validator')->verify('username', $sTry)
					&& Phpfox::getLib('parse.input')->allowTitle($sTry, 'Username is already in use.')
					&& Phpfox::getService('ban')->check('username', $sTry)	
				)
				{
					$aValidNames[] = $sTry;
					$iRand = rand(100, 999);
				}
				elseif ($iFailedTries < 2)
				{
					// missed once, we increment the random value
					$iRand = rand(100, 9999);
					$iFailedTries++;
				}
				else
				{
					// ok now its too many
					break;
				}				
			}			
			
			Phpfox::getBlock('user.signup-error', array('aNames' => $aValidNames));
			
			$this->html('#js_verify_username', $this->getContent(false))->show('#js_verify_username');			
		}
	}
	
	public function loadCustomField()
	{
		Phpfox::getBlock('user.custom');	
		
		$this->html('#js_custom_field_holder', $this->getContent(false));
	}	
	
	public function changePicture()
	{
		Phpfox::getBlock('user.photo');	
	}	
	
	public function block()
	{
		Phpfox::getBlock('user.block');
	}
	
	public function processBlock()
	{		
		if (Phpfox::getService('user.block.process')->add($this->get('user_id')))
		{
			$this->setMessage(Phpfox::getPhrase('user.user_successfully_blocked'));
		}
	}
	
	public function unBlock()
	{
		if (Phpfox::getService('user.block.process')->delete($this->get('user_id')))
		{
			$this->setMessage(Phpfox::getPhrase('user.user_successfully_unblocked'));
		}		
	}

	/**
	 * Handles featuring and unfeaturing a user, permissions are checked on the service itself
	 * @param int $iUser
	 */
	public function feature()
	{
		$iUser = intval($this->get('user_id'));
		$bFeature = $this->get('feature');
		if ($bFeature == 1 || $bFeature == 0)
		{
			if ($bFeature == 1 && (Phpfox::getService('user.featured.process')->feature($iUser))) // trying to feature
			{
				if ($this->get('type') != '1')
				{
					$sNewHtml = '<a href=\"#\" onclick=\"$.ajaxCall(\'user.feature\', \'user_id='.$iUser.'&feature=0\'); return false;\">' . Phpfox::getPhrase('user.unfeature_user');
					$this->call('$(".js_feature_'.$iUser.'").html("'.$sNewHtml.'");');
				}

				return true;
			}
			elseif($bFeature == 0 && (Phpfox::getService('user.featured.process')->unfeature($iUser)))			
			{
				if ($this->get('type') != '1')
				{
					$sNewHtml = '<a href=\"#\" onclick=\"$.ajaxCall(\'user.feature\', \'user_id='.$iUser.'&feature=1\'); return false;\">' . Phpfox::getPhrase('user.feature_user');
					$this->call('$(".js_feature_'.$iUser.'").html("'.$sNewHtml.'");');
				}				

				if ($this->get('view') == 'featured')
				{
					$this->hide('#js_parent_user_' . $iUser);
				}				
				
				return true;
			}
			
			
		}// else potential hack attempt		
		
		$this->alert(Phpfox::getPhrase('user.an_error_occured_and_this_operation_was_not_completed')); // potential hack attempt
		
		return false;
	}

	/**
	 * Changes the order of a fetured member
	 */
	public function setFeaturedOrder()
	{		
		if (Phpfox::getService('user.featured.process')->updateOrder($this->get('val')))
		{
			
		}
	}

	/**
	 * Verifies a username so the user can log in.
	 */
	public function verifyEmail()
	{
		$iUser = $this->get('iUser');
		$bVerified = Phpfox::getService('user.verify.process')->adminVerify($iUser);
		if ($bVerified == true)
		{
			$this->call('$(".js_verify_email_'.$iUser.'").hide("slow", function(){$(this).remove();});');
			//$this->call('$("#js_user_'.$iUser.'").hide("slow", function(){$(this).remove();});');
		}
		else
		{
			$this->alert(Phpfox::getPhrase('user.an_error_occured_and_this_user_could_not_be_verified'));
		}
	}

	/**
	 * Sends an email to the user_id with with the verification  link
	 */
	public function verifySendEmail()
	{
		$iUser = $this->get('iUser');
		$bSent = Phpfox::getService('user.verify.process')->sendMail($iUser);
		if ($bSent)
		{
			$this->alert(Phpfox::getPhrase('user.verification_email_sent'));
			return true;
		}

		$this->alert(Phpfox::getPhrase('user.an_error_occured_and_the_email_could_not_be_sent'));
		return false;
	}
	
	public function cropPhoto()
	{		
		$aPostVals = $this->get('val');
		
		if (empty($aPostVals['w']) && !isset($aPostVals['skip_croping']))
		{			
			$this->show('#js_photo_preview_ajax')->html('#js_photo_preview_ajax', '');

			return Phpfox_Error::set(Phpfox::getPhrase('photo.select_an_area_on_your_photo_to_crop'));
		}		
		
		if ($this->get('in_process'))
		{
			$oImage = Phpfox::getLib('image');
			$sFileName = $this->get('in_process');
			$aImages = array();
			if (($sPhotos = $this->get('photos')))
			{
				$aImages = unserialize(base64_decode(urldecode($this->get('photos'))));	
			}
			
			$iNotCompleted = 0;
			foreach(Phpfox::getParam('user.user_pic_sizes') as $iSize)
			{
				if (isset($aImages[sprintf($sFileName, '_' . $iSize)]))
				{
					continue;
				}
				
				if (Phpfox::getParam('core.keep_non_square_images'))
				{
					$oImage->createThumbnail(Phpfox::getParam('core.dir_user') . sprintf($sFileName, ''), Phpfox::getParam('core.dir_user') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);
				}
				$oImage->createThumbnail(Phpfox::getParam('core.dir_user') . sprintf($sFileName, ''), Phpfox::getParam('core.dir_user') . sprintf($sFileName, '_' . $iSize . '_square'), $iSize, $iSize, false);
				
				$aImages[sprintf($sFileName, '_' . $iSize)] = true;
				
				$iNotCompleted++;
				
				$this->call('p(\'Processing photo: ' . sprintf($sFileName, '_' . $iSize) . '\');');
				
				break;
			}

			$sValues = '';
			foreach ($this->get('val') as $sKey => $mValue)
			{
				$sValues .= '&val[' .$sKey . ']=' . urlencode($mValue);
			}				
			
			if ($iNotCompleted)
			{
				$this->call('$.ajaxCall(\'user.cropPhoto\', \'js_disable_ajax_restart=true&photos=' . urlencode(base64_encode(serialize($aImages))) . '&in_process=' . $this->get('in_process') . '&file=' . $this->get('in_process') . '' . $sValues . '\');');
			}
			else 
			{
				$oFile = Phpfox::getLib('file');
				
				$iServerId = Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID');
				
				$this->call('p(\'Completed resizing photos.\');');
				
				if (Phpfox::getUserBy('user_image') != '')
				{			
					if (file_exists(Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '')))
					{
						$oFile->unlink(Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), ''));
						foreach(Phpfox::getParam('user.user_pic_sizes') as $iSize)
						{
							if (file_exists(Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '_' . $iSize)))
							{
								$oFile->unlink(Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '_' . $iSize));
							}
							
							if (file_exists(Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '_' . $iSize . '_square')))
							{
								$oFile->unlink(Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '_' . $iSize . '_square'));
							}					
						}
					}
				}				

				$sFileName = $this->get('file');
				
				Phpfox::getLib('database')->update(Phpfox::getT('user'), array('user_image' => $sFileName, 'server_id' => $iServerId), 'user_id = ' . Phpfox::getUserId());

				(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('user_photo', Phpfox::getUserId()) : null);
				(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('user_photo', Phpfox::getUserId(), serialize(array('destination' => $sFileName, 'server_id' => $iServerId))) : null);				
				
				$this->call('$.ajaxCall(\'user.cropPhoto\', \'crop=true&js_disable_ajax_restart=true' . $sValues . '\');');
				if (Phpfox::isModule('photo'))
				{
					Phpfox::getService('photo.album')->getForProfileView(Phpfox::getUserId(), true);
				}
			}
			
			return;
		}
		
		$aVals = $this->get('val');
		
		if ((isset($aVals['skip_croping']) || (!isset($aVals['skip_croping']))))
		{
			$this->call('p(\'Cropping photo.\');');
			if (Phpfox::getService('user.process')->cropPhoto($this->get('val')))
			{		
				/*
				if ($this->get('crop'))
				{
				 * 
				 */
					Phpfox::addMessage(Phpfox::getPhrase('user.profile_photo_successfully_updated'));
					
					$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('user.photo') . '\';');	
				/*
				}
				else 
				{
					$this->show('#js_photo_preview_ajax')->html('#js_photo_preview_ajax', '<span class="valid_message">' . Phpfox::getPhrase('user.done') . '</span>', '.fadeOut(5000)');
					$sImageAvatar = Phpfox::getLib('image.helper')->display(array(
							'server_id' => Phpfox::getUserBy('server_id'),
							'title' => Phpfox::getUserBy('full_name'),
							'path' => 'core.url_user',
							'file' => Phpfox::getUserBy('user_image'),
							'suffix' => '_75_square',
							'max_width' => 75,
							'max_height' => 75,
							'no_default' => true,
							'time_stamp' => true,
							'class' => 'border'		
						)
					);
					$this->html('#js_user_avatar', $sImageAvatar);	
				}			
				 * 
				 */
			}
			else 
			{
				$this->show('#js_photo_preview_ajax')->html('#js_photo_preview_ajax', '');
			}
		}
	}
	
	public function changePassword()
	{
		Phpfox::getBlock('user.password');
	}
	
	public function updatePassword()
	{
		$this->error(false);
		
		if (Phpfox::getService('user.process')->updatePassword($this->get('val')))
		{
			Phpfox::addMessage(Phpfox::getPhrase('user.password_successfully_updated'));
			
			$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('user.setting') . '\';');
		}
		else 
		{
			$this->html('#js_progress_cache_loader', '<div class="error_message">' . implode('', Phpfox_Error::get()) . '</div>');
		}
	}
	
	public function checkSpaceUsage()
	{
		$this->error(false);
		if (Phpfox::getService('user.space')->isAllowedToUpload(Phpfox::getUserId()))
		{
			
		}
		else 
		{
			$this->html('#js_progress_cache_loader', '<div class="error_message">' . implode('', Phpfox_Error::get()) . '</div>');
			$this->hide('#' . $this->get('holder'));
			$this->show('#js_progress_cache_loader');
		}
	}	
	
	public function browseMethod()
	{
		if ($this->get('type') == 'advanced')
		{
			$this->show('#js_user_browse_advanced');
		}
		else 
		{
			$this->hide('#js_user_browse_advanced')->val('.js_custom_search', '');
		}
	}
	
	public function ban()
	{
		if (Phpfox::getService('user.process')->ban($this->get('user_id'), $this->get('type')))
		{
			if ($this->get('type') == 1)
			{
				Phpfox::addMessage(Phpfox::getPhrase('profile.this_user_has_been_banned'));
			}
			else
			{
				Phpfox::addMessage(Phpfox::getPhrase('ban.this_user_has_been_unbanned'));
			}
			$this->call("window.location.reload(true);");
			/*$this->html('#js_ban_' . $this->get('user_id'), ($this->get('type') ?
					'<a href="#" onclick="$.ajaxCall(\'user.ban\', \'user_id=' . $this->get('user_id') . '&amp;type=0\'); return false;">' . Phpfox::getPhrase('user.un_ban_user') . '</a>'
					:
					'<a href="'.Phpfox::getLib('url')->makeUrl('admincp.user.ban', array('user'=> $this->get('user_id'))) . '">' . Phpfox::getPhrase('user.ban_user') . '</a>'));
			$this->html('#user_status_' . $this->get('user_id'), '');*/
		}
	}
	
	public function getSettings()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		Phpfox::getBlock('user.admincp.setting');
		
		$this->html('#js_module_title', $this->get('module_id'));
		$this->html('#js_setting_block', $this->getContent(false));
		$this->show('#content_editor_text');
		
		$this->addClass('.table_clear', 'table_hover_action');
		$this->call('$.scrollTo(0);');
		$this->call('$Core.loadInit();');
	}
	
	public function updateSettings()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		
		$aVals = $this->get('val');
		foreach ($this->get('param') as $iId => $sVar)
		{
			$aVals['param'][$iId] = $sVar;
		}
		
		if (Phpfox::getService('user.group.setting.process')->update($this->get('id'), $aVals))
		{
			$this->slideUp('#global_ajax_message');
		}
	}
	
	public function deleteGroupIcon()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		
		if (Phpfox::getService('user.group.setting.process')->deleteIcon($this->get('group_id')))
		{
			
		}		
	}
	
	public function processUploadedImage()
	{
		
	}
	
	public function userPending()
	{
		Phpfox::isAdmin(true);
		
		if (($aUser = Phpfox::getService('user.process')->userPending($this->get('user_id'), $this->get('type'))))
		{			
			$this->remove('.js_user_pending_' . $this->get('user_id'));
			if ($this->get('type') == '1')
			{
				$this->html('#js_user_pending_group_' . $this->get('user_id'), $aUser['user_group_title']);
				if ($this->get('return') == true)
				{ // early return
					return true;
				}
				$this->alert(Phpfox::getPhrase('user.user_successfully_approved'));
			}
			else 
			{
				$this->html('#js_user_pending_group_' . $this->get('user_id'), Phpfox::getPhrase('user.not_approved'));
				if ($this->get('return') == true)
				{ // early return
					return true;
				}
				$this->alert(Phpfox::getPhrase('user.user_successfully_denied'));
			}
			return true;
		}
		return false;
	}

	/**
	 * Shows the "pop up" when denying a user from the adminCP
	 */
	public function showDenyUser()
	{
		Phpfox::isAdmin(true);		
		$iUser = (int)$this->get('iUser');
		Phpfox::getBlock('user.admincp.denyUser', array('iUser' => $iUser));
	}
	
	public function denyUser()
	{
		$sMessage = $this->get('sMessage');
		$sSubject = $this->get('sSubject');
		$iUser = $this->get('iUser');
		$bReturn = (bool)$this->get('doReturn');
		
		$this->set(array('user_id' => $iUser, 'type' => 2));
		if (!empty($bReturn) && $bReturn == true)
		{
			$this->set('return', true);
		
			$this->userPending();
			return true;
		}

		
		// send the email
		Phpfox::getLib('mail')->to($iUser)
				->subject($sSubject)
				->message($sMessage)
				->send();
		
		if ($this->userPending())
		{
			$this->call('$("#sFeedbackDeny").html("'.Phpfox::getPhrase('user.user_successfully_denied').'").show();');
			$this->call('setTimeout("tb_remove();",2000);');
		}
	}
	
	public function tooltip()
	{				
		Phpfox::getBlock('user.tooltip');
		
		$this->html('#js_user_tool_tip_cache_' . $this->get('user_name'), $this->getContent(false));
		$this->call('$Core.loadUserToolTip(\'' . $this->get('user_name') . '\');');
		if (Phpfox::getParam('core.defer_loading_user_images'))
		{
			// http://www.phpfox.com/tracker/view/14632/
			$this->call('$Behavior.defer_images();');
			// $this->call('$Core.loadInit();');
		}
	}
	
	public function addInactiveJob()
	{
		$iId = Phpfox::getService('user.process')->addInactiveJob($this->get('iDays'), $this->get('iBatchSize'));
		if ($iId == false)
		{
			$sErr = implode('.', Phpfox_Error::get());
			$this->alert($sErr);
			return false;
		}
		$this->html('#progress', Phpfox::getPhrase('mail.processing_batch_number',array('number' => 1)));
		$this->call('startJob('.$iId.');');
		$this->call('processJob('.$iId.');');
	}
	
	public function processJob()
	{
		$aInfo = Phpfox::getService('user.process')->processInactiveJob($this->get('iJobId'));
		if (isset($aInfo['iPercentage']) && $aInfo['iPercentage'] < 100)
		{
			$this->call('setTimeout("processJob('.$this->get('iJobId').')",3000);');
		}
		else
		{
			$this->call('jobCompleted();');
		}
		
		$this->html('#progress', Phpfox::getPhrase('mail.batch_number_completed_percentage', array('page_number' => $aInfo['page_number'], 'percentage' => $aInfo['iPercentage'])));
	}

	public function getInactiveMembersCount()
	{		
		$iCount = Phpfox::getService('user')->getInactiveMembersCount($this->get('iDays'));
		$this->html('#progress', Phpfox::getPhrase('user.there_are_a_total_of_icount_inactive_members', array('iCount' => $iCount)));
	}	
	
	
	public function deleteSpamQuestion()
	{
		if (Phpfox::getService('user.process')->deleteSpamQuestion($this->get('iQuestionId')) )
		{
			$this->softNotice(Phpfox::getPhrase('user.question_deleted_succesfully'));
			$this->remove('#tr_new_question_' . $this->get('iQuestionId'));
		}
	}
	
	public function saveMyLatLng()
	{
		if ($this->get('lat') == '0' && $this->get('lng') == '0')
		{
			return;
		}
		Phpfox::getService('user.process')->saveMyLatLng(array('latitude' => $this->get('lat'), 'longitude' => $this->get('lng') ) );
	}
}

?>
