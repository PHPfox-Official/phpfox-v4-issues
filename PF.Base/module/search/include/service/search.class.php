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
 * @package  		Module_Search
 * @version 		$Id: search.class.php 5616 2013-04-10 07:54:55Z Miguel_Espinoza $
 */
class Search_Service_Search extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function query($sQuery, $iPage, $iTotalShow, $sView = null)
	{
		if ($sView !== null && Phpfox::isModule($sView))
		{
			$aModuleResults = Phpfox::callback($sView . '.globalUnionSearch', $this->preParse()->clean($sQuery));
		}
		else 
		{
			$aModuleResults = Phpfox::massCallback('globalUnionSearch', $this->preParse()->clean($sQuery));
		}
		
		$iOffset = ($iPage * $iTotalShow);
		
		$aRows = $this->database()->select('item.*, ' . Phpfox::getUserField())
				->unionFrom('item')		
				->join(Phpfox::getT('user'), 'u', 'u.user_id = item.item_user_id')
				->limit($iOffset, $iTotalShow)
				->order('item_time_stamp DESC')				
				->execute('getSlaveRows');

		$aResults = array();
		foreach ($aRows as $iKey => $aRow)
		{
			$aResults[] = array_merge($aRow, (array) Phpfox::callback($aRow['item_type_id'] . '.getSearchInfo', $aRow));
		}
		
		if (Phpfox::getParam('core.section_privacy_item_browsing') && !empty($aResults))
		{
			// Check for special filters
			$aToParse = array();
			// Group results by their module
			foreach ($aResults as $aResult)
			{
				$aToParse[$aResult['item_type_id']][] = $aResult['item_id'];
			}


			foreach ($aToParse as $sModule => $aItems)
			{
				if (Phpfox::hasCallback($sModule, 'filterSearchResults'))
				{
					$aNotAllowed = Phpfox::callback($sModule . '.filterSearchResults', $aItems);

					if (!empty($aNotAllowed))
					{
						foreach ($aNotAllowed as $aItem)
						{
							foreach ($aResults as $iKey => $aResult)
							{
								if ($aResult['item_type_id'] == $aItem['item_type_id'] && $aResult['item_id'] == $aItem['item_id'])
								{
									unset($aResults[$iKey]);
								} 
							}
						}
					}
				}
			}
		}
		
		return $aResults;
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
		if ($sPlugin = Phpfox_Plugin::get('search.service_search__call'))
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