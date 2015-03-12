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
 * @package 		Phpfox_Service
 * @version 		$Id: browse.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Poll_Service_Browse extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function query()
	{
		$this->database()->select('pd.background, pd.percentage, pd.border, pr.answer_id, pr.user_id as voted, friends2.friend_id AS is_friend, ')
			->leftjoin(Phpfox::getT('poll_design'), 'pd', 'pd.poll_id = poll.poll_id')
			->leftjoin(Phpfox::getT('poll_result'), 'pr', 'pr.poll_id = poll.poll_id AND pr.user_id = ' . Phpfox::getUserId())
			->leftJoin(Phpfox::getT('friend'), 'friends2', 'friends2.user_id = poll.user_id AND friends2.friend_user_id = ' . Phpfox::getUserId());				

		if (Phpfox::isUser() && Phpfox::isModule('like'))
		{
			$this->database()->select('lik.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'lik', 'lik.type_id = \'poll\' AND lik.item_id = poll.poll_id AND lik.user_id = ' . Phpfox::getUserId());
		}		
	}
	
	public function getQueryJoins($bIsCount = false, $bNoQueryFriend = false)
	{
		if (Phpfox::isModule('friend') && Phpfox::getService('friend')->queryJoin($bNoQueryFriend))
		{
			$this->database()->join(Phpfox::getT('friend'), 'friends', 'friends.user_id = poll.user_id AND friends.friend_user_id = ' . Phpfox::getUserId());	
		}		
	}

	public function processRows(&$aPolls2)
	{
		$aPolls = $aPolls2;
		$aPolls2 = array();
		
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
				'feed_title' => $aPoll['question'],
				'type_id' => 'poll'
			);			
			
			$aPolls2[$aPoll['poll_id']] = $aPoll;

			if (isset($aPoll['poll_id']['user_id']) && $aPoll['poll_id']['user_id'] == Phpfox::getUserId())
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
		
		unset($aPolls);
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
		if ($sPlugin = Phpfox_Plugin::get('poll.service_browse__call'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>
