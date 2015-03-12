<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

define('PHPFOX_SKIP_POST_PROTECTION', true);
define('_ENGINE', true);

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: foxporter.class.php 2921 2011-08-29 17:35:44Z Raymond_Benc $
 */
class FoxporterModule_Se4 extends Foxporter_Abstract
{	
	private $_iVersion = '1.0.0';
	
	private $_oReq = null;
	private $_oUrl = null;
	private $_sCacheId = 'se4_cache_file.php';
	private $_aParam = '';
	
	private $_iPage = 0;
	private $_iLimit = 50;
	
	private	$_iTotalPages = 0;
	private	$_iCurrentPage = 0;
	private	$_iNextPage = 0;
	
	protected $_aDetails = array(
		'name' => 'Social Engine 4',
		'description' => 'Module that will import Social Engine 4. This module currently supports importing users, friends, photo categories, photo albums and photos. Emails will be sent out to users with their new passwords once completed.',
		'link' => 'http://www.socialengine.net/'
	);
	
	protected $_aSteps = array(
		'setup' => array(
			'phrase' => 'Setup',
			'method' => 'setup'
		),
		'import-users' => array(
			'phrase' => 'Users',
			'method' => 'importUsers'
		),
		'import-friends' => array(
			'phrase' => 'Friends',
			'method' => 'importFriends'
		),
		'import-photo-categories' => array(
			'phrase' => 'Photo Categories',
			'method' => 'importPhotoCategories',
		),
		'import-albums' => array(
			'phrase' => 'Photo Albums',
			'method' => 'importPhotoAlbums'
		),		
		'import-photos' => array(
			'phrase' => 'Photos',
			'method' => 'importPhotos'
		),		
		'completed' => array(
			'phrase' => 'Completed',
			'method' => 'completed'
		)				
	);	
	
	public function __construct()
	{
		$this->_oReq = Phpfox::getLib('request');
		$this->_oUrl = Phpfox::getLib('url');
		$this->_sCacheId = PHPFOX_DIR_FILE . 'log' . PHPFOX_DS . $this->_sCacheId;
		
		$this->_iPage = $this->_oReq->getInt('page');
	}
	
	public function setup()
	{
		if (($aVals = $this->_oReq->getArray('val')))
		{
			if (!empty($aVals['se4_path']))
			{
				if (file_exists($this->_sCacheId))
				{
					Phpfox::getLib('file')->unlink($this->_sCacheId);
				}
				
				$sPath = rtrim($aVals['se4_path'], PHPFOX_DS). PHPFOX_DS;
				$sConfigFile = $sPath . 'application' . PHPFOX_DS . 'settings' . PHPFOX_DS . 'database.php';
				if (file_exists($sConfigFile))
				{
					$sConfigData = str_replace('return', '$aConfig = ', file_get_contents($sConfigFile));
					eval(' ?> ' . $sConfigData . ' <?php ');
					$aConfig['se4_path'] = $sPath;
					
					Phpfox::getLib('file')->write($this->_sCacheId, serialize($aConfig));
					
					if ($this->_connect())
					{							
						$this->_oldConnect();
						
						return array(
							'phrase' => 'Checking setup... Done!',
							'next' => 'import-users'
						);							
					}
				}
				else 
				{
					Phpfox_Error::set('Cannot find the config file: ' . $sConfigFile);
				}				
			}
		}
		
		$sContent = '
		<form method="post" action="' . $this->_oUrl->makeUrl('admincp.foxporter', array('module' => 'se4', 'step' => 'setup')) . '">
			<div class="table_header">
				SE4 Details
			</div>
			<div class="table">
				<div class="table_left">
					Social Engine 4 Path:
				</div>
				<div class="table_right">
					<input type="text" name="val[se4_path]" value="" size="40" />
					<div class="extra_info">
						Provide the full path to where your root directory of Social Engine 4 is.
					</div>
				</div>
				<div class="clear"></div>
			</div>			
			<div class="table_clear">
				<input type="submit" value="Submit" class="button" />
			</div>
		</form>
		';
		
		
		return array(
			'content' => $sContent
		);		
	}
	
	public function importUsers()
	{
		$this->_connect();
		
		if (!$this->database()->isField($this->_tbl('users'), 'import_user_id'))
		{
			$this->database()->addField(array('table' => $this->_tbl('users'), 'field' => 'import_user_id', 'type' => 'INT', 'attribute' => 'UNSIGNED', 'null' => false, 'default' => 'DEFAULT \'0\''));
			$this->database()->addIndex($this->_tbl('users'), 'import_user_id');
		}
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_tbl('users'), 'u')			
			->execute('getSlaveField');								
		
