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
 * @version 		$Id: add-category-list.class.php 328 2009-03-29 12:26:31Z Raymond_Benc $
 */
class Blog_Component_Block_Add_Category_List extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$iUserId = ($this->getParam('user_id') ? $this->getParam('user_id') : Phpfox::getUserId());
		if ($iBlogId = $this->request()->get('blog_id'))
		{
			$aBlog = Phpfox::getService('blog')->getBlogForEdit($iBlogId);
			if (isset($aBlog['blog_id']) && ($aBlog['user_id'] == Phpfox::getUserId() && Phpfox::getUserParam('blog.can_delete_own_blog_category')) || Phpfox::getUserParam('blog.can_delete_other_blog_category'))
			{
				$iUserId = $aBlog['user_id'];
			}
		}
		
		if (Phpfox::getUserParam('blog.blog_add_categories'))
		{		
			switch($this->getParam('sType'))
			{
				case 'personal':
					$sCond = 'AND c.user_id IN(' . $iUserId . ')';
					$sOrder = 'added DESC';
					break;
				case 'used':
					$sCond = 'AND c.user_id IN(0,' . $iUserId . ')';
					$sOrder = 'used DESC';
					break;
				case 'public':
					$sCond = 'AND c.user_id IN(0)';
					$sOrder = 'added DESC';
					break;				
				default:
					$sCond = 'AND c.user_id IN(0,' . $iUserId . ')';
					$sOrder = 'added DESC';
			}		
		}
		else 
		{
			$sCond = 'AND c.user_id IN(0)';
			$sOrder = 'added DESC';			
		}
		
		$aItems = Phpfox::getService('blog.category')->getCategories(array($sCond), $sOrder);		
				
		$this->template()->assign(array(
			'aItems' => $aItems
		));	
		
		(($sPlugin = Phpfox_Plugin::get('blog.component_block_add_category_list_process')) ? eval($sPlugin) : false);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_block_add_category_list_clean')) ? eval($sPlugin) : false);
	}
}

?>