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
 * @package  		Module_Page
 * @version 		$Id: process.class.php 2525 2011-04-13 18:03:20Z Raymond_Benc $
 */
class Page_Service_Process extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('page');
	}
	
	public function add($aVals, $bIsUpdate = false, $iUserId = null)
	{
		$oFilter = Phpfox::getLib('parse.input');
		Phpfox::getService('ban')->checkAutomaticBan($aVals['title'] . ' ' . $aVals['text']);

		$aDisallow = array();
		$aCanModify = array();
		$aUserGroups = Phpfox::getService('user.group')->get();
		if (isset($aVals['allow_access']) || isset($aVals['can_modify']))
		{			
			foreach ($aUserGroups as $aUserGroup)
			{
				if (isset($aVals['allow_access']) && !in_array($aUserGroup['user_group_id'], $aVals['allow_access']))
				{
					$aDisallow[] = $aUserGroup['user_group_id'];
				}			
			}			
		}
		else 
		{
			foreach ($aUserGroups as $aUserGroup)
			{
				$aDisallow[] = $aUserGroup['user_group_id'];
			}				
		}		
		
		// Make sure the phrase is really a phrase
		if (isset($aVals['is_phrase']) && $aVals['is_phrase'])
		{
			if (!Phpfox::getLib('locale')->isPhrase($aVals['title']))
			{
				$aVals['is_phrase'] = 0;
			}
		}
		
		$aVals['disallow_access'] = (count($aDisallow) ? serialize($aDisallow) : null);		
		
		// Fix HTML
		$aVals['text_parsed'] = Phpfox::getLib('parse.input')->fixHtml($aVals['text']);		
		
		// BBCode
		if (isset($aVals['parse_bbcode']))
		{
			$oFilterBbcode = Phpfox::getLib('parse.bbcode');
			$aVals['text_parsed'] = $oFilterBbcode->preParse($aVals['text_parsed']);
			$aVals['text_parsed'] = $oFilterBbcode->parse($aVals['text_parsed']);
		}
		
		// Parse Emoticons
		if (isset($aVals['parse_emoticons']) && Phpfox::isModule('emoticon'))
		{
			$aVals['text_parsed'] = Phpfox::getService('emoticon')->parse($aVals['text_parsed']);
		}
		
		// Allowed to use PHP?
		if (!isset($aVals['parse_php']))
		{
			$aVals['text_parsed'] = preg_replace("/<\?[php|=| ](.*?)\?>/is", "", $aVals['text_parsed']);
			$aVals['parse_php'] = 0;
		}
		else 
		{
			$aVals['text_parsed'] = preg_replace("/<\?(php|=| )(.*?)\?>/is", "{php}\\2{/php}", $aVals['text_parsed']);
		}		
		
		// Add Breaks: <br />
		if (isset($aVals['parse_breaks']) && !isset($aVals['parse_wiki']))
		{
			$aVals['text_parsed'] = Phpfox::getLib('parse.input')->addBreak($aVals['text_parsed']);	
		}		
		
		/*
		if (isset($aVals['parse_wiki']))
		{
			$aVals['text_parsed'] = $aVals['text_parsed'] . "\n";
			$aVals['text_parsed'] = Phpfox::getLib('parse.wiki')->parse($aVals['text_parsed']);
		}
		*/
		
		if (preg_match('/flowplayer\.swf\?config=/i', $aVals['text_parsed']))
		{
			preg_match_all('/flowplayer\.swf\?config=\{(.*?)\}/i', $aVals['text_parsed'], $aFlowMatches);
			foreach ($aFlowMatches[0] as $sFlowMatch)
			{
				$aVals['text_parsed'] = str_replace($sFlowMatch, str_replace(array('{', '}'), array('{left_curly}', '{right_curly}'), $sFlowMatch), $aVals['text_parsed']);
			}			
		}
		
		// Remove comments to allow SMARTY type code
		// if (preg_match("/{(.*?)}/ie", $aVals['text']))
		{			
			$aVals['text_parsed'] = Phpfox::getLib('template.cache')->parse($aVals['text_parsed'], true);
		}		
		
		/*
		p(htmlspecialchars($aVals['text_parsed']));
		exit;		
		*/
		
		$aVals['keyword'] = (!empty($aVals['keyword']) ? $oFilter->clean($aVals['keyword']) : null);
		$aVals['description'] = (!empty($aVals['description']) ? $oFilter->clean($aVals['description']) : null);		
		$aVals['title'] = $oFilter->clean($aVals['title'], 255);		
		$aVals['total_tag'] = ((Phpfox::isModule('tag') && isset($aVals['tag_list'])) ? Phpfox::getService('tag')->getCount($aVals['tag_list']) : 0);
		
		$aSql = array(		
			'module_id',	
			'product_id',
			'is_active' => 'int',
			'is_phrase' => 'int',
			'parse_php' => 'int',
			'has_bookmark' => 'int',
			'add_view' => 'int',
			'full_size' => 'int',
			'title',
			'title_url',
			'disallow_access',
			'total_attachment' => 'int',
			'total_tag' => 'int'
		);
		
		$aSqlText = array(			
			'keyword',
			'description',
			'text',
			'text_parsed'
		);		
		
		if (empty($aVals['module_id']))
		{
			$aVals['module_id'] = 'core';
		}
		
		if ($bIsUpdate)
		{
			// If we uploaded any attachments make sure we update the 'item_id'
			if (Phpfox::isModule('attachment') && !empty($aVals['attachment']))
			{
				Phpfox::getService('attachment.process')->updateItemId($aVals['attachment'], Phpfox::getUserId(), $aVals['page_id']);
			}			
			
			$aVals['total_attachment'] = Phpfox::isModule('attachment') ? Phpfox::getService('attachment')->getCountForItem($aVals['page_id'], 'page') : 0;
			$sNewTitle = Phpfox::getLib('parse.input')->cleanTitle($aVals['title_url']);	
			if (isset($aVals['old_url']) && ($aVals['old_url'] != $sNewTitle))
			{
				$aVals['title_url'] = Phpfox::getService('page')->prepareTitle($aVals['title_url']);
			}
			
			$iId = $aVals['page_id'];
			$this->database()->process($aSql, $aVals)->update($this->_sTable, 'page_id = ' . (int) $aVals['page_id']);			
			$this->database()->process($aSqlText, $aVals)->update(Phpfox::getT('page_text'), 'page_id = ' . (int) $aVals['page_id']);
			
			Phpfox::getService('page.log.process')->add($iId, Phpfox::getUserId());
			
			if (Phpfox::isModule('tag'))
			{
				Phpfox::getService('tag.process')->update('page', $iId, $iUserId, (!Phpfox::getLib('parse.format')->isEmpty($aVals['tag_list']) ? $aVals['tag_list'] : null));				
			}
			
			if (isset($aVals['menu_id']) && $aVals['menu_id'] > 0)
			{
				$this->database()->update(Phpfox::getT('menu'), array('url_value' => $aVals['title_url']), 'menu_id = ' . (int) $aVals['menu_id']);
				$this->cache()->remove('menu', 'substr');
			}
		}
		else 
		{
			$aVals['added'] = PHPFOX_TIME;
			$aVals['user_id'] = Phpfox::getUserId();			
			$aVals['title_url'] = Phpfox::getService('page')->prepareTitle($aVals['title_url']);
			$aVals['total_attachment'] = (Phpfox::isModule('attachment')) ? Phpfox::getService('attachment')->getCount($aVals['attachment']) : 0;
			
			$aSql[] = 'user_id';
			$aSql[] = 'added';
			
			$iId = $this->database()->process($aSql, $aVals)->insert($this->_sTable);
			
			$aSqlText[] = 'page_id';
			$aVals['page_id'] = $iId;
			$this->database()->process($aSqlText, $aVals)->insert(Phpfox::getT('page_text'));
			
			if (Phpfox::isModule('tag') && isset($aVals['tag_list']) && !empty($aVals['tag_list']))
			{
				Phpfox::getService('tag.process')->add('page', $iId, Phpfox::getUserId(), $aVals['tag_list']);
			}			
			
			// If we uploaded any attachments make sure we update the 'item_id'
			if (Phpfox::isModule('attachment') && !empty($aVals['attachment']))
			{
				Phpfox::getService('attachment.process')->updateItemId($aVals['attachment'], Phpfox::getUserId(), $iId);
			}				
		}
		
		$this->cache()->remove('page', 'substr');

		return $aVals['title_url'];
	}	
	
	public function update($iId, $aVals, $iUserId = null)
	{
		$aVals['page_id'] = $iId;
		
		return $this->add($aVals, true, $iUserId);
	}	
	
	public function updateActivity($aVals)
	{		
		foreach ($aVals as $iId => $aVal)
		{
			$this->database()->update($this->_sTable, array(
				'is_active' => (isset($aVal['is_active']) ? 1 : 0)
			), 'page_id = ' . (int) $iId);

			$this->database()->update(Phpfox::getT('menu'), array(
				'is_active' => (isset($aVal['is_active']) ? 1 : 0)
			), "url_value = '" . $this->database()->escape($aVal['title_url']) . "'");			
		}
		
		$this->cache()->remove('page', 'substr');
		$this->cache()->remove('menu', 'substr');
		
		return true;
	}
	
	public function updateView($iId)
	{
		$this->database()->query("
			UPDATE " . $this->_sTable . "
			SET total_view = total_view + 1
			WHERE page_id = " . (int) $iId . "
		");			
		
		return true;
	}	
	
	public function delete($iId)
	{
		$aPage = Phpfox::getService('page')->getPage($iId);
		if (isset($aPage['page_id']))
		{
			$this->database()->delete($this->_sTable, 'page_id = ' . $aPage['page_id']);
			$this->database()->delete(Phpfox::getT('page_log'), 'page_id = ' . $aPage['page_id']);
			$this->database()->delete(Phpfox::getT('page_text'), 'page_id = ' . $aPage['page_id']);
			
			Phpfox::getService('admincp.menu.process')->delete($aPage['title_url'], true);
			
			if (Phpfox::isModule('attachment'))
			{
			    Phpfox::getService('attachment.process')->deleteForItem(null, $aPage['page_id'], 'page');
			}
			
			(Phpfox::isModule('tag') ? Phpfox::getService('tag.process')->deleteForItem($aPage['user_id'], $aPage['page_id'], 'page') : null);
			
			$this->cache()->remove('page', 'substr');
			$this->cache()->remove('menu', 'substr');			
		}		
		
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
		if ($sPlugin = Phpfox_Plugin::get('page.service_process__call'))
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