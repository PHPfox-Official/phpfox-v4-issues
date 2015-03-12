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
 * @version 		$Id: group.class.php 1306 2009-12-09 05:05:18Z Raymond_Benc $
 */
class Photo_Component_Controller_Group extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::getUserParam('photo.can_view_photos', true);
		
		$aGroup = $this->getParam('aGroup');		
		
		if (!Phpfox::getService('group')->hasAccess($aGroup['group_id'], 'can_use_photo'))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('photo.photo_section_is_closed'));
		}		
		
		$this->setParam('aCallback', array(
				'group_id' => $aGroup['group_id'],
				'url_home' => 'group.' . $aGroup['title_url'] . '.photo',
				'url_home_array' => array(
					'group',
					array(
						$aGroup['title_url']							
					)
				),
				'title' => $aGroup['title']	
			)
		);		
		
		if ($this->request()->get('req4') == 'view')
		{			
			return Phpfox::getLib('module')->setController('photo.view');	
		}		
		elseif ($this->request()->get('req4') == 'upload')
		{
			$this->url()->send('photo.upload', array('module' => 'group', 'item' => $aGroup['group_id']));
		}
		
		$this->template()->removeUrl('photo.index', 'photo.battle');
		$this->template()->removeUrl('photo.index', 'photo.rate');
		$this->template()->removeUrl('photo.index', 'profile.photo');
		$this->template()->removeUrl('photo.index', 'photo.public-album');
		$this->template()->rebuildMenu('photo.index', array(
					'group',
					array(
						$aGroup['title_url']							
					)
				)
			);
		
		return Phpfox::getLib('module')->setController('photo.index');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_controller_group_clean')) ? eval($sPlugin) : false);
	}
}

?>