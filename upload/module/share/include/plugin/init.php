<?php
if (isset($_REQUEST['share-connect']))
{
	Phpfox::getComponent('share.connect', array(), 'controller');	
	exit;
}
?>