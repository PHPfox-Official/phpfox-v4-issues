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
 * @version 		$Id: add.class.php 1179 2009-10-12 13:56:40Z Raymond_Benc $
 */
class Share_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		if (($iEditId = $this->request()->getInt('id')) && ($aSite = Phpfox::getService('share')->getForEdit($iEditId)))
		{
			$bIsEdit = true;
			$this->template()->assign('aForms', $aSite);
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('share.process')->update($aSite['site_id'], $aVals))
				{
					$this->url()->send('admincp.share', null, Phpfox::getPhrase('share.site_successfully_updated'));
				}				
			}
			else 
			{
				if (Phpfox::getService('share.process')->add($aVals))
				{
					$this->url()->send('admincp.share', null, Phpfox::getPhrase('share.site_successfully_added'));
				}
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('share.add_a_social_bookmarking_site'))
			->setBreadcrumb(Phpfox::getPhrase('share.social_bookmarking'), $this->url()->makeUrl('admincp.share'))
			->setBreadcrumb(Phpfox::getPhrase('share.add_a_site'), null, true)
			->assign(array(
					'bIsEdit' => $bIsEdit
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('share.component_controller_admincp_social_add_clean')) ? eval($sPlugin) : false);
	}
}

?>