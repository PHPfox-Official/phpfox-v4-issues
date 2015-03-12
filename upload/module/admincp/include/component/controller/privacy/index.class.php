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
 * @package  		Module_Admincp
 * @version 		$Id: add.class.php 2000 2010-10-29 11:24:24Z Raymond_Benc $
 */
class Admincp_Component_Controller_Privacy_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($iDeleteId = $this->request()->getInt('delete')) && Phpfox::getService('admincp.process')->deletePrivacyRule($iDeleteId))
		{
			$this->url()->send('admincp.privacy', array(), 'Successfully deleted this rule.');
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if (Phpfox::getService('admincp.process')->addNewPrivacyRule($aVals))
			{
				$this->url()->send('admincp.privacy', array(), 'Successfully added a new rule.');	
			}
		}
		
		
		$this->template()->setTitle(Phpfox::getPhrase('admincp.admincp_priacy_control'))
			->setBreadcrumb(Phpfox::getPhrase('admincp.admincp_priacy_control'))
			->assign(array(
					'aUserGroups' => Phpfox::getService('user.group')->get(),
					'aRules' => Phpfox::getService('admincp')->getAdmincpRules()
				)
			);
	}
}

?>