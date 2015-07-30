<?php

$out = [];
try {
	if (!file_exists(__DIR__ . '/../file/settings/license.sett.php')) {
		throw new Exception('PHPfox does not seem to be installed.');
	}
	require(__DIR__ . '/../file/settings/license.sett.php');

	if (!file_exists(__DIR__ . '/../file/settings/version.sett.php')) {
		throw new Exception('PHPfox is missing version ID');
	}
	$version = require(__DIR__ . '/../file/settings/version.sett.php');

	if (empty($_REQUEST['license_id']) || empty($_REQUEST['license_key'])) {
		throw new Exception('Missing License ID/Key');
	}

	if ($_REQUEST['license_id'] != PHPFOX_LICENSE_ID) {
		throw new Exception('License ID does not match.');
	}

	if ($_REQUEST['license_key'] != PHPFOX_LICENSE_KEY) {
		throw new Exception('License Key does not match.');
	}

	$out = $version;
} catch (Exception $e) {
	$out = ['error' => $e->getMessage()];
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($out, JSON_PRETTY_PRINT);