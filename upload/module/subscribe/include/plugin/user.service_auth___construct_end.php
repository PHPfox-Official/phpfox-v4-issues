<?php
if (isset($this->_aUser['user_id']) && $this->_aUser['user_id'] > 0 && Phpfox::getParam('subscribe.subscribe_is_required_on_sign_up') && $this->_aUser['user_group_id'] == '2' && $this->_aUser['subscribe_id'] > 0)
{
	$bSetDirect = true;	
	$bSetDirect = (((Phpfox::getLib('request')->get('req1') == 'subscribe' && Phpfox::getLib('request')->get('req2') == 'register')) || ((Phpfox::getLib('request')->get('req1') == 'user' && Phpfox::getLib('request')->get('req2') == 'logout'))) ? false : true;	

	if ($bSetDirect === true)			
	{
		Phpfox::getService('subscribe.purchase')->setRedirectId($this->_aUser['subscribe_id']);
	}
}
?>