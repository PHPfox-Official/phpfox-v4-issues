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
 * @version 		$Id: register.class.php 3099 2011-09-14 15:16:58Z Raymond_Benc $
 */
class Music_Component_Controller_Register extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$this->url()->send('music');
		
		Phpfox::isUser(true);
		
		if (Phpfox::getParam('music.music_user_group_id') == Phpfox::getUserBy('user_group_id'))
		{
			$this->url()->send('music');
		}
		
		$aUser = array(
			'full_name' => Phpfox::getUserBy('full_name')
		);

		$aSettings = Phpfox::getService('custom')->getForEdit(array('user_main', 'user_panel', 'profile_panel'), Phpfox::getUserId(), Phpfox::getParam('music.music_user_group_id'));
		
		$aParams = array(
				'full_name' => Phpfox::getPhrase('music.provide_a_artist_band_name'),
				'agree' => Phpfox::getPhrase('music.tick_the_box_to_agree_to_our_terms_and_privacy_policy')
		);
		
		foreach ($aSettings as $sKey => $aSetting)
		{
			if ($aSetting['is_required'])
			{
				$aParams['custom_field_' . $aSetting['field_id']] = array(
					'title' => Phpfox::getPhrase('music.provide_a_value_for') . ': ' . Phpfox::getPhrase($aSetting['phrase_var_name']),
					'def' => 'required',
					'php_id' => 'custom[' . $aSetting['field_id'] . ']'
				);
			}
		}		
		
		$oValid = Phpfox::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aParams));

		if ($aVals = $this->request()->getArray('val'))
		{
			if ($oValid->isValid($aVals))
			{
				if (Phpfox::getService('music.process')->convertMember($aVals, $this->request()->getArray('custom')))
				{
					$this->url()->send('music', null, Phpfox::getPhrase('music.you_have_successfully_converted_your_account'));
				}
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('music.musician_registration'))
			->setBreadcrumb(Phpfox::getPhrase('music.music'), $this->url()->makeUrl('music'))
			->setBreadcrumb(Phpfox::getPhrase('music.registration'), null, true)
			->setFullSite()
			->assign(array(
				'aForms' => $aUser,
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(),
				'aSettings' => $aSettings
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_controller_register_clean')) ? eval($sPlugin) : false);
	}
}

?>