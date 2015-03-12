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
 * @version 		$Id: display-options.class.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
class Blog_Component_Block_Display_Options extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		// We are viewing a blog on a users profile, we don't need the search box
		if ($this->getParam('bViewProfileBlog') === true)
		{
			return false;
		}
		
		// Not allowed to search for blogs
		if (!Phpfox::getUserParam('blog.search_blogs'))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('blog.search_filter')
			)
		);		
		
		return 'block';
	}
}

?>