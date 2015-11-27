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
 * @package  		Module_Ban
 * @version 		$Id: word.class.php 3917 2012-02-20 18:21:08Z Raymond_Benc $
 */
class Ban_Service_Word extends Phpfox_Service 
{
	private $_aWords = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('ban');
	}	

    function clean($sTxt)
    {
    	if ($this->_aWords)
    	{
    		return $this->_parseString($sTxt);
    	}

		$sCacheId = $this->cache()->set("ban_word");
		if (!($this->_aWords = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('find_value, replacement')
				->from($this->_sTable)
				->where("type_id = 'word'")
				->execute('getRows');
	    	foreach($aRows as $aRow)
	    	{
	    		$this->_aWords[$aRow['find_value']] = $aRow['replacement'];
	    	}
	    	$this->cache()->save($sCacheId, $this->_aWords);
	    }

		return $this->_parseString($sTxt);
    }	
    
    function _parseString($sTxt)
    {    	
    	if (!is_array($this->_aWords))
    	{
    		return $sTxt;
    	}
    	
    	if (!count($this->_aWords))
    	{
    		return $sTxt;
    	}    
		
		foreach ($this->_aWords as $sFilter => $mValue)
		{
			$sFilter = str_replace("/", "\/", $sFilter);
			$sFilter = str_replace('&#42;', '*', $sFilter);
			if (preg_match('/\*/i', $sFilter))
			{
				$sFilter = str_replace(array('.', '*'), array('\.', '([a-zA-Z@]?)'), $sFilter);

				$sTxt = preg_replace('/' . $sFilter . '/is', ' ' . $mValue . ' ', $sTxt);
			}
			else 
			{									
				$sTxt = preg_replace("/(\W)". $sFilter ."(\W)/i", "\\1". $mValue ."\\2", $sTxt);
				$sTxt = preg_replace("/^". $sFilter ."(\W)/i", "". $mValue ."\\1", $sTxt);
				$sTxt = preg_replace("/(\W)". $sFilter ."$/i", "\\1". $mValue ."", $sTxt);
				$sTxt = preg_replace("/^". $sFilter ."$/i", "". $mValue ."", $sTxt);
				
				$sTxt = ltrim($sTxt);
   				$sTxt = rtrim($sTxt);					
			}
		}    					
		
    	return $sTxt;
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
		if ($sPlugin = Phpfox_Plugin::get('ban.service_word__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
	
	private function _replace($aMatches)
	{
		d($aMatches, true);
		exit;
	}
}

?>