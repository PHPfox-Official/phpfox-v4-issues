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
 * @version 		$Id: design.class.php 5538 2013-03-25 13:20:22Z Miguel_Espinoza $
 */
class Theme_Component_Block_Design extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!defined('PHPFOX_IN_DESIGN_MODE') || defined('PHPFOX_PROFILE_INFO_PAGE'))
		{
			return false;
		}
		
		$aDesigner = $this->getParam('aDesigner', false);		
		
		if ($this->request()->get('reset_form'))
		{
			if (Phpfox::getService('theme.process')->resetCss($aDesigner['type_id'], $this->request()->getArray('css')))
			{
				$this->url()->forward($aDesigner['design_page'] . 'advanced/#' . $this->request()->get('reset_group'));			
			}
		}
		
		if ($this->request()->get('resetblock'))
		{
			if (Phpfox::getService('theme.process')->resetBlock($aDesigner['type_id']))
			{
				$this->url()->forward($aDesigner['design_page'] . 'block/');			
			}
		}		
		
		$aStlyes = Phpfox::getService('theme.style')->getStyles();

		$this->template()->assign(array(
				'aStlyes' => $aStlyes,
				'aDesigner' => $aDesigner,
				'aFonts' => Phpfox::getLib('parse.css')->getFonts(),
				'aFontSizes' => Phpfox::getLib('parse.css')->getFontSizes(),
				'aFontWeights' => Phpfox::getLib('parse.css')->getFontWeights(),
				'aFontStyles' => Phpfox::getLib('parse.css')->getFontStyles(),
				'aPositions' => Phpfox::getLib('parse.css')->getPositions(),
				'aBorderWidths' => Phpfox::getLib('parse.css')->getBorderWidths(),				
				'aBorderStyles' => Phpfox::getLib('parse.css')->getBorderStyles(),
				'aPaddingSizes' => Phpfox::getLib('parse.css')->getPaddingSizes(),
				'aTextAlign' => Phpfox::getLib('parse.css')->getTextAlign(),
				'aTextTransforms' => Phpfox::getLib('parse.css')->getTextTransforms(),
				'aTextDecorations' => Phpfox::getLib('parse.css')->getTextDecorations(),
				'iTestStyleId' => $this->request()->get('test_style_id'),
				'sResetGroup' => 'body',
				'sResetJs' => ''
			)
		);
		
		if ($this->request()->get('req3') == 'advanced')
		{
			$this->template()->assign('sResetJs', '<script type="text/javascript">$Behavior.theme_block_design = function() { if (!empty(window.location.hash)) { rebuilt_menu_design(window.location.hash); } };</script>');
		}
			
		if (isset($aDesigner['block']))
		{
			$this->template()->assign('aBlocks', Phpfox::getService('core')->getBlocks($aDesigner['block'], $aDesigner['item_id'], $aDesigner['type_id']));			
		}		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('theme.component_block_design_clean')) ? eval($sPlugin) : false);
	}
}

?>