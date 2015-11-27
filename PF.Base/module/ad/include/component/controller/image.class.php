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
 * @version 		$Id: image.class.php 7000 2013-12-19 17:11:14Z Fern $
 */
class Ad_Component_Controller_Image extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (!Phpfox::isUser())
		{
			exit;
		}
		
		$aImage = Phpfox_File::instance()->load('image', array('jpg', 'gif', 'png'));
		if ($aImage === false)
		{
			return j('#js_image_error')->show();
		}			
		
		$aParts = explode('x', $this->request()->get('ad_size'));
		if ($sFileName = Phpfox_File::instance()->upload('image', Phpfox::getParam('ad.dir_image'), Phpfox::getUserId() . uniqid()))
		{
			Phpfox_Image::instance()->createThumbnail(Phpfox::getParam('ad.dir_image') . sprintf($sFileName, ''), Phpfox::getParam('ad.dir_image') . sprintf($sFileName, '_thumb'), (Phpfox::getParam('ad.multi_ad') ? 100 : ($aParts[0] / 3)), (Phpfox::getParam('ad.multi_ad') ? 72 : ($aParts[1] - 20)));
			
			Phpfox_File::instance()->unlink(Phpfox::getParam('ad.dir_image') . sprintf($sFileName, ''));
			rename(Phpfox::getParam('ad.dir_image') . sprintf($sFileName, '_thumb'), Phpfox::getParam('ad.dir_image') . sprintf($sFileName, ''));
			
			// http://www.phpfox.com/tracker/view/14922/ -> If CDN, the unlink function above deletes the image!!
			if (Phpfox::getParam('core.allow_cdn'))
			{
				Phpfox::getLib('cdn')->put(Phpfox::getParam('ad.dir_image') . sprintf($sFileName, ''));
			}
			
			return [
				'run' => '$(\'.js_ad_image\').html(\'<a href="#ad-link"><img src="' . Phpfox::getParam('ad.url_image') . sprintf($sFileName, '') . '" alt="" /></a>\').show(); window.parent.$(\'#js_image_holder_message\').hide(); window.parent.$(\'#js_image_holder_link\').show(); window.parent.$(\'#js_image_id\').val(\'' . sprintf($sFileName, '') . '\');'
			];
		}
		
		exit;
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('ad.component_controller_image_clean')) ? eval($sPlugin) : false);
	}
}

?>
