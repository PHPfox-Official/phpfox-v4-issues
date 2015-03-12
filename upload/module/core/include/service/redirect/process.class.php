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
 * @version 		$Id: process.class.php 1496 2010-03-05 17:15:05Z Raymond_Benc $
 */
class Core_Service_Redirect_Process extends Phpfox_Service
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}

	/**
	 * Adds a redirection rule
	 * @param string $sRedirect Table table that stores the redirections
	 * @param string $sOldTitle Previous title
	 * @param string $sNewTitle New title
	 * @param integer $iItemId Item id (blog_id, poll_id, etc)
	 * @param string $sItemTable Database table that stores the main item
	 * @param string $sItemField Field in $sItemTable that stores the title_url of the item
	 * @return boolean Success
	 */
	public function addRedirect($sRedirectTable, $sOldTitle, $sNewTitle, $iItemId, $sItemTable, $sItemField)
	{
		if ($sOldTitle == $sNewTitle)
		{
			return Phpfox_Error::set('Titles are not different');;// this should never happen
		}
		// check if the new title is in use at sItemTable
		$iExisting = $this->database()->select('COUNT(' . $sItemField . ')')
				->from($sItemTable)
				->where($sItemField . ' = "' . $sNewTitle . '"')
				->execute('getSlaveField');
		if ($iExisting > 0)
		{
			return Phpfox_Error::set('This should not happen'); // this should never happen
		}

		// check for cyclic redirects
		$aRedirects = $this->database()->select('*')
				->from($sRedirectTable)
				->where('old_title = "' . $sNewTitle .'"')
				->execute('getSlaveRows');
		
		if (count($aRedirects) > 0)
		{
				return Phpfox_Error::set('This redirect would cause a loop');
				
		}

	    $this->database()->insert($sRedirectTable, array(
			'old_title' => $sOldTitle,
			'new_title' => $sNewTitle,
			'item_id' => (int)$iItemId
		));
		return true;
	}	
		
	/** This function updates the site wide rewrites, not the redirects.
	 * 	This is called from AdminCP -> Tools -> SEO -> URL Rewrite
	 * 	@version 3.7.0
	 * 	@param $aRewrites array [ {rewrite_id: #, original_url: string, replacement_url : string }, {... ]
	 */ 
	public function updateRewrites($aRewrites)
	{
		Phpfox::isAdmin(true);
		$oParse = Phpfox::getLib('parse.input');
		foreach ($aRewrites as $aRewrite)
		{
			if (!isset($aRewrite['rewrite_id']) || ( !isset($aRewrite['remove']) && (!isset($aRewrite['original_url']) || !isset($aRewrite['replacement_url'])) ))
			{
				continue;
			}
			if ( !isset($aRewrite['remove']) && strpos($aRewrite['original_url'], ' ') !== false)
			{
				Phpfox_Error::set('This is not a valid url: "' . $aRewrite['original_url'] . '"');
				continue;
			}
			if ( !isset($aRewrite['remove']) && strpos($aRewrite['replacement_url'], ' ') !== false)
			{
				Phpfox_Error::set('This is not a valid url: "' . $aRewrite['replacement_url'] . '"');
				continue;
			}
			
			// Invalid params from the otiringal url
			if (isset($aRewrite['original_url']))
			{
				$aRewrite['original_url'] = str_replace('_', '', $aRewrite['original_url']);
			}
					
			if (is_numeric($aRewrite['rewrite_id']) && $aRewrite['rewrite_id'] > 0 && ( (int)$aRewrite['rewrite_id'] == $aRewrite['rewrite_id']))
			{
				if (isset($aRewrite['remove']))
				{
					$this->database()->delete(Phpfox::getT('rewrite'), 'rewrite_id = ' . (int)$aRewrite['rewrite_id']);
				}
				else
				{
					$aRewrite['original_url'] = trim($aRewrite['original_url'], '/');
					$aRewrite['replacement_url'] = trim($aRewrite['replacement_url'], '/');
					
					$this->database()->update(Phpfox::getT('rewrite'), array(
						'url' => $oParse->clean($aRewrite['original_url']),
						'replacement' => $oParse->clean($aRewrite['replacement_url'])
					), 'rewrite_id = ' . (int)$aRewrite['rewrite_id']);
				}
			}
			else
			{
				$aRewrite['original_url'] = trim($aRewrite['original_url'], '/');
				$aRewrite['replacement_url'] = trim($aRewrite['replacement_url'], '/');
				
				$this->database()->insert(Phpfox::getT('rewrite'), array(
					'url' => $oParse->clean($aRewrite['original_url']),
					'replacement' => $oParse->clean($aRewrite['replacement_url'])
				));
			}			
		}
		$iCacheId = Phpfox::getLib('cache')->set('rewrite');
		Phpfox::getLib('cache')->remove( $iCacheId );
		$iReverseCacheId = Phpfox::getLib('cache')->set('rewrite_reverse');
		Phpfox::getLib('cache')->remove( $iReverseCacheId );
		
		return true;
	}

	public function removeRewrite($iId)
	{
		$this->database()->delete(Phpfox::getT('rewrite'), 'rewrite_id = ' . (int) $iId);
		Phpfox::getLib('cache')->remove('rewrite');
		Phpfox::getLib('cache')->remove('rewrite_reverse');

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
		if ($sPlugin = Phpfox_Plugin::get('core.service_redirect_process__call'))
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