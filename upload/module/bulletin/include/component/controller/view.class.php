<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Bulletin
 * @version 		$Id: view.class.php 1722 2010-08-13 14:56:11Z Miguel_Espinoza $
 */
class Bulletin_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{			
		if (($sLegacyTitle = $this->request()->getInt('id')) && !empty($sLegacyTitle))
		{			
			$aImport = Phpfox::getLib('database')->select('*')
				->from(Phpfox::getT('bulletin'))
				->where('bulletin_id = ' . (int) $sLegacyTitle)
				->execute('getSlaveRow');
			
			Phpfox::getService('core')->getLegacyItem(array(
					'field' => array('blog_id', 'title'),
					'table' => 'blog',		
					'redirect' => 'blog',
					'search' => 'blog_id',
					'title' => $aImport['legacy_import_id']
				)
			);
		}		

		$this->url()->send('blog', array(), null, 301);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('bulletin.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}

?>