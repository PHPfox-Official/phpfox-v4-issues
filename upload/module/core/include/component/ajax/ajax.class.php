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
 * @package  		Module_Core
 * @version 		$Id: ajax.class.php 6742 2013-10-07 15:07:33Z Raymond_Benc $
 */
class Core_Component_Ajax_Ajax extends Phpfox_Ajax
{	
	public function buildStats()
	{
		Phpfox::getBlock('core.admin-stat');
		
		$this->remove('#js_core_site_stat_build');
		$this->append('#js_core_site_stat', $this->getContent(false));
	}
	
	public function message()
	{
		Phpfox::getBlock('core.message', array(
				'sMessage' => ''// strip_tags($this->get('message'))
			)
		);
		$this->call('<script type="text/javascript">$(\'#js_custom_core_message\').html(sCustomMessageString);</script>');
	}

	public function preview()
	{
		Phpfox::getBlock('core.preview', array('sText' => $this->get('text')));
	}

	public function info()
	{
		Phpfox::getBlock('core.info');

		$this->html('#' . $this->get('temp_id') . '', $this->getContent(false));
		$this->call('$(\'#' . $this->get('temp_id') . '\').parent().show();');
	}

	public function dashboard()
	{
		Phpfox::getBlock('core.dashboard');

		$this->html('#js_core_dashboard', $this->getContent(false));
	}

	public function activity()
	{
		Phpfox::getBlock('core.activity');

		$this->html('#' . $this->get('temp_id') . '', $this->getContent(false));
		$this->call('$(\'#' . $this->get('temp_id') . '\').parent().show();');
	}

	/**
	 * Core progress bar using apc_fetch.
	 */
	public function progress()
	{
		return false;

		// Make sure APC is setup
		if (!function_exists('apc_fetch'))
		{
			return false;
		}

		// Fetch the progress status of the file uploaded
		$aStatus = apc_fetch('upload_' . $this->get('progress_key'));

		// Makre sure we actually got something in return from APC
		if ($aStatus === false)
		{
			return false;
		}

		// Create the percent value
		$iPercent = ($aStatus['current'] / $aStatus['total'] * 100);
		// Clean and shorten the photo name.
		$aStatus['filename'] = substr(htmlspecialchars(addslashes($aStatus['filename'])), 0, 10) . (strlen($aStatus['filename']) > 10 ? '...' : '');

		$this->call('percent = "' . $iPercent . '"; document.getElementById("js_progress_inner").style.width = percent+"%"; $(\'#js_progress_percent_value\').html(\'' . $aStatus['filename'] . ': ' . round($iPercent) . '\'); if (percent < 100){setTimeout("getProgress(\'' . $this->get('progress_key') . '\')", 100);}else{completeProgress();}');
	}

	public function updateDesign()
	{
		$aVals = $this->get('val');

		Phpfox::getService('user.process')->updateDesign($aVals);

		if (isset($aVals['iframe']))
		{
			$this->call('$(\'#js_theme_select_iframe\').attr(\'src\', \'' . $aVals['iframe'] . '\');');
		}
	}

	public function updateComponentSetting()
	{
		$aVals = $this->get('val');

		if (Phpfox::getService('core.process')->updateComponentSetting($aVals))
		{
			Phpfox::getBlock($aVals['load_block']);
			
			if (isset($aVals['load_entire_block']))
			{
				$this->call('$(\'#' . $aVals['block_id'] . '\').before(\'' . $this->getContent() . '\').remove();');
			}
			else
			{
				$this->call('$(\'#' . $aVals['block_id'] . '\').find(\'.content\').html(\'' . $this->getContent() . '\');');
			}

			if (isset($aVals['load_init']))
			{
				$this->call('$Core.loadInit();');
			}
		}
	}

	public function hideBlock()
	{
		if ($this->get('sController') == 'pages.view')
		{
			Phpfox::getService('theme.process')->updateBlock(array(
					'cache_id' => $this->get('type_id'),
					'item_id' => $this->get('custom_item_id'),
					'type_id' => 'pages',
					'is_installed' => '1'
				)
			);
		}
		else
		{
			Phpfox::getService('core.process')->hideBlock($this->get('block_id'), $this->get('type_id'), $this->get('sController'));
		}
		
		$this->softNotice('Block was hidden');
	}

