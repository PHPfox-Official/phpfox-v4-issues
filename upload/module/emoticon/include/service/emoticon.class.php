<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Main class for emoticons. Used to display and parse emoticons.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Emoticon
 * @version 		$Id: emoticon.class.php 3426 2011-11-02 12:18:25Z Miguel_Espinoza $
 */
class Emoticon_Service_Emoticon extends Phpfox_Service 
{
	/**
	 * Array of emoticons used in the text parser
	 *
	 * @var array
	 */
	private $_aEmoticons = array();
	
	/**
	 * Class Constructor
	 *
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('emoticon');
	}

	/**
	 * Gets the images for a given package
	 * @param int $iId
	 * @return array
	 */
	public function getPackages($iId = null)
	{
		if ($iId !== null)
		{
			$this->database()
				->where('ep.package_path = \'' . Phpfox::getLib('parse.input')->clean($iId) . '\'')
				->limit(1);
		}
		return $this->database()
			->select('COUNT(e.emoticon_id) as total, ep.is_active, ep.package_path, ep.product_id, ep.package_name')
			->from(Phpfox::getT('emoticon_package'), 'ep')
			->leftjoin($this->_sTable, 'e', 'e.package_path=ep.package_path')
			->group('ep.package_path')
			->execute('getSlaveRows');
		
	}

	/**
	 * gets the list of emoticons given a package_PATH
	 * @param int $iPackage
	 * @return array
	 */
	public function getEmoticons($iPackage)
	{
		return $this->database()
			->select('e.*, ep.package_path, ep.product_id, ep.package_name')
			->from(Phpfox::getT('emoticon_package'), 'ep')
			->join($this->_sTable, 'e', 'e.package_path=ep.package_path')
			->where('ep.package_path = \'' . $this->database()->escape($iPackage) . '\'')
			->order('e.ordering ASC')
			->execute('getSlaveRows');
	}

	/**
	 * Gets one emoticon for editing
	 * @param int $iId
	 * @return array
	 */
	public function getEmoticon($iId)
	{
		return $this->database()
			->select('*')
			->from($this->_sTable)
			->where('emoticon_id = ' . (int)$iId)
			->execute('getSlaveRow');
	}

	/**
	 * Emoticon preview, used to display all the emoticons that can be used on the site.
	 * Usually a pop-up of some kind.
	 *
	 * @return array Array of emoticons
	 */
	public function getPreview()
	{
		$sCacheId = $this->cache()->set('emoticon');
		
		if (!($aRows = $this->cache()->get($sCacheId)))
		{
			(($sPlugin = Phpfox_Plugin::get('emoticon.service_emoticon_getpreview_start')) ? eval($sPlugin) : false);
			
			$aRows = $this->database()->select('e.title, e.text, e.image, ep.package_path')
				->from($this->_sTable, 'e')
				->join(Phpfox::getT('emoticon_package'), 'ep', 'ep.package_path = e.package_path')
				->order('ordering ASC')
				->where('ep.is_active = 1') // only get active packages
				->execute('getRows');
				
			(($sPlugin = Phpfox_Plugin::get('emoticon.service_emoticon_getpreview_end')) ? eval($sPlugin) : false);
			
			$this->cache()->save($sCacheId, $aRows);
		}
		
		return $aRows;
	}
	
	/**
	 * Parse text and replace it with the emoticon image
	 *
	 * @param string $sTxt is the text we are going to parse
	 * @return string Parsed text with emoticons in place
	 */
	public function parse($sTxt)
	{
		//d($sTxt); die();
		if (!$this->_aEmoticons)
		{
			$sCacheId = $this->cache()->set('emoticon_parse');
			if (!($this->_aEmoticons = $this->cache()->get($sCacheId)))
			{
				$aRows = $this->database()->select('e.title, e.text, e.image, ep.package_path')
					->from($this->_sTable, 'e')
					->join(Phpfox::getT('emoticon_package'), 'ep', 'ep.package_path = e.package_path')
					->execute('getSlaveRows');
				
				foreach ($aRows as $aRow)
				{
					$this->_aEmoticons[$aRow['text']] = $aRow;
				}
				
				$this->cache()->save($sCacheId, $this->_aEmoticons);		
			}			
		}
		
		foreach ($this->_aEmoticons as $sKey => $aEmoticon)
		{		
			$sTxt = str_replace($sKey, '<img src="' . Phpfox::getParam('core.url_emoticon') . $aEmoticon['package_path'] . '/' . $aEmoticon['image'] . '" alt="' . $aEmoticon['title'] . '" title="' . $aEmoticon['title'] . '" class="v_middle" />', $sTxt);				
			$sTxt = str_replace(str_replace('&lt;', '<', $sKey), '<img src="' . Phpfox::getParam('core.url_emoticon') . $aEmoticon['package_path'] . '/' . $aEmoticon['image'] . '" alt="' . $aEmoticon['title'] . '" title="' . $aEmoticon['title'] . '" class="v_middle" />', $sTxt);
			$sTxt = str_replace(str_replace('>', '&gt;', $sKey), '<img src="' . Phpfox::getParam('core.url_emoticon') . $aEmoticon['package_path'] . '/' . $aEmoticon['image'] . '" alt="' . $aEmoticon['title'] . '" title="' . $aEmoticon['title'] . '" class="v_middle" />', $sTxt);			
		}
		
		return $sTxt;
	}

	/**
	 * Exports an emoticons package
	 * @param string $sId The packages path
	 * @return string
	 */
	public function export($sId)
	{
		$aPackage = $this->database()->select('*')
			->from(Phpfox::getT('emoticon_package'))
			->where('package_path = \'' . $this->database()->escape($sId) . '\'')
			->execute('getRow');
		
		if (!isset($aPackage['package_path']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('emoticon.emoticon_package_not_found'));
		}
			
		$aEmoticons = $this->getEmoticons($aPackage['package_path']);
		
		$sEmoticonName= 'phpfox-emoticon-' . $aPackage['package_path'] . '.xml';
		if (file_exists(PHPFOX_DIR_CACHE . $sEmoticonName))
		{
			unlink(PHPFOX_DIR_CACHE . $sEmoticonName);
		}
		
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		
		$oXmlBuilder->addGroup('emoticons');
		$oXmlBuilder->addTag('name', $aPackage['package_path']);
		$oXmlBuilder->addTag('package_name', $aPackage['package_name']);		
		
		foreach ($aEmoticons as $aEmoticon)
		{
			$oXmlBuilder->addGroup('emoticon');
			
			$oXmlBuilder->addTag('title', $aEmoticon['title']);
			$oXmlBuilder->addTag('text', $aEmoticon['text']);
			$oXmlBuilder->addTag('image', $aEmoticon['image']);
			$oXmlBuilder->addTag('image_code', base64_encode(file_get_contents(Phpfox::getParam('core.dir_emoticon') . $aEmoticon['package_path'] . '/' . $aEmoticon['image'])));	
		
			$oXmlBuilder->closeGroup();
		}
		
		$oXmlBuilder->closeGroup();
			
		Phpfox::getLib('file')->write(PHPFOX_DIR_CACHE . $sEmoticonName, $oXmlBuilder->output());	
		
		return $sEmoticonName;
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
		if ($sPlugin = Phpfox_Plugin::get('emoticon.service_emoticon__call'))
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