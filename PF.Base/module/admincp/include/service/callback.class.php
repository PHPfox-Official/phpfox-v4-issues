<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Callbacks
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Admincp
 * @version 		$Id: callback.class.php 4940 2012-10-23 10:04:04Z Miguel_Espinoza $
 */
class Admincp_Service_Callback extends Phpfox_Service
{
	public function massAdmincpProductDelete($sProduct)
	{
		$aTables = array(
			'block',			
			'component',
			'cron',
			'menu',
			'plugin',
			'plugin_hook',
			'setting',
			'setting_group',
			'site_stat'
		);

		foreach ($aTables as $sTable)
		{
			$this->database()->delete(Phpfox::getT($sTable), "product_id = '" . $this->database()->escape($sProduct) . "'");
		}

		$aModules = $this->database()->select('module_id')
			->from(Phpfox::getT('module'))
			->where("product_id = '" . $this->database()->escape($sProduct) . "'")
			->execute('getRows');

		foreach ($aModules as $aModule)
		{
			Phpfox::getService('admincp.module.process')->delete($aModule['module_id']);
		}
	}

	public function massAdmincpModuleDelete($iModule)
	{
		$aTables = array(
			'block',
			'component',
			'cron',
			'menu',
			'module',
			'plugin',
			'plugin_hook',
			'setting',
			'setting_group'
		);

		foreach ($aTables as $sTable)
		{
			$this->database()->delete(Phpfox::getT($sTable), "module_id = '" . $this->database()->escape($iModule) . "'");
		}
	}
	
	public function getDetailOnOrderUpdate()
	{
		return array(
			'table' => 'admincp_dashboard',
			'field' => 'user_id',
			'value' => Phpfox::getUserId()
		);		
	}

	public function removeDuplicateList()
	{
		$aList = array();
		
		$aList[] = array(
			'name' => Phpfox::getPhrase('admincp.menus'),
			'key' => 'menu_id',
			'table' => 'menu',
			'search' => array(
				'm_connection',
				'module_id',
				'var_name'
			)
		);
				
		$aList[] =	array(
			'name' => Phpfox::getPhrase('admincp.blocks'),
			'key' => 'block_id',
			'table' => 'block',
			'search' => array(
				'm_connection',
				'module_id',
				'component',
				'location'
			)					
		);

		$aList[] = array(
			'name' => Phpfox::getPhrase('admincp.components'),
			'key' => 'component_id',
			'table' => 'component',
			'search' => array(
				'component',
				'module_id',
				'product_id',
				'm_connection',
				'is_block'
			)
		);
		
		$aList[] =	array(
			'name' => Phpfox::getPhrase('admincp.global_settings'),
			'key' => 'setting_id',
			'table' => 'setting',
			'search' => array(
				'group_id',
				'module_id',
				'var_name'
			)					
		);			
			
		$aList[] =	array(
			'name' => Phpfox::getPhrase('admincp.modules'),
			'key' => 'module_id',
			'table' => 'module',
			'search' => array(
				'module_id'				
			)					
		);		
		
		return $aList;
	}		
	
	public function updateCounterList()
	{
		$aList = array();	

		$aList[] =	array(
			'name' => Phpfox::getPhrase('admincp.update_privacy_for_v3_upgrade'),
			'id' => 'update-v3-tables'
		);
		
		$aList[] =	array(
			'name' => Phpfox::getPhrase('admincp.import_groups_from_v2_to_v3_pages'),
			'id' => 'import-groups'
		);		
		
		$aList[] = array(
			'name' => Phpfox::getPhrase('admincp.fix_birthdays'),
			'id' => 'birthdays'
		);
		return $aList;
	}
	
