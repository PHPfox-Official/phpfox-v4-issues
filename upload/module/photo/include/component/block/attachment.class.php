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
 * @version 		$Id: attachment.class.php 2627 2011-05-24 19:04:14Z Raymond_Benc $
 */
class Photo_Component_Block_Attachment extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		Phpfox::isUser(true);
		
		$iPage = $this->request()->getInt('page');
		$iPageSize = 6;
		
		$aConditions = array();
		$aConditions[] = 'AND p.user_id = ' . Phpfox::getUserId();
		
		list($iCnt, $aPhotos) = Phpfox::getService('photo')->get($aConditions, 'p.time_stamp DESC', $iPage, $iPageSize);
		
		// Set the pager for the photos
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'ajax' => 'photo.getForAttachment'));		
		
		$this->template()->assign(array(
				'aPhotos' => $aPhotos,
				'iCurrentPage' => $iPage,
				'sAttachmentObjId' => $this->request()->get('obj-id'),
				'sAttachmentInput' => $this->request()->get('input'),
				'sCategoryId' => $this->request()->get('category'),
				'sIsAttachmentInline' => $this->request()->get('attachment-inline')
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('photo.component_block_attachment_clean')) ? eval($sPlugin) : false);
	}
}

?>