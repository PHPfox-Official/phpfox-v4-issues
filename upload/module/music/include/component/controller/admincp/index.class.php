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
 * @version 		$Id: index.class.php 1522 2010-03-11 17:56:49Z Miguel_Espinoza $
 */
class Music_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($aIds = $this->request()->getArray('id'))
		{
			$iDeleted = 0;
			foreach ($aIds as $iId)
			{
				if (Phpfox::getService('music.genre.process')->delete($iId))
				{
					$iDeleted++;
				}
			}
			
			if ($iDeleted > 0)
			{
				$this->url()->send('admincp.music', null, Phpfox::getPhrase('music.successfully_deleted_genres'));
			}
		}
		
		$this->template()
			->setTitle(Phpfox::getPhrase('music.manage_genres'))
			->setBreadcrumb(Phpfox::getPhrase('music.manage_genres'), $this->url()->makeUrl('admincp.music'))
			->setHeader('cache', array(
					'quick_edit.js' => 'static_script'
				)
			)
			->assign(array(
					'aGenres' => Phpfox::getService('music.genre')->getList()
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>