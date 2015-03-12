<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Service class that retrives and creates public categories
 * for the photo section.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: category.class.php 6000 2013-06-05 09:41:07Z Miguel_Espinoza $
 */
class Photo_Service_Category_Category extends Phpfox_Service 
{
	private $_aCategories = array();
	
	private $_iCnt = 0;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('photo_category');	
	}
	
	public function getCategory($iId)
	{
		return $this->database()->select('pc.*, pc2.name AS parent_name')
			->from($this->_sTable, 'pc')
			->leftJoin($this->_sTable, 'pc2', 'pc2.category_id = pc.parent_id')
			->where('pc.category_id = ' . (int) $iId)
			->execute('getRow');
	}
	public function getCategoryId($sName)
	{
		return $this->database()->select('category_id')
			->from($this->_sTable)
			->where('name_url = "' . $this->database()->escape($sName) . '"')
			->execute('getSlaveField');
	}
	
	public function getPhotos($sCategory, $mConditions = array(), $sOrder = 'p.time_stamp DESC', $iPage = '', $iPageSize = '', $aCallback = null)
	{
		$sCategories = $this->getAllCategories($sCategory);
		
		if (empty($sCategories))
		{
			return array(0, array());
		}		
		
		$mConditions[] = ' AND pcd.category_id IN(' . $sCategories . ')';
			
		$aPhotos = array();
		$iCnt = $this->database()->select('COUNT(DISTINCT p.photo_id)')
			->from(Phpfox::getT('photo'), 'p')
			->innerJoin(Phpfox::getT('photo_category_data'), 'pcd', 'pcd.photo_id = p.photo_id')
			->where($mConditions)
			->execute('getSlaveField');
		
		if ($iCnt)
		{
			$aPhotos = $this->database()->select('p.*, pcd.category_id, pa.name_url AS album_url, ' . Phpfox::getUserField())
				->from(Phpfox::getT('photo'), 'p')
				->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
				->innerJoin(Phpfox::getT('photo_category_data'), 'pcd', 'pcd.photo_id = p.photo_id')						
				->leftJoin(Phpfox::getT('photo_album'), 'pa', 'pa.album_id = p.album_id')
				->where($mConditions)
				->order($sOrder)
				->limit($iPage, $iPageSize, $iCnt)
				->group('p.photo_id')
				->execute('getSlaveRows');	
				
			$oUrl = Phpfox::getLib('url');
			foreach ($aPhotos as $iKey => $aPhoto)
			{
				$aPhotos[$iKey]['link'] = ($aCallback === null ? ($aPhoto['album_id'] ? $oUrl->makeUrl($aPhoto['user_name'], array('photo', $aPhoto['album_url'], $aPhoto['title_url'])) : $oUrl->makeUrl($aPhoto['user_name'], array('photo', 'view', $aPhoto['title_url']))) : $oUrl->makeUrl($aCallback['url_home'], array('view', $aPhoto['title_url'])));
			}				
		}		

		return array($iCnt, $aPhotos);
	}
	
	public function getAllCategories($sCategory)
	{
		$sCacheId = $this->cache()->set('photo_category_parent_' . $sCategory);
		
		if (!($sCategories = $this->cache()->get($sCacheId)))
		{
			$iCategory = $this->database()->select('category_id')
				->from($this->_sTable)
				->where('category_id = ' . (int) $sCategory)
				->execute('getField');
			
			$sCategories = $this->_getIds($sCategory);
			$sCategories = rtrim($iCategory . ',' . ltrim($sCategories, $iCategory . ','), ',');
			
			$this->cache()->save($sCacheId, $sCategories);
		}

		return $sCategories;	
	}
	
	public function getCategoryName($sCategory)
	{
		return $this->database()->select('name')
			->from($this->_sTable)
			->where('name_url = \'' . $this->database()->escape($sCategory) . '\'')
			->execute('getField');		
	}
	
	public function getParentCategories($sCategory)
	{
		$sCacheId = $this->cache()->set('photo_category_parent_extend_' . $sCategory);
		
		if (!($sCategories = $this->cache()->get($sCacheId)))
		{
			$iCategory = $this->database()->select('category_id')
				->from($this->_sTable)
				->where('category_id = \'' . (int) $sCategory . '\'')
				->execute('getField');
			
			$sCategories = $this->_getParentIds($iCategory);

			$sCategories = rtrim($sCategories, ',');
			
			$this->cache()->save($sCacheId, $sCategories);
		}

		return $sCategories;	
	}	
	
	public function getParentBreadcrumb($sCategory)
	{		
		$sCacheId = $this->cache()->set('photo_parent_breadcrumb_' . md5($sCategory));
		if (!($aBreadcrumb = $this->cache()->get($sCacheId)))
		{		
			$sCategories = $this->getParentCategories($sCategory);
			
			$aCategories = $this->database()->select('*')
				->from($this->_sTable)
				->where('category_id IN(' . $sCategories . ')')
				->execute('getRows');
			
			$aBreadcrumb = $this->getCategoriesByIdExtended(null, $aCategories);
			
			$this->cache()->save($sCacheId, $aBreadcrumb);
		}		
		
		return $aBreadcrumb;
	}	
	
	public function getCategoriesByIdExtended($iId = null, &$aCategories = null)
	{
		return $this->getCategoriesById($iId, $aCategories);
		/*
		$oUrl = Phpfox::getLib('url');		

		if (!count($aCategories))
		{
			return null;
		}
		
		$aBreadcrumb = array();		
		if (count($aCategories) > 1)
		{			
			foreach ($aCategories as $aCategory)
			{				
				if ($aCategory['parent_id'] > 0)
				{
					$aParts = explode('/', $this->_getParentsUrl($aCategory['parent_id'], true));
					$aParts = array_reverse($aParts);					
					$aCache = array();				
					foreach ($aParts as $sPart)
					{
						if (empty($sPart))
						{
							continue;
						}
						$aPart = explode('|', $sPart);
						$aCache[] = $aPart[0];
					}	
					$aCache[] = $aCategory['name_url'];
					
					$aBreadcrumb[] = array(Phpfox::getLib('locale')->convert($aCategory['name']), Phpfox::getLib('url')->makeUrl('photo', $aCache));
				}				
				else 
				{
					$aBreadcrumb[] = array(Phpfox::getLib('locale')->convert($aCategory['name']), Phpfox::getLib('url')->makeUrl('photo', $aCategory['name_url']));
				}				
			}
		}		
		else 
		{			
			$aBreadcrumb[] = array(Phpfox::getLib('locale')->convert($aCategories[0]['name']), Phpfox::getLib('url')->makeUrl('photo', $aCategories[0]['name_url']));
		}
		
		return $aBreadcrumb;*/
	}		
	
	public function getCategoriesById($iId, &$aCategories = null)
	{
		$oUrl = Phpfox::getLib('url');
		
		if ($aCategories === null)
		{
			$aCategories = $this->database()->select('pc.parent_id, pc.category_id, pc.name')
				->from(Phpfox::getT('photo_category_data'), 'pcd')
				->join($this->_sTable, 'pc', 'pc.category_id = pcd.category_id')
				->where('pcd.photo_id = ' . (int) $iId)
				->order('pc.parent_id ASC, pc.ordering ASC')
				->execute('getSlaveRows');
		}

		if (!count($aCategories))
		{
			return null;
		}
		
		$aBreadcrumb = array();		
		if (count($aCategories) > 1)
		{			
			foreach ($aCategories as $aCategory)
			{				
				$aBreadcrumb[] = array(Phpfox::getLib('locale')->convert($aCategory['name']), Phpfox::permalink('photo.category', $aCategory['category_id'], $aCategory['name']), 'category_id' => $aCategory['category_id']);
			}
		}		
		else 
		{			
			$aBreadcrumb[] = array(Phpfox::getLib('locale')->convert($aCategories[0]['name']), Phpfox::permalink('photo.category', $aCategories[0]['category_id'], $aCategories[0]['name']), 'category_id' => $aCategories[0]['category_id']);
		}
		
		return $aBreadcrumb;		
		
		/*
		$oUrl = Phpfox::getLib('url');
		$aCategories = $this->database()->select('pc.parent_id, pc.category_id, pc.name, pc.name_url')
			->from(Phpfox::getT('photo_category_data'), 'pcd')
			->join($this->_sTable, 'pc', 'pc.category_id = pcd.category_id')
			->where('pcd.photo_id = ' . (int) $iId)
			->execute('getSlaveRows');

		$sGroup = '';
		if (defined('PHPFOX_GROUP_VIEW') && PHPFOX_GROUP_VIEW){
				$sGroup = 'group.'.Phpfox::getLib('request')->get('req2').'.';
		}
		
		if (!count($aCategories))
		{
			return null;
		}
		
		$this->_aCategories[$iId] = '';
		if (count($aCategories) > 1)
		{			
			$sCategory = '';
			foreach ($aCategories as $aCategory)
			{				
				if ($aCategory['parent_id'] > 0)
				{
					$aParts = explode('/', $this->_getParentsUrl($aCategory['parent_id'], true));
					$aParts = array_reverse($aParts);					
					$aCache = array();				
					foreach ($aParts as $sPart)
					{
						if (empty($sPart))
						{
							continue;
						}
						$aPart = explode('|', $sPart);
						$aCache[] = $aPart[0];
					}	
					$aCache[] = $aCategory['name_url'];
					$sCategory .= '<a href="' . $oUrl->makeUrl($sGroup .'photo', $aCache) . '">' . Phpfox::getLib('locale')->convert($aCategory['name']) . '</a> <br />' . "\n";
				}				
				else 
				{
					$sCategory .= '<a href="' . $oUrl->makeUrl($sGroup . 'photo', $aCategory['name_url']) . '">' . Phpfox::getLib('locale')->convert($aCategory['name']) . '</a> <br />' . "\n";
				}
				$this->_aCategories[$iId] .= $aCategory['category_id'] . ',';
			}
		}		
		else 
		{	
			$sCategory = '<a href="' . $oUrl->makeUrl($sGroup .'photo', $aCategories[0]['name_url']) . '">' . Phpfox::getLib('locale')->convert($aCategories[0]['name']) . '</a>';
			$this->_aCategories[$iId] = $aCategories[0]['category_id'];
		}
		
		return $sCategory;
		*/
	}
	
	public function getCategoryIds($iId)
	{
		return (isset($this->_aCategories[$iId]) ? $this->_aCategories[$iId] : false);
	}
	
	public function hasCategories($bAnchor = false, $bDropDown = true)
	{
		$mCategories = $this->get($bAnchor, $bDropDown);
		
		return ((is_array($mCategories) || (is_string($mCategories) && !empty($mCategories))) ? true : false);
	}
	
	/**
	 * Gets all the categories and caches them with HTML already built into it.
	 *
	 * @return string HTML categories.
	 */
	public function get($bAnchor = true, $bDropDown = false)
	{		
		$sCacheId = $this->cache()->set('photo_category_html' . ($bDropDown ? '_drop' : ($bAnchor === true ? '_anchor' : '')));		
		if (!($sCategories = $this->cache()->get($sCacheId)))
		{
			$sCategories = $this->_get(0, $bAnchor, $bDropDown);
			$this->cache()->save($sCacheId, $sCategories);
		}

		return $sCategories;
	}
	
	public function getForEdit()
	{
		return $this->database()->select('pc.*')
			->from($this->_sTable, 'pc')
			->execute('getRows');
	}

	/**
	 * Gets the categories and subcategories (if available) in an array to use with the core.block.category
	 * template
	 * @param string|null $sParent
	 */
	public function getForBrowse($iCategoryId = null, $sIsRatingArea = null)
	{
		$sCacheId = $this->cache()->set('photo_category_browse_' . ($iCategoryId === null ? '' : '_' . $iCategoryId) . (empty($sIsRatingArea) ? '' : '_' . $sIsRatingArea));
	 	if (!($aCategories = $this->cache()->get($sCacheId)))
		{					
			$aCategories = $this->database()->select('mc.category_id, mc.name')
				->from($this->_sTable, 'mc')
				->where('mc.parent_id = ' . ($iCategoryId === null ? '0' : (int) $iCategoryId) . '')
				->order('mc.ordering ASC')
				->execute('getRows');
			
			foreach ($aCategories as $iKey => $aCategory)
			{
				if ($sIsRatingArea === null)
				{
					$aCategories[$iKey]['url'] = Phpfox::permalink('photo.category', $aCategory['category_id'], $aCategory['name']);
				}
				else 
				{
					$aCategories[$iKey]['url'] = Phpfox::permalink('photo.' . $sIsRatingArea . '.category', $aCategory['category_id'], $aCategory['name']);
				}
				
				//if ($sCategory === null)
				{
					$aCategories[$iKey]['sub'] = $this->database()->select('mc.category_id, mc.name')
						->from($this->_sTable, 'mc')
						->where('mc.parent_id = ' . $aCategory['category_id'] . '')
						->order('mc.ordering ASC')
						->execute('getRows');			
						
					foreach ($aCategories[$iKey]['sub'] as $iSubKey => $aSubCategory)
					{
						if ($sIsRatingArea === null)
						{
							$aCategories[$iKey]['sub'][$iSubKey]['url'] = Phpfox::permalink('photo.category', $aSubCategory['category_id'], $aSubCategory['name']);
						}
						else 
						{
							$aCategories[$iKey]['sub'][$iSubKey]['url'] = Phpfox::permalink('photo.' . $sIsRatingArea . '.category', $aSubCategory['category_id'], $aSubCategory['name']);
						}
					}
				}
			}
			
			$this->cache()->save($sCacheId, $aCategories);
		}
		
		return $aCategories;	
	}

	/**
	 * Gets categories based on their parent ID#.
	 *
	 * @param int $iParentId Category ID#.
	 * 
	 * @return string HTML categories.
	 */
	public function _get($iParentId, $bAnchor = true, $bDropDown = false)
	{		
		if ($bAnchor === false)
		{		
			static $iCount = 0;
			
			$iCount++;
		}
		
		$aCategories = $this->database()->select('pc.name, pc.name_url, pc.category_id, pc.parent_id')
			->from($this->_sTable, 'pc')
			->where('pc.parent_id = ' . (int) $iParentId)
			->order('pc.ordering ASC')
			->execute('getRows');
			
		if (!count($aCategories))
		{
			return '';
		}
			
		if ($iParentId != 0)
		{
			$this->_iCnt++;	
		}			
						
		$sCategories = ($bDropDown ? '' : '<ul>');
		foreach ($aCategories as $aCategory)
		{
			$mUrl = $aCategory['name_url'];
			if (!empty($aCategory['parent_id']))
			{
				$aParts = explode('/', $this->_getParentsUrl($aCategory['parent_id']));
				$aParts = array_reverse($aParts);
				$mUrl = array();
				foreach ($aParts as $sPart)
				{
					if (empty($sPart))
					{
						continue;
					}
					$mUrl[] = $sPart;
				}
				$mUrl[] = $aCategory['name_url'];
			}	
			
			if ($bDropDown)
			{
				$sCategories .= '<option class="js_photo_category_' . $aCategory['category_id'] . '" value="' . $aCategory['category_id'] . '">' . ($this->_iCnt > 0 ? str_repeat('&nbsp;', ($this->_iCnt * 2)) . ' ' : '') . Phpfox::getLib('locale')->convert($aCategory['name']) . '</option>';
				$sCategories .= $this->_get($aCategory['category_id'], false, true);
			}
			else 
			{
				if ($bAnchor === true)
				{
					$sCategories .= '<li><a href="' . Phpfox::getLib('url')->makeUrl('photo', $mUrl) . '" class="js_photo_category" id="js_photo_category_' . $aCategory['category_id'] . '">' . Phpfox::getLib('locale')->convert($aCategory['name']) . '</a>' . $this->_get($aCategory['category_id'], $bAnchor) . '</li>';
				}
				else 
				{
					$sCategories .= '<li><img src="' . Phpfox::getLib('template')->getStyle('image', 'misc/draggable.png') . '" alt="" /> <span class="js_photo_category" id="js_sortable_category_' . $aCategory['category_id'] . '">' . Phpfox::getLib('locale')->convert($aCategory['name']) . '</span>' . $this->_get($aCategory['category_id'], $bAnchor) . '</li>';				
				}
			}
		}
		$sCategories .= ($bDropDown ? '' : '</ul>');	
		
		$this->_iCnt = 0;
		
		return $sCategories;
	}	

	/**
	 * Given an array of categories (which may have sub-categories) this function
	 * returns a one-dimensional array with the category_ids of the child 
	 * elements.
	 * @param array $aCats
	 * @return array 
	 */ 
	public function extractCategories($aCats)
	{
		$aOut = array();
		
		foreach ($aCats as $aCategory)
		{
			$aOut[] = $aCategory['category_id'];
			if (!empty($aCategory['sub']))
			$aOut = array_merge($aOut, array_values($this->extractCategories($aCategory['sub'])));
		}
		return $aOut;
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
		if ($sPlugin = Phpfox_Plugin::get('photo.service_category__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
	
	/**
	 * Gets the parent categories based on the category ID
	 *
	 * @param int $iParentId Category ID to check all the parent ID
	 * @param boolean $bPassName True to pass the name of the category, or false to only pass the URL string
	 * 
	 * @return string Returns the fixed URL string
	 */
	private function _getParentsUrl($iParentId, $bPassName = false)
	{
		// Cache the round we are going to increment
		static $iCnt = 0;
		
		// Add to the cached round
		$iCnt++;
		
		// Check if this is the first round
		if ($iCnt === 1)
		{
			// Cache the cache ID
			static $sCacheId = null;
			
			// Check if we have this data already cached
			$sCacheId = $this->cache()->set('photo_category_url' . ($bPassName ? '_name' : '') . '_' . $iParentId);
			if ($sParents = $this->cache()->get($sCacheId))
			{
				return $sParents;
			}
		}
		
		// Get the menus based on the category ID
		$aParents = $this->database()->select('category_id, name, name_url, parent_id')
			->from($this->_sTable)
			->where('category_id = ' . (int) $iParentId)
			->execute('getRows');
			
		// Loop thur all the sub menus
		$sParents = '';
		foreach ($aParents as $aParent)
		{
			$sParents .= $aParent['name_url'] . ($bPassName ? '|' . $aParent['name'] . '|' . $aParent['category_id'] : '') . '/' . $this->_getParentsUrl($aParent['parent_id'], $bPassName);
		}		
	
		// Save the cached based on the static cache ID
		if (isset($sCacheId))
		{
			$this->cache()->save($sCacheId, $sParents);
		}
		
		// Return the loop
		return $sParents;
		
	}
	
	private function _getIds($iParentId, $bUseId = true)
	{
		$aCategories = $this->database()->select('pc.name, pc.category_id')
			->from($this->_sTable, 'pc')
			->where(($bUseId ? 'pc.parent_id = ' . (int) $iParentId . '' : 'pc.name_url = \'' . $this->database()->escape($iParentId) . '\''))
			->execute('getRows');
			
		$sCategories = '';
		foreach ($aCategories as $aCategory)
		{
			$sCategories .= $aCategory['category_id'] . ',' . $this->_getIds($aCategory['category_id']) . '';
		}
		
		return $sCategories;		
	}	
	
	private function _getParentIds($iId)
	{		
		$aCategories = $this->database()->select('pc.category_id, pc.parent_id')
			->from($this->_sTable, 'pc')
			->where('pc.category_id = ' . (int) $iId)
			->execute('getRows');
		
		$sCategories = '';
		foreach ($aCategories as $aCategory)
		{
			$sCategories .= $aCategory['category_id'] . ',' . $this->_getParentIds($aCategory['parent_id']) . '';
		}
		
		return $sCategories;		
	}		
}

?>