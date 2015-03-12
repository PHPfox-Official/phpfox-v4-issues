<?php
/** $Id: install.xml.php 4955 2012-10-24 12:58:45Z Miguel_Espinoza $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install><![CDATA[		
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
			$this->database()->insert(Phpfox::getT('currency'), $aInsert);
		}		
	
		$aRows = array(
			array(
				'url' => 'user/login',
				'replacement' => 'login'	
			),	
			array(
				'url' => 'user/logout',
				'replacement' => 'logout'
			)			
		);
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('rewrite'), $aInsert);
		}
		$aRows = array(
			array(
				'product_id' => 'phpfox',
				'title' => 'Core',
				'description' => '',
				'version' => '',
				'is_active' => '1',
				'url' => '',
				'url_version_check' => ''		
			),
			array(
				'product_id' => 'phpfox_installer',
				'title' => 'Core Installer',
				'description' => '',
				'version' => '1',
				'is_active' => '1',
				'url' => '',
				'url_version_check' => ''		
			),
			array(
				'product_id' => 'flowplayer',
				'title' => 'Flowplayer',
				'description' => 'Video Player for the Web',
				'version' => '3.1',
				'is_active' => '1',
				'url' => null,
				'url_version_check' => null
			)	
		);
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('product'), $aInsert);
		}		
		
		$aCountryChildren = array (
				  'US' => 
				  array (
				    0 => 'Alabama',
				    1 => 'Alaska',
				    2 => 'American Samoa',
				    3 => 'Arizona',
				    4 => 'Arkansas',
				    5 => 'California',
				    6 => 'Colorado',
				    7 => 'Connecticut',
				    8 => 'Delaware',
				    9 => 'District Of Columbia',
				    10 => 'Federated States Of Micronesia',
				    11 => 'Florida',
				    12 => 'Georgia',
				    13 => 'Guam',
				    14 => 'Hawaii',
				    15 => 'Idaho',
				    16 => 'Illinois',
				    17 => 'Indiana',
				    18 => 'Iowa',
				    19 => 'Kansas',
				    20 => 'Kentucky',
				    21 => 'Louisiana',
				    22 => 'Maine',
				    23 => 'Marshall Islands',
				    24 => 'Maryland',
				    25 => 'Massachusetts',
				    26 => 'Michigan',
				    27 => 'Minnesota',
				    28 => 'Mississippi',
				    29 => 'Missouri',
				    30 => 'Montana',
				    31 => 'Nebraska',
				    32 => 'Nevada',
				    33 => 'New Hampshire',
				    34 => 'New Jersey',
				    35 => 'New Mexico',
				    36 => 'New York',
				    37 => 'North Carolina',
				    38 => 'North Dakota',
				    39 => 'Northern Mariana Islands',
				    40 => 'Ohio',
				    41 => 'Oklahoma',
				    42 => 'Oregon',
				    43 => 'Palau',
				    44 => 'Pennsylvania',
				    45 => 'Puerto Rico',
				    46 => 'Rhode Island',
				    47 => 'South Carolina',
				    48 => 'South Dakota',
				    49 => 'Tennessee',
				    50 => 'Texas',
				    51 => 'Utah',
				    52 => 'Vermont',
				    53 => 'Virgin Islands',
				    54 => 'Virginia',
				    55 => 'Washington',
				    56 => 'West Virginia',
				    57 => 'Wisconsin',
				    58 => 'Wyoming',
				  ),
				  'SE' => 
				  array (
				    0 => 'Blekinge',
				    1 => 'Bohusl&#228;n',
				    2 => 'Dalarna',
				    3 => 'Dalsland',
				    4 => 'Gotland',
				    5 => 'G&#228;strikland',
				    6 => 'Halland',
				    7 => 'H&#228;lsingland',
				    8 => 'H&#228;rjedalen',
				    9 => 'J&#228;mtland',
				    10 => 'Lappland',
				    11 => 'Medelpad',
				    12 => 'Norrbotten',
				    13 => 'N&#228;rke',
				    14 => 'Sk&#229;ne',
				    15 => 'Sm&#229;land',
				    16 => 'S&#246;dermanland',
				    17 => 'Uppland',
				    18 => 'V&#228;rmland',
				    19 => 'V&#228;stmanland',
				    20 => 'V&#228;sterbotten',
				    21 => 'V&#228;sterg&#246;tland',
				    22 => '&#197;ngermanland',
				    23 => '&#214;land',
				    24 => '&#214;sterg&#246;tland',
				  )
		);	
		
		foreach ($aCountryChildren as $sIso => $aChilds)
		{
			foreach ($aChilds as $sChild)
			{
				$this->database()->insert(Phpfox::getT('country_child'), array('country_iso' => $sIso, 'name' => $sChild));
			}
		}

		/* Remove the attribute Unsigned from feed table*/
		$this->database()->query("ALTER TABLE  `" . Phpfox::getParam(array('db','prefix')) . "feed` CHANGE  `feed_reference`  `feed_reference` INT( 10 ) NOT NULL DEFAULT  '0'");
	]]></install>
</phpfox>