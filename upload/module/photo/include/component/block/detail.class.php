<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display the image details when viewing an image.
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Photo
 * @version 		$Id: detail.class.php 5857 2013-05-10 08:05:37Z Raymond_Benc $
 */
class Photo_Component_Block_Detail extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!$this->getParam('bIsValidImage'))
		{
			return false;
		}

		$aUser = $this->getParam('aUser');
		$aPhoto = $this->getParam('aPhoto');
		$bIsInPhoto = $this->getParam('is_in_photo');

		if ($aPhoto === null)
		{
			return false;
		}
		
		$sCategories = '';
		if (isset($aPhoto['categories']) && is_array($aPhoto['categories']))
		{
			foreach ($aPhoto['categories'] as $aCategory)
			{
				$sCategories .= $aCategory[0] . ',';
			}
			$sCategories = rtrim($sCategories, ',');
		}
		
		$aInfo = array(
			Phpfox::getPhrase('photo.added') => '<span itemprop="dateCreated">' . Phpfox::getTime(Phpfox::getParam('photo.photo_image_details_time_stamp'), $aPhoto['time_stamp']) . '</span>',
			Phpfox::getPhrase('photo.category') => $sCategories,
			Phpfox::getPhrase('photo.file_size') => Phpfox::getLib('file')->filesize($aPhoto['file_size']),
			Phpfox::getPhrase('photo.resolution') => $aPhoto['width'] . '×' . $aPhoto['height'],
			Phpfox::getPhrase('photo.comments') => $aPhoto['total_comment'],
			Phpfox::getPhrase('photo.views') => '<span itemprop="interactionCount">' . $aPhoto['total_view'] . '</span>',
			Phpfox::getPhrase('photo.rating') => round($aPhoto['total_rating']),
			Phpfox::getPhrase('photo.battle_wins') => round($aPhoto['total_battle']),
			Phpfox::getPhrase('photo.downloads') => $aPhoto['total_download']
		);
		
		if ($bIsInPhoto)
		{
			unset($aInfo[Phpfox::getPhrase('photo.added')]);
		}
		
		foreach ($aInfo as $sKey => $mValue)
		{
			if (empty($mValue))
			{
				unset($aInfo[$sKey]);
			}
		}

		$this->template()->assign(array(
				'sHeader' => Phpfox::getPhrase('photo.image_details'),
				'aPhotoDetails' => $aInfo,
				'bIsInPhoto' => $bIsInPhoto,
				'sUrlPath' => (preg_match("/\{file\/pic\/(.*)\/(.*)\.jpg\}/i", $aPhoto['destination'], $aMatches) ? Phpfox::getParam('core.path') . str_replace(array('{', '}'), '', $aMatches[0]) : (($aPhoto['server_id'] && Phpfox::getParam('core.allow_cdn')) ? Phpfox::getLib('cdn')->getUrl(Phpfox::getParam('photo.url_photo') . sprintf($aPhoto['destination'], '_500'), $aPhoto['server_id']) : Phpfox::getParam('photo.url_photo') . sprintf($aPhoto['destination'], '_500')))
			)
		);

		// return 'block';
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_detail_clean')) ? eval($sPlugin) : false);

		$this->template()->clean(array(
				'aPhotoDetails',
				'sEmbedCode',
				'sHeader'
			)
		);
	}
}

?>