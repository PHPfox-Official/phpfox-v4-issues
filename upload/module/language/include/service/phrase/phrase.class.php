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
 * @package  		Module_Language
 * @version 		$Id: phrase.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Language_Service_Phrase_Phrase extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('language_phrase');
	}
	
	public function isPhrase($aVals)
	{		
		$sPhrase = Phpfox::getService('language.phrase.process')->prepare($aVals['var_name']);		
		$aParts = explode('|', $aVals['module']);				
		
		$aRow = $this->database()->select('lp.var_name, m.module_id AS name')
			->from($this->_sTable, 'lp')
			->leftJoin(Phpfox::getT('module'), 'm', 'm.module_id = lp.module_id')
			->where("lp.module_id = '" . $this->database()->escape($aParts[0]) . "' AND lp.var_name = '" . $this->database()->escape($sPhrase) . "'")
			->execute('getRow');

		if (!isset($aRow['var_name']))
		{
			return false;
		}
		
		return $aParts[1] . '.' . $sPhrase;
	}
	
	public function isValid($sPhrase, $sLanguageId = null)
	{
		list($sModule, $sPhrase) = explode('.', $sPhrase);
		
		return ($this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where(($sLanguageId === null ? '' : 'language_id = \'' . $this->database()->escape($sLanguageId) . '\' AND ') . 'module_id = \'' . $this->database()->escape($sModule) . '\' AND var_name = \'' . $this->database()->escape($sPhrase) . '\'')
			->execute('getField') ? true : false);
	}
	
	public function get($aConds = array(), $sSort = 'lp.phrase_id DESC', $iPage = '', $sLimit = '', $bCount = true)
	{		
		$iCnt = ($bCount ? 0 : 1);
		$aRows = array();
		
		if ($bCount)
		{			
			$iCnt = $this->database()->select('COUNT(*)')
				->from($this->_sTable, 'lp')
				->join(Phpfox::getT('language'), 'l', 'l.language_id = lp.language_id')
				->join(Phpfox::getT('module'), 'm', 'm.module_id = lp.module_id AND m.is_active = 1')
				->where($aConds)
				->execute('getField');
		}

		if ($iCnt)
		{
			$aRows = $this->database()->select('lp.*, m.module_id AS name, l.title')
				->from($this->_sTable, 'lp')
				->join(Phpfox::getT('language'), 'l', 'l.language_id = lp.language_id')
				->join(Phpfox::getT('module'), 'm', 'm.module_id = lp.module_id AND m.is_active = 1')
				->where($aConds)
				->order($sSort)
				->limit($iPage, $sLimit, $iCnt)
				->execute('getRows');			
		}		
		
		if (!$bCount)
		{
			return $aRows;
		}
		
		return array($iCnt, $aRows);
	}	
	
	public function getSearch($aConds = array(), $sSort = 'lp.phrase_id DESC')
	{
		$aRows = $this->database()->select('lp.phrase_id')
			->from($this->_sTable, 'lp')
			->where($aConds)
			->order($sSort)
			->execute('getSlaveRows', array(
				'free_result' => true
			));
			
		$aIds = array();
		foreach ($aRows as $aRow)
		{
			$aIds[] = $aRow['phrase_id'];
		}
		
		unset($aRows);
		
		return $aIds;
	}
	
	public function getValues($sVarName)
	{
		$aParts = explode('.', $sVarName);
		
		$aPhrases = $this->database()->select('language_id, text')
			->from(Phpfox::getT('language_phrase'))
			->where('module_id = \'' . $this->database()->escape($aParts[0]) . '\' AND var_name = \'' . $this->database()->escape($aParts[1]) . '\'')
			->execute('getSlaveRows');		
		
		$aGroup = array();
		foreach ($aPhrases as $aPhrase)
		{
			$aGroup[$sVarName][$aPhrase['language_id']] = $aPhrase['text'];
		}

		return $aGroup;	
	}
	
	public function getStaticPhrase($sPhrase)
	{
		$aParts = explode('.', $sPhrase);
		
		$aRow = $this->database()->select('phrase_id, text')
			->from(Phpfox::getT('language_phrase'))
			->where('module_id = \'' . $this->database()->escape($aParts[0]) . '\' AND var_name = \'' . $this->database()->escape($aParts[1]) . '\'')
			->execute('getRow');
			
		if (!isset($aRow['phrase_id']))
		{
			return false;
		}
		
		return $aRow['text'];
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
		if ($sPlugin = Phpfox_Plugin::get('language.service_phrase_phrase__call'))
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