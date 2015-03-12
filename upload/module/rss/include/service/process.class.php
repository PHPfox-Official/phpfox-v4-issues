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
 * @package  		Module_Rss
 * @version 		$Id: process.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Rss_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('rss');	
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
			'group_id' => array(
				'message' => Phpfox::getPhrase('rss.select_a_group_for_this_feed'),
				'type' => 'int:required'
			),
			'title_var' => array(
				'message' => Phpfox::getPhrase('rss.at_least_one_title_for_the_feed_is_required'),
				'type' => 'phrase:required'	
			),
			'description_var' => array(
				'message' => Phpfox::getPhrase('rss.at_least_one_description_for_the_feed_is_required'),
				'type' => 'phrase:required'	
			),
			'feed_link' => array(
				'message' => Phpfox::getPhrase('rss.provide_a_link_for_the_feed'),
				'type' => 'string:required'
			),		
			'php_group_code' => array(
				'message' => Phpfox::getPhrase('rss.provide_proper_php_code'),
				'type' => 'php_code'
			),
			'php_view_code' => array(
				'message' => Phpfox::getPhrase('rss.php_code_for_the_feed_is_required'),
				'type' => 'php_code:required'
			),
			'is_site_wide' => array(
				'message' => Phpfox::getPhrase('rss.select_if_the_feed_can_be_seen_site_wide'),
				'type' => 'int:required'			
			),
			'is_active' => array(
				'message' => Phpfox::getPhrase('rss.select_if_the_feed_is_active_or_not'),
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
			
			$aPhrases = $aVals['title_var'];
			$aDescriptions = $aVals['description_var'];
			unset($aVals['title_var'], $aVals['description_var']);
			
			$this->database()->update($this->_sTable, $aVals, 'feed_id = ' . $iUpdateId);
			
			foreach ($aPhrases as $sPhrase => $aPhrase)
			{
				$aLanguage = array_keys($aPhrase);
				$aText = array_values($aPhrase);
				
				Phpfox::getService('language.phrase.process')->updateVarName($aLanguage[0], $sPhrase, $aText[0]);
			}
			
			foreach ($aDescriptions as $sPhrase => $aPhrase)
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
			
			$aPhrases = $aVals['title_var'];
			$aDescriptions = $aVals['description_var'];
			unset($aVals['title_var'], $aVals['description_var']);
			
			$iId = $this->database()->insert($this->_sTable, $aVals);
			
			$sPhraseVar = Phpfox::getService('language.phrase.process')->add(array(
					'var_name' => 'rss_title_' . $iId,
					'product_id' => $aVals['product_id'],
					'module' => $aVals['module_id'] . '|' . $aVals['module_id'],
					'text' => $aPhrases
				)
			);		
			
			$sDescriptionVar = Phpfox::getService('language.phrase.process')->add(array(
					'var_name' => 'rss_description_' . $iId,
					'product_id' => $aVals['product_id'],
					'module' => $aVals['module_id'] . '|' . $aVals['module_id'],
					'text' => $aDescriptions
				)
			);				
			
			$this->database()->update($this->_sTable, array('title_var' => $sPhraseVar, 'description_var' => $sDescriptionVar), 'feed_id = ' . $iId);			
		}
		
		$this->cache()->remove();
		
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
	
		$this->database()->update($this->_sTable, array('is_active' => (int) ($iType == '1' ? 1 : 0)), 'feed_id = ' . (int) $iId);
		
		$this->cache()->remove('rss', 'substr');
	}	
	
	public function updateSiteWide($iId, $iType)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);		
	
		$this->database()->update($this->_sTable, array('is_site_wide' => (int) ($iType == '1' ? 1 : 0)), 'feed_id = ' . (int) $iId);
		
		$this->cache()->remove('rss', 'substr');
	}		
	
	public function delete($iId)
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('admincp.has_admin_access', true);
		
		$aFeed = $this->database()->select('feed_id, module_id')
			->from($this->_sTable)
			->where('feed_id = ' . (int) $iId)
			->execute('getRow');
			
		if (!isset($aFeed['feed_id']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('rss.the_feed_you_are_looking_for_cannot_be_found'));
		}

		$this->database()->delete($this->_sTable, 'feed_id = ' . $aFeed['feed_id']);	
		$this->database()->delete(Phpfox::getT('language_phrase'), 'module_id = \'' . $aFeed['module_id'] . '\' AND var_name = \'rss_title_' . $aFeed['feed_id'] . '\'');
		$this->database()->delete(Phpfox::getT('language_phrase'), 'module_id = \'' . $aFeed['module_id'] . '\' AND var_name = \'rss_description_' . $aFeed['feed_id'] . '\'');
		
		$this->cache()->remove('rss', 'substr');
		
		return true;
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
			$this->database()->update($this->_sTable, array('ordering' => (int) $iOrder), 'feed_id = ' . (int) $iId);
		}
		
		$this->cache()->remove('rss', 'substr');
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
		if ($sPlugin = Phpfox_Plugin::get('rss.service_process__call'))
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