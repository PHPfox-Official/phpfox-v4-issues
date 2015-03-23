<?php

// Get the phrases (they may have more than one language)
$aPhrases = $this->_db()
	->select('*')
	->from(Phpfox::getT('language_phrase'))
	->where('var_name = "full_name_liked_a_comment_you_made_on_the_page_title"')
	->execute('getSlaveRows');
	
foreach ($aPhrases as $aPhrase)
{
	$this->_db()->update(Phpfox::getT('language_phrase'), array(
		'text_default' => str_replace('"{title"}', '{title}"', $aPhrase['text_default']),
		'text' => str_replace('"{title"}', '{title}"', $aPhrase['text']),
		), 'phrase_id = ' . $aPhrase['phrase_id']);
}

$this->_upgradeDatabase('3.6.0beta2');
$bCompleted = true;

?>