<?php

$this->_upgradeDatabase('3.0.0beta3');

// update the `phpfox_custom_relation`.`confirmation` field
$aRelations = array(
    array('phrase_var_name' => 'custom.custom_relation_blank', 'confirmation' => 0),
    array('phrase_var_name' => 'custom.custom_relation_single', 'confirmation' => 0),
    array('phrase_var_name' => 'custom.custom_relation_engaged', 'confirmation' => 1),
    array('phrase_var_name' => 'custom.custom_relation_married', 'confirmation' => 1),
    array('phrase_var_name' => 'custom.custom_relation_it_s_complicated', 'confirmation' => 0),
    array('phrase_var_name' => 'custom.custom_relation_in_an_open_relationship', 'confirmation' => 1),
    array('phrase_var_name' => 'custom.custom_relation_widowed', 'confirmation' => 0),
    array('phrase_var_name' => 'custom.custom_relation_separated', 'confirmation' => 0),
    array('phrase_var_name' => 'custom.custom_relation_divorced', 'confirmation' => 0),
    array('phrase_var_name' => 'custom.custom_relation_in_a_relationship', 'confirmation' => 1)
);

$iTotalRelations = (int) $this->_db()->select('COUNT(*)')
	->from(Phpfox::getT('custom_relation'))
	->execute('getSlaveField');
	
foreach ($aRelations as $aRelation)
{
	if ($iTotalRelations > 0)
	{
		$this->_db()->update(Phpfox::getT('custom_relation'), array('confirmation' => $aRelation['confirmation']), 'phrase_var_name = "' . $aRelation['phrase_var_name'] . '"');
	}
	else
	{
		$this->_db()->insert(Phpfox::getT('custom_relation'), array('phrase_var_name' => $aRelation['phrase_var_name'], 'confirmation' => $aRelation['confirmation']));
	}
	
}
Phpfox::getService('custom.callback')->updateCounter('import-custom-fields');
$bCompleted = true;

?>