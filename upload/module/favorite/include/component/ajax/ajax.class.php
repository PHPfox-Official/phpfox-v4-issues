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
 * @package 		Phpfox_Ajax
 * @version 		$Id: ajax.class.php 626 2009-06-02 09:10:12Z Raymond_Benc $
 */
class Favorite_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function add()
	{
		Phpfox::getBlock('favorite.add');
	}
	
	public function getFooterBar()
	{
		Phpfox::isUser(true);
		Phpfox::getBlock('favorite.footer');
		$this->html('#js_footer_bar_favorite_content', $this->getContent(false));
	}
	
	public function delete()
	{
		if (Phpfox::getService('favorite.process')->delete($this->get('favorite_id')))
		{
			
		}
	}
}

?>