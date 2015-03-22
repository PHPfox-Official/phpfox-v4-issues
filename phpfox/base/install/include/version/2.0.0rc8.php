<?php

$this->_upgradeDatabase('2.0.0rc8');

$this->_db()->update(Phpfox::getT('video'), array('is_viewed' => '1'), 'video_id > 0');

$bCompleted = true;

?>