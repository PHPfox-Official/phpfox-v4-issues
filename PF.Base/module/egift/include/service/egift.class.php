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
class Egift_Service_Egift extends Phpfox_Service
{

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('egift_category');
		/* This array holds the sizes for the thumbnails of the egifts */
		$this->_aSizes = array(120);
	}

	/**
	 * Getter function that returns a list of categories.
	 * @param bool $bHideEmpty Should we remove empty categories?
	 * @return array
	 */
	public function getCategories($bHideEmpty = false)
	{
		$sCacheId = $this->cache()->set('egift_category');
		if (!($aCategories = $this->cache()->get($sCacheId)))
		{
			$aCategories = $this->database()
							->select('ec.*, eg.egift_id')
							->leftjoin(Phpfox::getT('egift'), 'eg', 'eg.category_id=ec.category_id')
							->group('ec.category_id')
							->order('ec.ordering ASC')
							->from($this->_sTable, 'ec')
							->execute('getSlaveRows');
			if (!is_array($aCategories))
			{
				$aCategories = array();
			}
			foreach ($aCategories as $iKey => $aCat)
			{
				$aPhraseIds = $this->database()->select('phrase_id, language_id, text')
								->from(Phpfox::getT('language_phrase'))
								->where('module_id = "egift" AND var_name = "' . str_replace('egift.', '', $aCat['phrase']) . '"')
								->execute('getSlaveRows');
				foreach ($aPhraseIds as $aPhrase)
				{
					$aCategories[$iKey]['phrase_ids'][$aPhrase['language_id']] = array(
						'phrase_id' => $aPhrase['phrase_id'],
						'text' => $aPhrase['text']);
					/* Not needed anymore but lets leave it for safety */
					if (preg_match('/\{phrase var=/', $aPhrase['text']))
					{
						$aCategories[$iKey]['phrase_ids'][$aPhrase['language_id']]['text'] = str_replace(array('{phrase var=', '\'', '"', '}'), '', $aPhrase['text']);
					}
				}
			}
			$this->cache()->save($sCacheId, $aCategories);
		}
		if (!is_array($aCategories))
		{
			$aCategories = array();
		}
		if ($bHideEmpty)
		{
			foreach ($aCategories as $iKey => $aCat)
			{
				if (!isset($aCat['egift_id']) || empty($aCat['egift_id']))
				{
					unset($aCategories[$iKey]);
				}
			}
		}
		/* Now we make sure there is at least an empty string for the missing languages */
		return $aCategories;
	}

	/**
	 * Gets one single category
	 * @param int $iId
	 * @return array
	 */
	public function getCategoryById($iId)
	{
		$aCategories = $this->getCategories();
		foreach ($aCategories as $aCategory)
		{
			if ($aCategory['category_id'] == $iId)
			{
				return $aCategory;
			}
		}
		return array();
	}

	/**
	 * This function returns every egift available grouped by category and with
	 * the prices unserialized
	 * @return array
	 */
	public function getEgifts()
	{
		$sCacheId = $this->cache()->set('egift_item');
		if (!($aEgifts = $this->cache()->get($sCacheId)))
		{
			$aOut = array();
			$aEgifts = $this->database()->select('*')
							->join($this->_sTable, 'ec', 'ec.category_id = e.category_id')
							->from(Phpfox::getT('egift'), 'e')
							->execute('getSlaveRows');

			foreach ($aEgifts as $aGift)
			{
				// http://www.phpfox.com/tracker/view/14742/
				if(Phpfox::getParam('core.allow_cdn'))
				{
					$aGift['server_id'] = Phpfox::getLib('cdn')->getServerId();
				}
				else
				{
					$aGift['server_id'] = 0;
				}
				
				$aGift['price'] = unserialize($aGift['price']);
				$aOut[Phpfox::getPhrase($aGift['phrase'])][] = $aGift;
			}

			$this->cache()->save($sCacheId, $aOut);
			$aEgifts = $aOut;
		}
		if (!is_array($aEgifts))
		{
			$aEgifts = array();
		}
		return $aEgifts;
	}

	/**
	 * Gets a gift for editing. It accepts an optional second param to get the
	 * gift from there.
	 * Careful, this function serves very specific purposes.
	 * @param int $iEdit
	 * @param array $aCache Optional
	 * @param array $aCategories (Optional) If present, this function searches for the category of iEdit
	 * @return array or false
	 */
	public function getForEdit($iEdit, $aCache = array(), $aCategories = array())
	{
		foreach ($aCache as $sCategory => $aCategory)
		{
			foreach ($aCategory as $aGift)
			{
				if ($aGift['egift_id'] == $iEdit)
				{
					if (!empty($aCategories) && is_array($aCategories))
					{
						foreach ($aCategories as $aCat)
						{
							if ($aGift['category_id'] == $aCat['category_id'])
							{
								$aGift['category'] = $aCat;
							}
						}
					}
					return $aGift;
				}
			}
		}
		$aCache = $this->getEgifts();
		/* Yes, it could be recursive but to allow only one step makes little sense */
		foreach ($aCache as $sCategory => $aCategory)
		{
			foreach ($aCategory as $aGift)
			{
				if ($aGift['category_id'] == $iEdit)
				{
					return $aGift;
				}
			}
		}
		return false;
	}

	/** Gets only one gift
	 * @param int $iId
	 */
	public function getEgift($iId)
	{
		$aCache = $this->getEgifts();
		foreach ($aCache as $sCategory => $aCategory)
		{
			foreach ($aCategory as $aGift)
			{
				if ($aGift['egift_id'] == $iId)
				{
					return $aGift;
				}
			}
		}
		return array();
	}

	/**
	 * Gets the invoice for when processing the callback from paypal
	 * @param int $iId
	 */
	public function getEgiftInvoice($iId)
	{
		return $this->database()->select('*')
				->from(Phpfox::getT('egift_invoice'))
				->where('invoice_id = ' . (int) $iId)
				->execute('getSlaveRow');
	}

	/**
	 * This function returns the cost of an egift in the currency specified by the user
	 * @param int $iEgift egift_id
	 * @return int|float price
	 */
	public function getCost($iEgift)
	{
		$aGift = $this->getForEdit($iEgift, $this->getEgifts());
		if (isset($aGift['price'][Phpfox::getService('user')->getCurrency()]))
		{
			return $aGift['price'][Phpfox::getService('user')->getCurrency()];
		}
		return 0;
	}

	/**
	 * This function returns an array with all the ecards that this user has sent, 
	 * in cronological order (newer first), with their invoice if available
	 * @param int $iUser 
	 * @return array
	 */
	public function getSentEcards($iUser)
	{
		$aAll = $this->database()->select('*, ei.status AS invoice_status')
						->from(Phpfox::getT('friend_birthday'), 'fb')
						->leftjoin(Phpfox::getT('egift_invoice'), 'ei', 'ei.birthday_id = fb.birthday_id')
						->leftjoin(Phpfox::getT('user'), 'u', 'u.user_id = fb.birthday_user_receiver')
						->where('fb.birthday_user_sender = ' . (int) $iUser)
						->execute('getSlaveRows');
		return $aAll;
	}

	/**
	 * This function is similar to getSentEcards except this one is tailored to the adminCP
	 * the information it gets is different, allows more filters and groups information differently.
	 * Its purpsoe is to get information about invoices
	 */
	public function getInvoices()
	{
		$aInvoices = $this->database()->select('ei.*, ' . Phpfox::getUserField('userTo', 'to_') . ',' . Phpfox::getUserField('userFrom', 'from_'))
						->from(Phpfox::getT('egift_invoice'), 'ei')
						->join(Phpfox::getT('user'), 'userTo', 'userTo.user_id = ei.user_to')
						->join(Phpfox::getT('user'), 'userFrom', 'userFrom.user_id = ei.user_from')
						->order('ei.invoice_id DESC')
						->execute('getSlaveRows');

		foreach ($aInvoices as $sKey => $aInvoice)
		{
			$aInvoices[$sKey]['from'] = array();
			$aInvoices[$sKey]['to'] = array();
			foreach ($aInvoice as $sField => $sValue)
			{
				if (strpos($sField, 'from_') !== false)
				{
					$aInvoices[$sKey]['from'][str_replace('from_', '', $sField)] = $sValue;
					unset($aInvoices[$sKey][$sField]);
				}
				if (strpos($sField, 'to_') !== false)
				{
					$aInvoices[$sKey]['to'][str_replace('to_', '', $sField)] = $sValue;
					unset($aInvoices[$sKey][$sField]);
				}
				
			}
		}

		return $aInvoices;
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
		if ($sPlugin = Phpfox_Plugin::get('egift.service_egift__call'))
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
