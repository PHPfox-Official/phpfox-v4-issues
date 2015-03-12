<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * phpFox Process
 * Class is used to import/export modules. Used mainly in development.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: process.class.php 6599 2013-09-06 08:18:37Z Miguel_Espinoza $
 */
class Phpfox_Process
{
	/**
	 * Exports phpFox XML data.
	 *
	 * @return string XML output.
	 */
	public function export()
	{
		$aRows = Phpfox::getLib('database')->select('version_id, ordering')
			->from(Phpfox::getT('version'))
			->execute('getRows');
		
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('versions');
			
		foreach ($aRows as $aSetting)
		{
			$oXmlBuilder->addTag('version', '', array(
				'version_id' => $aSetting['version_id'],
				'ordering' => $aSetting['ordering']			
			));			
		}	
		$oXmlBuilder->closeGroup();
				
		return $oXmlBuilder->output();
	}		
	
	/**
	 * Import XML data.
	 *
	 * @param array $aVals ARRAY of XML data.
	 * @param bool $bMissingOnly TRUE to import only missing data.
	 * @return bool Always returns TRUE.
	 */
	public function import($aVals, $bMissingOnly = false)
	{		
		$aCache = array();
		if ($bMissingOnly)
		{			
			$aRows = Phpfox::getLib('database')->select('version_id')
				->from(Phpfox::getT('version'))
				->execute('getRows', array(
					'free_result' => true
				));			
			foreach ($aRows as $aRow)
			{
				$aCache[$aRow['version_id']] = $aRow['version_id'];
			}		
		}
		
		$aSql = array();	
		foreach ($aVals['version'] as $aVal)
		{
			if ($bMissingOnly && isset($aCache[$aVal['version_id']]))
			{
				continue;
			}			
			
			$aSql[] = array(	
				$aVal['version_id'],
				$aVal['ordering']
			);
		}
			
		if ($aSql)
		{	
			Phpfox::getLib('database')->multiInsert(Phpfox::getT('version'), array(
				'version_id',
				'ordering'
			), $aSql);				
		}
		
		return true;
	}
}

?>