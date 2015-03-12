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
 * @version 		$Id: add.class.php 3402 2011-11-01 09:07:31Z Miguel_Espinoza $
 */
class Pages_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$bIsEdit = false;
		$bIsSub = false;
		if (($iEditId = $this->request()->getInt('id')))
		{
			$aRow = Phpfox::getService('pages.type')->getForEdit($iEditId);
			$bIsEdit = true;
			$this->template()->assign(array(			
					'aForms' => $aRow,
					'iEditId' => $iEditId
				)
			);
		}
		
		if (($iSubtEditId = $this->request()->getInt('sub')))
		{
			$aRow = Phpfox::getService('pages.category')->getForEdit($iSubtEditId);
			$iEditId = $iSubtEditId;
			$bIsEdit = true;
			$bIsSub = true;
			$this->template()->assign(array(			
					'aForms' => $aRow,
					'iEditId' => $iEditId
				)
			);
		}		
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if ($bIsEdit)
			{
				if (Phpfox::getService('pages.process')->updateCategory($iEditId, $aVals))
				{
					if ($bIsSub)
					{
						$this->url()->send('admincp.pages', array('sub' => $aVals['type_id']), Phpfox::getPhrase('pages.successfully_updated_the_category'));
					}
					else
					{
						$this->url()->send('admincp.pages', null, Phpfox::getPhrase('pages.successfully_updated_the_category'));
					}					
				}				
			}
			else
			{
				if (Phpfox::getService('pages.process')->addCategory($aVals))
				{
					$this->url()->send('admincp.pages', null, Phpfox::getPhrase('pages.successfully_created_a_new_category'));
				}
			}
		}
		
		$this->template()->setTitle(Phpfox::getPhrase('pages.add_category'))
			->setBreadcrumb(Phpfox::getPhrase('pages.add_category'))
			->assign(array(
				'bIsEdit' => $bIsEdit,
				'aTypes' => Phpfox::getService('pages.type')->get()
			)
		)		
			->setHeader(array(
				'add.js' => 'module_pages'
			));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('pages.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>