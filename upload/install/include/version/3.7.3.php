<?php

/* Update phrase */
$aPhrase = $this->_db()
	->update(Phpfox::getT('language_phrase'),
	array(
		'text' => '<title>Display User Online Status</title><info>This produces an "is Online" message when the avatar is hovered over.</info>',
		'text_default' => '<title>Display User Online Status</title><info>This produces an "is Online" message when the avatar is hovered over.</info>'
	), 'var_name = "setting_display_user_online_status" AND (language_id = "en" OR language_id = "EN" OR language_id = "En")');

$this->_upgradeDatabase('3.7.3');
$bCompleted = true;

?>