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
 * @version 		$Id: index.class.php 6113 2013-06-21 13:58:40Z Raymond_Benc $
 */
class Core_Component_Controller_Admincp_Currency_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (($sDelete = $this->request()->get('delete')))
		{
			if (Phpfox::getService('core.currency.process')->delete($sDelete))
			{
				$this->url()->send('admincp.core.currency', null, Phpfox::getPhrase('admincp.currency_successfully_deleted'));
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('core.currency_manager'))
			->setBreadcrumb(Phpfox::getPhrase('core.currency_manager'), $this->url()->makeUrl('admincp.core.currency'))		
			->setHeader('cache', array(
					'drag.js' => 'static_script',
					'<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'core.currencyOrdering\'}); }</script>'
				)
			)			
			->assign(array(
					'aCurrencies' => Phpfox::getService('core.currency')->getForBrowse()
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_controller_admincp_currency_index_clean')) ? eval($sPlugin) : false);
	}
}

?>