<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_User
 * @version 		$Id: process.class.php 6476 2013-08-20 09:23:21Z Miguel_Espinoza $
 */
class User_Service_Cancellations_Process extends Phpfox_Service
{	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('user_delete');
	}

	/**
	 * Adds a new cancellation option to be shown when a user wants to delete their account
	 * Looks like its working when adding, @todo Purefan: test it works for editing as well.
	 * @param array $aVals
	 * @param int $iUpdateId Optional param to tell if we're editing
	 * @return boolean
	 */
	public function add($aVals)
	{
		$aForm = array(
			'product_id' => array(
				'message' => Phpfox::getPhrase('user.select_a_product'),
				'type' => 'product_id:required'
			),
			'module_id' => array(
				'message' => Phpfox::getPhrase('user.select_a_module'),
				'type' => 'module_id:required'
			),
			'phrase_var' => array(
				'message' => Phpfox::getPhrase('user.you_need_to_add_a_message_to_show'),
				'type' => 'phrase:required'
			),
			'is_active' => array(
				'message' => Phpfox::getPhrase('user.select_if_the_cancellation_option_is_active_or_not'),
				'type' => 'int:required'
			)
		);

		$iUpdateId = isset($aVals['iDeleteId']) ? (int)$aVals['iDeleteId'] : null;
		
		if ($iUpdateId !== null)
		{
			unset($aForm['product_id'], $aForm['module_id']);

			$aVals = $this->validator()->process($aForm, $aVals);

			if (!Phpfox_Error::isPassed())
			{
				return false;
			}

			$aPhrases = $aVals['phrase_var'];
			unset($aVals['phrase_var']);

			
			$this->database()->update($this->_sTable, $aVals, 'delete_id = ' . $iUpdateId);
			
			// Updates the language phrases for every language
			foreach ($aPhrases as $sPhrase => $aPhrase)
			{
				$aLanguage = array_keys($aPhrase);
				$aText = array_values($aPhrase);

				Phpfox::getService('language.phrase.process')->updateVarName($aLanguage[0], $sPhrase, $aText[0]);
			}
		}
		else
		{
			$aVals = $this->validator()->process($aForm, $aVals);

			if (!Phpfox_Error::isPassed())
			{
				return false;
			}

			$aPhrases = $aVals['phrase_var'];
			$aVals['phrase_var'] = '';

			$iId = $this->database()->insert($this->_sTable, $aVals);

			$sPhraseVar = Phpfox::getService('language.phrase.process')->add(array(
					'var_name' => 'user_cancellation_' . $iId,
					'product_id' => $aVals['product_id'],
					'module' => $aVals['module_id'] . '|' . $aVals['module_id'],
					'text' => $aPhrases
				)
			);

			$this->database()->update($this->_sTable, array('phrase_var' => $sPhraseVar), 'delete_id = ' . $iId);
		}

		$this->cache()->remove('user_cancellations');

		return true;
	}

	/**
	 * Cancels a user account by deleting all the information related to them.
	 * @param array $aVal
	 * @return Phpfox_Error if password doesnt match | false if user does not have enough permissions or password is not set
	 */
	public function cancelAccount($aVal)
	{
		Phpfox::isUser(true);
		define('PHPFOX_CANCEL_ACCOUNT', true);
		if (!isset($aVal['password']) && !Phpfox::getUserBy('fb_user_id') && !Phpfox::getUserBy('janrain_user_id'))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.please_enter_your_password'));
		}
		if (!Phpfox::getUserParam('user.can_delete_own_account'))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.you_are_not_allowed_to_delete_your_own_account'));
		}
		// confirm $aVal[password] == user password
		// get user's data
		$aRow = $this->database()
			->select('password_salt, password')
			->from(Phpfox::getT('user'))
			->where('user_id = ' . Phpfox::getUserId())
			->execute('getSlaveRow');
		
		if (!Phpfox::getUserBy('fb_user_id') && !Phpfox::getUserBy('janrain_user_id') && Phpfox::getLib('hash')->setHash($aVal['password'], $aRow['password_salt']) != $aRow['password'])
		{
			if ($sPlugin = Phpfox_Plugin::get('user.service_cancellations_process_cancelaccount_invalid_password')){eval($sPlugin);}
			return Phpfox_Error::set(Phpfox::getPhrase('user.invalid_password'));
		}
		Phpfox::getService('user.cancellations.process')->feedbackCancellation($aVal);
		
		// mass callback
		Phpfox::massCallback('onDeleteUser', Phpfox::getUserId());
		// log out adter having deleted all the info
		Phpfox::getService('user.auth')->logout();
		Phpfox::getLib('url')->send('', null, Phpfox::getPhrase('user.your_account_has_been_deleted'));
		return true;
	}

	/**
	 * Removes an user cancellation (from both user_delete and language_phrases).
	 * It also clears cache "user_cancellations".
	 * @param int $iDelete
	 * @return boolean true on success
	 */
	public function delete($iDelete)
	{
		$aDelete = $this->database()
			->select('*')
			->from($this->_sTable)
			->where('delete_id = ' . (int)$iDelete)
			->execute('getSlaveRow');
		if (empty($aDelete))
		{ // entry does not exist
			return false;
		}
		$this->database()->delete($this->_sTable, 'delete_id = ' . $iDelete);
		$this->database()->delete(Phpfox::getT('language_phrase'), 'module_id = \''.$aDelete['module_id'].'\' AND var_name = \'user_cancellation_' . $iDelete . '\'');
		$this->cache()->remove('user_cancellations');
		return true;
	}

	/**
	 * Deletes a feedback entry from `user_delete_feedback`
	 * @param <type> $iFeedback
	 * @return <type>
	 */
	public function deleteFeedback($iFeedback)
	{
		$this->database()->delete(Phpfox::getT('user_delete_feedback'), 'feedback_id = ' . (int)$iFeedback);
		return true;
	}

	/**
	 * Stores any information regarding a user's account cancellation
	 * @param array $aVals
	 *
	 */
	public function feedbackCancellation($aVals)
	{
		
		$aFeedback = array(
			'user_email' => Phpfox::getUserBy('email'),
			'user_group_id' => Phpfox::getUserBy('user_group_id'),
			'full_name' => Phpfox::getUserBy('full_name'),
			'time_stamp' => Phpfox::getTime()
		);
		// do we have any text?
		if (isset($aVals['feedback_text']) && $aVals['feedback_text'] != '')
		{
			$aFeedback['feedback_text'] = $this->preParse()->clean($aVals['feedback_text']);
		}
		else
		{
			$aFeedback['feedback_text'] = null;
		}

		// did the user provide any reason?
		if (isset($aVals['reason']))
		{
			// check these are valid reasons
			$sReasons = '1=2';
			foreach ($aVals['reason'] as $iReason)
			{
				$sReasons .= ' OR delete_id = ' . (int)$iReason;
			}
			$aDbReasons = $this->database()
				->select('phrase_var')
				->from(Phpfox::getT('user_delete'))
				->where($sReasons)
				->execute('getSlaveRows');
			
			$aFeedback['reasons_given'] = serialize($aDbReasons);
		}
		if (empty($aFeedback['reasons_given']))
		{
			$aFeedback['reasons_given'] = null;
		}
		$this->database()->insert(Phpfox::getT('user_delete_feedback'), $aFeedback);
	}


	/**
	 * Toggles active/inactive a cancellation
	 * @param int $iId `user_delete`.`delete_id`
	 * @param int $iType 1 = active, else = inactive
	 */
	public function updateActivity($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);

		$this->database()->update($this->_sTable, array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'delete_id = ' . (int) $iId);

		$this->cache()->remove('user_cancellations');
	}	

	/**
	 * Updates the order of the cancellations
	 * @param array $aVals
	 * @return <type>
	 */
	public function updateOrder($aVals)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);

		if (!isset($aVals['ordering']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('user.not_a_valid_request'));
		}

		foreach ($aVals['ordering'] as $iId => $iOrder)
		{
			$this->database()->update($this->_sTable, array('ordering' => (int) $iOrder), 'delete_id = ' . (int) $iId);
		}

		$this->cache()->remove('user_cancellations');
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_activity__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
}

?>