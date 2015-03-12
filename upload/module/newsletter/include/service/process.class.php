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
 * @package 		Phpfox_Service
 * @version 		$Id: process.class.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
class Newsletter_Service_Process extends Phpfox_Service
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('newsletter');
	}

	/**
	 * Adds a new job to send the newsletter, first there is no cron jobs/tabs so this function's return
	 * directs the flow of the script (refresh) to process the batches.
	 * Sets the errors using Phpfox_Error::set
	 * @param <type> $aVals
	 * @return Int Next round to process | false on error.
	 */
	public function add($aVals, $iUser)
	{
		// Check validations using the new method
		
		$aForm = array(
			'subject' => array(
				'message' => Phpfox::getPhrase('newsletter.add_a_subject'),
				'type' => 'string:required'
			),
			'total' => array(
				'message' => Phpfox::getPhrase('newsletter.how_many_users_to_contact_per_round'),
				'type' => 'int:required'
			),
			/*'type_id' => array(
				'message' => Phpfox::getPhrase('newsletter.please_choose_a_type_of_newsletter'),
				'type' => 'int:required'
			),*/
			'text' => array(
				'message' => Phpfox::getPhrase('newsletter.you_need_to_write_a_message_to_send'),
				'type' => 'string:required'
			)
		);
		$aVals['type_id'] = 2; // Internal newsletters are deprecated since 3.3.0 beta 1
		$this->validator()->process($aForm, $aVals);
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}
		// Phpfox::getService('ban')->checkAutomaticBan($aVals['subject'] . ' ' . $aVals['text'] . ' ' . $aVals['txtPlain']);

		$iActive = $this->database()->select('COUNT(newsletter_id)')
			->from($this->_sTable)
			->where('state = 1')
			->execute('getSlaveField');

		// insert the values in the database
		$aInsert = array(
			'subject' => $this->preParse()->clean($aVals['subject']),
			'round' => 0,
			'state' => $iActive > 0 ? 0 : 1, // 0 = not started; 1 = in progress; 2 = completed **
			'age_from' => (int)$aVals['age_from'],
			'age_to' => (int)$aVals['age_to'],
			'type_id' => (int)$aVals['type_id'], // 1 = Internal ; 2 = External
			'country_iso' => $this->preParse()->clean($aVals['country_iso']),
			'gender' => (int)$aVals['gender'],
			'user_group_id' => '',
			'total' => (int)$aVals['total'],
			'user_id' => (int)$iUser,
			'time_stamp' => Phpfox::getTime(),
			'archive' => (isset($aVals['archive'])) ? (int)$aVals['archive'] : 2, // 2 = delete, 1 = keep
			'privacy' => (isset($aVals['privacy'])) ? (int)$aVals['privacy'] : 2
		);
		
		if (isset($aVals['is_user_group']) && $aVals['is_user_group'] == 2)
		{
			$aGroups = array();
			$aUserGroups = Phpfox::getService('user.group')->get();
			if (isset($aVals['user_group']))
			{
				foreach ($aUserGroups as $aUserGroup)
				{
					if (in_array($aUserGroup['user_group_id'], $aVals['user_group']))
					{
						$aGroups[] = $aUserGroup['user_group_id'];
					}
				}
			}
			$aInsert['user_group_id'] = (count($aGroups) ? serialize($aGroups) : null);
		}

		// ** when we implement the cron job this is the place to set the state differently
		$iId = $this->database()->insert($this->_sTable, $aInsert);
		$this->database()->insert(Phpfox::getT('newsletter_text'), array(
			'newsletter_id' => $iId,
			'text_plain' => $this->preParse()->clean($aVals['txtPlain']),
			'text_html' => $aVals['text'])
		);
		// store that we are processing a job
		$aInsert['newsletter_id'] = $iId;
		$aInsert['round'] = 0;
		return $aInsert;
	}

	/**
	 * Sends newsletters according to the round set in `newsletter`.`round`
	 * Updates `newsletter`.`state` if needed.
	 * user_field.newsletter_state =
	 *		0 = no newsletter
	 *		1 = received newsletter
	 *
	 * Steps:
	 *		1. get the newsletter info
	 *		2. get users to send with filtering by total
	 *		3. send the message/email
	 *		4. update the users so they dont receive it again
	 *		5. update the round of the job.
	 *		6. return the job id and the percentage completed
	 * @param int | null $iId if null it fetches the first newsletter in progress and processes it.
	 */
	public function processJob($iId = null)
	{
		// Step 1. Need to check the newsletter state is in progress
		if ($iId === null)
		{
			$this->database()->where('n.newsletter_state = 1') // in progress
			->limit(1);
		}
		else
		{
			$this->database()->where('n.newsletter_id = ' . (int)$iId);
		}
		$aNewsletterInfo = $this->database()->select('*')
			->join(Phpfox::getT('newsletter_text'), 'nt', 'nt.newsletter_id = n.newsletter_id')
			->from($this->_sTable, 'n')
			->execute('getSlaveRow');
		if (!isset($aNewsletterInfo['text_plain']))
		{
			$aNewsletterInfo['text_plain'] = null;
		}
		// check if we have completed this job

		if (empty($aNewsletterInfo) || (isset($aNewsletterInfo['state']) && $aNewsletterInfo['state'] == 2))
		{
			$this->database()->update(Phpfox::getT('user_field'), array('newsletter_state' => 0), 'newsletter_state != 0');
			
			return array(true, 100);
		}		

		// Step 2: Get the pending members [the round field is unnecessary now]
		$sSelect = Phpfox::getUserField() . ', un.user_id as notification, u.email, u.language_id';
		$sWhere = 'uf.newsletter_state = 0'; // 0 = no newsletter ever sent, 1 last newsletter sent
		// filter the audience
		if (isset($aNewsletterInfo['age_from']) && $aNewsletterInfo['age_from'] > 0)
		{
			$iFromDate = PHPFOX_TIME  - (31556926 * $aNewsletterInfo['age_from']);
			$sWhere .= ' AND u.birthday_search < ' . $iFromDate;
		}
		if (isset($aNewsletterInfo['age_to']) && $aNewsletterInfo['age_to'] > 0)
		{
			$iToDate = PHPFOX_TIME - (31556926 * $aNewsletterInfo['age_to']);
			$sWhere .= ' AND u.birthday_search > ' . $iToDate;
		}
		if (isset($aNewsletterInfo['country_iso']) && $aNewsletterInfo['country_iso'] != '')
		{
			$sWhere .= ' AND country_iso = \'' . $aNewsletterInfo['country_iso'] . '\''; // no extra checks here since it comes directly from DB
		}
		if (isset($aNewsletterInfo['gender']) && $aNewsletterInfo['gender'] > 0)
		{
			$sWhere .= ' AND gender = ' . (int)$aNewsletterInfo['gender'];
		}
		if (!empty($aNewsletterInfo['user_group_id']))
		{
			$aUserGroups = unserialize($aNewsletterInfo['user_group_id']);
			
			$sWhere .= ' AND u.user_group_id IN(' . implode(',', $aUserGroups) . ')';
		}
		
		// Should fix http://www.phpfox.com/tracker/view/8949/
		if ($aNewsletterInfo['type_id'] == 2)
		{
			$sWhere .= ' AND u.email != ""';
		}
		$aUsers = $this->database()->select($sSelect)
			->from(Phpfox::getT('user'), 'u')
			->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = u.user_id')
			->limit((int)$aNewsletterInfo['total'])
			->leftjoin(Phpfox::getT('user_notification'), 'un', 'un.user_id = u.user_id')
			->group('u.user_id')
			->where($sWhere)
			->execute('getSlaveRows');			
			
		if (count($aUsers) == 0)
		{
			if ($aNewsletterInfo['archive'] != 1)
			{
				$this->database()->delete($this->_sTable, 'newsletter_id = ' . $aNewsletterInfo['newsletter_id']);
				$this->database()->delete(Phpfox::getT('newsletter_text'), 'newsletter_id = ' . $aNewsletterInfo['newsletter_id']);
			}
			else
			{
				$this->database()->update($this->_sTable, array('state' => 2), 'newsletter_id = ' . (int)$aNewsletterInfo['newsletter_id']);
			}
			$this->database()->update(Phpfox::getT('user_field'), array('newsletter_state' => 0), 'newsletter_state != 0');
			
			return array(true, 100); // newsletter sent to everyone. finished successfully.
		}
		
		$sOriginalHtmlText = $aNewsletterInfo['text_html'];
		$sOriginalPlainText = $aNewsletterInfo['text_plain'];
		
		// store these users ID into a string to update them		
		$sUpdate = '1=2 ';
		// Step 3: Send the message
		if ($aNewsletterInfo['type_id'] == 2) // External -> send email
		{
			$aValsT = $aNewsletterInfo;
			foreach ($aUsers as $aUser)
			{
				$aNewsletterInfo = $aValsT;
				$sUpdate .= ' OR user_id = ' . $aUser['user_id'];
				/*if (isset($aUser['user_group_id']) && Phpfox::getUserGroupParam($aUser['user_group_id'], 'newsletter.can_receive_notification') == false)
				{
					
				}
				else*/if (isset($aUser['notification']) && $aUser['notification'] != '' && $aNewsletterInfo['privacy'] != 1)
				{ // user does not want to receive mails and admin set this newsletter to NOT override this					
					continue;
				}
				// keyword substitution
				$aSearch = array('{FULL_NAME}', '{USER_NAME}', '{SITE_NAME}');
				$aReplace = array($aUser['full_name'], $aUser['user_name'], Phpfox::getParam('core.site_title'));
				
				$aNewsletterInfo['text_html'] = str_ireplace($aSearch, $aReplace, $sOriginalHtmlText);
				$aNewsletterInfo['subject'] = str_ireplace($aSearch, $aReplace, $aNewsletterInfo['subject']);
                                
				if ($aNewsletterInfo['text_plain'] !== null)
				{
					$aNewsletterInfo['text_plain'] = str_ireplace($aSearch, $aReplace, $sOriginalPlainText);
				}				
				unset($aSearch);
				unset($aReplace);
				$this->_sendExternal($aNewsletterInfo, $aUser);
			}
		}
		elseif($aNewsletterInfo['type_id'] == 1) // internal message
		{
			foreach ($aUsers as $aUser)
			{
				// keyword substitution
				$aSearch = array('{FULL_NAME}', '{USER_NAME}', '{SITE_NAME}');
				$aReplace = array($aUser['full_name'], $aUser['user_name'], Phpfox::getParam('core.site_title'));

				$aNewsletter = $aNewsletterInfo;
				$aNewsletter['text_html'] = str_ireplace($aSearch, $aReplace, $sOriginalHtmlText);
                $aNewsletter['subject'] = str_ireplace($aSearch, $aReplace, $aNewsletterInfo['subject']);

				$aNewsletter['user_id'] = $aUser['user_id'];
				unset($aSearch);
				unset($aReplace);
				
								
				$aNewsletter['full_name'] = $aUser['full_name'];
				$aNewsletter['user_id'] = $aUser['user_id'];
				$aNewsletter['email'] = $aUser['email'];
				
				
				$this->_sendInternal($aNewsletter);
				
				$sUpdate .= ' OR user_id = ' . $aUser['user_id'];
				
				if (isset($aUser['notification']) && $aUser['notification'] != '' && $aNewsletterInfo['privacy'] != 1)
				{ // user does not want to receive mails and admin set this newsletter to NOT override this
					continue;
				}				
			}
		}
		
		// Step 4: Update these users so they dont get the newsletter again
		$this->database()->update(Phpfox::getT('user_field'), array('newsletter_state' => 1), $sUpdate);
		//Step 5: Update the round
		++$aNewsletterInfo['round'];
		$this->database()->update($this->_sTable, array(
				'round' => $aNewsletterInfo['round'],
				'state' => 1,	// its in progress
			), 'newsletter_id = ' . (int)$aNewsletterInfo['newsletter_id']);

		// Step 6: return the id so it keeps sending in the next batch and calculate the percentage.
		// how many users do we have left?
		// check if we have a where
		$sSelect = 'COUNT(user_id)';
		
		$sNewWhere = str_replace('uf.newsletter_state = 0 AND ', '', $sWhere);
		if ($sNewWhere != '')
		{
			$sSelect = 'COUNT(uf.user_id)';
			$this->database()->where($sNewWhere)
			->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = u.user_id');
		}		
		
		$iTotalUsers = $this->database()
			->select($sSelect)
			->from(Phpfox::getT('user'), 'u')
			->execute('getSlaveField');
		$iSentTotal = $this->database()
			->select('count(user_id)')
			->from(Phpfox::getT('user_field'))
			->where('newsletter_state = 1')
			->execute('getSlaveField');


		if ($iTotalUsers > 0 && $iTotalUsers != $iSentTotal)
		{
			$iPerc = ceil( ($iSentTotal / $iTotalUsers) * 100 );
		}
		else
		{
			$iPerc = 100;
		}
		if($iPerc >= 100)
		{
			if ($aNewsletterInfo['archive'] != 1)
			{
				$this->database()->delete($this->_sTable, 'newsletter_id = ' . $aNewsletterInfo['newsletter_id']);
				$this->database()->delete(Phpfox::getT('newsletter_text'), 'newsletter_id = ' . $aNewsletterInfo['newsletter_id']);
			}
			else
			{
				$this->database()->update(Phpfox::getT('user_field'), array('newsletter_state' => 0), 'newsletter_state != 0');
				$this->database()->update($this->_sTable, array('state' => 2), 'newsletter_id = ' . $aNewsletterInfo['newsletter_id']);
			}
			$this->database()->update(Phpfox::getT('user_field'), array('newsletter_state' => 0), 'newsletter_state != 0');
		}
		return array((int)$aNewsletterInfo['newsletter_id'], $iPerc);
	}

	public function delete($iId)
	{
		if (!Phpfox::getUserParam('newsletter.can_create_newsletter'))
		{
			return false;
		}
		$iState = $this->database()->select('state')
		->from($this->_sTable)
		->where('newsletter_id = ' . (int)$iId)
		->execute('getSlaveField');
		if ($iState == 1)
		{
			$this->database()->update(Phpfox::getT('user_field'), array('newsletter_state' => 0), 'newsletter_state != 0');
		}
		$this->database()->delete($this->_sTable, 'newsletter_id = ' . (int)$iId);
		$this->database()->delete(Phpfox::getT('newsletter_text'), 'newsletter_id = ' . (int)$iId);
		return true;
	}
	/**
	 * Performes maintenance tasks such as resetting the user_field.newsletter_id to null
	 * @param int $iAction
	 * @return true on success
	 */
	public function purge($iAction, $iId)
	{
		switch($iAction)
		{
			case 1: // clear users
				$this->database()->update(Phpfox::getT('user_field'), array(
					'newsletter_state' => 0
					), 'newsletter_state != 0');
				return true;
				break;
			default:
				Phpfox_Error::set(Phpfox::getPhrase('newsletter.purge_action_not_valid'));
				return false;
				break;
		}

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
		if ($sPlugin = Phpfox_Plugin::get('notification.service_process__call'))
		{
			return eval($sPlugin);
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
	
	private function _sendExternal($aVals, $aUser)
	{
		$aVals['text_html'] = str_replace("\n", '', $aVals['text_html']);
		$aVals['text_html'] = Phpfox::getLib('parse.input')->prepare($aVals['text_html'], true);
		
		Phpfox::getLib('mail')->to($aVals)
			->aUser($aUser)
			->subject($aVals['subject'])
			->message($aVals['text_html'])
			->messagePlain(strip_tags($aVals['text_plain']))
			->fromName(Phpfox::getParam('core.mail_from_name'))
			->sendToSelf(true)
			->send();
			
		return true;
	}	
	
	/**
	 * This function can probably still be improved by not adding data to the mail_text and recycle the reference to the first entry
	 * @param <type> $aVals
	 */
	private function _sendInternal($aVals)
	{		
		$oFilter = Phpfox::getLib('parse.input');
		$aVals['subject'] = (isset($aVals['subject']) ? $oFilter->clean($aVals['subject'], 255) : null);
		
		$aSend = array();
		$aSend['to'] = array($aVals['user_id']);
		$aSend['subject'] = $aVals['subject'];
		$aSend['message'] = $aVals['text_html'];
		$aSend['bIsNewsletter'] = true;
		Phpfox::getService('mail.process')->add($aSend);
		
		return ;
		/*$aInsert = array(
			'parent_id' => 0,
			'subject' => $aVals['subject'],
			'preview' => $oFilter->clean($oFilter->prepare($aVals['text_html']), 255),
			'owner_user_id' => 0,
			'viewer_user_id' => $aVals['user_id'],
			'viewer_is_new' => 1,
			'time_stamp' => PHPFOX_TIME,
			'time_updated' => PHPFOX_TIME,
			'total_attachment' => 0,
		);

		$iId = $this->database()->insert(Phpfox::getT('mail'), $aInsert);

		$this->database()->insert(Phpfox::getT('mail_text'), array(
				'mail_id' => $iId,
				'text' => $oFilter->clean($aVals['text_html']),
				'text_parsed' => $oFilter->prepare($aVals['text_html'])
			)
		);
		
		// Send the user an email
		$sLink = Phpfox::getLib('url')->makeUrl('mail.view', array('id' => $iId));
		Phpfox::getLib('mail')->to($aVals['user_id'])
			->subject(array('newsletter.site_newsletter_title', array('title' => $aVals['subject'])))
			->message(array('newsletter.you_have_received_a_newsletter_from_title', array(
						'title' => Phpfox::getParam('core.site_title'),
						'link' => $sLink
					)
				)
			)
			->notification('mail.new_message')
			->send();		*/
	}	
}

?>