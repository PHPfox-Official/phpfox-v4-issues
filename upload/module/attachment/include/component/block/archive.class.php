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
 * @version 		$Id: archive.class.php 877 2009-08-20 11:21:32Z Raymond_Benc $
 */
class Attachment_Component_Block_Archive extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$iPage = $this->getParam('sPage');
		$iPageSize = 10;		
		
		list($iCnt, $aItems) = Phpfox::getService('attachment')->get(array("attachment.user_id = " . Phpfox::getUserId() . ""), 'attachment.time_stamp DESC',	$iPage, $iPageSize);
	
		Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt, 'ajax' => 'attachment.browse'));
		
		$aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);		
		
		$this->template()->assign(array(
				'aItems' => $aItems,
				'sUrlPath' => Phpfox::getParam('core.url_attachment'),
				'sThumbPath' => Phpfox::getParam('core.url_thumb'),
				'sUsage' => $aUser['space_total'],
				'bCanUseInline' => false,
				'sAttachmentInput' => $this->request()->get('input')
			)
		);
	}
}

?>