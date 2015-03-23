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
 * @package  		Module_Page
 * @version 		$Id: ajax.class.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
class Page_Component_Ajax_Admincp_Ajax extends Phpfox_Ajax
{	
	public function addUrl()
	{
		$this->call("if ($('#title_url').val() == '') { $('#js_url_table').show(); $('#title_url').val('" . Phpfox::getService('page')->prepareTitle($this->get('title')) . "'); }");
	}
}	

?>