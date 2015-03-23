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
 * @version 		$Id: process.class.php 405 2009-04-15 13:10:28Z Raymond_Benc $
 */
class Video_Service_Category_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('video_category');
	}
	
	public function add($aVals)
	{
		if (empty($aVals['name']))
		{
			return Phpfox_Error::set('Provide a category name.');
		}
		Phpfox::getService('ban')->checkAutomaticBan($aVals['name']);
		$oParseInput = Phpfox::getLib('parse.input');
		
		$iId = $this->database()->insert($this->_sTable, array(
				'parent_id' => (!empty($aVals['parent_id']) ? (int) $aVals['parent_id'] : 0),
				'is_active' => 1,
				'name' => $oParseInput->clean($aVals['name'], 255),
				// 'name_url' => $oParseInput->cleanTitle($aVals['name']),
				'time_stamp' => PHPFOX_TIME
			)
		);
		
		$this->cache()->remove('video', 'substr');
		
		return $iId;
	}
	
	public function update($iId, $aVals)
	{
		$this->database()->update($this->_sTable, array('name' => Phpfox::getLib('parse.input')->clean($aVals['name'], 255), 'parent_id' => (int) $aVals['parent_id']), 'category_id = ' . (int) $iId);
		
		$this->cache()->remove('video', 'substr');
		
		return true;
	}
	
	public function delete($iId)
	{
		$this->database()->update($this->_sTable, array('parent_id' => 0), 'parent_id = ' . (int) $iId);
		
                /* http://www.phpfox.com/tracker/view/6349/ 
                 * To fix this we can create a setting letting the admin choose 
                 * whether to delete the videos belonging to the category being
                 * deleted or to simply remove the category from them
                 */
                if ( false /* Phpfox::getParam('video.keep_video_after_category_delete') */)
                {
                    $this->database()->delete($this->_sTable, 'category_id = ' . (int) $iId);
                    $this->database()->delete(Phpfox::getT('video_category_data'), 'category_id = ' . (int)$iId);
                    $this->cache()->remove('video', 'substr');
                    return true;
                }
		$aVideos = $this->database()->select('m.video_id, m.user_id, m.image_path')
			->from(Phpfox::getT('video_category_data'), 'mcd')
			->join(Phpfox::getT('video'), 'm', 'm.video_id = mcd.video_id')
			->where('mcd.category_id = ' . (int) $iId)
			->execute('getRows');		
			
		foreach ($aVideos as $aVideo)
		{
			Phpfox::getService('video.process')->delete($aVideo['video_id'], $aVideo);
		}
		
		$this->database()->delete($this->_sTable, 'category_id = ' . (int) $iId);
		
		$this->cache()->remove('video', 'substr');
		
		return true;
	}
	
	public function updateOrder($aVals)
	{
		foreach ($aVals as $iId => $iOrder)
		{
			$this->database()->update($this->_sTable, array('ordering' => $iOrder), 'category_id = ' . (int) $iId);
		}
		
		$this->cache()->remove('video', 'substr');
		
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
		if ($sPlugin = Phpfox_Plugin::get('video.service_category_process__call'))
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