		$aRows = $this->database()->select('u.*, ufs.*')
			->from($this->_tbl('users'), 'u')
			->leftJoin($this->_tbl('user_fields_search'), 'ufs', 'ufs.item_id = u.user_id')			
			->limit($this->_iPage, $this->_iLimit, $iCnt)
			->order('u.user_id ASC')
			->execute('getSlaveRows');	
		
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['profile_images'] = $this->database()->select('*')
				->from($this->_tbl('storage_files'))
				->where('parent_type = \'user\' AND parent_id = ' . (int) $aRow['user_id'])
				->execute('getSlaveRows');
		}
		
		 // d($aRows);
		
		$this->_pager($iCnt);
	
		$this->_oldConnect();

		$aCache = array();
		foreach ($aRows as $aRow)
		{
			$aInsert = array(
				'full_name' => $aRow['displayname'],
				'email' => $aRow['email'],
				'user_name' => $aRow['username'],
				'gender' => ($aRow['gender'] == '3' ? 'female' : 'male'),
				'joined' => strtotime($aRow['creation_date']),
				'last_login' => strtotime($aRow['lastlogin_date']),
				'last_activity' => strtotime($aRow['lastlogin_date']),
				'total_view' => $aRow['view_count']
			);
			
			if (!empty($aRow['birthdate']))
			{
				$aBirthParts = explode('-', $aRow['birthdate']);
				
				$aInsert['birth_year'] = $aBirthParts[0];
				$aInsert['birth_month'] = $aBirthParts[1];
				$aInsert['birth_day'] = $aBirthParts[2];
			}
			
			if (!empty($aRow['locale']))
			{
				$aLocaleParts = explode('_', $aRow['locale']);
				if (isset($aLocaleParts[1]))
				{
					$aInsert['country_iso'] = $aLocaleParts[1];				
				}
			}
			
			if (!empty($aRow['profile_images']))
			{
				foreach ($aRow['profile_images'] as $aProfileImage)
				{
					if (empty($aProfileImage['type']))
					{
						$aInsert['profile_image'] = $this->_aParam['se4_path'] . str_replace('/', PHPFOX_DS, $aProfileImage['storage_path']);
						break;
					}
				}
			}
		
			$mReturn = $this->addUser($aInsert);	
			if (isset($mReturn['user_id']))
			{
				$aCache[$mReturn['user_id']] = $aRow['user_id'];
				
				Phpfox::getLib('mail')->to($aRow['email'])
					->messageHeader(false)
					->subject('Commmunity Updated')
					->message("We have updated our community at: <a href=\"" . Phpfox::getLib('url')->makeUrl('') . "\">" . Phpfox::getLib('url')->makeUrl('') . "</a>\n\nNote we have provided your new login details below...\n#######\n\n\n\n\nEmail: " . $aRow['email'] . "\nPassword: " . $mReturn['password'] . "\n")
					->send();							
			}
		}
		
		$this->_connect();
		
		foreach ($aCache as $iNewUserId => $iOldUserId)
		{
			$this->database()->update($this->_tbl('users'), array('import_user_id' => $iNewUserId), 'user_id = ' . (int) $iOldUserId);
		}
				
		$this->_oldConnect();
		
		if ($this->_isDone())
		{
			return array(
				'phrase' => 'Successfully imported ' . $iCnt . ' users.',
				'next' => 'import-friends'
			);
		}
		
		return array(
			'next_page' => $this->_iNextPage,
			'phrase' => 'Importing users. Page ' . $this->_iCurrentPage . ' out of ' . $this->_iTotalPages . '. Please hold...',
			'next' => 'import-users'
		);
	}	
	
	public function importFriends()
	{
		$this->_connect();
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_tbl('user_membership'))			
			->execute('getSlaveField');								
		
		$aRows = $this->database()->select('um.*, u1.import_user_id AS fox_resource_id, u2.import_user_id AS fox_user_id')
			->from($this->_tbl('user_membership'), 'um')
			->join($this->_tbl('users'), 'u1', 'u1.user_id = um.resource_id')
			->join($this->_tbl('users'), 'u2', 'u2.user_id = um.user_id')
			->limit($this->_iPage, $this->_iLimit, $iCnt)
			->order('um.resource_id ASC')
			->execute('getSlaveRows');	
		
		$this->_pager($iCnt);
	
		$this->_oldConnect();		

		foreach ($aRows as $aRow)
		{
			if ($aRow['active'] && $aRow['resource_approved'] && $aRow['user_approved'])
			{
				$this->addFriend($aRow['fox_resource_id'], $aRow['fox_user_id']);
			}
		}		
		
		if ($this->_isDone())
		{
			return array(
				'phrase' => 'Successfully imported ' . $iCnt . ' friends.',
				'next' => 'import-photo-categories'
			);
		}
		
		return array(
			'next_page' => $this->_iNextPage,
			'phrase' => 'Importing friends. Page ' . $this->_iCurrentPage . ' out of ' . $this->_iTotalPages . '. Please hold...',
			'next' => 'import-friends'
		);
	}
	
	public function importPhotoCategories()
	{
		$this->_connect();
		
		if (!$this->database()->isField($this->_tbl('album_categories'), 'import_id'))
		{
			$this->database()->addField(array('table' => $this->_tbl('album_categories'), 'field' => 'import_id', 'type' => 'INT', 'attribute' => 'UNSIGNED', 'null' => false, 'default' => 'DEFAULT \'0\''));
			$this->database()->addIndex($this->_tbl('album_categories'), 'import_id');
		}			
			
		$aRows = $this->database()->select('*')
			->from($this->_tbl('album_categories'))
			->order('category_name ASC')
			->execute('getSlaveRows');	
			
		$this->_oldConnect();
			
		$aCache = array();
		$iOrder = 0;
		foreach ($aRows as $aRow)
		{
			$iOrder++;
			$aCache[$aRow['category_id']] = $this->addPhotoCategory($aRow['category_name'], $iOrder);
		}			

		$this->_connect();
		
		foreach ($aCache as $iOldId => $iNewId)
		{
			$this->database()->update($this->_tbl('album_categories'), array('import_id' => (int) $iNewId), 'category_id = ' . (int) $iOldId);
		}		
		
		$this->_oldConnect();
			
		return array(
			'phrase' => 'Successfully imported ' . count($aCache) . ' photo album categories.',
			'next' => 'import-albums'
		);			
	}
	
	public function importPhotoAlbums()
	{
		$this->_connect();		
		
		if (!$this->database()->isField($this->_tbl('album_albums'), 'import_id'))
		{
			$this->database()->addField(array('table' => $this->_tbl('album_albums'), 'field' => 'import_id', 'type' => 'INT', 'attribute' => 'UNSIGNED', 'null' => false, 'default' => 'DEFAULT \'0\''));
			$this->database()->addIndex($this->_tbl('album_albums'), 'import_id');
		}		
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_tbl('album_albums'), 'aa')			
				->join($this->_tbl('users'), 'u', 'aa.owner_type = \'user\' AND u.user_id = aa.owner_id')			
			->execute('getSlaveField');								
		
		$aRows = $this->database()->select('aa.*, u.import_user_id')
			->from($this->_tbl('album_albums'), 'aa')
			->join($this->_tbl('users'), 'u', 'aa.owner_type = \'user\' AND u.user_id = aa.owner_id')						
			->limit($this->_iPage, $this->_iLimit, $iCnt)
			->order('aa.album_id ASC')
			->execute('getSlaveRows');	
		
		$this->_pager($iCnt);
	
		$this->_oldConnect();		

		$aCache = array();
		foreach ($aRows as $aRow)
		{
			$aCache[$aRow['album_id']] = $this->addPhotoAlbum(array(
					'user_id' => $aRow['import_user_id'],
					'name' => Phpfox::getLib('parse.input')->clean($aRow['title']),
					'time_stamp' => strtotime($aRow['creation_date']),
					'time_stamp_update' => strtotime($aRow['modified_date']),
					'total_comment' => (int) $aRow['comment_count']					
				)
			);
		}	
		
		$this->_connect();
		
		foreach ($aCache as $iOldId => $iNewId)
		{
			$this->database()->update($this->_tbl('album_albums'), array('import_id' => (int) $iNewId), 'album_id = ' . (int) $iOldId);
		}
				
		$this->_oldConnect();		
		
		if ($this->_isDone())
		{
			return array(
				'phrase' => 'Successfully imported ' . $iCnt . ' photo albums.',
				'next' => 'import-photos'
			);
		}
		
		return array(
			'next_page' => $this->_iNextPage,
			'phrase' => 'Importing photo albums. Page ' . $this->_iCurrentPage . ' out of ' . $this->_iTotalPages . '. Please hold...',
			'next' => 'import-albums'
		);
	}
	
	public function importPhotos()
	{
		$this->_connect();
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_tbl('album_photos'), 'ap')			
			->join($this->_tbl('users'), 'u', 'ap.owner_type = \'user\' AND u.user_id = ap.owner_id')			
			->execute('getSlaveField');								
		
		$aRows = $this->database()->select('ap.*, u.import_user_id, aa.import_id, sf.*, ac.import_id AS category_import_id')
			->from($this->_tbl('album_photos'), 'ap')
			->join($this->_tbl('users'), 'u', 'ap.owner_type = \'user\' AND u.user_id = ap.owner_id')			
			->join($this->_tbl('album_albums'), 'aa', 'aa.album_id = ap.album_id')
			->join($this->_tbl('storage_files'), 'sf', $this->database()->isNull('sf.type') . ' AND sf.parent_type = \'album_photo\' AND sf.parent_id = ap.photo_id')
			->leftJoin($this->_tbl('album_categories'), 'ac', 'ac.category_id = aa.category_id')
			->limit($this->_iPage, $this->_iLimit, $iCnt)
			->order('ap.photo_id ASC')
			->execute('getSlaveRows');	

		$this->_pager($iCnt);
	
		$this->_oldConnect();	
		
		foreach ($aRows as $aRow)
		{					
			$this->addPhoto(array(
					'user_id' => $aRow['import_user_id'],
					'album_id' => $aRow['import_id'],
					'title' => Phpfox::getLib('parse.input')->clean($aRow['title']),
					'time_stamp' => strtotime($aRow['creation_date']),
					'total_view' => (int) $aRow['view_count'],
					'total_comment' => (int) $aRow['comment_count'],
					'photo_path' => $this->_aParam['se4_path'] . str_replace('/', PHPFOX_DS, $aRow['storage_path']),
					'file_name' => $aRow['name'],
					'file_size' => $aRow['size'],
					'mime_type' => $aRow['mime_major'] . '/' . $aRow['mime_minor'],
					'extension' => $aRow['extension'],
					'category_id' => $aRow['category_import_id']
				)
			);			
		}			
		
		if ($this->_isDone())
		{
			return array(
				'phrase' => 'Successfully imported ' . $iCnt . ' photos.',
				'next' => 'completed'
			);
		}
		
		return array(
			'next_page' => $this->_iNextPage,
			'phrase' => 'Importing photos. Page ' . $this->_iCurrentPage . ' out of ' . $this->_iTotalPages . '. Please hold...',
			'next' => 'import-photos'
		);
	}
	
	public function completed()
	{
		return array(
			'phrase' => 'Import of your Social Engine has successfully been completed.',
			'completed' => true
		);			
	}
	
	private function _oldConnect()
	{
		$this->database()->close();
		
		$this->database()->connect(Phpfox::getParam(array('db', 'host')), Phpfox::getParam(array('db', 'user')), Phpfox::getParam(array('db', 'pass')), Phpfox::getParam(array('db', 'name')));		
	}
	
	private function _tbl($sTable)
	{
		return $this->_aParam['tablePrefix'] . $sTable;
	}
	
	private function _connect()
	{
		$this->_config();	
		
		$this->database()->close();
		
		return $this->database()->connect($this->_aParam['params']['host'], $this->_aParam['params']['username'], $this->_aParam['params']['password'], $this->_aParam['params']['dbname']);
	}
	
	private function _config()
	{		
		$this->_aParam = unserialize(file_get_contents($this->_sCacheId));		
	}
	
	private function _pager($iCnt)
	{
		Phpfox::getLib('pager')->set(array('page' => $this->_iPage, 'size' => $this->_iLimit, 'count' => $iCnt));

		$this->_iTotalPages = (int) Phpfox::getLib('pager')->getTotalPages();
		$this->_iCurrentPage = (int) Phpfox::getLib('pager')->getCurrentPage();
		$this->_iNextPage = (int) Phpfox::getLib('pager')->getNextPage();			
	}
	
	private function _isDone()
	{
		if ($this->_iTotalPages === $this->_iCurrentPage || $this->_iTotalPages === 0)
		{
			return true;	
		}			
		
		return false;
	}
}

?>