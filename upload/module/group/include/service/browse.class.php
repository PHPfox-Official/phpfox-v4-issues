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
 * @version 		$Id: browse.class.php 1549 2010-04-14 10:42:27Z Miguel_Espinoza $
 */
class Group_Service_Browse extends Phpfox_Service 
{	
	private $_aConditions = array();
	
	private $_iCnt = 0;
	
	private $_iPage = 0;
	
	private $_iPageSize = 25;
	
	private $_sOrder = 'm.is_featured DESC, m.time_stamp DESC';
	
	private $_aGroups = array();
	
	private $_sCategory = null;
	
	private $_iMember = null;	
	
	private $_iUserId = null;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('group');
	}
	
	public function condition($aConditions)
	{
		$this->_aConditions = $aConditions;
		
		return $this;
	}
	
	public function page($iPage)
	{
		$this->_iPage = $iPage;
		
		return $this;
	}
	
	public function size($iPageSize)
	{
		$this->_iPageSize = $iPageSize;
		
		return $this;
	}
	
	public function category($sCategory)
	{
		$this->_sCategory = $sCategory;
		
		return $this;
	}
	
	public function member($iAttending)
	{
		$this->_iMember = $iAttending;
		
		return $this;
	}	
	
	public function user($iUser)
	{
		$this->_iUserId = $iUser;
		
		return $this;
	}
	
	public function order($sOrder)
	{		
		if ($sOrder != 'm.time_stamp DESC')
		{		
			$this->_sOrder = $sOrder;
		}
		return $this;
	}

	public function execute()
	{
		if ($this->_sCategory !== null)
		{
			$sCategories = Phpfox::getService('group.category')->getAllCategories($this->_sCategory);
		
			$this->database()->innerJoin(Phpfox::getT('group_category_data'), 'mcd', 'mcd.group_id = m.group_id');
			
			$this->_aConditions[] = ' AND mcd.category_id IN(' . $sCategories . ')';
		}
		
		if ($this->_iMember !== null)
		{
			$this->database()->join(Phpfox::getT('group_invite'), 'ei', 'ei.group_id = m.group_id AND ei.member_id = ' . (int) $this->_iMember . ' AND ei.invited_user_id = ' . ($this->_iUserId !== null ? (int) $this->_iUserId : Phpfox::getUserId()));
		}
		
		$this->_iCnt = $this->database()->select(($this->_sCategory !== null ? 'COUNT(DISTINCT m.group_id)' : 'COUNT(*)'))
			->from($this->_sTable, 'm')
			->where($this->_aConditions)
			->execute('getSlaveField');
			
		if ($this->_iCnt)
		{
			if ($this->_sCategory !== null)
			{			
				$this->database()->innerJoin(Phpfox::getT('group_category_data'), 'mcd', 'mcd.group_id = m.group_id')->group('m.group_id');
			}
			
			if ($this->_iMember !== null)
			{
				$this->database()->select('ei.member_id, ')->join(Phpfox::getT('group_invite'), 'ei', 'ei.group_id = m.group_id AND ei.member_id = ' . (int) $this->_iMember . ' AND ei.invited_user_id = ' . ($this->_iUserId !== null ? (int) $this->_iUserId : Phpfox::getUserId()));
			}
			else 
			{
				$this->database()->select('ei.member_id, ')->leftJoin(Phpfox::getT('group_invite'), 'ei', 'ei.group_id = m.group_id AND ei.invited_user_id = ' . Phpfox::getUserId());
			}
			
			$aGroups = $this->database()->select('m.*, ' . Phpfox::getUserField())
				->from($this->_sTable, 'm')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = m.user_id')
				->where($this->_aConditions)
				->order($this->_sOrder)
				->group('m.group_id')
				->limit($this->_iPage, $this->_iPageSize, $this->_iCnt)				
				->execute('getSlaveRows');
				
			foreach ($aGroups as $aGroup)
			{				
				$aGroup['breadcrumb'] = Phpfox::getService('group.category')->getCategoriesById($aGroup['group_id']);				
				$aGroup['group_url'] = Phpfox::getLib('url')->makeUrl('group', array($aGroup['title_url'], 'member'));
				
				$this->_aGroups[] = $aGroup;
			}
		}		
	}	
		
	public function get()
	{
		return $this->_aGroups;
	}

	public function getCount()
	{
		return $this->_iCnt;
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
		if ($sPlugin = Phpfox_Plugin::get('group.service_browse__call'))
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