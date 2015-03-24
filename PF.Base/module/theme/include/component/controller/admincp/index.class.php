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
 * @package  		Module_Theme
 * @version 		$Id: index.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class Theme_Component_Controller_Admincp_Index extends Phpfox_Component {
	public function process()
	{
		if (($iDeleteId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('theme.process')->delete($iDeleteId))
			{
				$this->url()->send('admincp.theme', null, Phpfox::getPhrase('theme.theme_successfully_deleted'));
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('theme.themes'))
			->setSectionTitle('Themes')
			->setBreadcrumb(Phpfox::getPhrase('theme.themes'), $this->url()->makeUrl('admincp.theme'))
			->assign(array(
					'themes' => $this->template()->theme()->all()
				)
			);
	}
}