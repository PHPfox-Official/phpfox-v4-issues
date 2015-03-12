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
class Rss_Service_Group_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('rss_group');
	}
	
	public function add($aVals, $iUpdateId = null)
	{
		$aForm = array(
			'product_id' => array(
				'message' => Phpfox::getPhrase('rss.select_a_product'),
				'type' => 'product_id:required'
			),
			'module_id' => array(
				'message' => Phpfox::getPhrase('rss.select_a_module'),
				'type' => 'module_id:required'
			),
			'name_var' => array(
				'message' => Phpfox::getPhrase('rss.at_least_one_name_for_the_group_is_required'),
				'type' => 'phrase:required'
			),
			'is_active' => array(
				'message' => Phpfox::getPhrase('rss.select_if_the_group_is_active_or_not'),
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
			
			$aPhrases = $aVals['name_var'];
			unset($aVals['name_var']);
			
			$this->database()->update($this->_sTable, $aVals, 'group_id = ' . $iUpdateId);
			
			foreach ($aPhrases as $sPhrase => $aPhrase)
			{
				$aLanguage = array_keys($aPhrase);
				$aText = array_values($aPhrase);
				
				Phpfox::getService('language.phrase.process')->updateVarName($aLanguage[0], $sPhrase, $aText[0]);
			}
			
			$this->cache()->remove();
		}
		else 
		{				
			$aVals = $this->validator()->process($aForm, $aVals);			
			
			if (!Phpfox_Error::isPassed())
			{
				return false;
			}			
			
			$aPhrases = $aVals['name_var'];
			unset($aVals['name_var']);
			
			$iId = $this->database()->insert($this->_sTable, $aVals);
			
			$sPhraseVar = Phpfox::getService('language.phrase.process')->add(array(
					'var_name' => 'rss_group_name_' . $iId,
					'product_id' => $aVals['product_id'],
					'module' => $aVals['module_id'] . '|' . $aVals['module_id'],
					'text' => $aPhrases
				)
			);		
			
			$this->database()->update($this->_sTable, array('name_var' => $sPhraseVar), 'group_id = ' . $iId);
		}
		
		return true;
	}
	
	public function update($iId, $aVals)
	{				
		return $this->add($aVals, $iId);
	}

	public function updateOrder($aVals)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		
		if (!isset($aVals['ordering']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('rss.not_a_valid_request'));
		}
		
		foreach ($aVals['ordering'] as $iId => $iOrder)
		{
			$this->database()->update($this->_sTable, array('ordering' => (int) $iOrder), 'group_id = ' . (int) $iId);
		}
		
		$this->cache()->remove('rss', 'substr');
	}	
	
	public function delete($iId)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		
		$aGroup = $this->database()->select('group_id, module_id')
			->from($this->_sTable)
			->where('group_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aGroup['group_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('rss.the_group_you_are_looking_for_cannot_be_found'));
		}

		$this->database()->delete($this->_sTable, 'group_id = ' . $aGroup['group_id']);	
		$this->database()->delete(Phpfox::getT('language_phrase'), 'module_id = \'' . $aGroup['module_id'] . '\' AND var_name = \'rss_group_name_' . $aGroup['group_id'] . '\'');
		
		$this->cache()->remove('stat', 'substr');
		
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
		if ($sPlugin = Phpfox_Plugin::get('rss.service_group_process__call'))
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