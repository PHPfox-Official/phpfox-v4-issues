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
 * @version 		$Id: process.class.php 7188 2014-03-14 13:15:14Z Fern $
 */
class Poll_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('poll');
	}
	
	/**
	 * Adds a poll
	 *
	 * @param array $aVals input from the form after validated
	 * @param integer $iUser user_id of the owner of the poll
	 */
	public function add($iUser, $aVals, $bIsUpdate = false)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.service_process_add_start')) ? eval($sPlugin) : false);
		$sAnswers = '';
		if (isset($aVals['answer']) && is_array($aVals['answer']))
		{
			foreach ($aVals['answer'] as $aAnswer)
			{
				$sAnswers .= $aAnswer['answer'] . ' ';
			}
		}
		Phpfox::getService('ban')->checkAutomaticBan($aVals['question'] . ' ' . $sAnswers);
		if (!isset($aVals['randomize']))
		{
			$aVals['randomize'] = 0;
		}
		
		if (!isset($aVals['hide_vote']))
		{
			$aVals['hide_vote'] = 0;
		}
		
		if (!isset($aVals['privacy']))
		{
			$aVals['privacy'] = 0;
		}
		$oImage = Phpfox::getLib('image');
		$oFile = Phpfox::getLib('file');
		$bHasImage = false;
		$bIsCustom = ((!empty($aVals['module_id'])) ? true : false);
		if ($bIsCustom)
		{
			$aVals['randomize'] = '0';
		}
		
		// upload the image uploaded if allowed
		if (Phpfox::getUserParam('poll.poll_can_upload_image') && isset($_FILES['image']['name']) && ($_FILES['image']['name'] != ''))
		{
			$aImage = $oFile->load('image', array('jpg','gif','png'));
			if ($aImage === false)
			{
				return false;
			}
			$bHasImage = true;
		}
		
		$aInsert = array(			
			'question' => Phpfox::getLib('parse.input')->clean($aVals['question']),
			'privacy' => (isset($aVals['privacy']) ? $aVals['privacy'] : '0'),
			'privacy_comment' => (isset($aVals['privacy_comment']) ? $aVals['privacy_comment'] : '0'),
			'view_id' => ((!$bIsCustom && Phpfox::getUserParam('poll.poll_requires_admin_moderation')) === true) ? 1 : 0,			
			'randomize' => isset($aVals['randomize']) ? (int) $aVals['randomize'] : '1',
			'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID'),
			'hide_vote' => isset($aVals['hide_vote']) ? (int) $aVals['hide_vote'] : '0'
		);
		//(($sPlugin = Phpfox_Plugin::get('poll.service_process_add_ainsert')) ? eval($sPlugin) : false);

		//if its an update then delete the older answers
		if ($bIsUpdate)
		{
			$iId = $aVals['poll_id'];
			$this->database()->update($this->_sTable, $aInsert, 'poll_id = ' . (int)$aVals['poll_id']);
			$aInsert = $this->database()->select('poll_id, question, view_id, image_path')
				->from($this->_sTable)
				->where('poll_id = ' . (int)$aVals['poll_id'])
				->execute('getSlaveRow');
			// get the file size of the old image
			$iSize = Phpfox::getParam('poll.poll_max_image_pic_size');
			if ($bHasImage && isset($aInsert['image_path']) && $aInsert['image_path'] != '' &&
				file_exists(Phpfox::getParam('poll.dir_image') . sprintf($aInsert['image_path'], '') ) &&
				file_exists(Phpfox::getParam('poll.dir_image') . sprintf($aInsert['image_path'], '_' . $iSize)))
			{				
				$iOldPictureSpaceUsed = (filesize(Phpfox::getParam('poll.dir_image') . sprintf($aInsert['image_path'], '')) + filesize(Phpfox::getParam('poll.dir_image') . sprintf($aInsert['image_path'], '_' . $iSize)));
				// update the space used
				Phpfox::getService('user.space')->update((int)$iUser, 'quiz', $iOldPictureSpaceUsed, '-');
				// and delete the old picture
				Phpfox::getLib('file')->unlink(Phpfox::getParam('poll.dir_image') . sprintf($aInsert['image_path'], ''));
				Phpfox::getLib('file')->unlink(Phpfox::getParam('poll.dir_image') . sprintf($aInsert['image_path'], '_' . $iSize));
			}
			
			$aTotalVotes = $this->database()->select('pa.answer_id, pa.total_votes')
				->from(Phpfox::getT('poll_answer'), 'pa')				
				->where('pa.poll_id = ' . (int)$aVals['poll_id'])
				->execute('getSlaveRows');
			$this->database()->delete(Phpfox::getT('poll_answer'), 'poll_id = ' . $aVals['poll_id']);
			
			if (Phpfox::isModule('feed'))
			{
				(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->update('poll', $iId, $aVals['privacy'], (isset($aVals['privacy_comment']) ? (int) $aVals['privacy_comment'] : 0)) : null);
			}			
			
			if (Phpfox::isModule('privacy'))
			{
				if ($aVals['privacy'] == '4')
				{
					Phpfox::getService('privacy.process')->update('poll', $iId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));
				}
				else 
				{
					Phpfox::getService('privacy.process')->delete('poll', $iId);
				}			
			}
			
			if (Phpfox::getParam('feed.cache_each_feed_entry'))
			{
				$this->cache()->remove(array('feeds', 'poll_' . $iId));
			}
		}
		else 
		{
			$aInsert['user_id'] = $iUser;
			$aInsert['time_stamp'] = PHPFOX_TIME;
			if ($bIsCustom)
			{
				$aInsert['module_id'] = $aVals['module_id'];	
			}
			
			$iId = $this->database()->insert($this->_sTable, $aInsert);

			if (!Phpfox::getUserParam('poll.poll_requires_admin_moderation') && !$bIsCustom)
			{
				(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('poll', $iId, $aVals['privacy'], (isset($aVals['privacy_comment']) ? (int) $aVals['privacy_comment'] : 0)) : null);
				
				// Update user activity
				Phpfox::getService('user.activity')->update(Phpfox::getUserId(), 'poll');
			}
			
			if (isset($aVals['privacy']) && $aVals['privacy'] == '4')
			{
				Phpfox::getService('privacy.process')->add('poll', $iId, (isset($aVals['privacy_list']) ? $aVals['privacy_list'] : array()));			
			}			
		}
		
		// at this point there should only be valid answers ( != 'Answer number 1...', 'Answer number 2...')
		$iOrdering = 1;
		foreach($aVals['answer'] as $aAnswer)
		{
			if (Phpfox::getLib('parse.format')->isEmpty($aAnswer['answer']))
			{
				continue;
			}
			
			$aAnswerInsert = array(
					'poll_id' => ($bIsUpdate) ? $aVals['poll_id'] : (int) $iId,
					'answer' => Phpfox::getLib('parse.input')->clean($aAnswer['answer'], 255),
					'ordering' => $iOrdering
				);
			// (($sPlugin = Phpfox_Plugin::get('poll.service_process_add_insert_answer')) ? eval($sPlugin) : false);
			if (isset($aAnswer['answer_id']))
			{
				$aAnswerInsert['answer_id'] = $aAnswer['answer_id'];
				foreach ($aTotalVotes as $aVotes)
				{
					if ($aAnswer['answer_id'] == $aVotes['answer_id'])
					{
						$aAnswerInsert['total_votes'] = $aVotes['total_votes'];
					}
				}
			}			
			
			$this->database()->insert(Phpfox::getT('poll_answer'), $aAnswerInsert);
			++$iOrdering;
		}
		
		if ($bHasImage)
		{
			if (is_bool($iId)) $iId = (int)$aVals['poll_id'];
			$sFileName = $oFile->upload('image', Phpfox::getParam('poll.dir_image'), $iId);
			// update the poll
			$this->database()->update($this->_sTable, array('image_path' => $sFileName), 'poll_id = ' . $iId);			
			// now the thumbnails
			$iSize = Phpfox::getParam('poll.poll_max_image_pic_size');
			$oImage->createThumbnail(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '_' . $iSize), $iSize, $iSize);
			// Update user space usage
			Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'poll', (filesize(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '')) + filesize(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '_' . $iSize))));
			
			$this->database()->update($this->_sTable, array('server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')), 'poll_id = ' . (int) $iId);
		}
		
		if (!$bIsCustom)
		{
			if ($bIsUpdate)
			{
				// sync the results
				$aResults = $this->database()->select('pr.*')
					->from(Phpfox::getT('poll_result'), 'pr')
					->join(Phpfox::getT('poll_answer'), 'pa', 'pa.answer_id = pr.answer_id')
					->where('pr.poll_id = ' . (int)$aVals['poll_id'])
					->execute('getSlaveRows');
					
				$this->database()->delete(Phpfox::getT('poll_result'), 'poll_id = ' . $aVals['poll_id']);
				foreach ($aResults as $aResult)
				{
					$this->database()->insert(Phpfox::getT('poll_result'), $aResult);
				}
			}
		}
		
		(($sPlugin = Phpfox_Plugin::get('poll.service_process_add_end')) ? eval($sPlugin) : false);
		
		return array($iId, $aInsert);				
	}
	
	/**
	 * Changes the moderated state of a poll
	 *
	 * @param integer $iPoll poll_id
	 * @param integer $iResult 0 = public, 1 = awaiting moderation, 2 = deleted
	 * @return boolean if update, int if delete
	 */
	public function moderatePoll($iPoll, $iResult)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.service_process_moderate_start')) ? eval($sPlugin) : false);
		
		$aPoll = $this->database()->select('p.poll_id, p.view_id, p.user_id, p.image_path, p.question, p.privacy, p.privacy_comment, p.server_id')
			->from($this->_sTable, 'p')
			->where('p.poll_id = ' . (int) $iPoll)
			->execute('getRow');		

		if ($iResult == '0')
		{			
			if ($aPoll['view_id'] == '0')
			{
				return false;
			}
			
			$this->database()->update($this->_sTable, array('view_id' => (int) $iResult, 'time_stamp' => PHPFOX_TIME), 'poll_id = ' . $aPoll['poll_id']);
		
			if (Phpfox::isModule('notification'))
			{
				Phpfox::getService('notification.process')->add('poll_approved', $aPoll['poll_id'], $aPoll['user_id']);
			}

			(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->add('poll', $aPoll['poll_id'], $aPoll['privacy'], $aPoll['privacy_comment'], 0, $aPoll['user_id']) : null);
			
			// Send the user an email
			$sLink = Phpfox::getLib('url')->permalink('poll', $aPoll['poll_id'], $aPoll['question']);
			Phpfox::getLib('mail')->to($aPoll['user_id'])
				->subject(array('poll.your_poll_title_has_been_approved', array('title' => $aPoll['question'])))
				->message( Phpfox::getPhrase('poll.your_poll_a_href_link_title_a_has_been_approved_to_view_this_poll_follow_the_link_below_a_href_link_link_a',array('link' => $sLink, 'title' => $aPoll['question'])))				
				->send();			

			// Update user activity
			Phpfox::getService('user.activity')->update($aPoll['user_id'], 'poll');
			
			(($sPlugin = Phpfox_Plugin::get('poll.service_process_moderatepoll__1')) ? eval($sPlugin) : false);
			
			return 1;
		}						
		
		if (!empty($aPoll['image_path']))
		{
			$sFileName = $aPoll['image_path'];
			
			$iFileSize = 0;			
			if (file_exists(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '')))
			{
				$iFileSize += filesize(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, ''));
				Phpfox::getLib('file')->unlink(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, ''));
			}
			
			if (file_exists(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '_' . Phpfox::getParam('poll.poll_max_image_pic_size'))))
			{
				$iFileSize += filesize(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '_' . Phpfox::getParam('poll.poll_max_image_pic_size')));
				Phpfox::getLib('file')->unlink(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '_' . Phpfox::getParam('poll.poll_max_image_pic_size')));
			}
			
			// CDN!
			if (Phpfox::getParam('core.allow_cdn') && $aPoll['server_id'] > 0)
			{
				$aFilesToDelete = array(
					Phpfox::getParam('poll.dir_image') . sprintf($sFileName, ''),
					Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '_' . Phpfox::getParam('poll.poll_max_image_pic_size'))
				);
				
				foreach($aFilesToDelete as $sFilePath)
				{
					// Get the file size stored when the photo was uploaded
					$sTempUrl = Phpfox::getLib('cdn')->getUrl(str_replace(Phpfox::getParam('poll.dir_image'), Phpfox::getParam('poll.url_image'), $sFilePath));
					
					$aHeaders = get_headers($sTempUrl, true);
					if(preg_match('/200 OK/i', $aHeaders[0]))
					{
						$iFileSize += (int) $aHeaders["Content-Length"];
					}
					
					Phpfox::getLib('cdn')->remove($sFilePath);
				}
			}
					
			// Update user space usage
			Phpfox::getService('user.space')->update($aPoll['user_id'], 'poll', $iFileSize, '-');		
		}
		
		$this->database()->delete($this->_sTable, 'poll_id = ' . (int) $iPoll);
		$this->database()->delete(Phpfox::getT('poll_answer'), 'poll_id = ' . (int) $iPoll);
		$this->database()->delete(Phpfox::getT('poll_result'), 'poll_id = ' . (int) $iPoll);
		$this->database()->delete(Phpfox::getT('poll_design'), 'poll_id = ' . (int) $iPoll);
		$this->database()->delete(Phpfox::getT('poll_track'), 'item_id = ' . (int) $iPoll);
		
		Phpfox::getService('user.activity')->update($aPoll['user_id'], 'poll', '-');
		
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('poll', $iPoll) : null);
		(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->delete('comment_poll', $iPoll) : null);
		
		(($sPlugin = Phpfox_Plugin::get('poll.service_process_moderate_end')) ? eval($sPlugin) : false);
		
		return 2;
		
	}
	
	/**
	 * Tells if a user has voted on a specific poll
	 *
	 * @param integer $iUser
	 * @param integer $iPoll
	 * @return false or numeric
	 */
	public function hasUserVoted($iUser, $iPoll)
	{
		(($sPlugin = Phpfox_Plugin::get('poll.service_process_hasuservoted_start')) ? eval($sPlugin) : false);
		// check if user had already voted on this poll
		$iVoted = $this->database()->select('pr.answer_id')
			->from(Phpfox::getT('poll_result'),'pr')
			->where('poll_id = ' . (int)$iPoll . ' AND user_id =  ' . (int)$iUser)
			->execute('getSlaveField');
			
		
		(($sPlugin = Phpfox_Plugin::get('poll.service_process_hasuservoted_end')) ? eval($sPlugin) : false);
		if (is_numeric($iVoted) && $iVoted > 0)
		return $iVoted;
		
		return false;
	}

	/**
	 * Deletes an image, this function is a response to an ajax call
	 * @param integer $iPoll the identifier of the poll
	 * @param integer $iUser the user who triggered the ajax call
	 * @return boolean
	 */
	public function deleteImage($iPoll, $iUser)
	{
		$iUser = (int)$iUser;
		$iPoll = (int)$iPoll;
		if ($sPlugin = Phpfox_Plugin::get('poll.service_process_deleteimage_start'))eval($sPlugin);

		// get the name of the image:
		$sFileName = $this->database()->select('image_path')->from(Phpfox::getT('poll'))->where('poll_id = ' . $iPoll)->execute('getSlaveField');

		// calculate space used
		if (!empty($sFileName))
		{
			$iSize = Phpfox::getParam('poll.poll_max_image_pic_size');
			// check if the file exists and get its size
			if (file_exists(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '')) && file_exists(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '_' . $iSize)))
			$iOldPictureSpaceUsed = (filesize(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '')) + filesize(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '_' . $iSize)));
			
			// CDN!
			$iServerId = $this->database()->select('server_id')->from(Phpfox::getT('poll'))->where('poll_id = ' . $iPoll)->execute('getSlaveField');
			if (Phpfox::getParam('core.allow_cdn') && $iServerId > 0)
			{
				$iOldPictureSpaceUsed = 0;
				
				$aFilesToDelete = array(
					Phpfox::getParam('poll.url_image') . sprintf($sFileName, ''),
					Phpfox::getParam('poll.url_image') . sprintf($sFileName, '_' . $iSize)
				);
				
				foreach($aFilesToDelete as $sFilePath)
				{
					// Get the file size stored when the photo was uploaded
					$sTempUrl = Phpfox::getLib('cdn')->getUrl($sFilePath);
					
					$aHeaders = get_headers($sTempUrl, true);
					if(preg_match('/200 OK/i', $aHeaders[0]))
					{
						$iOldPictureSpaceUsed += (int) $aHeaders["Content-Length"];
					}
				}
			}
			
			// delete the old picture
			if (isset($iOldPictureSpaceUsed) && $iOldPictureSpaceUsed > 0)
			{
				Phpfox::getLib('file')->unlink(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, ''));
				Phpfox::getLib('file')->unlink(Phpfox::getParam('poll.dir_image') . sprintf($sFileName, '_' . $iSize));
				// decrease the count for the old picture
				Phpfox::getService('user.space')->update($iUser, 'poll', $iOldPictureSpaceUsed, '-');
			}
			
			if ($sPlugin = Phpfox_Plugin::get('poll.service_process_deleteimage_1')){eval($sPlugin);}
			
			if (!isset($bSkipDefaultReturn))
			{
				return $this->database()->update(Phpfox::getT('poll'), array('image_path' => null), 'poll_id = ' . $iPoll);
			}
		}
		
		if ($sPlugin = Phpfox_Plugin::get('poll.service_process_deleteimage_end')){eval($sPlugin);}
		
		return true;
		
	}

	/**
	 * Updates the count of a poll comment by increasing it.
	 * @param integer $iPoll The Poll identifier
	 */
	public function updateCounter($iPoll)
	{
		$this->database()->update($this->_sTable, array('total_comment' => array('= total_comment +', 1)), 'poll_id = ' . (int)$iPoll);
	}

	/**
	 * Casts a vote on a poll
	 * @param integer $iUser User identifier
	 * @param integer $iPoll Poll identifier
	 * @param integer $iAnswer Answer identifier
	 * @return boolean|Phpfox_Error
	 */
	public function addVote($iUser, $iPoll, $iAnswer)
	{		
		if ($sPlugin = Phpfox_Plugin::get('poll.service_process_addvote_1')){eval($sPlugin);}
		
		if ( $this->hasUserVoted($iUser, $iPoll) !== false)
		{
			// user has voted on this poll already
			if (Phpfox::getUserParam('poll.poll_can_change_own_vote'))
			{
				// update the vote
				// first delete current vote
				$this->database()->delete(Phpfox::getT('poll_result'), 'user_id = ' . (int)$iUser . ' AND answer_id = ' . (int)$iAnswer);
				// now insert the new vote
				$this->database()->insert(Phpfox::getT('poll_result'), array(
						'poll_id' => $iPoll,
						'answer_id' => $iAnswer,
						'user_id' => $iUser,
						'time_stamp' => PHPFOX_TIME
					)
				);
				return Phpfox_Error::set(Phpfox::getPhrase('poll.poll_vote_updated'));
			}
			else
			{
				// send error
				return Phpfox_Error::set(Phpfox::getPhrase('subscribe.your_membership_group_does_not_have_rights'));				
			}
		}
		else
		{
			// is user has not voted on this poll
			// check if user has permission to view this item
			$aPoll = $this->database()->select('p.poll_id, p.user_id, p.question, p.privacy, pa.answer')
				->from($this->_sTable, 'p')
				->join(Phpfox::getT('poll_answer'), 'pa', 'pa.answer_id = ' . (int) $iAnswer . ' AND pa.poll_id = ' . (int) $iPoll)
				->where('p.poll_id = ' . (int)$iPoll)
				->execute('getSlaveRow');
			
			if (!isset($aPoll['poll_id']))
			{
				return Phpfox_Error::set(Phpfox::getPhrase('poll.unable_to_find_this_poll'));
			}
			
			// insert new vote			
			$this->database()->insert(Phpfox::getT('poll_result'), array(
					'poll_id' => $iPoll,
					'answer_id' => $iAnswer,
					'user_id' => $iUser,
					'time_stamp' => PHPFOX_TIME
				)
			);
			
			// update the total votes field
			$bVotes = $this->database()->update(Phpfox::getT('poll_answer'), array('total_votes' => array('= total_votes +', 1)), 'answer_id = ' . $iAnswer);
			
			$sLink = Phpfox::permalink('poll', $aPoll['poll_id'], $aPoll['question']);
			
			Phpfox::getLib('mail')->to($aPoll['user_id'])
				->subject(array('poll.full_name_voted_on_your_poll_question', array('full_name' => Phpfox::getUserBy('full_name'), 'question' => $aPoll['question'])))
				->message(array('poll.full_name_voted_answer_on_your_poll_question', array('full_name' => Phpfox::getUserBy('full_name'), 'answer' => $aPoll['answer'], 'question' => $aPoll['question'], 'link' => $sLink)))
				->send();
				
			if (Phpfox::isModule('notification'))
			{
				Phpfox::getService('notification.process')->add('poll', $iPoll, $aPoll['user_id']);			
			}
			
			return true;
		}
	}
	
	/**
	 * Updates the default design of a poll, when polls are added they dont have a default design so 
	 * this function checks if they are updating or creating a new one
	 *
	 * @param integer $iUser user_id
	 * @param array $aPoll poll information
	 * @return boolean true = success
	 */
	public function updateDesign($iUser, $aPoll)
	{
		
		// first check if there are (due to DB compatibility we cannot use INSERT SET)
		$aExistingColors = $this->database()->select('pd.*')
			->from(Phpfox::getT('poll_design'),'pd')
			->where('pd.poll_id = ' . $aPoll['poll_id'])
			->execute('getSlaveRow');
		
		// if the colors have been set
		if (isset($aExistingColors['background']))
		{
			// we update
			$bColors = $this->database()->update(Phpfox::getT('poll_design'), array(
					'background' => "'".$aPoll['js_poll_background']."'",
					'percentage' => "'".$aPoll['js_poll_percentage']."'",
					'border' => "'".$aPoll['js_poll_border']."'"
				),'poll_id = ' . $aPoll['poll_id'], false
			);
			return $bColors;
		}
		else 
		{
			// we insert
			$iColors = $this->database()->insert(Phpfox::getT('poll_design'), array(
					'poll_id' => (int)$aPoll['poll_id'],
					'background' => isset($aPoll['js_poll_background']) ? $aPoll['js_poll_background'] : null,
					'percentage' => isset($aPoll['js_poll_percentage']) ? $aPoll['js_poll_percentage'] : null,
					'border' => isset($aPoll['js_poll_border']) ? $aPoll['js_poll_border'] : null
				)
			);
			return is_numeric($iColors);
		}
	}	

	/**
	 * Changes the text of a given answer
	 * @param integer $iId Answer identifier
	 * @param string $sTxt New text
	 */
	public function updateAnswer($iId, $sTxt)
	{
		Phpfox::getService('ban')->checkAutomaticBan($sTxt);
		$this->database()->update(Phpfox::getT('poll_answer'), array(
				'answer' => Phpfox::getLib('database')->escape($sTxt)
			), 'answer_id = ' . (int)$iId
		);
	}	
	
	/**
	 * Updates the counter of a poll views (increments)
	 *
	 * @param integer $iId Poll identifier
	 * @return true
	 */
	public function updateView($iId)
	{
		$this->database()->query('
			UPDATE ' . $this->_sTable . '
			SET total_view = total_view + 1
			WHERE poll_id = ' . (int) $iId . '
		');
		
		return true;
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
		if ($sPlugin = Phpfox_Plugin::get('poll.service_process__call'))
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
