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
 * @version 		$Id: add.class.php 1558 2010-05-04 12:51:22Z Raymond_Benc $
 */
class Core_Component_Controller_Admincp_Currency_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		if (($sId = $this->request()->get('id')) && ($aCurrency = Phpfox::getService('core.currency')->getForEdit($sId)))
		{
			$bIsEdit = true;
			$this->template()->assign('aForms', $aCurrency);	
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('core.currency.process')->update($aCurrency['currency_id'], $aVals))
				{
					$this->url()->send('admincp.core.currency.add', array('id' => $aVals['currency_id']), Phpfox::getPhrase('admincp.currency_successfully_updated'));
				}				
			}
			else 
			{
				if (Phpfox::getService('core.currency.process')->add($aVals))
				{
					$this->url()->send('admincp.core.currency', null, Phpfox::getPhrase('admincp.currency_successfully_added'));
				}
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('core.currency_manager'))
			->setBreadcrumb(Phpfox::getPhrase('core.currency_manager'), $this->url()->makeUrl('admincp.core.currency'))		
			->setBreadcrumb(Phpfox::getPhrase('admincp.add_currency'), null, true)
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
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_admincp_currency_add_clean')) ? eval($sPlugin) : false);
	}
}

?>