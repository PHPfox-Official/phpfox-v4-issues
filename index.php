<?php

if (version_compare(phpversion(), '5.4', '<') === true) {
	exit('PHPfox 4 requires PHP 5.4 or newer.');
}


require('./PF.Base/start.php');
