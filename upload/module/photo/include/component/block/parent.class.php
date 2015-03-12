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
 * @version 		$Id: parent.class.php 1174 2009-10-11 13:56:13Z Raymond_Benc $
 */
class Photo_Component_Block_Parent extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aGroup = $this->getParam('aGroup');
		$aPhotos = Phpfox::getService('photo')->getForGroup($aGroup['group_id'], $aGroup['title_url']);
		
		if (!count($aPhotos) && !defined('PHPFOX_IN_DESIGN_MODE'))
		{
			return false;
		}
		
		if (!Phpfox::getService('group')->hasAccess($aGroup['group_id'], 'can_use_photo'))
		{
			return false;
		}		
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('photo.photos'),
				'aPhotos' => $aPhotos
			)
		);
		
		if (count($aPhotos) == 3)
		{
			$this->template()->assign(array(
					'aFooter' => array(
						Phpfox::getPhrase('photo.view_more_photos') => $this->url()->makeUrl('group', array($aGroup['title_url'], 'photo'))
					)
				)
			);
		}
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_parent_clean')) ? eval($sPlugin) : false);
	}
}

?>