	public function updateCounter($iId, $iPage, $iPageLimit)
	{				
		if ($iId == 'birthdays')
		{
			$iCnt = $this->database()->select('COUNT(*)')
					->from(Phpfox::getT('user'))
					->where('LENGTH(birthday) < 8 OR birthday is null')
					->execute('getSlaveField');	
			
			$aUsers = $this->database()->select('user_id, birthday_search')
					->from(Phpfox::getT('user'))
					->where('LENGTH(birthday) < 8 OR birthday is null')
					->limit($iPage, $iPageLimit, $iCnt)
					->execute('getSlaveRows');
			
			foreach ($aUsers as $aUser)
			{
				$this->database()->update(Phpfox::getT('user'), 
						array('birthday' => date('dmY', $aUser['birthday_search'])), 
						'user_id = ' . $aUser['user_id']);
			}
			return $iCnt;
		}
		if ($iId == 'import-groups')
		{
			if (!$this->database()->isField(Phpfox::getT('group'), 'legacy_import_id'))
			{
				$this->database()->addField(array(
						'table' => Phpfox::getT('group'),
						'field' => 'legacy_import_id',
						'type' => 'INT(11)'
					)
				);
				$this->database()->addIndex(Phpfox::getT('group'), 'legacy_import_id');
				
				$this->database()->addField(array(
						'table' => Phpfox::getT('pages_category'),
						'field' => 'legacy_import_id',
						'type' => 'INT(11)'
					)
				);		
				$this->database()->addIndex(Phpfox::getT('pages_category'), 'legacy_import_id');
				
				$aGroupTypeInfo = $this->database()->select('pc.*')
					->from(Phpfox::getT('pages_category'), 'pc')
					->where('pc.page_type = 1')
					->execute('getSlaveRow');					
				
				$aGroupTypes = $this->database()->select('pc.*')
					->from(Phpfox::getT('group_category'), 'pc')					
					->execute('getSlaveRows');				
				
				foreach ($aGroupTypes as $aGroupType)
				{
					$this->database()->insert(Phpfox::getT('pages_category'), array(
							'type_id' => $aGroupTypeInfo['type_id'],
							'name' => $aGroupType['name'],
							'page_type' => '1',
							'is_active' => '1',
							'ordering' => $aGroupType['ordering'],
							'legacy_import_id' => $aGroupType['category_id']
						)
					);
				}
			}	
			
			$aGroupTypeBackup = $this->database()->select('pc.*')
				->from(Phpfox::getT('pages_category'), 'pc')
				->where('pc.page_type = 1')
				->execute('getSlaveRow');	
			
			$aGroupCache = array();
			$aGroupHistory = $this->database()->select('*')
				->from(Phpfox::getT('pages_category'))
				->where('legacy_import_id > 0')
				->execute('getSlaveRows');
			foreach ($aGroupHistory as $aOldCategory)
			{
				$aGroupCache[$aOldCategory['legacy_import_id']] = $aOldCategory;
			}

				$iCnt = $this->database()->select('COUNT(*)')
					->from(Phpfox::getT('group'))
					->execute('getSlaveField');			

				$aGroups = $this->database()->select('g.*, gt.*, gcd.category_id')
					->from(Phpfox::getT('group'), 'g')
					->join(Phpfox::getT('group_text'), 'gt', 'gt.group_id = g.group_id')
					->leftJoin(Phpfox::getT('group_category_data'), 'gcd', 'gcd.group_id = g.group_id')
					->limit($iPage, $iPageLimit, $iCnt)
					->order('g.group_id ASC')
					->execute('getSlaveRows');
				
				foreach ($aGroups as $aGroup)
				{					
					$iPageId = $this->database()->insert(Phpfox::getT('pages'), array(
							'view_id' => '0',
							'type_id' => (isset($aGroupCache[$aGroup['category_id']]) ? $aGroupCache[$aGroup['category_id']]['type_id'] : $aGroupTypeBackup['type_id']),
							'category_id' => (isset($aGroupCache[$aGroup['category_id']]) ? $aGroupCache[$aGroup['category_id']]['category_id'] : $aGroupTypeBackup['category_id']),
							'user_id' => $aGroup['user_id'],
							'title' => $aGroup['title'],
							'reg_method' => $aGroup['view_id'],
							'landing_page' => null,
							'time_stamp' => $aGroup['time_stamp'],
							'image_path' => (empty($aGroup['image_path']) ? null : '[GROUP]' . $aGroup['image_path']),
							'image_server_id' => $aGroup['server_id'],
							'total_comment' => $aGroup['total_comment'],
							'privacy' => '0'
						)
					);
					
					$this->database()->insert(Phpfox::getT('pages_text'), array(
							'page_id' => $iPageId,
							'text' => $aGroup['description'],
							'text_parsed' => $aGroup['description_parsed']						
						)
					);
					
					$this->database()->update(Phpfox::getT('event'), array('module_id' => 'pages', 'item_id' => $iPageId), 'module_id = \'group\' AND item_id = ' . (int) $aGroup['group_id']);
					$this->database()->update(Phpfox::getT('video'), array('module_id' => 'pages', 'item_id' => $iPageId), 'module_id = \'group\' AND item_id = ' . (int) $aGroup['group_id']);
					$this->database()->update(Phpfox::getT('forum_thread'), array('group_id' => $iPageId), 'group_id = ' . (int) $aGroup['group_id']);
					$this->database()->update(Phpfox::getT('photo'), array('group_id' => $iPageId, 'module_id' => 'pages'), 'group_id = ' . (int) $aGroup['group_id']);
					
					$this->database()->update(Phpfox::getT('group'), array('legacy_import_id' => $iPageId), 'group_id = ' . (int) $aGroup['group_id']);
					
					$sSalt = '';
					for ($i = 0; $i < 3; $i++)
					{
						$sSalt .= chr(rand(33, 91));
					}		

					$sPossible = Phpfox::getParam('captcha.captcha_code');
					$sPassword = '';
					$i = 0;
					while ($i < 10) 
					{ 
						$sPassword .= substr($sPossible, mt_rand(0, strlen($sPossible)-1), 1);
						$i++;
					}  		

					$iUserId = $this->database()->insert(Phpfox::getT('user'), array(
							'user_image' => (empty($aGroup['image_path']) ? null : '[GROUP]' . $aGroup['image_path']),
							'server_id' => $aGroup['server_id'],						
							'profile_page_id' => $iPageId,
							'user_group_id' => NORMAL_USER_ID,
							'view_id' => '7',
							'full_name' => $this->preParse()->clean($aGroup['title']),
							'joined' => PHPFOX_TIME,
							'password' => Phpfox::getLib('hash')->setHash($sPassword, $sSalt),
							'password_salt' => $sSalt
						)
					);

					$aExtras = array(
						'user_id' => $iUserId
					);

					$this->database()->insert(Phpfox::getT('user_activity'), $aExtras);
					$this->database()->insert(Phpfox::getT('user_field'), $aExtras);
					$this->database()->insert(Phpfox::getT('user_space'), $aExtras);
					$this->database()->insert(Phpfox::getT('user_count'), $aExtras);
					
					$aMembers = $this->database()->select('gi.*')
						->from(Phpfox::getT('group_invite'), 'gi')
						->where('gi.group_id = ' . (int) $aGroup['group_id'] . ' AND gi.member_id = 1')
						->execute('getSlaveRows');
					
					$iTotalMembers = 0;
					foreach ($aMembers as $aMember)
					{
						$iTotalMembers++;
						$this->database()->insert(Phpfox::getT('like'), array(
								'type_id' => 'pages',
								'item_id' => $iPageId,
								'user_id' => $aMember['invited_user_id'],
								'time_stamp' => $aMember['time_stamp']
							)
						);
					}
					
					$this->database()->update(Phpfox::getT('pages'), array('total_like' => $iTotalMembers), 'page_id = ' . (int) $iPageId);
					
					$aGroupComments = $this->database()->select('c.*, ct.*')
						->from(Phpfox::getT('comment'), 'c')
						->join(Phpfox::getT('comment_text'), 'ct', 'ct.comment_id = c.comment_id')
						->where('c.type_id = \'group\' AND item_id = ' . (int) $aGroup['group_id'])
						->execute('getSlaveRows');
					
					foreach ($aGroupComments as $aGroupComment)
					{
						$iCommentId = $this->database()->insert(Phpfox::getT('pages_feed_comment'), array(
								'user_id' => $aGroupComment['user_id'],
								'parent_user_id' => $iPageId,
								'content' => $aGroupComment['text_parsed'],
								'time_stamp' => $aGroupComment['time_stamp']
							)
						);						
						
						$this->database()->insert(Phpfox::getT('pages_feed'), array(
								'type_id' => 'pages_comment',
								'user_id' => $aGroupComment['user_id'],
								'parent_user_id' => $iPageId,
								'item_id' => $iCommentId,
								'time_stamp' => $aGroupComment['time_stamp']
							)
						);
					}
				}				
				
			return $iCnt;
		}	
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('user'))
			->execute('getSlaveField');
		
