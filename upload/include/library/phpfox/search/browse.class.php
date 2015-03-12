<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Parent browse routine
 * Controls how we browse all the sectons on the site.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: browse.class.php 7264 2014-04-09 21:00:49Z Fern $
 */
class Phpfox_Search_Browse
{
	/**
	 * Item count.
	 * 
	 * @var int
	 */
	private $_iCnt = 0;
	
	/**
	 * ARRAY of items
	 * 
	 * @var array
	 */
	private $_aRows = array();
	
	/**
	 * ARRAY of params we are going to work with.
	 * 
	 * @var array
	 */
	private $_aParams = array();
	
	/**
	 * Service object for the specific module we are working with
	 * 
	 * @var object
	 */
	private $_oBrowse = null;
	
	/**
	 * Short access to the "view" request.
	 * 
	 * @var string
	 */
	private $_sView = '';
	
	/**
	 * Class constructor.
	 *
	 */
	public function __construct()
	{		
	}
	
	/**	 
	 * Set the params for the browse routine.
	 * 	 
	 * @param array	$aParams ARRAY of params.
	 * @return object Return self.
	 */
	public function params($aParams)
	{
		$this->_aParams = $aParams;
		$this->_aParams['service'] = $aParams['module_id'] . '.browse';
		
		$this->_oBrowse = Phpfox::getService($this->_aParams['service']);
		
		$this->_sView = Phpfox::getLib('request')->get('view');
		
		if ($this->_sView == 'friend')
		{
			Phpfox::isUser(true);
		}
		
		return $this;
	}
	
	/**
	 * 
	 * Execute the browse routine. Runs the SQL query.
	 */
	public function execute()
	{
		$aActualConditions = (array) $this->search()->getConditions();		
		
		list($sModule, $sService) = explode('.',$this->_aParams['service']);		
		if (Phpfox::isModule('input') && (isset($_SESSION[Phpfox::getParam('core.session_prefix')]['search'][$sModule][Phpfox::getLib('request')->get('search-id')]['input'])))
		{
			$aInputs = ($_SESSION[Phpfox::getParam('core.session_prefix')]['search'][$sModule][Phpfox::getLib('request')->get('search-id')]['input']);
			$aInputsToSearch = array();
			foreach ($aInputs as $iInputId => $mValue)
			{
				if (!is_numeric($iInputId) || $iInputId < 1) continue;
				$aInputsToSearch[$iInputId] = $mValue;
			}			
			$aJoins = Phpfox::getService('input')->getJoinsForSearch($aInputsToSearch, $sModule);					
			if (empty($aJoins))
			{
				$aJoins = array(0);
			}
			$aActualConditions[] = 'AND (' . $this->_aParams['alias'].'.' . $this->_aParams['field'] .' IN (' . implode(',',$aJoins) . '))';
		}
		
		$this->_aConditions = array();
		foreach ($aActualConditions as $sCond)
		{
			switch ($this->_sView)
			{
				case 'friend':
					$this->_aConditions[] = str_replace('%PRIVACY%', '0,1,2', $sCond);
					break;
				case 'my':
					$this->_aConditions[] = str_replace('%PRIVACY%', '0,1,2,3,4', $sCond);
					break;				
				case 'pages_member':
					$this->_aConditions[] = str_replace('%PRIVACY%', '0,1', $sCond);
					break;
				case 'pages_admin':
					$this->_aConditions[] = str_replace('%PRIVACY%', '0,1,2', $sCond);
					break;
				default:
					$this->_aConditions[] = str_replace('%PRIVACY%', '0', $sCond);
					break;
			}
		}		
		// testing:
		// $this->_aConditions = array_merge( (array)array_pop($this->_aConditions), (array)array_pop($this->_aConditions));
		// d($this->_aConditions);die();
		if (Phpfox::getParam('core.section_privacy_item_browsing') && (isset($this->_aParams['hide_view']) && !in_array($this->_sView, $this->_aParams['hide_view'])))
		{			
			Phpfox::getService('privacy')->buildPrivacy(array_merge($this->_aParams, array('count' => true)));			
				
			$this->_iCnt = $this->database()->joinCount('total_item')->execute('getSlaveField');		
		}
		else 
		{
			$this->_oBrowse->getQueryJoins(true);
			
			$this->_iCnt = $this->database()->select((isset($this->_aParams['distinct']) ? 'COUNT(DISTINCT ' . $this->_aParams['field'] . ')' : 'COUNT(*)'))
				->from($this->_aParams['table'], $this->_aParams['alias'])
				->where($this->_aConditions)
				//->limit($this->search()->getPage(), $this->search()->getDisplay())
				->execute('getSlaveField');
		}
		
		if ($this->_iCnt)
		{
			if (Phpfox::getParam('core.section_privacy_item_browsing') && (isset($this->_aParams['hide_view']) && !in_array($this->_sView, $this->_aParams['hide_view'])))
			{
				Phpfox::getService('privacy')->buildPrivacy($this->_aParams);
				
				$this->database()->unionFrom($this->_aParams['alias']);
			}
			else 
			{				
				$this->_oBrowse->getQueryJoins();
				
				$this->database()->from($this->_aParams['table'], $this->_aParams['alias'])->where($this->_aConditions);
			}		

			$this->_oBrowse->query();

			$this->_aRows = $this->database()->select($this->_aParams['alias'] . '.*, ' . (isset($this->_aParams['select']) ? $this->_aParams['select'] : '') . Phpfox::getUserField())
				->join(Phpfox::getT('user'), 'u', 'u.user_id = ' . $this->_aParams['alias'] . '.user_id')
				->order($this->search()->getSort())
				->limit($this->search()->getPage(), $this->search()->getDisplay(), $this->_iCnt, false, false)
				->execute('getSlaveRows');
			
			if ($this->search()->getPage() > 0 && count($this->_aRows) < 1)
			{
				Phpfox::getLib('url')->send('error.404');
			}
			
			if (method_exists($this->_oBrowse, 'processRows'))
			{
				$this->_oBrowse->processRows($this->_aRows);
			}
		}
		else if ($this->search()->getPage() > 0)
		{
			Phpfox::getLib('url')->send('error.404');
		}
					
	}
	
	/**
	 * Gets the count.
	 * 
	 * @return int Total items.
	 */
	public function getCount()
	{
		return (int) $this->_iCnt;
	}
	
	/**
	 * Get items
	 * 
	 * @return array ARRAY of items.
	 */
	public function getRows()
	{
		return (array) $this->_aRows;
	}
	
	/**
	 * Extends database class
	 * 
	 * @see Phpfox_Database
	 * @return object Returns database object
	 */
	public function database()
	{
		return Phpfox::getLib('database');
	}
	
	/**
	 * Extends search class
	 * 
	 * @see Phpfox_Search
	 * @return object Returns the search object
	 */
	public function search()
	{
		return Phpfox::getLib('search');
	}
	
	/**
	 * Reset the search
	 *
	 */
	public function reset()
	{
		$this->_aRows = array();
		$this->_iCnt = 0;
		$this->_aConditions = array();
		$this->_aParams = array();
		
		Phpfox::getLib('search')->reset();
	}
}

?>