	public function getEditBarNew()
	{
		Phpfox::getBlock('core.new-setting');
		$this->html('#js_edit_block_' . $this->get('block_id'), $this->getContent(false))->slideDown('#js_edit_block_' . $this->get('block_id'));
	}

	public function getChildren()
	{
		Phpfox::getBlock('core.country-child', array('country_child_value' => $this->get('country_iso'), 'country_child_id' => $this->get('country_child_id')));

		$this->remove('#js_cache_country_iso')->html('#js_country_child_id', $this->getContent(false));
	}

	public function statOrdering()
	{
		if (Phpfox::getService('core.stat.process')->updateOrder($this->get('val')))
		{

		}
	}

	/**
	 * Clone of statOrdering to change the order of the items shown when cancelling an account
	 */
	public function cancellationsOrdering()
	{
		if (Phpfox::getService('user.cancellations.process')->updateOrder($this->get('val')))
		{

		}
	}
	/**
	 * Clone of updateStatActivity, activates/deactivates a cancellation
	 */
	public function updateCancellationsActivity()
	{
		if (Phpfox::getService('user.cancellations.process')->updateActivity($this->get('id'), $this->get('active')))
		{

		}
	}

	public function updateStatActivity()
	{
		if (Phpfox::getService('core.stat.process')->updateActivity($this->get('id'), $this->get('active')))
		{

		}
	}
	
	public function ftpPathSearch()
	{
		if (($aVals = $this->get('val')))
		{
			define('PHPFOX_FTP_LOGIN_PASS', true);
			
			$this->error(false);
			
			if (Phpfox::getLib('ftp')->connect($aVals['host'], $aVals['user_name'], $aVals['password']))
			{				
				$sPath = Phpfox::getLib('ftp')->getPath();
			
               if ($sPath === false)
               {
                    $this->html('#js_ftp_check_process', '')->html('#js_ftp_error', implode('', Phpfox_Error::get()))->show('#js_ftp_error');
               	
               		return;
               }               

               if (Phpfox::getLib('ftp')->test($sPath))
               {
               		$this->hide('#js_ftp_form')->show('#js_ftp_path')->val('#js_ftp_actual_path', str_replace('\\', '/', $sPath))->html('#js_ftp_check_process', '');
                    if (empty($sPath))
                    {
                        $this->show('#js_empty_ftp_path');
                    }
               }				
			}
			
			$this->html('#js_ftp_check_process', '')->html('#js_ftp_error', implode('', Phpfox_Error::get()))->show('#js_ftp_error');
			
			return;
		}	
		
		Phpfox::getBlock('core.ftp');
	}
	
	public function countryOrdering()
	{
		$aVals = $this->get('val');
		Phpfox::getService('core.process')->updateOrdering(array(
				'table' => 'country',
				'key' => 'country_iso',
				'values' => $aVals['ordering']
			)
		);
		Phpfox::getLib('cache')->remove('currency');
		Phpfox::getLib('cache')->remove('country', 'substr');
	}
	
	public function currencyOrdering()
	{
		$aVals = $this->get('val');
		Phpfox::getService('core.process')->updateOrdering(array(
				'table' => 'currency',
				'key' => 'currency_id',
				'values' => $aVals['ordering']
			)
		);
	}	
	
	public function updateCurrencyDefault()
	{
		if (Phpfox::getService('core.currency.process')->updateDefault($this->get('id'), $this->get('active')))
		{

		}		
	}
	
	public function updateCurrencyActivity()
	{
		if (Phpfox::getService('core.currency.process')->updateActivity($this->get('id'), $this->get('active')))
		{

		}		
	}	
	
	public function countryChildOrdering()
	{
		$aVals = $this->get('val');
		Phpfox::getService('core.process')->updateOrdering(array(
				'table' => 'country_child',
				'key' => 'child_id',
				'values' => $aVals['ordering']
			)
		);		
	}
	
