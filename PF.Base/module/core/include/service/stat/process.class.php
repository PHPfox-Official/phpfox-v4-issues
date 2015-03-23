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
 * @version 		$Id: process.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Core_Service_Stat_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('site_stat');
	}
	
	public function add($aVals, $iUpdateId = null)
	{		
		$aForm = array(
			'product_id' => array(
				'message' => Phpfox::getPhrase('admincp.select_a_product'),
				'type' => 'product_id:required'
			),
			'module_id' => array(
				'message' => Phpfox::getPhrase('admincp.select_a_module'),
				'type' => 'module_id:required'
			),
			'phrase_var' => array(
				'message' => Phpfox::getPhrase('admincp.at_least_one_title_for_the_stat_is_required'),
				'type' => 'phrase:required'
			),
			'stat_link' => array(
				'message' => Phpfox::getPhrase('admincp.link_for_the_stat_is_required'),
				'type' => 'string:required'
			),
			'stat_image' => array(
				'message' => Phpfox::getPhrase('admincp.image_for_the_stat_is_required'),
				'type' => 'string'
			),
			'php_code' => array(
				'message' => Phpfox::getPhrase('admincp.php_code_for_the_stat_is_required'),
				'type' => 'php_code:required'
			),
			'is_active' => array(
				'message' => Phpfox::getPhrase('admincp.select_if_the_stat_is_active_or_not'),
				'type' => 'int:required'
			)
		);
		
		if ($iUpdateId !== null)
		{			
			unset($aForm['product_id'], $aForm['module_id']);
			
			$aVals = $this->validator()->process($aForm, $aVals);	
			
			if (!Phpfox_Error::isPassed())
			{
				return false;
			}			
			
			$aPhrases = $aVals['phrase_var'];
			unset($aVals['phrase_var']);
			
			$this->database()->update($this->_sTable, $aVals, 'stat_id = ' . $iUpdateId);
			
			foreach ($aPhrases as $sPhrase => $aPhrase)
			{
				$aLanguage = array_keys($aPhrase);
				$aText = array_values($aPhrase);
				
				Phpfox::getService('language.phrase.process')->updateVarName($aLanguage[0], $sPhrase, $aText[0]);
			}
		}
		else 
		{
			$aVals = $this->validator()->process($aForm, $aVals);	
			
			if (!Phpfox_Error::isPassed())
			{
				return false;
			}
			
			$aPhrases = $aVals['phrase_var'];
			unset($aVals['phrase_var']);
			
			$iId = $this->database()->insert($this->_sTable, $aVals);
			
			$sPhraseVar = Phpfox::getService('language.phrase.process')->add(array(
					'var_name' => 'stat_title_' . $iId,
					'product_id' => $aVals['product_id'],
					'module' => $aVals['module_id'] . '|' . $aVals['module_id'],
					'text' => $aPhrases
				)
			);		
			
			$this->database()->update($this->_sTable, array('phrase_var' => $sPhraseVar), 'stat_id = ' . $iId);
		}
		
		$this->cache()->remove('stat', 'substr');
		
		return true;
	}
	
	public function updateOrder($aVals)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		
		if (!isset($aVals['ordering']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.not_a_valid_request'));
		}
		
		foreach ($aVals['ordering'] as $iId => $iOrder)
		{
			$this->database()->update($this->_sTable, array('ordering' => (int) $iOrder), 'stat_id = ' . (int) $iId);
		}
		
		$this->cache()->remove('stat', 'substr');
	}	
	
	public function delete($iId)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		
		$aStat = $this->database()->select('stat_id, module_id')
			->from($this->_sTable)
			->where('stat_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aStat['stat_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('admincp.the_stat_you_are_looking_for_cannot_be_found'));
		}

		$this->database()->delete($this->_sTable, 'stat_id = ' . $aStat['stat_id']);	
		$this->database()->delete(Phpfox::getT('language_phrase'), 'module_id = \'' . $aStat['module_id'] . '\' AND var_name = \'stat_title_' . $aStat['stat_id'] . '\'');
		
		$this->cache()->remove('stat', 'substr');
		
		return true;
	}
	
	public function update($iId, $aVals)
	{				
		return $this->add($aVals, $iId);
	}
	
	public function updateActivity($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);		
	
		$this->database()->update($this->_sTable, array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'stat_id = ' . (int) $iId);
		
		$this->cache()->remove('stat', 'substr');
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
		if ($sPlugin = Phpfox_Plugin::get('core.service_stat_process__call'))
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