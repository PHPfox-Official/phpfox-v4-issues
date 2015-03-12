<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Pagination
 * This class handles all the pagination on the site and creates a 
 * template variable that is automatically picked up with a simple HTML
 * variable call.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: pager.class.php 6699 2013-09-30 14:14:43Z Fern $
 */
class Phpfox_Pager
{
	/**
	 * Current page we are on.
	 *
	 * @var int
	 */
	private $_iPage = 0;
	
	/**
	 * Total items per page.
	 *
	 * @var int
	 */
	private $_iPageSize = 0;
	
	/**
	 * Total pages.
	 *
	 * @var int
	 */
	private $_iPagesCount = 0;
	
	/**
	 * From page number.
	 *
	 * @var int
	 */
	private $_iFirstRow;
	
	/**
	 * Last page number.
	 *
	 * @var int
	 */
	private $_iLastRow;
	
	/**
	 * Numbers to display in the pagination frame.
	 *
	 * @var int
	 */
	private $_iFrameSize = 5;
	
	/**
	 * AJAX request call.
	 *
	 * @var string
	 */
	private $_sAjax;
	
	/**
	 * Params to pass along with the pagination request.
	 *
	 * @var unknown_type
	 */
	private $_aParams = array();
	
    /** 
     * URL key for page param e.g. in http://example.com/?page=3 it is 'page'
     * 
     * @var string
     */
    private $_sUrlKey = 'page';	
    
    /**
     * Custom phrase for the pager.
     *
     * @var string
     */
    private $_sPhrase = '';
    
    /**
     * Custom icon for the pager.
     *
     * @var string
     */
    private $_sIcon = '';
	
    /**
     * Class constructor.
     *
     */
    public function __construct()
    {    	
    }
    
    /**
     * Set all variables and build the pagination enviroment for this specific page.
     *
     * @param array $aParams ARRAY of params.
     */
	public function set($aParams = array())
	{	
		$this->_iPage = $aParams['page'];		
		$this->_iPageSize =  max(intval($aParams['size']), 1);
		$this->_iCnt = max(intval($aParams['count']), 0);
		$this->_iPagesCount = ceil($this->_iCnt / $this->_iPageSize);
		$this->_iPage = max(1, min($this->_iPagesCount, intVal($aParams['page'])));
        $this->_iFirstRow   = $this->_iPageSize*($this->_iPage-1);
        $this->_iLastRow    = min($this->_iFirstRow + $this->_iPageSize, $this->_iCnt);
        $this->_iFrameSize  = max(intval($this->_iFrameSize), 1);
        if (isset($aParams['ajax']))
        {
        	$this->_sAjax = $aParams['ajax'];
        }        
        
        if (isset($aParams['phrase']))
        {
        	$this->_sPhrase = $aParams['phrase'];
        }
        
        if (isset($aParams['icon']))
        {
        	$this->_sIcon = $aParams['icon'];
        }
        
        if (isset($aParams['aParams']))
        {
        	$this->_aParams = array_merge(Phpfox::getLib('request')->getRequests(), $aParams['aParams']);
        }
        else 
        {
        	$this->_aParams = Phpfox::getLib('request')->getRequests();
        }      

        $this->_getInfo();        
	}
	
	/**
	 * Process the output data for pages that are cached.
	 *
	 * @param array $aRows ARRAY of SQL data.
	 */
	public function process(&$aRows)
	{
		$sActualLimit = $this->_iPageSize;
		$sNewLimit = ($this->_iPage > 0 ? (($this->_iPage - 1) * $sActualLimit) : 0);
		$iCurrentCnt = 0;					
		foreach ($aRows as $iKey => $aRow)
		{
			$iCurrentCnt++;				
			if ($this->_iPage > 0 && ($iCurrentCnt <= $sNewLimit || $iCurrentCnt > ($sNewLimit + $sActualLimit)))
			{
				unset($aRows[$iKey]);
			}
			
			if (!$this->_iPage)
			{
				if ($iCurrentCnt > $sActualLimit)
				{
					unset($aRows[$iKey]);	
				}
			}
		}

		$iNextPage = ($this->_iPage + 1);
		
		Phpfox::getLib('template')->assign('iPagerNextPageCnt', $iNextPage);		
	}
	
	/**
	 * Get the number of total pages.
	 *
	 * @return int
	 */
	public function getTotalPages()
	{
		return $this->_iPagesCount;
	}
	
	/**
	 * Get the current page we are on.
	 *
	 * @return int
	 */
	public function getCurrentPage()
	{
		return $this->_iPage;
	}
	
	/**
	 * Get the number of the next page.
	 *
	 * @return int
	 */
	public function getNextPage()
	{
		return ($this->_iPage + 1);
	}	
	
	/**
	 * Get the number of the last page.
	 *
	 * @return int
	 */
	public function getLastPage()
	{
		return $this->_iPagesCount;
	}
	
    /**
     * Get offset for given page (fix page number if needed)
     *
     * @param int $iPage      page number
     * @param int $iPageSize  page size (rows per page)
     * @param int $iCnt       records number
     * @return int offset of LIMIT in SQL
     */
    public function getOffset($iPage, $iPageSize, $iCnt)
    {
        if ($iPageSize) //if get page -- fix current page and get offset
        {
            $iPages  = ceil($iCnt / $iPageSize);
            $iPage   = max(1, min($iPages, $iPage));
            return $iPageSize*($iPage-1);
        }

        return 0;
    }
    
