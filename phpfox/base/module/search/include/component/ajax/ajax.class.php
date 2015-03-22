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
 * @package  		Module_Search
 * @version 		$Id: ajax.class.php 2692 2011-06-27 19:13:17Z Raymond_Benc $
 */
class Search_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function viewMore()
	{
		Phpfox::getComponent('search.index', array(), 'controller');		
		
		$this->remove('#feed_view_more');
		$this->append('#js_feed_content', $this->getContent(false));
		$this->call('$Core.loadInit();');		
	}
}

?>