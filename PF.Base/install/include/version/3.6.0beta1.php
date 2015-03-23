<?php

/** Add an index to the event_category */
$this->_db()->addIndex(Phpfox::getT('feed'), 'user_id, feed_reference, time_stamp');

$this->_upgradeDatabase('3.6.0beta1');


$bCompleted = true;
?>