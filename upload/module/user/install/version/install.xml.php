<?php
/** $Id: install.xml.php 858 2009-08-13 01:12:17Z Raymond_Benc $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
		$aRows = array(
			array(
				'user_group_id' => '1',
				'title' => 'Administrator',
				'is_special' => '1'
			),
			array(
				'user_group_id' => '2',
				'title' => 'Registered User',
				'is_special' => '1'
			),
			array(
				'user_group_id' => '3',
				'title' => 'Guest',
				'is_special' => '1'
			),
			array(
				'user_group_id' => '4',
				'title' => 'Staff',
				'is_special' => '1'
			)
		);
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('user_group'), $aInsert);
		}		
		
		$iUserGroupId = Phpfox::getService('user.group.process')->add(array(
				'title' => 'Banned',
				'inherit_id' => 2
			)
		);	
		
		$this->database()->update(Phpfox::getT('setting'), array('value_actual' => $iUserGroupId), 'module_id = \'core\' AND var_name = \'banned_user_group_id\'');
		$this->database()->update(Phpfox::getT('user_group_custom'), array('default_value' => '1'), 'user_group_id = ' . (int) $iUserGroupId . ' AND module_id = \'core\' AND name = \'user_is_banned\'');			
	</install>
</phpfox>