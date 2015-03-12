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
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z Raymond_Benc $
 */
class Egift_Component_Controller_Admincp_Categories extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aCategories = Phpfox::getService('egift')->getCategories();
		$aLanguages = Phpfox::getService('language')->getAll();

		/* Adding a category*/
		if ( ($aVals = $this->request()->getArray('cat')))
		{
			$aVals = array_merge($aVals, $this->request()->getArray('val'));
			if ($aVals['do_schedule'])
			{
				// no values? Create them based on the datepicker values
				if (empty($aVals['start_month']) && empty($aVals['start_day']) && empty($aVals['end_month']) && empty($aVals['end_day']))
				{
					// Start date, get the complete date
					$sStartDate = $this->request()->get('js_start__datepicker');
					// Separate it
					$aDate = explode('/', $sStartDate);
					// Set the month, day and year
					switch($aVals['date_order'])
					{
						case 'DMY':
							$aVals['start_day'] = $aDate[0];
							$aVals['start_month'] = $aDate[1];
							$aVals['start_year'] = $aDate[2];
							break;
						case 'YMD':
							$aVals['start_year'] = $aDate[0];
							$aVals['start_month'] = $aDate[1];
							$aVals['start_day'] = $aDate[2];
							break;
						// MDY
						default:
							$aVals['start_month'] = $aDate[0];
							$aVals['start_day'] = $aDate[1];
							$aVals['start_year'] = $aDate[2];
							break;
					}
				   
					// End date, get the complete date
					$sEndDate = $this->request()->get('js_end__datepicker');
					// Separate it
					$aDate = explode('/', $sEndDate);
					// Set the month, day and year
					switch($aVals['date_order'])
					{
						case 'DMY':
							$aVals['end_day'] = $aDate[0];
							$aVals['end_month'] = $aDate[1];
							$aVals['end_year'] = $aDate[2];
							break;
						case 'YMD':
							$aVals['end_year'] = $aDate[0];
							$aVals['end_month'] = $aDate[1];
							$aVals['end_day'] = $aDate[2];
							break;
						// MDY
						default:
							$aVals['end_month'] = $aDate[0];
							$aVals['end_day'] = $aDate[1];
							$aVals['end_year'] = $aDate[2];
							break;
					}
	 
					// Delete the aux variables                                    
					unset($sStartDate);
					unset($aDate);
				}
			}
			
			if (Phpfox::getService('egift.process')->addCategory($aVals))
			{
				$this->url()->send('admincp.egift.categories',array(), Phpfox::getPhrase('egift.category_added_successfully'));
			}
		}
		/* Editing categories */
		else if($aVal = $this->request()->getArray('val'))
		{
			if ($aVal['do_schedule'])
			{
				// no values? Create them based on the datepicker values
				if (empty($aVal['start_month']) && empty($aVal['start_day']) && empty($aVal['end_month']) && empty($aVal['end_day']))
				{
					// Start date, get the complete date
					$sStartDate = $this->request()->get('js_start__datepicker');
					// Separate it
					$aDate = explode('/', $sStartDate);
					// Set the month, day and year
					switch($aVals['edit_date_order'])
					{
						case 'DMY':
							$aVal['start_day'] = $aDate[0];
							$aVal['start_month'] = $aDate[1];
							$aVal['start_year'] = $aDate[2];
							break;
						case 'YMD':
							$aVal['start_year'] = $aDate[0];
							$aVal['start_month'] = $aDate[1];
							$aVal['start_day'] = $aDate[2];
							break;
						// MDY
						default:
							$aVal['start_month'] = $aDate[0];
							$aVal['start_day'] = $aDate[1];
							$aVal['start_year'] = $aDate[2];
							break;
					}
				   
					// End date, get the complete date
					$sEndDate = $this->request()->get('js_end__datepicker');
					// Separate it
					$aDate = explode('/', $sEndDate);
					// Set the month, day and year
					switch($aVal['edit_date_order'])
					{
						case 'DMY':
							$aVal['end_day'] = $aDate[0];
							$aVal['end_month'] = $aDate[1];
							$aVal['end_year'] = $aDate[2];
							break;
						case 'YMD':
							$aVal['end_year'] = $aDate[0];
							$aVal['end_month'] = $aDate[1];
							$aVal['end_day'] = $aDate[2];
							break;
						// MDY
						default:
							$aVal['end_month'] = $aDate[0];
							$aVal['end_day'] = $aDate[1];
							$aVal['end_year'] = $aDate[2];
							break;
					}
	 
					// Delete the aux variables                                    
					unset($sStartDate);
					unset($aDate);
				}
			}
			
			if (Phpfox::getService('egift.process')->editCategory($this->request()->getArray('val')))
			{
				$this->url()->send('admincp.egift.categories',array(),Phpfox::getPhrase('egift.update_successfully'));
			}
		}
		/* Deleting a category */
		else if ($iId = $this->request()->getInt('delete'))
		{
			if (Phpfox::getService('egift.process')->deleteCategory($iId))
			{
				$this->url()->send('admincp.egift.categories',array(),Phpfox::getPhrase('egift.delete_successfully'));
			}
		}

		$this->template()->assign(array(
			'aCategories' => $aCategories,
			'aLanguages' => $aLanguages,
			'iTotalColumns' => count($aLanguages) + 3
			))
			->setHeader(array(
				'categories.js' => 'module_egift',
				'drag.js' => 'static_script',
				'<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'egift.setOrder\'}); }</script>'
			))
			->setBreadcrumb(Phpfox::getPhrase('egift.module_egift'), $this->url()->makeUrl('admincp.egift'))
			->setBreadcrumb(Phpfox::getPhrase('egift.maange_categories'), null, true);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('egift.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>
