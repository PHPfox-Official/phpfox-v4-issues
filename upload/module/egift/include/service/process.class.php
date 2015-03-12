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
 * @package 		Phpfox_Service
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Egift_Service_Process extends Phpfox_Service
{

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		
	}

	/**
	 * This function stores categories in the database and clears cache. It only stores language phrases so
	 * if a category is going to be added it will create a language phrase for it.
	 * In the language_phrase table the records are stored as the final string, even if what we got was a
	 * language phrase we parse it before hand.
	 * @param array $aTitles
	 * @return bool
	 */
	public function addCategory($aTitles)
	{
		
		if (!is_array($aTitles))
		{
			return Phpfox_Error::set('Name must be an array');
		}

		$sTemp = reset($aTitles['lang']);
		$iMatch = preg_match("/\{phrase var='(.*)'/i", $sTemp, $aMatch);
		if (false && !empty($sTemp) && ($iMatch))
		{
			/* In this case the first phrase is a language phrase, we will use this for every
			 * language available
			 */
			foreach ($aTitles as $sLangId => $sTitle)
			{
				$aTitles[$sLangId] = Phpfox::getPhrase($aMatch[1]);
			}
		}
		//else
		{

			/* In this case every entry is a human phrase so we turn them into a language phrase */
			/* First we insert a dummy value to figure out the auto_increment */
			$aInsert= array('phrase' => '');
			if (isset($aTitles['do_schedule']) && $aTitles['do_schedule'] == 1)
			{				
				$iStart = mktime(0,0,0, (isset($aTitles['start_month']) && !empty($aTitles['start_month']) ? (int)$aTitles['start_month'] : date('m')), (isset($aTitles['start_day']) && !empty($aTitles['start_day']) ? (int)$aTitles['start_day'] : date('d')),(isset($aTitles['start_year']) && !empty($aTitles['start_year']) ? (int)$aTitles['start_year'] : date('Y')));
				$iEnd = mktime(23,59,59, (isset($aTitles['end_month']) && !empty($aTitles['end_month']) ? (int)$aTitles['end_month'] : date('m')), (isset($aTitles['end_day']) && !empty($aTitles['end_day']) ? (int)$aTitles['end_day'] : date('d')),(isset($aTitles['end_year']) && !empty($aTitles['end_year']) ? (int)$aTitles['end_year'] : date('Y')));
				$aInsert['time_start'] = $iStart;
				$aInsert['time_end'] = $iEnd;
			}
			
			$iAutoIncrement = $this->database()->insert(Phpfox::getT('egift_category'), $aInsert);

			/* Make sure that every language has a phrase */
			$sLast = '';
			foreach ($aTitles as $sLangId => $sTitle)
			{
				if (!empty($sTitle))
				{
					$sLast = $sTitle;
					continue;
				}
				if (empty($sTitle) && !empty($sLast))
				{
					$aTitles[$sLangId] = $sLast;
				}
			}

			/* Now we create the array */
			$aParse = array(
				'module' => 'egift|egift',
				'var_name' => 'egift_category_' . $iAutoIncrement,
				'product_id' => 'phpfox',
				'text' => $aTitles['lang']);

			$sPhrase = Phpfox::getService('language.phrase.process')->add($aParse);
			$this->database()->update(Phpfox::getT('egift_category'), array(
				'phrase' => $sPhrase
					), 'category_id = ' . $iAutoIncrement);
		}

		/* Delete cache */
		$this->cache()->remove();
		$this->cache()->remove('egift_category');
		return true;
	}

	/**
	 * Creates an invoice for a non-free egift
	 * @param int $iRefId in v3 this is the feed_id
	 * @param int $iUserTo the user that will receive the egift
	 * @param array $aEgift the egift to send
	 */
	public function addInvoice($iRefId, $iUserTo, $aEgift)
	{
		/* Create an invoice*/
		$iInvoice = $this->database()->insert(Phpfox::getT('egift_invoice'),array(
			'user_from' => Phpfox::getUserId(),
			'user_to' => $iUserTo,
			'egift_id' => $aEgift['egift_id'],
			'birthday_id' => $iRefId,
			'currency_id' => Phpfox::getService('user')->getCurrency(),
			'price' => $aEgift['price'][Phpfox::getService('user')->getCurrency()],
			'time_stamp_created' => PHPFOX_TIME,
			'status' => 'pending'
		));
		
		return $iInvoice;
	}
	
	/**
	 * This function deletes a category and the language phrases associated with it.
	 * @param int $iId
	 * @return bool true on success, Phpfox_Error otherwise
	 */
	public function deleteCategory($iId)
	{
		/* Get the info related to this category */
		$aCategories = Phpfox::getService('egift')->getCategories();
		foreach ($aCategories as $aCat)
		{
			if ($aCat['category_id'] == (int) $iId)
			{
				Phpfox::getService('language.phrase.process')->delete($aCat['phrase'], true);
				$this->database()->delete(Phpfox::getT('egift_category'), 'category_id = ' . $aCat['category_id']);
				$this->cache()->remove('egift_category');
				return true;
			}
		}
		return Phpfox_Error::set('category or phrase not found');
	}

	/**
	 * This function updates language phrases that belong to a category for egifts.
	 * @param array $aVal
	 * @return boolean Success?
	 */
	public function editCategory($aVal)
	{
		
		if (!is_array($aVal['edit']))
		{
			return Phpfox_Error::set('Wrong format to edit a phrase.');
		}

		foreach ($aVal['edit'] as $sLanguage => $iCategory)
		{
			$sValue = reset($iCategory);
			$iCategory = array_keys($iCategory);
			$iCategory = reset($iCategory);

			$aCategory = Phpfox::getService('egift')->getCategoryById($iCategory);
			if (empty($aCategory))
			{
				return Phpfox_Error::set('That category doesnt exist');
			}
			$aVar = explode('.', $aCategory['phrase']);

			/*
			$aPhrase = $this->database()->select('*')
							->from(Phpfox::getT('language_phrase'))
							->where('language_id = "' . Phpfox::getLib('parse.input')->clean($sLanguage) . '" AND module_id = "egift" AND var_name = "' . $aVar[1] . '"')
							->execute('getSlaveRow');
			*/
			$this->database()->update(Phpfox::getT('language_phrase'), array('text' => $sValue), 'language_id = "' . Phpfox::getLib('parse.input')->clean($sLanguage) . '" AND module_id = "egift" AND var_name = "' . $aVar[1] . '"');
			// $bUpdate = Phpfox::getService('language.phrase.process')->update($aPhrase['phrase_id'], $sValue);
		}
		foreach ($aVal['dates'] as $iId => $aDates)
		{
			if (!isset($aDates['do_schedule']) ||  $aDates['do_schedule'] != true)
			{
				$iStart = null;
				$iEnd = null;
			}
			else
			{
				$iStart = mktime(0,0,0, (isset($aDates['start_month']) && !empty($aDates['start_month']) ? (int)$aDates['start_month'] : date('m')), (isset($aDates['start_day']) && !empty($aDates['start_day']) ? (int)$aDates['start_day'] : date('d')),(isset($aDates['start_year']) && !empty($aDates['start_year']) ? (int)$aDates['start_year'] : date('Y')));
				$iEnd = mktime(23,59,59, (isset($aDates['end_month']) && !empty($aDates['end_month']) ? (int)$aDates['end_month'] : date('m')), (isset($aDates['end_day']) && !empty($aDates['end_day']) ? (int)$aDates['end_day'] : date('d')),(isset($aDates['end_year']) && !empty($aDates['end_year']) ? (int)$aDates['end_year'] : date('Y')));
			}
			$this->database()->update(Phpfox::getT('egift_category'), array(
				'time_start' => $iStart,
				'time_end' => $iEnd
			), 'category_id = ' . (int)$iId);
		}
		
		$this->cache()->remove();
		
		return true;
	}

	/**
	 * Adds a gift
	 * @param array $aVals
	 * @return bool
	 * @todo more checks on the incoming values before insert
	 */
	public function addGift($aVals)
	{
		$iSize = 120;
		$oFile = Phpfox::getLib('file');
		$mLoaded = null;
		$oImage = Phpfox::getLib('image');
		$bIsEdit = isset($aVals['egift_id']) && $aVals['egift_id'] > 0;
		$aVals['category'] = (isset($aVals['category']) ? (int)$aVals['category'] : 0);
		$aSQL = array('category_id' => (int) $aVals['category'],
			'user_id' => Phpfox::getUserId(),
			'time_stamp' => PHPFOX_TIME,
			'title' => Phpfox::getLib('parse.input')->clean($aVals['title']),
			'price' => serialize($aVals['currency']));

		if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))
		{
			if (!$oFile->load('file', array('jpg', 'gif', 'png')))
			{
				return Phpfox_Error::set('Could not load file');
			}
			$aSQL['file_path'] = $oFile->upload('file', Phpfox::getParam('egift.dir_egift'), '');
			if ($aSQL['file_path'] == false)
			{
				return Phpfox_Error::set('Could not upload files');
			}

			$oImage->createThumbnail(Phpfox::getParam('egift.dir_egift') . sprintf($aSQL['file_path'], ''), Phpfox::getParam('egift.dir_egift') . sprintf($aSQL['file_path'], '_' . $iSize), $iSize, $iSize);			
			$oImage->createThumbnail(Phpfox::getParam('egift.dir_egift') . sprintf($aSQL['file_path'], ''), Phpfox::getParam('egift.dir_egift') . sprintf($aSQL['file_path'], '_75_square'), 75, 75, false);			
		}

		if ($bIsEdit)
		{
			/* Make sure we delete the old image */
			if (isset($aSQL['file_path']))
			{
				$sOldFile = $this->database()->select('file_path')->from(Phpfox::getT('egift'))->where('egift_id = ' . (int) $aVals['egift_id'])->execute('getSlaveField');
				foreach (Phpfox::getService('egift')->_aSizes as $iSize)
				{
					if (empty($sOldFile))
					{
						continue;
					}
					
					if (file_exists(Phpfox::getParam('egift.dir_egift') . sprintf($sOldFile, $iSize)))
					{
						$oFile->unlink(Phpfox::getParam('egift.dir_egift') . sprintf($sOldFile, $iSize));
					}
				}
				
				if (!empty($sOldFile) && file_exists(Phpfox::getParam('egift.dir_egift') . sprintf($sOldFile, '')))
				{
					$oFile->unlink(Phpfox::getParam('egift.dir_egift') . sprintf($sOldFile, ''));
				}
			}
			$this->database()->update(Phpfox::getT('egift'), $aSQL, 'egift_id = ' . (int) $aVals['egift_id']);
		}
		else
		{
			$this->database()->insert(Phpfox::getT('egift'), $aSQL);
		}

		$this->cache()->remove('egift','substr');
		return true;
	}

	/**
	 * Alias function of addGift
	 */
	public function editGift($aVals)
	{
		return $this->addGift($aVals);
	}

	/**
	 * This function deletes an egift and the images that it uses. It currently does not remove
	 * an entry from the awarded gifts table but it should
	 * @param int $iId `phpfox_egift`.`egift_id`
	 * @return bool Success?
	 */
	public function deleteGift($iId)
	{
		$aSizes = Phpfox::getService('egift')->_aSizes;

		$aGifts = Phpfox::getService('egift')->getEgifts();
		foreach ($aGifts as $sCategory => $aCategory)
		{
			foreach ($aCategory as $aGift)
			{
				if ($aGift['egift_id'] == $iId)
				{
					$oFile = Phpfox::getLib('file');
					foreach (Phpfox::getService('egift')->_aSizes as $iSize)
					{
						if (file_exists(Phpfox::getParam('egift.dir_egift') . sprintf($aGift['file_path'], $iSize)))
						{
							$oFile->unlink(Phpfox::getParam('egift.dir_egift') . sprintf($aGift['file_path'], $iSize));
						}
					}
					if (file_exists(Phpfox::getParam('egift.dir_egift') . sprintf($aGift['file_path'], '')))
					{
						$oFile->unlink(Phpfox::getParam('egift.dir_egift') . sprintf($aGift['file_path'], ''));
					}
					$this->database()->delete(Phpfox::getT('egift'), 'egift_id = ' . (int) $iId);
					$this->cache()->remove('egift_item');
					return true;
				}
			}
		}
		return Phpfox_Error::set('That item does not exist.');
	}

	/**
	 * Sets the order for the categories. This affects only the categories.
	 * @param array $aVals The keys in this array are the category_ids and the values the order to set
	 */
	public function setOrder($aVals)
	{		
		$iCnt = 0;
		foreach ($aVals as $mKey => $mOrdering)
		{
			$iCnt++;

			$this->database()->update(Phpfox::getT('egift_category'),
					array('ordering' => $iCnt),
					'category_id = ' . $this->database()->escape($mKey) . '');
		}
		$this->cache()->remove('egift_category');
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
		if ($sPlugin = Phpfox_Plugin::get('egift.service_process__call'))
		{
			eval($sPlugin);
			return;
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}

}

?>