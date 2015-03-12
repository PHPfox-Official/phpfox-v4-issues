<?php
/** $Id: install.xml.php 788 2009-07-21 14:06:02Z Miguel_Espinoza $ **/
defined('PHPFOX') or exit('NO DICE!');
?>
<phpfox>
	<install>
		$aRows = array(
			array(
				'title' => 'Smile',
				'text' => ':)',
				'image' => 'smile.png',
				'ordering' => '1',
				'package_path' => 'default'
			),	
			array(
				'title' => 'Evilgrin',
				'text' => '>;->',
				'image' => 'evilgrin.png',
				'ordering' => '2',
				'package_path' => 'default'
			),
			array(
				'title' => 'Happy',
				'text' => ':-)',
				'image' => 'happy.png',
				'ordering' => '3',
				'package_path' => 'default'
			),
			array(
				'title' => 'Wink',
				'text' => ';)',
				'image' => 'wink.png',
				'ordering' => '4',
				'package_path' => 'default'
			),
			array(
				'title' => 'Tongue',
				'text' => ':P',
				'image' => 'tongue.png',
				'ordering' => '5',
				'package_path' => 'default'
			),
			array(
				'title' => 'Unhappy',
				'text' => ':(',
				'image' => 'unhappy.png',
				'ordering' => '6',
				'package_path' => 'default'
			),
			array(
				'title' => 'Surprised',
				'text' => '=:o',
				'image' => 'surprised.png',
				'ordering' => '7',
				'package_path' => 'default'
			),
			array(
				'title' => 'Grin',
				'text' => ':>',
				'image' => 'grin.png',
				'ordering' => '8',
				'package_path' => 'default'
			)			
		);
		foreach ($aRows as $aRow)
		{
			$aInsert = array();
			foreach ($aRow as $sKey => $sValue)
			{
				$aInsert[$sKey] = $sValue;
			}
			$this->database()->insert(Phpfox::getT('emoticon'), $aInsert);

		}
					$aPackage = array(
				'package_path' => 'default',
				'product_id' => 'phpfox',
				'package_name' => 'default',
				'is_active' => 1
			);
			$this->database()->insert(Phpfox::getT('emoticon_package'), $aPackage);
	</install>
</phpfox>