		$aRows = $this->database()->select('u.user_id')
			->from(Phpfox::getT('user'), 'u')
			->order('u.user_id ASC')
			->limit($iPage, $iPageLimit, $iCnt)
			->execute('getSlaveRows');		
		
		if (!$this->database()->isField(Phpfox::getT('bulletin'), 'legacy_import_id'))
		{
			$this->database()->addField(array(
					'table' => Phpfox::getT('bulletin'),
					'field' => 'legacy_import_id',
					'type' => 'INT(11)'
				)
			);
			$this->database()->addIndex(Phpfox::getT('bulletin'), 'legacy_import_id');
		}		
		
		/*
		 *
			- Blogs (1 -> 0; 2 -> 3; 3 -> 1)
			- Polls (1 -> 0; 2 -> 3; 3 -> 1)
			- Quiz (1 -> 0; 2 -> 3; 3 -> 1)
			- Photo Albums (1 -> 3; 2 -> 1; 3 -> 4)
		 *  
		 */
		foreach ($aRows as $aRow)
		{			
			$this->database()->update(Phpfox::getT('blog'), array('privacy' => '0'), 'user_id = ' . (int) $aRow['user_id'] . ' AND privacy = 1');			
			$this->database()->update(Phpfox::getT('blog'), array('privacy' => '1'), 'user_id = ' . (int) $aRow['user_id'] . ' AND privacy = 3');
			$this->database()->update(Phpfox::getT('blog'), array('privacy' => '3'), 'user_id = ' . (int) $aRow['user_id'] . ' AND privacy = 2');
			
			$this->database()->update(Phpfox::getT('poll'), array('privacy' => '0'), 'user_id = ' . (int) $aRow['user_id'] . ' AND privacy = 1');
			$this->database()->update(Phpfox::getT('poll'), array('privacy' => '1'), 'user_id = ' . (int) $aRow['user_id'] . ' AND privacy = 3');	
			$this->database()->update(Phpfox::getT('poll'), array('privacy' => '3'), 'user_id = ' . (int) $aRow['user_id'] . ' AND privacy = 2');
			
			$this->database()->update(Phpfox::getT('quiz'), array('privacy' => '0'), 'user_id = ' . (int) $aRow['user_id'] . ' AND privacy = 1');			
			$this->database()->update(Phpfox::getT('quiz'), array('privacy' => '1'), 'user_id = ' . (int) $aRow['user_id'] . ' AND privacy = 3');
			$this->database()->update(Phpfox::getT('quiz'), array('privacy' => '3'), 'user_id = ' . (int) $aRow['user_id'] . ' AND privacy = 2');			
			
			$this->database()->update(Phpfox::getT('photo_album'), array('privacy' => '4'), 'user_id = ' . (int) $aRow['user_id'] . ' AND privacy = 3');	
			$this->database()->update(Phpfox::getT('photo_album'), array('privacy' => '3'), 'user_id = ' . (int) $aRow['user_id'] . ' AND privacy = 1');
			$this->database()->update(Phpfox::getT('photo_album'), array('privacy' => '1'), 'user_id = ' . (int) $aRow['user_id'] . ' AND privacy = 2');			
			
			if (Phpfox::isModule('bulletin'))
			{
				$aBulletins = $this->database()->select('b.*, bt.*')
					->from(Phpfox::getT('bulletin'), 'b')
					->join(Phpfox::getT('bulletin_text'), 'bt', 'b.bulletin_id = bt.bulletin_id')
					->where('b.user_id = ' . (int) $aRow['user_id'])
					->execute('getSlaveRows');
				
				foreach ($aBulletins as $aBulletin)
				{
					$iBlogId = $this->database()->insert(Phpfox::getT('blog'), array(
							'user_id' => $aBulletin['user_id'],
							'title' => $aBulletin['title'],
							'title_url' => '',
							'time_stamp' => $aBulletin['time_stamp'],
							'is_approved' => '1',
							'privacy' => '1',
							'post_status' => '1',
							'total_view' => $aBulletin['views'],
							'total_attachment' => $aBulletin['total_attachment'],
							'total_comment' => $aBulletin['total_comment']
						)
					);
					
					$this->database()->insert(Phpfox::getT('blog_text'), array(
							'blog_id' => $iBlogId,
							'text' => $aBulletin['text'],
							'text_parsed' => $aBulletin['text_parsed']
						)
					);
					
					$this->database()->update(Phpfox::getT('comment'), array('type_id' => 'blog', 'item_id' => $iBlogId), 'type_id = \'bulletin\' AND item_id = ' . (int) $aBulletin['bulletin_id']);
					
					$this->database()->update(Phpfox::getT('bulletin'), array('legacy_import_id' => $iBlogId), 'bulletin_id = ' . (int) $aBulletin['bulletin_id']);
				}
			}	
		}
	
		return $iCnt;
	}
}

?>