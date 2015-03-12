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
 * @version 		$Id: artist.class.php 1245 2009-11-02 16:10:29Z Raymond_Benc $
 */
class Music_Component_Controller_Browse_Artist extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		define('PHPFOX_MUSIC_INDEX_OVERIDE', true);
		
		return Phpfox::getLib('module')->setController('music.index');
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('music.component_controller_browse_artist_clean')) ? eval($sPlugin) : false);
	}
}

?>