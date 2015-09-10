<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond_Benc
 * @package 		Phpfox_Component
 * @version 		$Id: like.class.php 3333 2011-10-20 13:34:25Z Miguel_Espinoza $
 */
class Pages_Component_Block_Like extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$aPage = $this->getParam('aPage');
		list($iTotalMembers, $aMembers) = Phpfox::getService('pages')->getMembers($aPage['page_id'], 12);

		$this->template()->assign(array(
				'sHeader' => '<a href="#" onclick="return $Core.box(\'like.browse\', 400, \'type_id=pages&amp;item_id=' . $aPage['page_id'] . '' . ($aPage['page_type'] != '1' ? '&amp;force_like=1' : '') . '\');">' . ($aPage['page_type'] == '1' ? Phpfox::getPhrase('pages.members_total', array('total' => $iTotalMembers)) : $iTotalMembers . ' Followers') . '</a>',
				'aMembers' => $aMembers
			)
		);
		
		if (!PHPFOX_IS_AJAX || defined("PHPFOX_IN_DESIGN_MODE") || Theme_Service_Theme::instance()->isInDndMode())
		{
			return 'block';
		}
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('pages.component_block_like_clean')) ? eval($sPlugin) : false);
	}
}

?>