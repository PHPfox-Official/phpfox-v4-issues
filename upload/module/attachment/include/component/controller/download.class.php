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
 * @package  		Module_Attachment
 * @version 		$Id: download.class.php 2626 2011-05-24 13:24:52Z Raymond_Benc $
 */
class Attachment_Component_Controller_Download extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{	
		$iId = $this->request()->get('id');
		
		$aRow = Phpfox::getService('attachment')->getForDownload($iId);	

		if (!isset($aRow['destination']))
		{
			return Phpfox_Error::display(Phpfox::getPhrase('attachment.no_such_download_found'));
		}
		
		$sPath = Phpfox::getParam('core.dir_attachment') . sprintf($aRow['destination'], '');
		
		if (Phpfox::hasCallback($aRow['category_id'], 'attachmentControl'))
		{
			$bAllowed = Phpfox::callback($aRow['category_id'] . '.attachmentControl',$aRow['item_id']);
			if ($bAllowed == false)
			{
				return Phpfox_Error::display(Phpfox::getPhrase('attachment.you_are_not_allowed_to_download_this_attachment'));
			}
		}
		Phpfox::getService('attachment.process')->updateCounter($aRow['attachment_id']);
		
		Phpfox::getLib('file')->forceDownload($sPath, $aRow['file_name'], $aRow['mime_type'], $aRow['file_size'], $aRow['server_id']);
		
		exit;
	}
}

?>