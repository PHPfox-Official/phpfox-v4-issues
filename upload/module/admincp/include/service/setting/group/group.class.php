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
 * @package  		Module_Admincp
 * @version 		$Id: group.class.php 6545 2013-08-30 08:41:44Z Raymond_Benc $
 */
class Admincp_Service_Setting_Group_Group extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('setting_group');
	}	
	
	public function get($bAllModules = false)
	{		
		// if (PHPFOX_DEBUG)
		{
			$this->database()->select('COUNT(s.group_id) AS total_settings, ')
				->leftJoin(Phpfox::getT('setting'), 's', 's.group_id = setting_group.group_id AND s.is_hidden = 0')
				->join(Phpfox::getT('module'), 'm', 'm.module_id = s.module_id AND m.is_active = 1')
				->group('setting_group.var_name');
		}
		
		$aRows = $this->database()->select('setting_group.group_id, setting_group.product_id, setting_group.var_name, product.title AS product_name, language_phrase.text AS language_var_name')
			->from($this->_sTable, 'setting_group')
			->leftJoin(Phpfox::getT('product'), 'product', 'product.product_id = setting_group.product_id')
			->leftJoin(Phpfox::getT('language_phrase'), 'language_phrase', array(
					"language_phrase.language_id = '" . $this->database()->escape(Phpfox::getLib('locale')->getLangId()) . "'",
					"AND language_phrase.var_name = setting_group.var_name"
				)
			)
			->execute('getSlaveRows');				
		
		$aGroups = array();
		$aProductGroups = array();
		$aModules = ($bAllModules ? Phpfox::getService('admincp.module')->getModules() : Phpfox::getService('admincp.module')->getModulesForSettings());		

		foreach ($aModules as $iKey => $aModule)
		{
			if (!$aModule['total_settings'])
			{
				unset($aModules[$iKey]);
			}			
		}
		
		if (defined('PHPFOX_IS_HOSTED_SCRIPT') && !defined('PHPFOX_GROUPLY_TEST'))
		{
			$aNotAllowedToEdit = array(
					'archive_handler',
					'cdn_content_delivery_network',
					'cookie',
					'debug',
					'ftp',
					'image_processing'
				);
		}
		
		foreach ($aRows as $aRow)
		{			
			if (defined('PHPFOX_IS_HOSTED_SCRIPT') && !defined('PHPFOX_SHOW_HIDDEN') && !defined('PHPFOX_GROUPLY_TEST'))
			{
				if (in_array($aRow['group_id'], $aNotAllowedToEdit))
				{
					continue;
				}
			}			
			
			if (!$aRow['total_settings'])
			{
				continue;
			}
			
			if (!empty($aRow['language_var_name']))
			{
				$aParts = explode('</title><info>', $aRow['language_var_name']);			
				$aRow['var_name'] = str_replace('<title>', '', $aParts[0]);
				$aRow['setting_info'] = str_replace(array("\n", '</info>'), array("<br />", ''), $aParts[1]);			
			}

			$aGroups[$aRow['var_name']] = $aRow;			
		}
		
		ksort($aGroups);	
		
		$aProductGroups = $this->database()->select('p.title AS var_name, p.product_id, COUNT(s.setting_id) AS total_settings')
			->from(Phpfox::getT('product'), 'p')
			->leftJoin(Phpfox::getT('setting'), 's', 's.product_id = p.product_id')
			->group('p.product_id')
			->where('p.is_active = 1')
			->execute('getSlaveRows');
		foreach ($aProductGroups as $iKey => $aProductGroup)
		{
			if (
				$aProductGroup['product_id'] == 'phpfox'
				|| $aProductGroup['total_settings'] <= 0
			)
			{
				unset($aProductGroups[$iKey]);
				
				continue;
			}
			
			// $aProductGroups[$iKey]['total_settings'] = '1';
		}

		return array($aGroups, $aModules, $aProductGroups);
	}
	
	public function getGroups()
	{
		$aRows = $this->database()->select('setting_group.group_id, language_phrase.text AS language_var_name')
			->from($this->_sTable, 'setting_group')
			->leftJoin(Phpfox::getT('product'), 'product', 'product.product_id = setting_group.product_id AND product.is_active = 1')
			->leftJoin(Phpfox::getT('language_phrase'), 'language_phrase', array(
					"language_phrase.language_id = '" . $this->database()->escape(Phpfox::getLib('locale')->getLangId()) . "'",
					"AND language_phrase.var_name = setting_group.var_name"
				)
			)
			->execute('getSlaveRows');		
			
		foreach ($aRows as $iKey => $aRow)
		{
			if (!empty($aRow['language_var_name']))
			{
				$aParts = explode('</title><info>', $aRow['language_var_name']);			
				$aRows[$iKey]['var_name'] = str_replace('<title>', '', $aParts[0]);
				$aRows[$iKey]['setting_info'] = str_replace(array("\n", '</info>'), array("<br />", ''), $aParts[1]);			
			}			
		}
			
		return $aRows;
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
		if ($sPlugin = Phpfox_Plugin::get('admincp.service_group_group__call'))
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