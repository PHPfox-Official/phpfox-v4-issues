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
 * @version 		$Id: display.class.php 2689 2011-06-23 12:10:46Z Raymond_Benc $
 */
class Custom_Component_Block_Display extends Phpfox_Component
{
	private $_sTemplate = null;
	
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		static $iUserGroupId = 0;
		static $bIsCustom = false;
		static $aCustomMain = array();

		if (!Phpfox::getService('user.privacy')->hasAccess($this->getParam('item_id'), 'profile.profile_info'))
		{
			return false;
		}
		
		if ($iUserGroupId === 0)
		{
			$aUser = (PHPFOX_IS_AJAX ? array('user_group_id' => $this->getParam('user_group_id')) : $this->getParam('aUser'));
		
			$bIsCustom = Phpfox::getService('user.group.setting')->getGroupParam($aUser['user_group_id'], 'custom.has_special_custom_fields');
			$iUserGroupId = $aUser['user_group_id'];
		}

		if (!isset($aCustomMain[$this->getParam('type_id')]))
		{
			$aCustomMain[$this->getParam('type_id')] = Phpfox::getService('custom')->getForDisplay($this->getParam('type_id'), $this->getParam('item_id'), ($bIsCustom ? $iUserGroupId : null));
		}

		$aOutput = array();
		if (($sCustomFieldName = $this->getParam('custom_field_id')))
		{			
			if (!isset($aCustomMain[$this->getParam('type_id')]['cf_' . $sCustomFieldName]))
			{				
				return false;
			}
		
			$aOutput = array($aCustomMain[$this->getParam('type_id')]['cf_' . $sCustomFieldName]);
		}		
		else 
		{
			$aOutput = $aCustomMain[$this->getParam('type_id')];
		}		
		
		$this->_sTemplate = $this->getParam('template');

		$this->template()->assign(array(
				'aCustomMain' => $aOutput,
				'sTemplate' => $this->getParam('template')
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{		
		$this->template()->clean(array(
				'aCustomMain'
			)
		);
		
		(($sPlugin = Phpfox_Plugin::get('custom.component_block_display_clean')) ? eval($sPlugin) : false);
	}
}

?>