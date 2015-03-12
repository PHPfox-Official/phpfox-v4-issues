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
 * @version 		$Id: frame.class.php 6590 2013-09-05 12:29:59Z Miguel_Espinoza $
 */
class Attachment_Component_Controller_Frame extends Phpfox_Component 
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		if (!isset($_FILES['file']) && isset($_FILES['Filedata']))
		{
			$_FILES['file'] = array();
			$_FILES['file']['error']['file'] = UPLOAD_ERR_OK;
			$_FILES['file']['name']['file'] = $_FILES['Filedata']['name'];
			$_FILES['file']['type']['file'] = $_FILES['Filedata']['type'];
			$_FILES['file']['tmp_name']['file'] = $_FILES['Filedata']['tmp_name'];
			$_FILES['file']['size']['file'] = $_FILES['Filedata']['size'];
		}
		elseif (!isset($_FILES['file']))
		{
			exit;
		}

		$oFile = Phpfox::getLib('file');
		$oImage = Phpfox::getLib('image');
		
		$oAttachment = Phpfox::getService('attachment.process');		
		
		$sIds = '';		
		$sStr = '';
		$iUploaded = 0;
		$iFileSizes = 0;
		foreach ($_FILES['file']['error'] as $iKey => $sError)
		{
			if ($sError == UPLOAD_ERR_OK) 
			{				
				$aValid = array('gif', 'png', 'jpg');
				if ($this->request()->get('custom_attachment') == 'photo')
				{
					$aValid = array('gif', 'png', 'jpg');	
				}
				elseif ($this->request()->get('custom_attachment') == 'video')
				{
					$aValid = Phpfox::getService('video')->getFileExt();	
				}
				
				if ($this->request()->get('input') == '' && $this->request()->get('custom_attachment') == '')
				{
					$aValid = Phpfox::getService('attachment.type')->getTypes();
				}
				
				$iMaxSize = null;
				
				if (Phpfox::getUserParam('attachment.item_max_upload_size') !== 0)
				{
					$iMaxSize = (Phpfox::getUserParam('attachment.item_max_upload_size') / 1024);
				}
				
				$aImage = $oFile->load('file[' . $iKey . ']', $aValid, $iMaxSize);
				
				if ($aImage !== false)
				{
					if (!Phpfox::getService('attachment')->isAllowed())
					{
						echo '<script type="text/javascript">window.parent.$(\'#' . $this->request()->get('upload_id') . '\').parents(\'.js_upload_attachment_parent_holder\').html(\'<div class="error_message">' . Phpfox::getPhrase('attachment.failed_limit_reached') . '</div>\');</script>';
						
						continue;
					}
					
					$iUploaded++;
					$bIsImage = in_array($aImage['ext'], Phpfox::getParam('attachment.attachment_valid_images'));
					
					$iId = $oAttachment->add(array(
							'category' => $this->request()->get('category_name'),
							'file_name' => $_FILES['file']['name'][$iKey],						
							'extension' => $aImage['ext'],
							'is_image' => $bIsImage
						)
					);
					
					$sIds .= $iId . ',';
					
					$sFileName = $oFile->upload('file[' . $iKey . ']', Phpfox::getParam('core.dir_attachment'), $iId);

					$sFileSize = filesize(Phpfox::getParam('core.dir_attachment') . sprintf($sFileName, ''));
					$iFileSizes += $sFileSize;				
					
					$oAttachment->update(array(
						'file_size' => $sFileSize,
						'destination' => $sFileName,
						'server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')
					), $iId);
					
					if ($bIsImage)
					{
						$sThumbnail = Phpfox::getParam('core.dir_attachment') . sprintf($sFileName, '_thumb');
						$sViewImage = Phpfox::getParam('core.dir_attachment') . sprintf($sFileName, '_view');
						
						$oImage->createThumbnail(Phpfox::getParam('core.dir_attachment') . sprintf($sFileName, ''), $sThumbnail, Phpfox::getParam('attachment.attachment_max_thumbnail'), Phpfox::getParam('attachment.attachment_max_thumbnail'));
						$oImage->createThumbnail(Phpfox::getParam('core.dir_attachment') . sprintf($sFileName, ''), $sViewImage, Phpfox::getParam('attachment.attachment_max_medium'), Phpfox::getParam('attachment.attachment_max_medium'));
						
						$iFileSizes += (filesize($sThumbnail) + filesize($sThumbnail));
					}
	
					if ($this->request()->get('custom_attachment') == 'video')
					{
						Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'attachment', $iFileSizes);
						
						echo '<script type="text/javascript">window.parent.$(\'#' . $this->request()->get('upload_id') . '\').find(\'.js_upload_form_image_holder:first\').html(\'<div class="js_upload_form_image_holder_image">' . Phpfox::getLib('image.helper')->display(array('theme' => 'ajax/add.gif')) . '</div>' . Phpfox::getPhrase('attachment.converting') . ' ' . strip_tags($_FILES['file']['name'][$iKey]) . '...\'); window.parent.$.ajaxCall(\'video.convert\', \'attachment_id=' . $iId . '&attachment_inline=' . ($this->request()->get('attachment_inline') ? '1' : '0') . '&attachment_obj_id=' . $this->request()->get('attachment_obj_id') . '\');</script>';
						exit;		
					}
					else 
					{
						echo '<script type="text/javascript">window.parent.$(\'#' . $this->request()->get('upload_id') . '\').find(\'.js_upload_form_image_holder:first\').html(\'<div class="js_upload_form_image_holder_image">' . Phpfox::getLib('image.helper')->display(array('theme' => 'misc/accept.png')) . '</div>Completed ' . strip_tags($_FILES['file']['name'][$iKey]) . '\');</script>';
					}
				}
				else 
				{
					echo '<script type="text/javascript">window.parent.$(\'#' . $this->request()->get('upload_id') . '\').find(\'.js_upload_form_image_holder:first\').html(\'<div class="js_upload_form_image_holder_image">' . Phpfox::getLib('image.helper')->display(array('theme' => 'misc/delete.png')) . '</div>Failed ' . strip_tags($_FILES['file']['name'][$iKey]) . ' <br /> <div class="error_message">' . implode(' ', Phpfox_Error::get()) . '</div>\');</script>';
				}
			}
		}
		
		if (!$iUploaded)
		{
			exit;
		}	
		
		if ($this->request()->get('custom_attachment') == 'photo' || $this->request()->get('custom_attachment') == 'video')
		{
			$aAttachment = Phpfox::getLib('database')->select('*')
				->from(Phpfox::getT('attachment'))
				->where('attachment_id = ' . (int) $iId)
				->execute('getSlaveRow');
			
			if ($this->request()->get('custom_attachment') == 'photo')
			{				
				$sImagePath = Phpfox::getLib('image.helper')->display(array('server_id' => $aAttachment['server_id'], 'path' => 'core.url_attachment', 'file' => $aAttachment['destination'], 'suffix' => '_view', 'max_width' => 'attachment.attachment_max_medium', 'max_height' =>'attachment.attachment_max_medium', 'return_url' => true));
				
				echo '
				<script type="text/javascript">
					window.parent.Editor.insert({is_image: true, name: \'\', id: \'' . $iId . ':view\', type: \'image\', path: \'' . $sImagePath . '\'});
				</script>
				';				
			}
			else
			{
				echo '
				<script type="text/javascript">
					window.parent.Editor.insert({is_image: true, name: \'\', id: \'' . $iId . '\', type: \'video\'});
				</script>
				';				
			}			

		}
		else
		{
			ob_start();
			
			Phpfox::getBlock('attachment.list', array('sIds' => $sIds, 'bCanUseInline' => true, 'attachment_no_header' => true, 'attachment_edit' => true, 'sAttachmentInput' => $this->request()->get('input')));
			
			$sContent = ob_get_contents();
			
			ob_clean();
			
			$sAttachmentObject = $this->request()->get('attachment_obj_id');
			
			if (!empty($sAttachmentObject))
			{
				echo '
				<script type="text/javascript">
					var $oParent = window.parent.$(\'#' . $this->request()->get('attachment_obj_id') . '\');
					$oParent.find(\'.js_attachment:first\').val($oParent.find(\'.js_attachment:first\').val() + \'' . $sIds . '\');
					$oParent.find(\'.js_attachment_list:first\').show();
					$oParent.find(\'.js_attachment_list_holder:first\').prepend(\'' . str_replace("'", "\'", str_replace(array("\n", "\t", "\r"), '', $sContent)) . '\');
					window.parent.$Core.loadInit();
				</script>
				';			
			}
			
			if ($this->request()->get('category_name') == 'theme')
			{
				echo '
				<script type="text/javascript">
					var $oParent = window.parent.$(\'#' . $this->request()->get('input') . '\');
					$oParent.val(\'' . Phpfox::getParam('core.url_attachment') . sprintf($sFileName, '') . '\');
					// window.parent.on_change_image($oParent);
					$oParent.focus();
					$oParent.blur();
					window.parent.tb_remove();
				</script>
				';						
			}
		}
	
		// Update user space usage
		Phpfox::getService('user.space')->update(Phpfox::getUserId(), 'attachment', $iFileSizes);		
		
		if ($this->request()->get('attachment_inline'))
		{
			echo '<script type="text/javascript">window.parent.$Core.updateInlineBox();</script>';
		}

		exit;
	}

	private function _echo($sTxt)
	{
		if (!isset($_FILES['Filedata']))
		{
			echo '<script type="text/javascript">' . $sTxt . '</script>';
		}
		else
		{
			echo $sTxt;
		}
	}
}

?>