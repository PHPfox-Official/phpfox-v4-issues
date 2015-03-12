<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handles the popup guide for forms
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Help
 * @version 		$Id: popup.class.php 852 2009-08-10 18:05:32Z Raymond_Benc $
 */
class Help_Component_Block_Popup extends Phpfox_Component 
{
	/**
	 * Process popup information
	 *
	 */
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		static $iCnt = 0;
		
		$iCnt++;
		
		$bIsValid = false;
		$sInfo = '';
		if (Phpfox::getLib('locale')->isPhrase($this->getParam('phrase')))
		{
			$bIsValid = true;
			$sInfo = Phpfox::getPhrase($this->getParam('phrase'));			
			$sInfo = Phpfox::getLib('parse.bbcode')->preParse($sInfo);
			$sInfo = Phpfox::getLib('parse.bbcode')->parse($sInfo);
			$sInfo = str_replace("\n", "<br />", $sInfo);
		}		

		$this->template()->assign(array(
			'bIsValid' => $bIsValid,
			'sPhrase' => $this->getParam('phrase'),
			'sInfo' => $sInfo,
			'iCnt' => $iCnt
		));		
		
		(($sPlugin = Phpfox_Plugin::get('help.component_block_popup_process')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Clean routine
	 *
	 */
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('help.component_block_popup_clean')) ? eval($sPlugin) : false);
		
		$this->template()->clean(array(
			'bIsValid',
			'sPhrase',
			'sInfo'
		));			
	}
}

?>