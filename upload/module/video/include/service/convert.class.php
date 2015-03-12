<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

##
# Usage: */1 * * * * /usr/bin/php /module/video/include/cron/convert.php
##

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox_Service
 * @version 		$Id: service.class.php 67 2009-01-20 11:32:45Z Raymond_Benc $
 */
class Video_Service_Convert extends Phpfox_Service 
{
	private $_sFfmpeg = 'ffmpeg';
	
	private $_sMencoder = 'mencoder';

	private $_sFlvtool2 = 'flvtool2';

	private $_sLastLineCode = '';
	
	private $_aVideoDetails = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('video');
		
		$this->_sFfmpeg = Phpfox::getParam('video.ffmpeg_path');
		$this->_sMencoder = Phpfox::getParam('video.mencoder_path');
		$this->_sFlvtool2 = Phpfox::getParam('video.flvtool2_path');
	}
	
	public function process($iId = null, $bIsAttachment = false)
	{
		$aCondition = array();
		if ($iId !== null)
		{
			$aCondition[] = 'video_id = ' . (int) $iId . ' AND ';
		}
		$aCondition[] = 'in_process = 1';
		if ($iId !== null)
		{
			$aCondition[] = 'AND user_id = ' . Phpfox::getUserId() . '';
		}
		
		if ($bIsAttachment)
		{
			$aVideos = $this->database()->select('attachment_id AS video_id, user_id, server_id, destination, extension AS file_ext')
				->from(Phpfox::getT('attachment'))
				->where('attachment_id = ' . (int) $iId)
				->limit(1)
				->execute('getSlaveRows');					
		}
		else 
		{
			$aVideos = $this->database()->select('*')
				->from($this->_sTable)
				->where($aCondition)
				->limit(1)
				->execute('getSlaveRows');		
		}
				
		if (!count($aVideos))
		{
			$this->_debug(Phpfox::getPhrase('video.nothing_to_convert'));

			exit;
		}		
			
		$this->_debug(Phpfox::getPhrase('video.started_converting_process'));
		
		if ($sPlugin = Phpfox_Plugin::get('video.service_convert_process_1')){eval($sPlugin);}
		
		if (defined('PHPFOX_CLI'))
		{
			touch(PHPFOX_DIR_CACHE . 'video.lock');
		}
		
		if (!$bIsAttachment)
		{
			foreach ($aVideos as $aVideo)
			{
				// 'Converting (store in cache): ' . $aVideo['video_id']
				$this->_debug(Phpfox::getPhrase('video.converting_store_in_cache_video_id'), array('video_id' => $aVideo['video_id']));
				
				$this->database()->update($this->_sTable, array('in_process' => '2'), 'video_id = ' . $aVideo['video_id']);
				
				$this->_debug(Phpfox::getPhrase('video.updated_process_id'));
			}
		}
		
		foreach ($aVideos as $aVideo)
		{
			if (Phpfox::getParam('video.close_sql_connection_while_converting'))
			{
				$this->database()->close();
			}
			
			if (Phpfox::getParam('core.allow_cdn') == true)
			{ // Fixes 
				Phpfox::getLib('cdn')->setServerId($aVideo['server_id']);
			}
			
			// 'Start converting process: ' . $aVideo['video_id']
			$this->_debug(Phpfox::getPhrase('video.start_converting_process_video_id', array('video_id' => $aVideo['video_id'])));
			
			$sNewPath = substr_replace(sprintf($aVideo['destination'], ''), '', -(strlen($aVideo['file_ext']) + 1)) . '.flv';
			$sSource = Phpfox::getParam(($bIsAttachment ? 'core.dir_attachment' : 'video.dir')) . sprintf($aVideo['destination'], '');
			if (Phpfox::getParam(array('balancer', 'enabled')) && !file_exists($sSource))
			{
				preg_match('/(.*)\/(.*)_(.*?)/i', $sSource, $aLbMatches);
				if (isset($aLbMatches[2]))
				{
					$aServers = Phpfox::getParam(array('balancer', 'servers'));
					foreach ($aServers as $iIp => $aServer)
					{
						if ($aServer['id'] == $aLbMatches[2])
						{
							$sSource = str_replace(PHPFOX_DIR, $aServer['url'], $sSource);
							
							break;
						}				
					}	
				}	
			}					
			
			$sDestination = Phpfox::getParam(($bIsAttachment ? 'core.dir_attachment' : 'video.dir')) . $sNewPath;
			if ($bIsAttachment)
			{
				$sImageLocation = Phpfox::getParam('core.dir_attachment') . substr_replace($sNewPath, '%s.jpg', -4);	
			}
			else 
			{
				$sImageLocation = Phpfox::getLib('file')->getBuiltDir(Phpfox::getParam(($bIsAttachment ? 'core.dir_attachment' :'video.dir_image'))) . md5($aVideo['video_id']) . '%s.jpg';	
			}

			if (file_exists($sDestination) && $aVideo['file_ext'] != 'flv')
			{
				// 'File exists: ' . $sDestination
				$this->_debug(Phpfox::getPhrase('video.file_exists_sdestination'), array('sDestination' => $sDestination));
				
				continue;
			}
			
			$iWidth = 620;
			$iHeight = 386;		

			// 'Converting: ' . $sSource
			$this->_debug(Phpfox::getPhrase('video.converting_ssource', array('sSource' => $sSource)));
			$aFind = array(
					'{source}',
					'{destination}',
					'{width}',
					'{height}'
			);
			$aReplace = array(
					$sSource,
					$sDestination,
					$iWidth,
					$iHeight
			);
			
			$sFfmpegParams = str_replace($aFind, $aReplace, Phpfox::getParam('video.params_for_ffmpeg'));

			if (Phpfox::getParam('video.upload_for_html5'))
			{
				$aHTML5Files = array(
						str_replace('.flv', '.mp4', $sDestination),
						str_replace('.flv', '.webm', $sDestination),
						str_replace('.flv', '.ogg', $sDestination)
						);
				
				foreach (Phpfox::getParam('video.covert_mp4_exec') as $sExecCode)
				{
					if (!file_exists(str_replace('.flv', '.mp4', $sDestination)))
					{
						$this->_exec(str_replace(array('{SOURCE}', '{DESTINATION}'), array($sSource, str_replace('.flv', '.mp4', $sDestination)), $sExecCode));
					}	
				}
				
				foreach (Phpfox::getParam('video.covert_webm_exec') as $sExecCode)
				{
					if (!file_exists(str_replace('.flv', '.webm', $sDestination)))
					{
						$this->_exec(str_replace(array('{SOURCE}', '{DESTINATION}'), array($sSource, str_replace('.flv', '.webm', $sDestination)), $sExecCode));
					}
				}	

				foreach (Phpfox::getParam('video.covert_ogg_exec') as $sExecCode)
				{
					if (!file_exists(str_replace('.flv', '.ogg', $sDestination)))
					{
						$this->_exec(str_replace(array('{SOURCE}', '{DESTINATION}'), array($sSource, str_replace('.flv', '.ogg', $sDestination)), $sExecCode));
					}
				}

				foreach (Phpfox::getParam('video.covert_mp4_image') as $sExecCode)
				{
					if (!file_exists(sprintf($sImageLocation, '')))
					{
						$this->_exec(str_replace(array('{SOURCE}', '{DESTINATION}'), array(str_replace('.flv', '.mp4', $sDestination), sprintf($sImageLocation, '')), $sExecCode));
					}
				}
				
				$sDestination = str_replace('.flv', '.mp4', $sDestination);
			}
			else
			{
				if ($aVideo['file_ext'] != 'flv')			
				{				
					$this->_exec($this->_sFfmpeg . ' ' . $sFfmpegParams);
								
					if (!$this->_check($sDestination))
					{				
						if (file_exists($sDestination))
						{
							Phpfox::getLib('file')->unlink($sDestination);
						}
						$sMencoderParams = str_replace($aFind, $aReplace, Phpfox::getParam('video.params_for_mencoder'));
						$this->_exec($this->_sMencoder . ' ' . $sMencoderParams);
					}
					
					if (!$this->_check($sDestination))
					{
						if (file_exists($sDestination))
						{
							Phpfox::getLib('file')->unlink($sDestination);
						}				
						
						$this->_exec($this->_sMencoder . ' ' . str_replace($aFind, $aReplace, Phpfox::getParam('video.params_for_mencoder_fallback')));
					}				
				}
				
				if (!($bReturn = $this->_check($sDestination)))
				{
					// 'Can\'t convert: ' . $sSource
					$this->_debug(Phpfox::getPhrase('video.cant_convert_ssource', array('sSource' => $sSource)));
						
					return $bReturn;
				}	
						
				if (Phpfox::getParam('video.enable_flvtool2'))
				{
						$this->_exec($this->_sFlvtool2 . ' ' . str_replace($aFind, $aReplace, Phpfox::getParam('video.params_for_flvtool2')));
				}
			}
				
			// 'Converting completed: ' . $sDestination
			$this->_debug(Phpfox::getPhrase('video.converting_completed_sdestination', array('sDestination' => $sDestination)));
			
			if ($bIsAttachment)
			{
				$aSql = array();				
			}
			else
			{
				$aSql  = array(
					'view_id' => (($aVideo['module_id'] == 'video' && Phpfox::getUserParam('video.approve_video_before_display')) ? 2 : 0),
					'in_process' => 0,
					'destination' => $sNewPath,				
					'image_path' => str_replace(Phpfox::getParam('video.dir_image'), '', $sImageLocation),
					'image_server_id' => Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID')
				);
			}
				
			// Temp. disable error reporting
			Phpfox_Error::skip(true);	
			
			require_once(PHPFOX_DIR_LIB . 'getid3' . PHPFOX_DS . 'getid3' . PHPFOX_DS . 'getid3.php');
				
			$oGetId3 = new getID3;
				
			$aMetaData = $oGetId3->analyze($sDestination);
			
			if (isset($aMetaData['playtime_string']))
			{
				$aSql['duration'] = $aMetaData['playtime_string'];
			}	
				
			if (isset($aMetaData['video']['resolution_x']))
			{
				$aSql['resolution_x'] = $aMetaData['video']['resolution_x'];
			}
				
			if (isset($aMetaData['video']['resolution_y']))
			{
				$aSql['resolution_y'] = $aMetaData['video']['resolution_y'];
			}			
			
			// Return back error reporting
			Phpfox_Error::skip(false);									
				
			$this->_debug(Phpfox::getPhrase('video.updated_database_video_table'));
				
			if (Phpfox::getParam('video.close_sql_connection_while_converting'))
			{
				$this->database()->connect(Phpfox::getParam(array('db', 'host')), Phpfox::getParam(array('db', 'user')), Phpfox::getParam(array('db', 'pass')), Phpfox::getParam(array('db', 'name')));
			}
				
			if (!$bIsAttachment)
			{
				// Update user space usage
				Phpfox::getService('user.space')->update($aVideo['user_id'], 'video', filesize($sDestination));	
				
				$this->_debug(Phpfox::getPhrase('video.updated_user_points'));
			}
			
			if(Phpfox::getParam('video.upload_for_html5'))
			{
				if (!in_array($aVideo['file_ext'], array('mp4', 'webm', 'ogg')) && substr($sSource, 0, 4) != 'http')			
				{
					Phpfox::getLib('file')->unlink($sSource);
				
					$this->_debug(Phpfox::getPhrase('video.removed_source_file'));
				}
			}
			else
			{
				if ($aVideo['file_ext'] != 'flv' && substr($sSource, 0, 4) != 'http')			
				{
					Phpfox::getLib('file')->unlink($sSource);
				
					$this->_debug(Phpfox::getPhrase('video.removed_source_file'));
				}
			}			
  		
			if (Phpfox::getParam('video.upload_for_html5'))
			{
				
			}
			else
			{
				if (!file_exists(sprintf($sImageLocation, '')))
				{
					$this->_exec($this->_sFfmpeg . ' -y -i ' . $sDestination . ' -t 00:00:01 -r 1 -f mjpeg ' . sprintf($sImageLocation, ''));	
				}			
	    			
	    		if (!file_exists(sprintf($sImageLocation, '')))
	    		{
	    			$this->_exec($this->_sFfmpeg . ' -y -i ' . $sDestination . ' -t 00:00:01 -r 1 -f image2 ' . sprintf($sImageLocation, ''));
	    		}
	
				if (class_exists('ffmpeg_movie') && !file_exists(sprintf($sImageLocation, '')))
				{
					$oFfmpegMovie = new ffmpeg_movie($sDestination);
					if (is_object($oFfmpegMovie) && method_exists($oFfmpegMovie, 'getFrame'))
					{
						$oFrame = $oFfmpegMovie->getFrame(10);
						if (is_object($oFrame) && method_exists($oFrame, 'toGDImage'))
						{
							$mImage = $oFrame->toGDImage();			
							if ($mImage)
							{
								@imagejpeg($mImage, sprintf($sImageLocation, ''), 120);
								@imagedestroy($mImage);
							}
						}
					}
				}
			}    		   		

			// 'Completed Image: ' . sprintf($sImageLocation, '')
    		$this->_debug(Phpfox::getPhrase('video.completed_image_simagelocation',array('sImageLocation' => sprintf($sImageLocation, ''))));

    		// Phpfox::getLib('image')->createThumbnail($sImageLocation, Phpfox::getLib('file')->getBuiltDir(Phpfox::getParam('video.dir_image')) . md5($aVideo['video_id']) . '.jpg', 400, 400);
    		
    		Phpfox::getLib('image')->createThumbnail(sprintf($sImageLocation, ''), sprintf($sImageLocation, '_120'), 120, 120);
			Phpfox::getLib('image')->createThumbnail(sprintf($sImageLocation, ''), sprintf($sImageLocation, '_12090'), 120, 90, false);
			// http://www.phpfox.com/tracker/view/14924/
			Phpfox::getLib('image')->createThumbnail(sprintf($sImageLocation, ''), sprintf($sImageLocation, '_200'), 200, 200, false);
    		
    		Phpfox::getLib('file')->unlink(sprintf($sImageLocation, ''));    		    		

			// 'Completed: ' . $sDestination
			$this->_debug(Phpfox::getPhrase('video.completed_sdestination', array('sDestination' => $sDestination)));
			
			if (Phpfox::getParam('core.allow_cdn'))
			{
				$aSql['image_server_id'] = Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID');
				if (Phpfox::getParam('video.upload_for_html5'))
				{
					foreach ($aHTML5Files as $sHTML5File)
					{
						Phpfox::getLib('cdn')->put($sHTML5File);
					}
				}
				else
				{
					Phpfox::getLib('cdn')->put($sDestination);
				}
				
				$aSql['server_id'] = Phpfox::getLib('request')->getServer('PHPFOX_SERVER_ID');
			}			
			
			if ($bIsAttachment)
			{
				$this->_aVideoDetails = array(
					'video_id' => $aVideo['video_id'],
					'destination' => $sNewPath,
					'extension' => 'flv',
					'duration' => (isset($aSql['duration']) ? $aSql['duration'] : null)				
				);			
			}
			else
			{
				$this->database()->update($this->_sTable, $aSql, 'video_id = ' . $aVideo['video_id']);
				
				if ($aVideo['module_id'] != 'video' && Phpfox::hasCallback($aVideo['module_id'], 'uploadVideo'))
				{
					$aCallback = Phpfox::callback($aVideo['module_id'] . '.uploadVideo', $aVideo['item_id']);		
				}							
				
				$bUpdatePoints = ($aVideo['module_id'] == 'video' ? (Phpfox::getUserParam('video.approve_video_before_display') ? false : true) : true);
				
				if ($bUpdatePoints === true)
				{
					$aCallback = null;
					if ($aVideo['module_id'] != 'video' && Phpfox::hasCallback($aVideo['module_id'], 'convertVideo'))
					{
						$aCallback = Phpfox::callback($aVideo['module_id'] . '.convertVideo', $aVideo);	
					}					
				
					(Phpfox::isModule('feed') ? Phpfox::getService('feed.process')->callback($aCallback)->add('video', $aVideo['video_id'], $aVideo['privacy'], $aVideo['privacy_comment'], $aVideo['item_id']) : null);
					
					// Update user activity
					Phpfox::getService('user.activity')->update(Phpfox::getUserId(), 'video');
				}			
			}
		}
		
		if (defined('PHPFOX_CLI'))
		{
			unlink(PHPFOX_DIR_CACHE . 'video.lock');
		}
		if (!Phpfox_Error::isPassed())
		{
			return false;
		}
		return true;
	}
	
	public function getDetails()
	{
		return $this->_aVideoDetails;
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
		if ($sPlugin = Phpfox_Plugin::get('video.service_convert__call'))
		{
			return eval($sPlugin);
		}
			
		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}	
	
	private function _exec($sCmd)
	{
		$this->_debug($sCmd);
		
		$this->_sLastLineCode = exec($sCmd . ' 2>&1', $aOutput);		
		
		if (defined('PHPFOX_CLI'))
		{
			echo implode("\n", $aOutput);
		}
		
		$this->_debug(implode("\n", $aOutput));
		
		return $this;
	}
	
	private function _debug($sMessage)
	{
		if (defined('PHPFOX_CLI'))
		{
			echo $sMessage . "\n";
		}		
		
		// if (PHPFOX_DEBUG)
		{
			$sCacheName = PHPFOX_DIR . 'file' . PHPFOX_DS . 'log' . PHPFOX_DS . 'phpfox_video_log_' . date('d_m_y', time()) . '.log.php';				
			
			if ($hFile = @fopen($sCacheName, 'a'))
			{			
				$sData = "#### " . microtime() . " ####\n";
				$sData .= "[" . Phpfox::getLib('file')->filesize(memory_get_usage()) . "]" . "{$sMessage}\n";
				$sData .= "####\n";
	
				fwrite($hFile, $sData);
				fclose($hFile);		
			}	
		}
	}
	
	private function _check($sDestination)
	{
		if (!file_exists($sDestination))
		{
			$this->_debug(Phpfox::getPhrase('video.unable_to_convert_video'));
				
			if (!empty($this->_sLastLineCode))
			{
				Phpfox_Error::set($this->_sLastLineCode);
			}				
							
			return Phpfox_Error::set(Phpfox::getPhrase('video.unable_to_convert_video'));
		}		
			
		// Temp. disable error reporting
		Phpfox_Error::skip(true);	
			
		require_once(PHPFOX_DIR_LIB . 'getid3' . PHPFOX_DS . 'getid3' . PHPFOX_DS . 'getid3.php');
			
		$oGetId3 = new getID3;
			
		$aMetaData = $oGetId3->analyze($sDestination);	
		
		// Return back error reporting
		Phpfox_Error::skip(false);			
			
		if (isset($aMetaData['error']) && count($aMetaData['error']))
		{			
			if (!empty($this->_sLastLineCode))
			{
				Phpfox_Error::set($this->_sLastLineCode);
			}
				
			return Phpfox_Error::set(implode('<br />', array_map('ucfirst', $aMetaData['error'])));
		}		
			
		return true;
	}
}

?>
