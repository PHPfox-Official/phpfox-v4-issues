<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel_Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: featured.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class User_Component_Block_Featured extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		list($aUsers, $iTotal) = Phpfox::getService('user.featured')->get();
		if (empty($aUsers) || $aUsers === false) return false;
		if (count($aUsers) < $iTotal) $this->template()->assign(array('aFooter' => array(
					Phpfox::getPhrase('user.view_all') => $this->url()->makeUrl('user.browse', array('view' => 'featured'))
				)));
		$this->template()->assign(array(
				'aFeaturedUsers' => $aUsers,
				'sHeader' => Phpfox::getPhrase('user.featured_members'),
			)
		);

		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_block_featured_clean')) ? eval($sPlugin) : false);
	}
}

?>