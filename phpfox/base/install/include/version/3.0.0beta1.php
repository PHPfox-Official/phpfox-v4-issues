<?php

$hDir = opendir(PHPFOX_DIR . 'module');
while ($sModuleFolder = readdir($hDir))
{
	if ($sModuleFolder == '.' || $sModuleFolder == '..' || $sModuleFolder == '.svn')
	{
		continue;
	}
	
	if (!file_exists(PHPFOX_DIR . 'module' . PHPFOX_DS . $sModuleFolder . PHPFOX_DS . 'install' . PHPFOX_DS . 'version' . PHPFOX_DS . 'v3.phpfox'))
	{
		$this->_db()->update(Phpfox::getT('module'), array('is_active' => '0'), 'module_id = \'' . $this->_db()->escape($sModuleFolder) . '\'');
	}
}

$this->_db()->query('TRUNCATE TABLE ' . Phpfox::getT('theme') . '');
$this->_db()->query('TRUNCATE TABLE ' . Phpfox::getT('theme_style') . '');
$this->_db()->query('TRUNCATE TABLE ' . Phpfox::getT('theme_css') . '');
$this->_db()->query('TRUNCATE TABLE ' . Phpfox::getT('theme_template') . '');
$this->_db()->query('TRUNCATE TABLE ' . Phpfox::getT('user_design_order') . '');
$this->_db()->query('TRUNCATE TABLE ' . Phpfox::getT('user_dashboard') . '');
$this->_db()->query('TRUNCATE TABLE ' . Phpfox::getT('notification') . '');

$this->_db()->update(Phpfox::getT('product'), array('is_active' => '0'), 'product_id NOT IN(\'phpfox\', \'phpfox_installer\')');

$this->_upgradeDatabase('3.0.0beta1');

		$aRows = array(
			array(
				'name' => 'Default',
				'folder' => 'default',
				'created' => '1212226813',
				'is_active' => '1',
				'is_default' => '1',
				'total_column' => '3'
			),
			array(
				'name' => 'Cosmic',
				'folder' => 'cosmic',
				'created' => '1212226813',
				'is_active' => '1',
				'is_default' => '0',
				'total_column' => '3'
			)			
		);
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->_db()->insert(Phpfox::getT('theme'), $aInsert);
		}
		
		$aRows = array(
			array(
				'theme_id' => '1',
				'name' => 'Default',
				'folder' => 'default',
				'created' => '1212227060',
				'is_active' => '1',
				'is_default' => '1',
				'logo_image' => 'logo.png'
			),
			array(
				'theme_id' => '1',
				'name' => 'Facebookish',
				'folder' => 'facebookish',
				'created' => '1212227060',
				'is_active' => '1',
				'is_default' => '0',
				'logo_image' => 'logo.png'
			),
			array(
				'theme_id' => '1',
				'name' => 'Altitude',
				'folder' => 'altitude',
				'created' => '1212227060',
				'is_active' => '1',
				'is_default' => '0',
				'logo_image' => 'logo.png'
			),
			array(
				'theme_id' => '2',
				'name' => 'Cosmic',
				'folder' => 'cosmic',
				'created' => '1212227060',
				'is_active' => '1',
				'is_default' => '0',
				'logo_image' => 'logo.png'
			),
			array(
				'theme_id' => '1',
				'name' => 'Density',
				'folder' => 'density',
				'created' => '1212227060',
				'is_active' => '1',
				'is_default' => '0',
				'logo_image' => 'logo.png'
			)			
		);
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->_db()->insert(Phpfox::getT('theme_style'), $aInsert);
		}

$this->_db()->insert(Phpfox::getT('setting'), array(
		'group_id' => null,
		'module_id' => 'core',
		'product_id' => 'phpfox',
		'is_hidden' => '1',
		'version_id' => '3.0.0beta1',
		'type_id' => 'integer',
		'var_name' => 'v3_legacy_upgrade',
		'phrase_var_name' => 'setting_v3_legacy_upgrade',
		'value_actual' => '1',
		'value_default' => '0',
		'ordering' => '0'
	)
);

$aTitleUpdate = array(
	'poll' => 'question_url',
	'event' => 'title_url',
	'photo' => 'title_url',
	'quiz' => 'title_url',
	'music_song' => 'title_url',
	'music_album' => 'name_url',
	'marketplace' => 'title_url'
);

