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
 * @package  		Module_Page
 * @version 		$Id: page.class.php 3623 2011-11-30 12:43:46Z Raymond_Benc $
 */
class Page_Service_Page extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('page');
	}
	
	public function prepareTitle($sTitle)
	{
		static $aTitle = array();
		
		if (isset($aTitle[$sTitle]))
		{
			return $aTitle[$sTitle];
		}		
		
		$sNewTitle = Phpfox::getLib('parse.input')->cleanTitle($sTitle);			
			
		$aOlds = $this->database()->select('title_url')
			->from($this->_sTable)
			->where("title_url LIKE '%" . $this->database()->escape($sNewTitle) . "%'")
			->execute('getRows');			

		$iTotal = 0;
		foreach ($aOlds as $aOld)
		{
			// If the old URL is identical to the new title lets correct the title count
			if ($aOld['title_url'] === $sNewTitle)
			{				
				$sNewTitle = $sNewTitle;
				$iTotal++;
				continue;
			}
			
			// Remove the numerical value from the title
			if (preg_replace("/(.*?)-[0-9]/i", "$1", $aOld['title_url']) === $sNewTitle)
			{
				$iTotal++;
			}
		}	
		
		$aTitle[$sTitle] =  $sNewTitle . ($iTotal > 0 ? '-' . ($iTotal + 1) : '');		
		
		return $aTitle[$sTitle];
	}
	
	public function getForEdit($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('page.service_page_getforedit')) ? eval($sPlugin) : false);
		
		return $this->database()->select('p.*, m.menu_id, pt.keyword, pt.description, pt.text, pt.text_parsed')
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('page_text'), 'pt', 'pt.page_id = p.page_id')
			->leftJoin(Phpfox::getT('menu'), 'm', 'm.module_id = \'page\' AND m.url_value = p.title_url')
			->where('p.page_id = ' . (int) $iId)
			->execute('getRow');			
	}
	
	public function hasViewed($iId, $iUserId)
	{
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('page_track'))
			->where('item_id = ' . (int) $iId . ' AND user_id = ' . (int) $iUserId)
			->execute('getSlaveField');

		return ($iCnt ? true : false);
	}
	
	public function get()
	{
		(($sPlugin = Phpfox_Plugin::get('page.service_page_get')) ? eval($sPlugin) : false);
		
		$aRows = $this->database()->select('p.*, m.menu_id')
			->from($this->_sTable, 'p')			
			->leftJoin(Phpfox::getT('menu'), 'm', 'm.page_id = p.page_id')
			->order('p.added DESC')
			->group('p.title') // avoids duplicated pages
			->execute('getRows');	
		
		foreach ($aRows as $iKey => $aRow)
		{
			if ($aRow['is_phrase'])
			{
				$aParts = explode('.', $aRow['title']);
				if (!Phpfox::isModule($aParts[0]))
				{
					$aRows[$iKey]['is_phrase'] = '0';
				}
			}
		}
		
		return $aRows;
	}
	
	public function getCache()
	{		
		$aPages = array();
		$sCacheId = $this->cache()->set('page');
		if (!($aPages = $this->cache()->get($sCacheId)))
		{
			(($sPlugin = Phpfox_Plugin::get('page.service_page_getcache')) ? eval($sPlugin) : false);
			$aRows = $this->database()->select('page_id, title_url')
				->from($this->_sTable)
				->execute('getRows');
			
			foreach ($aRows as $aRow)
			{
				$aPages[$aRow['title_url']] = $aRow['page_id'];
			}
			
			$this->cache()->save($sCacheId, $aPages);
		}		
		
		return (is_array($aPages) ? $aPages : array());
	}
	
	public function getPage($mPage, $bIsVar = false)
	{
		(($sPlugin = Phpfox_Plugin::get('page.service_page_getpage')) ? eval($sPlugin) : false);
		
		$aRow = $this->database()->select('p.*, pt.keyword, pt.description, pt.text, pt.text_parsed, t.item_id AS has_viewed')
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('page_text'), 'pt', 'pt.page_id = p.page_id')
			->leftJoin(Phpfox::getT('page_track'), 't', 't.item_id = p.page_id AND t.user_id = ' . Phpfox::getUserId())
			->join(Phpfox::getT('product'), 'product', 'p.product_id = product.product_id AND product.is_active = 1')
			->where(($bIsVar ? "p.title_url = '" . $this->database()->escape($mPage) . "'" : 'p.page_id = ' . (int) $mPage))
			->execute('getRow');

		return $aRow;
	}

	public function export($sProductId, $sModule = null)
	{
		$aSql = array();
		$aSql[] = "p.product_id = '" . $sProductId . "'";
		if ($sModule !== null)
		{
			$aSql[] = "AND p.module_id = '" . $sModule . "'";
		}

		$aRows = $this->database()->select('p.*, pt.*')
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('page_text'), 'pt', 'pt.page_id = p.page_id')
			->where($aSql)
			->execute('getRows');

		if (!count($aRows))
		{
			return false;
		}
			
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('pages');

		foreach ($aRows as $aRow)
		{
			$oXmlBuilder->addGroup('page', array(
					'module_id' => $aRow['module_id'],
					'is_phrase' => $aRow['is_phrase'],
					'has_bookmark' => $aRow['has_bookmark'],
					'parse_php' => $aRow['parse_php'],
					'add_view' => $aRow['add_view'],
					'full_size' => $aRow['full_size'],
					'title' => $aRow['title'],
					'title_url' => $aRow['title_url'],
					'added' => $aRow['added']
				)
			);

			$oXmlBuilder->addTag('keyword', $aRow['keyword']);
			$oXmlBuilder->addTag('description', $aRow['description']);
			$oXmlBuilder->addTag('text', $aRow['text']);
			$oXmlBuilder->addTag('text_parsed', $aRow['text_parsed']);
			$oXmlBuilder->closeGroup();
		}
		$oXmlBuilder->closeGroup();

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
		if ($sPlugin = Phpfox_Plugin::get('page.service_page__call'))
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