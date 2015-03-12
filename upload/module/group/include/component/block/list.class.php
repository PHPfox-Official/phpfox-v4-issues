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
 * @version 		$Id: list.class.php 1129 2009-10-03 12:42:56Z Raymond_Benc $
 */
class Group_Component_Block_List extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iPage = $this->request()->getInt('page');
		$iType = $this->request()->getInt('type', 1);
		$iPageSize = 6;

		if (PHPFOX_IS_AJAX)
		{
			$aGroup = Phpfox::getService('group')->getGroup($this->request()->get('id'), true);
			$this->template()->assign('aGroup', $aGroup);
		}
		else 
		{
			$aGroup = $this->getParam('aGroup');			
		}
		
		if (!Phpfox::getService('group')->hasAccess($aGroup['group_id'], 'can_view_members'))
		{
			return false;
		}
		
		list($iCnt, $aMembers) = Phpfox::getService('group')->getMembers($aGroup['group_id'], $iType, $iPage, $iPageSize, ($this->request()->getInt('admin') ? true : false));
		
		Phpfox::getLib('pager')->set(array('ajax' => 'group.listMembers', 'page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'aParams' => array('id' => $aGroup['group_id'])));
		
		$this->template()->assign(array(
				'aMembers' => $aMembers,
				'iType' => $iType	
			)
		);		
		
		if (!PHPFOX_IS_AJAX)
		{		
			$this->template()->assign(array(
					'sHeader' => Phpfox::getPhrase('group.members'),					
					'sBoxJsId' => 'group_members'
				)
			);
			
			if ($iCnt == 6)
			{
				$this->template()->assign(array(
						'aFooter' => array(
							Phpfox::getPhrase('group.view_more') => $this->url()->makeUrl('group', array($aGroup['title_url'], 'member'))
						)
					)
				);
			}
			
			if ($this->getParam('group_list_menu'))
			{				
				$this->template()->assign(array(
						'aMenu' => array(
							Phpfox::getPhrase('group.members') => '#group.listMembers?type=1&amp;id=' . $aGroup['group_id'],
							Phpfox::getPhrase('group.admins') => '#group.listMembers?type=1&amp;admin=1&amp;id=' . $aGroup['group_id'],
							Phpfox::getPhrase('group.not_responded') => '#group.listMembers?type=0&amp;id=' . $aGroup['group_id'],
							Phpfox::getPhrase('group.pending_approval') => '#group.listMembers?type=2&amp;id=' . $aGroup['group_id'],							
						)
					)
				);
			}
			
			return 'block';
		}		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('group.component_block_list_clean')) ? eval($sPlugin) : false);
	}			
}

?>