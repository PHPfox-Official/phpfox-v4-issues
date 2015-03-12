<?php

$this->_db()->delete(Phpfox::getT('site_stat'), 'module_id = \'user\' AND stat_link = \'user.browse\'');

$this->_upgradeDatabase('2.0.5dev1');

		$aRows = array(
			array(
				'currency_id' => 'USD',
				'symbol' => '&#36;'	,
				'phrase_var' => 'core.u_s_dollars',
				'ordering' => '1',
				'is_default' => '1',
				'is_active' => '1'
			),	
			array(
				'currency_id' => 'EUR',
				'symbol' => '&#8364;'	,
				'phrase_var' => 'core.euros',
				'ordering' => '2',
				'is_default' => '0',
				'is_active' => '1'
			),
			array(
				'currency_id' => 'GBP',
				'symbol' => '&#163;',
				'phrase_var' => 'core.pounds_sterling',
				'ordering' => '3',
				'is_default' => '0',
				'is_active' => '1'
			)
		);	
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$sField = $this->_db()->select('currency_id')
					->from(Phpfox::getT('currency'))
					->where('currency_id = "' . $aInsert['currency_id'].'"')
					->execute('getSlaveField');
			if ($sField != '')
			{
				continue;
			}
			$this->_db()->insert(Phpfox::getT('currency'), $aInsert);
		}	
	
$bCompleted = true;

?>