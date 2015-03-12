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
 * @package  		Module_Poll
 * @version 		$Id: poll.class.php 7061 2014-01-22 15:15:00Z Fern $
 */
class Poll_Service_Poll extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('poll');
	}

	/**
	 *	checks the format of the array and default answers and empty values
	 * @param array $aVals input from the user
	 * @return boolean true on success | array(string) on error
	 */
	public function checkStructure($aVals)
	{

		$aErrors = array();
		// check the question so its not empty
		if( empty($aVals['question']) || ($aVals['question'] == '') || (strlen($aVals['question']) > 254))
		{
			$aErrors[0] = Phpfox::getPhrase('poll.maximum_length_for_the_question_is_255_characters_and_it_cannot_be_empty');
		}
		
		$iTotalPass = 0;
		foreach ($aVals['answer'] as $aAnswer)
		{
			if (!Phpfox::getLib('parse.format')->isEmpty($aAnswer['answer']))
			{
				$iTotalPass++;
			}
			
			if ((strpos(strtolower($aAnswer['answer']), 'answer') === false) || (strpos($aAnswer['answer'], '...') === false))
			{
				continue;
			}
			// default answers format is "Answer X[Y]..."
			if (is_numeric($aAnswer['answer']))
			{
				continue;
			}

			$sAnswer = str_replace('answer', '', strtolower($aAnswer['answer']));
			$sAnswer = trim(str_replace('...', '', $sAnswer));
			if (is_numeric($sAnswer))
			{
				$aErrors[1] = Phpfox::getPhrase('poll.we_dont_allow_default_answers_answer', array('answer' => $aAnswer['answer']));
				continue;
			}

			if (strlen($aAnswer['answer']) > 150)
			{
				$aErrors[2] = Phpfox::getPhrase('poll.maximum_length_for_the_answers_is_150_characters');
				continue;
			}
		}
		
		if ($iTotalPass < 2)
		{
			Phpfox_Error::set(Phpfox::getPhrase('poll.you_need_to_write_at_least_2_answers'));
		}

		if(!is_array($aVals['answer']) || empty($aVals['answer']) || count($aVals['answer']) < 2)
		{
			Phpfox_Error::set(Phpfox::getPhrase('poll.you_need_to_write_at_least_2_answers'));
		}

		if (!empty($aErrors)) return $aErrors;
		return true;

	}

	/**
	 * Gets one poll from the database given only its url question
	 *
	 * @param string $sQuestionUrl url question
	 *
	 * @return array
	 */
	public function getPollById($iPollId, $iUser = null)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.service_poll_getpollbyid_start')) ? eval($sPlugin) : false);

		$aPoll = $this->getPollByUrl($iPollId);

		(($sPlugin = Phpfox_Plugin::get('poll.service_poll_getpollbyid_end')) ? eval($sPlugin) : false);
		
		return $aPoll;
	}

	/**
	 * Gets one poll given its question_url
	 *
	 * @param string $sUrl question_url
	 *
	 * @return array
	 */
	public function getPollByUrl($sUrl, $iPage = false, $iPageSize = false, $bIsView = false)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.service_poll_getpollbyurl_start')) ? eval($sPlugin) : false);

		if (Phpfox::isModule('track') && $bIsView)
		{
			$this->database()->select("poll_track.item_id AS poll_is_viewed, ")->leftJoin(Phpfox::getT('poll_track'), 'poll_track', 'poll_track.item_id = p.poll_id AND poll_track.user_id = ' . Phpfox::getUserBy('user_id'));
		}		
		
		if (Phpfox::isModule('friend') && Phpfox::isUser())
		{
			$this->database()->select('COALESCE(f.friend_id, false) AS is_friend, ')->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = p.user_id AND f.friend_user_id = " . Phpfox::getUserId());					
		}
		else
		{
			$this->database()->select('false as is_friend, ');
		}
		
		if(Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'poll\' AND l.item_id = p.poll_id AND l.user_id = ' . Phpfox::getUserId());
		}
		
		$aPoll = $this->database()->select('p.*, pd.background, pd.percentage, pd.border, pr.user_id as voted, pr.answer_id, ' . Phpfox::getUserField())
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'),'u', 'u.user_id = p.user_id')
			->leftjoin(Phpfox::getT('poll_design'), 'pd', 'pd.poll_id = p.poll_id')
			->leftjoin(Phpfox::getT('poll_result'), 'pr', 'pr.poll_id = p.poll_id AND pr.user_id = ' . Phpfox::getUserId())
			->where('p.poll_id = ' . (int) $sUrl)
			->execute('getSlaveRow');
		
		// Control		
		if (empty($aPoll))
		{
			return false;
		}
		
		$aPoll['user_voted_this_poll'] = false;

		$aAnswers = $this->database()->select('pa.*')
			->from(Phpfox::getT('poll_answer'), 'pa')
			->where('pa.poll_id = ' . (int) $aPoll['poll_id'])
			->order('pa.ordering ASC')
			->execute('getSlaveRows');

		$iTotalVotes = 0;
		foreach ($aAnswers as $aAnswer)
		{
			$iTotalVotes += $aAnswer['total_votes'];
		}
		foreach ($aAnswers as $iKeyAnswer => $aAnswer)
		{			
			if ($aPoll['poll_id'] == $aAnswer['poll_id'])
			{
				if (isset($aAnswer['total_votes']) && $aAnswer['total_votes'] > 0)
				{
					$aAnswers[$iKeyAnswer]['vote_percentage'] = round(($aAnswer['total_votes'] * 100) / $iTotalVotes);
				}
				else
				{
					$aAnswers[$iKeyAnswer]['vote_percentage'] = 0;
				}
			}
		}

		$aPoll['total_votes'] = $iTotalVotes;

		// check if we should randomize the answers
		if ($aPoll['randomize'] == 1)
		{
			shuffle($aAnswers);
		}

		$aPoll['answer'] = $aAnswers;
		if (!empty($aPoll['answer_id']))
		{
			$aPoll['user_voted_this_poll'] = true;
		}		
		if (!isset($aPoll['is_friend']))
		{
			$aPoll['is_friend'] = 1;
		}
			
		(($sPlugin = Phpfox_Plugin::get('poll.service_poll_getpollbyurl_end')) ? eval($sPlugin) : false);

		return $aPoll;
	}

	/**
	 *	returns the ids of the answers that $iUser has voted
	 * @param int $iUser
	 * @return array
	 */
	public function getVotedAnswersByUser($iUser, $iPoll = null)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.service_poll_getVotedAnswersByUser_start')) ? eval($sPlugin) : false);
		return $this->database()->select('pr.answer_id')
		->from(Phpfox::getT('poll_result'), 'pr')
		->where('pr.user_id = ' . (int)$iUser . (isset($iPoll) ? ' AND pr.poll_id = ' . (int)$iPoll : ''))
		->execute('getSlaveRows');
		(($sPlugin = Phpfox_Plugin::get('poll.service_poll_getVotedAnswersByUser_end')) ? eval($sPlugin) : false);
	}

	/**
	 * Returns if a poll is being moderated
	 * @param integer $iPoll
	 * @return boolean
	 */
	public function isModerated($iPoll)
	{
		$iModerated = $this->database()->select('view_id')
		->from($this->_sTable)
		->where('poll_id = ' . (int)$iPoll)
		->execute('getSlaveField');

		return (is_numeric($iModerated) && $iModerated == 1);
	}

	/**
	 * Gets the polls given the conditions in $aCond which can be an array or just a string,
	 * orders by date as in newest first
	 *
	 * @deprecated
	 * @since 3.0.0beta1
	 * @param mixed $aCond
	 * @param integer $iUser user id to check if this user has already voted
	 * @param integer $iPage Page to show
	 * @param integer $iPageSize How many items per page
	 * @return array
	 */
	public function getPolls($aCond = array(), $iPage = false, $iPageSize = false, $sOrder = null)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.service_poll_getpolls_start')) ? eval($sPlugin) : false);		
		
		$aCond = array();
		foreach ($this->search()->getConditions() as $sCond)
		{
			switch (Phpfox::getLib('request')->get('view'))
			{
				case 'friend':
					$aCond[] = str_replace('%PRIVACY%', '0,1,2', $sCond);
					break;
				case 'my':
					$aCond[] = str_replace('%PRIVACY%', '0,1,2,3,4', $sCond);
					break;				
				default:
					$aCond[] = str_replace('%PRIVACY%', '0', $sCond);
					break;
			}
		}		
		
		if (Phpfox::getParam('core.section_privacy_item_browsing'))
		{	
			Phpfox::getService('privacy')->buildPrivacy(array(
					'module_id' => 'poll',
					'alias' => 'poll',
					'field' => 'poll_id',
					'count' => true,
					'table' => Phpfox::getT('poll'),
					'service' => 'poll'
				)
			);			
				
			$iCnt = $this->database()->joinCount('total_item')->execute('getSlaveField');		
		}
		else 
		{
			$iCnt = $this->database()->select("COUNT(*)")
				->from($this->_sTable, 'poll')			
				->where($aCond)
				->execute('getSlaveField');
		}		

		// quick check
		if (empty($iCnt) || $iCnt == 0)
		{
			return array(0, array());
		}
				
		if (Phpfox::getParam('core.section_privacy_item_browsing'))
		{
			Phpfox::getService('privacy')->buildPrivacy(array(
					'module_id' => 'poll',
					'alias' => 'poll',
					'field' => 'poll_id',
					'table' => Phpfox::getT('poll'),
					'service' => 'poll'
				)
			);
			$this->database()->unionFrom('poll');
		}
		else 
		{
			$this->database()->from($this->_sTable, 'poll')->where($aCond);
		}
		
		$aPolls = $this->database()->select('poll.*,  pd.background, pd.percentage, pd.border, pr.answer_id, pr.user_id as voted, friends.friend_id AS is_friend, ' . Phpfox::getUserField())
			->join(Phpfox::getT('user'), 'u', 'u.user_id = poll.user_id')
			->leftjoin(Phpfox::getT('poll_design'), 'pd', 'pd.poll_id = poll.poll_id')
			->leftjoin(Phpfox::getT('poll_result'), 'pr', 'pr.poll_id = poll.poll_id AND pr.user_id = ' . Phpfox::getUserId())
			->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'poll\' AND l.item_id = poll.poll_id AND l.user_id = ' . Phpfox::getUserId())
			->leftJoin(Phpfox::getT('friend'), 'friends', 'friends.user_id = poll.user_id AND friends.friend_user_id = ' . Phpfox::getUserId())
			->limit($iPage, $iPageSize, $iCnt)			
			->order('poll.time_stamp DESC')
			->execute('getSlaveRows');				

		// we "implode" the poll_ids to run only one query on the DB to get the
		// answers
		$sPolls = '';
		foreach ($aPolls as $aPoll)
		{
			$sPolls .= $aPoll['poll_id'] . ',';
		}
		$sPolls = rtrim($sPolls, ',');

		$aAnswers = $this->database()->select('pa.*, pr.user_id as voted')
			->from(Phpfox::getT('poll_answer'),'pa')
			->where('pa.poll_id IN(' . $sPolls . ')')
			->leftjoin(Phpfox::getT('poll_result'), 'pr', 'pr.answer_id = pa.answer_id AND pr.user_id = ' . Phpfox::getUserId())
			->order('pa.ordering ASC')
			->execute('getSlaveRows');
		
		// now merge both arrays by their poll_id and add the count for the total votes
		$aPolls2 = array();
		$iTotalVotes = 0;
		$aTotalVotes = array();
		foreach ($aAnswers as $aAnswer)
		{			
			if($aAnswer['total_votes'] > 0)
			{
				if (isset($aTotalVotes[$aAnswer['poll_id']]))
				{
					$aTotalVotes[$aAnswer['poll_id']] += $aAnswer['total_votes'];//$aTotalVotes[$aAnswer['poll_id']]+1;
				}
				else
				{
					$aTotalVotes[$aAnswer['poll_id']] = $aAnswer['total_votes'];
				}
			}
		}

		foreach ($aPolls as $iKey => $aPoll)
		{
			$aPoll['aFeed'] = array(			
				'feed_display' => 'mini',	
				'comment_type_id' => 'poll',
				'privacy' => $aPoll['privacy'],
				'comment_privacy' => $aPoll['privacy_comment'],
				'like_type_id' => 'poll',				
				'feed_is_liked' => (isset($aPoll['is_liked']) ? $aPoll['is_liked'] : false),
				'feed_is_friend' => (isset($aPoll['is_friend']) ? $aPoll['is_friend'] : false),
				'item_id' => $aPoll['poll_id'],
				'user_id' => $aPoll['user_id'],
				'total_comment' => $aPoll['total_comment'],
				'feed_total_like' => $aPoll['total_like'],
				'total_like' => $aPoll['total_like'],
				'feed_link' => Phpfox::permalink('poll', $aPoll['poll_id'], $aPoll['question']),
				'feed_title' => $aPoll['question']			
			);			
			
			$aPolls2[$aPoll['poll_id']] = $aPoll;

			if ($aPoll['poll_id']['user_id'] == Phpfox::getUserId())
			{
				$aPolls2[$aPoll['poll_id']]['user_voted_this_poll'] = 'true';
			}
			else
			{
				$aPolls2[$aPoll['poll_id']]['user_voted_this_poll'] = 'false'; // this could be tricky, test and see if it works everywhere
			}
			
			if (!isset($aPolls2[$aPoll['poll_id']]['total_votes']))
			{
				$aPolls2[$aPoll['poll_id']]['total_votes'] = 0;
			}
			
			foreach ($aAnswers as &$aAnswer)
			{ // we add the total votes for the poll
				
				if (!isset($aAnswer['vote_percentage']))
				{
					$aAnswer['vote_percentage'] = 0;
				}
				if (!isset($aAnswer['total_votes']))
				{
					$aAnswer['total_votes'] = 0;
				}
				// Normalize if user voted this answer or not
				if (isset($aAnswer['voted']) && $aAnswer['voted'] == Phpfox::getUserId())
				{
					$aAnswer['user_voted_this_answer'] = 1;
				}
				else
				{
					$aAnswer['user_voted_this_answer'] = 2;
				}
				if ($aPoll['poll_id'] == $aAnswer['poll_id'])
				{
					if ((isset($aTotalVotes[$aAnswer['poll_id']]) && $aTotalVotes[$aAnswer['poll_id']] > 0))
					{
						$aAnswer['vote_percentage'] =  round( ($aAnswer['total_votes'] / $aTotalVotes[$aAnswer['poll_id']]) * 100 );
					}
					else
					{
						 $aAnswer['vote_percentage'] = 0;
					}
					
					$aPolls2[$aPoll['poll_id']]['answer'][$aAnswer['answer_id']] = $aAnswer;
					
					$aPolls2[$aPoll['poll_id']]['total_votes'] += $aAnswer['total_votes'];
				}				
			}		
			
			if ($aPoll['randomize'] == 1 && !empty($aPolls2[$aPoll['poll_id']]['answer']))
			{
				shuffle($aPolls2[$aPoll['poll_id']]['answer']);
			}
		}

		(($sPlugin = Phpfox_Plugin::get('poll.service_poll_getpolls_end')) ? eval($sPlugin) : false);
		
		return array($iCnt, $aPolls2);
	}

	/**
	 * Gets answers specific to one poll
	 *
	 * @param integer $iPoll phpfox_poll.poll_id
	 * @deprecated
	 * @return array
	 */
	public function getAnswers($iPoll)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.service_poll_getanswers_start')) ? eval($sPlugin) : false);
		$aAnswers = $this->database()->select('pa.*, pc.*')
		->from(Phpfox::getT('poll_answer'), 'pa')
		->leftJoin(Phpfox::getT('poll_design'),'pc', 'pc.poll_id = '.$iPoll)
		->where('pa.poll_id = ' . (int) $iPoll)
		->execute('getSlaveRows');

		// total votes
		$iTotalVotes = 0;
		foreach ($aAnswers as $aAnswer)
		{
			$iTotalVotes = $iTotalVotes + $aAnswer['total_votes'];
		}
		foreach ($aAnswers as &$aAnswer)
		{
			$aAnswer['vote_percentage'] = ($aAnswer['total_votes'] > 0 ? round($aAnswer['total_votes'] * 100 / $iTotalVotes) : 0);
		}

		(($sPlugin = Phpfox_Plugin::get('poll.service_poll_getanswers_end')) ? eval($sPlugin) : false);
		return $aAnswers;

	}

	/**
	 * Gets the newer polls available
	 * @param integer $iLimit How many polls to fetch
	 * @return array
	 */
	public function getNew($iLimit = 3)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.service_poll_getnew_start')) ? eval($sPlugin) : false);
		
		return $this->database()->select('p.poll_id, p.time_stamp, p.question, p.question_url, ' . Phpfox::getUserField())
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->where('' . Phpfox::getLib('database')->isNull('p.module_id') . ' AND p.view_id = 0 AND p.privacy = 1')
			->limit($iLimit)
			->order('p.time_stamp DESC')
			->execute('getSlaveRows');

		(($sPlugin = Phpfox_Plugin::get('poll.service_poll_getnew_end')) ? eval($sPlugin) : false);
	}

	/**
	 * Used for paging, mostly an ajax call
	 * @param integer $iPage
	 * @param integer $sPoll
	 * @return array
	 */
	public function getVotes($iPollid)
	{
		$aVotes = $this->database()->select('p.poll_id, pa.answer, pr.user_id, pr.time_stamp, ' . Phpfox::getUserField())
			->from(Phpfox::getT('poll_result'), 'pr')
			->join($this->_sTable, 'p', 'p.poll_id = ' . (int) $iPollid)
			->join(Phpfox::getT('poll_answer'), 'pa', 'pa.answer_id = pr.answer_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = pr.user_id')
			// ->limit(((int)$iPage -1) * Phpfox::getParam('poll.show_x_users_who_took_poll'), Phpfox::getParam('poll.show_x_users_who_took_poll'))
			->order('pr.time_stamp DESC')
			->where('pr.poll_id = p.poll_id')
			->execute('getSlaveRows');

		return $aVotes;
	}

	/**
	 * Checks for permissions on editing a poll. This function doesnt call the database
	 * @param integer $iUser The user id to check for
	 */
	public function bCanEdit($iUser)
	{
		if ($iUser == Phpfox::getUserId())
		{
			return Phpfox::getUserParam('poll.poll_can_edit_own_polls') &&
			(Phpfox::getUserParam('poll.can_edit_question') || Phpfox::getUserParam('poll.can_edit_title'));
		}
		else
		{
			return Phpfox::getUserParam('poll.poll_can_edit_others_polls') &&
			(Phpfox::getUserParam('poll.can_edit_question') || Phpfox::getUserParam('poll.can_edit_title'));
		}
	}

	/**
	 * Gets the total number of polls pending approval
	 * @return int
	 */
	public function getPendingTotal()
	{
		return (int) $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('view_id = 1')
			->execute('getSlaveField');
	}	

	public function getInfoForAction($aItem)
	{
		if (is_numeric($aItem))
		{
			$aItem = array('item_id' => $aItem);
		}
		$aRow = $this->database()->select('p.poll_id, p.question as title, p.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('poll'), 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->where('p.poll_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');
			
		if (empty($aRow))
		{
			d($aRow);
			d($aItem);
		}
		
		$aRow['link'] = Phpfox::getLib('url')->permalink('poll', $aRow['poll_id'], $aRow['title']);
		return $aRow;
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
		if ($sPlugin = Phpfox_Plugin::get('poll.service_poll__call'))
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
