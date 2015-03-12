<?php

$this->_upgradeDatabase('3.5.0beta1');

$this->_db()->query('ALTER TABLE  `' . Phpfox::getT('upload_track') . '` CHANGE  `user_id`  `user_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL');
if (!$this->_db()->isField(Phpfox::getT('upload_track'), 'time_stamp'))
{
	$this->_db()->query('ALTER TABLE  `' . Phpfox::getT('upload_track') . '` ADD  `time_stamp` INT UNSIGNED NULL DEFAULT NULL');
}

if (Phpfox::isModule('marketplace') && !$this->_db()->isField(Phpfox::getT('marketplace'), 'is_notified'))
{
	$this->_db()->query('ALTER TABLE  `' . Phpfox::getT('marketplace') . '` ADD  `is_notified` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT \'0\'');
}

if (!$this->_db()->isField(Phpfox::getT('blog'), 'module_id'))
{
	$this->_db()->query('ALTER TABLE  `' . Phpfox::getT('blog') . '` ADD  `module_id` VARCHAR( 75 ) NOT NULL DEFAULT \'blog\'');
}

if (!$this->_db()->isField(Phpfox::getT('blog'), 'item_id'))
{
	$this->_db()->query('ALTER TABLE  `' . Phpfox::getT('blog') . '` ADD  `item_id` INT( 10 ) NOT NULL DEFAULT \'0\'');
}

/* Location for pages */
if (!$this->_db()->isField(Phpfox::getT('pages'), 'location_latitude'))
{
	$this->_db()->query('ALTER TABLE  `' . Phpfox::getT('pages') . '` ADD  `location_latitude` DECIMAL( 30,27 ) NULL DEFAULT NULL');
}
if (!$this->_db()->isField(Phpfox::getT('pages'), 'location_longitude'))
{
	$this->_db()->query('ALTER TABLE  `' . Phpfox::getT('pages') . '` ADD  `location_longitude` DECIMAL( 30,27 ) NULL DEFAULT NULL');
}
if (!$this->_db()->isField(Phpfox::getT('pages'), 'location_name'))
{
	$this->_db()->query('ALTER TABLE  `' . Phpfox::getT('pages') . '` ADD  `location_name` VARCHAR( 255 ) NULL DEFAULT NULL');
}

/* Location for users */
if (!$this->_db()->isField(Phpfox::getT('user_field'), 'location_latlng'))
{
	$this->_db()->query('ALTER TABLE  `' . Phpfox::getT('pages') . '` ADD  `location_latlng` VARCHAR( 100 ) NULL DEFAULT NULL');
}

/* Dislike */
if (!$this->_db()->isField(Phpfox::getT('comment'), 'total_dislike'))
{
	$this->_db()->query('ALTER TABLE  `' . Phpfox::getT('comment') . '` ADD  `total_dislike` INT( 10 ) NOT NULL DEFAULT \'0\'');
}

if (!$this->_db()->isField(Phpfox::getT('pages'), 'use_timeline'))
{
	$this->_db()->query('ALTER TABLE  `' . Phpfox::getT('pages') . '` ADD  `use_timeline` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT \'0\'');
}

$this->_db()->update(Phpfox::getT('module'), array('is_active' => '0'), 'module_id = \'microblog\'');

$bCompleted = true;

?>