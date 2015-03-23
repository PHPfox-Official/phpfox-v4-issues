<?php
// get all settings that are drop-down
$aDrops = $this->_db()->select('setting_id, value_actual')
			->from(Phpfox::getT('setting'))
			->where("type_id = 'drop'")
			->execute('getRows');

// move along all drop down settings
foreach($aDrops as $aDrop)
{
	// unserialize the current value
	$aValue = unserialize($aDrop['value_actual']);
	// move along the new array
	foreach($aValue as $iValKey => $mValue)
	{
		// if the values index contains an array
		if($iValKey == 'values' && is_array($mValue))
		{
			// remove the white spaces for all values in the values index
			foreach($mValue as $iValValKey => $sValValue)
			{
				$aValue[$iValKey][$iValValKey] = trim($sValValue);
			}
		}
		else
		{
			// remove any strange white space in the other indexes
			$aValue[$iValKey] = trim($mValue);
		}
	}
	// seralize it again
	$sUpdate = serialize($aValue);
	// update the database
	$this->_db()->update(Phpfox::getT('setting'), array(
			'value_actual' => $sUpdate
		), 'setting_id = ' . $aDrop['setting_id']
	);
}

$this->_upgradeDatabase('3.7.6rc1');
$bCompleted = true;
?>
