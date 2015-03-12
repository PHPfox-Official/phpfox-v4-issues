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
 * @version 		$Id: view-mobile.class.php 1491 2010-03-03 15:34:04Z Raymond_Benc $
 */
class Mail_Component_Controller_View_Mobile extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aValidation = array(
			'message' => Phpfox::getPhrase('mail.add_reply')
		);				

		$oValid = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_form', 
				'aParams' => $aValidation
			)
		);				
	
		$aMail = Phpfox::getService('mail')->getMail($this->request()->getInt('id'));	
		
		if (!isset($aMail['mail_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('mail.invalid_message'));
		}
		
		$bCanView = false;
		if (($aMail['viewer_user_id'] == Phpfox::getUserId()) || ($aMail['owner_user_id'] == Phpfox::getUserId()))
		{
			$bCanView = true;			
		}
		
		if ($bCanView === false)
		{
			return Phpfox_Error::display(Phpfox::getPhrase('mail.invalid_message'));
		}
		
		if ($aVals = $this->request()->getArray('val'))
		{			
			if ($oValid->isValid($aVals))
			{
				$aVals['to'] = $aMail['owner_user_id'];
				
				if (($iNewId = Phpfox::getService('mail.process')->add($aVals)))
				{
					$this->url()->send('mail.view', array('id' => $iNewId));
				}
			}
		}	
		
		if ($aMail['viewer_user_id'] == Phpfox::getUserId())
		{
			Phpfox::getService('mail.process')->toggleView($aMail['mail_id'], false);
		}
		
		$this->template()->assign(array(
				'bMobileInboxIsActive' => true,
				'aMail' => $aMail
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('mail.component_controller_view_mobile_clean')) ? eval($sPlugin) : false);
	}
}

?>