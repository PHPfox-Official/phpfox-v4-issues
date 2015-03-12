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
 * @package  		Module_Mail
 * @version 		$Id: folder.class.php 4087 2012-04-05 12:45:43Z Raymond_Benc $
 */
class Mail_Component_Block_Folder extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			return false;
		}
		
		if ($this->getParam('bIsInLegacyView'))
		{
			return false;
		}
		
		/*
		$aFolders = array();
		if (Phpfox::getUserParam('mail.can_add_folders'))
		{
			$aFolders = Phpfox::getService('mail.folder')->get();
			if (count($aFolders))
			{
				$this->template()->assign(array(
						'aFooter' => array(
							Phpfox::getPhrase('mail.edit_folders') => '#'
						)
					)
				);
			}
		}

		(($sPlugin = Phpfox_Plugin::get('mail.component_block_folder_process')) ? eval($sPlugin) : false);

		$this->template()->assign(array(
				'aFolders' => $aFolders
			)
		);

		// check if we should show the folder contents count (how many in inbox, sent and deleted)
		if (Phpfox::getParam('mail.show_core_mail_folders_item_count') && Phpfox::getUserParam('mail.show_core_mail_folders_item_count'))
		{

			$aCountFolders = Phpfox::getService('mail')->getDefaultFoldersCount(Phpfox::getUserId());
			$this->template()->assign(array(
				'iCountInbox'   => $aCountFolders['iCountInbox'],
				'iCountSentbox' => $aCountFolders['iCountSentbox'],
				'iCountDeleted' => $aCountFolders['iCountDeleted']
				)
			);
		}

		if (!$this->getParam('bIsAjax'))
		{
			$this->template()->assign(array(
					'sHeader' => Phpfox::getPhrase('mail.folders')
				)
			);

			return 'block';
		}	
		*/
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('mail.component_block_folder_clean')) ? eval($sPlugin) : false);
	}
}

?>