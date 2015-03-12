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
 * @version 		$Id: index.class.php 1601 2010-05-30 05:20:59Z Raymond_Benc $
 */
class User_Component_Controller_Admincp_Promotion_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($iDeleteId = $this->request()->getInt('delete')) && Phpfox::getService('user.promotion.process')->delete($iDeleteId))
		{
			$this->url()->send('admincp.user.promotion', null, Phpfox::getPhrase('user.promotion_successfully_deleted'));
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('user.promotions'))
			->setBreadcrumb(Phpfox::getPhrase('user.promotions'), $this->url()->makeUrl('admincp.user.promotion'))			
			->assign(array(
					'aPromotions' => Phpfox::getService('user.promotion')->get()
				)
			);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_controller_admincp_promotion_index_clean')) ? eval($sPlugin) : false);
	}
}

?>