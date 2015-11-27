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
 * @version 		$Id: callback.class.php 7097 2014-02-07 14:27:25Z Fern $
 */
class Rss_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
	
	}
	
	public function getProfileLink()
	{
		return 'rss';
	}
	
	public function exportModule($sProductId, $sModule = null)
	{
		$sOutput = '';		
		$aSql = array();
		$aSql[] = "product_id = '" . $sProductId . "'";
		if ($sModule !== null)
		{
			$aSql[] = "AND module_id = '" . $sModule . "'";
		}

		$aRows = $this->database()->select('*')
			->from(Phpfox::getT('rss_group'))
			->where($aSql)
			->execute('getRows');

		if (!count($aRows))
		{
			return false;
		}
			
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('rss_group');

		foreach ($aRows as $aRow)
		{
			$oXmlBuilder->addTag('group', '', array(					
					'module_id' => $aRow['module_id'],
					'group_id' => $aRow['group_id'],
					'name_var' => $aRow['name_var'],
					'is_active' => $aRow['is_active']
				)
			);
		}
		$oXmlBuilder->closeGroup();
		
		$aSql = array();
		$aSql[] = "product_id = '" . $sProductId . "'";
		if ($sModule !== null)
		{
			$aSql[] = "AND module_id = '" . $sModule . "'";
		}

		$aRows = $this->database()->select('*')
			->from(Phpfox::getT('rss'))
			->where($aSql)
			->execute('getRows');		
		$oXmlBuilder->addGroup('rss');	
		foreach ($aRows as $aRow)
		{
			$oXmlBuilder->addGroup('feed', array(
					'module_id' => $aRow['module_id'],
					'group_id' => $aRow['group_id'],
					'title_var' => $aRow['title_var'],
					'description_var' => $aRow['description_var'],
					'feed_link' => $aRow['feed_link'],					
					'is_active' => $aRow['is_active'],
					'is_site_wide' => $aRow['is_site_wide']
				)
			);
			
			$oXmlBuilder->addTag('php_group_code', $aRow['php_group_code']);
			$oXmlBuilder->addTag('php_view_code', $aRow['php_view_code']);
			
			$oXmlBuilder->closeGroup();
		}		
		$oXmlBuilder->closeGroup();
		
		return true;
	}
	
	public function installModule($sProduct, $sModule, $aModule)
	{		
		if (isset($aModule['rss_group']))
		{
			// http://www.phpfox.com/tracker/view/15083/
			$aCurrentGroups = $this->database()->select('name_var')
				->from(Phpfox::getT('rss_group'))
				->where("module_id = '" . $sModule . "' AND product_id = '" . $sProduct . "'")
				->execute('getSlaveRows');
			
			$aCacheCheck = array();
			foreach ($aCurrentGroups as $aCacheRow)
			{
				$aCacheCheck[$aCacheRow['name_var']] = $aCacheRow;
			}
			// END
			
			$aRows = (isset($aModule['rss_group']['group'][1]) ? $aModule['rss_group']['group'] : array($aModule['rss_group']['group']));
			$aGroups = array();
			foreach ($aRows as $aRow)
			{
				if(!isset($aCacheCheck[$aRow['name_var']])) // http://www.phpfox.com/tracker/view/15083/
				{
					$aGroups[$aRow['group_id']] = $this->database()->insert(Phpfox::getT('rss_group'), array(
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'name_var' => $aRow['name_var'],
							'is_active' => (int) $aRow['is_active']
						)
					);
				}
			}
		}
		
		if (isset($aModule['rss']))
		{
			// http://www.phpfox.com/tracker/view/15083/
			$aCurrentRss = $this->database()->select('title_var, description_var')
				->from(Phpfox::getT('rss'))
				->where("module_id = '" . $sModule . "' AND product_id = '" . $sProduct . "'")
				->execute('getSlaveRows');
			
			$aCacheCheck = array();
			foreach ($aCurrentRss as $aCacheRow)
			{
				$aCacheCheck[$aCacheRow['title_var'] . "-" . $aCacheRow['description_var']] = $aCacheRow;
			}
			// END
			
			$aRows = (isset($aModule['rss']['feed'][1]) ? $aModule['rss']['feed'] : array($aModule['rss']['feed']));
			foreach ($aRows as $aRow)
			{
				if(!isset($aCacheCheck[$aRow['title_var'] . "-" . $aRow['description_var']])) // http://www.phpfox.com/tracker/view/15083/
				{
					$this->database()->insert(Phpfox::getT('rss'), array(
							'module_id' => ($sModule === null ? $aRow['module_id'] : $sModule),
							'product_id' => $sProduct,
							'group_id' => (int) $aGroups[$aRow['group_id']],
							'title_var' => $aRow['title_var'],
							'description_var' => $aRow['description_var'],					
							'feed_link' => $aRow['feed_link'],
							'php_group_code' => (empty($aRow['php_group_code']) ? null : Phpfox::getLib('parse.format')->phpCode($aRow['php_group_code'])),
							'php_view_code' => Phpfox::getLib('parse.format')->phpCode($aRow['php_view_code']),	
							'is_active' => (int) $aRow['is_active'],
							'is_site_wide' => (int) $aRow['is_site_wide']
						)
					);
				}
			}
		}
	}
	
	public function getProfileSettings()
	{
		return array(
			'rss.display_on_profile' => array(
				'phrase' => Phpfox::getPhrase('user.display_rss_subscribers_count')					
			),
			'rss.can_subscribe_profile' => array(
				'phrase' => Phpfox::getPhrase('user.subscribe_to_your_rss_feed'),
				'default' => '1',
				'no_user' => true	
			)			
		);
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
		if ($sPlugin = Phpfox_Plugin::get('rss.service_callback__call'))
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
