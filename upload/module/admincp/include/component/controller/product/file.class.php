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
 * @package  		Module_Admincp
 * @version 		$Id: file.class.php 5296 2013-01-31 12:37:12Z Miguel_Espinoza $
 */
class Admincp_Component_Controller_Product_File extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (Phpfox::getParam('core.phpfox_is_hosted'))
		{
			$this->url()->send('admincp');
		}			
		
		$oArchiveExport = Phpfox::getLib('archive.export')->set(array('zip'));
		$oArchiveImport = Phpfox::getLib('archive.import')->set(array('zip'));
		
		if ($this->request()->get('req4') == 'process')
		{
			$aData = unserialize(base64_decode($this->request()->get('step')));
			if ($mReturn = Phpfox::getService('admincp.module.process')->processInstall($this->request()->get('id'), $aData, $this->request()->get('overwrite')))
			{
				if (is_array($mReturn))
				{
					$this->url()->send('admincp', array('product', 'file', 'process', 'overwrite' => $this->request()->get('overwrite'), 'id' => $this->request()->get('id'), 'step' => base64_encode(serialize($mReturn))));
				}
				else 
				{
					Phpfox::getLib('module')->_cacheModules();
					Phpfox_Plugin::set();
					if ($sPlugin = Phpfox_Plugin::get('admincp.component_controller_product_file_1')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
					if ($this->request()->get('overwrite'))
					{
						if ($sPlugin = Phpfox_Plugin::get('admincp.component_controller_product_file_2')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
						$this->url()->send('admincp', array('product'), Phpfox::getPhrase('admincp.product_successfully_installed'));	
					}
					else 
					{
						if ($sPlugin = Phpfox_Plugin::get('admincp.component_controller_product_file_3')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
						$this->url()->send('admincp', array('product', 'file'), Phpfox::getPhrase('admincp.product_successfully_installed'));	
					}
				}
			}
		}

		// Run the export routine
		if ($sExportId = $this->request()->get('export'))
		{
			if ($mData = Phpfox::getService('admincp.product')->export($sExportId))
			{				
				$oArchiveExport->download('phpfox-product-' . $mData['name'], 'zip', $mData['folder']);
			}
		}
		
		if (($sProduct = $this->request()->get('install')))
		{
			// Import the settings
			if (($aInstall = Phpfox::getService('admincp.product.process')->import($sProduct, $this->request()->get('overwrite'))))
			{
				$this->url()->send('admincp', array('product', 'file', 'process', 'overwrite' => $this->request()->get('overwrite'), 'id' => $aInstall['product_id'], 'step' => base64_encode(serialize($aInstall['files']))));
			}
		}
		
		// Run the import routine
		if (isset($_FILES['import']) && ($aFile = $_FILES['import']))
		{
			if (preg_match('/^phpfox-product-(.*?)\.zip$/i', $aFile['name'], $aMatches))
            {
				if ($aFiles = $oArchiveImport->process($aFile))
				{
					$sFolderName = $aMatches[1];
					if (preg_match('/^(.*)-(.*?)$/i', $aMatches[1]))
					{
						$aParts = explode('-', $aMatches[1]);
						$sFolderName = $aParts[0];
					}						
					
					// Import the settings
					if (($aInstall = Phpfox::getService('admincp.product.process')->import($sFolderName, $this->request()->get('overwrite'))))
					{
						$this->url()->send('admincp', array('product', 'file', 'process', 'overwrite' => $this->request()->get('overwrite'), 'id' => $aInstall['product_id'], 'step' => base64_encode(serialize($aInstall['files']))));
					}
				}
            }
            else 
            {
            	Phpfox_Error::set('Not a valid product to import.');	
            }
		}

		$aProducts = Phpfox::getService('admincp.product')->get();
		foreach ($aProducts as $iKey => $aProduct)
		{
			if ($aProduct['product_id'] == 'phpfox' || $aProduct['product_id'] == 'phpfox_installer')
			{
				unset($aProducts[$iKey]);
			}
		}

		// Assign needed vars to the template
		$this->template()->setTitle(Phpfox::getPhrase('admincp.import_products'))
				->setBreadcrumb(Phpfox::getPhrase('admincp.products'), $this->url()->makeUrl('admincp.product'))
				->setBreadCrumb(Phpfox::getPhrase('admincp.import_products'), null, true)
				->assign(array(
				'aArchives' => $oArchiveExport->getSupported(),
				'sSupported' => $oArchiveImport->getSupported(),
				'sFtpEditLink' => $this->url()->makeUrl('admincp.setting.edit', array('group-id' => 'ftp')),
				'aNewProducts' => Phpfox::getService('admincp.product')->getNewProductsForInstall()
			)
		);

	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_setting_file_clean')) ? eval($sPlugin) : false);
	}
}

?>