    /** 
     * Calculates first/last page in a current frame
     * 
     * @return array ($nStart, $nEnd)
     */
    private function _getPos()
    {
        $nStart = 1;
        if (($this->_iPage - $this->_iFrameSize/2) > 0)
        {
            if (($this->_iPage + $this->_iFrameSize/2) > $this->_iPagesCount)
            {
                $nStart = (($this->_iPagesCount - $this->_iFrameSize)>0) ? ( $this->_iPagesCount - $this->_iFrameSize + 1) : 1;
            }
            else
            {
                $nStart = $this->_iPage - floor($this->_iFrameSize/2);
            }
        }

        $nEnd = (($nStart + $this->_iFrameSize - 1) < $this->_iPagesCount) ? ($nStart + $this->_iFrameSize - 1) : $this->_iPagesCount;
        
        return array($nStart, $nEnd);
    }    
	
    /** 
     * Returns paging info: 'totalPages', 'totalRows', 'current', 'fromRow','toRow', 'firstUrl', 'prevUrl', 'nextUrl', 'lastUrl',  'urls' (url=>page)
     * 
     * @param Url $oUrl page url
     * @return array paging info
     */
    private function _getInfo()
    {
		if($this->getTotalPages() == 0)
		{
			return false;
		}
		
        $sParams = '';
        if (count($this->_aParams))
        {
	        foreach ($this->_aParams as $iKey => $sValue)
	        {
	        	if (in_array($iKey, array(
	        				'phpfox',
	        				Phpfox::getTokenName(),
	        				'page',
	        				PHPFOX_GET_METHOD,
	        				'ajax_page_display'
	        			)
	        		)
	        	)
	        	{
	        		continue;
	        	}
				
				if (is_array($sValue))
				{
					foreach ($sValue as $sKey => $sNewValue)
					{
						if (is_numeric($sKey))
						{
							continue;
						}
						
						$sParams .= '&amp;' . $iKey . '[' . $sKey . ']=' . $sNewValue;
					}
				}
	        	else
				{
					if (PHPFOX_IS_AJAX && $iKey == 'feed' && Phpfox::isModule('comment') && Phpfox::getParam('comment.load_delayed_comments_items'))
					{
						continue;
					}
					$sParams .= '&amp;' . $iKey . '=' . $sValue;
				}
	        }        
        }
    	$aInfo = array(
            'totalPages' => $this->_iPagesCount,
            'totalRows'  => $this->_iCnt,
            'current'    => $this->_iPage,
            'fromRow'    => $this->_iFirstRow+1,
            'toRow'      => $this->_iLastRow,
            'displaying' => ($this->_iCnt <= ($this->_iPageSize * $this->_iPage) ? $this->_iCnt : ($this->_iPageSize * $this->_iPage)),
            'sParams' => $sParams,
            'phrase' => $this->_sPhrase,
            'icon' => $this->_sIcon
        );        

        list($nStart, $nEnd) = $this->_getPos();        
        
        $oUrl = Phpfox::getLib('url');
        $oUrl->clearParam('page');
        
        if ($this->_iPage != 1)
        {
        	$oUrl->setParam($this->_sUrlKey, 1);
        	$aInfo['firstAjaxUrl'] = 1;
        	$aInfo['firstUrl'] = $oUrl->getFullUrl();
    
        	$oUrl->setParam($this->_sUrlKey, $this->_iPage-1);
        	$aInfo['prevAjaxUrl'] = ($this->_iPage-1);
            $aInfo['prevUrl'] = $oUrl->getFullUrl();        
			Phpfox::getLib('template')->setHeader('<link rel="prev" href="' . $aInfo['prevUrl'] . '" />');
        }        
       
        for ($i = $nStart; $i <= $nEnd; $i++)
        {
            if ($this->_iPage == $i)
            {
                $oUrl->setParam($this->_sUrlKey, $i); 
            	$aInfo['urls'][$oUrl->getFullUrl()] = $i;
            }
            else
            {
            	$oUrl->setParam($this->_sUrlKey, $i);            	
            	$aInfo['urls'][$oUrl->getFullUrl()] = $i;
            }
        }
        
        $oUrl->setParam($this->_sUrlKey, ($this->_iPage + 1));  
        $aInfo['nextAjaxUrlPager'] = $oUrl->getFullUrl();  
        
        if ($this->_iPagesCount != $this->_iPage)
        {
       		$oUrl->setParam($this->_sUrlKey, ($this->_iPage + 1));       		
       		$aInfo['nextAjaxUrl'] = ($this->_iPage + 1);       		
       		$aInfo['nextUrl'] = $oUrl->getFullUrl();             
			Phpfox::getLib('template')->setHeader('<link rel="next" href="' . $aInfo['nextUrl'] . '" />');
       		
            $oUrl->setParam($this->_sUrlKey, $this->_iPagesCount);
            $aInfo['lastUrl']= $oUrl->getFullUrl();       		
            $aInfo['lastAjaxUrl'] = $this->_iPagesCount;
        }   
		
		$aInfo['sParamsAjax'] = str_replace("'", "\\'", $aInfo['sParams']);
		
        Phpfox::getLib('template')->assign(array(
        		'aPager' => $aInfo,
        		'sAjax' => $this->_sAjax
        	)
        );
    }	
}

?>
