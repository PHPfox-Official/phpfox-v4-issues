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
 * @version 		$Id: api.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class User_Service_Api extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('user');
		$this->_oApi = Phpfox::getService('api');
	}
	
	public function get()
	{
		/*
		@title
		@info Get information about a user.
		@method GET
		@extra user_id=#{User ID#|int|no}
		*/		
		
		return $this->getUser();
	}
	
	public function getUser()
	{
		if ((int) $this->_oApi->get('user_id') === 0)
		{
			$iUserId = $this->_oApi->getUserId();
		}
		else
		{
			$iUserId = $this->_oApi->get('user_id');
		}
		
		$sSelect = 'u.user_id, u.user_name, u.joined, u.user_image, u.gender, u.country_iso';
		
		// Check if user allowed access to get his full_name
		if ($this->_oApi->isAllowed('user.get_full_name'))
		{
			$sSelect .= ', u.full_name'; 
		}				
				
		if ($this->_oApi->isAllowed('user.get_email'))
		{
			$sSelect .= ', u.email';
		}		
		
		$aRow = $this->database()->select($sSelect)
			->from($this->_sTable, 'u')
			->where('u.user_id = ' . (int) $iUserId)
			->execute('getSlaveRow');
			
		if (!isset($aRow['user_id']))
		{
			return $this->_oApi->error('user.user_cannot_be_found', 'User cannot be found.');
		}
		
		$sImagePath = $aRow['user_image'];
		
		if ($this->_oApi->isAllowed('user.get_full_name'))
		{
			$aRow['full_name_link'] = '<a href="' . Phpfox::getLib('url')->makeUrl($aRow['user_name']) . '">' . $aRow['full_name'] . '</a>';
		}
		
		$aRow['photo_50px'] = Phpfox::getLib('image.helper')->display(array(
				'user' => $aRow,
				'suffix' => '_50',
				'return_url' => true
			)
		);
		
		$aRow['photo_50px_square'] = Phpfox::getLib('image.helper')->display(array(
				'user' => $aRow,
				'suffix' => '_50_square',
				'return_url' => true
			)
		);		
		
		$aRow['photo_120px'] = Phpfox::getLib('image.helper')->display(array(
				'user' => $aRow,
				'suffix' => '_120',
				'return_url' => true
			)
		);		
		
		$aRow['photo_original'] = Phpfox::getLib('image.helper')->display(array(
				'user' => $aRow,
				'suffix' => '',
				'return_url' => true
			)
		);		
		
		$aRow['photo_50px_link'] = Phpfox::getLib('image.helper')->display(array(
				'user' => $aRow,
				'suffix' => '_50',
				'target' => '_parent'
			)
		);
		
		$aRow['photo_50px_square_link'] = Phpfox::getLib('image.helper')->display(array(
				'user' => $aRow,
				'suffix' => '_50_square',
				'target' => '_parent'
			)
		);
		
		$aRow['photo_120px_link'] = Phpfox::getLib('image.helper')->display(array(
				'user' => $aRow,
				'suffix' => '_120',
				'target' => '_parent'
			)
		);
		
		$aRow['photo_original_link'] = Phpfox::getLib('image.helper')->display(array(
				'user' => $aRow,
				'suffix' => '',
				'target' => '_parent'
			)
		);		
		
		$aRow['gender'] = ($aRow['gender'] == '1' ? 'Male' : 'Female');
		$aRow['profile_url'] = Phpfox::getLib('url')->makeUrl($aRow['user_name']);
		
		unset($aRow['user_image']);

		return $aRow;
	}	
	
	/**
	 * This function updates the user status by adding a feed
	 */
	public function updateStatus()
	{
		/*
		@title
		@info Post a status update. Returns <b>true</b> on success, <b>false</b> on failure.
		@method POST
		@extra user_status=#{Status content|string|yes}
		*/		
		
		if ($this->_oApi->isAllowed('user.update_status') == false)
		{
			return $this->_oApi->error('user.not_allowed', 'Status updates not allowed for this user.');
		}
		$sStatus = $this->_oApi->get('user_status');
		if (empty($sStatus))
		{
			return $this->_oApi->error('user.status_is_empty', 'The variable user_status cannot be empty');
		}
		
		$iPrivacy = 0;
		
		$iStatusId = Phpfox::getService('user.process')->updateStatus(array(
				'user_status' => $this->_oApi->get('user_status'),
				'privacy' => $iPrivacy
			)
		);
		
		if (!$iStatusId)
		{
			return false;
		}
		
		return $this->status(Phpfox::getService('user.process')->getLastStatusId());
	}
	
	public function status($iLinkId = 0)
	{
		/*
		@title
		@info Get status updates from a user or a specific status update.
		@method POST
		@extra user_id=#{User ID#|int|no}&id=#{Status ID#|int|no}
		@return id=#{ID# of the status|int}&update=#{Status update content|string}&time_stamp=#{UNIX time stamp|int}&convert_time_stamp=#{User friendly time stamp|string}
		*/		
		
		if ((int) $this->_oApi->get('user_id') !== 0)
		{
			$iUserId = $this->_oApi->get('user_id');
		}		
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('user_status'), 'p')
			->where(($iLinkId > 0 ? 'p.status_id = ' . (int) $iLinkId : (isset($iUserId) ? 'p.user_id = ' . (int) $iUserId . ' AND ' : '') . ' p.privacy = 0'))
			->execute('getSlaveField');
		
		$this->_oApi->setTotal($iCnt);
		
		$iOffset = ($this->_oApi->get('page') * 10);
		
		if (Phpfox::isModule('like'))
		{
			$this->database()->select('lik.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'lik', 'lik.type_id = \'user_status\' AND lik.item_id = p.status_id AND lik.user_id = ' . Phpfox::getUserId());
		}

		$aRows = $this->database()->select('p.*, ' . Phpfox::getUserField())
			->from(Phpfox::getT('user_status'), 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->where(($iLinkId > 0 ? 'p.status_id = ' . (int) $iLinkId : (isset($iUserId) ? 'p.user_id = ' . (int) $iUserId . ' AND ' : '') . ' p.privacy = 0'))
			->limit($iOffset, 10)
			->order('p.time_stamp DESC')
			->execute('getSlaveRows');	

		$aUpdates = array();
		foreach ($aRows as $iKey => $aRow)
		{
			$aUpdates[$iKey] = Phpfox::getService('apps')->buildUser($aRow);
			$aUpdates[$iKey]['id'] = $aRow['status_id'];
			$aUpdates[$iKey]['update'] = Phpfox::getLib('parse.output')->parse($aRow['content']);
			$aUpdates[$iKey]['time_stamp'] = $aRow['time_stamp'];
			$aUpdates[$iKey]['convert_time_stamp'] = Phpfox::getLib('date')->convertTime($aRow['time_stamp'], 'comment.comment_time_stamp');
			$aUpdates[$iKey]['comments'] = $aRow['total_comment'];
			$aUpdates[$iKey]['likes'] = $aRow['total_like'];
			$aUpdates[$iKey]['is_liked'] = (empty($aRow['is_liked']) ? false : true);
		}
		
		if ($iLinkId > 0)
		{
			return $aUpdates[0];
		}
		
		return $aUpdates;
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
		if ($sPlugin = Phpfox_Plugin::get('user.service_api__call'))
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