foreach ($aTitleUpdate as $sTable => $sField)
{
	if ($sTable == 'marketplace' && !Phpfox::isModule('marketplace'))
	{
		continue;		
	}
	
	$this->_db()->query('ALTER TABLE ' . Phpfox::getT($sTable) . '  CHANGE ' . $sField . ' ' . $sField . ' VARCHAR( 255 ) NULL DEFAULT NULL');
}

		$aPageCategories = array (
		  0 => 
		  array (
			'name' => 'Entertainment',
			'categories' => 
			array (
			  0 => 
			  array (
				'name' => 'Album',
				'page_type' => '0',
			  ),
			  1 => 
			  array (
				'name' => 'Amateur Sports Team',
				'page_type' => '0',
			  ),
			  2 => 
			  array (
				'name' => 'Book',
				'page_type' => '0',
			  ),
			  3 => 
			  array (
				'name' => 'Book Store',
				'page_type' => '0',
			  ),
			  4 => 
			  array (
				'name' => 'Concert Tour',
				'page_type' => '0',
			  ),
			  5 => 
			  array (
				'name' => 'Concert Venue',
				'page_type' => '0',
			  ),
			  6 => 
			  array (
				'name' => 'Fictional Character',
				'page_type' => '0',
			  ),
			  7 => 
			  array (
				'name' => 'Library',
				'page_type' => '0',
			  ),
			  8 => 
			  array (
				'name' => 'Magazine',
				'page_type' => '0',
			  ),
			  9 => 
			  array (
				'name' => 'Movie',
				'page_type' => '0',
			  ),
			  10 => 
			  array (
				'name' => 'Movie Theater',
				'page_type' => '0',
			  ),
			  11 => 
			  array (
				'name' => 'Music Award',
				'page_type' => '0',
			  ),
			  12 => 
			  array (
				'name' => 'Music Chart',
				'page_type' => '0',
			  ),
			  13 => 
			  array (
				'name' => 'Music Video',
				'page_type' => '0',
			  ),
			  14 => 
			  array (
				'name' => 'Musical Instrument',
				'page_type' => '0',
			  ),
			  15 => 
			  array (
				'name' => 'Playlist',
				'page_type' => '0',
			  ),
			  16 => 
			  array (
				'name' => 'Professional Sports Team',
				'page_type' => '0',
			  ),
			  17 => 
			  array (
				'name' => 'Radio Station',
				'page_type' => '0',
			  ),
			  18 => 
			  array (
				'name' => 'Record Label',
				'page_type' => '0',
			  ),
			  19 => 
			  array (
				'name' => 'School Sports Team',
				'page_type' => '0',
			  ),
			  20 => 
			  array (
				'name' => 'Song',
				'page_type' => '0',
			  ),
			  21 => 
			  array (
				'name' => 'Sports League',
				'page_type' => '0',
			  ),
			  22 => 
			  array (
				'name' => 'Sports Venue',
				'page_type' => '0',
			  ),
			  23 => 
			  array (
				'name' => 'Studio',
				'page_type' => '0',
			  ),
			  24 => 
			  array (
				'name' => 'TV Channel',
				'page_type' => '0',
			  ),
			  25 => 
			  array (
				'name' => 'TV Network',
				'page_type' => '0',
			  ),
			  26 => 
			  array (
				'name' => 'TV Show',
				'page_type' => '0',
			  ),
			  27 => 
			  array (
				'name' => 'TV/Movie Award',
				'page_type' => '0',
			  ),
			),
		  ),
		  1 => 
		  array (
			'name' => 'Brand or Product',
			'categories' => 
			array (
			  0 => 
			  array (
				'name' => 'Appliances',
				'page_type' => '0',
			  ),
			  1 => 
			  array (
				'name' => 'Baby Goods/Kids Goods',
				'page_type' => '0',
			  ),
			  2 => 
			  array (
				'name' => 'Bags/Luggage',
				'page_type' => '0',
			  ),
			  3 => 
			  array (
				'name' => 'Building Materials',
				'page_type' => '0',
			  ),
			  4 => 
			  array (
				'name' => 'Camera/Photo',
				'page_type' => '0',
			  ),
			  5 => 
			  array (
				'name' => 'Cars',
				'page_type' => '0',
			  ),
			  6 => 
			  array (
				'name' => 'Clothing',
				'page_type' => '0',
			  ),
			  7 => 
			  array (
				'name' => 'Commercial Equipment',
				'page_type' => '0',
			  ),
			  8 => 
			  array (
				'name' => 'Computers',
				'page_type' => '0',
			  ),
			  9 => 
			  array (
				'name' => 'Drugs',
				'page_type' => '0',
			  ),
			  10 => 
			  array (
				'name' => 'Electronics',
				'page_type' => '0',
			  ),
			  11 => 
			  array (
				'name' => 'Food/Beverages',
				'page_type' => '0',
			  ),
			  12 => 
			  array (
				'name' => 'Furniture',
				'page_type' => '0',
			  ),
			  13 => 
			  array (
				'name' => 'Games/Toys',
				'page_type' => '0',
			  ),
			  14 => 
			  array (
				'name' => 'Health/Beauty',
				'page_type' => '0',
			  ),
			  15 => 
			  array (
				'name' => 'Home Decor',
				'page_type' => '0',
			  ),
			  16 => 
			  array (
				'name' => 'Household Supplies',
				'page_type' => '0',
			  ),
			  17 => 
			  array (
				'name' => 'Jewelry/Watches',
				'page_type' => '0',
			  ),
			  18 => 
			  array (
				'name' => 'Kitchen/Cooking',
				'page_type' => '0',
			  ),
			  19 => 
			  array (
				'name' => 'Movies/Music',
				'page_type' => '0',
			  ),
			  20 => 
			  array (
				'name' => 'Musical Instrument',
				'page_type' => '0',
			  ),
			  21 => 
			  array (
				'name' => 'Office Supplies',
				'page_type' => '0',
			  ),
			  22 => 
			  array (
				'name' => 'Outdoor Gear/Sporting Goods',
				'page_type' => '0',
			  ),
			  23 => 
			  array (
				'name' => 'Patio/Garden',
				'page_type' => '0',
			  ),
			  24 => 
			  array (
				'name' => 'Pet Supplies',
				'page_type' => '0',
			  ),
			  25 => 
			  array (
				'name' => 'Product/Service',
				'page_type' => '0',
			  ),
			  26 => 
			  array (
				'name' => 'Software',
				'page_type' => '0',
			  ),
			  27 => 
			  array (
				'name' => 'Tools/Equipment',
				'page_type' => '0',
			  ),
			  28 => 
			  array (
				'name' => 'Vitamins/Supplements',
				'page_type' => '0',
			  ),
			  29 => 
			  array (
				'name' => 'Website',
				'page_type' => '0',
			  ),
			  30 => 
			  array (
				'name' => 'Wine/Spirits',
				'page_type' => '0',
			  ),
			),
		  ),
		  2 => 
		  array (
			'name' => 'Group or Community',
			'categories' => 
			array (
			  0 => 
			  array (
				'name' => 'Business',
				'page_type' => '1',
			  ),
			  1 => 
			  array (
				'name' => 'Common Interest',
				'page_type' => '1',
			  ),
			  2 => 
			  array (
				'name' => 'Entertainment & Arts ',
				'page_type' => '1',
			  ),
			  3 => 
			  array (
				'name' => 'Geography',
				'page_type' => '1',
			  ),
			  4 => 
			  array (
				'name' => 'Internet & Technology',
				'page_type' => '1',
			  ),
			  5 => 
			  array (
				'name' => 'Just for Fun',
				'page_type' => '1',
			  ),
			  6 => 
			  array (
				'name' => 'Music',
				'page_type' => '1',
			  ),
			  7 => 
			  array (
				'name' => 'Organisations',
				'page_type' => '1',
			  ),
			  8 => 
			  array (
				'name' => 'Sports & Recreation',
				'page_type' => '1',
			  ),
			  9 => 
			  array (
				'name' => 'Student Groups',
				'page_type' => '1',
			  ),
			),
		  ),
		  3 => 
		  array (
			'name' => 'Local Business or Place',
			'categories' => 
			array (
			  0 => 
			  array (
				'name' => 'Airport',
				'page_type' => '0',
			  ),
			  1 => 
			  array (
				'name' => 'Arts/Entertainment/Nightlife',
				'page_type' => '0',
			  ),
			  2 => 
			  array (
				'name' => 'Attractions/Things to Do',
				'page_type' => '0',
			  ),
			  3 => 
			  array (
				'name' => 'Automotive',
				'page_type' => '0',
			  ),
			  4 => 
			  array (
				'name' => 'Bank/Financial Services',
				'page_type' => '0',
			  ),
			  5 => 
			  array (
				'name' => 'Bar',
				'page_type' => '0',
			  ),
			  6 => 
			  array (
				'name' => 'Book Store',
				'page_type' => '0',
			  ),
			  7 => 
			  array (
				'name' => 'Business Services',
				'page_type' => '0',
			  ),
			  8 => 
			  array (
				'name' => 'Church/Religious Organization',
				'page_type' => '0',
			  ),
			  9 => 
			  array (
				'name' => 'Club',
				'page_type' => '0',
			  ),
			  10 => 
			  array (
				'name' => 'Community/Government',
				'page_type' => '0',
			  ),
			  11 => 
			  array (
				'name' => 'Concert Venue',
				'page_type' => '0',
			  ),
			  12 => 
			  array (
				'name' => 'Education',
				'page_type' => '0',
			  ),
			  13 => 
			  array (
				'name' => 'Event Planning/Event Services',
				'page_type' => '0',
			  ),
			  14 => 
			  array (
				'name' => 'Food/Grocery',
				'page_type' => '0',
			  ),
			  15 => 
			  array (
				'name' => 'Health/Medical/Pharmacy',
				'page_type' => '0',
			  ),
			  16 => 
			  array (
				'name' => 'Home Improvement',
				'page_type' => '0',
			  ),
			  17 => 
			  array (
				'name' => 'Hospital/Clinic',
				'page_type' => '0',
			  ),
			  18 => 
			  array (
				'name' => 'Hotel',
				'page_type' => '0',
			  ),
			  19 => 
			  array (
				'name' => 'Landmark',
				'page_type' => '0',
			  ),
			  20 => 
			  array (
				'name' => 'Library',
				'page_type' => '0',
			  ),
			  21 => 
			  array (
				'name' => 'Local Business',
				'page_type' => '0',
			  ),
			  22 => 
			  array (
				'name' => 'Movie Theater',
				'page_type' => '0',
			  ),
			  23 => 
			  array (
				'name' => 'Museum/Art Gallery',
				'page_type' => '0',
			  ),
			  24 => 
			  array (
				'name' => 'Pet Services',
				'page_type' => '0',
			  ),
			  25 => 
			  array (
				'name' => 'Professional Services',
				'page_type' => '0',
			  ),
			  26 => 
			  array (
				'name' => 'Public Places',
				'page_type' => '0',
			  ),
			  27 => 
			  array (
				'name' => 'Real Estate',
				'page_type' => '0',
			  ),
			  28 => 
			  array (
				'name' => 'Restaurant/Cafe',
				'page_type' => '0',
			  ),
			  29 => 
			  array (
				'name' => 'School',
				'page_type' => '0',
			  ),
			  30 => 
			  array (
				'name' => 'Shopping/Retail',
				'page_type' => '0',
			  ),
			  31 => 
			  array (
				'name' => 'Spas/Beauty/Personal Care',
				'page_type' => '0',
			  ),
			  32 => 
			  array (
				'name' => 'Sports Venue',
				'page_type' => '0',
			  ),
			  33 => 
			  array (
				'name' => 'Sports/Recreation/Activities',
				'page_type' => '0',
			  ),
			  34 => 
			  array (
				'name' => 'Tours/Sightseeing',
				'page_type' => '0',
			  ),
			  35 => 
			  array (
				'name' => 'Transit Stop',
				'page_type' => '0',
			  ),
			  36 => 
			  array (
				'name' => 'Transportation',
				'page_type' => '0',
			  ),
			  37 => 
			  array (
				'name' => 'University',
				'page_type' => '0',
			  ),
			),
		  ),
		  4 => 
		  array (
			'name' => 'Company, Organization, or Institution',
			'categories' => 
			array (
			  0 => 
			  array (
				'name' => 'Aerospace/Defense',
				'page_type' => '0',
			  ),
			  1 => 
			  array (
				'name' => 'Automobiles and Parts',
				'page_type' => '0',
			  ),
			  2 => 
			  array (
				'name' => 'Bank/Financial Institution',
				'page_type' => '0',
			  ),
			  3 => 
			  array (
				'name' => 'Biotechnology',
				'page_type' => '0',
			  ),
			  4 => 
			  array (
				'name' => 'Cause',
				'page_type' => '0',
			  ),
			  5 => 
			  array (
				'name' => 'Chemicals',
				'page_type' => '0',
			  ),
			  6 => 
			  array (
				'name' => 'Church/Religious Organization',
				'page_type' => '0',
			  ),
			  7 => 
			  array (
				'name' => 'Community Organization',
				'page_type' => '0',
			  ),
			  8 => 
			  array (
				'name' => 'Company',
				'page_type' => '0',
			  ),
			  9 => 
			  array (
				'name' => 'Computers/Technology',
				'page_type' => '0',
			  ),
			  10 => 
			  array (
				'name' => 'Consulting/Business Services',
				'page_type' => '0',
			  ),
			  11 => 
			  array (
				'name' => 'Education',
				'page_type' => '0',
			  ),
			  12 => 
			  array (
				'name' => 'Energy/Utility',
				'page_type' => '0',
			  ),
			  13 => 
			  array (
				'name' => 'Engineering/Construction',
				'page_type' => '0',
			  ),
			  14 => 
			  array (
				'name' => 'Farming/Agriculture',
				'page_type' => '0',
			  ),
			  15 => 
			  array (
				'name' => 'Food/Beverages',
				'page_type' => '0',
			  ),
			  16 => 
			  array (
				'name' => 'Government Organization',
				'page_type' => '0',
			  ),
			  17 => 
			  array (
				'name' => 'Health/Beauty',
				'page_type' => '0',
			  ),
			  18 => 
			  array (
				'name' => 'Health/Medical/Pharmaceuticals',
				'page_type' => '0',
			  ),
			  19 => 
			  array (
				'name' => 'Industrials',
				'page_type' => '0',
			  ),
			  20 => 
			  array (
				'name' => 'Insurance Company',
				'page_type' => '0',
			  ),
			  21 => 
			  array (
				'name' => 'Internet/Software',
				'page_type' => '0',
			  ),
			  22 => 
			  array (
				'name' => 'Legal/Law',
				'page_type' => '0',
			  ),
			  23 => 
			  array (
				'name' => 'Media/News/Publishing',
				'page_type' => '0',
			  ),
			  24 => 
			  array (
				'name' => 'Mining/Materials',
				'page_type' => '0',
			  ),
			  25 => 
			  array (
				'name' => 'Non-Governmental Organization (NGO)',
				'page_type' => '0',
			  ),
			  26 => 
			  array (
				'name' => 'Non-Profit Organization',
				'page_type' => '0',
			  ),
			  27 => 
			  array (
				'name' => 'Organization',
				'page_type' => '0',
			  ),
			  28 => 
			  array (
				'name' => 'Political Organization',
				'page_type' => '0',
			  ),
			  29 => 
			  array (
				'name' => 'Political Party',
				'page_type' => '0',
			  ),
			  30 => 
			  array (
				'name' => 'Retail and Consumer Merchandise',
				'page_type' => '0',
			  ),
			  31 => 
			  array (
				'name' => 'School',
				'page_type' => '0',
			  ),
			  32 => 
			  array (
				'name' => 'Small Business',
				'page_type' => '0',
			  ),
			  33 => 
			  array (
				'name' => 'Telecommunication',
				'page_type' => '0',
			  ),
			  34 => 
			  array (
				'name' => 'Transport/Freight',
				'page_type' => '0',
			  ),
			  35 => 
			  array (
				'name' => 'Travel/Leisure',
				'page_type' => '0',
			  ),
			  36 => 
			  array (
				'name' => 'University',
				'page_type' => '0',
			  ),
			),
		  ),
		  5 => 
		  array (
			'name' => 'Artist, Band or Public Figure',
			'categories' => 
			array (
			  0 => 
			  array (
				'name' => 'Actor/Director',
				'page_type' => '0',
			  ),
			  1 => 
			  array (
				'name' => 'Artist',
				'page_type' => '0',
			  ),
			  2 => 
			  array (
				'name' => 'Athlete',
				'page_type' => '0',
			  ),
			  3 => 
			  array (
				'name' => 'Author',
				'page_type' => '0',
			  ),
			  4 => 
			  array (
				'name' => 'Business Person',
				'page_type' => '0',
			  ),
			  5 => 
			  array (
				'name' => 'Chef',
				'page_type' => '0',
			  ),
			  6 => 
			  array (
				'name' => 'Coach',
				'page_type' => '0',
			  ),
			  7 => 
			  array (
				'name' => 'Comedian',
				'page_type' => '0',
			  ),
			  8 => 
			  array (
				'name' => 'Dancer',
				'page_type' => '0',
			  ),
			  9 => 
			  array (
				'name' => 'Doctor',
				'page_type' => '0',
			  ),
			  10 => 
			  array (
				'name' => 'Editor',
				'page_type' => '0',
			  ),
			  11 => 
			  array (
				'name' => 'Entertainer',
				'page_type' => '0',
			  ),
			  12 => 
			  array (
				'name' => 'Fictional Character',
				'page_type' => '0',
			  ),
			  13 => 
			  array (
				'name' => 'Government Official',
				'page_type' => '0',
			  ),
			  14 => 
			  array (
				'name' => 'Journalist',
				'page_type' => '0',
			  ),
			  15 => 
			  array (
				'name' => 'Lawyer',
				'page_type' => '0',
			  ),
			  16 => 
			  array (
				'name' => 'Monarch',
				'page_type' => '0',
			  ),
			  17 => 
			  array (
				'name' => 'Musician/Band',
				'page_type' => '0',
			  ),
			  18 => 
			  array (
				'name' => 'News Personality',
				'page_type' => '0',
			  ),
			  19 => 
			  array (
				'name' => 'Politician',
				'page_type' => '0',
			  ),
			  20 => 
			  array (
				'name' => 'Producer',
				'page_type' => '0',
			  ),
			  21 => 
			  array (
				'name' => 'Public Figure',
				'page_type' => '0',
			  ),
			  22 => 
			  array (
				'name' => 'Teacher',
				'page_type' => '0',
			  ),
			  23 => 
			  array (
				'name' => 'Writer',
				'page_type' => '0',
			  ),
			),
		  ),
		);
		
		$iCnt = 0;
		foreach ($aPageCategories as $aCategory)
		{
			$iCnt++;
			$iInsertId = $this->_db()->insert(Phpfox::getT('pages_type'), array(
					'is_active' => '1',
					'name' => $aCategory['name'],
					'time_stamp' => PHPFOX_TIME,
					'ordering' => $iCnt
				)
			);
			
			$iSubCnt = 0;
			foreach ($aCategory['categories'] as $aSub)
			{
				$iSubCnt++;
				$this->_db()->insert(Phpfox::getT('pages_category'), array(
						'type_id' => $iInsertId,
						'is_active' => '1',
						'name' => $aSub['name'],
						'page_type' => $aSub['page_type'],
						'ordering' => $iSubCnt
					)
				);
			}			
		}
	
		$aAppCategories = array(
			'Just for Fun',			
			'Gaming',
			'Sports',
			'Utility',
			'Education',
			'Dating',
			'Messaging',
			'Chat',
			'Music',
			'Events',
			'Alerts',
			'Photo',
			'Business',
			'Video',
			'Politics',
			'Fashion',
			'Food and Drink',
			'Travel',
			'Money',
			'Mobile',
			'Classified',
			'File Sharing'
		);		
		sort($aAppCategories);
		$iCategoryOrder = 0;
		foreach ($aAppCategories as $sCategory)
		{
			$iCategoryOrder++;
			$this->_db()->insert(Phpfox::getT('app_category'), array(					
					'name' => $sCategory					
				)
			);
		}		

// Make all custom fields belong to "custom"		
$this->_db()->update(Phpfox::getT('custom_field'), array('module_id' => 'custom'), 'module_id != "custom"');
$bCompleted = true;

?>