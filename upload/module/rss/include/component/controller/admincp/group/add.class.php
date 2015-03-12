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
class Rss_Component_Controller_Admincp_Group_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;		
		if (($iId = $this->request()->getInt('id')))
		{
			if (($aGroup = Phpfox::getService('rss.group')->getForEdit($iId)))
			{
				$bIsEdit = true;
				$this->template()->assign('aForms', $aGroup);
			}
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('rss.group.process')->update($aGroup['group_id'], $aVals))
				{
					$this->url()->send('admincp.rss.group.add', array('id' => $aGroup['group_id']), Phpfox::getPhrase('rss.group_successfully_updated'));
				}				
			}
			else 
			{
				if (Phpfox::getService('rss.group.process')->add($aVals))
				{
					$this->url()->send('admincp.rss.group', null, Phpfox::getPhrase('rss.group_successfully_added'));
				}
			}
		}		
		
		$this->template()->setTitle(Phpfox::getPhrase('rss.add_new_group'))
			->setBreadcrumb(Phpfox::getPhrase('rss.manage_groups'), $this->url()->makeUrl('admincp.feed.group'))
			->setBreadcrumb(Phpfox::getPhrase('rss.add_new_group'), null, true)
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
		(($sPlugin = Phpfox_Plugin::get('rss.component_controller_admincp_group_add_clean')) ? eval($sPlugin) : false);
	}
}

?>