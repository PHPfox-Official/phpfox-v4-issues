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
 * @version 		$Id: browse.class.php 852 2009-08-10 18:05:32Z Raymond_Benc $
 */
class User_Component_Block_Browse extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		$iPage = $this->getParam('page', 0);
		$iPageSize = 9;
		$oDb = Phpfox::getLib('database');
		
		$aConditions = array();
		if (($sFind = $this->getParam('find')))
		{
			$aConditions[] = 'AND (u.user_name LIKE \'%' . $oDb->escape($sFind) . '%\' OR u.full_name LIKE \'%' . $oDb->escape($sFind) . '%\' OR u.email LIKE \'%' . $oDb->escape($sFind) . '%\')';	
		}
		
		list($iCnt, $aUsers) = Phpfox::getService('user.browse')
			->conditions($aConditions)
			->page($iPage)
			->limit($iPageSize)
			->sort('u.last_login DESC')
			->get();
		
		Phpfox::getLib('pager')->set(array('ajax' => 'user.browseAjax', 'page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));	

		$this->template()->assign(array(
				'aUsers' => $aUsers,
				'sPrivacyInputName' => $this->getParam('input'),
				'bIsAjaxSearch' => $this->getParam('is_search', false)
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_block_browse_clean')) ? eval($sPlugin) : false);
	}
}

?>