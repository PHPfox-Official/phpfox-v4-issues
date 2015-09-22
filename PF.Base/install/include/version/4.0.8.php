<?php

return function(Phpfox_Installer $Installer) {
	$Installer->db->query('ALTER TABLE ' . Phpfox::getT('user') . ' CHANGE password password CHAR(150) NULL DEFAULT NULL');
};