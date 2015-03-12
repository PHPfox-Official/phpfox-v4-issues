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
 * @package  		Module_Blog
 * @version 		$Id: blog.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Blog_Service_Blog extends Phpfox_Service
{	
	private $_aSpecial = array(
		'category',
		'tag'
	);	

	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('blog');
		
		(($sPlugin = Phpfox_Plugin::get('blog.service_blog___construct')) ? eval($sPlugin) : false);
	}	
	
	public function isValidUrl($sUrl)
	{
		return (in_array(Phpfox::getLib('parse.input')->cleanTitle($sUrl), $this->_aSpecial) ? true : Error::set('Invalid'));
	}
	
	public function getDraftsCount($iUserId)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getdraftscount__start')) ? eval($sPlugin) : false);
		return $this->database()->select("COUNT(*)")
			->from($this->_sTable, 'blog')
			->where('user_id = ' . $iUserId . ' AND post_status = 2')
			->execute('getSlaveField');		
	}
	
	public function getNewBlogs($sLimit)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getnewblogs__start')) ? eval($sPlugin) : false);
		$aRows = $this->database()->getSlaveRows("
			SELECT b.blog_id, b.title, u.user_name
			FROM " . $this->_sTable . " AS b
				JOIN " . Phpfox::getT('user') . " AS u
					ON(b.user_id = u.user_id)
			LIMIT 0," . $sLimit . "
		");		
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getnewblogs__end')) ? eval($sPlugin) : false);
		return $aRows;
	}	
	
	public function getBlogForEdit($iId)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getblogsforedit__start')) ? eval($sPlugin) : false);
		
		return $this->database()->select("blog.*, blog_text.text AS text, u.user_name")
			->from($this->_sTable, 'blog')
			->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = blog.user_id')
			->where('blog.blog_id = ' . (int) $iId)
			->execute('getSlaveRow');		
	}
	
	public function getBlog($iBlogId)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getblog__start')) ? eval($sPlugin) : false);
		(($sPlugin = Phpfox_Plugin::get('blog.service_blog_getblog')) ? eval($sPlugin) : false);
		
		if (Phpfox::isModule('track'))
		{
			$this->database()->select("blog_track.item_id AS is_viewed, ")->leftJoin(Phpfox::getT('blog_track'), 'blog_track', 'blog_track.item_id = blog.blog_id AND blog_track.user_id = ' . Phpfox::getUserBy('user_id'));
		}		
				
		if (Phpfox::isModule('friend'))
		{
			$this->database()->select('f.friend_id AS is_friend, ')->leftJoin(Phpfox::getT('friend'), 'f', "f.user_id = blog.user_id AND f.friend_user_id = " . Phpfox::getUserId());					
		}		
		
		if (Phpfox::isModule('like'))
		{
			$this->database()->select('l.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'l', 'l.type_id = \'blog\' AND l.item_id = blog.blog_id AND l.user_id = ' . Phpfox::getUserId());
		}
		
		$aRow = $this->database()->select("blog.*, " . (Phpfox::getParam('core.allow_html') ? "blog_text.text_parsed" : "blog_text.text") ." AS text, " . Phpfox::getUserField())
			->from($this->_sTable, 'blog')
			->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = blog.user_id')
			->where('blog.blog_id = ' . (int) $iBlogId)
			->execute('getSlaveRow');		

		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getblog__end')) ? eval($sPlugin) : false);
		
		if (!isset($aRow['is_friend']))
		{
			$aRow['is_friend'] = 0;
		}
		
		return $aRow;
	}	

	public function hasAccess($iId, $sUserPerm, $sGlobalPerm)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.service_blog_hasaccess_start')) ? eval($sPlugin) : false);
		
		$aRow = $this->database()->select('u.user_id')
			->from($this->_sTable, 'blog')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = blog.user_id')
			->where('blog.blog_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		(($sPlugin = Phpfox_Plugin::get('blog.service_blog_hasaccess_end')) ? eval($sPlugin) : false);
		
		if (!isset($aRow['user_id']))
		{
			return false;
		}
		
		if ((Phpfox::getUserId() == $aRow['user_id'] && Phpfox::getUserParam('blog.' . $sUserPerm)) || Phpfox::getUserParam('blog.' . $sGlobalPerm))
		{
			return $aRow['user_id'];
		}
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getblog__end')) ? eval($sPlugin) : false);
		return false;
	}
	
	public function verifyPassword($iId, $sPassword)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_verifypassword__start')) ? eval($sPlugin) : false);
		if (!Phpfox::getUserParam('blog.can_view_password_protected_blog'))
		{
			return false;
		}
		
		$aRow = $this->database()->select("blog.password, " . (Phpfox::getParam('core.allow_html') ? "blog_text.text_parsed" : "blog_text.text") ." AS text")
			->from($this->_sTable, 'blog')
			->join(Phpfox::getT('blog_text'), 'blog_text', 'blog.blog_id = blog_text.blog_id')
			->where('blog.blog_id = ' . (int) $iId)
			->execute('getSlaveRow');
		
		if (!isset($aRow['password']))
		{
			return false;
		}
	
		if ($sPassword != $aRow['password'])
		{
			return false;
		}
		
		// Set a session so we don't have to add the password once again
		Phpfox::getLib('session')->set('blog_password_' . $iId, Phpfox::getLib('hash')->setRandomHash($aRow['password']));		
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_verifypassword__end')) ? eval($sPlugin) : false);
		return Phpfox::getLib('parse.output')->parse($aRow['text']);
	}
	
	public function prepareTitle($sTitle, $bCleanOnly = false)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_preparetitle__start')) ? eval($sPlugin) : false);
		return Phpfox::getLib('parse.input')->prepareTitle('blog', $sTitle, 'title_url', Phpfox::getUserId(), Phpfox::getT('blog'), null, $bCleanOnly);
	}
	
	public function getExtra(&$aItems, $sType = null)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getextra__start')) ? eval($sPlugin) : false);
		
		if (!is_array($aItems))
		{
			$aItems = array();
		}
		
		$aIds = array();
		foreach ($aItems as $iKey => $aValue)
		{
			$aIds[] = $aValue['blog_id'];
		}			

		$aCategories = Phpfox::getService('blog.category')->getCategoriesById(implode(', ', $aIds));	

		if (Phpfox::isModule('tag'))
		{
			$aTags = Phpfox::getService('tag')->getTagsById('blog', implode(', ', $aIds));	
		}

		$oFilterOutput = Phpfox::getLib('parse.output');
		foreach ($aItems as $iKey => $aValue)
		{
			if (isset($aCategories[$aValue['blog_id']]))
			{
				$sCategories = '';
				$aCacheCategory[$aValue['blog_id']] = array();
				foreach ($aCategories[$aValue['blog_id']] as $aCategory)
				{					
					if (isset($aCacheCategory[$aValue['blog_id']][$aCategory['category_id']]))
					{
						continue;
					}
					
					$aCacheCategory[$aValue['blog_id']][$aCategory['category_id']] = true;						

					if ($aCategory['user_id'] && $sType == 'user_profile')
					{
						$sCategories .= ', <a href="' . Phpfox::getLib('url')->permalink($aValue['user_name'] . '.blog.category',  $aCategory['category_id'], $aCategory['category_name']) . '">' . Phpfox::getLib('locale')->convert($oFilterOutput->clean($aCategory['category_name'])) . '</a>';
					}
					else 
					{
						$sCategories .= ', <a href="' . Phpfox::getLib('url')->permalink('blog.category',  $aCategory['category_id'], $aCategory['category_name']) . '">' . Phpfox::getLib('locale')->convert($oFilterOutput->clean($aCategory['category_name'])) . '</a>';
					}
				}
				$sCategories = trim(ltrim($sCategories, ','));

				$aItems[$iKey]['info'] = Phpfox::getPhrase('blog.posted_x_by_x_in_x', array('date' => Phpfox::getTime(Phpfox::getParam('blog.blog_time_stamp'), $aValue['time_stamp']), 'link' => Phpfox::getLib('url')->makeUrl($aValue['user_name']), 'user' => $aValue, 'categories' => $sCategories));
			}
			else 
			{				
				$aItems[$iKey]['info'] = Phpfox::getPhrase('blog.posted_x_by_x', array('date' => Phpfox::getTime(Phpfox::getParam('blog.blog_time_stamp'), $aValue['time_stamp']), 'link' => Phpfox::getLib('url')->makeUrl($aValue['user_name']), 'user' => $aValue));
			}
			
			if (isset($aTags[$aValue['blog_id']]))
			{
				$aItems[$iKey]['tag_list'] = $aTags[$aValue['blog_id']];
			}
			
			$aItems[$iKey]['bookmark_url'] = Phpfox::permalink('blog', $aValue['blog_id'], $aValue['title']);
			
			$aItems[$iKey]['aFeed'] = array(			
				'feed_display' => 'mini',	
				'comment_type_id' => 'blog',
				'privacy' => $aValue['privacy'],
				'comment_privacy' => $aValue['privacy_comment'],
				'like_type_id' => 'blog',				
				'feed_is_liked' => (isset($aValue['is_liked']) ? $aValue['is_liked'] : false),
				'feed_is_friend' => (isset($aValue['is_friend']) ? $aValue['is_friend'] : false),
				'item_id' => $aValue['blog_id'],
				'user_id' => $aValue['user_id'],
				'total_comment' => $aValue['total_comment'],
				'feed_total_like' => $aValue['total_like'],
				'total_like' => $aValue['total_like'],
				'feed_link' => $aItems[$iKey]['bookmark_url'],
				'feed_title' => $aValue['title'],
				'time_stamp' => $aValue['time_stamp'],
				'type_id' => 'blog'
			);
		}						
		
		unset($aTags, $aCategories);
		
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getextra__end')) ? eval($sPlugin) : false);
	}
	
	public function getNew($iLimit = 3)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getnew__start')) ? eval($sPlugin) : false);
		$aRows = $this->database()->select('b.blog_id, b.time_stamp, b.title, b.title_url, ' . Phpfox::getUserField())
			->from($this->_sTable, 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where('b.is_approved = 1 AND b.privacy = 1 AND b.post_status = 1')
			->limit($iLimit)
			->order('b.time_stamp DESC')
			->execute('getSlaveRows');	
			
		foreach ($aRows as $iKey => $aRow)
		{
			$aRows[$iKey]['posted_on'] = Phpfox::getPhrase('blog.posted_on_post_time_by_user_link', array(
					'post_time' => Phpfox::getTime(Phpfox::getParam('blog.blog_time_stamp'), $aRow['time_stamp']),
					'user' => $aRow
				)
			);
		}
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getnew__end')) ? eval($sPlugin) : false);
		return $aRows;
	}

	public function getSpamTotal()
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getspamtotal__start')) ? eval($sPlugin) : false);
		
		return $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('is_approved = 9')
			->execute('getSlaveField');		
	}	
	
	public function getPendingTotal()
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_getpendingtotal')) ? eval($sPlugin) : false);
		
		return (int) $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('is_approved = 0')
			->execute('getSlaveField');		
	}	

	public function getTotalDrafts($iUserId)
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_service_blog_gettotaldrafts')) ? eval($sPlugin) : false);
		
		return (int) $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where('user_id = ' . (int) $iUserId . ' AND post_status = 2')
			->execute('getSlaveField');		
	}		
	
	public function getInfoForAction($aItem)
	{
		$aRow = $this->database()->select('b.blog_id, b.title, b.user_id, u.gender, u.full_name')	
			->from(Phpfox::getT('blog'), 'b')
			->join(Phpfox::getT('user'), 'u', 'u.user_id = b.user_id')
			->where('b.blog_id = ' . (int) $aItem['item_id'])
			->execute('getSlaveRow');
		$aRow['link'] = Phpfox::getLib('url')->permalink('blog', $aRow['blog_id'], $aRow['title']);
		return $aRow;
	}
	
	public function __call($sMethod, $aArguments)
	{
		if ($sPlugin = Phpfox_Plugin::get('blog.service_blog__call'))
		{
			return eval($sPlugin);
		}
		
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
}

?>
