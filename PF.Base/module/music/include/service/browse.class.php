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
 * @version 		$Id: browse.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Music_Service_Browse extends Phpfox_Service 
{	
	private $_aConditions = array();
	
	private $_iCnt = 0;
	
	private $_iPage = 0;
	
	private $_iPageSize = 25;
	
	private $_sOrder = 'u.joined DESC';
	
	private $_aRows = array();
	
	private $_sGenre = null;	
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('user');
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
	
	public function genre($sGenre)
	{
		if ($sGenre != 'browse')
		{
			$this->_sGenre = $sGenre;
		}
		
		return $this;
	}

	public function order($sOrder)
	{
		$this->_sOrder = $sOrder;
		
		return $this;
	}	

	public function execute()
	{
		if ($this->_sGenre !== null)
		{		
			$this->database()				
				->join(Phpfox::getT('music_genre'), 'mg', 'mg.name_url = \'' . $this->database()->escape($this->_sGenre) . '\'')
				->join(Phpfox::getT('music_genre_user'), 'mgu', 'mgu.user_id = u.user_id AND mgu.genre_id = mg.genre_id');			
		}		
		
		$this->_iCnt = $this->database()->select(($this->_sGenre !== null ? 'COUNT(*)' : 'COUNT(*)'))
			->from($this->_sTable, 'u')
			->where($this->_aConditions)
			->execute('getSlaveField');
			
		if ($this->_iCnt)
		{
			if ($this->_sGenre !== null)
			{			
				$this->database()
					->select('mg.name AS genre_name, ')		
					->join(Phpfox::getT('music_genre'), 'mg', 'mg.name_url = \'' . $this->database()->escape($this->_sGenre) . '\'')
					->join(Phpfox::getT('music_genre_user'), 'mgu', 'mgu.user_id = u.user_id AND mgu.genre_id = mg.genre_id');
			}			
			
			$aRows = $this->database()->select(Phpfox::getUserField() . ', u.country_iso')
				->from($this->_sTable, 'u')
				->where($this->_aConditions)
				->order($this->_sOrder)
				->limit($this->_iPage, $this->_iPageSize, $this->_iCnt)
				->execute('getSlaveRows');
			
			$sUserIds = '';
			foreach ($aRows as $aRow)
			{
				$this->_aRows[$aRow['user_id']] = $aRow;
				
				$sUserIds .= $aRow['user_id'] . ',';
			}
			$sUserIds = rtrim($sUserIds, ',');
			
			$aGenres = $this->database()->select('mg.name, mg.name_url, mgu.user_id')
				->from(Phpfox::getT('music_genre_user'), 'mgu')
				->join(Phpfox::getT('music_genre'), 'mg', 'mg.genre_id = mgu.genre_id')
				->where('mgu.user_id IN(' . $sUserIds . ')')
				->execute('getSlaveRows');
				
			foreach ($aGenres as $aGenre)
			{
				$this->_aRows[$aGenre['user_id']]['genres'][] = $aGenre;
			}
		}		
	}	
		
	public function get()
	{
		return $this->_aRows;
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
		if ($sPlugin = Phpfox_Plugin::get('music.service_browse__call'))
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