<?php
/** $Id: install.xml.php 2536 2011-04-14 19:37:29Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
		$aRelations = array(
			1 => array('phrase_var_name' => 'custom.custom_relation_blank', 'confirmation' => 0),
			2 => array('phrase_var_name' => 'custom.custom_relation_single', 'confirmation' => 0),
			3 => array('phrase_var_name' => 'custom.custom_relation_engaged', 'confirmation' => 1),
			4 => array('phrase_var_name' => 'custom.custom_relation_married', 'confirmation' => 1),
			5 => array('phrase_var_name' => 'custom.custom_relation_it_s_complicated', 'confirmation' => 0),
			6 => array('phrase_var_name' => 'custom.custom_relation_in_an_open_relationship', 'confirmation' => 1),
			7 => array('phrase_var_name' => 'custom.custom_relation_widowed', 'confirmation' => 0),
			8 => array('phrase_var_name' => 'custom.custom_relation_separated', 'confirmation' => 0),
			9 => array('phrase_var_name' => 'custom.custom_relation_divorced', 'confirmation' => 0),
			10 => array('phrase_var_name' => 'custom.custom_relation_in_a_relationship', 'confirmation' => 1),
		);
		foreach ($aRelations as $iId => $aRelation)
		{
			$this->database()->insert(Phpfox::getT('custom_relation'), array(
					'relation_id' => $iId,
					'phrase_var_name' => $aRelation['phrase_var_name'],
					'confirmation' => $aRelation['confirmation']
				)
			);
		}
	</install>
</phpfox>