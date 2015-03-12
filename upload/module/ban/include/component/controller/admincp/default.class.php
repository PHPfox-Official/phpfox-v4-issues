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
 * @version 		$Id: default.class.php 6374 2013-07-27 12:05:58Z Raymond_Benc $
 */
class Ban_Component_Controller_Admincp_Default extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aBanFilter = $this->getParam('aBanFilter');
		
		if (($iDeleteId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('ban.process')->delete($iDeleteId))
			{
				$this->url()->send($aBanFilter['url'], null, Phpfox::getPhrase('ban.filter_successfully_deleted'));
			}
		}
		
		if (($sBanValue = $this->request()->get('find_value')))
		{
			$aBan = $this->request()->getArray('aBan');
			
			$aVals = array_merge(array(
						'type_id' => $aBanFilter['type'],
						'find_value' => $sBanValue,
						'replacement' => $this->request()->get('replacement', null)
					),$aBan);
			if (Phpfox::getService('ban.process')->add($aVals, $aBanFilter))	
			{
				$this->url()->send($aBanFilter['url'], null, Phpfox::getPhrase('ban.filter_successfully_added'));
			}
		}
		$aFilters = Phpfox::getService('ban')->getFilters($aBanFilter['type']);
		foreach ($aFilters as $iKey => $aFilter)
		{
			$aFilters[$iKey]['s_user_groups_affected'] = '';
			if (is_array($aFilter['user_groups_affected']))
			{				
				foreach ($aFilter['user_groups_affected'] as $aGroup)
				{
					$aFilters[$iKey]['s_user_groups_affected'] .= Phpfox::getLib('locale')->convert($aGroup['title']) . ', ';
				}
				$aFilters[$iKey]['s_user_groups_affected'] = rtrim($aFilters[$iKey]['s_user_groups_affected'], ', ');
			}
		}
		$this->template()->setTitle(Phpfox::getPhrase('ban.ban') . ': ' . $aBanFilter['title'])
			->setBreadcrumb(Phpfox::getPhrase('ban.ban_filters'))
			->setBreadcrumb($aBanFilter['title'], null, true)
			->assign(array(
					'aFilters' => $aFilters,
					'aBanFilter' => $aBanFilter
				)
			);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ban.component_controller_admincp_default_clean')) ? eval($sPlugin) : false);
	}
}

?>