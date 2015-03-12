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
 * @version 		$Id: album-tag.class.php 4240 2012-06-08 11:29:40Z Raymond_Benc $
 */
class Photo_Component_Block_Album_Tag extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aAlbum = $this->getParam('aAlbum');
		
		list($iCnt, $aUsers) = Phpfox::getService('photo.album')->inThisAlbum($aAlbum['album_id']);
		
		if (!$iCnt)
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('photo.in_this_album') . ' (' . $iCnt . ')',
				'aTaggedUsers' => $aUsers
			)
		);
		
		return 'block';	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_album_tag_clean')) ? eval($sPlugin) : false);
	}
}

?>