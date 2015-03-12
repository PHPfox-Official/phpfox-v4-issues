<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Contact
 * @version 		$Id: process.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Contact_Service_Process extends Phpfox_Service
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('contact_category');
	}

	/**
	 * Adds a category to phpfox_contact_category
	 * The order is not specified so it defaults to 0 as per DB design
	 *
	 * @param unknown_type $sCat
	 * @return unknown
	 */
	public function addCategory($sCat)
	{
		// clean input
		$oFilter = Phpfox::getLib('parse.input');
		$sTitle = $oFilter->clean($sCat, 255);

		// prepare insert array
		$aInsert = array(
			'title' => $sTitle,
		);

		// check for plugins
		(($sPlugin = Phpfox_Plugin::get('contact.service_process_add_start')) ? eval($sPlugin) : false);

		// do the insert
		$iId = $this->database()->insert($this->_sTable, $aInsert);

		// renew cache
		$this->renewCache();
		// check for plugins
		(($sPlugin = Phpfox_Plugin::get('contact.service_process_add_end')) ? eval($sPlugin) : false);

		// return, the DB class returns the insert id on success or 0 on error
		if ($iId > 0) return true;

		return false;
	}

	/**
	 * Deletes one or more category entries from the DB, also renews cache
	 *
	 * @param array $aIds only integers that correspond to their category_id in this->_sTable
	 * @return true
	 */
	public function deleteMultiple($aIds)
	{
		foreach ($aIds as $iId)
		{
			$this->database()->delete($this->_sTable, 'category_id = ' . (int) $iId);
		}
		$this->renewCache();
		return true;
	}

	public function updateMultiple($aCategories)
	{
		$bResult = true;
		foreach ($aCategories as $aCategory)
		{
			$bUpdate = $this->database()->update($this->_sTable, array(
					'title' => $aCategory['title'],
					'ordering' => ((int)$aCategory['ordering'] > 0) ? (int)$aCategory['ordering'] : 0
						), 'category_id = '. (int)$aCategory['category_id']);
			$bResult = $bResult && $bUpdate;

		}
		// renew cache even if the update failed, it may have updated a few only
		$this->renewCache();
		return $bResult;
	}

	public function updateOrdering($aVal)
	{
		foreach ($aVal as $iId => $iPosition)
		{
			$this->database()->update(Phpfox::getT('contact_category'), array('ordering' => (int)$iPosition), 'category_id = ' . (int)$iId);
		}
		$this->renewCache();
	}

	public function renewCache()
	{
		// clean the cache
		$this->cache()->remove('contact_category');
		// reset the cache
		$this->cache()->set('contact_category','contact');
		$this->cache()->save('contact_category', Phpfox::getService('contact.contact')->getCategories());
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
		if ($sPlugin = Phpfox_Plugin::get('contact.service_process__call'))
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