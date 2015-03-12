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
 * @package  		Module_Bulletin
 * @version 		$Id: display.class.php 1724 2010-08-16 11:14:54Z Miguel_Espinoza $
 */
class Bulletin_Component_Block_Display extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		return false;
		
		if (!Phpfox::isUser())
		{
			return false;
		}		
		
		$aBulletins = Phpfox::getService('bulletin.bulletin')->getBulletins(Phpfox::getUserId());
		
		
		if (empty($aBulletins))
		{
			return false;
		}
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('bulletin.bulletins'),	
				'aBulletins' => $aBulletins,		
				'bNoExtraLinks' => true,	
				'aFooter' => ((empty($aBulletins) ? array() : array(
							Phpfox::getPhrase('bulletin.view_all_bulletins') => $this->url()->makeUrl('bulletin'),
							Phpfox::getPhrase('bulletin.post_a_bulletin') => $this->url()->makeUrl('bulletin.add')
						)
					)
				)
			)
		);
		
		$this->template()->assign('sDeleteBlock', 'dashboard');
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('bulletin.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
	
	public function widget()
	{
		return true;
	}
}

?>