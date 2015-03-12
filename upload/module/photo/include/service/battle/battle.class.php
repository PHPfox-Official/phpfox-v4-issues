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
 * @version 		$Id: battle.class.php 2633 2011-05-30 13:57:44Z Raymond_Benc $
 */
class Photo_Service_Battle_Battle extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('photo');	
	}
	
	public function get($sCategory = null)
	{
		$sSelect = 'p.photo_id, p.server_id, p.destination, p.time_stamp, ' . Phpfox::getUserField();
		
		$aConds = array();
		$aConds[] = 'AND p.privacy = 0 AND p.allow_rate = 1';
		if ($sCategory !== null)
		{
			$sCategoryIds = Phpfox::getService('photo.category')->getAllCategories($sCategory);
				
			if (!empty($sCategoryIds))
			{
				$aConds[] = ' AND pcd.category_id IN (' . $sCategoryIds . ')';
					
				$this->database()->innerJoin(Phpfox::getT('photo_category_data'), 'pcd', 'pcd.photo_id = p.photo_id');
			}
		}	
		
		$aRows = $this->database()->select($sSelect)
			->from($this->_sTable, 'p')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = p.user_id')
			->where($aConds)
			->order('RAND()')			
			->limit(2)
			->execute('getSlaveRows');				
		
		if (!count($aRows))
		{
			return false;
		}
		
		if (count($aRows) < 2)
		{
			return false;
		}
		
		$sMode = (Phpfox::getLib('request')->get('mode') == 'full' ? 'full' : '');
		
		$aPhotos = array();
		foreach ($aRows as $iKey => $aRow)
		{
			if ($iKey === 0)
			{
				$aRow['link'] = Phpfox::getLib('url')->makeUrl('photo.battle', array('w' => $aRow['photo_id'], 'l' => $aRows[1]['photo_id'], 'mode' => $sMode));
			}
			else 
			{
				$aRow['link'] = Phpfox::getLib('url')->makeUrl('photo.battle', array('w' => $aRow['photo_id'], 'l' => $aRows[0]['photo_id'], 'mode' => $sMode));
			}
			
			$aPhotos[($iKey === 0 ? 'one' : 'two')] = $aRow;
		}
			
		return $aPhotos;		
	}
	
	private function _build($aPhoto)
	{
		$sJs = '';	
		foreach ($aPhoto as $sKey => $sValue)
		{
			if ($sKey == 'destination')
			{
				$sValue = Phpfox::getLib('image.helper')->display(array(
						'server_id' => $aPhoto['server_id'],
						'path' => 'photo.url_photo',
						'file' => $aPhoto['destination'],
						'suffix' => '_500',
						'max_width' => 400,
						'max_height' => 400
					)
				);				
			}
			elseif ($sKey == 'full_name')
			{
				$sValue = '<a href="' . Phpfox::getLib('url')->makeUrl($aPhoto['user_name']) . '">' . $aPhoto['full_name'] . '</a>';
			}				
			elseif ($sKey == 'time_stamp')
			{
				$sValue = Phpfox::getTime(Phpfox::getParam('photo.photo_image_details_time_stamp'), $aPhoto['time_stamp']);
			}
			
			$sJs .= $sKey . ': \'' . str_replace("'", "\'", $sValue) . '\',';
		}						
		$sJs = rtrim($sJs, ',');			
		
		return $sJs;
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
		if ($sPlugin = Phpfox_Plugin::get('photo.service_battle_battle__call'))
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