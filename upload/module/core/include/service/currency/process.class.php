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
 * @version 		$Id: process.class.php 1558 2010-05-04 12:51:22Z Raymond_Benc $
 */
class Core_Service_Currency_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('currency');	
	}
	
	public function add($aVals, $iUpdateId = null)
	{
		$aForm = array(
			'currency_id' => array(
				'message' => Phpfox::getPhrase('admincp.provide_a_3_character_currency_id'),
				'type' => 'string:required'
			),	
			'symbol' => array(
				'message' => Phpfox::getPhrase('admincp.provide_a_symbol'),
				'type' => 'string:required'
			),				
			'phrase_var' => array(
				'message' => Phpfox::getPhrase('admincp.provide_a_phrase_for_your_currency'),
				'type' => 'phrase:required'	
			),
			'is_active' => array(
				'message' => Phpfox::getPhrase('admincp.select_if_this_currency_is_active_or_not'),
				'type' => 'int:required'
			)
		);
		
		$aVals = $this->validator()->process($aForm, $aVals);		
			
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}	
		
		$aVals['symbol'] = $this->preParse()->clean($aVals['symbol']);
		
		if ($iUpdateId !== null)
		{
			if ($iUpdateId != $aVals['currency_id'])
			{
				$iCheck = $this->database()->select('COUNT(*)')
					->from($this->_sTable)
					->where('currency_id = \'' . $this->database()->escape($aVals['currency_id']) . '\'')
					->execute('getField');
					
				if ($iCheck)
				{
					return Phpfox_Error::set(Phpfox::getPhrase('admincp.this_currency_is_already_in_use'));
				}				
			}
			
			$aPhrases = $aVals['phrase_var'];			
			unset($aVals['phrase_var']);
			$this->database()->update($this->_sTable, $aVals, 'currency_id = \'' . $this->database()->escape($iUpdateId) . '\'');
			
			foreach ($aPhrases as $sPhrase => $aPhrase)
			{
				$aLanguage = array_keys($aPhrase);
				$aText = array_values($aPhrase);
				
				Phpfox::getService('language.phrase.process')->updateVarName($aLanguage[0], $sPhrase, $aText[0]);
			}			
		}
		else 
		{
			$iCheck = $this->database()->select('COUNT(*)')
				->from($this->_sTable)
				->where('currency_id = \'' . $this->database()->escape($aVals['currency_id']) . '\'')
				->execute('getField');
				
			if ($iCheck)
			{
				return Phpfox_Error::set(Phpfox::getPhrase('admincp.this_currency_is_already_in_use'));
			}			
			
			$this->database()->insert($this->_sTable, $aVals);
			
			$sPhraseVar = Phpfox::getService('language.phrase.process')->add(array(
					'var_name' => 'custom_currency_' . $aVals['currency_id'],
					'product_id' => 'phpfox',
					'module' => 'core|core',
					'text' => $aVals['phrase_var']
				)
			);
			
			$this->database()->update($this->_sTable, array('phrase_var' => $sPhraseVar), 'currency_id = \'' . $this->database()->escape($aVals['currency_id']) . '\'');
		}
		
		$this->cache()->remove('currency');
		
		return true;
	}
	
	public function update($iId, $aVals)
	{				
		return $this->add($aVals, $iId);
	}	
	
	public function updateDefault($iId, $sType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);			
		
		$this->database()->update($this->_sTable, array('is_default' => '0'), '1');
		$this->database()->update($this->_sTable, array('is_default' => '1'), 'currency_id = \'' . $this->database()->escape($iId) . '\'');
		
		$this->cache()->remove('currency');
	}
	
	public function updateActivity($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);		
	
		$this->database()->update($this->_sTable, array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'currency_id = \'' . $this->database()->escape($iId) . '\'');
		
		$this->cache()->remove('currency');
	}		
	
	public function delete($sId)
	{
		$this->database()->delete($this->_sTable, 'currency_id = \'' . $this->database()->escape($sId) . '\'');
		$this->cache()->remove('currency');
		
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
		if ($sPlugin = Phpfox_Plugin::get('core.service_currency_process__call'))
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