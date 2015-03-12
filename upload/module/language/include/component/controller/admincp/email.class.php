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
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Language_Component_Controller_Admincp_Email extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($aVals = $this->request()->getArray('val'))
		{
			if (Phpfox::getService('language.phrase.process')->updateMailPhrases($aVals))
			{
				Phpfox::addMessage(Phpfox::getPhrase('language.phrases_updated_successfully'));
			}
		}
		$sLanguage = $this->request()->get('sLanguage', Phpfox::getUserBy('language_id'));
		$aPhrases = Phpfox::getService('language')->getMailPhrases(true);

		$this->template()->assign(array(
				'sLanguage' => $sLanguage,
				'aPhrases' => $aPhrases
			)
		);
		$aLangs = Phpfox::getService('language')->getAll();
		$this->template()->setTitle(Phpfox::getPhrase('language.phrases_used_in_emails'))
			->setBreadcrumb(Phpfox::getPhrase('language.phrases_used_in_emails'))
			->setHeader(array(
				'admincp_email.js' => 'module_language'
			))
			->assign(array(
				'aLangs' => $aLangs
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('language.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>