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
 * @version 		$Id: logo.class.php 3657 2011-12-05 09:48:06Z Raymond_Benc $
 */
class Theme_Component_Controller_Admincp_Style_Logo extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$this->_setMenuName('admincp.theme');
		
		$aStyle = Theme_Service_Style_Style::instance()->getStyle($this->request()->getInt('id'));
		
		if (!isset($aStyle['theme_id']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('theme.not_a_valid_style'));
		}
		
		if ($this->request()->get('revert'))
		{
			if (Theme_Service_Style_Process::instance()->revertLogo($aStyle['style_id']))
			{
				$this->url()->send('admincp.theme.style.logo', array('id' => $aStyle['style_id']), Phpfox::getPhrase('theme.logo_successfully_reverted'));
			}
		}

		if (!empty($_FILES['logo']))
		{
			$aImage = Phpfox_File::instance()->load('logo', array('jpg', 'gif', 'png'));
			
			if (isset($aImage['tmp_name']) && Theme_Service_Style_Process::instance()->changeLogo($aStyle['style_id'], $aImage, ($this->request()->get('resize') == '1' ? true : false)))
			{
				$this->url()->send('admincp.theme.style.logo', array('id' => $aStyle['style_id']), Phpfox::getPhrase('theme.logo_successfully_uploaded'));
			}
		}

		list($sCurrentStyleLogo, $bIsNewLogo, $iWidth, $iHeight) = Theme_Service_Style_Style::instance()->getCurrentLogo($aStyle['style_id']);

		$this->template()->setTitle(Phpfox::getPhrase('theme.change_site_logo'))
			->setBreadcrumb(Phpfox::getPhrase('theme.themes'), $this->url()->makeUrl('admincp.theme'))
			->setBreadcrumb($aStyle['theme_name'], $this->url()->makeUrl('admincp.theme'))
			->setBreadcrumb(Phpfox::getPhrase('theme.styles'), $this->url()->makeUrl('admincp.theme.style', array('id' => $aStyle['theme_id'])))
			->setBreadcrumb($aStyle['name'], $this->url()->makeUrl('admincp.theme.style', array('id' => $aStyle['theme_id'])))
			->setBreadcrumb(Phpfox::getPhrase('theme.change_logo'), null, true)			
			->assign(array(
					'aStyle' => $aStyle,
					'sCurrentStyleLogo' => $sCurrentStyleLogo,
					'bIsNewLogo' => $bIsNewLogo,
					'iWidth' => 100,
					'iHeight' => 100
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('theme.component_controller_admincp_logo_clean')) ? eval($sPlugin) : false);
	}
}

?>