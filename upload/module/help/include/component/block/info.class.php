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
 * @package  		Module_Help
 * @version 		$Id: info.class.php 852 2009-08-10 18:05:32Z Raymond_Benc $
 */
class Help_Component_Block_Info extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (Phpfox::getUserBy('hide_tip'))
		{
			return false;
		}
		
		if (!Phpfox::getUserParam('help.show_tips'))
		{
			return false;
		}
		
		$sPhrase = $this->getParam('phrase');
		$sHash = md5($sPhrase);
		
		if (Phpfox::getLib('session')->get('tip_' . $sHash))
		{
			return false;
		}		
		
		$aParts = explode('.', $sPhrase);
		
		if (!isset($aParts[1]))
		{
			return false;
		}
		
		if (!Phpfox::isModule($aParts[0]))
		{
			return false;
		}
		
		$this->template()->assign(array(
			'sMessage' => Phpfox::getPhrase($sPhrase),
			'sPhrase' => $sHash
		));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('help.component_block_info_clean')) ? eval($sPlugin) : false);
	}
}

?>