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
 * @package 		Phpfox_Component
 * @version 		$Id: add.class.php 852 2009-08-10 18:05:32Z Raymond_Benc $
 */
class Favorite_Component_Block_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		if (Phpfox::getService('favorite.process')->add($this->request()->get('type'), $this->request()->get('id')))
		{
			Phpfox::getLib('ajax')->call('<script type="text/javascript">$(\'#js_footer_bar_favorite_content\').html(\'<!-- EMPTY_FOOTER_BAR -->\');</script>');
		}		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('favorite.component_block_add_clean')) ? eval($sPlugin) : false);
	}
}

?>