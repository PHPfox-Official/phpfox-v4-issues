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
 * @version 		$Id: profile.class.php 5840 2013-05-09 06:14:35Z Raymond_Benc $
 */
class Pages_Component_Block_Profile extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$aUser = $this->getParam('aUser');
		
		list($iTotal, $aPages) = Phpfox::getService('pages')->getForProfile($aUser['user_id'], 10);
		
		if (!$iTotal)
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => '<a href="'.$this->url()->makeUrl($aUser['user_name'], 'pages/?view=all').'">' . Phpfox::getPhrase('pages.pages') . '<span>' . $iTotal . '</span></a>',
				'aPagesList' => $aPages,
			)
		);
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('pages.component_block_profile_clean')) ? eval($sPlugin) : false);
	}
}

?>