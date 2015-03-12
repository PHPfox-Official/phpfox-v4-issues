<?php
	if (Phpfox::getParam('facebook.enable_facebook_connect') && defined('PHPFOX_IS_FB_USER'))
	{
		$aInsert['status_id'] = 0;
		$aInsert['view_id'] = 0;
		$bSkipVerifyEmail = true;
        $iUserIdVerify = $this->database()->select('user_id')
                ->from(Phpfox::getT('user'))
                ->where('status_id = 1 AND email = "' . $aInsert['email'] . '"')
                ->execute('getSlaveField');
        if (!empty($iUserIdVerify) && $iUserIdVerify > 0)
        {
            $this->database()->delete(Phpfox::getT('user'), 'email = "' . $aInsert['email'] . '" AND status_id = 1');
            $this->database()->delete(Phpfox::getT('user_verify'), 'email = "' . $aInsert['email'] .'"');
        }
	}
?>