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
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Marketplace_Component_Block_Profile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aUser = $this->getParam('aUser');
		
		if (!Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'marketplace.display_on_profile'))
		{
			return false;
		}			
		
		$iProfileLimit = 5;
		
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_block_profile_process')) ? eval($sPlugin) : false);
		
		$aListings = Phpfox::getService('marketplace')->getForProfileBlock($aUser['user_id'], $iProfileLimit);
		
		if (!count($aListings) && !defined('PHPFOX_IN_DESIGN_MODE'))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('marketplace.marketplace_listings'),
				'sBlockJsId' => 'profile_marketplace',
				'aListings' => $aListings
			)
		);
		
		if (Phpfox::getUserId() == $aUser['user_id'])
		{
			$this->template()->assign('sDeleteBlock', 'profile');
		}			
		
		if (count($aListings) >= $iProfileLimit)
		{
			$this->template()->assign(array(
					'aFooter' => array(
						Phpfox::getPhrase('marketplace.view_more') => $this->url()->makeUrl($aUser['user_name'], array('marketplace'))
					)
				)
			);
		}		
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('marketplace.component_block_profile_clean')) ? eval($sPlugin) : false);
	}		
}

?>