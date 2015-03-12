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
 * @version 		$Id: index.class.php 1301 2009-12-07 15:43:49Z Raymond_Benc $
 */
class Theme_Component_Controller_Admincp_Style_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->_setMenuName('admincp.theme');
		
		$iId = $this->request()->getInt('id');
		
		$aTheme = Phpfox::getService('theme')->getTheme($iId);			
		
		if (!isset($aTheme['theme_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('theme.not_a_valid_theme'));
		}
		
		if (($iDeleteId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('theme.style.process')->delete($iDeleteId))
			{
				$this->url()->send('admincp.theme.style', array('id' => $aTheme['theme_id']), Phpfox::getPhrase('theme.style_successfully_deleted'));
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('theme.managing_styles_for') . ': ' . $aTheme['name'])
			->setBreadcrumb(Phpfox::getPhrase('theme.themes'), $this->url()->makeUrl('admincp.theme'))
			->setBreadcrumb($aTheme['name'], $this->url()->makeUrl('admincp.theme'))
			->setBreadcrumb(Phpfox::getPhrase('theme.styles'), null, true)			
			->assign(array(
					'aStyles' => Phpfox::getService('theme.style')->get('theme_id = ' . $this->request()->getInt('id')),
					'aTheme' => $aTheme					
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('theme.component_controller_admincp_style_index_clean')) ? eval($sPlugin) : false);
	}
}

?>