	public function prompt()
	{
		$sPhrase = '';
		switch ($this->get('type'))
		{
			case 'url':
				$sPhrase = Phpfox::getPhrase('core.enter_the_url_of_your_link');
				$sCommand = 'Editor.createBBtag(\'[link=\\\'\' + $(\'#js_global_prompt_value\').val() + \'\\\']\', \'[/link]\', \'' . $this->get('editor') . '\', $(\'#js_global_prompt_value\').val());';
				$sError = Phpfox::getPhrase('core.fill_in_a_proper_url');
				$sTitle = Phpfox::getPhrase('core.url');
				break;
			case 'img':
				$sPhrase = Phpfox::getPhrase('core.enter_the_url_of_your_image');
				$sCommand = 'Editor.createBBtag(\'[img]\' + $(\'#js_global_prompt_value\').val() + \'\', \'[/img]\', \'' . $this->get('editor') . '\');';
				$sError = Phpfox::getPhrase('core.provide_a_proper_image_path');
				$sTitle = Phpfox::getPhrase('core.image');
				break;
		}		
		
		echo '<div class="main_break"></div>';
		echo '<div id="js_prompt_error_message" class="error_message" style="display:none;">' . $sError . '</div>';
		echo $sPhrase;
		echo '<div class="p_4"><input type="text" name="url" value="http://" style="width:80%;" id="js_global_prompt_value" /><div class="p_top_4"><input type="submit" value="' . Phpfox::getPhrase('core.submit') . '" class="button" onclick="if (empty($(\'#js_global_prompt_value\').val()) || $(\'#js_global_prompt_value\').val() == \'http://\') { $(\'#js_prompt_error_message\').show(); } else { ' . $sCommand . ' tb_remove(); }" /></div></div>';
		echo '<script type="text/javascript">$(\'#TB_ajaxWindowTitle\').html(\'' . str_replace("'", "\'", $sTitle) . '\');</script>';
	}
	
	public function javascriptAlert()
	{		
		echo '<div class="main_break"></div>';
		echo Phpfox::getLib('parse.output')->clean($this->get('phrase'));
		echo '<script type="text/javascript">$(\'#TB_ajaxWindowTitle\').html(\'' . Phpfox::getPhrase('core.message') . '\');</script>';
	}
	
	public function javascriptConfirm()
	{
		echo 'true';
	}

	public function trackUpload()
	{
		$sFiles = $this->get('sFiles');
		$aFiles = explode(',', $sFiles);
		$aValues = array();
		foreach ($aFiles as $iKey => $sFile)
		{
			if (empty($sFile) || ($sFile == '.') || ($sFile == '..') || strlen($sFile) < 4)
			{
				continue;
			}
			$aValues[] = array(Phpfox::getUserId(), Phpfox::getCookie('user_hash'), md5($sFile));
		}
		if (!empty($aValues))
		{
			Phpfox::getLib('database')->multiInsert(Phpfox::getT('upload_track'),
				array('user_id','user_hash','file_hash'),
				$aValues
				);
			echo 'swfu.startUpload()';
		}
		else
		{
			echo 'alert("No valid files were submitted");';
		}
	}
	
	/* Enables or disables the Design DnD module */
	public function designdnd()
	{	
		if ($this->get('enable') == 1 && Phpfox::getUserParam('core.can_design_dnd'))
		{
			Phpfox::setCookie('doDnD', '1', PHPFOX_TIME + 3600);	
			if ($this->get('inline'))
			{
				$this->call('windowjavascript:location.reload(true);');				
			}
			else
			{   				
				$this->call('window.location.href = \'' . Phpfox::getLib('url')->makeUrl('') . '\';');
			}			
		}
		else
		{
			Phpfox::setCookie('doDnD', -1, PHPFOX_TIME);
			$this->call('windowjavascript:location.reload(true);');
		}		
	}
	
	/**
	 * This function removes a block when in DnD mode
	 */
	public function removeBlockDnD()
	{
		if (!Phpfox::getService('theme')->isInDnDMode())
		{
			return $this->alert(Phpfox::getPhrase('friend.you_must_enable_dnd_mode'));
		}
		if (Phpfox::getService('theme.process')->removeBlockDnD($this->get('sController'), $this->get('block_id')))
		{
			$this->softNotice(Phpfox::getPhrase('friend.block_was_deleted'));
		}
		else
		{
			$this->alert(Phpfox::getPhrase('friend.cant_delete_it'));
		}
	}
	
	public function showGiftPoints()
	{
		Phpfox::getBlock('core.giftpoints', array('user_id' => $this->get('user_id')));
	}
	
