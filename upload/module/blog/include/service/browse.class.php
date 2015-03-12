<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Module_Blog
 * @version 		$Id: browse.class.php 7059 2014-01-22 14:20:10Z Fern $
 */
class Blog_Service_Browse extends Phpfox_Service 
{	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('blog');	
	}
	
	public function query()
	{		
		$this->database()->select('blog_text.text_parsed AS text, ')->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id');

		if (Phpfox::isUser() && Phpfox::isModule('like'))
		{
			$this->database()->select('lik.like_id AS is_liked, ')
					->leftJoin(Phpfox::getT('like'), 'lik', 'lik.type_id = \'blog\' AND lik.item_id = blog.blog_id AND lik.user_id = ' . Phpfox::getUserId());
		}		
	}
	
	public function getQueryJoins($bIsCount = false, $bNoQueryFriend = false)
	{
		if (Phpfox::isModule('friend') && Phpfox::getService('friend')->queryJoin($bNoQueryFriend))
		{
			$this->database()->join(Phpfox::getT('friend'), 'friends', 'friends.user_id = blog.user_id AND friends.friend_user_id = ' . Phpfox::getUserId());	
		}
		
		if (Phpfox::getParam('core.section_privacy_item_browsing'))
		{
			if ($this->search()->isSearch())
			{
				$this->database()->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id');
			}			
		}
		else
		{
			if ($bIsCount && $this->search()->isSearch())
			{
				$this->database()->join(Phpfox::getT('blog_text'), 'blog_text', 'blog_text.blog_id = blog.blog_id');
			}
		}
		
		if ($this->request()->get((defined('PHPFOX_IS_PAGES_VIEW') ? 'req4' : 'req2')) == 'tag')
		{
			$this->database()->innerJoin(Phpfox::getT('tag'), 'tag', 'tag.item_id = blog.blog_id AND tag.category_id = \'blog\'');	
		}
		
		if ($this->request()->get((defined('PHPFOX_IS_USER_PROFILE') ? 'req3' : 'req2')) == 'category')
		{		
			$this->database()
				->innerJoin(Phpfox::getT('blog_category_data'), 'blog_category_data', 'blog_category_data.blog_id = blog.blog_id')
				->innerJoin(Phpfox::getT('blog_category'), 'blog_category', 'blog_category.category_id = blog_category_data.category_id');			
		}		
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
		if ($sPlugin = Phpfox_Plugin::get('blog.service_browse__call'))
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
