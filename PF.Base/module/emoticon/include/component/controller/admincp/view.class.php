<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 * Shows the views of a package, listing all its emoticons and allowing sorting and links for editing
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package  		Module_Emoticon
 * @version 		$Id: view.class.php 6113 2013-06-21 13:58:40Z Raymond_Benc $
 */
class Emoticon_Component_Controller_Admincp_View extends Phpfox_Component
{
	public function process()
	{
		if (!($iId = $this->request()->get('id')))
		{
			$this->url()->send('admincp.emoticon.package', null, Phpfox::getPhrase('emoticon.package_does_not_exist'));
		}
		
		if (($aVals = $this->request()->getArray('update')))
		{
			if (Phpfox::getService('emoticon.process')->updateEmoticons($aVals))
			{
				$this->url()->send('admincp.emoticon.view', array('id' => $iId), Phpfox::getPhrase('emoticon.emoticons_successfully_updated'));	
			}
		}

		$aPackage = Phpfox::getService('emoticon')->getEmoticons($iId);
		$sPackage = isset($aPackage[0]['package_name']) ? $aPackage[0]['package_name'] : '';		
		$this->template()->setTitle(Phpfox::getPhrase('emoticon.view_emoticon_package') . ': ' . $sPackage)
			->setBreadcrumb(Phpfox::getPhrase('emoticon.emoticons'), $this->url()->makeUrl('admincp.emoticon.package'))
			->setBreadCrumb(Phpfox::getPhrase('emoticon.view_package') . ': ' . $sPackage, null, true)
			->assign(array(
				'aPackage' => $aPackage,
				'sUrlEmoticon' => Phpfox::getParam('core.url_emoticon'),
				'sPackageId' => $iId
			))
			->setHeader(array(
				'drag.js' => 'static_script',
				'<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'emoticon.setEmoticonOrder\'}); }</script>'
			));
	}
}
?>
