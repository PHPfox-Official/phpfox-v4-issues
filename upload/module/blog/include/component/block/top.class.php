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
 * @version 		$Id: top.class.php 2239 2010-12-13 13:39:04Z Raymond_Benc $
 */
class Blog_Component_Block_Top extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (defined('PHPFOX_IS_USER_PROFILE') || defined('PHPFOX_IS_AJAX_CONTROLLER'))
		{
			return false;
		}
		
		$aRows = Phpfox::getService('user.activity')->getTop('blog');

		if (!is_array($aRows))
		{
			return false;
		}
		
		if (!count($aRows))
		{
			return false;
		}

		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('blog.top_bloggers'),
				'aTopBloggers' => $aRows
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('blog.component_block_top_process')) ? eval($sPlugin) : false);
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		// Lets clear it from memory
		$this->template()->clean(array(
				'aTopBloggers',
				'aTopBlogger',
				'sHeader'
			)
		);
		(($sPlugin = Phpfox_Plugin::get('blog.component_block_top_clean')) ? eval($sPlugin) : false);
	}	
}

?>