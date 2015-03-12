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
 * @version 		$Id: form.class.php 1289 2009-12-02 16:13:11Z Raymond_Benc $
 */
class Language_Component_Block_Admincp_Email extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$sLanguage = $this->request()->get('sLanguage');		
		$aPhrases = Phpfox::getService('language')->getMailPhrases(true);
		
		$this->template()->assign(array(
				'sLanguage' => $sLanguage,
				'aPhrases' => $aPhrases
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('language.component_block_admincp_form_clean')) ? eval($sPlugin) : false);		
	}
}

?>