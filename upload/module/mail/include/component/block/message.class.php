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
 * @version 		$Id: folder.class.php 225 2009-02-13 13:24:59Z Raymond_Benc $
 */
class Mail_Component_Block_Message extends Phpfox_Component
{
    /**
     * Class process method wnich is used to execute this component.
     */
    public function process()
    {
		$iId = $this->request()->get('id');

		$aMessage = Phpfox::getService('mail')->getMail($iId);

		if (!Phpfox::getParam('mail.threaded_mail_conversation'))
		{
			// calculate the "best" dimensions possible:
			//die(d($aMessage, true));
			if (strpos($aMessage['text'], '<br />') !== false)
			{
				$iWidth = ((strlen($aMessage['text']) / substr_count($aMessage['text'], '<br />')) * 9) > 800 ? 800 : ((strlen($aMessage['text']) / substr_count($aMessage['text'], '<br />')) * 9);
				$iHeight = ((strlen($aMessage['text']) / substr_count($aMessage['text'], '<br />')) * 5) > 600 ? 600 : ((strlen($aMessage['text']) / substr_count($aMessage['text'], '<br />')) * 5);

			}
			else
			{
				// guess...
				$iWidth = strlen($aMessage['text']) * 8 > 600 ? 600 : (strlen($aMessage['text']) * 4 < 300 ? 300 : strlen($aMessage['text']) * 4);
				$iHeight = $iWidth;
			}
		}

		//)), Phpfox::getPhrase('mail.read_private_message'), $iWidth, $iHeight);

		$this->template()->assign(array(	    
				'aMessage' => $aMessage
			)
		);

		return 'block';
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