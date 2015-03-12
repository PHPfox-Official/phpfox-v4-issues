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
 * @version 		$Id: add.class.php 1522 2010-03-11 17:56:49Z Miguel_Espinoza $
 */
class Forum_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aValidation = array(
			'name' => Phpfox::getPhrase('forum.provide_a_name_for_your_forum')
		);		
		
		$oValid = Phpfox::getLib('validator')->set(array(
				'sFormName' => 'js_form', 
				'aParams' => $aValidation
			)
		);			
		
		$bIsEdit = false;
		if ($iId = $this->request()->getInt('id'))
		{		
			$bIsEdit = true;
			
			Phpfox::getUserParam('forum.can_edit_forum', true);
			
			$aForum = Phpfox::getService('forum')->getForEdit($iId);
			$this->template()->assign('aForms', $aForum);
		}
		else 
		{
			Phpfox::getUserParam('forum.can_add_new_forum', true);
		}
		
		if ($aVals = $this->request()->getArray('val'))
		{			
			if ($oValid->isValid($aVals))
			{
				if ($bIsEdit)
				{
					if (Phpfox::getService('forum.process')->update($aForum['forum_id'], $aVals))
					{
						$this->url()->send('admincp.forum', null, Phpfox::getPhrase('forum.forum_successfully_updated'));
					}					
				}
				else 
				{
					if (Phpfox::getService('forum.process')->add($aVals))
					{
						$this->url()->send('admincp.forum.add', null, Phpfox::getPhrase('forum.forum_successfully_added'));
					}
				}
			}
		}
		
		$sTitle = ($bIsEdit ? Phpfox::getPhrase('forum.editing_forum') . ': ' . $aForum['name'] : Phpfox::getPhrase('forum.create_new_form'));

		$this->template()->setTitle($sTitle)
			->setBreadCrumb($sTitle, $this->url()->makeUrl('admincp.forum'))
			->assign(array(			
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(),
				'sForumParents' => Phpfox::getService('forum')->active(($bIsEdit ? $aForum['parent_id'] : $this->request()->getInt('child')))->edit(($bIsEdit ? $aForum['forum_id'] : 0))->getJumpTool(true, $bIsEdit)
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('forum.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>