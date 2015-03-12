<?php
if (Phpfox::getParam('janrain.enable_janrain_login'))
{
	$this->database()->select('janrain.user_id as janrain_user_id, ')
		->leftJoin(Phpfox::getT('janrain'), 'janrain', 'janrain.user_id = u.user_id');
}
?>