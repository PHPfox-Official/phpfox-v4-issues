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
 * @version 		$Id: add.class.php 1601 2010-05-30 05:20:59Z Raymond_Benc $
 */
class Blog_Component_Controller_Export extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */

	public function process()
	{
		phpfox::isUser(true);
		if (!Phpfox::isUser())
		{
			return Phpfox_Error::display('Need to be logged in!');

		}

		Phpfox::getUserParam('blog.can_export_blog',true);  //check if user able to access this page

		$exportTemplate = $this->request()->get('option');
		if($exportTemplate)
		{

			$content = Phpfox::getService('blog.export')->getContent($exportTemplate);
			// echo($content);exit;
			Phpfox::getService('blog.export')->exportXML($content,$exportTemplate);
			return;
		}

		$this->template()->setBreadcrumb(phpfox::getPhrase('blog.blogs'), $this->url()->makeUrl('blog'))
		->setBreadcrumb(phpfox::getPhrase('blog.export_blog_s'), $this->url()->makeUrl('blog.export'), true)
		->setHeader('cache', array(
				'jquery/plugin/jquery.highlightFade.js' => 'static_script',
				'switch_legend.js' => 'static_script',
				'switch_menu.js' => 'static_script',
				'quick_edit.js' => 'static_script',
				'pager.css' => 'style_css'
				));

	}
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('blog.component_controller_Export_clean')) ? eval($sPlugin) : false);
	}
}

?>
