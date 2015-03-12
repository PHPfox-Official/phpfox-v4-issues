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
 * @version 		$Id: process.class.php 7286 2014-04-28 14:58:07Z Fern $
 */
class User_Service_Process extends Phpfox_Service 
{	
	private $_iStatusId = 0;
	
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('user');
	}
	
	public function saveData($aSaveData, $iUserId = null)
	{
		if ($iUserId === null)
		{
			if (!Phpfox::isUser())
			{
				return;
			}
	
			$iUserId = Phpfox::getUserId();
		}
	
		$sCacheId = $this->cache()->set(array('userdata', $iUserId));
	
		$this->cache()->skipClose(true);
		$aCachedInfo = (array) $this->cache()->get($sCacheId);
		$aKey = array_keys($aSaveData);
		if (isset($aCachedInfo[$aKey[0]]))
		{
			unset($aCachedInfo[$aKey[0]]);
		}
		
		$this->cache()->save($sCacheId, $aSaveData);
	}	
	
	public function saveUserCache($iUserId)
	{
		$aUser = $this->database()->select('*')
			->from(Phpfox::getT('user'))
			->where('user_id = ' . (int) $iUserId)
			->execute('getSlaveRow');
		
		if (isset($aUser['user_id']))
		{
			$sCacheId = $this->cache()->set(array('userjoin', $iUserId));
			$this->cache()->save($sCacheId, array(
					'user_name' => $aUser['user_name'],
					'full_name' => $aUser['full_name'],
					'user_image' => $aUser['user_image'],
					'server_id' => $aUser['server_id']
					)
				);
		}
	}
	
	public function updateFeedSort($sOrder)
	{
		$this->database()->update(Phpfox::getT('user'), array('feed_sort' => (int) $sOrder), 'user_id = ' . (int) Phpfox::getUserId());
		
		return true;
	}
	
	public function addPointsPurchase($iTotal, $iTotalUpgrade)
	{
		$iId = $this->database()->insert(Phpfox::getT('point_purchase'), array(
				'user_id' => Phpfox::getUserId(),
				'currency_id' => Phpfox::getService('core.currency')->getDefault(),
				'price' => $iTotal,
				'status' => '0',
				'time_stamp' => PHPFOX_TIME,
				'total_point' => $iTotalUpgrade
			)
		);
		
		return $iId;
	}
	
	public function purchaseWithPoints($sModule, $iItem, $iTotal, $sCurreny)
	{
		if (!Phpfox::isModule($sModule))
		{
			return Phpfox_Error::set('Not a valid module.');
		}
		
		$iTotalPoints = (int) $this->database()->select('activity_points')
				->from(Phpfox::getT('user_activity'))
				->where('user_id = ' . (int) Phpfox::getUserId())
				->execute('getSlaveField');
				
		$aSetting = Phpfox::getParam('user.points_conversion_rate');
		if (isset($aSetting[$sCurreny]))
		{
			$iConversion = $iTotal / $aSetting[$sCurreny];
			if ($iTotalPoints >= $iConversion)
			{
				$iNewPoints = ($iTotalPoints - $iConversion);				
				
				$bReturn = Phpfox::callback($sModule. '.paymentApiCallback', array(
						'gateway' => 'activitypoints',
						'status' => 'completed',
						'item_number' => $iItem,
						'total_paid' => $iTotal
					)
				);
				
				// http://www.phpfox.com/tracker/view/15424/
				Phpfox::getService('api.gateway')->callback('activitypoints');

				if ($bReturn === false)
				{
					return false;
				}
				
				$this->database()->update(Phpfox::getT('user_activity'), array('activity_points' => (int) $iNewPoints), 'user_id = ' . (int) Phpfox::getUserId());
				
				return true;
			}
		}
		
		return Phpfox_Error::set(Phpfox::getPhrase('user.not_enough_points', array('total' => (int) $iTotalPoints)));
	}
	
	public function removeLogo($iUserId = null)
	{
		if ($iUserId === null)
		{
			$iUserId = Phpfox::getUserId();
		}
		
		$this->database()->update(Phpfox::getT('user_field'), array('cover_photo' => '0', 'cover_photo_top' => null), 'user_id = ' . (int) $iUserId);
		// This function takes care of all checks and queries if needed.
		Phpfox::getService('profile.process')->clearProfileCache( (int)$iUserId );
		
		
		return true;		
	}
	
	// http://www.phpfox.com/tracker/view/15193/
	public function removeProfilePic($iId)
	{
		$oFile = Phpfox::getLib('file');
		
		$sUserImage = $this->database()->select('user_image')
			->from(Phpfox::getT('user'))
			->where('user_id = ' . (int) $iId)
			->execute('getSlaveField');
		
		if (!empty($sUserImage))
		{			
			if (file_exists(Phpfox::getParam('core.dir_user') . sprintf($sUserImage, '')))
			{
				$oFile->unlink(Phpfox::getParam('core.dir_user') . sprintf($sUserImage, ''));
				foreach(Phpfox::getParam('user.user_pic_sizes') as $iSize)
				{
					if (file_exists(Phpfox::getParam('core.dir_user') . sprintf($sUserImage, '_' . $iSize)))
					{
						$oFile->unlink(Phpfox::getParam('core.dir_user') . sprintf($sUserImage, '_' . $iSize));
					}
					
					if (file_exists(Phpfox::getParam('core.dir_user') . sprintf($sUserImage, '_' . $iSize . '_square')))
					{
						$oFile->unlink(Phpfox::getParam('core.dir_user') . sprintf($sUserImage, '_' . $iSize . '_square'));
					}					
				}
			}
		}
	}
	
	public function updateCoverPosition($sPosition, $iUserId = null)
	{
		if ($iUserId === null)
		{
			$iUserId = Phpfox::getUserId();
		}
		
		$this->database()->update(Phpfox::getT('user_field'), array('cover_photo_top' => $sPosition), 'user_id = ' . (int) $iUserId);
		// This function takes care of all checks and queries if needed.
		Phpfox::getService('profile.process')->clearProfileCache( (int)$iUserId );
		return true;		
	}
	
	public function updateCoverPhoto($iPhotoId, $iUserId = null)
	{
		if ($iUserId === null)
		{
			$iUserId = Phpfox::getUserId();
		}
		
		$this->database()->update(Phpfox::getT('user_field'), array('cover_photo' => $iPhotoId, 'cover_photo_top' => null), 'user_id = ' . (int) $iUserId);
		
		// This function takes care of all checks and queries if needed.
		Phpfox::getService('profile.process')->clearProfileCache( (int)$iUserId );
		
		return true;
	}

	public function add($aVals, $iUserGroupId = null)
	{
		if (!defined('PHPFOX_INSTALLER') && defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$iTotalMembersMax = (int) Phpfox::getParam('core.phpfox_grouply_members');
			$iCurrentTotalMembers = $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('user'))
				->where('view_id = 0')
				->execute('getSlaveField');
			
			if ($iTotalMembersMax > 0 && $iCurrentTotalMembers >= $iTotalMembersMax)
			{
				Phpfox_Error::set('We are unable to setup an account for you at this time. This site has currently reached its limit on users.');	
			}
		}
		
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.split_full_name'))
		{
			if (empty($aVals['first_name']) || empty($aVals['last_name']))
			{
				Phpfox_Error::set(Phpfox::getPhrase('user.please_fill_in_both_your_first_and_last_name'));
			}
		}
		
		if (!defined('PHPFOX_INSTALLER') && !Phpfox::getParam('user.allow_user_registration'))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('user.user_registration_has_been_disabled'));
		}
		$oParseInput = Phpfox::getLib('parse.input');
		$sSalt = $this->_getSalt();
		$aCustom = Phpfox::getLib('request')->getArray('custom');
		
		(($sPlugin = Phpfox_Plugin::get('user.service_process_add_1')) ? eval($sPlugin) : false);		
		
		$aCustomFields = Phpfox::getService('custom')->getForEdit(array('user_main', 'user_panel', 'profile_panel'), null, null, true);
		foreach ($aCustomFields as $aCustomField)
		{
			if ($aCustomField['on_signup'] && $aCustomField['is_required'] && empty($aCustom[$aCustomField['field_id']]))
			{
				Phpfox_Error::set(Phpfox::getPhrase('user.the_field_field_is_required', array('field' => Phpfox::getPhrase($aCustomField['phrase_var_name']))));
			}
		}
		
		/* Check if there should be a spam question answered */
		$aSpamQuestions = $this->database()->select('*')->from(Phpfox::getT('user_spam'))->execute('getSlaveRows');
		if (!defined('PHPFOX_INSTALLER') && !defined('PHPFOX_IS_FB_USER') && !empty($aSpamQuestions) && (isset($aVals['spam'])))
		{			
			$oParse = Phpfox::getLib('parse.input');
			// The visitor's current language is...
			$sLangId = Phpfox::getLib('locale')->getLangId();

			foreach ($aVals['spam'] as $iQuestionId => $sAnswer)
			{
				$aDbQuestion = $this->database()->select('us.*')
					->from(Phpfox::getT('user_spam'), 'us')
					->where('us.question_id = ' . (int) $iQuestionId)
					->execute('getSlaveRow');
					
				if (!isset($aDbQuestion['answers_phrases']) || empty($aDbQuestion['answers_phrases']))
				{
					Phpfox_Error::set(Phpfox::getPhrase('user.that_question_does_not_exist_all_hack_attempts_are_forbidden_and_logged'));
					break;
				}
				// now to compare the answers
				$aAnswers = json_decode($aDbQuestion['answers_phrases']);
				$bValidAnswer = false;
				
				foreach ($aAnswers as $sDbAnswer)
				{					
					if (preg_match('/phrase var=&#039;([a-z\._0-9]+)/', $sDbAnswer, $aMatch))
					{
						$sDbAnswer = Phpfox::getPhrase($aMatch[1], array(), false, null, $sLangId);
						$sDbAnswer = html_entity_decode($sDbAnswer, null, 'UTF-8');
					}
					if (strcmp($sAnswer, $sDbAnswer) == 0)
					{
						$bValidAnswer = true;
						break;
					}
				}
				
				if ($bValidAnswer == false)
				{
					Phpfox_Error::set(Phpfox::getPhrase('user.captcha_failed'));
					break;
				}

				// $this->database()->delete(Phpfox::getT('upload_track'), 'user_hash = "' . $sHash . '" OR time_stamp < ' . (PHPFOX_TIME - (60*15)));
			}
			
			
		}
		else if (!defined('PHPFOX_INSTALLER') && !defined('PHPFOX_IS_FB_USER') && !empty($aSpamQuestions) && !isset($aVals['spam']))
		{
			Phpfox_Error::set('You forgot to answer the CAPTCHA questions');
		}
		
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}

		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.split_full_name'))
		{
			$aVals['full_name'] = $aVals['first_name'] . ' ' . $aVals['last_name'];
		}
		
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.validate_full_name'))
		{
			if (!Phpfox::getLib('validator')->check($aVals['full_name'], array('html', 'url')))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('user.not_a_valid_name'));
			}
		}

		if (!defined('PHPFOX_INSTALLER') && $aVals['full_name'] == '&#173;')
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.not_a_valid_name'));
		}
		
		if (!defined('PHPFOX_INSTALLER') &&  Phpfox::getParam('core.city_in_registration') && isset($aVals['city_location']) && !Phpfox::getLib('validator')->check($aVals['city_location'], array('html', 'url')))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.not_a_valid_city'));
		}
				
		if (!defined('PHPFOX_INSTALLER') && !Phpfox::getService('ban')->check('display_name', $aVals['full_name']))
		{
			Phpfox_Error::set(Phpfox::getPhrase('user.this_display_name_is_not_allowed_to_be_used'));
		}			

		if (!defined('PHPFOX_INSTALLER') && Phpfox::isModule('subscribe') && Phpfox::getParam('subscribe.enable_subscription_packages') && Phpfox::getParam('subscribe.subscribe_is_required_on_sign_up') && empty($aVals['package_id']))
		{
			$aPackages = Phpfox::getService('subscribe')->getPackages(true);
			
			if (count($aPackages))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('user.select_a_membership_package'));
			}
		}

		if (!defined('PHPFOX_INSTALLER'))
		{
		    if (!defined('PHPFOX_SKIP_EMAIL_INSERT'))
		    {
				if (!Phpfox::getLib('mail')->checkEmail($aVals['email']))
			    {
					return Phpfox_Error::set(Phpfox::getPhrase('user.email_is_not_valid'));
			    }
		    }
		    
			if (Phpfox::getLib('parse.format')->isEmpty($aVals['full_name']))
			{
				Phpfox_Error::set(Phpfox::getPhrase('user.provide_a_name_that_is_not_representing_an_empty_name'));
			}		    
		}
		
		$bHasImage = false;
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.force_user_to_upload_on_sign_up'))
		{
			if (Phpfox::getParam('user.verify_email_at_signup'))
			{
				define('PHPFOX_FORCE_PHOTO_VERIFY_EMAIL', true);
			}
			if (!isset($_FILES['image']['name']) || empty($_FILES['image']['name']) )
			{
				Phpfox_Error::set(Phpfox::getPhrase('photo.please_upload_an_image_for_your_profile'));
			}
			else
			{
				$aImage = Phpfox::getLib('file')->load('image', array('jpg', 'gif', 'png'), (Phpfox::getUserParam('user.max_upload_size_profile_photo') === 0 ? null : (Phpfox::getUserParam('user.max_upload_size_profile_photo') / 1024)));

				if ($aImage !== false)
				{
					$bHasImage = true;
				}				
			}
		}

		$aInsert = array(
			'user_group_id' => ($iUserGroupId === null ? NORMAL_USER_ID : $iUserGroupId),
			'full_name' => $oParseInput->clean($aVals['full_name'], 255),
			'password' => Phpfox::getLib('hash')->setHash($aVals['password'], $sSalt),
			'password_salt' => $sSalt,
			'email' => $aVals['email'],
			'joined' => PHPFOX_TIME,
			'gender' => (defined('PHPFOX_INSTALLER') || (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('core.registration_enable_gender')) ? $aVals['gender'] : 0),
			'birthday' => (defined('PHPFOX_INSTALLER') || (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('core.registration_enable_dob')) ? Phpfox::getService('user')->buildAge($aVals['day'],$aVals['month'],$aVals['year']) : null),
			'birthday_search' => (defined('PHPFOX_INSTALLER') || (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('core.registration_enable_dob')) ? Phpfox::getLib('date')->mktime(0, 0, 0, $aVals['month'], $aVals['day'], $aVals['year']) : 0),
			'country_iso' => (defined('PHPFOX_INSTALLER') || (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('core.registration_enable_location')) ? $aVals['country_iso'] : null),
			'language_id' => ((!defined('PHPFOX_INSTALLER') && Phpfox::getLib('session')->get('language_id')) ? Phpfox::getLib('session')->get('language_id') : null),
			'time_zone' => (isset($aVals['time_zone']) && (defined('PHPFOX_INSTALLER') || (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('core.registration_enable_timezone'))) ? $aVals['time_zone'] : null),
			'last_ip_address' => Phpfox::getIp(),
			'last_activity' => PHPFOX_TIME
		);
		
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.invite_only_community') && !Phpfox::getService('invite')->isValidInvite($aVals['email']))
		{
			// the isValidInvite runs Phpfox_Error::set so we don't have to do it here
		}
		
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.verify_email_at_signup'))
		{
			$aInsert['status_id'] = 1;// 1 = need to verify email
		}
		
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.approve_users'))
		{
			$aInsert['view_id'] = '1';// 1 = need to approve the user
		}		

		if (!Phpfox::getParam('user.profile_use_id') && !Phpfox::getParam('user.disable_username_on_sign_up'))
		{
			$aVals['user_name'] = str_replace(' ', '_', $aVals['user_name']);
			$aInsert['user_name'] = $oParseInput->clean($aVals['user_name']);					
		}
		
		/*
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.maximum_length_for_full_name') > 0 && strlen($aInsert['full_name']) > Phpfox::getParam('user.maximum_length_for_full_name'))
		{
			$aChange = array('iMax' => Phpfox::getParam('user.maximum_length_for_full_name'));
			$sPhrase = Phpfox::getParam('user.display_or_full_name') == 'full_name' ? Phpfox::getPhrase('user.please_shorten_full_name', $aChange) : Phpfox::getPhrase('user.please_shorten_display_name', $aChange);
			Phpfox_Error::set($sPhrase);
		}
		*/
		
		(($sPlugin = Phpfox_Plugin::get('user.service_process_add_start')) ? eval($sPlugin) : false);

		if (!Phpfox_Error::isPassed())
		{
			return false;
		}
		$iId = $this->database()->insert($this->_sTable, $aInsert);
		$aInsert['user_id'] = $iId;
		$aExtras = array(
			'user_id' => $iId
		);

		(($sPlugin = Phpfox_Plugin::get('user.service_process_add_extra')) ? eval($sPlugin) : false);

		$this->database()->insert(Phpfox::getT('user_activity'), $aExtras);
		$this->database()->insert(Phpfox::getT('user_field'), $aExtras);
		$this->database()->insert(Phpfox::getT('user_space'), $aExtras);
		$this->database()->insert(Phpfox::getT('user_count'), $aExtras);

		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('core.city_in_registration') && isset($aVals['city_location']))
		{
			Phpfox::getService('user.field.process')->update($iId, 'city_location', Phpfox::getLib('parse.input')->clean($aVals['city_location'], 100));
		}
		if (Phpfox::getParam('user.profile_use_id') || Phpfox::getParam('user.disable_username_on_sign_up'))
		{
			$this->database()->update($this->_sTable, array('user_name' => 'profile-' . $iId), 'user_id = ' . $iId);
		}
		
		if ($bHasImage)
		{
			$this->uploadImage($iId, true, null, true);
		}		

		if ( Phpfox::isModule('invite') && (Phpfox::getCookie('invited_by_email') || Phpfox::getCookie('invited_by_user')))
		{
			Phpfox::getService('invite.process')->registerInvited($iId);
		}
		elseif (Phpfox::isModule('invite'))
		{
			Phpfox::getService('invite.process')->registerByEmail($aInsert);
		}

		(($sPlugin = Phpfox_Plugin::get('user.service_process_add_feed')) ? eval($sPlugin) : false);
		
		if (!defined('PHPFOX_INSTALLER') && !Phpfox::getParam('user.verify_email_at_signup') && !Phpfox::getParam('user.approve_users') && !isset($bDoNotAddFeed))
		{
			//(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->allowGuest()->add('user_joined', $iId, null, $iId) : null);
		}

		if (isset($aVals['country_child_id']))
		{
			Phpfox::getService('user.field.process')->update($iId, 'country_child_id', $aVals['country_child_id']);
		}
		
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.split_full_name'))
		{
			Phpfox::getService('user.field.process')->update($iId, 'first_name', (empty($aVals['first_name']) ? null :$aVals['first_name']));
			Phpfox::getService('user.field.process')->update($iId, 'last_name', (empty($aVals['last_name']) ? null :$aVals['last_name']));
		}		
		
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('core.registration_enable_dob'))
		{
			// Updating for the birthday range
			$this->database()->update(Phpfox::getT('user_field'), array('birthday_range' => '\''.Phpfox::getService('user')->buildAge($aVals['day'], $aVals['month']) .'\''), 'user_id = ' . $iId, false);
		}
		
		if (!defined('PHPFOX_INSTALLER'))
		{
			$iFriendId = (int) Phpfox::getParam('user.on_signup_new_friend');
			if ($iFriendId > 0 && Phpfox::isModule('friend'))
			{
				$iCheckFriend = $this->database()->select('COUNT(*)')
					->from(Phpfox::getT('friend'))
					->where('user_id = ' . (int) $iId . ' AND friend_user_id = ' . (int) $iFriendId)
					->execute('getSlaveField');
				
				if (!$iCheckFriend)
				{
					$this->database()->insert(Phpfox::getT('friend'), array(
							'list_id' => 0,
							'user_id' => $iId,
							'friend_user_id' => $iFriendId,
							'time_stamp' => PHPFOX_TIME
						)
					);
					
					$this->database()->insert(Phpfox::getT('friend'), array(
							'list_id' => 0,
							'user_id' => $iFriendId,
							'friend_user_id' => $iId,
							'time_stamp' => PHPFOX_TIME
						)
					);
	
					Phpfox::getService('friend.process')->updateFriendCount($iId, $iFriendId);
					Phpfox::getService('friend.process')->updateFriendCount($iFriendId, $iId);
				}
			}
			if ($sPlugin = Phpfox_Plugin::get('user.service_process_add_check_1'))
			{
				eval($sPlugin);
			}
			
			// Allow to send an email even if verify email is disabled
			if ( (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.verify_email_at_signup') == false && !isset($bDoNotSendWelcomeEmail)) || isset($bSendWelcomeEmailPlg))
			{
			    Phpfox::getLib('mail')
					->to($iId)
					->subject(array('core.welcome_email_subject', array('site' => Phpfox::getParam('core.site_title'))))
					->message(array('core.welcome_email_content'))
					->send();
			}
			
			switch (Phpfox::getParam('user.on_register_privacy_setting'))
			{
				case 'network':
					$iPrivacySetting = '1';
					break;
				case 'friends_only':
					$iPrivacySetting = '2';
					break;
				case 'no_one':
					$iPrivacySetting = '4';
					break;
				default:
					
					break;
			}
			
			if (isset($iPrivacySetting))
			{
				$this->database()->insert(Phpfox::getT('user_privacy'), array(
						'user_id' => $iId,
						'user_privacy' => 'profile.view_profile',
						'user_value' => $iPrivacySetting
					)
				);			
			}
		}
		
		(($sPlugin = Phpfox_Plugin::get('user.service_process_add_end')) ? eval($sPlugin) : false);
		
		if (!empty($aCustom))
		{
			if (!Phpfox::getService('custom.process')->updateFields($iId, $iId, $aCustom, true))
			{
				return false;
			}
		}		
		
		$this->database()->insert(Phpfox::getT('user_ip'), array(
				'user_id' => $iId,
				'type_id' => 'register',
				'ip_address' => Phpfox::getIp(),
				'time_stamp' => PHPFOX_TIME
			)
		);			
		
		if (!defined('PHPFOX_INSTALLER') && Phpfox::getParam('user.verify_email_at_signup') && !isset($bSkipVerifyEmail))
		{
			$aVals['user_id'] = $iId;
			$sHash = Phpfox::getService('user.verify')->getVerifyHash($aVals);
			$this->database()->insert(Phpfox::getT('user_verify'), array('user_id' => $iId, 'hash_code' => $sHash, 'time_stamp' => Phpfox::getTime(), 'email' => $aVals['email']));
			// send email
			$sLink = Phpfox::getLib('url')->makeUrl('user.verify', array('link' => $sHash));
			Phpfox::getLib('mail')
				->to($iId)
				->subject(array('user.please_verify_your_email_for_site_title', array('site_title' => Phpfox::getParam('core.site_title'))))
				->message(array('user.you_registered_an_account_on_site_title_before_being_able_to_use_your_account_you_need_to_verify_that_this_is_your_email_address_by_clicking_here_a_href_link_link_a', array(
							'site_title' => Phpfox::getParam('core.site_title'),
							'link' => $sLink
						)
					)
				)
				->send();
		}
		
		if (!defined('PHPFOX_INSTALLER') && Phpfox::isModule('subscribe') && Phpfox::getParam('subscribe.enable_subscription_packages') && !empty($aVals['package_id']))
		{
			$aPackage = Phpfox::getService('subscribe')->getPackage($aVals['package_id']);
			if (isset($aPackage['package_id']))
			{
				$iPurchaseId = Phpfox::getService('subscribe.purchase.process')->add(array(
						'package_id' => $aPackage['package_id'],
						'currency_id' => $aPackage['default_currency_id'],
						'price' => $aPackage['default_cost']
					), $iId
				);
				
				$iDefaultCost = (int) str_replace('.', '', $aPackage['default_cost']);
				
				if ($iPurchaseId)
				{
					if ($iDefaultCost > 0)
					{							
						define('PHPFOX_MUST_PAY_FIRST', $iPurchaseId);
						
						Phpfox::getService('user.field.process')->update($iId, 'subscribe_id', $iPurchaseId);
					
						return array(Phpfox::getLib('url')->makeUrl('subscribe.register', array('id' => $iPurchaseId)));
					}
					else 
					{						
						Phpfox::getService('subscribe.purchase.process')->update($iPurchaseId, $aPackage['package_id'], 'completed', $iId, $aPackage['user_group_id'], $aPackage['fail_user_group']);
					}
				}
				else 
				{
					return false;
				}				
			}
		}		

		return $iId;
	}

	public function update($iUserId, $aVals, $aSpecial = array(), $bIsAccount = false)
	{
		if (!defined('PHPFOX_IS_CUSTOM_FIELD_UPDATE') && Phpfox::getParam('user.split_full_name'))
		{
			if (empty($aVals['first_name']) || empty($aVals['last_name']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('user.please_fill_in_both_your_first_and_last_name'));
			}
			
			$aVals['full_name'] = $aVals['first_name'] . ' ' . $aVals['last_name'];
		}		
		
		if (!empty($aVals['city_location']))
		{
			if (!Phpfox::getLib('validator')->check($aVals['city_location'], array('html', 'url')))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('user.not_a_valid_city'));
			}
		}

		if (isset($aVals['full_name']) && Phpfox::getParam('user.validate_full_name'))
		{
			if (!Phpfox::getLib('validator')->check($aVals['full_name'], array('html', 'url')))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('user.not_a_valid_name'));
			}
			//d(Phpfox::getParam('user.maximum_length_for_full_name'));			d(strlen($aVals['full_name']));			d($aVals);die();
			if (Phpfox::getParam('user.maximum_length_for_full_name') > 0 && strlen($aVals['full_name']) > Phpfox::getParam('user.maximum_length_for_full_name'))
			{
				$aChange = array('iMax' => Phpfox::getParam('user.maximum_length_for_full_name'));
				$sPhrase = Phpfox::getParam('user.display_or_full_name') == 'full_name' ? Phpfox::getPhrase('user.please_shorten_full_name', $aChange) : Phpfox::getPhrase('user.please_shorten_display_name', $aChange);
				return Phpfox_Error::set($sPhrase);
			}
		}

		if (!defined('PHPFOX_INSTALLER') && isset($aVals['full_name']) && $aVals['full_name'] == '&#173;')
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.not_a_valid_name'));
		}
				
		if (!$bIsAccount && Phpfox::getUserParam('user.can_edit_dob') && (empty($aVals['day']) || empty($aVals['month']) || empty($aVals['year'])))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.please_enter_your_date_of_birth'));	
		}

		if (isset($aVals['relation']) && Phpfox::getUserParam('custom.can_have_relationship') 
			&& ($aVals['relation'] != $aVals['previous_relation_type'] || $aVals['relation_with'] != $aVals['previous_relation_with'])
			)
		{
			if (isset($_POST['null']) && empty($_POST['null']))
			{
				$aVals['relation_with'] = null;
			}
			/* has the user defined another user to share this relationship with? */			
			Phpfox::getService('custom.relation.process')->updateRelationship($aVals['relation'], isset($aVals['relation_with']) ? $aVals['relation_with'] : null);
			
		}
		$oParseInput = Phpfox::getLib('parse.input');
		$aInsert = array(			
			'dst_check' => (isset($aVals['dst_check']) ? '1' : '0'),
			'language_id' => $aVals['language_id']			
		);		
		
		if (!$bIsAccount)
		{
			if (isset($aVals['country_iso']))
			{
				$aInsert['country_iso'] = $aVals['country_iso'];
				// http://www.phpfox.com/tracker/view/15297/
				$aCountryChildren = Phpfox::getService('core.country')->getChildren($aVals['country_iso']);
				$bHasCountryChildren = !empty($aCountryChildren);
			}
			
			//$aInsert['birthday'] = (Phpfox::getUserParam('user.can_edit_dob') && isset($aVals['day']) && isset($aVals['month']) && isset($aVals['year']) ? Phpfox::getService('user')->buildAge($aVals['day'], $aVals['month'], $aVals['year']) : null);
			$aInsert['birthday_search'] = (Phpfox::getUserParam('user.can_edit_dob') && isset($aVals['day']) && isset($aVals['month']) && isset($aVals['year']) ? Phpfox::getLib('date')->mktime(0, 0, 0, $aVals['month'], $aVals['day'], $aVals['year']) : 0);
			// http://www.phpfox.com/tracker/view/14726/
			// if ($aInsert['birthday_search'] > 0)
			if (isset($aInsert['birthday_search']))
			{
				$aInsert['birthday'] = date('mdY', $aInsert['birthday_search']);
			}
			if (Phpfox::getUserParam('user.can_edit_gender_setting') && isset($aVals['gender']))
			{
				$aInsert['gender'] = (int) $aVals['gender'];
			}
		}
		
		if (isset($aVals['time_zone']))
		{
			$aInsert['time_zone'] = $aVals['time_zone'];
		}
		
		(($sPlugin = Phpfox_Plugin::get('user.service_process_update_start')) ? eval($sPlugin) : false);

		if (isset($aSpecial['changes_allowed']) && $aSpecial['changes_allowed'] > $aSpecial['total_user_change'] && Phpfox::getUserParam('user.can_change_own_user_name') && !Phpfox::getParam('user.profile_use_id') && isset($aVals['old_user_name']) && $aVals['user_name'] != $aVals['old_user_name'])
		{
			// http://www.phpfox.com/tracker/view/15155/
			$aVals['user_name'] = str_replace(' ', '-', $aVals['user_name']);
			$aVals['user_name'] = str_replace('_', '-', $aVals['user_name']);

			Phpfox::getService('user.validate')->user($aVals['user_name']);

			if (!Phpfox_Error::isPassed())
			{
				return false;
			}			

			$aInsert['user_name'] = $aVals['user_name'];
			
			$this->database()->updateCounter('user_field', 'total_user_change', 'user_id', $iUserId);
		}
		
		// updating the full name
		if (isset($aSpecial['full_name_changes_allowed']) && 
				($aSpecial['full_name_changes_allowed'] > $aSpecial['total_full_name_change'] ||
				$aSpecial['full_name_changes_allowed'] == 0) &&
				Phpfox::getUserParam('user.can_change_own_full_name') &&
				($aSpecial['current_full_name'] != $aVals['full_name'])
			)
		{
			if (Phpfox::getLib('parse.format')->isEmpty($aVals['full_name']))
			{
				Phpfox_Error::set(Phpfox::getPhrase('user.provide_a_name_that_is_not_representing_an_empty_name'));
			}
			
			if (!Phpfox::getService('ban')->check('display_name', $aVals['full_name']))
			{
				Phpfox_Error::set(Phpfox::getPhrase('user.this_display_name_is_not_allowed_to_be_used'));
			}			
			
			if (!Phpfox_Error::isPassed())
			{
				return false;
			}				
			
			$aInsert['full_name'] = $oParseInput->clean($aVals['full_name'], 255);
			if ($aSpecial['full_name_changes_allowed'] > 0)
			{
				$this->database()->updateCounter('user_field', 'total_full_name_change', 'user_id', $iUserId);
			}
		}
		
		$sFullName = Phpfox::getUserBy('full_name');
		$this->database()->update($this->_sTable, $aInsert, 'user_id = ' . (int) $iUserId);
		
		$aInsert['prev_full_name'] = $sFullName;
		Phpfox::masscallback('onUserUpdate', $aInsert);
		
		if ($sPlugin = Phpfox_Plugin::get('user.service_process_update_1'))
		{
			eval($sPlugin);
			if (isset($mPluginReturn))
			{
				return $mPluginReturn;
			}
		}
		
		if (!$bIsAccount)
		{
			if ($bHasCountryChildren && isset($aVals['country_child_id'])) // http://www.phpfox.com/tracker/view/15297/
			{
				Phpfox::getService('user.field.process')->update($iUserId, 'country_child_id', $aVals['country_child_id']);
			}
			else 
			{
				Phpfox::getService('user.field.process')->update($iUserId, 'country_child_id', 0);
			}

			if (isset($aVals['city_location']))
			{
				Phpfox::getService('user.field.process')->update($iUserId, 'city_location', (empty($aVals['city_location']) ? null : Phpfox::getLib('parse.input')->clean($aVals['city_location'], 100)));
			}

			if (isset($aVals['postal_code']))
			{
				Phpfox::getService('user.field.process')->update($iUserId, 'postal_code', (empty($aVals['postal_code']) ? null : Phpfox::getLib('parse.input')->clean($aVals['postal_code'], 20)));
			}

			if (isset($aVals['signature']))
			{
				Phpfox::getService('user.field.process')->update($iUserId, 'signature', (empty($aVals['signature']) ? null : Phpfox::getLib('parse.input')->prepare($aVals['signature'])));
				Phpfox::getService('user.field.process')->update($iUserId, 'signature_clean', (empty($aVals['signature']) ? null : Phpfox::getLib('parse.input')->clean($aVals['signature'])));
			}	
		}
		
		if (isset($aVals['default_currency']))
		{
			Phpfox::getService('user.field.process')->update($iUserId, 'default_currency', (empty($aVals['default_currency']) ? null :$aVals['default_currency']));
			$this->cache()->remove(array('currency', $iUserId));
		}		
		
		if (isset($aVals['use_timeline']))
		{
			Phpfox::getService('user.field.process')->update($iUserId, 'use_timeline', (empty($aVals['use_timeline']) ? 0 :$aVals['use_timeline']));
		}		
		
		if (isset($aVals['landing_page']))
		{
			Phpfox::getService('user.field.process')->update($iUserId, 'landing_page', (empty($aVals['landing_page']) ? 0 :$aVals['landing_page']));
		}	
		
		if (Phpfox::getParam('user.split_full_name'))
		{
			Phpfox::getService('user.field.process')->update($iUserId, 'first_name', (empty($aVals['first_name']) ? null :$aVals['first_name']));
			Phpfox::getService('user.field.process')->update($iUserId, 'last_name', (empty($aVals['last_name']) ? null :$aVals['last_name']));
		}		
		
		if (!$bIsAccount)
		{
			if (isset($aVals['day']) && isset($aVals['month']))
			{
				$this->database()->update(Phpfox::getT('user_field'), array('birthday_range' => '\''.Phpfox::getService('user')->buildAge($aVals['day'], $aVals['month']) .'\''), 'user_id = ' . $iUserId, false);
			}
		}
		
		if (isset($aVals['gateway_detail']) && is_array($aVals['gateway_detail']))
		{
			$aGateways = array();
			$this->database()->delete(Phpfox::getT('user_gateway'), 'user_id = ' . (int) $iUserId);
			foreach ($aVals['gateway_detail'] as $sGateway => $mValue)
			{
				$this->database()->insert(Phpfox::getT('user_gateway'), array(
						'user_id' => $iUserId,
						'gateway_id' => $sGateway,
						'gateway_detail' => serialize($mValue)
					)
				);
			}
		}
		
		$this->database()->insert(Phpfox::getT('user_ip'), array(
				'user_id' => $iUserId,
				'type_id' => 'update_account',
				'ip_address' => Phpfox::getIp(),
				'time_stamp' => PHPFOX_TIME
			)
		);		
		
		
		
		(($sPlugin = Phpfox_Plugin::get('user.service_process_update_end')) ? eval($sPlugin) : false);	
		
		return true;
	}

	public function updateSimple($iUserId, $aVals)
	{
		$aSql = array(
			'gender' => (isset($aVals['gender']) ? $aVals['gender'] : 0),
			'birthday' => (isset($aVals['day']) ? Phpfox::getService('user')->buildAge($aVals['day'], $aVals['month'], $aVals['year']) : 0),
			'birthday_search' => (isset($aVals['day']) ? Phpfox::getLib('date')->mktime(0, 0, 0, $aVals['month'], $aVals['day'], $aVals['year']) : 0),
			'country_iso' => $aVals['country_iso']
		);

		$this->database()->update($this->_sTable, $aSql, 'user_id = ' . (int) $iUserId);
		if (isset($aVals['day']))
		{
			$this->database()->update(Phpfox::getT('user_field'), array('birthday_range' => '\''.Phpfox::getService('user')->buildAge($aVals['day'], $aVals['month']) .'\''), 'user_id = ' . $iUserId, false);
		}
		
		(($sPlugin = Phpfox_Plugin::get('user.service_process_updatesimple')) ? eval($sPlugin) : false);
		
		return true;
	}

	public function updateUserGroup($iUserId, $iUserGroupId)
	{
		$this->database()->update($this->_sTable, array('user_group_id' => (int) $iUserGroupId), 'user_id = ' . (int) $iUserId);
		
		(($sPlugin = Phpfox_Plugin::get('user.service_process_updateusergroup')) ? eval($sPlugin) : false);
	}

	/**
	 *
	 * @param type $iId
	 * @param type $bForce
	 * @param string $sPath Path to the photo that we will copy/resize
	 * @return type 
	 */
	public function uploadImage($iId, $bForce = true, $sPath = null, $bNoCheck = false, $iPhotoId = 0)
	{		
		if ($iId != Phpfox::getUserId() && $sPath === null && $bNoCheck === false)
		{
			Phpfox::getUserParam('user.can_change_other_user_picture', true);
		}

		$oFile = Phpfox::getLib('file');
		$oImage = Phpfox::getLib('image');
		
		if ($bForce)
		{
			$sUserImage = Phpfox::getUserBy('user_image');
			if ($iId != Phpfox::getUserId())
			{
				$sUserImage = $this->database()->select('user_image')
					->from(Phpfox::getT('user'))
					->where('user_id = ' . (int) $iId)
					->execute('getSlaveField');
			}
			
			if (!empty($sUserImage))
			{			
				if (file_exists(Phpfox::getParam('core.dir_user') . sprintf($sUserImage, '')))
				{
					$oFile->unlink(Phpfox::getParam('core.dir_user') . sprintf($sUserImage, ''));
					foreach(Phpfox::getParam('user.user_pic_sizes') as $iSize)
					{
						if (file_exists(Phpfox::getParam('core.dir_user') . sprintf($sUserImage, '_' . $iSize)))
						{
							$oFile->unlink(Phpfox::getParam('core.dir_user') . sprintf($sUserImage, '_' . $iSize));
						}
						
						if (file_exists(Phpfox::getParam('core.dir_user') . sprintf($sUserImage, '_' . $iSize . '_square')))
						{
							$oFile->unlink(Phpfox::getParam('core.dir_user') . sprintf($sUserImage, '_' . $iSize . '_square'));
						}					
					}
				}
			}
		}
		
		(($sPlugin = Phpfox_Plugin::get('user.service_process_uploadimage')) ? eval($sPlugin) : false);
		
		if ($sPath === null)
		{
			$sFileName = $oFile->upload('image', Phpfox::getParam('core.dir_user'), $iId);
		}
		else
		{
			$sFileName = $iId . '%s.' . substr($sPath, -3);
			$sTo = Phpfox::getParam('core.dir_user') . sprintf($sFileName,'');
			
			if (file_exists($sTo))
			{
				$oFile->unlink($sTo);
			}			
			
			if (Phpfox::getParam('core.allow_cdn'))
			{
				$mReturn = Phpfox::getLib('request')->send($sPath, array(), 'GET');
				$hFile = @fopen($sTo, 'w');
				@fwrite($hFile, $mReturn);
				@fclose($hFile);
		 
				if(filesize($sTo) > 0)
				{
					$bReturn = Phpfox::getLib('cdn')->put($sTo);
				}
				else
				{
					$oFile->unlink($sTo);
					$oFile->copy($sPath, $sTo);
					$bReturn = Phpfox::getLib('cdn')->put($sTo);
				}
			}
			else if (!$oFile->copy($sPath, $sTo))
			{
				   
			}
		}
		
		if (true)
		{			
			if ($bForce)
			{
				$iServerId = Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID');
	
				foreach(Phpfox::getParam('user.user_pic_sizes') as $iSize)
				{
					if (Phpfox::getParam('core.keep_non_square_images'))
					{
						$oImage->createThumbnail(Phpfox::getParam('core.dir_user') . sprintf($sFileName, ''), Phpfox::getParam('core.dir_user') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);
					}
					$oImage->createThumbnail(Phpfox::getParam('core.dir_user') . sprintf($sFileName, ''), Phpfox::getParam('core.dir_user') . sprintf($sFileName, '_' . $iSize . '_square'), $iSize, $iSize, false);
				
					if (defined('PHPFOX_IS_HOSTED_SCRIPT') || (Phpfox::getParam('core.allow_cdn') && !Phpfox::getParam('core.keep_files_in_server')))
					{
						if(file_exists(Phpfox::getParam('core.dir_user') . sprintf($sFileName, '_' . $iSize)))
						{
							unlink(Phpfox::getParam('core.dir_user') . sprintf($sFileName, '_' . $iSize));
						}
						if(file_exists(Phpfox::getParam('core.dir_user') . sprintf($sFileName, '_' . $iSize . '_square')))
						{
							unlink(Phpfox::getParam('core.dir_user') . sprintf($sFileName, '_' . $iSize . '_square'));
						}
					}
				}				
			
				if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
				{
					unlink(Phpfox::getParam('core.dir_user') . sprintf($sFileName, ''));
				}
				
				$this->database()->update($this->_sTable, array('user_image' => $sFileName, 'server_id' => $iServerId), 'user_id = ' . (int) $iId);
				
				$aAlbum = array();
				if (!defined('PHPFOX_USER_PHOTO_IS_COPY') && Phpfox::isModule('photo'))
				{
					$aAlbum = Phpfox::getService('photo.album')->getForProfileView($iId, true);
				}
				
				if (!Phpfox::getUserBy('profile_page_id') && !defined('PHPFOX_PAGES_IS_IN_UPDATE') && $iId == Phpfox::getUserId())
				{
					(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('user_photo', $iId) : null);
					if(isset($aAlbum['photo_id']) && !empty($aAlbum['photo_id']))
					{
						$this->database()->delete(Phpfox::getT('feed'), 'type_id = \'user_photo\' AND user_id = ' . $iId);
						(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('user_photo', $aAlbum['photo_id']) : null);
					}
					else if($iPhotoId != 0)
					{
						$this->database()->delete(Phpfox::getT('feed'), 'type_id = \'user_photo\' AND user_id = ' . $iId);
						(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('user_photo', $iPhotoId) : null);
					}
					// http://www.phpfox.com/tracker/view/15374/
					if(isset($aAlbum['album_id']))
					{
						Phpfox::getService('photo.album.process')->updateCounter($aAlbum['album_id'], 'total_photo');
					}
				}
				
				$this->saveUserCache($iId);
				
				return array('user_image' => $sFileName, 'server_id' => $iServerId);
			}			
			
			/*if (!defined('PHPFOX_USER_PHOTO_IS_COPY') && Phpfox::isModule('photo'))
			{
				Phpfox::getService('photo.album')->getForProfileView($iId, true);
			}*/
			
			$this->saveUserCache($iId);

			return array('user_image' => $sFileName);
		}

		return false;
	}

	public function updateStatus($aVals)
	{		
		if (Phpfox::getLib('parse.format')->isEmpty($aVals['user_status']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.add_some_text_to_share'));
		}				
		
		if (!Phpfox::getService('ban')->checkAutomaticBan($aVals['user_status']))
		{
			return false;
		}
		
		$sStatus = $this->preParse()->prepare($aVals['user_status']);
		
		$aUpdates = $this->database()->select('content')
			->from(Phpfox::getT('user_status'))
			->where('user_id = ' . (int) Phpfox::getUserId())
			->limit(Phpfox::getParam('user.check_status_updates'))
			->order('time_stamp DESC')
			->execute('getSlaveRows');
			
		$iReplications = 0;
		foreach ($aUpdates as $aUpdate)
		{
			if ($aUpdate['content'] == $sStatus)
			{
				$iReplications++;
			}
		}
			
		if ($iReplications > 0)
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.you_have_already_added_this_recently_try_adding_something_else'));			
		}
		
		if (empty($aVals['privacy']))
		{
			$aVals['privacy'] = 0;
		}		
		
		if (empty($aVals['privacy_comment']))
		{
			$aVals['privacy_comment'] = 0;
		}
		
		$aInsert = array(
				'user_id' => (int) Phpfox::getUserId(),
				'privacy' => $aVals['privacy'],
				'privacy_comment' => $aVals['privacy_comment'],
				'content' => $sStatus,
				'time_stamp' => PHPFOX_TIME
			);
			
		if (isset($aVals['location']) && isset($aVals['location']['latlng']) && !empty($aVals['location']['latlng']))
		{
			$aMatch = explode(',',$aVals['location']['latlng']);
			$aMatch['latitude'] = floatval($aMatch[0]);
			$aMatch['longitude'] = floatval($aMatch[1]);
			$aInsert['location_latlng'] = json_encode(array('latitude' => $aMatch['latitude'], 'longitude' => $aMatch['longitude']));
		}
		
		if (isset($aInsert['location_latlng']) && !empty($aInsert['location_latlng']) && isset($aVals['location']) && isset($aVals['location']['name']) && !empty($aVals['location']['name']))
		{
			$aInsert['location_name'] = Phpfox::getLib('parse.input')->clean($aVals['location']['name']);
		}
		$iStatusId = $this->database()->insert(Phpfox::getT('user_status'), $aInsert);		
		$this->_iStatusId = $iStatusId;
		
		if (isset($aVals['privacy']) && $aVals['privacy'] == '4')
		{
			Phpfox::getService('privacy.process')->add('user_status', $iStatusId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));
		}		

		Phpfox::getService('user.process')->notifyTagged($sStatus, $iStatusId, 'status');

		if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support'))
		{
			Phpfox::getService('tag.process')->add('user_status', $iStatusId, Phpfox::getUserId(), $sStatus, true);
		}

		(($sPlugin = Phpfox_Plugin::get('user.service_process_add_updatestatus')) ? eval($sPlugin) : false);		
		
		$iReturnId = Phpfox::getService('feed.process')->add('user_status', $iStatusId, $aVals['privacy'], $aVals['privacy_comment'], 0, null, 0, (isset($aVals['parent_feed_id']) ? $aVals['parent_feed_id'] : 0), (isset($aVals['parent_module_id']) ? $aVals['parent_module_id'] : null));
		
		(($sPlugin = Phpfox_Plugin::get('user.service_process_add_updatestatus_end')) ? eval($sPlugin) : false);
		
		return $iReturnId;
	}
	
	public function getLastStatusId()
	{
		return $this->_iStatusId;	
	}

	/*
		Made it a new function because we may use this in more places
	*/
	public function getIdFromMentions($sContent)
	{
		$iCount = preg_match_all('/\[x=(\d+)\].+?\[\/x\]/i', $sContent, $aMatches);
		if ($iCount < 1)
		{
			return array();
		}
		/* Filter out non friends */
		$oFriend = Phpfox::getService('friend');
		$aOut = array();
		foreach ($aMatches[1] as $iKey => $iUserId)
		{
		    if ($oFriend->isFriend(Phpfox::getUserId(), $iUserId))
		    {
			$aOut[] = $iUserId;
		    }
		}
		
		return $aOut;
	}
	
	public function notifyTagged($sContent, $iItemId, $sType)
	{
		
		$aMatches = $this->getIdFromMentions($sContent);
		$aChecked = array();
		foreach ($aMatches as $iKey => $iUserId)
		{
			if (in_array($iUserId, $aChecked)) continue;
			$aChecked[] = $iUserId;
		}
		$aMatches = $aChecked;		
		
		if (empty($aMatches))
		{
			return;
		}
		$sUsers = implode(',', $aMatches);
		$aPerms = $this->database()->select('user_id, user_value')->from(Phpfox::getT('user_privacy'))->where('user_id in (' . $sUsers . ' ) AND user_privacy = \'user.can_i_be_tagged\'')->execute('getSlaveRows');
		$aUsers = array();
		foreach ($aPerms as $aRow)
		{
			foreach ($aMatches as $iIndex => $iUserId)
			{
				if ($iUserId == $aRow['user_id'] && $aRow['user_value'] == 4)
				{
					unset($aMatches[$iIndex]);
				}
			}
		}
		
		if ($sType == 'status')
		{
			foreach ($aMatches as $iIndex => $iUserId)
			{
				// Copy the status update as if it were a comment on that user's profile
				Phpfox::getService('feed.process')->addComment(array(
					'privacy_comment' => 0,
					'parent_user_id' => $iUserId,
					'user_id' => Phpfox::getUserId(),
					'user_status' => $sContent,
					'privacy' => 0,
					'time_stamp' => PHPFOX_TIME,
					'feed_reference' => $iItemId
				));
				if (Phpfox::isModule('notification'))
				{
					Phpfox::getService('notification.process')->add('feed_comment_profile', $iItemId, $iUserId);		
				}	
			}
		} 
		else 
		{
			/*
				Implemented for comments in:
					photo
					blog
					Comments in pages are funky, remove from there?
					Video - phrase
					Quiz
					Poll
					Song
					Music Album
					
			*/
			
			if (Phpfox::isModule('notification'))
			{
				$sName = 'comment_';
				if ($sType == 'photo_album' || (strpos($sType, 'music') !== false) || ($sType == 'user_status'))
				{
					$sName .= $sType.'tag';
				}
				else
				{
					$sName .= $sType.'_tag';
				}
				
				foreach ($aMatches as $iIndex => $iUserId)
				{
					
					Phpfox::getService('notification.process')->add($sName, $iItemId, $iUserId);		
				}
			}
		}
		
	}
	
	
	public function updateFooterBar($iUserId, $iTypeId)
	{
		$this->database()->update($this->_sTable, array('footer_bar' => ($iTypeId == 1 ? '1' : '0')), 'user_id = ' . Phpfox::getUserId());
	}

	public function updateDesign($aVals)
	{
		Phpfox::isUser(true);

		if (isset($aVals['order']))
		{
			$this->database()->delete(Phpfox::getT('user_dashboard'), 'user_id = ' . Phpfox::getUserId() . ' AND is_hidden = 0');
			foreach ($aVals['order'] as $sCacheId => $aOrder)
			{
				$aKey = array_keys($aOrder);
				$aValue = array_values($aOrder);
				$this->database()->insert(Phpfox::getT('user_dashboard'), array('user_id' => Phpfox::getUserId(), 'cache_id' => $sCacheId, 'block_id' => $aKey[0], 'ordering' => $aValue[0]));
			}
		}

		if (isset($aVals['cache_id']))
		{
			$this->hideBlock($aVals['cache_id'], ($aVals['is_installed'] ? 1 : 0));
		}

		if (isset($aVals['style_id']))
		{
			if (Phpfox::getService('theme.style.process')->setStyle($aVals['style_id']))
			{

			}
		}
	}

	public function hideBlock($sBlockId, $iHidden = 1)
	{
		$iHasEntry = $this->database()->select('COUNT(*)')
		->from(Phpfox::getT('user_dashboard'))
		->where('user_id = ' . Phpfox::getUserId() . ' AND cache_id = \'js_block_border_' . $this->database()->escape($sBlockId) . '\'')
		->execute('getSlaveField');

		if ($iHasEntry)
		{
			$this->database()->update(Phpfox::getT('user_dashboard'), array('is_hidden' => $iHidden), 'user_id = ' . Phpfox::getUserId() . ' AND cache_id = \'js_block_border_' . $this->database()->escape($sBlockId) . '\'');
		}
		else
		{
			$this->database()->insert(Phpfox::getT('user_dashboard'), array('user_id' => Phpfox::getUserId(), 'cache_id' => 'js_block_border_' . $sBlockId, 'block_id' => null, 'ordering' => 0, 'is_hidden' => $iHidden));
		}
	}

	public function updateAdvanced($iUserid, $aVals)
	{
		Phpfox::getUserParam('user.can_edit_users', true);
		
		$aActivity = array();
		if (isset($aVals['activity']))
		{
			$aActivity = (array) $aVals['activity'];
		}
		if (isset($aVals['signature']))
		{
			$sSignature = $aVals['signature'];
		}
		$aOrg = $aVals;
		$aForms = array(
			'full_name' => array(
				'message' => Phpfox::getPhrase('user.fill_in_a_display_name'),
				'type' => 'string:required'
			),
			'user_group_id' => array(
				'message' => Phpfox::getPhrase('user.select_a_user_group_for_this_user'),
				'type' => 'int:required'
			),
			'country_iso' => array(
				'message' => Phpfox::getPhrase('user.select_a_location'),
				'type' => 'string'
			),
			'gender' => array(
				'message' => Phpfox::getPhrase('user.select_a_gender'),
				'type' => 'int'
			),
			'birthday' => array(
				'message' => Phpfox::getPhrase('user.select_a_date_of_birth'),
				'type' => 'string'
			),
			'birthday_search' => array(
				'type' => 'int'
			),
			'time_zone' => 'string',
			'status' => 'string',
			'total_spam' => 'int',
			'language_id' => 'string'			
		);
		
		$aUserFieldsForms = array(
			'country_child_id' => array(
				'type' => 'int'
			),
			'city_location' => array(
				'type' => 'string'
			),
			'postal_code' => array(
				'type' => 'string'
			)
		);

		if (!empty($aVals['day']) && !empty($aVals['month']) && !empty($aVals['year']))
		{			
			$aVals['birthday'] = Phpfox::getService('user')->buildAge($aVals['day'],$aVals['month'],$aVals['year']);
			$aVals['birthday_search'] = Phpfox::getLib('date')->mktime(0, 0, 0, $aVals['month'], $aVals['day'], $aVals['year']);
		}

		if (isset($aVals['user_name_check']))
		{
			$aForms['user_name'] = array(
				'message' => Phpfox::getPhrase('user.username_is_required_and_can_only_contain_alphanumeric_characters_and_or_and_must_be_between_5_and_25_characters_long'),
				'type' => array('string:required', 'regex:user_name')
			);

			$aVals['user_name'] = str_replace(' ', '_', $aVals['user_name']);

			Phpfox::getService('user.validate')->user($aVals['user_name']);
		}

		if (isset($aVals['email_check']))
		{
			$aForms['email'] = array(
				'message' => Phpfox::getPhrase('user.provide_a_valid_email'),
				'type' => array('string:required', 'regex:email')
			);

			Phpfox::getService('user.validate')->email($aVals['email']);
			$bIsEmailPass = true;
		}

		if (isset($aVals['password_check']))
		{
			$sSalt = $this->_getSalt();
			$aVals['password'] = Phpfox::getLib('hash')->setHash($aVals['password'], $sSalt);
			$aVals['password_salt'] = $sSalt;
			$aForms['password'] = array(
				'type' => 'string'
			);
			$aForms['password_salt'] = array(
				'type' => 'string'
			);
		}
		
		if (defined('PHPFOX_IS_HOSTED_SCRIPT') && $aVals['user_group_id'] == ADMIN_USER_ID)
		{
			$iCurrentUserGroupId = $this->database()->select('user_group_id')
				->from(Phpfox::getT('user'))
				->where('user_id = ' . (int) $iUserid)
				->execute('getSlaveField');
			
			if ($aVals['user_group_id'] != $iCurrentUserGroupId)
			{
				$iTotalAdmins = $this->database()->select('COUNT(*)')
					->from(Phpfox::getT('user'))
					->where('user_group_id = ' . (int) ADMIN_USER_ID)
					->execute('getSlaveField');		

				if ($iTotalAdmins >= Phpfox::getParam('core.phpfox_grouply_admins'))
				{
					Phpfox_Error::set('You have currently reached your Admin limit. (' . $iTotalAdmins . ' out of ' . Phpfox::getParam('core.phpfox_grouply_admins') . ')');
				}
			}
		}
		
		(($sPlugin = Phpfox_Plugin::get('user.service_process_updateadvanced_start')) ? eval($sPlugin) : false);

		if(isset($aVals['city_location']) && !empty($aVals['city_location']))
		{
				$aVals['city_location'] = Phpfox::getLib('parse.input')->clean($aVals['city_location']);
		}

		$aUserFields = $this->validator()->process($aUserFieldsForms, $aVals);
		$aVals = $this->validator()->process($aForms, $aVals);		

		if (!Phpfox_Error::isPassed())
		{
			return false;
		}

		$aVals['full_name'] = Phpfox::getLib('parse.input')->clean($aVals['full_name'], 255);

		$this->database()->update($this->_sTable, $aVals, 'user_id = ' . (int) $iUserid);
		$this->database()->update(Phpfox::getT('user_field'), $aUserFields, 'user_id = ' . (int) $iUserid);
		
		if (!empty($aOrg['day']) && !empty($aOrg['month']))
		{
			$this->database()->update(Phpfox::getT('user_field'), array('birthday_range' => '\''.Phpfox::getService('user')->buildAge($aOrg['day'], $aOrg['month']) .'\''), 'user_id = ' . (int) $iUserid, false);
		}
				
		if (count($aActivity))
		{
			foreach ($aActivity as $sKey => $sValue)
			{
				$this->database()->update(Phpfox::getT('user_activity'), array($sKey => (int) $sValue), 'user_id = ' . (int) $iUserid);
			}
		}
		
		if (isset($bIsEmailPass))
		{
			$this->database()->update(Phpfox::getT('user_verify'), array('email' => $aVals['email']), 'user_id = ' . (int) $iUserid);
		}
		
		if (isset($sSignature))
		{
			$this->database()->update(Phpfox::getT('user_field'), array
				(
					'signature' => Phpfox::getLib('parse.input')->clean($sSignature)
				),
				'user_id = ' . (int)$iUserid);
		}
		(($sPlugin = Phpfox_Plugin::get('user.service_process_updateadvanced_end')) ? eval($sPlugin) : false);
		
		return true;
	}
	
	public function cropPhoto($aVals)
	{
		if (isset($aVals['skip_croping']))
		{
			return true;
		}

		// http://www.phpfox.com/tracker/view/14516/
		$sFile = Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '');
		if(!file_exists($sFile))
		{
			if (Phpfox::getParam('core.allow_cdn'))
			{
				$sMainFile = $sFile;
				$sActualFile = Phpfox::getLib('image.helper')->display(array(
						'server_id' => Phpfox::getUserBy('server_id'),
						'path' => 'core.url_user',
						'file' => Phpfox::getUserBy('user_image'),
						'suffix' => (!isset($iSize) ? '' : '_') . $iSize,
						'return_url' => true
					)
				);
				
				copy($sActualFile, $sFile);
			}
		}
		
		Phpfox::getLib('image')->createThumbnail(Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), ''), Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '') . '_temp', $aVals['image_width'], $aVals['image_height'], false);
		
		if (empty($aVals['w']))
		{			
			return Phpfox_Error::set(Phpfox::getPhrase('photo.select_an_area_on_your_photo_to_crop'));
		}
		
		Phpfox::getLib('image')->cropImage(
			Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '') . '_temp',
			Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '_50_square'),			
			$aVals['w'],
			$aVals['h'],
			$aVals['x1'],
			$aVals['y1'],
			75
		);
		
		Phpfox::getLib('image')->cropImage(
			Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '') . '_temp',
			Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '') . '_temp',			
			$aVals['w'],
			$aVals['h'],
			$aVals['x1'],
			$aVals['y1'],
			// 75
			// $aVals['x1']
			// http://www.phpfox.com/tracker/view/14516/ 
			$aVals['w']
		);
		
		foreach(Phpfox::getParam('user.user_pic_sizes') as $iSize)
		{
			if ($iSize >= 75)
			{
				// continue;
			}
			
			if (Phpfox::getParam('core.keep_non_square_images'))
			{
				Phpfox::getLib('image')->createThumbnail(
					Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '') . '_temp',
					//Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '_'. $iSize.'_square'), 
					Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '_' . $iSize), 
					$iSize, 
					$iSize
				);
			}
			Phpfox::getLib('image')->createThumbnail(
				Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '') . '_temp',
				//Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '_'. $iSize.'_square'), 
				Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '_' . $iSize . '_square'), 
				$iSize, 
				$iSize, 
				false
			);
			
			if (defined('PHPFOX_IS_HOSTED_SCRIPT'))
			{
				unlink(Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '_' . $iSize));	
				unlink(Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '_' . $iSize . '_square'));
			}
		}
		
		unlink(Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '') . '_temp');
		
		// http://www.phpfox.com/tracker/view/14516/
		if(Phpfox::isModule('photo') && Phpfox::getParam('photo.delete_original_after_resize'))
		{
			if(file_exists(Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '') . '_temp'))
			{
				unlink(Phpfox::getParam('core.dir_user') . sprintf(Phpfox::getUserBy('user_image'), '') . '_temp');
			}
			
			if (Phpfox::getParam('core.allow_cdn'))
			{
				 Phpfox::getLib('cdn')->remove(sprintf(sprintf(Phpfox::getUserBy('user_image'), '')));
			}
		}
		
		return true;
	}

	public function updatePassword($aVals)
	{
		Phpfox::isUser(true);
		
		if (empty($aVals['old_password']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.missing_old_password'));
		}
		
		if (empty($aVals['new_password']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.missing_new_password'));
		}
		
		if (empty($aVals['confirm_password']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.confirm_your_new_password'));
		}		
		
		if ($aVals['confirm_password'] != $aVals['new_password'])
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.your_confirmed_password_does_not_match_your_new_password'));
		}
		
		$aUser = Phpfox::getService('user')->getUser(Phpfox::getUserId());
		
		if (Phpfox::getLib('hash')->setHash($aVals['old_password'], $aUser['password_salt']) != $aUser['password'])
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.your_current_password_does_not_match_your_old_password'));	
		}
		
		$sSalt = $this->_getSalt();
		$aInsert = array();
		$aInsert['password'] = Phpfox::getLib('hash')->setHash($aVals['new_password'], $sSalt);
		$aInsert['password_salt'] = $sSalt;
		
		$this->database()->update($this->_sTable, $aInsert, 'user_id = ' . Phpfox::getUserId());
		
		list($bLogged, $aUser) = Phpfox::getService('user.auth')->login($aUser['email'], $aVals['new_password'], false, 'email');
		
		$this->database()->insert(Phpfox::getT('user_ip'), array(
				'user_id' => Phpfox::getUserId(),
				'type_id' => 'update_password',
				'ip_address' => Phpfox::getIp(),
				'time_stamp' => PHPFOX_TIME
			)
		);			
		
		(($sPlugin = Phpfox_Plugin::get('user.service_process_updatepassword')) ? eval($sPlugin) : false);
		
		return ($bLogged ? true : false);
	}

	/**
	 * Adds or removes a ban on a user.
	 * @param int $iUserId
	 * @param int $iType 1|0 => 1 to place the ban, 0 to remove it @deprecated
	 * @return <type>
	 */
	public function ban($iUserId, $iType)
	{
		Phpfox::isUser(true);
		
		if (!defined('PHPFOX_SKIP_BAN_ADMIN_CHECK'))
		{
			Phpfox::getUserParam('admincp.has_admin_access', true);
		}
		
		if (Phpfox::getService('user')->isAdminUser($iUserId))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.you_are_unable_to_ban_a_site_administrator'));	
		}

		// Adding a check so we can't ban ourselves.
		if ($iUserId == Phpfox::getUserId() && !defined('PHPFOX_SKIP_BAN_ADMIN_CHECK'))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.you_should_not_ban_yourself'));
		}
		
		$aBanned = Phpfox::getService('ban')->isUserBanned(array('user_id' => $iUserId));
		
		if (isset($aBanned['ban_data_id']))
		{
			if ($aBanned['is_banned'] == true)
			{
				// Removing a user from a ban user group, lets make sure there are no active bans in the ban_data			
				if (isset($aBanned['return_user_group']) && ((int)$aBanned['return_user_group'] > 0))
				{
					$this->database()->update($this->_sTable, array('user_group_id' => $aBanned['return_user_group']), 'user_id = ' . (int) $iUserId);
				}
				else
				{
					$this->database()->update($this->_sTable, array('user_group_id' => NORMAL_USER_ID), 'user_id = ' . (int) $iUserId);
				}

				// make sure all bans are expired
				$this->database()->update(Phpfox::getT('ban_data'),array(
					'is_expired' => '1'),
					'user_id = ' . (int)$iUserId . ''
				);
			}
			else
			{
				// add a ban by updating the user group
				$this->database()->update($this->_sTable, array('user_group_id' =>  Phpfox::getParam('core.banned_user_group_id')), 'user_id = ' . (int) $iUserId);
			}
		}
		else
		{
			if ($iType)
			{
				$this->database()->update($this->_sTable, array('user_group_id' =>  Phpfox::getParam('core.banned_user_group_id')), 'user_id = ' . (int) $iUserId);
			}
			else
			{
				$this->database()->update($this->_sTable, array('user_group_id' => NORMAL_USER_ID), 'user_id = ' . (int) $iUserId);
			}
		}
		
		(($sPlugin = Phpfox_Plugin::get('user.service_process_banuser')) ? eval($sPlugin) : false);
		
		return true;	
	}
	
	public function clearStatus($iUserId)
	{
		$this->database()->update(Phpfox::getT('user'), array('status' => null), 'user_id = ' . (int) $iUserId);
	}
	
	public function userPending($iUserId, $iType)
	{
		$aUser = $this->database()->select('ug.title AS user_group_title, u.user_id')
			->from(Phpfox::getT('user'), 'u')
			->join(Phpfox::getT('user_group'), 'ug', 'ug.user_group_id = u.user_group_id')
			->where('u.user_id = ' . (int) $iUserId)
			->execute('getSlaveRow');
			
		if (!isset($aUser['user_id']))
		{
			return false;
		}
		
		if ($iType == '1')
		{
			Phpfox::getLib('mail')->to($aUser['user_id'])
				->subject(array('user.account_approved'))
				->message(array('user.your_account_has_been_approved_on_site_title', array(
							'site_title' => Phpfox::getParam('core.site_title'),
							'link' => Phpfox::getLib('url')->makeUrl('')
						)
					)
				)
				->send();		
				
			$this->database()->update(Phpfox::getT('user'), array(
					'view_id' => '0'
				), 'user_id = ' . $aUser['user_id']
			);	
			
			Phpfox::getService('user.verify.process')->adminVerify($aUser['user_id']);
		}
		else 
		{
			$this->database()->update(Phpfox::getT('user'), array(
					'view_id' => '2'
				), 'user_id = ' . $aUser['user_id']
			);			
		}
			
		return $aUser;
	}
	
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('user.service_process__call'))
		{
			return eval($sPlugin);
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}

	private function _getSalt($iTotal = 3)
	{
		$sSalt = '';
		for ($i = 0; $i < $iTotal; $i++)
		{
			$sSalt .= chr(rand(33, 91));
		}

		return $sSalt;
	}

	/**
	 * This function creates a Remind Inactive Users job
	 * @param integer $iDays How many days in the past to search for users
	 * @param integer $iBatchSize How many users to mail per round
	 * @param boolean $bDeletePrevious Delete or not a previous job
	 * @return mixed integer if the job was created, false otherwise
	 */
	public function addInactiveJob($iDays, $iBatchSize)
	{		
		$iDays = (int)$iDays;
		$iBatchSize = (int)$iBatchSize;

		$iCnt = $this->database()->select('COUNT(user_id)')
			->from(Phpfox::getT('user'))
			->where('profile_page_id = 0 AND last_login < ' .(PHPFOX_TIME - ($iDays * 86400)))
			->execute('getSlaveField');

		$iJobId = $this->database()->insert(Phpfox::getT('user_inactive'), array(
			'days_inactive' => $iDays,
			'batch_size' => $iBatchSize,
			'page_number' => 0,
			'date_started' => 0,
			'total_users' => $iCnt,
			'user_id' => Phpfox::getUserId()
		));
		return $iJobId;
	}

	public function processInactiveJob($iId)
	{
		$aJob = $this->database()->select('*')
				->from(Phpfox::getT('user_inactive'))
				->where('job_id = ' . (int)$iId)
				->execute('getSlaveRow');

		// ajob should have (batch_size * page_number <= total_users) at all times
		// sanity check
		if ( ($aJob['page_number'] * $aJob['batch_size']) >= $aJob['total_users'])
		{
			return array('iPercentage' => 100, 'page_number' => $aJob['page_number']);
		}

		if (!isset($aJob['page_number']) || !isset($aJob['batch_size']))
		{
			return Phpfox_Error::set('invalid job id');
		}
		if ($aJob['batch_size'] > 0)
		{
			$this->database()->limit($aJob['page_number']*$aJob['batch_size'] .','. $aJob['batch_size']);
		}
		// get the next batch of users
		$aUsers = $this->database()->select('user_id, email, language_id, full_name, user_name, user_group_id')
			->from(Phpfox::getT('user'))
			->where('profile_page_id = 0 AND last_login <= ' . (PHPFOX_TIME - ($aJob['days_inactive'] * 86400)))
			->order('user_id ASC')
			->execute('getSlaveRows');
		
		$oMail = Phpfox::getLib('mail');
		foreach ($aUsers as $aUser)
		{
			$oMail->aUser($aUser);
		}
		$bSent = $oMail->subject(array('user.inactive_member_email_subject'))
						->message(array('user.inactive_member_email_body'))
						->send();
		if ($bSent)
		{
			$this->database()->update(Phpfox::getT('user_inactive'), array(
				'page_number' => $aJob['page_number']+1
				),'job_id = ' . $aJob['job_id']);
			if ($aJob['batch_size'] > 0)
			{
				$aJob['iPercentage'] = (int)(((($aJob['page_number'] + 1) * $aJob['batch_size']) / $aJob['total_users'])*100);
				if ($aJob['iPercentage'] > 100)
				{
					$aJob['iPercentage'] = 100;
				}
			}
			else
			{
				$aJob['iPercentage'] = 100;
			}
			$aJob['page_number']++;
			return $aJob;
		}
		return false;
	}

	public function addSpamQuestion($aVals, $bReturnId = false)
	{
		$oParse = Phpfox::getLib('parse.input');
		$oFile = Phpfox::getLib('file');
		// Check that there is at least one answer
		if (!isset($aVals['answer']) || count($aVals['answer']) < 1)
		{
			return Phpfox_Error::set('No answers received');
		}
		
		foreach ($aVals['answer'] as $iKey => $sAnswer)
		{
			$aVals['answer'][$iKey] = $oParse->clean($sAnswer);
		}
		
		$aInsert = array(
			'question_phrase' => $oParse->clean($aVals['question']),
			'answers_phrases' => json_encode($aVals['answer']),
			'time_stamp' => PHPFOX_TIME,
			//'case_sensitive' => (int)$aVals['case'],
			'image_path' => (isset($aVals['image_path']) && !empty($aVals['image_path'])) ? $oParse->clean($aVals['image_path']) : ''
		);
		
		if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))
		{
			if (!$oFile->load('file', array('jpg', 'gif', 'png')))
			{
				return Phpfox_Error::set('Could not load file');
			}
			$aInsert['image_path'] = $oFile->upload('file', Phpfox::getParam('user.dir_user_spam'), '');
			if ($aInsert['image_path'] == false)
			{
				return Phpfox_Error::set('Could not upload files');
			}
			$aInsert['image_path'] = sprintf($aInsert['image_path'], '');
		}
		
		$iQuestionId = $this->database()->insert(Phpfox::getT('user_spam'), $aInsert);
		if ($bReturnId)
		{
			return $iQuestionId;
		}
		
		return true;
	}
	
	public function editSpamQuestion($aVals)
	{
		if (!isset($aVals['question_id']) || !is_numeric($aVals['question_id']))
		{
			return Phpfox_Error::set('Invalid question id when editing.');
		}
		
		if (isset($aVals['preserve_image']) && !empty($aVals['preserve_image']))
		{
			$aVals['image_path'] = $this->database()->select('image_path')
				->from(Phpfox::getT('user_spam'))
				->where('question_id = ' . (int)$aVals['question_id'])
				->execute('getSlaveField');				
		}
		// add the new question
		$iNewId = $this->addSpamQuestion($aVals, true);
		
		if ($this->deleteSpamQuestion($aVals['question_id'], (isset($aVals['preserve_image']) && !empty($aVals['preserve_image']))))
		{
			// Reset the question_id
			$this->database()->update(Phpfox::getT('user_spam'), array('question_id' => (int)$aVals['question_id']), 'question_id = ' . $iNewId);
		}
		
		return true;
		
	}
	
	public function deleteSpamQuestion($iQuestionId, $bPreserveImage = false)
	{
		// Check if the previous question had an image		
		$sImagePath = $this->database()->select('image_path')->from(Phpfox::getT('user_spam'))->where('question_id = ' . (int)$iQuestionId)->execute('getSlaveField');
		$sFilePath = Phpfox::getParam('user.dir_user_spam') . sprintf($sImagePath, '');
		if ($bPreserveImage != true && !empty($sImagePath) && file_exists($sFilePath))
		{
			Phpfox::getLib('file')->unlink( $sFilePath );
		}
		
		// Delete the previous question from the database
		$this->database()->delete(Phpfox::getT('user_spam'), 'question_id = ' . (int)$iQuestionId);
		
		return true;
	}
	/* Stores a latitude and a longitude for the given user */
	public function saveMyLatLng($aLocation)
	{
		$fLat = floatval($aLocation['latitude']);
		$fLng = floatval($aLocation['longitude']);
		
		if ($fLat == 0 && $fLng == 0)
		{
			return false;
		}
		$aUpdate = array(
			'latitude' => $fLat,
			'longitude' => $fLng
		);
		$this->database()->update(Phpfox::getT('user_field'),array('location_latlng' => json_encode($aUpdate)), 'user_id = ' . Phpfox::getUserId());
		return true;
	}
}

?>
