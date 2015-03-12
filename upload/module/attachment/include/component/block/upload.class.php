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
 * @version 		$Id: upload.class.php 6949 2013-11-29 11:08:23Z Miguel_Espinoza $
 */
class Attachment_Component_Block_Upload extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iMaxFileSize = (Phpfox::getUserParam('attachment.item_max_upload_size') === 0 ? null : ((Phpfox::getUserParam('attachment.item_max_upload_size') / 1024) * 1048576));
		$iMaxFileSize = Phpfox::getLib('file')->filesize($iMaxFileSize);
		$this->template()->assign(array(
				'bIsAllowed' => Phpfox::getService('attachment')->isAllowed(),
				'iTotal' => Phpfox::getParam('attachment.attachment_upload_bars'),
				'sCategoryId' => (PHPFOX_IS_AJAX ? $this->request()->get('category_id') : $this->getParam('sCategoryId')),
				'aValidExtensions' => Phpfox::getService('attachment.type')->getTypes(),
				'iMaxFileSize' => $iMaxFileSize,
				'sAttachmentInput' => $this->request()->get('input'),
				'sVideoFileExt' => (Phpfox::isModule('video') ? Phpfox::getService('video')->getFileExt(true) : ''),
				'bIsAttachmentInline' => (bool) $this->request()->get('attachment_inline'),
				'sAttachmentObjId' => $this->request()->get('attachment_obj_id')
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('attachment.component_block_upload_clean')) ? eval($sPlugin) : false);
	}
}

?>