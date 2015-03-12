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
 * @package 		Phpfox_Component
 * @version 		$Id: admin.class.php 4589 2012-08-09 10:46:37Z Raymond_Benc $
 */
class Pages_Component_Block_Admin extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (!Phpfox::getParam('pages.show_page_admins'))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('pages.admins'),
				'aPageAdmins' => Phpfox::getService('pages')->getPageAdmins()
			)
		);
		
		return 'block';
	}
}
?>