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
 * @version 		$Id: song.class.php 3313 2011-10-18 09:44:00Z Raymond_Benc $
 */
class Music_Component_Controller_Browse_Song extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{		
		if (($sLegacyTitle = $this->request()->get('req4')) && !empty($sLegacyTitle))
		{			
			Phpfox::getService('core')->getLegacyItem(array(
					'field' => array('genre_id', 'name'),
					'table' => 'music_genre',		
					'redirect' => 'music.genre',
					'search' => 'name_url',
					'title' => $sLegacyTitle
				)
			);
		}			
		
		$this->url()->send('music', array(), null, 301);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_controller_browse_song_clean')) ? eval($sPlugin) : false);
	}
}

?>