<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handle AJAX calls for the language module
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Language
 * @version 		$Id: ajax.class.php 4375 2012-06-27 08:01:06Z Miguel_Espinoza $
 */
class Language_Component_Ajax_Ajax extends Phpfox_Ajax
{	
	/**
	 * Add a phrase using an inline method
	 *
	 */
	public function add()
	{
		Phpfox::getComponent('language.admincp.phrase.add', array('sReturnUrl' => $this->get('return'), 'sVar' => $this->get('phrase'), 'bNoJsValidation' => true), 'controller');
	}
	
	public function select()
	{
		Phpfox::getBlock('language.select');
	}
	
	public function process()
	{		
		if (Phpfox::getService('language.process')->useLanguage($this->get('id')))
		{
			Phpfox::addMessage(Phpfox::getPhrase('language.successfully_updated_your_language_preferences'));
			
						$sReturn = Phpfox::getLib('session')->get('redirect');
						if (is_bool($sReturn))
						{
							$sReturn = '';
						}		

						if ($sReturn)
						{
							$aParts = explode('/', trim($sReturn, '/'));		
							if (isset($aParts[0]))
							{
								$aParts[0] = Phpfox::getLib('url')->reverseRewrite($aParts[0]);
							}
							if (isset($aParts[0]) && !Phpfox::isModule($aParts[0]))
							{
								$aUserCheck = Phpfox::getService('user')->getByUserName($aParts[0]);
								if (isset($aUserCheck['user_id']))
								{
									if (isset($aParts[1]) && !Phpfox::isModule($aParts[1]))
									{
										$sReturn = '';	
									}
								}
								else 
								{
									$sReturn = '';
								}
							}
						}			
						
						$sReturn = trim($sReturn, '/');
			
			$this->call('window.location.href = window.location.href;');// . Phpfox::getLib('url')->makeUrl($sReturn) . '\';');
		}
	}
	
	public function sample()
	{
		Phpfox::getBlock('language.sample');
	}

	public function loadMailPhrases()
	{
		$sLanguage = $this->get('sLanguage');
		Phpfox::getBlock('language.admincp.email', array('sLanguage' => $sLanguage));
		$this->html('#phrasesContainer', $this->getContent(false));
	}
}

?>