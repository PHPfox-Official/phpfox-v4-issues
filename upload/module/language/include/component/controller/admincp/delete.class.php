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
 * @package  		Module_Language
 * @version 		$Id: delete.class.php 6136 2013-06-24 12:28:43Z Miguel_Espinoza $
 */
class Language_Component_Controller_Admincp_Delete extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		Phpfox::getUserParam('language.can_manage_lang_packs', true);
		
		if ($this->request()->get('no'))
		{
			$this->url()->send('admincp', 'language');
		}		
		
		$iId = $this->request()->get('id');
		
		if (!$iId)
		{
			return Phpfox_Error::display(Phpfox::getPhrase('language.invalid_language'));	
		}
		
		$aLanguage = Phpfox::getService('language')->getLanguage($iId);		
		
		if (!isset($aLanguage['language_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('language.invalid_language_package'));
		}
		
		if ($this->request()->get('yes'))
		{
			if (Phpfox::getService('language.process')->delete($iId))
			{
				Phpfox::getLib('locale')->autoLoadLanguage();
				$this->url()->send('admincp', 'language', Phpfox::getPhrase('language.language_package_successfully_deleted'));
			}
		}
		
		$this->template()->assign(array(
			'aLanguage' => $aLanguage
		))->setTitle(Phpfox::getPhrase('language.manage_language_packages'))
			->setTitle(Phpfox::getPhrase('language.delete'))
			->setBreadcrumb(Phpfox::getPhrase('language.manage_language_packages'))
			->setBreadcrumb(Phpfox::getPhrase('language.delete'));
	}
}

?>