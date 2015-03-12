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
 * @version 		$Id: deleteUser.class.php 2137 2010-11-15 13:37:06Z Raymond_Benc $
 */
class User_Component_Block_Admincp_DenyUser extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iUser = $this->request()->get('iUser');
		$aUser = Phpfox::getService('user')->get($iUser, true);
		$aUser['link'] = $this->url()->makeUrl($aUser['user_name']);
		
		$this->template()->assign(array(
				'aUser' => $aUser,
				'iUserIdDelete' => $aUser['user_id']
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
		(($sPlugin = Phpfox_Plugin::get('user.component_block_filter_clean')) ? eval($sPlugin) : false);
	}
}

?>