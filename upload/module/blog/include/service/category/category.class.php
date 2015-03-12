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
 * @package  		Module_Blog
 * @version 		$Id: category.class.php 3917 2012-02-20 18:21:08Z Raymond_Benc $
 */
class Blog_Service_Category_Category extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('blog_category');
	}
	
	public function isPrivateCategory($sTxt, $iUserId)
	{
		return (int) $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where("name = '" . $this->database()->escape($sTxt) . "' AND user_id = " . $iUserId . "")
			->execute('getSlaveField');
	}	
	
	public function getCategory($iId)
	{
		$aCategory = $this->database()->select('*')
			->from(Phpfox::getT('blog_category'))
			->where('category_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		return (isset($aCategory['category_id']) ? $aCategory : false);
	}	
	
	public function prepareTitle($sTitle, $iUserId, $bCleanOnly = false)
	{
		static $aTitle = array();
		
		if (isset($aTitle[$sTitle]))
		{
			return $aTitle[$sTitle];
		}		
		
		$sNewTitle = Phpfox::getLib('parse.input')->cleanTitle($sTitle);	

		if ($bCleanOnly)
		{
			return $sNewTitle;
		}
			
		$aOlds = $this->database()->select('name_url')
			->from($this->_sTable)
			->where("user_id = " . (int) $iUserId . " AND name_url LIKE '" . $this->database()->escape($sNewTitle) . "%'")
			->execute('getRows');			

		$iTotal = 0;
		$aNumbers = array();
		foreach ($aOlds as $aOld)
		{			
			if (preg_match("/(.*)-([0-9])/i", $aOld['name_url'], $aMatches))
			{
				$aNumbers[] = $aMatches[2];				
			}
			
			if ($aOld['name_url'] === $sNewTitle)
			{
				$aNumbers[] = $sNewTitle;
			}
		}		
		
		if (count($aNumbers))
		{
			arsort($aNumbers);
			$iTotal = (count($aNumbers) + 1);
		}

		$aTitle[$sTitle] =  $sNewTitle . ($iTotal > 0 ? '-' . $iTotal : '');

		return $aTitle[$sTitle];
	}	
	
	public function get($aConds, $sSort = 'c.name ASC', $iPage = '', $iLimit = '')
	{		
		(($sPlugin = Phpfox_Plugin::get('blog.service_category_category_get_start')) ? eval($sPlugin) : false);
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('blog_category'), 'c')
			->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = c.user_id')
			->where($aConds)
			->order($sSort)
			->execute('getSlaveField');	
			
		$aItems = array();
		if ($iCnt)
		{		
			$aItems = $this->database()->select('c.*, ' . Phpfox::getUserField())
				->from(Phpfox::getT('blog_category'), 'c')
				->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = c.user_id')
				->where($aConds)
				->order($sSort)
				->limit($iPage, $iLimit, $iCnt)
				->execute('getSlaveRows');
				
			foreach ($aItems as $iKey => $aItem)
			{
				$aItems[$iKey]['link'] = ($aItem['user_id'] ? Phpfox::getLib('url')->permalink($aItem['user_name'] . '.blog.category', $aItem['category_id'], $aItem['name']) : Phpfox::getLib('url')->permalink('blog.category', $aItem['category_id'], $aItem['name']));
			}
		}
			
		(($sPlugin = Phpfox_Plugin::get('blog.service_category_category_get_end')) ? eval($sPlugin) : false);
		
		return array($iCnt, $aItems);
	}
	
	public function addCategoryForBlog($iBlogId, $aCategories, $bUpdateUsageCount = true)
	{
		if (count($aCategories))
		{
			$aCache = array();
			foreach ($aCategories as $iKey => $iId)
			{
				if (!is_numeric($iId))
				{
					continue;
				}
				
				if (isset($aCache[$iId]))
				{
					continue;
				}
				
				$aCache[$iId] = true;
				
				$this->database()->insert(Phpfox::getT('blog_category_data'), array('blog_id' => $iBlogId, 'category_id' => $iId));				
				if ($bUpdateUsageCount === true)
				{
					$this->database()->updateCount('blog_category_data', 'category_id = ' . (int) $iId, 'used', 'blog_category', 'category_id = ' . (int) $iId);
				}
			}			
		}		
	}
	
	public function updateCategoryForBlog($iBlogId, $aCategories, $bUpdateUsageCount)
	{
		$aRows = $this->database()->select('category_id')
			->from(Phpfox::getT('blog_category_data'))
			->where('blog_id = ' . (int) $iBlogId)
			->execute('getRows');		
					
		if (count($aRows))
		{
			foreach ($aRows as $aRow)
			{				
				$this->database()->delete(Phpfox::getT('blog_category_data'), "blog_id = " . (int) $iBlogId . " AND category_id = " . (int) $aRow["category_id"]);
				
				$this->database()->query("
					UPDATE " . Phpfox::getT('blog_category') . "
					SET used = used - 1
					WHERE category_id = " . $aRow["category_id"] . "
				");
			}			
		}		

		$this->addCategoryForBlog($iBlogId, $aCategories, $bUpdateUsageCount);			
	}
	
	public function getCategories($aConds, $sSort = 'c.name ASC')
	{		
		(($sPlugin = Phpfox_Plugin::get('blog.service_category_category_getcategories_start')) ? eval($sPlugin) : false);
		
		$aItems = $this->database()->select('c.category_id, c.name, c.name, c.user_id')
			->from(Phpfox::getT('blog_category'), 'c')
			->where($aConds)
			->group('c.category_id')
			->order($sSort)
			->execute('getSlaveRows');			
			
		(($sPlugin = Phpfox_Plugin::get('blog.service_category_category_getcategories_end')) ? eval($sPlugin) : false);
		
		return $aItems;
	}
	
	public function getCategoriesById($sId)
	{		
		if (!$sId)
		{
			return array();
		}		
		
		$aItems = $this->database()->select('d.blog_id, d.category_id, c.name AS category_name, c.user_id')
			->from(Phpfox::getT('blog_category_data'), 'd')
			->join(Phpfox::getT('blog_category'), 'c', 'd.category_id = c.category_id')
			->where("d.blog_id IN(" . $sId . ")")			
			->execute('getSlaveRows');
		
		$aCategories = array();
		foreach ($aItems as $aItem)
		{
			$aCategories[$aItem['blog_id']][] = $aItem;
		}

		return $aCategories;
	}
	
	public function getBlogsByCategory($sName, $iUserId, $aConds = array(), $sSort = '', $iPage = '', $sLimit = '')
	{
		$aConds = array_merge(array("AND blog_category.user_id = " . (int) $iUserId), $aConds);
		$aConds = array_merge(array("AND (blog_category.category_id = " . $sName . " OR blog_category.name = '" . $this->database()->escape($sName) . "') "), $aConds); 
		
		$aItems = array();		
		(($sPlugin = Phpfox_Plugin::get('blog.service_category_category_getblogsbycategory_count')) ? eval($sPlugin) : false);
		$iCnt = $this->database()->select('COUNT(DISTINCT blog.blog_id)')
			->from(Phpfox::getT('blog'), 'blog')
			->innerJoin(Phpfox::getT('blog_category_data'), 'blog_category_data', 'blog_category_data.blog_id = blog.blog_id')
			->innerJoin(Phpfox::getT('blog_category'), 'blog_category', 'blog_category.category_id = blog_category_data.category_id')
			->where($aConds)
			->execute('getSlaveField');			

		if ($iCnt)
		{			
			(($sPlugin = Phpfox_Plugin::get('blog.service_category_category_getblogsbycategory_query')) ? eval($sPlugin) : false);
			$aItems = $this->database()->select("blog.*, " . (Phpfox::getParam('core.allow_html') ? "blog_text.text_parsed" : "blog_text.text") ." AS text, blog_category.category_id AS category_id, blog_category.name AS category_name, " . Phpfox::getUserField())
				->from(Phpfox::getT('blog'), 'blog')
				->innerJoin(Phpfox::getT('blog_category_data'), 'blog_category_data', 'blog_category_data.blog_id = blog.blog_id')
				->innerJoin(Phpfox::getT('blog_category'), 'blog_category', 'blog_category.category_id = blog_category_data.category_id')
				->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id')
				->join(Phpfox::getT('user'), 'u', 'blog.user_id = u.user_id')
				->where($aConds)
				->order($sSort)
				->group('blog.blog_id')
				->limit($iPage, $sLimit, $iCnt)
				->execute('getSlaveRows');				
		}		

		return array($iCnt, $aItems);
	}
	
	public function getSearch($aConds, $sSort)
	{		
		(($sPlugin = Phpfox_Plugin::get('blog.service_category_category_getsearch')) ? eval($sPlugin) : false);
		$aRows = $this->database()->select('blog.blog_id')
			->from(Phpfox::getT('blog'), 'blog')
			->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id')
			->innerJoin(Phpfox::getT('blog_category_data'), 'blog_category_data', 'blog_category_data.blog_id = blog.blog_id')
			->innerJoin(Phpfox::getT('blog_category'), 'blog_category', 'blog_category.category_id = blog_category_data.category_id')
			->where($aConds)
			->order($sSort)
			->execute('getSlaveRows');		
			
		$aSearchIds = array();
		foreach ($aRows as $aRow)
		{
			$aSearchIds[] = $aRow['blog_id'];
		}	
		
		return $aSearchIds;
	}

	public function canAdd()
	{
		$iLimit = Phpfox::getUserParam('blog.blog_category_limit');
		
		if ($iLimit == '0')
		{
			return false;
		}
		
		if ($iLimit == 'null')
		{
			return true;
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('user_id = ' . Phpfox::getUserId())
			->execute('getField');
			
		if ($iCnt < $iLimit)
		{
			return true;
		}
		
		return false;
	}
	
	public function delete($iId)
	{
		$aRow = $this->database()->select('category_id, user_id')
			->from($this->_sTable)
			->where('category_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aRow['category_id']))
		{
			return false;
		}
		
		if (($aRow['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('blog.can_delete_own_blog_category')) || Phpfox::getUserParam('blog.can_delete_other_blog_category'))
		{				
			$this->database()->delete($this->_sTable, 'category_id = ' . (int) $aRow['category_id']);
			$this->database()->delete(Phpfox::getT('blog_category_data'), 'category_id = ' . (int) $aRow['category_id']);		
			
			return true;
		}
		
		return false;
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
		if ($sPlugin = Phpfox_Plugin::get('blog.service_category_category__call'))
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