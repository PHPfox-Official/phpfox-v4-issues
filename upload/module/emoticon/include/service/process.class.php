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
 * @package  		Module_Emoticon
 * @version 		$Id: process.class.php 4462 2012-07-04 07:32:23Z Raymond_Benc $
 */
class Emoticon_Service_Process extends Phpfox_Service
{
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('emoticon');
	}

	public function updateEmoticons($aVals)
	{
		$aCache = array();
		$aRows = $this->database()->select('text')
			->from($this->_sTable)
			->execute('getRows');
		foreach ($aRows as $aRow)
		{
			$aCache[$aRow['text']] = true;
		}
		
		foreach ($aVals as $iId => $aVal)
		{
			if (isset($aCache[$aVal['text']]))
			{
				// continue;
			}
			
			$this->database()->update($this->_sTable, array(
					'title' => $this->preParse()->clean($aVal['title']),
					'text' => $this->preParse()->clean($aVal['text'])
				), 'emoticon_id = ' . (int) $iId
			);
		}		
		
		return true;
	}
	
	/**
	 * Uploads an emoticon and inserts it in the package it belongs to, it also updates an emoticon's title and replace.
	 * @param array $aVals
	 */
	public function addEmoticon($aVals, $sFileName = null)
	{
		// check completeness of the array
		$aForm = array(
			'title' => array(
				'message' => Phpfox::getPhrase('emoticon.select_a_module'),
				'type' => 'string:required'
			),
			'text' => array(
				'message' => Phpfox::getPhrase('emoticon.provide_a_emoticon_symbol'),
				'type' => 'string:required'
			),
			'package_path' => array(
				'message' => Phpfox::getPhrase('emoticon.define_a_path_for_the_package'),
				'type' => 'string:required'
			)
		);

		$this->validator()->process($aForm, $aVals);
		
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}

		// check that there is not another replace for the same package
		$bExists = $this->database()->select('*')
			->from($this->_sTable)
			->where('text = \'' . $aVals['text'] . '\'')
			->execute('getSlaveRow');

		// if is not updating and the one in the DB matches in text and package_PATH then throw an error
		if (!isset($aVals['emoticon_id']) && isset($bExists['emoticon_id']) && $bExists['emoticon_id'] > 0)
		{			
			return Phpfox_Error::set(Phpfox::getPhrase('emoticon.symbol_already_exists'));
		}

		// if is updating then update all the fields except the image field right away
		if (isset($aVals['emoticon_id']) && $aVals['emoticon_id'] > 0)
		{
			$aUpdate = array(
				'title' => Phpfox::getLib('parse.input')->clean($aVals['title']),
				'text' => Phpfox::getLib('parse.input')->clean($aVals['text']),
				'package_path' => Phpfox::getLib('parse.input')->clean($aVals['package_path'])
			);
			
			$this->database()->update($this->_sTable, $aUpdate, 'emoticon_id = ' . (int)$aVals['emoticon_id']);
		}

		// Upload image
		if (!empty($aVals['file']['tmp_name']))
		{
			if ($sFileName === null)
			{
				$oFile = Phpfox::getLib('file');
				$oImage = Phpfox::getLib('image');
				
				$aImage = $oFile->load('file', array('png', 'jpg', 'gif'));
				
				if ($aImage === false)
				{
					return false;
				}
				$sFileName = Phpfox::getLib('parse.input')->cleanFileName(preg_replace("/^(.*?)\.(jpg|jpeg|gif|png)$/i", "$1", $aVals['file']['name']));
				
				$sDirectory = $this->database()->select('package_path')
					->from(Phpfox::getT('emoticon_package'))
					->where('package_path =\'' . $this->database()->escape(Phpfox::getLib('parse.input')->clean($aVals['package_path'])) . '\'')
					->execute('getSlaveField');					

				$sDirectory = Phpfox::getParam('core.dir_emoticon') . $sDirectory . PHPFOX_DS;
	
				if (!($sFileName = $oFile->upload('file',  $sDirectory, $sFileName, false, 0644, false)))
				{
					return Phpfox_Error::set(Phpfox::getPhrase('emoticon.image_could_not_be_uploaded'));
				}
			}
		}	

		if (isset($aVals['emoticon_id']) && is_numeric($aVals['emoticon_id']))
		{
			// Update the image field
			$this->database()->update($this->_sTable, array('title' => $this->preParse()->clean($aVals['title']), 'text' => $this->preParse()->clean($aVals['text'])), 'emoticon_id = ' . (int) $aVals['emoticon_id']);
		}
		else
		{
			// insert in the database
			$aInsert = array(
				'title' => $this->preParse()->clean($aVals['title']),
				'text' => $this->preParse()->clean($aVals['text']),
				'image' => str_replace('%s', '', $sFileName),
				'package_path' => Phpfox::getLib('parse.input')->clean($aVals['package_path'])
			);
				
			$this->database()->insert($this->_sTable, $aInsert);
		}

		// remove cache
		$this->cache()->remove('emoticon');
		$this->cache()->remove('emoticon_parse');		

		return true;
	}

	/**
	 * Creates an empty package. This function DOES NOT import a package
	 * @param array $aVal
	 * @return bool true on success
	 */
	public function addPackage($aVal)
	{
		// check consistency
		if (!isset($aVal['product_id']) || !isset($aVal['package_name']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('emoticon.please_fill_in_the_package_name_field'));
		}
		
		if (isset($aVal['package_path']))
		{
			$this->database()->update(Phpfox::getT('emoticon_package'), array('package_name' => $aVal['package_name']), 'package_path = \'' . $this->database()->escape($aVal['package_path']) . '\'');			
		}
		else
		{
			// use prepareTitle to avoid duplicates.
			$aVal['package_path'] = Phpfox::getLib('parse.input')->prepareTitle('emoticon', $aVal['package_name'], 'package_path', null, Phpfox::getT('emoticon_package'));			
			
			$iId = $this->database()->insert(Phpfox::getT('emoticon_package'), $aVal);

			if (!is_dir(Phpfox::getParam('core.dir_emoticon') . $aVal['package_path']))
			{
				if (Phpfox::getParam('core.ftp_enabled'))
				{
					Phpfox::getLib('ftp')->mkdir(Phpfox::getParam('core.dir_emoticon') . $aVal['package_path']);
				}
				else 
				{
					if (!mkdir(Phpfox::getParam('core.dir_emoticon') . $aVal['package_path']))
					{
						return Phpfox_Error::set(Phpfox::getPhrase('emoticon.path_is_not_writable_and_the_folder_could_not_be_created', array('path' => Phpfox::getParam('core.dir_emoticon'))));
					}
				}
			}
			// check if we are editing a package
		}
		
		if (!empty($_FILES['import']['name']))
		{
			$sDir = PHPFOX_DIR_CACHE . md5($_FILES['import']['name'] . uniqid());

			mkdir($sDir);
			if (!is_dir($sDir) || !is_writable($sDir))
			{
				return Phpfox_Error::set('Folder could no be created or does not exist');
			}
			Phpfox::getLib('archive', 'zip')->extract($_FILES['import']['tmp_name'], $sDir);
			
			$hDir = opendir($sDir);
			while ($sFile = readdir($hDir))
			{
				preg_match('/^(.*?)\.(.*?)$/i', $sFile, $aMatches);

				if (!isset($aMatches[2]))
				{
					continue;
				}

				if (!in_array($aMatches[2], array(
							'png',
							'gif',
							'jpg',
							'jpeg'
						)
					)
				)
				{
					continue;
				}

				$this->addEmoticon(array(
					'title' => $aMatches[1],
					'text' => ':' . $aMatches[1] . ':',
					'package_path' => $aVal['package_path']
				), $sFile);

				copy($sDir . PHPFOX_DS . $sFile, Phpfox::getParam('core.dir_emoticon') . $aVal['package_path'] . PHPFOX_DS . $sFile);
			}

			Phpfox::getLib('file')->delete_directory($sDir);
		}
		return $aVal['package_path'];
	}

	/**
	 * Checks for admin permission and deletes one emoticon from the database and the file system if second param is true
	 * @todo purefan implement hard delete
	 * @param <type> $iId
	 * @return <type>
	 */
	public function deleteEmoticon($iId, $bHardDelete = false)
	{
		Phpfox::getUserParam('admincp.has_admin_access', true);
		$this->cache()->remove('emoticon');
		$this->cache()->remove('emoticon_parse');
		return $this->database()->delete($this->_sTable, 'emoticon_id = ' . (int)$iId);
	}

	/**
	 * Delets a package from the database
	 * @param int $iId
	 * @param bool $bHardDelete
	 * @return <type>
	 */
	public function deletePackage($iId, $bHardDelete = true)
	{
		Phpfox::getUserParam('admincp.has_admin_access', true);
		if ($bHardDelete)
		{
			$sPath = $this->database()
				->select('ep.package_path')
				->from(Phpfox::getT('emoticon_package'), 'ep')
				->where('ep.package_path = \''. Phpfox::getLib('parse.input')->clean($iId) . '\'')
				->execute('getSlaveField');

			$sPath = Phpfox::getParam('core.dir_emoticon') . $sPath;
			Phpfox::getLib('file')->delete_directory($sPath);
		}		
		
		$this->database()->delete($this->_sTable, 'package_path = \'' . Phpfox::getLib('parse.input')->clean($iId).'\'');		
		$this->database()->delete(Phpfox::getT('emoticon_package'), 'package_path = \'' . Phpfox::getLib('parse.input')->clean($iId).'\'');
		
		$this->cache()->remove('emoticon', 'substr');
		
		return true;
	}
	/**
	 * Enables/Disables an emoticon package
	 * @param int $iId
	 * @param int $iState
	 */
	public function updateActivity($iId, $iState)
	{	
		$this->database()->update(Phpfox::getT('emoticon_package'), array('is_active'=>(int)$iState), 'package_path = \'' . Phpfox::getLib('parse.input')->clean($iId) . '\'');
		
		$this->cache()->remove('emoticon', 'substr');		

		return true;	
	}

	/**
	 * Updates the order of the emoticons
	 * @return boolean
	 */
	public function updateOrder($aVals)
	{
		$aPositions = $aVals['ordering'];

		foreach ($aPositions as $iUser => $iPos)
		{
			$this->database()->update($this->_sTable, array('ordering' => (int)$iPos), 'emoticon_id = ' . (int)$iUser);
		}
		
		$this->cache()->remove('emoticon', 'substr');
		
		return true;
	}
	
	public function import($aVals, &$aParams)
	{
		if (!isset($aParams['emoticon']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('emoticon.not_a_valid_emoticon_package'));
		}
		
		if ($aVals['overwrite'])
		{
			$this->deletePackage($aParams['package_name']);
		}

		$aCache = array();
		$aRows = $this->database()->select('text')
			->from(Phpfox::getT('emoticon'))
			->execute('getRows');
		foreach ($aRows as $aRow)
		{
			$aCache[$aRow['text']] = true;
		}
		
		$sPath = $this->addPackage(array(
				'package_name' => $aParams['package_name'],
				'product_id' => 'phpfox'
			)
		);
		
		if ($sPath === false)
		{
			return Phpfox_Error::set(Phpfox::getPhrase('emoticon.unable_to_import_emoticon_package'));
		}
		
		if (Phpfox::getParam('core.ftp_enabled'))
		{
			Phpfox::getLib('ftp')->chmod(PHPFOX_DIR_FILE . 'pic' . PHPFOX_DS . 'emoticon' . PHPFOX_DS . $sPath . PHPFOX_DS, 0777);
		}
		
		$iFailed = 0;
		$iSuccess = 0;
		$aEmoticonArray = (isset($aParams['emoticon']['title']) ? array($aParams['emoticon']) : $aParams['emoticon']);
		foreach ($aEmoticonArray as $aEmoticon)
		{
			if (isset($aCache[$aEmoticon['text']]))
			{
				$iFailed++;
				
				continue;
			}
			
			$iSuccess++;
			
			$this->database()->insert(Phpfox::getT('emoticon'), array(
					'title' => $aEmoticon['title'],
					'text' => $aEmoticon['text'],
					'image' => $aEmoticon['image'],
					'package_path' => $sPath
				)
			);
			
			$hFile = fopen(Phpfox::getParam('core.dir_emoticon') . $sPath . PHPFOX_DS . $aEmoticon['image'], 'w');
			fwrite($hFile, base64_decode($aEmoticon['image_code']));
			fclose($hFile);
		}
		
		$this->cache()->remove('emoticon', 'substr');				
		
		return array(
			'id' => $sPath,
			'failed' => $iFailed,
			'success' => $iSuccess
		);
	}
}
?>