	public function doGiftPoints()
	{
		if (Phpfox::getService('user.activity')->doGiftPoints($this->get('user_id'), $this->get('amount')))
		{			
			$this->html('#div_show_gift_points', Phpfox::getPhrase('core.gift_sent_successfully'));
		}
		else
		{
			$sError = Phpfox_Error::get();
			$this->html('#div_show_gift_points', 'An error occurred: ' . array_pop($sError));
		}
	}
	
	
	public function getMyCity()
	{
		//$sInfo = Phpfox::getLib('request')->send('http://smart-ip.net/geoip-json/' . Phpfox::getLib('request')->getIp(), array(), 'GET');
		$sInfo = Phpfox::getLib('request')->send('http://freegeoip.net/json/' . Phpfox::getLib('request')->getIp(), array(), 'GET');
		$oInfo = json_decode($sInfo);
		if ($this->get('section') == 'feed')
		{
			// during testing latlng wont work
			if (empty($oInfo->latitude))
			{
				$oInfo->latitude = '-43.132123';
				$oInfo->longitude = '9.140625';
			}
			$this->call('$Core.Feed.gMyLatLng = new google.maps.LatLng("' . $oInfo->latitude . '","' . $oInfo->longitude .'");');
			$this->call('setCookie("core_places_location", "' . $oInfo->latitude .',' . $oInfo->longitude . '");');
			$this->call('$("#hdn_location_name, #val_location_name").val("' . $oInfo->city . ', ' . $oInfo->country_name . '"); ');
			$this->call('$Core.Feed.getNewLocations();');
			$this->call('$Core.Feed.createMap();');
		}
		
		if ($this->get('saveLocation'))
		{
			Phpfox::getService('user.process')->saveMyLatLng(array('latitude' => $oInfo->latitude, 'longitude' => $oInfo->longitude));
		}
		
		if ($this->get('callback') == '$Core.Feed.showMap')
		{
			/*$this->call('$Core.Feed.showMap();');*/
		}
	}
	
	/* Called from main.js loads the blocks from an ajax call after the controller has loaded */
	public function loadDelayedBlocks()
	{
		// These are blocks intentionally delayed
		$aLocations = explode(',',$this->get('locations'));
		$oModule = Phpfox::getLib('phpfox.module');
		$aParams = $this->get('params');
		define('PHPFOX_LOADING_DELAYED', true);
		if ($this->get('locations') != null && count($aLocations) > 0)
		{	
			$oModule->loadBlocks();
			if ($oModule->getFullControllerName() == 'core.index' && Phpfox::isUser())
			{
				$oModule->setController('core.index-member');
			}
			foreach ($aLocations as $iLocation)
			{
				$aBlocks = $oModule->getModuleBlocks($iLocation, true);
				foreach ($aBlocks as $sBlock)
				{
					Phpfox::getBlock($sBlock);
					$this->html('#delayed_block_' . $iLocation , $this->getContent(false));
				}
			}
		}
		else if ($this->get('loadContent') != null) // Then we are loading the 'content'
		{
			$sController = $this->get('loadContent');
			if (!empty($aParams))
			{
				$oRequest = Phpfox::getLib('request');
				foreach ($aParams as $sIndex => $sKey)
				{
					$oRequest->set($sIndex, $sKey);
				}
			}		
			$oModule->getComponent($sController, $aParams, 'controller');
			
			$this->hide('#delayed_block_image');
			$this->html('#delayed_block', $this->getContent(false) );
			$this->show('#delayed_block');
		}
		else if ($this->get('delayedTemplates') != null)
		{
			
			$aTemplates = $this->get('delayedTemplates');
			
			foreach ($aTemplates as $sIndex => $sKey)
			{
				$aTemplate = explode('=', $sKey);
				$sTemplate = Phpfox::getLib('template')->getBuiltFile($aTemplate[1]);
				$this->html('#' . $aTemplate[1], $sTemplate);
			}
			
		}
		$this->call('$Behavior.loadDelayedBlocks = function(){}; $Core.loadInit();');
	}
	
	/** Called from rewrite.js in the AdminCP -> SEO -> Rewrite URL */
	public function updateRewrites()
	{
		Phpfox::isAdmin(true);
		$aRewrites = json_decode($this->get('aRewrites'), true);
		
		Phpfox::getService('core.redirect.process')->updateRewrites($aRewrites);
		
		if (Phpfox_Error::isPassed())
		{
			$this->call('$Core.AdminCP.Rewrite.saveSuccessful();');
			$this->softNotice('Saved Successfully');
		}
		else
		{
			$this->call('$("#processing").hide();');
		}
		
	}

	public function removeRewrite()
	{
		Phpfox::isAdmin(true);

		Phpfox::getService('core.redirect.process')->removeRewrite($this->get('id'));
	}
}

?>
