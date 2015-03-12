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
 * @version 		$Id: add.class.php 1522 2010-03-11 17:56:49Z Miguel_Espinoza $
 */
class Music_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$oValidator = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_genre_add',
				'aParams' => array(
					'name' => Phpfox::getPhrase('music.provide_a_genre_name')
				)
			)
		);
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if ($oValidator->isValid($aVals))
			{
				if (Phpfox::getService('music.genre.process')->add($aVals))
				{
					$this->url()->send('admincp.music.add', null, Phpfox::getPhrase('music.genre_successfully_added'));
				}
			}
		}
		
		$this->template()
			->setTitle(Phpfox::getPhrase('music.add_genre'))
			->setBreadcrumb(Phpfox::getPhrase('music.add_genre'), $this->url()->makeUrl('admincp.music'))
			->assign(array(
					'sCreateJs' => $oValidator->createJS(),
					'sGetJsForm' => $oValidator->getJsForm()			
				)
			);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>