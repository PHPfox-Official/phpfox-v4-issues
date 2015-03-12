<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel_Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: add.class.php 1146 2009-10-06 18:36:51Z Raymond_Benc $
 */
class Emoticon_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if ($iId = $this->request()->get('delete'))
		{
			if (Phpfox::getService('emoticon.process')->deleteEmoticon($iId))
			{
				$this->url()->send('admincp.emoticon.add', null, Phpfox::getPhrase('emoticon.emoticon_successfully_deleted'));
			}
		}
		if ($aVals = $this->request()->getArray('val'))
		{
			$aVals = array_merge($aVals, $_FILES);

			if (Phpfox::getService('emoticon.process')->addEmoticon($aVals))
			{
				// send to the package
				if (isset($aVals['emoticon_id']))
				{
					$this->url()->send('admincp.emoticon.view', array('id' => $aVals['package_path']), Phpfox::getPhrase('emoticon.emoticon_successfully_updated'));
				}
				else
				{
					$this->url()->send('admincp.emoticon.package', null, Phpfox::getPhrase('emoticon.emoticon_successfully_added'));
				}
			}
		}
		
		if ($iId = $this->request()->getInt('id'))
		{ // editing an emoticon

			$this->template()->assign(array(
					'aForms' => Phpfox::getService('emoticon')->getEmoticon($iId)
				))
			->setTitle(Phpfox::getPhrase('emoticon.edit_emoticon'))
			->setBreadcrumb(Phpfox::getPhrase('emoticon.emoticons'), $this->url()->makeUrl('admincp.emoticon.package'))
			->setBreadcrumb(Phpfox::getPhrase('emoticon.edit_emoticon'), null, true);
		}
		else
		{ // is adding
			$this->template()->setTitle(Phpfox::getPhrase('emoticon.add_emoticon'))
			->setBreadcrumb(Phpfox::getPhrase('emoticon.emoticons'), $this->url()->makeUrl('admincp.emoticon.package'))
			->setBreadcrumb(Phpfox::getPhrase('emoticon.add_emoticon'), null, true);
		}

		$this->template()->assign(array('aPackages' => Phpfox::getService('emoticon')->getPackages()));
		
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('event.component_controller_admincp_add_clean')) ? eval($sPlugin) : false);
	}
}

?>