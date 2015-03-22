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
 * @package 		Phpfox_Component
 * @version 		$Id: vidly.class.php 4440 2012-07-01 19:31:35Z Raymond_Benc $
 */
class Video_Component_Controller_Vidly extends Phpfox_Component
{
	public function process()
	{
		if ($this->request()->get('vidlypost'))
		{
			/*
			$hFile = fopen(PHPFOX_DIR_FILE . 'log' . PHPFOX_DS . 'vidly.log', 'a+');
			fwrite($hFile, print_r($_REQUEST, true) . "\n");
			fclose($hFile);
			*/
			if ($this->request()->get('vidlypost') == 'AddMedia')
			{
				Phpfox::getService('video.process')->vidlyUpdateNewUrl($this->request()->getInt('vidid'), $_REQUEST);
			}
			exit;
		}
		
		if (!isset($_POST['hash']))
		{
			echo json_encode(array('error' => true, 'error_message' => 'No post hash'));
		}

		if (($iId = Phpfox::getService('video')->checkVidlyHash($_POST['hash'])))
		{	
			if (isset($_POST['cmd']) && $_POST['cmd'] == 'done')
			{
				if (!Phpfox::getService('video.process')->vidlyIsDone())
				{
					echo json_encode(array('error' => true, 'error_message' => implode('', Phpfox_Error::get())));
				}
			}
			echo json_encode(array('passed' => true, 'vidly_id' => $iId));
		}
		else
		{
			echo json_encode(array('error' => true, 'error_message' => implode('', Phpfox_Error::get())));
		}
		exit;
	}
}

?>