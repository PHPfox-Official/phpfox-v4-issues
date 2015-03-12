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
class Apps_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{				
		/* Is user trying to delete an app? */
		if ( ($iId = $this->request()->getInt('delete')))
		{
			if (Phpfox::getService('apps.process')->deleteApp($iId))
			{
				Phpfox::getLib('url')->send('apps', null, Phpfox::getPhrase('apps.app_successfully_deleted'));
			}
			else
			{
				// this function returns Phpfox_Error::display so we dont need much here
			}
		}
		
		$sView = $this->request()->get('view');	
		
		/* Uninstalling ? */
		if ( ($iId = $this->request()->getInt('uninstall')))
		{
			if (Phpfox::getService('apps.process')->uninstallApp($iId))
			{
				Phpfox::getLib('url')->send('apps', array('view' => 'installed'), Phpfox::getPhrase('apps.app_successfully_uninstalled'));
			}
		}
		
		if ($this->request()->getInt('req2') > 0)
		{			
			return Phpfox::getLib('module')->setController('apps.view');
		}
		
		$oApps = Phpfox::getService('apps');
		$aCategories = $oApps->getCategories();		
		
		/* Build the menu on the left side */
		$aFilterMenu = array(
				Phpfox::getPhrase('apps.all_apps') => '',
				Phpfox::getPhrase('apps.my_apps') => 'my',
				Phpfox::getPhrase('apps.installed_apps') => 'installed' 
			);
		
		if (Phpfox::getUserParam('apps.can_moderate_apps'))
		{
			$iPendingTotal = Phpfox::getService('apps')->getPendingTotal();			
			if ($iPendingTotal)
			{
				$aFilterMenu['' . Phpfox::getPhrase('apps.pending_apps') . '<span class="pending">' . $iPendingTotal . '</span>'] = 'pending';
			}
		}	
		$this->template()->buildSectionMenu('apps', $aFilterMenu);
		
		$this->template()->setTitle(Phpfox::getPhrase('apps.apps'))->setBreadcrumb('Apps', $this->url()->makeUrl('apps'));		
		
		if ($this->request()->get('req2') == 'category' && ($iCategoryId = $this->request()->getInt('req3')) && ($aType = Phpfox::getService('apps.category')->getCategoryById($iCategoryId)))
		{
			$this->setParam('iCategory', $iCategoryId);
			
			$this->template()->setBreadcrumb(Phpfox::getLib('locale')->convert($aType['name']), Phpfox::permalink('apps.category', $aType['category_id'], $aType['name']) . ($sView ? 'view_' . $sView . '/' . '' : ''), true);
		}		
		
		if ($this->request()->get('req2') == 'sub-category' && ($iSubCategoryId = $this->request()->getInt('req3')) && ($aCategory = Phpfox::getService('apps.category')->getCategoryById($iSubCategoryId)))
		{
			$this->setParam('iCategory', $aCategory['type_id']);
			
			// $this->template()->setBreadcrumb(Phpfox::getLib('locale')->convert($aCategory['type_name']), Phpfox::permalink('pages.category', $aCategory['type_id'], $aCategory['type_name']) . ($sView ? 'view_' . $sView . '/' . '' : ''));
			$this->template()->setBreadcrumb(Phpfox::getLib('locale')->convert($aCategory['name']), Phpfox::permalink('apps.sub-category', $aCategory['category_id'], $aCategory['name']) . ($sView ? 'view_' . $sView . '/' . '' : ''), true);
		}
		
		// Set up Browsing search filters
		$this->search()->set(array(
				'type' => 'app',
				'field' => 'app.app_id',				
				'search_tool' => array(
					'table_alias' => 'app',
					'search' => array(
						'action' => $this->url()->makeUrl('apps', array($this->request()->get('view'))),
						'default_value' => Phpfox::getPhrase('apps.search_apps'),
						'name' => 'search',
						'field' => 'app.app_title'
					),
					'sort' => array(
						'latest' => array('app.time_stamp', Phpfox::getPhrase('apps.latest'))												
					),
					'show' => array(10, 15, 20)
				)
			)
		);			
		
		$aModeration = array(
				'name' => 'apps',
				'ajax' => 'apps.appsModeration',
				'menu' => array(
					array(
						'phrase' => Phpfox::getPhrase('apps.delete'),
						'action' => 'delete'
					),
					array(
						'phrase' => Phpfox::getPhrase('apps.approve'),
						'action' => 'approve'
					)					
				)
			);
		
		$aBrowseParams = array(
			'module_id' => 'apps',
			'alias' => 'app',
			'field' => 'app_id',
			'table' => Phpfox::getT('app'),
			'hide_view' => array('pending', 'my')
		);
		
		switch( $this->request()->get('view', 'all'))
		{
			case 'my':
				Phpfox::isUser(true);
				$this->search()->setCondition('AND app.user_id = ' . Phpfox::getUserId());
				break;
			case 'installed':
				Phpfox::isUser(true);
				$aModeration['menu'] = array(
					array(
						'phrase' => Phpfox::getPhrase('apps.uninstall'),
						'action' => 'uninstall'
					),
					array(
						'phrase' => Phpfox::getPhrase('apps.approve'),
						'action' => 'approve'
					)	);
				$this->search()->setCondition('AND app.privacy IN(%PRIVACY%) AND app.view_id = 0');
				break;
			case 'pending':
				Phpfox::getUserParam('apps.can_moderate_apps', true);
				$this->search()->setCondition('AND app.view_id = 1');
				break;
			default:
				$this->search()->setCondition('AND app.privacy IN(%PRIVACY%) AND app.view_id = 0');			
		}
		$this->search()->browse()->params($aBrowseParams)->execute();	
		
		$aApps = $this->search()->browse()->getRows();
		
		$this->setParam('global_moderation', $aModeration);
		
		Phpfox::getLib('pager')->set(array('page' => $this->search()->getPage(), 'size' => $this->search()->getDisplay(), 'count' => $this->search()->browse()->getCount()));
		
		$this->template()->assign(array(
					'aApps' => $aApps,
					'aCategories' => $aCategories
				)
			)
			->setHeader(array(
					'index.css' => 'module_apps',
					'index.js' => 'module_apps',
					'comment.css' => 'style_css',
					'pager.css' => 'style_css'
				)
			);			
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('apps.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>