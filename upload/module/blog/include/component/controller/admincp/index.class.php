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
 * @package  		Module_Blog
 * @version 		$Id: index.class.php 1522 2010-03-11 17:56:49Z Miguel_Espinoza $
 */
class Blog_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if ($aDeleteIds = $this->request()->getArray('id'))
		{
			if (Phpfox::getService('blog.category.process')->deleteMultiple($aDeleteIds))
			{
				$this->url()->send('admincp.blog', null, Phpfox::getPhrase('blog.categories_successfully_deleted'));
			}
		}
		
		$iPage = $this->request()->getInt('page');
		
		$aPages = array(5, 10, 15, 20);
		$aDisplays = array();
		foreach ($aPages as $iPageCnt)
		{
			$aDisplays[$iPageCnt] = Phpfox::getPhrase('core.per_page', array('total' => $iPageCnt));
		}		
		
		$aSorts = array(
			'added' => Phpfox::getPhrase('core.time'),
			'used' => Phpfox::getPhrase('blog.most_used')
		);
		
		$aFilters = array(
			'search' => array(
				'type' => 'input:text',
				'search' => "AND c.name LIKE '%[VALUE]%'"
			),	
			'user' => array(
				'type' => 'input:text',
				'search' => "AND u.user_name LIKE '%[VALUE]%'"
			),						
			'display' => array(
				'type' => 'select',
				'options' => $aDisplays,
				'default' => '10'
			),
			'created_by' => array(
				'type' => 'select',
				'options' => array(
					array(Phpfox::getPhrase('blog.users'), "AND c.user_id != 0"),
					array(Phpfox::getPhrase('blog.system'), "AND c.user_id = 0")
				),
				'add_select' => true
			),
			'sort' => array(
				'type' => 'select',
				'options' => $aSorts,
				'default' => 'added',
				'alias' => 'c'
			),
			'sort_by' => array(
				'type' => 'select',
				'options' => array(
					'DESC' => Phpfox::getPhrase('core.descending'),
					'ASC' => Phpfox::getPhrase('core.ascending')
				),
				'default' => 'DESC'
			)
		);		
		
		$oSearch = Phpfox::getLib('search')->set(array(
				'type' => 'categories',
				'filters' => $aFilters,
				'search' => 'search'
			)
		);
		
		$iLimit = $oSearch->getDisplay();
		
		list($iCnt, $aCategories) = Phpfox::getService('blog.category')->get($oSearch->getConditions(), $oSearch->getSort(), $oSearch->getPage(), $iLimit);
		
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iLimit, 'count' => $oSearch->getSearchTotal($iCnt)));
		
		$this->template()->setTitle(Phpfox::getPhrase('blog.blog'))
			->setBreadcrumb(Phpfox::getPhrase('blog.blog'), $this->url()->makeUrl('admincp.blog'))
			->assign(array(
					'aCategories' => $aCategories
				)
			)
			->setHeader('cache', array(
				'quick_edit.js' => 'static_script'			
			)			
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>