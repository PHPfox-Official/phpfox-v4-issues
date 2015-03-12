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
 * @version 		$Id: group.class.php 1121 2009-10-01 12:59:13Z Raymond_Benc $
 */
class Event_Component_Controller_Group extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aGroup = $this->getParam('aGroup');
		
		if (!Phpfox::getService('group')->hasAccess($aGroup['group_id'], 'can_use_event'))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('event.the_events_section_is_closed'));
		}		
		
		if ($this->request()->get('req4') == 'view')
		{
			$this->setParam('aCallback', array(
					'request' => 'req5',
					'item' => $aGroup['group_id'],
					'module' => 'group',
					'host' => $aGroup['title'],
					'url' => array(
						'group',
						array(
							$aGroup['title_url']							
						)
					),
					'url_home' => array(
						'group',
						array(
							$aGroup['title_url']							
						)
					)
				)	
			);
			
			return Phpfox::getLib('module')->setController('event.view');
		}		
		elseif ($this->request()->get('req4') == 'add')
		{			
			$this->url()->send('event.add', array('module' => 'group', 'item' => $aGroup['group_id']));
		}
		
		$this->setParam('aCallback', array(
				'category_request' => 3,
				'item' => $aGroup['group_id'],
				'module' => 'group',
				'url' => array(
					'group',
					array(
						$aGroup['title_url'],
						'event',
						'view'
					)
				),
				'url_home' => array(
					'group',
					array(
						$aGroup['title_url']							
					)
				)				
			)
		);
		
		return Phpfox::getLib('module')->setController('event.index');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('event.component_controller_group_clean')) ? eval($sPlugin) : false);
	}
}

?>