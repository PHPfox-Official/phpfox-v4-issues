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
 * @package 		Phpfox_Service
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Tinymce_Service_Tinymce extends Phpfox_Service 
{
	private $_sId = '#text';
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		
	}
	
	public function load()
	{
		static $bLoadTinymce = null;
		
		if ($bLoadTinymce !== null)
		{
			return $bLoadTinymce;
		}		
		
		$bLoadTinymce = false;
		$aLoadTinyMce = Phpfox::getParam('tinymce.tinymce_load_on_pages');
		if (is_array($aLoadTinyMce))
		{	
			$sControllFullName = Phpfox::getLib('module')->getFullControllerName();
			if (Phpfox::getLib('url')->getUrl() == 'admincp/newsletter/add')
			{
				$bLoadTinymce = true;
				$this->_sId = '#text';
			}
			elseif (Phpfox::getLib('url')->getUrl() == 'admincp/page/add')
			{
				$bLoadTinymce = true;
				$this->_sId = '#text';
			}			
			else
			{
				foreach ($aLoadTinyMce as $sPage)
				{
					$aParts = explode('|', $sPage);
					if ($sControllFullName == trim($aParts[0]))
					{
						$bLoadTinymce = true;
						$this->_sId = str_replace('#', '', $aParts[1]);
						break;
					}
				}	
			}
		}		
		
		if (Phpfox::getParam('core.site_wide_ajax_browsing'))
		{
			return true;
		}		

		return $bLoadTinymce;
	}
	
	public function getId()
	{
		return $this->_sId;	
	}
	
	public function getJsCode()
	{
			$sButton2 = Phpfox::getParam('tinymce.tinymce_button_2');
			$sPlugins = Phpfox::getParam('tinymce.tinymce_plugins');	
			
			$sId = Phpfox::getService('tinymce')->getId();
/*
			case 'marketplace.add':
			case 'group.add':
			case 'event.add':
				$sId = 'description';
				break;
			case 'mail.compose':
			case 'mail.view':
				$sId = 'message';
				break;
			default:
				
				break;
*/

/*
				<script type="text/javascript" src="' . Phpfox::getParam('core.path') . 'static/jscript/wysiwyg/tiny_mce/tiny_mce.js?v=' . Phpfox::getLib('template')->getStaticVersion() . '"></script>
				<script type="text/javascript" src="' . Phpfox::getParam('core.path') . 'static/jscript/wysiwyg/tiny_mce/core.js?v=' . Phpfox::getLib('template')->getStaticVersion() . '"></script>		
*/
		
			$sScript = '		
				<script type="text/javascript">
				var sButton1 = null;
				var sButton2 = null;				
				function customTinyMCE_init(sName, sEditorType)
				{			
					if (!sName)
				    {
				        return false;
				    }	    
									    
				    p(\'Loading TinyMCE for: \' + sName);
				    
					sButton1 = "' . Phpfox::getParam('tinymce.tinymce_button_1') . '";
				    sButton2 = "' . $sButton2 . '";
						
					if (!isModule(\'emoticon\'))
					{			
						sButton2 = sButton2.replace("phpfoxemoticon,", "");					
					}										

				    	
				    if (sName.match(/js_feed_comment_form_textarea_/g) || sEditorType == \'comment\'){
						sButton1 = sButton1.replace("fontsizeselect,", "");
				    	sButton1 = sButton1.replace("fontselect,", "");
				    }		
				    		
					tinyMCE.init({
						mode : \'exact\',
						elements : sName,
						theme : "advanced",
						skin: "cirkuit",
						theme_advanced_buttons1 : sButton1,
						theme_advanced_buttons2 : sButton2,
						theme_advanced_buttons3 : "' . Phpfox::getParam('tinymce.tinymce_button_3') . '",
					    theme_advanced_toolbar_location : "' . Phpfox::getParam('tinymce.tinymce_toolbar_location') . '",
					    theme_advanced_toolbar_align : "' . Phpfox::getParam('tinymce.tinymce_toolbar_alignment') . '",
					    cleanup : false,
					    plugins : "' . $sPlugins . '",
					    theme_advanced_resizing : false,
					    theme_advanced_resize_horizontal : false,
					    theme_advanced_more_colors : false,
						convert_urls : false,
						relative_urls : true					    
					});	
					
					$Behavior.loadTinymceEditor = function() {}
				}
				
				var LoadedTinymceEditors = {};
				// $Behavior.loadTinymceEditor_' . md5($sId . uniqid()) . ' = function()
				$Behavior.loadTinymceEditor = function()
				{	
					/*
					';
					if (substr($sId, 0, 1) == '.')
					{
						$sScript .= '
							var iCustomCnt = 0;
							$(\'' . $sId . '\').each(function(){
								iCustomCnt++;
								$(this).attr(\'id\', \'js_custom_textarea_\' + iCustomCnt + \'\');
								customTinyMCE_init(\'js_custom_textarea_\' + iCustomCnt + \'\');
							});
						';
					}
					else
					{
						$sScript .= '
						if ($(\'#' . str_replace('#','', $sId) . '\').length > 0)
						{
							customTinyMCE_init(\'' . str_replace('#','', $sId) . '\');					
						}
						';
					}
					$sScript .= '
					*/
						if ($(\'#' . str_replace('#','', $sId) . '\').length > 0)
						{
							customTinyMCE_init(\'' . str_replace('#','', $sId) . '\');					
						}					
				}			
				</script>';

		return $sScript;		
	}
	
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing 
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('tinymce.service_tinymce__call'))
		{
			eval($sPlugin);
			return;
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
}

?>