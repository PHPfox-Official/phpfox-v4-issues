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
 * @version 		$Id: footer.class.php 1245 2009-11-02 16:10:29Z Raymond_Benc $
 */
class Favorite_Component_Block_Footer extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		list($iOwnerUserId, $aFavorites) = Phpfox::getService('favorite')->get(Phpfox::getUserId());
		
		$aMenus = array();
		foreach ($aFavorites as $aModule)
		{
			if (isset($aModule['title']))
			{
				$aMenus[] = $aModule['title'];
			}
		}		
		
		$this->template()->assign(array(
				'aFavorites' => $aFavorites,
				'aFavMenus' => $aMenus,
				'iFavoriteUserId' => $iOwnerUserId
			)	
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('favorite.component_block_footer_clean')) ? eval($sPlugin) : false);
	}
}

?>