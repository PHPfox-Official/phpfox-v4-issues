<?php
// get the settings we need to make hidden
$aSettings = array(
	'enable_mass_uploader',
	'music_enable_mass_uploader',
	'video_enable_mass_uploader',
);

foreach($aSettings as $sSetting)
{
	// update the database
	$this->_db()->update(Phpfox::getT('setting'), array(
			'is_hidden' => 1,
			'value_actual' => 0
		), "var_name = '" . $sSetting . "'"
	);
}

$this->_upgradeDatabase('3.7.7');
$bCompleted = true;
?>
